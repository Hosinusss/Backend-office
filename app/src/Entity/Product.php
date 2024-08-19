<?php
// src/Entity/Product.php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(name: 'id')]
#[Groups(['product:read'])]
private ?int $id = null;

#[ORM\Column(length: 255)]
#[Groups(['product:read'])]
private ?string $name = null;

#[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
#[Groups(['product:read'])]
private ?float $price = null;

#[ORM\Column(type: 'text')]
#[Groups(['product:read'])]
private ?string $description = null;

#[ORM\Column(length: 255)]
#[Groups(['product:read'])]
private ?string $image = null;

#[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
#[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'category_id', nullable: false)]
#[Groups(['product:read'])]
private ?Category $category = null;

#[ORM\ManyToOne(targetEntity: Supplier::class, inversedBy: 'products')]
#[ORM\JoinColumn(name: 'supplier_id', referencedColumnName: 'supplier_id', nullable: false)]
#[Groups(['product:read'])]
private ?Supplier $supplier = null;

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

public function getPrice(): ?float
{
return $this->price;
}

public function setPrice(float $price): static
{
$this->price = $price;
return $this;
}

public function getDescription(): ?string
{
return $this->description;
}

public function setDescription(string $description): static
{
$this->description = $description;
return $this;
}

public function getImage(): ?string
{
return $this->image;
}

public function setImage(string $image): static
{
$this->image = $image;
return $this;
}

public function getCategory(): ?Category
{
return $this->category;
}

public function setCategory(?Category $category): static
{
$this->category = $category;
return $this;
}

public function getSupplier(): ?Supplier
{
return $this->supplier;
}

public function setSupplier(?Supplier $supplier): static
{
$this->supplier = $supplier;
return $this;
}
}
