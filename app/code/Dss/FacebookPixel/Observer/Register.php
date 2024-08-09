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

class Register implements ObserverInterface
{
    /**
     * Register constructor.
     * @param \Dss\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Dss\FacebookPixel\Helper\Data $fbPixelHelper
     */
    public function __construct(
        protected SessionFactory $fbPixelSession,
        protected Data $fbPixelHelper
    ) {
    }

    /**
     * Execute for register customer event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer): bool
    {
        $customer = $observer->getEvent()->getCustomer();
        if (!$this->fbPixelHelper->isRegistration()
            || !$customer
        ) {
            return true;
        }
        $data = [
            'customer_id' => $customer->getId(),
            'email' => $customer->getEmail(),
            'fn' => $customer->getFirstName(),
            'ln' => $customer->getLastName()
        ];

        $this->fbPixelSession->create()->setRegister($data);

        return true;
    }
}
