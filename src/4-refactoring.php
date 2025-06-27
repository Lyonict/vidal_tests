<?php

/*
First thoughts :

- properties are public instead of being private
- should id be allowed to be null ? Don't think so
- mix of french and english
- error when calling properties -> french and english weird mix, so incorrect variables
- what's happening at the class instanciation at the end? It's weird
- why is getClassification protected ?
- getmollecule is neither public or private
- weird indentation for appelAPI
    - also, this funtion should probably be private
    - in addition to be put into english
- mix of declaring an array array() and [] -> stick to one
- no type declaration ? Maybe because it's php 5 ?
- also, should $name be allowed to be null ?
- getters should probably be in the same order as the properties
- also, we barely have setters

I'm gonna assume that we are at least in the last version of PHP 7, which support typing

Not totally sure what's the best way to handle the "name" property. It really shouldn't be nullable
*/

require_once __DIR__ . '/ApiService.php';

class Product
{

    private int $id;

    private string $name = "";

    private ?string $marketStatus = null;

    private ?array $molecules = [];

    private ?array $classifications = [];

    public function __construct(int $pIdProduct)
    {
        $this->id = $pIdProduct;
        $apiService = new ApiService;
        $apiService->apiCall($this);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $pIdProduct): void
    {
        $this->id = $pIdProduct;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMarketStatus(): string|null
    {
        return $this->marketStatus;
    }

    public function setMarketStatus(?string $marketStatus): void
    {
        $this->marketStatus = $marketStatus;
    }

    public function getMolecules(): array|null
    {
        return $this->molecules;
    }

    public function setMolecules(?array $molecules): void
    {
        $this->molecules = $molecules;
    }

    public function getClassifications(): array|null
    {
        return $this->classifications;
    }

    public function setClassifications(?array $classifications): void
    {
        $this->classifications = $classifications;
    }
}

$product = new Product(5485);
echo "<b>Nom</b> : " . $product->getName() . "<br/>";
echo "<b>Status de commercialisation</b> : " . $product->getMarketStatus() . "<br/>";