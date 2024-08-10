<?php

declare(strict_types=1);

/**
* Digit Software Solutions.
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
*
* @category  Dss
* @package   Dss_FacebookPixel
* @author    Extension Team
* @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
*/
namespace Dss\FacebookPixel\Observer;

use Dss\FacebookPixel\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Bundle\Model\Product\Type;
use Dss\FacebookPixel\Model\SessionFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class AddToCart implements ObserverInterface
{
    /**
     * AddToCart constructor.
     * @param \Dss\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Dss\FacebookPixel\Helper\Data $helper
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     */
    public function __construct(
        protected SessionFactory $fbPixelSession,
        protected Data $helper,
        protected ProductRepository $productRepository
    ) {
    }

    /**
     * Execute for addtocart product event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer): bool
    {
        $items = $observer->getItems();
        $typeConfi = Configurable::TYPE_CODE;
        if (!$this->helper->isAddToCart() || !$items) {
            return true;
        }
        $product = [
            'content_ids' => [],
            'value' => 0,
            'currency' => ""
        ];

        /** @var \Magento\Sales\Model\Order\Item $item */
        foreach ($items as $item) {
            if ($item->getProduct()->getTypeId() == $typeConfi) {
                continue;
            }
            if ($item->getParentItem()) {
                if ($item->getParentItem()->getProductType() == $typeConfi) {
                    $product['contents'][] = [
                        'id' => $item->getSku(),
                        'name' => $item->getName(),
                        'quantity' => $item->getParentItem()->getQtyToAdd()
                    ];
                    $product['value'] += $item->getProduct()->getFinalPrice() * $item->getParentItem()->getQtyToAdd();
                } else {
                    $product['contents'][] = [
                        'id' => $item->getSku(),
                        'name' => $item->getName(),
                        'quantity' => $item->getData('qty')
                    ];
                }
            } else {
                $product['contents'][] = [
                    'id' => $this->checkBundleSku($item),
                    'name' => $item->getName(),
                    'quantity' => $item->getQtyToAdd()
                ];
                $product['value'] += $item->getProduct()->getFinalPrice() * $item->getQtyToAdd();
            }
            $product['content_ids'][] = $this->checkBundleSku($item);
        }

        $data = [
            'content_type' => 'product',
            'content_ids' => $product['content_ids'],
            'contents' => $product['contents'],
            'currency' => $this->helper->getCurrencyCode(),
            'value' => $product['value']
        ];

        $this->fbPixelSession->create()->setAddToCart($data);

        return true;
    }

    /**
     * Check bundle sku
     *
     * @param mixed $item
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function checkBundleSku($item): string
    {
        $typeBundle = Type::TYPE_CODE;
        if ($item->getProductType() == $typeBundle) {
            $skuBundleProduct= $this->productRepository->getById($item->getProductId())->getSku();
            return $skuBundleProduct;
        }
        return $item->getSku();
    }
}
