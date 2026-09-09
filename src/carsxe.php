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

    private function post(string $endpoint, array $body): array
    {
        $url = $this->buildUrl($endpoint, []);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode($body),
            ],
        ]);

        $response = file_get_contents($url, false, $context);

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

    // Required: vin
    // Optional: state (US state code), mileage (numeric), condition (excellent|clean|average|rough)
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

    // Required: year, make, model
    public function recallsYmm(array $params): array
    {
        return $this->get('v1/recalls-ymm', $params);
    }

    // Provide at least one of: vins (array), csv, csvUrl
    // Optional: webhookUrl
    public function submitBulkRecallBatch(array $params): array
    {
        return $this->post('v1/recalls-batch/submit', $params);
    }

    // Required: batchId
    public function getBulkRecallBatchStatus(array $params): array
    {
        return $this->get('v1/recalls-batch/status', $params);
    }

    // Required: batchId
    public function getBulkRecallBatchResults(array $params): array
    {
        return $this->get('v1/recalls-batch/results', $params);
    }

    // Required: batchId
    public function getBulkRecallBatchDownloadUrl(array $params): string
    {
        return $this->buildUrl('v1/recalls-batch/download', $params);
    }

    // Required: batchId — returns CSV text
    public function downloadBulkRecallBatch(array $params): string
    {
        $url = $this->getBulkRecallBatchDownloadUrl($params);
        $response = file_get_contents($url);

        if ($response === false) {
            throw new \Exception("Failed to fetch API response from $url");
        }

        return $response;
    }

    // Optional: dimension, year, make, model
    public function ymmOptions(array $params): array
    {
        return $this->get('v1/ymm-options', $params);
    }

    // Required: vin
    // Optional: include
    public function ownershipVin(array $params): array
    {
        return $this->get('v1/ownership/vin', $params);
    }

    // Required: first_name, last_name, address, zip
    // Optional: include
    public function ownershipPerson(array $params): array
    {
        return $this->get('v1/ownership/person', $params);
    }

    // Required: address, zip
    // Optional: include, variant
    public function ownershipAddress(array $params): array
    {
        return $this->get('v1/ownership/address', $params);
    }

    // Required: zip
    // Optional: gender, min_age, max_age, income, page, limit, include, variant
    public function ownershipZip(array $params): array
    {
        return $this->get('v1/ownership/zip', $params);
    }
}