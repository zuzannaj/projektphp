<?php
/**
 * Stop entity.
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StopRepository")
 * @ORM\Table(name="stops")
 */
class Stop
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * City.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $city;

    /**
     * Name.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Getter for City.
     *
     * @return string|null City
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Stop
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Getter for Name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Stop
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     *
     * @constant int NUMBER_OF_ITEMS
     */
    const NUMBER_OF_ITEMS = 3;
}
