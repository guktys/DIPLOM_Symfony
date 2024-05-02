<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegistrationControllerTest extends WebTestCase
{
    public function testSuccessfulRegistration(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/register', [
            'email' => 'test@example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone' => '1234567890',
            'logo' => 'logo.png',
            'confirm_password' => 'securepassword123'
        ]);

        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('success', $responseData);
        $this->assertTrue($responseData['success']);
        $this->assertEquals('Ви успішно зареєстровані!', $responseData['message']);
    }
}