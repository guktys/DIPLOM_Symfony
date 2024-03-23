<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\AppointmentRepository')]
#[ORM\Table(name: 'appointments')]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'id')]
    private User $employer;



    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'id')]
    private User $user;

    #[ORM\Column(type: 'string')]
    private ?string $service = '';

    #[ORM\Column(name: 'create_at', type: 'datetime')]
    private \DateTime $createAt;

    #[ORM\Column(name: 'time', type: 'datetime')]
    private \DateTime $time;

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
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService(string $service): void
    {
        $this->service = $service;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }

    /**
     * @param \DateTime $createAt
     */
    public function setCreateAt(\DateTime $createAt): void
    {
        $this->createAt = $createAt;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     */
    public function setTime(\DateTime $time): void
    {
        $this->time = $time;
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
    /**
     * @return User
     */
    public function getEmployer(): User
    {
        return $this->employer;
    }

    /**
     * @param User $employer
     */
    public function setEmployer(User $employer): void
    {
        $this->employer = $employer;
    }
}
