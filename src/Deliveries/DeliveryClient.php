<?php

declare(strict_types=1);

namespace Bosta\Deliveries;

use Bosta\Bosta;
use Bosta\Utils\Receiver;
use Bosta\Utils\DropOffAddress;
use Bosta\Utils\Specs;

class DeliveryClient
{
    /**
     * Create DeliveryClient Instance
     *
     * @param \Bosta\Bosta $apiClient
     */
    public function __construct(Bosta $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Create Delivery
     *
     * @param int $type
     * @param \Bosta\Utils\DropOffAddress $dropOffAddress
     * @param \Bosta\Utils\Receiver $receiver
     * @param string $notes
     * @param int $cod
     * @param int $businessReference
     * @param \Bosta\Utils\Specs $Specs
     * @param int $webhookUrl
     * @return \stdClass
     */
    public function create(
        int $type,
        DropOffAddress $dropOffAddress,
        Receiver $receiver,
        $notes,
        int $cod,
        $businessReference = 0,
        Specs $Specs,
        $webhookUrl = 0
    ): \stdClass {
        try {
            $path = 'deliveries';

            $body = new \stdClass();
            $body->type = $type;
            $body->notes = $notes;

            $body->dropOffAddress = $dropOffAddress->dropOffAddress;
            $body->receiver = $receiver->receiver;

            if ($webhookUrl) {
                $body->webhookUrl = $webhookUrl;
            }
            if ($businessReference) {
                $body->businessReference = $businessReference;
            }

            if ($Specs) {

                if ($Specs->specs->packageDetails) {
                    $body->specs  = $Specs->specs;
                    // debug($Specs->specs->packageDetails);
                }
            }

            if ($cod && $cod != 0) {
                $body->cod = $cod;
            }

            $response = $this->apiClient->send('POST', $path, $body, '');

            if ($response->success === true) {
                return $response->data;
            } elseif (!isset($response->success) || $response->success === false) {
                throw new \Exception($response->message);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Update Delivery
     *
     * @param string $deliveryId
     * @param \Bosta\Utils\DropOffAddress $dropOffAddress
     * @param \Bosta\Utils\Receiver $receiver
     * @param string $notes
     * @param int $cod
     * @return string
     */
    public function update(
        $deliveryId,
        DropOffAddress $dropOffAddress,
        Receiver $receiver,
        $notes,
        int $cod
    ) {
        try {
            $path = 'deliveries/' . $deliveryId;

            $body = new \stdClass();
            $body->notes = $notes;

            $body->dropOffAddress = $dropOffAddress->dropOffAddress;
            $body->receiver = $receiver->receiver;

            if ($cod && $cod != 0) {
                $body->cod = $cod;
            }

            $response = $this->apiClient->send('PUT', $path, $body, '');

            if ($response->success === true) {
                return $response->message;
            } elseif (!isset($response->success) || $response->success === false) {
                throw new \Exception($response->message);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Delete Delivery
     *
     * @param string $deliveryId
     * @return void
     */
    public function delete(string $deliveryId)
    {
        try {
            $path = 'deliveries/' . $deliveryId;
            $response = $this->apiClient->send('DELETE', $path, new \stdClass, '');

            if ($response->success === true) {
                return $response->message;
            } elseif (!isset($response->success) || $response->success === false) {
                throw new \Exception($response->message);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * List Deliveries
     *
     * @param int $pageNumber
     * @param int $pageLimit
     * @return \stdClass
     */
    public function list(int $pageNumber = 0, int $pageLimit = 50): \stdClass
    {
        try {
            $path = 'deliveries?pageNumber=' . $pageNumber . '&pageLimit=' . $pageLimit;
            $response = $this->apiClient->send('GET', $path, new \stdClass, '');

            if ($response->success === true) {
                return $response->data;
            } elseif (!isset($response->success) || $response->success === false) {
                throw new \Exception($response->message);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * get Delivery
     *
     * @param string $deliveryId
     * @return \stdClass
     */
    public function get(string $deliveryId): \stdClass
    {
        try {
            $path = 'deliveries/' . $deliveryId;
            $response = $this->apiClient->send('GET', $path, new \stdClass, '');

            if ($response->success === true) {
                return $response->data;
            } elseif (!isset($response->success) || $response->success === false) {
                throw new \Exception($response->message);
            }
        } catch (Exception $e) {
            return $e;
        }
    }


    /**
     * get Invoice
     *
     * @param string $deliveryId
     * @return \stdClass
     */
    public function getInvoice(string $deliveryId = 'KjEcA2F3wJWo2t8vd')
    {
        try {
            // $deliveryId = 'KjEcA2F3wJWo2t8vd';
            $path = '/deliveries/awb/' . $deliveryId;
            $response = $this->apiClient->send('GET', $path, new \stdClass, '');

            if ($response->success === true) {
                return $response->data->data;
            } elseif (!isset($response->success) || $response->success === false) {
                throw new \Exception($response->message);
            }
        } catch (Exception $e) {
            return $e;
        }
    }
}
