<?php
/**
 * Bus line entity.
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bus line entity.
 *
 * @ORM\Entity(repositoryClass="App\Repository\BusLineRepository")
 * @ORM\Table(name="bus_lines")
 */
class BusLine
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
     * Number.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="1",
     *     max="3",
     * )
     */
    private $number;

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
     * Get number.
     *
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * Set number.
     *
     * @param int $number
     * @return BusLine
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * To string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->number;
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
