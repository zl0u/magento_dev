<?php

namespace GorbanSv\AskQuestion\Model\ResourceModel;

/**
 * Class AskQuestion
 * @package GorbanSv\AskQuestion\Model\ResourceModel
 */
class AskQuestion extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('gorbansv_ask_question', 'question_id');
    }
}
