<?php

declare(strict_types=1);

namespace App\Service\OrderPriceCalculator;

class OrderPriceCalculatorCollector
{
    /**
     * @var OrderPriceCalculatorInterface[]
     */
    private $priceCalculators = [];

    /**
     * @param OrderPriceCalculatorInterface[] $priceCalculators
     */
    public function __construct(array $priceCalculators)
    {
        $this->priceCalculators = $priceCalculators;
    }

    public function calculate(float $price): float
    {
        foreach ($this->priceCalculators as $priceCalculator) {
            $price = $priceCalculator->calculate($price);
        }

        return $price;
    }
}
