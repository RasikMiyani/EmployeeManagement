<?php
namespace Rasik\EmployeeManagement\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Rasik\EmployeeManagement\Model\EmployeeFactory;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee as EmployeeResource;

class CreateEmployee implements ResolverInterface
{
    private $employeeFactory;
    private $employeeResource;

    public function __construct(
        EmployeeFactory $employeeFactory,
        EmployeeResource $employeeResource
    ) {
        $this->employeeFactory = $employeeFactory;
        $this->employeeResource = $employeeResource;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        try {
            $employee = $this->employeeFactory->create();
            $employee->setData($args['input']);
            $this->employeeResource->save($employee);

            return [
                'success' => true,
                'message' => 'Employee created successfully',
                'employee' => $employee->getData()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'employee' => null
            ];
        }
    }
}
