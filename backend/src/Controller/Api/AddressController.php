<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 14.05.2018
 * Time: 17:35
 */

namespace App\Controller\Api;

use App\Entity\Address;
use App\Entity\Phone;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/api/address")
     * @Method("POST")
     */
    public function newAction(Request $request) {
        $data = json_decode($request->getContent());
        $serializer = $this->get("jms_serializer");
        $actorId = $data->actorId;
        $street = $data->street;
        $streetNumber = $data->streetNumber;
        $country = $data->country;
        $county = $data->county;
        $city = $data->city;
        $postalCode = $data->postalCode;
        $phoneType = $data->phoneType;
        $phoneNumber = $data->phoneNumber;

        $phone = new Phone();
        $phone->setType($phoneType);
        $phone->setNumber($phoneNumber);

        $address = new Address();
        $address->setStreet($street);
        $address->setStreetNumber($streetNumber);
        $address->setCountry($country);
        $address->setCounty($county);
        $address->setCity($city);
        $address->setPostalCode($postalCode);

        // persist through cascade
        $address->setPhone($phone);


        try {
            $actor = $this->getDoctrine()->getRepository("App:Actor")
                ->getActorById($actorId);

            $actor->setAddress($address);
            $actor->getUser()->setComplete("2");

            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->persist($actor);
            $em->flush();

            $address = $serializer->serialize($address, 'json');
            return new Response($address, 201);
        } catch (NonUniqueResultException $e) {
            return new Response("SHIT", 409);
        }
    }
}