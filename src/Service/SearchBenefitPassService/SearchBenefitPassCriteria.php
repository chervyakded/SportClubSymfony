<?php

namespace EfTech\SportClub\Service\SearchBenefitPassService;

/**
 * Логика поиска льгот по критериям
 */
class SearchBenefitPassCriteria
{

    /**
     * id клиента
     *
     * @var integer|null
     */
    private ?int $customer_id = null;

    /**
     * ФИО клиента
     *
     * @var string|null
     */
    private ?string $customerFullName = null;

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
     * Тип льготы
     *
     * @var string|null
     */
    private ?string $type_benefit = null;

    /**
     * Номер документа
     *
     * @var string|null
     */
    private ?string $number_document = null;

    /**
     * Дата окончания действия льготы
     *
     * @var string|null
     */
    private ?string $end = null;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    /**
     * @param int|null $customer_id
     * @return SearchBenefitPassCriteria
     */
    public function setCustomerId(?int $customer_id): SearchBenefitPassCriteria
    {
        $this->customer_id = $customer_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerFullName(): ?string
    {
        return $this->customerFullName;
    }

    /**
     * @param string|null $customerFullName
     * @return SearchBenefitPassCriteria
     */
    public function setCustomerFullName(?string $customerFullName): SearchBenefitPassCriteria
    {
        $this->customerFullName = $customerFullName;
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
     * @return SearchBenefitPassCriteria
     */
    public function setCustomerSex(?string $customer_sex): SearchBenefitPassCriteria
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
     * @return SearchBenefitPassCriteria
     */
    public function setCustomerBirthdate(?string $customer_birthdate): SearchBenefitPassCriteria
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
     * @return SearchBenefitPassCriteria
     */
    public function setCustomerPhone(?string $customer_phone): SearchBenefitPassCriteria
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
     * @return SearchBenefitPassCriteria
     */
    public function setCustomerPassport(?string $customer_passport): SearchBenefitPassCriteria
    {
        $this->customer_passport = $customer_passport;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPassId(): ?int
    {
        return $this->pass_id;
    }

    /**
     * @param int|null $pass_id
     * @return SearchBenefitPassCriteria
     */
    public function setPassId(?int $pass_id): SearchBenefitPassCriteria
    {
        $this->pass_id = $pass_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @param string|null $duration
     * @return SearchBenefitPassCriteria
     */
    public function setDuration(?string $duration): SearchBenefitPassCriteria
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    /**
     * @param string|null $discount
     * @return SearchBenefitPassCriteria
     */
    public function setDiscount(?string $discount): SearchBenefitPassCriteria
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeBenefit(): ?string
    {
        return $this->type_benefit;
    }

    /**
     * @param string|null $type_benefit
     * @return SearchBenefitPassCriteria
     */
    public function setTypeBenefit(?string $type_benefit): SearchBenefitPassCriteria
    {
        $this->type_benefit = $type_benefit;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberDocument(): ?string
    {
        return $this->number_document;
    }

    /**
     * @param string|null $number_document
     * @return SearchBenefitPassCriteria
     */
    public function setNumberDocument(?string $number_document): SearchBenefitPassCriteria
    {
        $this->number_document = $number_document;
        return $this;
    }

    /**
     * Получить дату окончания действия льготы
     *
     * @return string|null
     */
    public function getEnd(): ?string
    {
        return $this->end;
    }//end getEnd()

    /**
     * Изменить дату окончания действия льготы
     *
     * @param  string|null $end
     * @return SearchBenefitPassCriteria
     */
    public function setEnd(?string $end): SearchBenefitPassCriteria
    {
        $this->end = $end;
        return $this;
    }//end setEnd()


}//end class
