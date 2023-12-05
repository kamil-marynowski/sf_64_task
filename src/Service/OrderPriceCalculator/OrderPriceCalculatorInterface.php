<?php

declare(strict_types=1);

namespace App\Service\OrderPriceCalculator;

interface OrderPriceCalculatorInterface
{
    public function calculate(float $price): float;
}