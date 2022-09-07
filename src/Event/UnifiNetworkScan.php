<?php

namespace App\Event;

use App\Entity\Device;
use App\Event\NetworkScanBeginEvent;
use App\Service\UnifiService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UnifiNetworkScan implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            NetworkScanBeginEvent::NAME => 'onNetworkScanBegin',
        ];
    }

    private UnifiService $unifiService;

    public function __construct(UnifiService $unifiService)
    {
        $this->unifiService = $unifiService;
    }

    public function onNetworkScanBegin(NetworkScanBeginEvent $event)
    {
        $activeClients = $this->unifiService->getActiveClients();

        foreach ($activeClients as $result) {
            $ip = null;
            if (array_key_exists('ip', $result)) {
                $ip = $result['ip'];
            } else if (array_key_exists('fixed_ip', $result)) {
                $ip = $result['fixed_ip'];
            }
            if (!$ip) {
                echo 'Result missing IP: ';
                var_dump($result);
                continue;
            }
                
            $newDevice = new Device();
            $newDevice
                ->setIdentifiedBy('unifi')
                ->setMac($result['mac'])
                ->setLastIP($ip)
                ->setVendor($result['oui'])
                ->setIsGuest($result['is_guest'])
                ->setSatisfaction($result['satisfaction']);
            
            if (array_key_exists('network', $result)) {
                $newDevice->setNetworkString($result['network']);
            }

            if (array_key_exists('hostname', $result)) {
                $newDevice->setHostname($result['hostname']);
            }
            if (array_key_exists('name', $result)) {
                $newDevice->setName($result['name']);
            }

            $newDevice->setIsWired($result['is_wired']);
            if ($result['is_wired']) {
                $newDevice->setPort($result['sw_port']);
            } else {
                $newDevice->setPort(null);
                $newDevice->setSignal($result['signal']);
            }

            $firstSeen = new \DateTime();
            $firstSeen->setTimestamp($result['first_seen']);
            $newDevice->setFirstConnection($firstSeen);

            $lastSeen = new \DateTime();
            $lastSeen->setTimestamp($result['last_seen']);
            $newDevice->setLastConnection($lastSeen);

            $event->addDevice($newDevice);
        }
    }
}
