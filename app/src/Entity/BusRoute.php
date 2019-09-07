<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="BusRouteRepository")
 * @ORM\Table(name="bus_routes")
 */
class BusRoute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="1",
     *     max="3",
     * )
     */
    public $stop_order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BusLine")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bus_line;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stop")
     * @ORM\JoinColumn(nullable=false)
     */
    public $stop;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getStopOrder(): ?int
    {
        return $this->stop_order;
    }

    /**
     * @param int $stop_order
     * @return BusRoute
     */
    public function setStopOrder(int $stop_order): self
    {
        $this->stop_order = $stop_order;

        return $this;
    }

    /**
     * @return BusLine|null
     */
    public function getBusLine(): ?BusLine
    {
        return $this->bus_line;
    }

    /**
     * @param BusLine|null $bus_line
     * @return BusRoute
     */
    public function setBusLine(?BusLine $bus_line): self
    {
        $this->bus_line = $bus_line;

        return $this;
    }

    /**
     * @return Stop|null
     */
    public function getStop(): ?Stop
    {
        return $this->stop;
    }

    /**
     * @param Stop|null $stop
     * @return BusRoute
     */
    public function setStop(?Stop $stop): self
    {
        $this->stop = $stop;

        return $this;
    }

    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     *
     * @constant int NUMBER_OF_ITEMS
     */
    const NUMBER_OF_ITEMS = 10;

    /**
     * @return string
     */
    public function __toString(): string
    {
        // to show the name of the Category in the select
        return $this->id;
    }
}
