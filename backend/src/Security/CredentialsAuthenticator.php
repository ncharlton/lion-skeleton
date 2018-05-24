<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 09.05.2018
 * Time: 12:10
 */

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class CredentialsAuthenticator extends AbstractGuardAuthenticator
{
    private $encoder;
    private $em;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $this->encoder = $encoder;
        $this->em = $em;
    }

    public function supports(Request $request)
    {
        if($request->getPathInfo() == "/api/login" && $request->isMethod("GET")) {

            if($request->query->has("username") && $request->query->has("password"))
                return true;
            else
                return false;
        } else {
            return false;
        }
    }

    public function getCredentials(Request $request)
    {
        return array (
            "username" => $request->query->get("username"),
            "password" => $request->query->get("password")
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials["username"];
        $password = $credentials["password"];

        if($username === null && $password === null)
            return;

        return $userProvider->loadUserByUsername($username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // if password valid generate new api token
        if($this->encoder->isPasswordValid($user, $credentials['password'])) {
            $token = bin2hex(random_bytes(16));

            $loginUser = $this->em->getRepository("App:User")
                ->findOneBy([
                    "username" => $user->getUsername()
                ]);

            $loginUser->setToken($token);

            $this->em->persist($loginUser);
            $this->em->flush();

            return true;
        }
        else
            return false;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => "Username or password is wrong."
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        /** @var User $loginUser */
        $loginUser = $this->em->getRepository("App:User")
            ->findOneBy([
               "username" => $request->query->get("username")
            ]);

        $data = array(
            'message' => "Success",
            'token' => $loginUser->getToken(),
        );

       return new JsonResponse($data, 200);
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}