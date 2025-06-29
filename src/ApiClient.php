<?php

// In the context of the exercice, this is certainly overkill, but in general it's probably better to further separate concerns, and to have an ApiClient to handle all ApiCall, so we can re-use it for all kind of ApiCall without having to worry about the logic every time
class ApiClient
{
    private array $defaultHeaders = [];

    public function __construct(array $defaultHeaders = [])
    {
        $this->defaultHeaders = $defaultHeaders;
    }

    public function get(string $url, array $headers = []): string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array_merge($this->defaultHeaders, $headers),
        ]);
        $res = curl_exec($ch);

        if ($res === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \RuntimeException("cURL error: $error");
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            throw new \RuntimeException("API error: HTTP $httpCode");
        }

        return $res;
    }
}