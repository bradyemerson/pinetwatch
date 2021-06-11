<?php

namespace App\Event;

use App\Entity\Device;
use App\Entity\Event;
use App\Event\DeviceNewEvent;
use App\Event\DeviceDownEvent;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventNotifierSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            DeviceNewEvent::NAME => 'onDeviceNewEvent',
            DeviceDownEvent::NAME => 'onDeviceDownEvent'
        ];
    }

    private NotifierInterface $notifierInterface;

    public function __construct(NotifierInterface $notifierInterface)
    {
        $this->notifierInterface = $notifierInterface;
    }

    public function onDeviceNewEvent(DeviceNewEvent $event)
    {
        $device = $event->getDevice();
        $subject = sprintf('New Device Alert: %s (%s)', $device->getName(), $device->getLastIP());
        $content = $subject;
        $notification = (new Notification($subject))
            ->content($content)
            ->importance(Notification::IMPORTANCE_HIGH);

        $this->notifierInterface->send($notification);
    }

    public function onDeviceDownEvent(DeviceDownEvent $event)
    {
        $device = $event->getDevice();
        $subject = sprintf('Device Down Alert: %s (%s)', $device->getName(), $device->getLastIP());
        $content = $subject;
        $notification = (new Notification($subject))
            ->content($content)
            ->importance(Notification::IMPORTANCE_HIGH);

        $this->notifierInterface->send($notification);
    }
}
