<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\NewsRepository')]
#[ORM\Table(name: 'news')]
class News
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private readonly ?int $id;
    #[ORM\Column(type: 'datetime', length: 250, nullable: true)]
    private ?\DateTime $date;
    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private string $title;
    #[ORM\Column(type: 'text', nullable: true)]
    private string $text;
    #[ORM\Column(type: 'text', nullable: true)]
    private string $imageLinks;

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     */
    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getImageLinks(): string
    {
        return $this->imageLinks;
    }

    /**
     * @param string $imageLinks
     */
    public function setImageLinks(string $imageLinks): void
    {
        $this->imageLinks = $imageLinks;
    }

}