<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 16.04.2018
 * Time: 15:49
 */

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Service\IdService;
use App\Service\RequestService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Route("/api/comment/new")
     */
    public function newAction(Request $request, RequestService $requestService, IdService $idService) {
        $serializer = $this->get('jms_serializer');
        $post = json_decode($request->getContent());

        if(strlen($post->comment) > 0 && $post->user_id) {
            $commentText = $post->comment;
            $userId = $post->user_id;
            $user = $this->getDoctrine()->getRepository('App:User')
                ->findOneBy([
                    'id' => $userId
                ]);

            if($user) {
                $comment = new Comment();
                $comment->setId($idService->generateGlobalId());
                $comment->setCommentText($commentText);
                $comment->setActor($user->getActor());

                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                $data = $serializer->serialize($comment, 'json');
                return new Response($data, 200, $requestService->corsHeaders());

            }
        } else {
            return new Response('error', 400, $requestService->corsHeaders());
        }
    }

    /**
     * @Route("/api/comments")
     * @Method("GET")
     */
    public function listAction(Request $request) {
        $get = $request->query;
        $serializer = $this->get('jms_serializer');

        $comments = $this->getDoctrine()->getRepository('App:Comment')
            ->listComments(10);

        $comments = $serializer->serialize($comments, 'json');

        return new Response($comments, 200);
    }
}