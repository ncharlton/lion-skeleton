<?php
/**
 * lionapp
 *
 * Authentication Controller
 * handles register, login, user object fetch
 */

namespace App\Controller\Api;

use App\Entity\Actor;
use App\Entity\User;
use App\Service\ErrorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AuthenticationController extends Controller
{
    /**
     * @Route("/api/user")
     * @Method("POST")
     */
    public function registerAction(Request $request, ValidatorInterface $validator, ErrorService $errorService) {
        $data = json_decode($request->getContent());
        $serializer = $this->get("jms_serializer");

        $user = new User();
        $user->setUserName($data->username);
        $user->setEmail($data->email);
        $user->setComplete("0");
        $user->setPlainPassword($data->password);

        $actor = new Actor();
        $actor->setUser($user);
        $user->setActor($actor);

        $errors = $validator->validate($user);

        if(count($errors) > 0) {
            $errorMessages = $serializer->serialize($errorService->validationErrors($errors), 'json');
            return new Response($errorMessages, 409);
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($actor);
            $em->flush();

            $user->setPlainPassword(null);
            $user = $serializer->serialize($user, 'json');

            return new Response($user, 200);
        }
    }

    /**
     * @Route("/api/login")
     * @Method("GET")
     */
    public function loginAction(Request $request) {
        // => App\Security\CredentialsAuthenticator.php
    }

    /**
     * @param Request $request
     * @Route("/api/login/check")
     * @Method("GET")
     */
    public function tokenAction(Request $request) {
        $serializer = $this->get("jms_serializer");

        if($request->query->has("token")) {
            $token = trim($request->query->get("token"));

            $user = $this->getDoctrine()->getRepository("App:User")
                ->getUserByToken($token);

            if($user) {
                $user = $serializer->serialize($user[0], 'json');
                return new Response($user, 200);
            } else {
                return new Response("false", 400);
            }
        } else {
            return new Response("false", 400);
        }
    }
}