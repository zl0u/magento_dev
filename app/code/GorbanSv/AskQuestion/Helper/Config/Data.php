<?php

namespace GorbanSv\AskQuestion\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{
    /**
     * @param string $scope
     * @return bool
     */
    public function isEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT) : bool
    {
        return $this->scopeConfig->isSetFlag(
            'customer_question_general_options/general/enable',
            $scope
        );
    }

    /**
     * @param string $scope
     * @return bool
     */
    public function isEnabledAutoConfirming($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT) : bool
    {
        return $this->scopeConfig->isSetFlag(
            'customer_question_general_options/cron_options/enable_auto_confirming',
            $scope
        );
    }

    /**
     * @param string $scope
     * @return mixed
     */
    public function getCronFrequency($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'customer_question_general_options/cron_options/cron_frequency',
            $scope
        );
    }

    /**
     * @param string $scope
     * @return bool
     */
    public function isEnabledEmailNotifications($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT) : bool
    {
        return $this->scopeConfig->isSetFlag(
            'customer_question_general_options/additional/enable_email_notifications',
            $scope
        );
    }
}
