<?php

namespace App\Entity;

use App\Model\CourseName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CoursesRepository')]
#[ORM\Table(name: 'courses')]
class Сourses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?CourseName $kourseName;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(name: 'start_time', type: 'datetime')]
    private \DateTime $startTime;

    #[ORM\Column(name: 'end_time', type: 'datetime')]
    private \DateTime $endTime;

    #[ORM\Column(type: 'string')]
    private string $status;


}