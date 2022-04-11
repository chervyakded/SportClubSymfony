<?php

namespace EfTech\SportClub\Service\SearchPassService;

/**
 * Логика поиска абонементов по критериям
 */
class SearchPassCriteria
{
    /**
     * id клиента
     *
     * @var int|null
     */
    private ?int $customer_id = null;

    /**
     * ФИО клиента
     *
     * @var string|null
     */
    private ?string $customer_full_name = null;

    /**
     * Пол клиента
     *
     * @var string|null
     */
    private ?string $customer_sex = null;

    /**
     * День рождения клиента
     *
     * @var string|null
     */
    private ?string $customer_birthdate = null;

    /**
     * Телефон клиента
     *
     * @var string|null
     */
    private ?string $customer_phone = null;

    /**
     * Паспорт клиента
     *
     * @var string|null
     */
    private ?string $customer_passport = null;

    /**
     * id абонемента
     *
     * @var integer|null
     */
    private ?int $pass_id = null;

    /**
     * Срок льготы
     *
     * @var string|null
     */
    private ?string $duration = null;

    /**
     * Срок льготы
     *
     * @var string|null
     */
    private ?string $discount = null;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    /**
     * @param int|null $customer_id
     * @return SearchPassCriteria
     */
    public function setCustomerId(?int $customer_id): SearchPassCriteria
    {
        $this->customer_id = $customer_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerFullName(): ?string
    {
        return $this->customer_full_name;
    }

    /**
     * @param string|null $customer_full_name
     * @return SearchPassCriteria
     */
    public function setCustomerFullName(?string $customer_full_name): SearchPassCriteria
    {
        $this->customer_full_name = $customer_full_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerSex(): ?string
    {
        return $this->customer_sex;
    }

    /**
     * @param string|null $customer_sex
     * @return SearchPassCriteria
     */
    public function setCustomerSex(?string $customer_sex): SearchPassCriteria
    {
        $this->customer_sex = $customer_sex;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerBirthdate(): ?string
    {
        return $this->customer_birthdate;
    }

    /**
     * @param string|null $customer_birthdate
     * @return SearchPassCriteria
     */
    public function setCustomerBirthdate(?string $customer_birthdate): SearchPassCriteria
    {
        $this->customer_birthdate = $customer_birthdate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerPhone(): ?string
    {
        return $this->customer_phone;
    }

    /**
     * @param string|null $customer_phone
     * @return SearchPassCriteria
     */
    public function setCustomerPhone(?string $customer_phone): SearchPassCriteria
    {
        $this->customer_phone = $customer_phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerPassport(): ?string
    {
        return $this->customer_passport;
    }

    /**
     * @param string|null $customer_passport
     * @return SearchPassCriteria
     */
    public function setCustomerPassport(?string $customer_passport): SearchPassCriteria
    {
        $this->customer_passport = $customer_passport;
        return $this;
    }//end isArray()


    /**
     * Получить id абонемента
     *
     * @return integer|null
     */
    public function getPassId(): ?int
    {
        return $this->pass_id;

    }//end getPassId()


    /**
     * Изменить id абонемента
     *
     * @param  integer|null $pass_id
     * @return SearchPassCriteria
     */
    public function setPassId(?int $pass_id): SearchPassCriteria
    {
        $this->pass_id = $pass_id;
        return $this;

    }//end setPassId()


    /**
     * Получить срок льготы
     *
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;

    }//end getDuration()


    /**
     * Изменить срок льготы
     *
     * @param  string|null $duration
     * @return SearchPassCriteria
     */
    public function setDuration(?string $duration): SearchPassCriteria
    {
        $this->duration = $duration;
        return $this;

    }//end setDuration()


    /**
     * Получить срок льготы
     *
     * @return string|null
     */
    public function getDiscount(): ?string
    {
        return $this->discount;

    }//end getDiscount()


    /**
     * Изменить срок льготы
     *
     * @param  string|null $discount
     * @return SearchPassCriteria
     */
    public function setDiscount(?string $discount): SearchPassCriteria
    {
        $this->discount = $discount;
        return $this;

    }//end setDiscount()

}//end class
