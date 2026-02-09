<?php
namespace Rasik\EmployeeManagement\Api;
/**
 * Interface for Employee Repository
 * @api
 */
interface EmployeeRepositoryInterface
{
    /**
     * Create or update an employee
     * @api
     * @param \Rasik\EmployeeManagement\Api\Data\EmployeeInterface $employee Employee data object
     * @return \Rasik\EmployeeManagement\Api\Data\EmployeeInterface Created/Updated employee object
     */
    public function save(\Rasik\EmployeeManagement\Api\Data\EmployeeInterface $employee): \Rasik\EmployeeManagement\Api\Data\EmployeeInterface;

    /**
     * Get employee by ID
     * @api
     * @param int $employeeId Employee ID
     * @return \Rasik\EmployeeManagement\Api\Data\EmployeeInterface Employee data object
     */
    public function getById(int $employeeId): \Rasik\EmployeeManagement\Api\Data\EmployeeInterface;

    /**
     * Delete employee by ID
     * @api
     * @param int $employeeId Employee ID
     * @return bool True on success
     */
    public function deleteById(int $employeeId): bool;

    /**
     * Get list of employees
     * @api
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
