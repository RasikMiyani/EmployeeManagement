<?php
namespace Rasik\EmployeeManagement\Model;

use Magento\Framework\Api\SearchResults;
use Rasik\EmployeeManagement\Api\Data\EmployeeInterface;

class EmployeeSearchResults extends SearchResults
{
    /**
     * @return EmployeeInterface[]
     */
    public function getItems()
    {
        return parent::getItems();
    }

    /**
     * @param EmployeeInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null)
    {
        return parent::setItems($items);
    }
}
