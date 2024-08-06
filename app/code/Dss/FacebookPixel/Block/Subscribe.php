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
namespace Dss\FacebookPixel\Block;

use Dss\FacebookPixel\Model\SessionFactory;
use Magento\Customer\CustomerData\SectionSourceInterface;

class Subscribe implements SectionSourceInterface
{
    /**
     * Subscribe constructor.
     * @param \Dss\FacebookPixel\Model\SessionFactory $fbPixelSession
     */
    public function __construct(
        protected SessionFactory $fbPixelSession
    ) {
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getSectionData(): array
    {
        $data = [
            'events' => []
        ];

        if ($this->fbPixelSession->create()->hasAddSubscribe()) {
            $data['events'][] = [
                'eventName' => 'Subscribe',
                'eventAdditional' => $this->fbPixelSession->create()->getAddSubscribe()
            ];
        }
        return $data;
    }
}
