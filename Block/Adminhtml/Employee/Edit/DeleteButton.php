<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Block\Adminhtml\Employee\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];
        $employeeId = $this->getEmployeeId();
        if ($employeeId) {
            $data = [
                'label' => __('Delete Employee'),
                'class' => 'delete',
                'on_click' => sprintf(
                    "deleteConfirm('%s', '%s')",
                    __('Are you sure you want to delete this employee?'),
                    $this->getUrl('*/*/delete', ['entity_id' => $employeeId])
                ),
                'sort_order' => 20,
            ];
        }
        return $data;
    }
}
