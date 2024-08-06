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

class Subcribe implements ObserverInterface
{
    /**
     * Subcribe constructor.
     * @param \Dss\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Dss\FacebookPixel\Helper\Data $helper
     */
    public function __construct(
        protected SessionFactory $fbPixelSession,
        protected Data $helper
    ) {
    }

    /**
     * Execute for subscribe
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer): bool
    {
        $email = $observer->getEvent()->getSubscriber()->getSubscriberEmail();
        $subscribeId =$observer->getEvent()->getSubscriber()->getSubscriberId();
        if (!$this->helper->isSubscribe() || !$email) {
            return true;
        }

        $data = [
            'id' => $subscribeId,
            'email' => $observer->getEvent()->getSubscriber()->getSubscriberEmail()
        ];

        $this->fbPixelSession->create()->setAddSubscribe($data);

        return true;
    }
}
