<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 22.04.2018
 * Time: 14:47
 */

namespace App\Service;

use App\Entity\Actor;
use App\Entity\Comment;
use App\Entity\User;

class EntityService
{
    /**
     * @param Actor object $object
     * @return Actor $actor
     */
    public function transformActor($object) {
        $actor = new Actor();
        $actor->setId($object->id);
        $actor->setActorType($object->actor_type);
        $actor->setCreatedAt(new \DateTime($object->created_at));
        return $actor;
    }

    /**
     * @param object $object
     * @param Actor $actor
     * @return User
     */
    public function transformUser($object, $actor) {
        $user = new User();
        $user->setId($object->id);
        $user->setUserEmail($object->user_email);
        $user->setUserName($object->user_name);
        $user->setActor($actor);
        return $user;
    }

    /**
     * @param object $object
     * @param Actor $actor
     * @return Comment
     */
    public function transformComment($object, $actor) {
        $comment = new Comment();
        $comment->setId($object->id);
        $comment->setCommentText($object->comment_text);
        $comment->setActor($actor);
        $comment->setCreatedAt(new \DateTime($object->created_at));
        return $comment;
    }
}