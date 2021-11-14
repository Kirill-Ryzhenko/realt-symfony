<?php

namespace App\Entity;

use App\Repository\SupportMessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SupportMessageRepository::class)
 */
class SupportMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(name="id_user", onDelete="CASCADE", nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      max = 60,
     *      minMessage = "Минимальное количество символов темы должно быть {{ limit }}",
     *      maxMessage = "Максимальное количество символов темы должно быть {{ limit }}"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 20,
     *      max = 1000,
     *      minMessage = "Минимальное количество символов описания должно быть {{ limit }}",
     *      maxMessage = "Максимальное количество символов описания должно быть {{ limit }}"
     * )
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
