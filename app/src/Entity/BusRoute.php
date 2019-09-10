<?php
/**
 * Bus route entity.
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BusRouteRepository")
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
    public $stopOrder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BusLine")
     * @ORM\JoinColumn(nullable=false)
     */
    public $busLine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stop", cascade={"remove"}))
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
        return $this->stopOrder;
    }

    /**
     * @param int $stopOrder
     *
     * @return BusRoute
     */
    public function setStopOrder(int $stopOrder): self
    {
        $this->stopOrder = $stopOrder;

        return $this;
    }

    /**
     * @return BusLine|null
     */
    public function getBusLine(): ?BusLine
    {
        return $this->busLine;
    }

    /**
     * @param BusLine|null $busLine
     *
     * @return BusRoute
     */
    public function setBusLine(?BusLine $busLine): self
    {
        $this->busLine = $busLine;

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
     *
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
        return $this->stop;
    }
}
