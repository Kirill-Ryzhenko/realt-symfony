<?php

namespace App\Entity;

use App\Repository\ComplaintRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ComplaintRepository::class)
 */
class Complaint
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Announcement::class)
     * @ORM\JoinColumn(name="id_announcement", onDelete="CASCADE", nullable=false)
     */
    private $id_announcement;

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

    public function getIdAnnouncement(): ?Announcement
    {
        return $this->id_announcement;
    }

    public function setIdAnnouncement(?Announcement $id_announcement): self
    {
        $this->id_announcement = $id_announcement;

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
