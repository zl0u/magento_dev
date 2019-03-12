<?php

namespace GorbanSv\AskQuestion\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for Ask Question search results.
 * @api
 */
interface AskQuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     * @return \GorbanSv\AskQuestion\Api\Data\AskQuestionInterface[]
     */
    public function getItems();

    /**
     * Set questions list.
     * @param \GorbanSv\AskQuestion\Api\Data\AskQuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
