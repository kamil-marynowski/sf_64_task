<?php

declare(strict_types=1);

namespace App\Service\OrderPriceCalculator;

class OrderPriceVatCalculator implements OrderPriceCalculatorInterface
{
    public function calculate(float $price): float
    {
        return round($price * 0.23, 2);
    }
}