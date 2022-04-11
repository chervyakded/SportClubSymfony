<?php

namespace EfTech\SportClub\Service\SearchBenefitPassService;

class BenefitPassDto
{

    /**
     * id абонемента
     *
     * @var integer
     */
    private int $pass_id;

    /**
     * Клиент
     *
     * @var CustomerDto
     */
    private CustomerDto $customer;

    /**
     * Срок льготы
     *
     * @var string
     */
    private string $duration;

    /**
     * Скидка
     *
     * @var string
     */
    private string $discount;

    /**
     * Тип льготы
     *
     * @var string
     */
    private string $type_benefit;

    /**
     * Номер документа
     *
     * @var string
     */
    private string $number_document;

    /**
     * Дата окончания действия льготы
     *
     * @var string
     */
    private string $end;


    /**
     * @param integer     $pass_id         - id абонемента
     * @param CustomerDto $customer        - клиент
     * @param string      $duration        - срок льготы
     * @param string      $discount        - скидка
     * @param string      $type_benefit    - тип льготы
     * @param string      $number_document - номер документа
     * @param string      $end             - дата окончания действия льготы
     */
    public function __construct(
        int         $pass_id,
        CustomerDto $customer,
        string      $duration,
        string      $discount,
        string      $type_benefit,
        string      $number_document,
        string      $end
    ) {
        $this->pass_id         = $pass_id;
        $this->customer        = $customer;
        $this->duration        = $duration;
        $this->discount        = $discount;
        $this->type_benefit    = $type_benefit;
        $this->number_document = $number_document;
        $this->end             = $end;
    }//end __construct()


    /**
     * Получить id абонемента
     *
     * @return integer
     */
    public function getPassId(): int
    {
        return $this->pass_id;

    }//end getPassId()


    /**
     * Получить клиента
     *
     * @return CustomerDto
     */
    public function getCustomer(): CustomerDto
    {
        return $this->customer;

    }//end getCustomer()


    /**
     * Получить срок льготы
     *
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;

    }//end getDuration()


    /**
     * Получить скидка
     *
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;

    }//end getDiscount()


    /**
     * Получить тип льготы
     *
     * @return string
     */
    public function getTypeBenefit(): string
    {
        return $this->type_benefit;

    }//end getTypeBenefit()


    /**
     * Получить номер документа
     *
     * @return string
     */
    public function getNumberDocument(): string
    {
        return $this->number_document;

    }//end getNumberDocument()


    /**
     * Получить дата окончания действия льготы
     *
     * @return string
     */
    public function getEnd(): string
    {
        return $this->end;

    }//end getEnd()


}//end class
