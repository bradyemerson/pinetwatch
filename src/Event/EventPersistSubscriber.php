<?php

namespace App\Event;

use App\Entity\Device;
use App\Entity\Event;
use App\Event\DeviceNewEvent;
use App\Event\DeviceDownEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventPersistSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            DeviceNewEvent::NAME => 'onDeviceNewEvent',
            DeviceDownEvent::NAME => 'onDeviceDownEvent'
        ];
    }

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onDeviceNewEvent(DeviceNewEvent $event)
    {
        $persistEvent = new Event();
        $persistEvent->setEventType($event::NAME);
        $persistEvent->setDevice($event->getDevice());
        $persistEvent->setIsPendingEmail(true);
        $persistEvent->setDateTime(new \DateTime());
        $this->entityManager->persist($persistEvent);
    }

    public function onDeviceDownEvent(DeviceDownEvent $event)
    {
        $persistEvent = new Event();
        $persistEvent->setEventType($event::NAME);
        $persistEvent->setDevice($event->getDevice());
        $persistEvent->setIsPendingEmail(true);
        $persistEvent->setDateTime(new \DateTime());
        $this->entityManager->persist($persistEvent);
    }
}
