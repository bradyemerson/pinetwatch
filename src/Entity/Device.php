<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
 */
class Device
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hostname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vendor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFavorite = false;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $firstConnection;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $lastConnection;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastIP;

    /**
     * @ORM\Column(type="boolean")
     */
    private $alertDeviceDown = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isGuest = false;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="device")
     */
    private $events;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isNewDevice = true;

    /**
     * @ORM\ManyToOne(targetEntity=Network::class, inversedBy="devices")
     */
    private $network;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isWired;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $port;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $satisfaction;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $signal;

    private $networkString;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifiedBy;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMac(): ?string
    {
        return $this->mac;
    }

    public function setMac(string $mac): self
    {
        $this->mac = strtolower($mac);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name ? $this->name : $this->hostname;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getHostname(): ?string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): self
    {
        $this->hostname = $hostname;

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

    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    public function setVendor(?string $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    public function getFirstConnection(): ?\DateTimeInterface
    {
        return $this->firstConnection;
    }

    public function setFirstConnection(\DateTimeInterface $firstConnection): self
    {
        $this->firstConnection = $firstConnection;

        return $this;
    }

    public function getLastConnection(): ?\DateTimeInterface
    {
        return $this->lastConnection;
    }

    public function setLastConnection(\DateTimeInterface $lastConnection): self
    {
        $this->lastConnection = $lastConnection;

        return $this;
    }

    public function getLastIP(): ?string
    {
        return $this->lastIP;
    }

    public function setLastIP(string $lastIP): self
    {
        $this->lastIP = $lastIP;

        return $this;
    }

    public function getAlertDeviceDown(): ?bool
    {
        return $this->alertDeviceDown;
    }

    public function setAlertDeviceDown(bool $alertDeviceDown): self
    {
        $this->alertDeviceDown = $alertDeviceDown;

        return $this;
    }

    public function getIsGuest(): ?bool
    {
        return $this->isGuest;
    }

    public function setIsGuest(bool $isGuest): self
    {
        $this->isGuest = $isGuest;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setDevice($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getDevice() === $this) {
                $event->setDevice(null);
            }
        }

        return $this;
    }

    public function getIsNewDevice(): ?bool
    {
        return $this->isNewDevice;
    }

    public function setIsNewDevice(bool $isNewDevice): self
    {
        $this->isNewDevice = $isNewDevice;

        return $this;
    }

    public function getNetwork(): ?Network
    {
        return $this->network;
    }

    public function setNetwork(?Network $network): self
    {
        $this->network = $network;

        return $this;
    }

    public function getNetworkString() : ?string
    {
        return $this->networkString;
    }

    public function setNetworkString(?string $networkString)
    {
        $this->networkString = $networkString;

        return $this;
    }

    public function getIsWired(): ?bool
    {
        return $this->isWired;
    }

    public function setIsWired(?bool $isWired): self
    {
        $this->isWired = $isWired;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(?int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getSatisfaction(): ?int
    {
        return $this->satisfaction;
    }

    public function setSatisfaction(?int $satisfaction): self
    {
        $this->satisfaction = $satisfaction;

        return $this;
    }

    public function getSignal(): ?int
    {
        return $this->signal;
    }

    public function setSignal(?int $signal): self
    {
        $this->signal = $signal;

        return $this;
    }

    public function getIdentifiedBy(): ?string
    {
        return $this->identifiedBy;
    }

    public function setIdentifiedBy(string $identifiedBy): self
    {
        $this->identifiedBy = $identifiedBy;

        return $this;
    }
}
