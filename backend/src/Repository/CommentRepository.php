<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 16.04.2018
 * Time: 18:48
 */

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    /**
     * @return Comment[]
     * @param integer $limit
     * @param string $order
     */
    public function listComments($limit = 10, $order = "DESC") {
        return $this->createQueryBuilder('comment')
            ->orderBy("comment.createdAt", $order)
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }

    /**
     * @return Comment
     * @param integer $id
     */
    public function getCommentById($id) {
        return $this->createQueryBuilder('comment')
            ->where("comment.id = :id")
            ->setParameter(":id", $id)
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
    }

    /**
     * @return Comment[]
     * @param Comment $comment
     * @param string $order
     */
    public function getCommentsAfterComment(Comment $comment, $order = "DESC") {
        return $this->createQueryBuilder('comment')
            ->where("comment.createdAt > :createdAt")
            ->setParameter(":createdAt", $comment->getCreatedAt())
            ->orderBy("comment.createdAt", $order)
            ->getQuery()
            ->execute();
    }

    /**
     * @return Comment[]
     * @param Comment $comment
     * @param string $order
     */
    public function getCommentsAfterId($id, $order = "DESC") {
        $comment = $this->getCommentById($id);

        return $this->createQueryBuilder('comment')
            ->where("comment.createdAt > :createdAt")
            ->setParameter(":createdAt", $comment[0]->getCreatedAt())
            ->orderBy("comment.createdAt", $order)
            ->getQuery()
            ->execute();
    }
}