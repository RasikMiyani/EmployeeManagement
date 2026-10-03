<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Controller\Adminhtml\Employee;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Rasik\EmployeeManagement\Api\EmployeeRepositoryInterface;

/**
 * Edit Employee action
 */
class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Rasik_EmployeeManagement::employee';

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var EmployeeRepositoryInterface
     */
    private EmployeeRepositoryInterface $employeeRepository;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param EmployeeRepositoryInterface $employeeRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        EmployeeRepositoryInterface $employeeRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Edit or Create Employee page
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $id = (int)$this->getRequest()->getParam('entity_id');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Rasik_EmployeeManagement::employee_list');

        if ($id) {
            try {
                $employee = $this->employeeRepository->getById($id);
                $resultPage->getConfig()->getTitle()->prepend(__('Edit Employee "%1"', $employee->getName()));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This employee no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Employee'));
        }

        return $resultPage;
    }
}
