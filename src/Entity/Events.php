<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 */
class Events
{

    public function __construct()
    {
        $this->datetime = new \DateTime();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=255)
    */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @ORM\Column(type="string", length=255)
    */
    private $description;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @ORM\Column(type="datetime")
    */
    private $datetime;

    public function getDateTime(): ?DateTime
    {
        return $this->datetime;
    }

    /**
     * Set description
     *
     * @param string $datetime
     * @return User
     */
    public function setDateTime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }
    

    /**
     * @ORM\Column(type="string", length=255)
    */
    private $place;

    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return User
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    

    /**
     * @ORM\Column(type="string", length=1000)
    */
    private $imageurl;

    public function getImageUrl(): ?string
    {
        return $this->imageurl;
    }

    /**
     * Set image
     *
     * @param string $imageurl
     * @return User
     */
    public function setImageUrl($imageurl)
    {
        $this->imageurl = $imageurl;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'datetime' => $this->getDateTime(),
            'place' => $this->getPlace(),
            'image' => $this->getImageUrl()
        ];
    }
}
