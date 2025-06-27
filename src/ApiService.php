<?php

class ApiService
{
    public function apiCall(Product $product): void
    {
        $url = "https://api.vidal.fr/rest/api/product/{$product->getId()}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            trigger_error('API Call error', E_USER_WARNING);
            return;
        }

        $xml = simplexml_load_string($res);
        $product->setId(strval($xml->entry->id));
        $product->setName(isset($xml->entry->name) ? (string) $xml->entry->name : '');
        $product->setMarketStatus((string) $xml->entry->marketStatus);
        $product->setMolecules((array) $xml->entry->molecules);
        $product->setClassifications((array) $xml->entry->classifications);
    }
}