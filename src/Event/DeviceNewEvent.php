<?php

namespace App\Event;

use App\Entity\Device;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The device.new event is dispatched when a new Device joins the network
 */
class DeviceNewEvent extends Event
{
    public const NAME = 'device.new';

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