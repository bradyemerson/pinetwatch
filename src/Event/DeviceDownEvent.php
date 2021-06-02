<?php

namespace App\Event;

use App\Entity\Device;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The device.down event is dispatched when an exepcted Device is off the network
 */
class DeviceDownEvent extends Event
{
    public const NAME = 'device.down';

    private Device $device;

    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    public function getDevice() : Device
    {
        return $this->device;
    }
}