<?php

namespace App\Entity;

use App\Entity\Courses;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CoursesStudentRepository')]
#[ORM\Table(name: 'courses_student')]
class CoursesStudent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'id')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Courses::class, inversedBy: 'id')]
    private ?Courses $kourse;

    #[ORM\Column(name: 'start_time', type: 'datetime')]
    private \DateTime $startTime;

    #[ORM\Column(name: 'end_time', type: 'datetime')]
    private \DateTime $endTime;

    #[ORM\Column(type: 'string')]
    private string $status;

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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return \App\Entity\Courses|null
     */
    public function getKourse(): ?\App\Entity\Courses
    {
        return $this->kourse;
    }

    /**
     * @param \App\Entity\Courses|null $kourse
     */
    public function setKourse(?\App\Entity\Courses $kourse): void
    {
        $this->kourse = $kourse;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime(): \DateTime
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime(): \DateTime
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime(\DateTime $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

}