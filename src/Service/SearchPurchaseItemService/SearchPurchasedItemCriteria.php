<?php

namespace EfTech\SportClub\Service\SearchPurchaseItemService;

/**
 * Логика поиска продуктов по критериям
 */
class SearchPurchasedItemCriteria
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
     * id продукта
     *
     * @var integer|null
     */
    private ?int $purchasedItemId = null;

    /**
     * id абонемента
     *
     * @var integer|null
     */
    private ?int $pass = null;

    /**
     * id программы
     *
     * @var integer|null
     */
    private ?int $programId = null;

    /**
     * Цена
     *
     * @var integer|null
     */
    private ?int $price = null;

    /**
     * Получить id клиента
     *
     * @return integer|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }//end getId()

    /**
     * Получить ФИО клиента
     *
     * @return string|null
     */
    public function getCustomerFullName(): ?string
    {
        return $this->customerFullName;
    }//end getFullName()

    /**
     * Получить пол клиента
     *
     * @return string|null
     */
    public function getCustomerSex(): ?string
    {
        return $this->customer_sex;
    }//end getSex()

    /**
     * Получить день рождения клиента
     *
     * @return string|null
     */
    public function getCustomerBirthdate(): ?string
    {
        return $this->customer_birthdate;
    }//end getBirthdate()

    /**
     * Получить телефон клиента
     *
     * @return string|null
     */
    public function getCustomerPhone(): ?string
    {
        return $this->customer_phone;
    }//end getPhone()

    /**
     * Получить паспорт клиента
     *
     * @return string|null
     */
    public function getCustomerPassport(): ?string
    {
        return $this->customer_passport;
    }//end getPassport()

    /**
     * Получить id продукта
     *
     * @return integer|null
     */
    public function getPurchasedItemId(): ?int
    {
        return $this->purchasedItemId;
    }//end getPurchasedItemId()

    /**
     * Получить id абонемента
     *
     * @return integer|null
     */
    public function getPass(): ?int
    {
        return $this->pass;
    }//end getPassId()

    /**
     * Получить id программы
     *
     * @return integer|null
     */
    public function getProgramId(): ?int
    {
        return $this->programId;
    }//end getIdProgramme()

    /**
     * Получить цену
     *
     * @return integer|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }//end getPrice()

    /**
     * Изменить id клиента
     *
     * @param  integer|null $customer_id
     * @return SearchPurchasedItemCriteria
     */
    public function setCustomerId(?int $customer_id): SearchPurchasedItemCriteria
    {
        $this->customer_id = $customer_id;
        return $this;
    }//end setCustomerId()

    /**
     * Изменить ФИО клиента
     *
     * @param  string|null $customerFullName
     * @return SearchPurchasedItemCriteria
     */
    public function setCustomerFullName(?string $customerFullName): SearchPurchasedItemCriteria
    {
        $this->customerFullName = $customerFullName;
        return $this;
    }//end setFullName()

    /**
     * Изменить пол клиента
     *
     * @param  string|null $customer_sex
     * @return SearchPurchasedItemCriteria
     */
    public function setCustomerSex(?string $customer_sex): SearchPurchasedItemCriteria
    {
        $this->customer_sex = $customer_sex;
        return $this;
    }//end setSex()

    /**
     * Изменить день рождения клиента
     *
     * @param  string|null $customer_birthdate
     * @return SearchPurchasedItemCriteria
     */
    public function setCustomerBirthdate(?string $customer_birthdate): SearchPurchasedItemCriteria
    {
        $this->customer_birthdate = $customer_birthdate;
        return $this;
    }//end setBirthdate()

    /**
     * Изменить телефон клиента
     *
     * @param  string|null $customer_phone
     * @return SearchPurchasedItemCriteria
     */
    public function setCustomerPhone(?string $customer_phone): SearchPurchasedItemCriteria
    {
        $this->customer_phone = $customer_phone;
        return $this;
    }//end setPhone()

    /**
     * Изменить паспорт клиента
     *
     * @param  string|null $customer_passport
     * @return SearchPurchasedItemCriteria
     */
    public function setCustomerPassport(?string $customer_passport): SearchPurchasedItemCriteria
    {
        $this->customer_passport = $customer_passport;
        return $this;
    }//end setPassport()

    /**
     * Изменить id продукта
     *
     * @param  integer|null $purchasedItemId
     * @return SearchPurchasedItemCriteria
     */
    public function setPurchasedItemId(?int $purchasedItemId): SearchPurchasedItemCriteria
    {
        $this->purchasedItemId = $purchasedItemId;
        return $this;
    }//end setPurchasedItemId()

    /**
     * Изменить id абонемента
     *
     * @param  integer|null $pass
     * @return SearchPurchasedItemCriteria
     */
    public function setPass(?int $pass): SearchPurchasedItemCriteria
    {
        $this->pass = $pass;
        return $this;
    }//end setPassId()

    /**
     * Изменить id программы
     *
     * @param  integer|null $programId
     * @return SearchPurchasedItemCriteria
     */
    public function setProgramId(?int $programId): SearchPurchasedItemCriteria
    {
        $this->programId = $programId;
        return $this;
    }//end setIdProgramme()

    /**
     * Изменить цену
     *
     * @param  integer|null $price
     * @return SearchPurchasedItemCriteria
     */
    public function setPrice(?int $price): SearchPurchasedItemCriteria
    {
        $this->price = $price;
        return $this;
    }//end setPrice()
}//end class
