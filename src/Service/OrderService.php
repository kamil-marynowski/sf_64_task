<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use App\Service\OrderPriceCalculator\OrderPriceCalculatorCollector;
use App\Service\OrderPriceCalculator\OrderPriceGrossCalculator;
use App\Service\OrderPriceCalculator\OrderPriceVatCalculator;

class OrderService
{
    private OrderProductRepository $orderProductRepository;

    private OrderRepository $orderRepository;

    /**
     * @param OrderProductRepository $orderProductRepository
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        OrderProductRepository $orderProductRepository,
        OrderRepository $orderRepository
    )
    {
        $this->orderProductRepository = $orderProductRepository;
        $this->orderRepository        = $orderRepository;
    }

    /**
     * @return string
     */
    public function generateOrderNumber(): string
    {
        $year = (new \DateTimeImmutable())->format('Y');
        $ordersCount = $this->orderRepository->getOrdersCount();

        return 'N/' . $year .'/' . $ordersCount + 1;
    }

    /**
     * @param Order $order
     * @return array
     */
    public function getClientOrderData(Order $order): array
    {
        $productsCount = $this->orderProductRepository->getProductCountByOrderId($order->getId());

        $priceNetSum = $this->getOrderPriceNetSum($order);

        $orderGrossPriceSumCalculator = new OrderPriceCalculatorCollector([new OrderPriceGrossCalculator()]);
        $priceGrossSum = $orderGrossPriceSumCalculator->calculate($priceNetSum);

        $orderVatSumCalculator = new OrderPriceCalculatorCollector([new OrderPriceVatCalculator()]);
        $vatSum = $orderVatSumCalculator->calculate($priceNetSum);


        return [
            'number'         => $order->getNumber(),
            'status'         => $order->getStatus(),
            'products_count' => $productsCount,
            'price_net'      => $priceNetSum,
            'price_gross'    => $priceGrossSum,
            'vat'            => $vatSum
        ];
    }

    /**
     * @param Order $order
     * @return float
     */
    private function getOrderPriceNetSum(Order $order): float
    {
        $priceNetSum = 0.00;
        $orderProducts = $order->getOrderProducts();

        /** @var OrderProduct $orderProduct */
        foreach ($orderProducts as $orderProduct) {
            $priceNetSum += $orderProduct->getProduct()->getPriceNet() * $orderProduct->getCount();
        }

        return $priceNetSum;
    }
}