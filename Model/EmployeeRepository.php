<?php
namespace Rasik\EmployeeManagement\Model;

use Rasik\EmployeeManagement\Api\EmployeeRepositoryInterface;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee as Resource;
use Rasik\EmployeeManagement\Model\EmployeeFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee\CollectionFactory;
use Rasik\EmployeeManagement\Model\EmployeeSearchResultsFactory;

/**
 * Employee Repository implementation
 * @inheritdoc
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    protected $resource;
    protected $employeeFactory;
    protected $collectionFactory;
    protected $searchResultsFactory;

    public function __construct(
        Resource $resource,
        EmployeeFactory $employeeFactory,
        CollectionFactory $collectionFactory,
        EmployeeSearchResultsFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->employeeFactory = $employeeFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     */
    public function save(\Rasik\EmployeeManagement\Api\Data\EmployeeInterface $employee): \Rasik\EmployeeManagement\Api\Data\EmployeeInterface
    {
        $this->resource->save($employee);
        return $employee;
    }

    /**
     * @inheritdoc
     */
    public function getById(int $employeeId): \Rasik\EmployeeManagement\Api\Data\EmployeeInterface
    {
        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, $employeeId);
        if (!$employee->getId()) {
            throw new NoSuchEntityException(__('Employee not found'));
        }
        return $employee;
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $employeeId): bool
    {
        $employee = $this->getById($employeeId);
        $this->resource->delete($employee);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $group) {
            foreach ($group->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
