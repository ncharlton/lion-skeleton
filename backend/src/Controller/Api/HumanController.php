<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 10.05.2018
 * Time: 14:34
 */

namespace App\Controller\Api;

use App\Entity\Human;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HumanController extends Controller
{
    /**
     * @Route("/api/human")
     * @Method("POST")
     *
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request) {
        $data = json_decode($request->getContent());
        $serializer = $this->get("jms_serializer");

        // assign vars
        $userId = $data->userId;
        $firstName = $data->firstName;
        $surName = $data->surName;
        $otherNames = $data->otherNames;
        $gender = $data->gender;
        $placeOfBirth = $data->placeOfBirth;
        $dateOfBirth = \DateTime::createFromFormat('j.n.Y', (string) $data->dateOfBirth); //('j.n.Y ', (string) $data->dateOfBirth);
        $married = (boolean) $data->married;

        // create human
        $human = new Human();
        $human->setFirstName($firstName);
        $human->setSurName($surName);
        $human->setOtherNames($otherNames);
        $human->setGender($gender);
        $human->setPlaceOfBirth($placeOfBirth);
        $human->setDateOfBirth($dateOfBirth);
        $human->setMarried($married);

        try {
            $user = $this->getDoctrine()->getRepository("App:User")
                ->getUserById($userId);

            // set human on actor
            $user->getActor()->setHuman($human);
            $user->setComplete("1");

            $em = $this->getDoctrine()->getManager();
            $em->persist($human);
            $em->persist($user);
            $em->flush();

            $human = $serializer->serialize($human, 'json');
            return new Response($human, 201);
        } catch (NonUniqueResultException $e) {
            return new Response("SHIT", 409);
        }
    }
}