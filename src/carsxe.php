<?php

namespace CarsxeDeveloper\Carsxe;

class Carsxe
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getApiBaseUrl(): string
    {
        return 'https://api.carsxe.com';
    }

    private function buildUrl(string $endpoint, array $params = []): string
    {
        // Ensure key and source are always included in the query
        $query = array_merge(
            ['key' => $this->getApiKey(), 'source' => 'php'],
            $params
        );

        // Build the URL with query params
        $queryString = http_build_query($query);
        return $this->getApiBaseUrl() . '/' . $endpoint . '?' . $queryString;
    }

    private function get(string $endpoint, array $params): array
    {
        $url = $this->buildUrl($endpoint, $params);
        $response = file_get_contents($url);

        if ($response === false) {
            throw new \Exception("Failed to fetch API response from $url");
        }

        return json_decode($response, true);
    }

    public function specs(array $params): array
    {
        return $this->get('specs', $params);
    }

    public function intVinDecoder(array $params): array
    {
        return $this->get('v1/international-vin-decoder', $params);
    }

    public function recalls(array $params): array
    {
        return $this->get('v1/recalls', $params);
    }

    public function plateDecoder(array $params): array
    {
        return $this->get('v2/platedecoder', $params);
    }

    public function images(array $params): array
    {
        return $this->get('images', $params);
    }

    public function marketValue(array $params): array
    {
        return $this->get('v2/marketvalue', $params);
    }

    public function history(array $params): array
    {
        return $this->get('history', $params);
    }

    public function plateImageRecognition(array $params): array
    {
        $url = $this->buildUrl('platerecognition', []);
        $data = ['upload_url' => $params['upload_url']];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode($data),
            ],
        ]);

        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new \Exception("Failed to fetch API response from $url");
        }

        return json_decode($response, true);
    }

    public function vinOcr(array $params): array
    {
        $url = $this->buildUrl('v1/vinocr', []);
        $data = ['upload_url' => $params['upload_url']];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode($data),
            ],
        ]);

        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new \Exception("Failed to fetch API response from $url");
        }

        return json_decode($response, true);
    }

    public function yearMakeModel(array $params): array
    {
        return $this->get('v1/ymm', $params);
    }

    public function obdCodesDecoder(array $params): array
    {
        return $this->get('obdcodesdecoder', $params);
    }

    public function lienAndTheft(array $params): array
    {
        return $this->get('v1/lien-theft', $params);
    }
}