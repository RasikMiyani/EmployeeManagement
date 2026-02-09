<?php
namespace Rasik\EmployeeManagement\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Rasik\EmployeeManagement\Model\EmployeeFactory;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee;

class UpdateEmployee implements ResolverInterface
{
    private $employeeFactory;
    private $employeeResource;

    public function __construct(
        EmployeeFactory $employeeFactory,
        Employee $employeeResource
    ) {
        $this->employeeFactory = $employeeFactory;
        $this->employeeResource = $employeeResource;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $employee = $this->employeeFactory->create();
        $this->employeeResource->load($employee, $args['entity_id']);

        if (!$employee->getId()) {
            return ['success' => false, 'message' => 'Employee not found', 'employee' => null];
        }

        $employee->addData($args['input']);
        $this->employeeResource->save($employee);

        return [
            'success' => true,
            'message' => 'Employee updated successfully',
            'employee' => $employee->getData()
        ];
    }
}
