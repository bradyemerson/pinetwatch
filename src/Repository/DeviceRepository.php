<?php

namespace App\Repository;

use App\Entity\Device;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Device|null find($id, $lockMode = null, $lockVersion = null)
 * @method Device|null findOneBy(array $criteria, array $orderBy = null)
 * @method Device[]    findAll()
 * @method Device[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    // /**
    //  * @return Device[] Returns an array of Device objects
    //  */

    public function findAlertDeviceDown($macs)
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->andWhere('d.alertDeviceDown = true')
        ;
        if ($macs) {
            $queryBuilder
                ->andWhere('d.mac NOT IN (:macs)')
                ->setParameter('macs', '\'' . implode('\',\'', $macs) . '\'')
            ;
        }
        return $queryBuilder->getQuery()->getResult();
    }

    public function findOneByMac($value): ?Device
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.mac = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function merge(Device $a, Device $b) {
        if ($b->getLastIP()) {
            $a->setLastIP($b->getLastIP());
        }
        if ($b->getVendor()) {
            $a->setVendor($b->getVendor());
        }
        if ($b->getLastConnection()) {
            $a->setLastConnection($b->getLastConnection());
        }
        if ($b->getIsWired() !== null) {
            $a->setIsWired($b->getIsWired());
        }
        if ($b->getSignal()) {
            $a->setSignal($b->getSignal());
        }
        if ($b->getPort()) {
            $a->setPort($b->getPort());
        }
        if ($b->getSatisfaction()) {
            $a->setSatisfaction($b->getSatisfaction());
        }
        if ($b->getIsGuest() !== null) {
            $a->setIsGuest($b->getIsGuest());
        }
    }
}
