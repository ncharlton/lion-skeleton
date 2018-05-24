<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 22.04.2018
 * Time: 12:16
 */

namespace App\Repository;

use App\Entity\Actor;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class ActorRepository extends EntityRepository {

    /**
     * @param $id
     * @return Actor
     * @throws NonUniqueResultException
     */
    public function getActorById($id) {
        return $this->createQueryBuilder("actor")
            ->where("actor.id = :id")
            ->setMaxResults(1)
            ->setParameter(":id", $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

}