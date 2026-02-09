<?php
namespace Rasik\EmployeeManagement\Ui\DataProvider\Employee;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}
