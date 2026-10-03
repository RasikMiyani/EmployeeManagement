<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for Employee search results
 * @api
 */
interface EmployeeSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get employees list
     *
     * @return \Rasik\EmployeeManagement\Api\Data\EmployeeInterface[]
     */
    public function getItems();

    /**
     * Set employees list
     *
     * @param \Rasik\EmployeeManagement\Api\Data\EmployeeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
