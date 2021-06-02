<?php

namespace App\Event;

use App\Entity\Device;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The networkscan.begin event is dispatched when a scan is initiated
 * in the system.
 */
class NetworkScanBeginEvent extends Event
{
    public const NAME = 'networkscan.begin';

    protected $devices;

    public function __construct()
    {
        $this->devices = [];
    }

    public function getDevices(): Array
    {
        return $this->devices;
    }

    public function addDevice(Device $device) 
    {
        $this->devices[] = $device;
    }
}