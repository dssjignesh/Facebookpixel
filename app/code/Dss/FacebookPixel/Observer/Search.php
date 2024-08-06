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
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Search\Helper\Data as SearchHelper;

class Search implements ObserverInterface
{
    /**
     * Search constructor.
     * @param \Dss\FacebookPixel\Helper\Data $fbPixelHelper
     * @param \Magento\Search\Helper\Data $searchHelper
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Dss\FacebookPixel\Model\SessionFactory $fbPixelSession
     */
    public function __construct(
        protected Data $fbPixelHelper,
        protected SearchHelper $searchHelper,
        protected RequestInterface $request,
        protected SessionFactory $fbPixelSession
    ) {
    }

    /**
     * Execute for search event
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return boolean
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer): bool
    {
        $text = $this->searchHelper->getEscapedQueryText();
        if (!$text) {
            $text = $this->request->getParams();
            foreach ($this->request->getParams() as $key => $value) {
                $text[$key] = $value;
            }
        }
        if (!$this->fbPixelHelper->isSearch() || !$text) {
            return true;
        }

        $data = [
            'search_string' => $text
        ];
        $this->fbPixelSession->create()->setSearch($data);

        return true;
    }
}
