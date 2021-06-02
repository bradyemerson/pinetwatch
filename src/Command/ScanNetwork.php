<?php
namespace App\Command;

use App\Event\ArpNetworkScan;
use App\Event\NetworkScanBeginEvent;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ScanNetwork extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:scan-network';

    private $entityManager;
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher, DeviceRepository $deviceRepository, EntityManagerInterface $entityManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->deviceRepository = $deviceRepository;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Scans network to update current devices.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('')
            ->addOption('no-notifications', 's', InputOption::VALUE_NONE, 'Supress Notifications')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $scan = new NetworkScanBeginEvent();
        $this->eventDispatcher->dispatch($scan, NetworkScanBeginEvent::NAME);

        // Combine common macs
        $devices = $scan->getDevices();
        $seenMacs = [];
        foreach($devices as $key => $device) {
            if (array_key_exists($device->getMac(), $seenMacs)) {
                if ($device->getIdentifiedBy() === 'unifi') {
                    unset($devices[$seenMacs[$device->getMac()]]);
                    $seenMacs[$device->getMac()] = $key;
                } else {
                    unset($devices[$key]);
                }
            } else {
                $seenMacs[$device->getMac()] = $key;
            }
        }

        foreach($devices as $device) {
            $remoteDevice = $this->deviceRepository->findOneByMac($device->getMac());
            if (!$remoteDevice) {
                $this->entityManager->persist($device);
            }
        }
        $this->entityManager->flush();

        // print_r($scan);

        // Deduplicate

        echo 'done';
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }
}