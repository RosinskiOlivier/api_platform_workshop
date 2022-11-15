<?php

namespace App\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Product;
use App\ProductDb;
use Symfony\Component\Uid\Uuid;

class ProductProvider implements ProviderInterface
{
    public function __construct(private ProductDb $productDb)
    {

    }

    /**
     * @param Operation $operation
     * @param array     $uriVariables
     * @param array     $context
     *
     * @return \Generator<Product>
     */
    public function provide(
        Operation $operation,
        array     $uriVariables = [],
        array     $context = []
    ): object|array|null {
        if (!isset($uriVariables['id'])) {
            return $this->productDb->getCollection();
        }

        return $this->productDb->get(Uuid::fromString($uriVariables['id']));
    }
}
