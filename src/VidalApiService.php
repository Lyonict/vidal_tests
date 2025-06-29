<?php

// Not sure if there's a better way to handle errors for a curl call...

class VidalApiService
{
    public function apiCall(Product $product): void
    {
        $url = "https://api.vidal.fr/rest/api/product/{$product->getId()}";
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
            // We would also add the api token here
        ]);
        $res = curl_exec($ch);

        if (!$res) {
            $error = curl_error($ch);
            curl_close($ch);
            trigger_error('Curl error', E_USER_WARNING);
            return;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            trigger_error('API Call error', E_USER_WARNING);
            return;
        }
        $xml = simplexml_load_string($res);
        if ($xml === false) {
            trigger_error('Invalid XML response', E_USER_WARNING);
            return;
        }

        $product->setId(strval($xml->entry->id));
        $product->setName(isset($xml->entry->name) ? (string) $xml->entry->name : '');
        $product->setMarketStatus((string) $xml->entry->marketStatus);
        $product->setMolecules((array) $xml->entry->molecules);
        $product->setClassifications((array) $xml->entry->classifications);
    }
}