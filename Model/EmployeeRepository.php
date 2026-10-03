<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Rasik\EmployeeManagement\Api\Data\EmployeeInterface;
use Rasik\EmployeeManagement\Api\Data\EmployeeSearchResultsInterface;
use Rasik\EmployeeManagement\Api\Data\EmployeeSearchResultsInterfaceFactory;
use Rasik\EmployeeManagement\Api\EmployeeRepositoryInterface;
use Rasik\EmployeeManagement\Model\EmployeeFactory;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee as EmployeeResource;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee\CollectionFactory as EmployeeCollectionFactory;

/**
 * Class EmployeeRepository
 * Implements service contract for Employee CRUD operations.
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @var EmployeeResource
     */
    private $resource;

    /**
     * @var EmployeeFactory
     */
    private $employeeFactory;

    /**
     * @var EmployeeCollectionFactory
     */
    private $employeeCollectionFactory;

    /**
     * @var EmployeeSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface|null
     */
    private $collectionProcessor;

    /**
     * @param EmployeeResource $resource
     * @param EmployeeFactory $employeeFactory
     * @param EmployeeCollectionFactory $employeeCollectionFactory
     * @param EmployeeSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        EmployeeResource $resource,
        EmployeeFactory $employeeFactory,
        EmployeeCollectionFactory $employeeCollectionFactory,
        EmployeeSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->employeeFactory = $employeeFactory;
        $this->employeeCollectionFactory = $employeeCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save employee entity
     *
     * @param EmployeeInterface $employee
     * @return EmployeeInterface
     * @throws CouldNotSaveException
     */
    public function save(EmployeeInterface $employee): EmployeeInterface
    {
        try {
            $this->resource->save($employee);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the employee: %1', $exception->getMessage()),
                $exception
            );
        }
        return $employee;
    }

    /**
     * Load employee entity by ID
     *
     * @param int $employeeId
     * @return EmployeeInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $employeeId): EmployeeInterface
    {
        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, $employeeId);
        if (!$employee->getEntityId()) {
            throw new NoSuchEntityException(__('Employee with ID "%1" does not exist.', $employeeId));
        }
        return $employee;
    }

    /**
     * Delete employee entity
     *
     * @param EmployeeInterface $employee
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(EmployeeInterface $employee): bool
    {
        try {
            $this->resource->delete($employee);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the employee: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * Delete employee by ID
     *
     * @param int $employeeId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $employeeId): bool
    {
        return $this->delete($this->getById($employeeId));
    }

    /**
     * Get list of employees matching SearchCriteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return EmployeeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): EmployeeSearchResultsInterface
    {
        $collection = $this->employeeCollectionFactory->create();

        if ($this->collectionProcessor !== null) {
            $this->collectionProcessor->process($searchCriteria, $collection);
        } else {
            // Fallback manual processor if collection processor not injected
            foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
                $fields = [];
                $conditions = [];
                foreach ($filterGroup->getFilters() as $filter) {
                    $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                    $fields[] = $filter->getField();
                    $conditions[] = [$condition => $filter->getValue()];
                }
                if ($fields) {
                    $collection->addFieldToFilter($fields, $conditions);
                }
            }

            if ($searchCriteria->getSortOrders()) {
                foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                    $collection->addOrder(
                        $sortOrder->getField(),
                        ($sortOrder->getDirection() == \Magento\Framework\Api\SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                    );
                }
            }

            $collection->setCurPage($searchCriteria->getCurrentPage());
            $collection->setPageSize($searchCriteria->getPageSize());
        }

        /** @var EmployeeSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
