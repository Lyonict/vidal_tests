<?php

class Product
{

    public $id = null;

public $name = "";

public $marketStatus = null;

public $molecules = array();

public $classifications = [];

    public function __construct($pIdProduct = null){
    $this->id = $pIdProduct;
    $this->appelAPI();
        }

        public function appelAPI($pIdProduct = null){
            $url = "https://api.vidal.fr/rest/api/product/".$this->id;
            $ch = curl_init();
            curlsetopt($ch, CURLOPT_URL, $url);
            curlsetopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($httpCode>=400){
                trigger_error('API Call error', E_USER_WARNING);
                return;
            }
        $xml = simplexml_load_string($res);
        $this->id = strval($xml->entry->id);
        if(isset($xml->entry->name)){
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

    public function getMarketStatus(){
        return $this->marketStatus;
    }

    function getMolecules(){
        return $this->molecules;
    }

    protected function getClassifications(){
        return $this->classifications;}
}

$product = new Product(5485);
$product->setId(5485);
echo "<b>Name</b> : ".$product->getNom()."<br/>";
echo "<b>Status de commercialisation</b> : ".$product->getMarketStatus()."<br/>";