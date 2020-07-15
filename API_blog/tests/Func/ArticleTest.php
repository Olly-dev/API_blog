<?php

declare(strict_types=1);

namespace App\Tests\Func;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory; 

/**
 * Functional creation test api articles
 */
class ArticleTest extends AbstractEndPoint
{
    private string $articlePayload = '{"name": "%s", "content": "%s", "author":"%s"}';

    public function testGetArticles(): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/articles'
        );

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testPostArticles(): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/articles',
            $this->getPayLoad()
        );

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        //dd($responseDecoded);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    private function getPayLoad(): string
    {
        $faker = Factory::create();

        return sprintf($this->articlePayload, $faker->name(), $faker->text(), '/api/users/1');
    }
}