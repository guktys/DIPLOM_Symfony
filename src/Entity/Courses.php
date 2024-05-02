<?php

namespace App\Entity;

use App\Model\CourseStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: 'App\Repository\CoursesRepository')]
#[ORM\Table(name: 'courses')]
class Courses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $kourseName;
    #[ORM\OneToMany(targetEntity: CoursesInfo::class, mappedBy: 'courses')]
    private ?Collection $coursesInfo = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(name: 'start_time', type: 'datetime')]
    private \DateTime $startTime;

    #[ORM\Column(name: 'end_time', type: 'datetime')]
    private \DateTime $endTime;

    #[ORM\Column(type: 'string')]
    private $status;

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
     * @return mixed
     */
    public function getKourseName()
    {
        return $this->kourseName;
    }

    /**
     * @param mixed $kourseName
     */
    public function setKourseName($kourseName): void
    {
        $this->kourseName = $kourseName;
    }

    /**
     * @return Collection|null
     */
    public function getCoursesInfo(): ?Collection
    {
        return $this->coursesInfo;
    }

    /**
     * @param Collection|null $coursesInfo
     */
    public function setCoursesInfo(?Collection $coursesInfo): void
    {
        $this->coursesInfo = $coursesInfo;
    }


    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
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
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


}