<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Rasik\EmployeeManagement\Api\Data\EmployeeInterface;
use Rasik\EmployeeManagement\Api\Data\EmployeeInterfaceFactory;
use Rasik\EmployeeManagement\Api\EmployeeRepositoryInterface;

/**
 * Handle Frontend Employee Data Submission
 */
class Save implements HttpPostActionInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * @var FormKeyValidator
     */
    private FormKeyValidator $formKeyValidator;

    /**
     * @var EmployeeRepositoryInterface
     */
    private EmployeeRepositoryInterface $employeeRepository;

    /**
     * @var EmployeeInterfaceFactory
     */
    private EmployeeInterfaceFactory $employeeFactory;

    /**
     * @param RequestInterface $request
     * @param RedirectFactory $redirectFactory
     * @param ManagerInterface $messageManager
     * @param FormKeyValidator $formKeyValidator
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param EmployeeInterfaceFactory $employeeFactory
     */
    public function __construct(
        RequestInterface $request,
        RedirectFactory $redirectFactory,
        ManagerInterface $messageManager,
        FormKeyValidator $formKeyValidator,
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeInterfaceFactory $employeeFactory
    ) {
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->employeeRepository = $employeeRepository;
        $this->employeeFactory = $employeeFactory;
    }

    /**
     * Save employee from frontend form
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->redirectFactory->create();

        if (!$this->formKeyValidator->validate($this->request)) {
            $this->messageManager->addErrorMessage(__('Invalid form key. Please refresh the page and try again.'));
            return $resultRedirect->setPath('employee/index/index');
        }

        $postData = $this->request->getPostValue();

        try {
            if (empty($postData['name']) || empty($postData['contact_number'])) {
                throw new LocalizedException(__('Please fill in all required fields.'));
            }

            /** @var EmployeeInterface $employee */
            $employee = $this->employeeFactory->create();
            $employee->setName(trim((string)$postData['name']));
            $employee->setContactNumber(trim((string)$postData['contact_number']));
            $employee->setDob(!empty($postData['dob']) ? trim((string)$postData['dob']) : null);
            $employee->setSalary(!empty($postData['salary']) ? (float)$postData['salary'] : null);
            $employee->setAddress(!empty($postData['address']) ? trim((string)$postData['address']) : '');

            // Persist via Service Contract Repository
            $this->employeeRepository->save($employee);

            $this->messageManager->addSuccessMessage(
                __('Thank you! Employee "%1" has been registered successfully.', $employee->getName())
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('An error occurred while saving employee data: %1', $e->getMessage())
            );
        }

        return $resultRedirect->setPath('employee/index/index');
    }
}
