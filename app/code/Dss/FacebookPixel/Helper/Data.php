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
namespace Dss\FacebookPixel\Helper;

use Magento\Tax\Model\Config;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Json\EncoderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Catalog\Helper\Data as CatalogHelper;

class Data extends AbstractHelper
{
    /**
     * The flag of Tax Tax display
     *
     * @var null|int
     */
    protected $taxDisplayFlag = null;

    /**
     * The flag of Tax catalog
     *
     * @var null|int
     */
    protected $taxCatalogFlag = null;

    /**
     * Store object
     *
     * @var null|\Magento\Store\Model\Store
     */
    protected $store = null;

    /**
     * The id of the Store
     *
     * @var null|int
     */
    protected $storeId = null;

    /**
     * The code of the Base currency
     *
     * @var null|string
     */
    protected $baseCurrencyCode = null;

    /**
     * The code of the current currency
     *
     * @var null|string
     */
    protected $currentCurrencyCode = null;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Tax\Model\Config $taxConfig
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Catalog\Helper\Data $catalogHelper
     */
    public function __construct(
        protected Context $context,
        protected StoreManagerInterface $storeManager,
        protected Config $taxConfig,
        protected EncoderInterface $jsonEncoder,
        protected CatalogHelper $catalogHelper
    ) {
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * Serialized Value
     *
     * @param array $data
     * @return false|string
     */
    public function serializes($data): bool|string
    {
        $result = $this->jsonEncoder->encode($data);
        if (false === $result) {
            throw new \InvalidArgumentException('Unable to serialize value.');
        }
        return $result;
    }

    /**
     * Is tax Config
     *
     * @return \Magento\Tax\Model\Config
     */
    public function isTaxConfig(): Config
    {
        return $this->taxConfig;
    }

    /**
     * List of page disable
     *
     * @return array
     */
    public function listPageDisable(): array
    {
        $list = $this->returnDisablePage();
        if ($list) {
            return explode(',', $list);
        } else {
            return [];
        }
    }

    /**
     * Based on provided configuration path returns configuration value.
     *
     * @param string $configPath
     * @return string
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Pixel Id
     *
     * @param mixed $scope
     * @return string
     */
    public function returnPixelId($scope = null)
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/general/pixel_id',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Return Disable pages
     *
     * @param mixed $scope
     * @return mixed
     */
    public function returnDisablePage($scope = null)
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/disable_code',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is Product view
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isProductView($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/product_view',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is Category View
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isCategoryView($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/category_view',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is Initiate checkout
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isInitiateCheckout($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/initiate_checkout',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is Purchase
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isPurchase($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/purchase',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is AddToWishlist
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isAddToWishList($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/add_to_wishlist',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is AddTocart
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isAddToCart($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/add_to_cart',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is Registration
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isRegistration($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/registration',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is Subscribe
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isSubscribe($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/subscribe',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is search
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isSearch($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'dss_facebook_pixel/event_tracking/search',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Is Include Tax
     *
     * @param mixed $scope
     * @return bool|string
     */
    public function isIncludeTax($scope = null): bool|string
    {
        return $this->scopeConfig->getValue(
            'tax/calculation/price_includes_tax',
            ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Add slashes to string and prepares string for javascript.
     *
     * @param string $str
     * @return string
     */
    public function escapeSingleQuotes($str): string
    {
        return str_replace("'", "\'", $str);
    }

    /**
     * Get Currency code
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrencyCode()
    {
        return $this->storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    /**
     * Get Pixel Html
     *
     * @param array $data
     * @return string
     */
    public function getPixelHtml($data = false)
    {
        $json = 404;
        if ($data) {
            $json =$this->serializes($data);
        }

        return $json;
    }

    /**
     * Get Product price
     *
     * @param mixed $product
     * @return mixed|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductPrice($product)
    {
        switch ($product->getTypeId()) {
            case 'bundle':
                $price =  $this->getBundleProductPrice($product);
                break;
            case 'configurable':
                $price = $this->getConfigurableProductPrice($product);
                break;
            case 'grouped':
                $price = $this->getGroupedProductPrice($product);
                break;
            default:
                $price = $this->getFinalPrice($product);
        }

        return $price;
    }

    /**
     * Returns bundle product price.
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getBundleProductPrice($product)
    {
        $includeTax = (bool) $this->getDisplayTaxFlag();

        return $this->getFinalPrice(
            $product,
            $product->getPriceModel()->getTotalPrices(
                $product,
                'min',
                $includeTax,
                1
            )
        );
    }

    /**
     * Get Configurable product price
     *
     * @param  \Magento\Catalog\Model\Product $product
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getConfigurableProductPrice($product)
    {
        if ($product->getFinalPrice() === 0) {
            $simpleCollection = $product->getTypeInstance()
                ->getUsedProducts($product);

            foreach ($simpleCollection as $simpleProduct) {
                if ($simpleProduct->getPrice() > 0) {
                    return $this->getFinalPrice($simpleProduct);
                }
            }
        }

        return $this->getFinalPrice($product);
    }

    /**
     * Get group product price
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getGroupedProductPrice($product)
    {
        $assocProducts = $product->getTypeInstance(true)
            ->getAssociatedProductCollection($product)
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('tax_class_id')
            ->addAttributeToSelect('tax_percent');

        $minPrice = INF;
        foreach ($assocProducts as $assocProduct) {
            $minPrice = min($minPrice, $this->getFinalPrice($assocProduct));
        }

        return $minPrice;
    }

    /**
     * Returns final price.
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $price
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getFinalPrice($product, $price = null)
    {
        $price = $this->resultPriceFinal($product, $price);

        $productType = $product->getTypeId();
        //  Apply tax if needed
        // Simple, Virtual, Downloadable products price is without tax
        // Grouped products have associated products without tax
        // Bundle products price already have tax included/excluded
        // Configurable products price already have tax included/excluded
        if ($productType != 'configurable' && $productType != 'bundle') {
            // If display tax flag is on and catalog tax flag is off
            if ($this->getDisplayTaxFlag() && !$this->getCatalogTaxFlag()) {
                $price = $this->catalogHelper->getTaxPrice(
                    $product,
                    $price,
                    true,
                    null,
                    null,
                    null,
                    $this->getStoreId(),
                    false,
                    false
                );
            }
        }

        // Case when catalog prices are with tax but display tax is set to
        // to exclude tax. Applies for all products except for bundle
        if ($productType != 'bundle') {
            // If display tax flag is off and catalog tax flag is on
            if (!$this->getDisplayTaxFlag() && $this->getCatalogTaxFlag()) {
                $price = $this->catalogHelper->getTaxPrice(
                    $product,
                    $price,
                    false,
                    null,
                    null,
                    null,
                    $this->getStoreId(),
                    true,
                    false
                );
            }
        }

        return $price;
    }

    /**
     * Result Final Price
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param float|int $price
     * @return float
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function resultPriceFinal($product, $price)
    {
        if ($price === null) {
            $price = $product->getFinalPrice();
        }

        if ($price === null) {
            $price = $product->getData('special_price');
        }
        $productType = $product->getTypeId();
        // 1. Convert to current currency if needed

        // Convert price if base and current currency are not the same
        // Except for configurable products they already have currency converted
        if (($this->getBaseCurrencyCode() !== $this->getCurrentCurrencyCode())
            && $productType != 'configurable'
        ) {
            // Convert to from base currency to current currency
            $price = $this->getStore()->getBaseCurrency()
                ->convert($price, $this->getCurrentCurrencyCode());
        }
        return $price;
    }

    /**
     * Returns flag based on "Stores > Configuration > Sales > Tax
     * > Price Display Settings > Display Product Prices In Catalog"
     * Returns 0 or 1 instead of 1, 2, 3.
     *
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getDisplayTaxFlag()
    {
        if ($this->taxDisplayFlag === null) {
            // Tax Display
            // 1 - excluding tax
            // 2 - including tax
            // 3 - including and excluding tax
            $flag = $this->isTaxConfig()->getPriceDisplayType($this->getStoreId());

            // 0 means price excluding tax, 1 means price including tax
            if ($flag == 1) {
                $this->taxDisplayFlag = 0;
            } else {
                $this->taxDisplayFlag = 1;
            }
        }

        return $this->taxDisplayFlag;
    }

    /**
     * Returns Stores > Configuration > Sales > Tax > Calculation Settings
     * > Catalog Prices configuration value
     *
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCatalogTaxFlag()
    {
        // Are catalog product prices with tax included or excluded?
        if ($this->taxCatalogFlag === null) {
            $this->taxCatalogFlag = (int) $this->isIncludeTax();
        }

        // 0 means excluded, 1 means included
        return $this->taxCatalogFlag;
    }

    /**
     * Get Store
     *
     * @return \Magento\Store\Api\Data\StoreInterface|\Magento\Store\Model\Store|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStore()
    {
        if ($this->store === null) {
            $this->store = $this->storeManager->getStore();
        }

        return $this->store;
    }

    /**
     * Get storeid
     *
     * @return int|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        if ($this->storeId === null) {
            $this->storeId = $this->getStore()->getId();
        }

        return $this->storeId;
    }

    /**
     * Return base currency code
     *
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseCurrencyCode(): string|null
    {
        if ($this->baseCurrencyCode === null) {
            $this->baseCurrencyCode = strtoupper(
                $this->getStore()->getBaseCurrencyCode()
            );
        }

        return $this->baseCurrencyCode;
    }

    /**
     * Return current currency code
     *
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentCurrencyCode(): string|null
    {
        if ($this->currentCurrencyCode === null) {
            $this->currentCurrencyCode = strtoupper(
                $this->getStore()->getCurrentCurrencyCode()
            );
        }

        return $this->currentCurrencyCode;
    }
}
