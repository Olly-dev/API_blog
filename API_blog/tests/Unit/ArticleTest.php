<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Article;
use PHPUnit\Framework\TestCase;
use App\Entity\User;

class ArticleTest extends TestCase
{
    private Article $article;
    protected function setUp()
    {
        parent::setUp();

        $this->article = new Article();
    }

    public function testGetName(): void
    {
        $value = 'ici un titre de test unitaire';

        $response = $this->article->setName($value);

        self::assertInstanceOf(Article::class, $response);
        self::assertEquals($value, $this->article->getName());
    }

    public function testGetContent(): void
    {
        $value = 'ici un contenu pour les tests unitaires';

        $response = $this->article->setContent($value);

        self::assertInstanceOf(Article::class, $response);
        self::assertEquals($value, $this->article->getContent());
    }

    public function testGetAuthor(): void
    {
        $value = new User();

        $response = $this->article->setAuthor($value);

        self::assertInstanceOf(Article::class, $response);
        self::assertInstanceOf(User::class, $this->article->getAuthor());
    }
}