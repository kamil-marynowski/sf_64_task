<?php

declare(strict_types=1);

namespace App\Service\OrderPriceCalculator;

class OrderPriceGrossCalculator implements OrderPriceCalculatorInterface
{
    public function calculate(float $price): float
    {
        return $price * 1.23;
    }
}