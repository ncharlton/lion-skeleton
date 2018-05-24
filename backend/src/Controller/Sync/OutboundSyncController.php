<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 17.04.2018
 * Time: 17:16
 */

namespace App\Controller\Sync;

use App\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OutboundSyncController extends Controller
{
    /**
     * @Route("/sync/outbound/comments")
     * @Method("GET")
     */
    public function deliverAllComments(Request $request) {
        $serializer = $this->get("jms_serializer");

        $comments = $this->getDoctrine()->getRepository('App:Comment')
            ->findAll();

        $comments = $serializer->serialize($comments, 'json');

        return new Response($comments, 200);
    }


    /**
     * @Route("/sync/outbound/comments/since")
     * @Method("GET")
     */
    public function deliverCommentsAfterId(Request $request) {
        $get = $request->query;
        $serializer = $this->get("jms_serializer");

        if($get->has('comment_id')) {
            $comment_id = $get->get('comment_id');

            $lastComment = $this->getDoctrine()->getRepository('App:Comment')
                ->getCommentById($comment_id);

            $lastComment = $lastComment[0];

            $comments = $this->getDoctrine()->getRepository('App:Comment')
                ->getCommentsAfterComment($lastComment);

            $comments = $serializer->serialize($comments, 'json');

            return new Response($comments, 200);
         }
    }
}