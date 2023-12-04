<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column]
    private ?float $price_net = null;

    #[ORM\Column]
    private ?float $price_gross = null;

    #[ORM\Column]
    private ?float $vat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPriceNet(): ?float
    {
        return $this->price_net;
    }

    public function setPriceNet(float $price_net): static
    {
        $this->price_net = $price_net;

        return $this;
    }

    public function getPriceGross(): ?float
    {
        return $this->price_gross;
    }

    public function setPriceGross(float $price_gross): static
    {
        $this->price_gross = $price_gross;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): static
    {
        $this->vat = $vat;

        return $this;
    }
}
