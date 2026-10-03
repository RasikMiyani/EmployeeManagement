<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Block\Adminhtml\Employee\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Rasik\EmployeeManagement\Api\EmployeeRepositoryInterface;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var EmployeeRepositoryInterface
     */
    protected $employeeRepository;

    /**
     * @param Context $context
     * @param EmployeeRepositoryInterface $employeeRepository
     */
    public function __construct(
        Context $context,
        EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->context = $context;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Return Employee ID
     *
     * @return int|null
     */
    public function getEmployeeId(): ?int
    {
        $id = $this->context->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                return (int)$this->employeeRepository->getById((int)$id)->getEntityId();
            } catch (NoSuchEntityException $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
