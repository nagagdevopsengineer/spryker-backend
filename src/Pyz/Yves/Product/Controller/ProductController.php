<?php

namespace Pyz\Yves\Product\Controller;

use SprykerEngine\Yves\Application\Controller\AbstractController;
use SprykerFeature\Shared\Product\Model\AbstractProductInterface;

class ProductController extends AbstractController
{

    /**
     * @param AbstractProductInterface $product
     *
     * @return array
     */
    public function detailAction(AbstractProductInterface $product)
    {
        return [
            'product' => $product,
            'category' => count($product->getCategory()) ? current($product->getCategory()) : null,
        ];
    }

}