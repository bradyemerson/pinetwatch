<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Device::class, inversedBy="events")
     */
    private $device;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $dateTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $additionalInfo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventType;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPendingEmail = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getIsPendingEmail(): ?bool
    {
        return $this->isPendingEmail;
    }

    public function setIsPendingEmail(bool $isPendingEmail): self
    {
        $this->isPendingEmail = $isPendingEmail;

        return $this;
    }
}
