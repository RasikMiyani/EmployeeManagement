<?php
namespace Rasik\EmployeeManagement\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee\CollectionFactory;

class EmployeeList implements ResolverInterface
{
    private $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $collection = $this->collectionFactory->create();

        return [
            'total_count' => $collection->getSize(),
            'items' => $collection->getData()
        ];
    }
}
