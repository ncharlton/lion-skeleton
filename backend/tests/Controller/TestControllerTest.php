<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 14.04.2018
 * Time: 12:28
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestControllerTest extends WebTestCase
{
    public function testUserCreation() {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/user',
            array(
                'username' => 'Test',
                'email' => 'email@email.de'
            )
        );

        echo $client->getResponse();
    }

}