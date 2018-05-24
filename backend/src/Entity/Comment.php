<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 14.04.2018
 * Time: 14:36
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 */
class Comment {
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=30)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Actor", inversedBy="comments")
     * @ORM\JoinColumn(name="actor", referencedColumnName="id")
     */
    private $actor;

    /**
     * @ORM\Column(type="string")
     */
    private $commentText;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCommentText()
    {
        return $this->commentText;
    }

    /**
     * @param mixed $commentText
     */
    public function setCommentText($commentText): void
    {
        $this->commentText = $commentText;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }


    /**
     * @return mixed
     */
    public function getActor(): Actor
    {
        return $this->actor;
    }

    /**
     * @param Actor $actor
     */
    public function setActor(Actor $actor)
    {
        $this->actor = $actor;
    }

}