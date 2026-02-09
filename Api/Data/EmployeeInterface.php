<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Rasik\EmployeeManagement\Api\Data;

/**
 * Interface for Employee data object
 * @api
 */
interface EmployeeInterface
{
    public const EMPLOYEE_ID = 'entity_id';
    public const NAME = 'name';
    public const ADDRESS = 'address';
    public const SALARY = 'salary';
    public const DOB = 'dob';
    public const CONTACT_NUMBER = 'contact_number';

    /**
     * Get Employee ID
     * @api
     * @return int|null Employee ID
     */
    public function getEntityId();

    /**
     * Set Employee ID
     * @api
     * @param int $id Employee ID
     * @return $this
     */
    public function setEntityId($id);

    /**
     * Get name
     * @api
     * @return string|null Name
     */
    public function getName();

    /**
     * Set name
     * @api
     * @param string $name Name
     * @return $this
     */
    public function setName($name);

    /**
     * Get address
     * @api
     * @return string|null Address
     */
    public function getAddress();

    /**
     * Set address
     * @api
     * @param string $address Address
     * @return $this
     */
    public function setAddress($address);

    /**
     * Get salary
     * @api
     * @return float|null Salary
     */
    public function getSalary();

    /**
     * Set salary
     * @api
     * @param float $salary Salary
     * @return $this
     */
    public function setSalary($salary);

    /**
     * Get date of birth
     * @api
     * @return string|null Date of birth
     */
    public function getDob();

    /**
     * Set date of birth
     * @api
     * @param string $dob Date of birth (Y-m-d)
     * @return $this
     */
    public function setDob($dob);

    /**
     * Get contact number
     * @api
     * @return string|null Contact number
     */
    public function getContactNumber();

    /**
     * Set contact number
     * @api
     * @param string $number Contact number
     * @return $this
     */
    public function setContactNumber($number);
}