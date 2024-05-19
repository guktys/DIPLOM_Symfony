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

    #[ORM\ManyToOne(targetEntity: Services::class, inversedBy: 'id')]
    private ?Services $service=null;
    #[ORM\Column(name: 'price',type: 'string')]
    private string $price;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'id')]
    private User $user;

    #[ORM\Column(name: 'create_at', type: 'datetime')]
    private \DateTime $createAt;

    #[ORM\Column(name: 'time', type: 'datetime')]
    private \DateTime $time;

    #[ORM\ManyToOne(targetEntity: AppointmentStatus::class, inversedBy: 'id')]
    private ?AppointmentStatus $status = null;

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
     * @return Services
     */
    public function getService(): Services
    {
        return $this->service;
    }

    /**
     * @param Services $service
     */
    public function setService(Services $service): void
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
     * @return AppointmentStatus|null
     */
    public function getStatus(): ?AppointmentStatus
    {
        return $this->status;
    }

    /**
     * @param AppointmentStatus|null $status
     */
    public function setStatus(?AppointmentStatus $status): void
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

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

}
