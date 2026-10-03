<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Rasik\EmployeeManagement\Model;

use Magento\Framework\Model\AbstractModel;
use Rasik\EmployeeManagement\Api\Data\EmployeeInterface;
use Rasik\EmployeeManagement\Model\ResourceModel\Employee as EmployeeResource;

/**
 * Employee model implementation
 */
class Employee extends AbstractModel implements EmployeeInterface
{
    /**
     * CMS page cache tag.
     */
    public const CACHE_TAG = 'rasik_employee';

    /**
     * @var string
     */
    protected $_cacheTag = 'rasik_employee';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'rasik_employee';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(EmployeeResource::class);
    }

    /**
     * @inheritdoc
     */
    public function getEntityId()
    {
        $id = $this->getData(self::EMPLOYEE_ID);
        return $id !== null ? (int)$id : null;
    }

    /**
     * @inheritdoc
     */
    public function setEntityId($id)
    {
        return $this->setData(self::EMPLOYEE_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritdoc
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * @inheritdoc
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * @inheritdoc
     */
    public function getSalary()
    {
        $salary = $this->getData(self::SALARY);
        return $salary !== null ? (float)$salary : null;
    }

    /**
     * @inheritdoc
     */
    public function setSalary($salary)
    {
        return $this->setData(self::SALARY, $salary);
    }

    /**
     * @inheritdoc
     */
    public function getDob()
    {
        return $this->getData(self::DOB);
    }

    /**
     * @inheritdoc
     */
    public function setDob($dob)
    {
        return $this->setData(self::DOB, $dob);
    }

    /**
     * @inheritdoc
     */
    public function getContactNumber()
    {
        return $this->getData(self::CONTACT_NUMBER);
    }

    /**
     * @inheritdoc
     */
    public function setContactNumber($number)
    {
        return $this->setData(self::CONTACT_NUMBER, $number);
    }
}
