<?php
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Model;

use Magento\Framework\Api\SearchResults;
use Rasik\EmployeeManagement\Api\Data\EmployeeSearchResultsInterface;

/**
 * Service Contract Employee Search Results Model
 */
class EmployeeSearchResults extends SearchResults implements EmployeeSearchResultsInterface
{
}
