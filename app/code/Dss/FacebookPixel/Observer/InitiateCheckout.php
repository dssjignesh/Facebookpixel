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
use Dss\FacebookPixel\Model\SessionFactory as FbPixelSession;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Pricing\Helper\Data as DataPrice;
use Magento\Checkout\Model\SessionFactory;

class InitiateCheckout implements ObserverInterface
{
    /**
     * InitiateCheckout constructor.
     * @param \Magento\Checkout\Model\SessionFactory $checkoutSession
     * @param \Dss\FacebookPixel\Helper\Data $helper
     * @param \Dss\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Magento\Framework\Pricing\Helper\Data $dataPrice
     */
    public function __construct(
        protected SessionFactory $checkoutSession,
        protected Data $helper,
        protected FbPixelSession $fbPixelSession,
        protected DataPrice $dataPrice
    ) {
    }

    /**
     * Execute for Checkout event initate
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(Observer $observer): bool
    {
        if (!$this->helper->isInitiateCheckout()) {
            return true;
        }
        $checkout = $this->checkoutSession->create();
        if (empty($checkout->getQuote()->getAllVisibleItems())) {
            return true;
        }

        $product = [
            'content_ids' => [],
            'contents' => [],
            'value' => "",
            'currency' => ""
        ];
        $items = $checkout->getQuote()->getAllVisibleItems();
        foreach ($items as $item) {
            $product['contents'][] = [
                'id' => $item->getSku(),
                'name' => $item->getName(),
                'quantity' => $item->getQty(),
                'item_price' => $this->dataPrice->currency($item->getPrice(), false, false)
            ];
            $product['content_ids'][] = $item->getSku();
        }
        $data = [
            'content_ids' => $product['content_ids'],
            'contents' => $product['contents'],
            'content_type' => 'product',
            'value' => $checkout->getQuote()->getGrandTotal(),
            'currency' => $this->helper->getCurrencyCode(),
        ];
        $this->fbPixelSession->create()->setInitiateCheckout($data);

        return true;
    }
}
