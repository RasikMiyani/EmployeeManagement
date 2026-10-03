<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Rasik\EmployeeManagement\Api\Data\EmployeeInterface;
use Rasik\EmployeeManagement\Api\Data\EmployeeSearchResultsInterface;

/**
 * Interface for Employee Repository
 * @api
 */
interface EmployeeRepositoryInterface
{
    /**
     * Save employee
     *
     * @param EmployeeInterface $employee
     * @return EmployeeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(EmployeeInterface $employee): EmployeeInterface;

    /**
     * Get employee by ID
     *
     * @param int $employeeId
     * @return EmployeeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $employeeId): EmployeeInterface;

    /**
     * Delete employee
     *
     * @param EmployeeInterface $employee
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(EmployeeInterface $employee): bool;

    /**
     * Delete employee by ID
     *
     * @param int $employeeId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $employeeId): bool;

    /**
     * Get list of employees matching the search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return EmployeeSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): EmployeeSearchResultsInterface;
}
