<?php

namespace App\Event;

use App\Entity\Device;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The public.ip.change event is dispatched when the internet IP changes
 */
class PublicIpChangeEvent extends Event
{
    public const NAME = 'public.ip.change';

    protected $newIpAddress;

    public function __construct($newIpAddress)
    {
        $this->newIpAddress = $newIpAddress;
    }

    public function getNewIpAddress(): String
    {
        return $this->newIpAddress;
    }
}