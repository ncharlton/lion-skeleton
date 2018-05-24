<?php
namespace App\Controller\Api;

use App\Entity\File;
use App\Entity\Profile;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller {
    /**
     * @Route("/api/profile")
     * @Method("POST")
     *
     * @param Request $request
     * @throws NonUniqueResultException
     * @return Response
     */
    public function newAction(Request $request) {
        $serializer = $this->get("jms_serializer");

        $actorId = $request->request->get("actorId");
        $hobbies = $request->request->get("hobbies");
        $profession = $request->request->get("profession");

        // fetch actor
        $actor = $this->getDoctrine()->getRepository("App:Actor")
            ->getActorById($actorId);

        // create new file
        /** @var UploadedFile $image */
        $image = $request->files->get("image");

        $file = new File();
        $file->setActor($actor);
        $file->setFile($image);
        $file->setName($actor->getUser()->getUserName());
        $file->setSize($image->getClientSize());
        $file->setType($image->getClientMimeType());
        $file->setPath($this->getParameter("avatar_images_dir"));
        $file->setExtension($image->guessExtension());

        // create new profile
        $profile = new Profile();
        $profile->setAvatar($file);
        $profile->setHobbies($hobbies);
        $profile->setProfession($profession);

        // assign profile to actor
        $actor->setProfile($profile);
        $actor->getUser()->setComplete("5");

        // flush objects
        $em = $this->getDoctrine()->getManager();
        $em->persist($file);
        $em->persist($profile);
        $em->persist($actor);
        $em->flush();

        // save image in avatar directory
        $filename = $actor->getUser()->getUserName() . "." . $image->guessExtension();

        $image->move(
            $this->getParameter("avatar_images_dir"),
            $filename
        );

        // return Response
        $data = $serializer->serialize($profile, 'json');

        return new Response($data, 201);
    }
}