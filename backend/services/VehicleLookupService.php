<?php

class VehicleLookupService
{
    private string $apiUrl = 'https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMake/';

    public function getModelsByMake(string $make): array
    {
        $make = trim($make);

        if ($make === '') {
            throw new InvalidArgumentException('Vehicle make is required.');
        }

        $url = $this->apiUrl . rawurlencode($make) . '?format=json';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($response === false || $error !== '') {
            error_log('Vehicle API connection error: ' . $error);
            throw new RuntimeException('Vehicle information service is currently unavailable.');
        }

        if ($statusCode !== 200) {
            error_log('Vehicle API returned HTTP status: ' . $statusCode);
            throw new RuntimeException('Vehicle information service returned an error.');
        }

        $data = json_decode($response, true);

        if (!is_array($data) || !isset($data['Results'])) {
            error_log('Vehicle API returned an invalid response.');
            throw new RuntimeException('Invalid response from vehicle information service.');
        }

        return $data['Results'];
    }
}
