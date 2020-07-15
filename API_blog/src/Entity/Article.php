<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\ArticleUpdatedAt;


/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ApiResource( 
 *      normalizationContext={"groups"={"article:read"}},
 *      normalizationContext={"groups"={"article:details:read"}},
 *      collectionOperations={"get", "post"},
 *      itemOperations={
 *                      "get",
 *                      "put",
 *                      "patch",
 *                      "delete",
 *                      "put_updated_at"={
 *                          "method"="PUT",
 *                          "path"="/articles/{id}/updated_at",
 *                          "controller"=ArticleUpdatedAt::class
 *                      }
 *      }
 * )
 */
class Article
{
    use ResourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"article:read","user:read", "article:details:read"})
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"article:read","user:read", "article:details:read"})
     */
    private string $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"article:details:read"})
     */
    private User $author;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
