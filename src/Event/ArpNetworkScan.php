<?php

namespace App\Event;

use App\Entity\Device;
use App\Event\NetworkScanBeginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArpNetworkScan implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            NetworkScanBeginEvent::NAME => 'onNetworkScanBegin',
        ];
    }

    public function onNetworkScanBegin(NetworkScanBeginEvent $event)
    {

        $re = '/(?P<ip>((2[0-5]|1[0-9]|[0-9])?[0-9]\.){3}((2[0-5]|1[0-9]|[0-9])?[0-9]))\s*(?P<mac>([0-9a-fA-F]{2}[:-]){5}([0-9a-fA-F]{2}))\s*(?P<hw>.*)/m';
        $str = '192.168.1.1     b4:fb:e4:28:de:39       Ubiquiti Networks Inc.
        192.168.1.2     04:d4:c4:39:07:53       (Unknown)
        192.168.1.112   f0:9f:c2:76:8e:bd       Ubiquiti Networks Inc.
        192.168.1.113   f0:9f:c2:a6:ba:02       Ubiquiti Networks Inc.
        192.168.1.123   e0:63:da:21:40:e5       (Unknown)
        192.168.1.129   44:d9:e7:06:55:c5       Ubiquiti Networks Inc.
        192.168.1.130   f0:9f:c2:a6:ba:63       Ubiquiti Networks Inc.
        192.168.1.145   00:02:99:09:fe:66       Apex, Inc.';

        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        foreach ($matches as $match) {
            $newDevice = new Device();
            $newDevice
                ->setIdentifiedBy('arp')
                ->setMac($match['mac'])
                ->setLastIP($match['ip']);

            $hardware = trim($match['hw']);
            if ($hardware !== '(Unknown)') {
                $newDevice->setVendor($hardware);
            }

            $firstSeen = new \DateTime();
            $newDevice->setFirstConnection($firstSeen);

            $lastSeen = new \DateTime();
            $newDevice->setLastConnection($lastSeen);

            $event->addDevice($newDevice);
        }
    }
}
