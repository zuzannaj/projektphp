<?php
/**
 * Ticket entity.
 */
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 * @ORM\Table(name="tickets")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BusLine")
     * @ORM\JoinColumn(nullable=false)
     */
    public $busLine;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = "3",
     *     max = "255",
     * )
     */
    public $first_stop;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = "3",
     *     max = "255",
     * )
     */
    public $last_stop;

    /**
     * Ticket constructor.
     */
    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return Ticket
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Ticket
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \App\Entity\BusLine
     */
    public function getBusLine(): ?BusLine
    {
        return $this->busLine;
    }

    /**
     * @param BusLine|null $bus_line
     * @return Ticket
     */
    public function setBusLine(BusLine $busLine): self
    {
        $this->busLine = $busLine;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstStop(): ?string
    {
        return $this->first_stop;
    }

    /**
     * @param string $first_stop
     * @return Ticket
     */
    public function setFirstStop(string $first_stop): self
    {
        $this->first_stop = $first_stop;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastStop(): ?string
    {
        return $this->last_stop;
    }

    /**
     * @param string $last_stop
     * @return Ticket
     */
    public function setLastStop(string $last_stop): self
    {
        $this->last_stop = $last_stop;

        return $this;
    }

    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     *
     * @constant int NUMBER_OF_ITEMS
     */
    const NUMBER_OF_ITEMS = 6;
}
