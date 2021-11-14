<?php

namespace App\Entity;

use App\Repository\AnnouncementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnouncementRepository::class)
 */
class Announcement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="announcements")
     * @ORM\JoinColumn(name="id_user", onDelete="CASCADE", nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="float")
     */
    private $total_area;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $living_area;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $kitchen_area;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="announcements")
     * @ORM\JoinColumn(name="id_balcony", onDelete="SET NULL", nullable=true)
     */
    private $idBalcony;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="announcements")
     * @ORM\JoinColumn(name="id_type_house", onDelete="SET NULL", nullable=true)
     */
    private $idType_house;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="announcements")
     * @ORM\JoinColumn(name="id_apartment_size", onDelete="SET NULL", nullable=true)
     */
    private $idApartment_size;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="announcements")
     * @ORM\JoinColumn(name="id_due_date", onDelete="SET NULL", nullable=true)
     */
    private $idDue_date;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="announcements")
     * @ORM\JoinColumn(name="id_ownership", onDelete="SET NULL", nullable=true)
     */
    private $idOwnership;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $photos = [];

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $banned;

    /**
     * @ORM\Column(type="integer")
     */
    private $floor;

    /**
     * @ORM\Column(type="integer")
     */
    private $count_floor;

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getTotalArea(): ?int
    {
        return $this->total_area;
    }

    public function setTotalArea(int $total_area): self
    {
        $this->total_area = $total_area;

        return $this;
    }

    public function getLivingArea(): ?int
    {
        return $this->living_area;
    }

    public function setLivingArea(int $living_area): self
    {
        $this->living_area = $living_area;

        return $this;
    }

    public function getKitchenArea(): ?int
    {
        return $this->kitchen_area;
    }

    public function setKitchenArea(int $kitchen_area): self
    {
        $this->kitchen_area = $kitchen_area;

        return $this;
    }

//    public function getBalcony(): ?string
//    {
//        return $this->balcony;
//    }
//
//    public function setBalcony(string $balcony): self
//    {
//        $this->balcony = $balcony;
//
//        return $this;
//    }

//    public function getTypeHouse(): ?string
//    {
//        return $this->type_house;
//    }
//
//    public function setTypeHouse(?string $type_house): self
//    {
//        $this->type_house = $type_house;
//
//        return $this;
//    }
//
//    public function getApartmentSize(): ?string
//    {
//        return $this->apartment_size;
//    }
//
//    public function setApartmentSize(string $apartment_size): self
//    {
//        $this->apartment_size = $apartment_size;
//
//        return $this;
//    }
//
//    public function getDueDate(): ?string
//    {
//        return $this->due_date;
//    }
//
//    public function setDueDate(string $due_date): self
//    {
//        $this->due_date = $due_date;
//
//        return $this;
//    }
//
//    public function getOwnership(): ?string
//    {
//        return $this->ownership;
//    }
//
//    public function setOwnership(?string $ownership): self
//    {
//        $this->ownership = $ownership;
//
//        return $this;
//    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function setPhotos(?array $photos): self
    {
        $this->photos = $photos;

        return $this;
    }

    public function getBanned(): ?\DateTimeInterface
    {
        return $this->banned;
    }

    public function setBanned(?\DateTimeInterface $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getCountFloor(): ?int
    {
        return $this->count_floor;
    }

    public function setCountFloor(int $count_floor): self
    {
        $this->count_floor = $count_floor;

        return $this;
    }

    public function getIdBalcony(): ?Properties
    {
        return $this->idBalcony;
    }

    public function setIdBalcony(?Properties $idProperty): self
    {
        $this->idBalcony = $idProperty;

        return $this;
    }

    public function getIdTypeHouse(): ?Properties
    {
        return $this->idType_house;
    }

    public function setIdTypeHouse(?Properties $idProperty): self
    {
        $this->idType_house = $idProperty;

        return $this;
    }

     public function getIdApartmentSize(): ?Properties
    {
        return $this->idApartment_size;
    }

    public function setIdApartmentSize(?Properties $idProperty): self
    {
        $this->idApartment_size = $idProperty;

        return $this;
    }

    public function getIdDueDate(): ?Properties
    {
        return $this->idDue_date;
    }

    public function setIdDueDate(?Properties $idProperty): self
    {
        $this->idDue_date = $idProperty;

        return $this;
    }

     public function getIdOwnership(): ?Properties
    {
        return $this->idOwnership;
    }

    public function setIdOwnership(?Properties $idProperty): self
    {
        $this->idOwnership = $idProperty;

        return $this;
    }
}
