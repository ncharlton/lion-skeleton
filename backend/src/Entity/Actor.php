<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActorRepository")
 * @ORM\Table(name="actor")
 */
Class Actor {
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=30)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\GlobalIdGenerator")
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="actor")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Human")
     * @ORM\JoinColumn(name="human", referencedColumnName="id")
     *
     * @var Human
     */
    private $human;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Address")
     * @ORM\JoinColumn(name="address", referencedColumnName="id")
     *
     * @var Address
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile")
     * @ORM\JoinColumn(name="profile", referencedColumnName="id")
     *
     * @var Profile
     */
    private $profile;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Human
     */
    public function getHuman(): Human
    {
        return $this->human;
    }

    /**
     * @param Human $human
     */
    public function setHuman(Human $human): void
    {
        $this->human = $human;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Profile
     */
    public function getProfile(): Profile
    {
        return $this->profile;
    }

    /**
     * @param Profile $profile
     */
    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }
}