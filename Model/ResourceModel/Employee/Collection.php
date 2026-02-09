<?php
namespace Rasik\EmployeeManagement\Model\ResourceModel\Employee;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Rasik\EmployeeManagement\Model\Employee as EmployeeModel;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee as EmployeeResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    
    protected function _construct()
    {
        $this->_init(
            EmployeeModel::class,
            EmployeeResource::class
        );
    }
}
