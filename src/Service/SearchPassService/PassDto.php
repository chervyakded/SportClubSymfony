<?php

namespace EfTech\SportClub\Service\SearchPassService;

class PassDto
{

    /**
     * id абонемента
     *
     * @var integer
     */
    private int $pass_id;

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
     * id клиента
     *
     * @var integer
     */
    private int $customer_id;


    /**
     * @param integer $pass_id     - id абонемента
     * @param string  $duration    - срок льготы
     * @param string  $discount    - скидка
     * @param integer $customer_id - id клиента
     */
    public function __construct(
        int $pass_id,
        string $duration,
        string $discount,
        int $customer_id
    ) {
        $this->pass_id     = $pass_id;
        $this->duration    = $duration;
        $this->discount    = $discount;
        $this->customer_id = $customer_id;

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
     * Получить id клиента
     *
     * @return integer
     */
    public function getCustomerId(): int
    {
        return $this->customer_id;

    }//end getCustomerId()


}//end class
