<?php
namespace Rasik\EmployeeManagement\Model;

use Magento\Framework\ObjectManagerInterface;

class EmployeeSearchResultsFactory
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
     * Create EmployeeSearchResults instance
     * @return EmployeeSearchResults
     */
    public function create(array $data = [])
    {
        return $this->objectManager->create(EmployeeSearchResults::class, $data);
    }
}
