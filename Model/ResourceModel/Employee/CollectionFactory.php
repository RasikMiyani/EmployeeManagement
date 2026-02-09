<?php
namespace Rasik\EmployeeManagement\Model\ResourceModel\Employee;

use Magento\Framework\ObjectManagerInterface;

class CollectionFactory
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create employee collection
     * @return Collection
     */
    public function create()
    {
        return $this->objectManager->create(Collection::class);
    }
}
