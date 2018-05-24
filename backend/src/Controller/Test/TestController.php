<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 13.04.2018
 * Time: 09:44
 */

namespace App\Controller\Test;


use App\Service\IdService;
use Buzz\Browser;
use Doctrine\ORM\Mapping\Id;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("/test/user/creation")
     */
    public function testNewUser() {

        $testcase = new WebTestCase();


        $browser = new Browser();

        //$respone = $browser->post('/api/user', array(), )

        $result = $browser->submitForm('/api/user', [
            'username' => "test",
            'email' => "test@test.de"
        ]);

        return new Response($result);
    }

    /**
     * @Route("/test/guid")
     */
    public function testGuid() {
        $idService = new IdService();
        $message = "";
        for($i = 0; $i < 20; $i++) {
            $message .= $idService->generateGlobalId() . '<br>';
        }
        die($message);
    }

}