<?php

namespace App\Entity;

use App\Repository\UserDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserDetailsRepository::class)]
class UserDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: "userDetails", cascade: ["persist"])]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", nullable: true)]
    private ?User $user = null;
    #[ORM\Column(type: 'string', length: 255)]
    private string $instagram;

    #[ORM\Column(type: 'string')]
    private string $telegram;

    #[ORM\Column(type:'string', length: 255)]
    private string $profession;

    #[ORM\Column(type: 'json', length: 255, options: ["default" => "{}"])]
    private mixed $abilitys = [];

    #[ORM\Column(type:'string', length: 255)]
    private string $city;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getInstagram(): string
    {
        return $this->instagram;
    }

    /**
     * @param string $instagram
     */
    public function setInstagram(string $instagram): void
    {
        $this->instagram = $instagram;
    }

    /**
     * @return string
     */
    public function getTelegram(): string
    {
        return $this->telegram;
    }

    /**
     * @param string $telegram
     */
    public function setTelegram(string $telegram): void
    {
        $this->telegram = $telegram;
    }

    /**
     * @return string
     */
    public function getProfession(): string
    {
        return $this->profession;
    }

    /**
     * @param string $profession
     */
    public function setProfession(string $profession): void
    {
        $this->profession = $profession;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getAbilitys(): mixed
    {
        return $this->abilitys;
    }

    /**
     * @param mixed $abilitys
     */
    public function setAbilitys(mixed $abilitys): void
    {
        $this->abilitys = $abilitys;
    }



}