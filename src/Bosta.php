<?php

declare(strict_types=1);

namespace Bosta;

use Bosta\Zones\ZoneClient;
use Bosta\Cities\CityClient;
use Bosta\Deliveries\DeliveryClient;
use Bosta\PickupRequests\PickupClient;
use Bosta\PickupLocations\PickupLocationClient;

class Bosta
{
    /**
     * Create Bosta Instance
     *
     * @param string $API_KEY
     * @param string $BASE_URL
     */
    public function __construct(string $API_KEY, string $BASE_URL = 'https://app.bosta.co')
    {
        $this->BASE_URL = $BASE_URL . '/api/v1/';
        $this->API_KEY = $API_KEY;
        $this->pickup = new PickupClient($this);
        $this->pickupLocation = new PickupLocationClient($this);
        $this->delivery = new DeliveryClient($this);
        $this->city = new CityClient($this);
        $this->zone = new ZoneClient($this);
    }

    /**
     * Send Api Request
     *
     * @param string $method
     * @param string $path
     * @param object $body
     * @param string $headers
     * @return void
     */
    public function send(string $method, string $path, object $body, string $headers)
    {
        $url = $this->BASE_URL . $path;
        $curl = curl_init($url);
        if ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        // die;
        $testBody = '{
            "type": 10,
            "specs": {
             
              "packageDetails": {
                "itemsCount": 5
              }
            },
            "returnSpecs": {
              "size": "SMALL",
              "packageDetails": {
                "itemsCount": 5,
                "document": "Document",
                "description": "Desc."
              }
            },
            "notes": "Welcome Note",
            "cod": 50,
            "dropOffAddress": {
              "district": "Maadi",
              "firstLine": "Maadi",
              "secondLine": "Nasr  City",
              "buildingNumber": "123",
              "floor": "4",
              "apartment": "2",
              "isWorkAddress": true,
              "zone": "Maadi & Muqattam",
              "cityCode": "EG-01"
            },
            "returnAddress": {
              "district": "Maadi",
              "firstLine": "Maadi",
              "secondLine": "Nasr  City",
              "buildingNumber": "123",
              "floor": "4",
              "apartment": "2",
              "isWorkAddress": true,
              "zone": "Maadi & Muqattam",
              "cityCode": "EG-01"
            },
            "allowToOpenPackage": true,
            "businessReference": "43535252",
            "receiver": {
              "firstName": "Sasuke",
              "lastName": "Uchiha",
              "phone": "01065685435",
              "email": "ahmed@ahmed.com"
            }
          }';




        if ($method === 'POST' || $method === 'PUT') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
            // curl_setopt($curl, CURLOPT_POSTFIELDS, $testBody);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Content-Type: application/json",
                'authorization:' . $this->API_KEY,
                'X-Requested-By: php-sdk',
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);

        // echo "<pre>";
        // print_r(json_encode($body));
        // print_r($testBody);
        // print_r(json_decode($response));

        // die;
        return json_decode($response);
    }
}
