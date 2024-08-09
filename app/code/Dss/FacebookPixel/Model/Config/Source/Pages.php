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
namespace Dss\FacebookPixel\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Pages implements ArrayInterface
{
    /**
     * Options for disable page for admin configuration
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'cms_page', 'label' => 'Cms Page'],
            ['value' => 'account_page', 'label' => 'Account Page'],
            ['value' => 'registration_page', 'label' => 'Registration Page'],
            ['value' => 'checkout_page', 'label' => 'Checkout Page'],
            ['value' => 'success_page', 'label' => 'Success Page'],
            ['value' => 'search_page', 'label' => 'Search Page'],
            ['value' => 'advanced_search_page', 'label' => 'Advanced Search Page']
        ];
    }
}
