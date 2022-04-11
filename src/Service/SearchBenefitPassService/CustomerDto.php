<?php

namespace EfTech\SportClub\Service\SearchBenefitPassService;

use DateTimeImmutable;

class CustomerDto
{

    /**
     * id клиента
     *
     * @var integer
     */
    private int $customer_id;

    /**
     * ФИО клиента
     *
     * @var string
     */
    private string $full_name;

    /**
     * Пол клиента
     *
     * @var string
     */
    private string $sex;

    /**
     * День рождения клиента
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $birthdate;

    /**
     * Телефон клиента
     *
     * @var string
     */
    private string $phone;

    /**
     * Номер паспорта клиента
     *
     * @var string
     */
    private string $passport;


    /**
     * @param integer           $customer_id - id клиента
     * @param string            $full_name   - ФИО клиента
     * @param string            $sex         - пол клиента
     * @param DateTimeImmutable $birthdate   - день рождения клиента
     * @param string            $phone       - телефон клиента
     * @param string            $passport    - номер паспорта клиента
     */
    public function __construct(
        int               $customer_id,
        string            $full_name,
        string            $sex,
        DateTimeImmutable $birthdate,
        string            $phone,
        string            $passport
    ) {
        $this->customer_id = $customer_id;
        $this->full_name   = $full_name;
        $this->sex         = $sex;
        $this->birthdate   = $birthdate;
        $this->phone       = $phone;
        $this->passport    = $passport;
    }//end __construct()


    /**
     * Получить id клиента
     *
     * @return integer
     */
    public function getCustomerId(): int
    {
        return $this->customer_id;

    }//end getCustomerId()


    /**
     * Получить ФИО клиента
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->full_name;

    }//end getFullName()


    /**
     * Получить пол клиента
     *
     * @return string
     */
    public function getSex(): string
    {
        return $this->sex;

    }//end getSex()


    /**
     * Получить день рождения клиента
     *
     * @return DateTimeImmutable
     */
    public function getBirthdate(): DateTimeImmutable
    {
        return $this->birthdate;

    }//end getBirthdate()


    /**
     * Получить телефон клиента
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;

    }//end getPhone()


    /**
     * Получить номер паспорта клиента
     *
     * @return string
     */
    public function getPassport(): string
    {
        return $this->passport;

    }//end getPassport()


}//end class
