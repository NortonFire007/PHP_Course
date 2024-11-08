<?php

class MyNovaPoshtaAPIRequester
{
    private $apiKey;
    private $url;

    public function __construct()
    {
        $this->apiKey = getenv('NOVA_POSHTA_API_KEY');
        $this->url = "https://api.novaposhta.ua/v2.0/json/";
    }

    public function getCities($findByString)
    {
        $data = [
            "apiKey" => $this->apiKey,
            "modelName" => "AddressGeneral",
            "calledMethod" => "getCities",
            "methodProperties" => [
                "FindByString" => $findByString,
                "Page" => "1",
                "Limit" => "20",
                "Language" => "UA"
            ]
        ];

        return $this->sendRequest($data);
    }

    public function getWarehouses($cityRef, $typeOfWarehouseRef, $weight)
    {
        $data = [
            "apiKey" => $this->apiKey,
            "modelName" => "AddressGeneral",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                "CityRef" => $cityRef,
                "TypeOfWarehouseRef" => $typeOfWarehouseRef,
                "Language" => "UA"
            ]
        ];

        $response = $this->sendRequest($data);

        if ($response['success']) {
            return array_filter($response['data'], function ($warehouse) use ($weight) {
                return isset($warehouse['TotalMaxWeightAllowed']) && (float)$warehouse['TotalMaxWeightAllowed'] >= (float)$weight;
            });
        }

        return [];
    }

    private function sendRequest($data)
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            return [
                'success' => false,
                'message' => "cURL Error: $errorMessage"
            ];
        }

        curl_close($ch);
        return json_decode($response, true);
    }
}
