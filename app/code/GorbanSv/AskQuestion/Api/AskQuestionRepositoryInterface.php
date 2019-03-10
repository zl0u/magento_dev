<?php

namespace GorbanSv\AskQuestion\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Ask Question CRUD interface.
 * @api
 */
interface AskQuestionRepositoryInterface
{
    /**
     * Save question.
     * @param \GorbanSv\AskQuestion\Api\Data\AskQuestionInterface $askQuestion
     * @return \GorbanSv\AskQuestion\Api\Data\AskQuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\AskQuestionInterface $askQuestion);

    /**
     * Retrieve question.
     * @param int $askQuestionId
     * @return \GorbanSv\AskQuestion\Api\Data\AskQuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($askQuestionId);

    /**
     * Retrieve questions matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return \GorbanSv\AskQuestion\Api\Data\AskQuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question.
     * @param \GorbanSv\AskQuestion\Api\Data\AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\AskQuestionInterface $askQuestion);

    /**
     * Delete question by ID.
     * @param int $askQuestionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($askQuestionId);
}
