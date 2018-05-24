<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="profile")
 */

class Profile {
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Doctrine\GlobalIdGenerator")
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $hobbies;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $profession;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\File")
     * @ORM\JoinColumn(name="avatar", referencedColumnName="id")
     *
     * @var File
     */
    private $avatar;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHobbies(): string
    {
        return $this->hobbies;
    }

    /**
     * @param string $hobbies
     */
    public function setHobbies(string $hobbies): void
    {
        $this->hobbies = $hobbies;
    }

    /**
     * @return string
     */
    public function getProfession(): string
    {
        return $this->profession;
    }

    /**
     * @param string $profession
     */
    public function setProfession(string $profession): void
    {
        $this->profession = $profession;
    }

    /**
     * @return File
     */
    public function getAvatar(): File
    {
        return $this->avatar;
    }

    /**
     * @param File $avatar
     */
    public function setAvatar(File $avatar): void
    {
        $this->avatar = $avatar;
    }
}