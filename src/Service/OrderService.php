<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;

class OrderService
{
    /**
     * @return string
     */
    public function generateOrderNumber(): string
    {
        $orderNumber = 'N/2023/0001';

        return $orderNumber;
    }

    /**
     * @param Order $order
     * @return array
     */
    public function getClientOrderData(Order $order): array
    {
        return [
            'number'      => $order->getNumber(),
            'status'      => $order->getStatus(),
            'price_net'   => 100,
            'price_gross' => 123,
            'vat'         => 23
        ];
    }
}