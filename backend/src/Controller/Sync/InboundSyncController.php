<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 17.04.2018
 * Time: 17:16
 */

namespace App\Controller\Sync;

use App\Service\EntityService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InboundSyncController extends Controller
{
    /**
     * @Route("/sync/inbound/comments")
     * @Method("POST")
     * @param Request $request
     */
    public function syncComments(Request $request, EntityService $entityService) {
        $serializer = $this->get("jms_serializer");

        $data = json_decode($request->getContent());

        // Initialize Repositories and Entity Manager
        $commentRepo = $this->getDoctrine()->getRepository("App:Comment");
        $actorRepo = $this->getDoctrine()->getRepository("App:Actor");
        $userRepo = $this->getDoctrine()->getRepository("App:User");
        $syncRepo = $this->getDoctrine()->getRepository("App:Sync");
        $em = $this->getDoctrine()->getManager();

        $dataId = $data->id;
        $dataComments = $data->comments;

        // fetch comments since id
        $commentsSince = $this->getDoctrine()->getRepository("App:Comment")
            ->getCommentsAfterId($dataId);

        $em = $this->getDoctrine()->getManager();
        // insert local comments

        foreach($dataComments as $comment) {

            $actor = $entityService->transformActor($comment->actor);
            $user = $entityService->transformUser($comment->actor->user, $actor);
            $comment = $entityService->transformComment($comment, $actor);

            if($commentRepo->getCommentById($comment->getId())) {

            } else {
                // check if actor exists
                if($actorRepo->getActorById($actor->getId())) {
                    // actor fix
                    $getActor = $actorRepo->findOneBy(["id" => $actor->getId()]);
                    $comment->setActor($getActor);
                    $em->persist($comment);
                    $em->flush();
                } else {
                    // if actor doesnt exist flush all
                    $em->persist($actor);
                    $em->persist($user);
                    $em->persist($comment);
                    $em->flush();
                }
            }
        }

        $commentsSince = $serializer->serialize($commentsSince, 'json');

        return new Response($commentsSince, 200);
    }
}