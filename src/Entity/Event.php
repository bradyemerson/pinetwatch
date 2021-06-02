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
     * @ORM\Column(type="array")
     */
    private $type = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $additionalInfo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iSNew;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isNew;

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

    public function getType(): ?array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

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

    public function getISNew(): ?string
    {
        return $this->iSNew;
    }

    public function setISNew(string $iSNew): self
    {
        $this->iSNew = $iSNew;

        return $this;
    }
}
