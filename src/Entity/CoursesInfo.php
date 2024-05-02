<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CoursesInfoRepository')]
#[ORM\Table(name: 'courses_info')]
class CoursesInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Courses::class, inversedBy: 'courses')]
    #[ORM\JoinColumn(name: 'courses_id', referencedColumnName: 'id')]
    private ?Courses $courses = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'id')]
    private User $instructor;

    #[ORM\Column(type:'text')]
    private?string $firstParagraph='';

    #[ORM\Column(type:'json')]
    private?array $skills = [];

    #[ORM\Column(type:'text')]
    private?string $endParagraph;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Courses|null
     */
    public function getCourses(): ?Courses
    {
        return $this->courses;
    }

    /**
     * @param Courses|null $courses
     */
    public function setCourses(?Courses $courses): void
    {
        $this->courses = $courses;
    }

    /**
     * @return User
     */
    public function getInstructor(): User
    {
        return $this->instructor;
    }

    /**
     * @param User $instructor
     */
    public function setInstructor(User $instructor): void
    {
        $this->instructor = $instructor;
    }

    /**
     * @return string|null
     */
    public function getFirstParagraph(): ?string
    {
        return $this->firstParagraph;
    }

    /**
     * @param string|null $firstParagraph
     */
    public function setFirstParagraph(?string $firstParagraph): void
    {
        $this->firstParagraph = $firstParagraph;
    }

    /**
     * @return array|null
     */
    public function getSkills(): ?array
    {
        return $this->skills;
    }

    /**
     * @param array|null $skills
     */
    public function setSkills(?array $skills): void
    {
        $this->skills = $skills;
    }

    /**
     * @return string|null
     */
    public function getEndParagraph(): ?string
    {
        return $this->endParagraph;
    }

    /**
     * @param string|null $endParagraph
     */
    public function setEndParagraph(?string $endParagraph): void
    {
        $this->endParagraph = $endParagraph;
    }



}