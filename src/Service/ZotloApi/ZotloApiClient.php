<?php


namespace App\Service\ZotloApi;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ZotloApiClient
{
//    private HttpClientInterface $client;
//
//    public function __construct(HttpClientInterface $client)
//    {
//        $this->client = $client;
//    }

    const BASE_URL = "https://test-api.zotlo.com/v1/";
    const ACCESS_KEY = "3947a9bdb6c565258844deba5e0e25cb5975bf82eded1ea1bd";
    const ACCESS_SECRET = "af04af0196348d9381c1afa67dabc2121ede34b29496110e8307b97382dd93b1d2242263a8b7b47d";
    const PACKAGE = "zotlo.premium";
    const APPLICATION_ID = 128;

    public function request($endpoint, $method, $data = [])
    {

//        $response = $this->client->request(
//            'POST',
//            self::BASE_URL . $endpoint,
//            [
//                'body' => json_encode($data),
//                'headers' => [
//                    'Content-Type' => "application/json",
//                    'AccessKey' => self::ACCESS_KEY,
//                    'AccessSecret' => self::ACCESS_SECRET,
//                    'ApplicationId' => self::APPLICATION_ID,
//                    'Language' => 'en'
//                ]
//            ]
//        );

        $curl = curl_init();
        $curlConfigs = [
            CURLOPT_URL => self::BASE_URL . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                "AccessKey: " . self::ACCESS_KEY,
                "AccessSecret: " . self::ACCESS_SECRET,
                "Content-Type: application/json",
                "ApplicationId: " . self::APPLICATION_ID,
                "Language: en"
            ],
        ];

        if (!empty($data)) {
            $curlConfigs[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($curl, $curlConfigs);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

}