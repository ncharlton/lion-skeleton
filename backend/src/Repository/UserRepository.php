<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 22.04.2018
 * Time: 12:16
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class UserRepository extends EntityRepository
{
    /**
     * @param $id
     * @return User
     * @throws NonUniqueResultException
     */
    public function getUserById($id) {
        return $this->createQueryBuilder("user")
            ->where("user.id = :userId")
            ->setMaxResults(1)
            ->setParameter(":userId", $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $username
     * @return User
     * @throws NonUniqueResultException
     */
    public function getUserByUsername($username) {
        return $this->createQueryBuilder("user")
            ->where("user.username = :username")
            ->setParameter(":username", $username)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getUserByLoginCredentials($username, $password) {

    }

    /**
     * @param $token
     * @return User
     */
    public function getUserByToken($token) {
        return $this->createQueryBuilder("user")
            ->where("user.token = :token")
            ->setParameter(":token", $token)
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
    }
}