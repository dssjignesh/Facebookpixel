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
use Dss\FacebookPixel\Model\SessionFactory;
use Magento\Framework\Event\ObserverInterface;

class WishlistAddProduct implements ObserverInterface
{
    /**
     * WishlistAddProduct constructor.
     * @param \Dss\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Dss\FacebookPixel\Helper\Data $helper
     */
    public function __construct(
        protected SessionFactory $fbPixelSession,
        protected Data $helper
    ) {
    }

    /**
     * Execute for add product to wishlist event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer): bool
    {
        $product = $observer->getItem()->getProduct();
        /** @var \Magento\Catalog\Model\Product $product */
        if (!$this->helper->isAddToWishList() || !$product) {
            return true;
        }
        
        $data = [
            'content_type' => 'product',
            'content_ids' => $product->getSku(),
            'content_name' => $product->getName(),
            'currency' => $this->helper->getCurrencyCode()
        ];

        $this->fbPixelSession->create()->setAddToWishlist($data);
        
        return true;
    }
}
