<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavoriteRepository::class)
 */
class Favorite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="id_user", onDelete="CASCADE", nullable=false)
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity=Announcement::class)
     * @ORM\JoinColumn(name="id_announcement", onDelete="CASCADE", nullable=false)
     */
    private $id_announcement;

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdAnnouncement(): ?Announcement
    {
        return $this->id_announcement;
    }

    public function setIdAnnouncement(?Announcement $id_announcement): self
    {
        $this->id_announcement = $id_announcement;

        return $this;
    }
}
