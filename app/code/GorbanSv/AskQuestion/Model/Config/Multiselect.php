<?php

namespace GorbanSv\AskQuestion\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Multiselect
 * @package GorbanSv\AskQuestion\Model\Config
 */
class Multiselect extends \Magento\Captcha\Model\Config\Form\AbstractForm
{
    /**
     * @var string
     */
    protected $_configPath = 'customer_question_general_options/test/customer_question_multiselect';

    /**
     * Returns options for form multiselect
     * @return array
     */
    public function toOptionArray() : array
    {
        $optionArray = [];
        $backendConfig = $this->_config->getValue($this->_configPath, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
        if ($backendConfig) {
            foreach ($backendConfig as $formName => $formConfig) {
                if (!empty($formConfig['label'])) {
                    $optionArray[] = ['label' => $formConfig['label'], 'value' => $formName];
                }
            }
        }
        return $optionArray;
    }
}
