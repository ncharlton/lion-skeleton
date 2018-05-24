<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 13.04.2018
 * Time: 10:08
 */

namespace App\Controller\Api;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MainController
 * @package App\Controller\Api
 */
class MainController extends Controller
{
    /**
     * @Route("/api")
     */
    public function displayAction() {
        return new Response("true");
    }
}