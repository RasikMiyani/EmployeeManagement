<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Controller\Adminhtml\Employee;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Rasik\EmployeeManagement\Api\Data\EmployeeInterface;
use Rasik\EmployeeManagement\Api\Data\EmployeeInterfaceFactory;
use Rasik\EmployeeManagement\Api\EmployeeRepositoryInterface;

/**
 * Save Employee action
 */
class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Rasik_EmployeeManagement::employee';

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * @var EmployeeRepositoryInterface
     */
    private EmployeeRepositoryInterface $employeeRepository;

    /**
     * @var EmployeeInterfaceFactory
     */
    private EmployeeInterfaceFactory $employeeFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param EmployeeInterfaceFactory $employeeFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeInterfaceFactory $employeeFactory
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->employeeRepository = $employeeRepository;
        $this->employeeFactory = $employeeFactory;
    }

    /**
     * Save employee action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        $id = !empty($data['entity_id']) ? (int)$data['entity_id'] : null;

        try {
            if ($id) {
                /** @var EmployeeInterface $model */
                $model = $this->employeeRepository->getById($id);
            } else {
                /** @var EmployeeInterface $model */
                $model = $this->employeeFactory->create();
                unset($data['entity_id']);
            }

            $model->setName($data['name'] ?? '');
            $model->setContactNumber($data['contact_number'] ?? '');
            $model->setDob($data['dob'] ?? null);
            $model->setSalary(!empty($data['salary']) ? (float)$data['salary'] : null);
            $model->setAddress($data['address'] ?? '');

            $this->employeeRepository->save($model);
            $this->messageManager->addSuccessMessage(__('You saved the employee.'));
            $this->dataPersistor->clear('rasik_employee');

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getEntityId()]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the employee.'));
        }

        $this->dataPersistor->set('rasik_employee', $data);
        return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
    }
}
