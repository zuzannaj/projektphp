<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConnectionRepository")
 * @ORM\Table(name="connections")
 */
class Connection
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $departure_time;

    /**
     * @ORM\Column(type="time")
     */
    private $arrival_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $free_seats;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stop")
     */
    private $first_stop_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stop")
     */
    private $last_stop_id;

    public function __construct()
    {
        $this->first_stop_id = new ArrayCollection();
        $this->last_stop_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departure_time;
    }

    public function setDepartureTime(\DateTimeInterface $departure_time): self
    {
        $this->departure_time = $departure_time;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeInterface
    {
        return $this->arrival_time;
    }

    public function setArrivalTime(\DateTimeInterface $arrival_time): self
    {
        $this->arrival_time = $arrival_time;

        return $this;
    }

    public function getFreeSeats(): ?int
    {
        return $this->free_seats;
    }

    public function setFreeSeats(int $free_seats): self
    {
        $this->free_seats = $free_seats;

        return $this;
    }

    /**
     * @return Collection|Stop[]
     */
    public function getFirstStopId(): Collection
    {
        return $this->first_stop_id;
    }

    public function addFirstStopId(Stop $firstStopId): self
    {
        if (!$this->first_stop_id->contains($firstStopId)) {
            $this->first_stop_id[] = $firstStopId;
        }

        return $this;
    }

    public function removeFirstStopId(Stop $firstStopId): self
    {
        if ($this->first_stop_id->contains($firstStopId)) {
            $this->first_stop_id->removeElement($firstStopId);
        }

        return $this;
    }

    /**
     * @return Collection|Stop[]
     */
    public function getLastStopId(): Collection
    {
        return $this->last_stop_id;
    }

    public function addLastStopId(Stop $lastStopId): self
    {
        if (!$this->last_stop_id->contains($lastStopId)) {
            $this->last_stop_id[] = $lastStopId;
        }

        return $this;
    }

    public function removeLastStopId(Stop $lastStopId): self
    {
        if ($this->last_stop_id->contains($lastStopId)) {
            $this->last_stop_id->removeElement($lastStopId);
        }

        return $this;
    }
}
