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
     * Id.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Created at.
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * User.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Bus line.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\BusLine")
     * @ORM\JoinColumn(nullable=false)
     */
    public $busLine;

    /**
     * First stop.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(
     *     min = "3",
     *     max = "255",
     * )
     */
    public $firstStop;

    /**
     * Last stop.
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(
     *     min = "3",
     *     max = "255",
     * )
     */
    public $lastStop;

    /**
     * Ticket constructor.
     */
    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int|null
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get created at.
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set created at.
     *
     * @param \DateTimeInterface $createdAt
     *
     * @return Ticket
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get user.
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user.
     *
     * @param User|null $user
     *
     * @return Ticket
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get bus line.
     *
     * @return \App\Entity\BusLine
     */
    public function getBusLine(): ?BusLine
    {
        return $this->busLine;
    }

    /**
     * Set bus line.
     *
     * @param BusLine|null $busLine
     *
     * @return Ticket
     */
    public function setBusLine(BusLine $busLine): self
    {
        $this->busLine = $busLine;

        return $this;
    }

    /**
     * Get first stop.
     *
     * @return string|null
     */
    public function getFirstStop(): ?string
    {
        return $this->firstStop;
    }

    /**
     * Set first stop.
     *
     * @param string $firstStop
     *
     * @return Ticket
     */
    public function setFirstStop(string $firstStop): self
    {
        $this->firstStop = $firstStop;

        return $this;
    }

    /**
     * Get last stop.
     *
     * @return string|null
     */
    public function getLastStop(): ?string
    {
        return $this->lastStop;
    }

    /**
     * Set last stop.
     *
     * @param string $lastStop
     *
     * @return Ticket
     */
    public function setLastStop(string $lastStop): self
    {
        $this->lastStop = $lastStop;

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
