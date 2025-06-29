<?php

// Not sure if there's a better way to handle errors for a curl call...
// Thinking on it, maybe VidalApiService should be inheriting ApiClient ?
// But maybe there's better practice...

require_once __DIR__ . '/ApiClient.php';
class VidalApiService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function fetchProduct(Product $product): void
    {
        $url = "https://api.vidal.fr/rest/api/product/{$product->getId()}";
        $response = $this->client->get($url);

        $xml = simplexml_load_string($response);
        if ($xml === false) {
            throw new \RuntimeException('Invalid XML response');
        }

        $product->setId(strval($xml->entry->id));
        $product->setName(isset($xml->entry->name) ? (string) $xml->entry->name : '');
        $product->setMarketStatus((string) $xml->entry->marketStatus);
        $product->setMolecules((array) $xml->entry->molecules);
        $product->setClassifications((array) $xml->entry->classifications);

        // Test data values, for verification purposes
        // $product->setId(strval(5485));
        // $product->setName("Bidule");
        // $product->setMarketStatus("Available");
        // $product->setMolecules(["foo", "bar"]);
        // $product->setClassifications(["Baz", "Buz"]);
    }
}