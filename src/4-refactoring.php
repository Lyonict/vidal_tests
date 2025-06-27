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
*/

class Product
{

    public $id = null;

    public $name = "";

    public $marketStatus = null;

    public $molecules = array();

    public $classifications = [];

    public function __construct($pIdProduct = null)
    {
        $this->id = $pIdProduct;
        $this->appelAPI();
    }

    public function appelAPI($pIdProduct = null)
    {
        $url = "https://api.vidal.fr/rest/api/product/" . $this->id;
        $ch = curl_init();
        curlsetopt($ch, CURLOPT_URL, $url);
        curlsetopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode >= 400) {
            trigger_error('API Call error', E_USER_WARNING);
            return;
        }
        $xml = simplexml_load_string($res);
        $this->id = strval($xml->entry->id);
        if (isset($xml->entry->name)) {
            $this->nom;
        }
        $this->marketStatus = (string) $xml->entry->marketStatus;
        $this->molecules = $xml->entry->molecules;
        $this->classifications = $xml->entry->classifications;
    }

    private function getname()
    {
        return $this->nom;
    }

    public function setId($pIdProduct)
    {
        $this->id = $pIdProduct;
        $this->appelAPI();
    }

    public function getMarketStatus()
    {
        return $this->marketStatus;
    }

    function getMolecules()
    {
        return $this->molecules;
    }

    protected function getClassifications()
    {
        return $this->classifications;
    }
}

$product = new Product(5485);
$product->setId(5485);
echo "<b>Name</b> : " . $product->getNom() . "<br/>";
echo "<b>Status de commercialisation</b> : " . $product->getMarketStatus() . "<br/>";