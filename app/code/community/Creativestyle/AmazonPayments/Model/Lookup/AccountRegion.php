<?php
/**
 * This file is part of the official Amazon Pay and Login with Amazon extension
 * for Magento 1.x
 *
 * (c) 2016 - 2017 creativestyle GmbH. All Rights reserved
 *
 * Distribution of the derivatives reusing, transforming or being built upon
 * this software, is not allowed without explicit written permission granted
 * by creativestyle GmbH
 *
 * @category   Creativestyle
 * @package    Creativestyle_AmazonPayments
 * @copyright  2016 - 2017 creativestyle GmbH
 * @author     Marek Zabrowarny <ticket@creativestyle.de>
 */
class Creativestyle_AmazonPayments_Model_Lookup_AccountRegion extends Creativestyle_AmazonPayments_Model_Lookup_Abstract
{
    /**
     * Returns Amazon Pay config model instance
     *
     * @return Creativestyle_AmazonPayments_Model_Config
     */
    protected function _getConfig()
    {
        return Mage::getSingleton('amazonpayments/config');
    }

    protected function _getRegions()
    {
        return $this->_getConfig()->getGlobalConfigData('account_regions');
    }

    /**
     * @return bool
     */
    protected function _isExtendedConfigEnabled()
    {
        return $this->_getConfig()->isExtendedConfigEnabled();
    }

    public function toOptionArray()
    {
        if (null === $this->_options) {
            $this->_options = array();
            foreach ($this->_getRegions() as $region => $regionName) {
                $this->_options[] = array(
                    'value' => $region,
                    'label' => Mage::helper('amazonpayments')->__($regionName)
                );
            }

            if ($this->_isExtendedConfigEnabled()) {
                $this->_options[] = array(
                    'value' => 'USD',
                    'label' => Mage::helper('amazonpayments')->__('United States')
                );
            }
        }

        return $this->_options;
    }

    public function getRegionLabelByCode($code)
    {
        $regions = $this->getOptions();
        if (array_key_exists($code, $regions)) {
            return $regions[$code];
        }

        return null;
    }
}
