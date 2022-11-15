<?php

namespace App;

use App\ApiResource\Product;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

class ProductDb
{

    private $filename = __DIR__ . "/../var/Product.txt";

    public function __construct()
    {
    }

    /**
     * @return Product[]
     */
    public function getCollection(): iterable
    {
        $products = $this->getData();

        foreach($products as $product){
            yield $product;
        }
    }

    /**
     * @param Uuid|null $id
     *
     * @return array|Object|null
     */
    public function get(Uuid $id = null): array|Object|null
    {
        $products = $this->getData();

        return $products[(string)$id] ?? null;
    }

    public function save(Product $product): void
    {
        $productsData = $this->getData();
        $productsData [(string) $product->id] = $product;
        $productsData = serialize($productsData);

        file_put_contents($this->filename, $productsData);
    }

    public function delete(Product $product): void
    {

    }

    public function getData()
    {
        if(!file_exists($this->filename)){
            fopen($this->filename, 'w');
        }
        $file = file_get_contents($this->filename);

        return unserialize($file, ['allowed_classes' => [Product::class, UuidV4::class]]);
    }
}
