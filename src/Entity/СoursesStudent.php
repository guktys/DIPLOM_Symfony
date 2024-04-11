<?php

namespace App\Entity;

use App\Entity\Сourses;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CoursesStudentRepository')]
#[ORM\Table(name: 'courses_student')]
class СoursesStudent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'id')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Сourses::class, inversedBy: 'id')]
    private ?Сourses $kourse;

    #[ORM\Column(name: 'start_time', type: 'datetime')]
    private \DateTime $startTime;

    #[ORM\Column(name: 'end_time', type: 'datetime')]
    private \DateTime $endTime;

    #[ORM\Column(type: 'string')]
    private string $status;

}