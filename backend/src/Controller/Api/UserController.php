<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 13.04.2018
 * Time: 15:08
 */

namespace App\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{

    /**
     * @Route("/api/users")
     * @Method("GET")
     */
    public function getAction(Request $request) {
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        $format = 'json';
        $data = $this->get('jms_serializer')->serialize($users, 'json');

        //return new JsonResponse($data, 200);

        return $response = new Response(
            $data,
            RESPONSE::HTTP_OK,
            array('content-type' => 'application/json')
        );
       // return new Response($users);
    }

}