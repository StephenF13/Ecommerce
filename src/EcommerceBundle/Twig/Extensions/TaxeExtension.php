<?php

namespace EcommerceBundle\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TaxeExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [new TwigFilter('taxe', [$this, 'taxeFilter'])];
    }

    public function taxeFilter($priceHT, $taxe)
    {
        return round($priceHT / $taxe, 2);
    }
}