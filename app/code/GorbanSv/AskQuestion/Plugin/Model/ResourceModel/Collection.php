<?php

namespace GorbanSv\AskQuestion\Plugin\Model\ResourceModel;

use GorbanSv\AskQuestion\Model\ResourceModel\AskQuestion\Collection as AskQuestionCollection;

/**
 * Class Collection
 * @package GorbanSv\AskQuestion\Plugin\Model\ResourceModel
 */
class Collection
{
    /**
     * @param AskQuestionCollection $subject
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeLoad(AskQuestionCollection $subject)
    {
        $subject->addStoreFilter();
    }
}
