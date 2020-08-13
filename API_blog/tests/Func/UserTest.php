<?php

declare(strict_types=1);

namespace App\Tests\Func;

use App\DataFixtures\AppFixtures;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Functional creation test api users.
 */
class UserTest extends AbstractEndPoint
{
    private string $userPayload = '{"email": "%s", "password": "password"}';

    public function testGetUsers(): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/users',
            '',
            [],
            false
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testGetDefaultUser(): int
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/users',
            '',
            ['email' => AppFixtures::DEFAULT_USER['email']],
            false
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent, true);

        //dd($responseDecoded);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);

        return $responseDecoded[0]['id'];
    }

    /**
     * @depends testGetDefaultUser
     */
    public function testPutDefaultUsers(int $id): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_PUT,
            '/api/users/'.$id,
            $this->getPayLoad(),
            [],
            false
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        //dd($responseDecoded);

        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    /**
     * @depends testGetDefaultUser
     */
    public function testPatchDefaultUsers(int $id): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_PATCH,
            '/api/users/'.$id,
            $this->getPayLoad(),
            [],
            false
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        //dd($responseDecoded);

        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    /**
     * @depends testGetDefaultUser
     */
    public function testDeleteDefaultUsers(int $id): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_DELETE,
            '/api/users/'.$id,
            $this->getPayLoad(),
            [],
            false
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        //dd($responseDecoded);

        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testPostUsers(): int
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/users',
            $this->getPayLoad(),
            [],
            false
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent, true);

        //dd($responseDecoded['id']);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);

        return $responseDecoded['id'];
    }

    /**
     * @depends testPostUsers
     */
    public function testDeleteOtherUsersWithJWT(int $id): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_DELETE,
            '/api/users/'.$id
        );

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent, true);

        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        self::assertEquals($this->notYourResource, $responseDecoded['message']);
    }

    /**
     * @depends testGetDefaultUser
     */
    public function testDeleteDefaultUsersWithJWT(int $id): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_DELETE,
            '/api/users/'.$id
        );

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testPostDefaultUsers(): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/users',
            json_encode(AppFixtures::DEFAULT_USER),
            [],
            false
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent, true);

        //dd($responseDecoded['id']);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testPostSameDefaultUsers(): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/users',
            json_encode(AppFixtures::DEFAULT_USER),
            [],
            false
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent, true);

        //dd($response->getStatusCode());

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    private function getPayLoad(): string
    {
        $faker = Factory::create();

        return sprintf($this->userPayload, $faker->email);
    }
}
