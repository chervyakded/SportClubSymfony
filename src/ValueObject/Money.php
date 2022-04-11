<?php

namespace EfTech\SportClub\ValueObject;

/**
 * Деньги
 */
class Money
{

    /**
     * Количество
     *
     * @var integer
     */
    private int $amount;

    /**
     * Представление денег в формате с плавающей точкой
     *
     * @var float|null
     */
    private ?float $decimal = null;

    /**
     * Валюта
     *
     * @var Currency
     */
    private Currency $currency;


    /**
     * @param integer  $amount   - количество
     * @param Currency $currency - валюта
     */
    public function __construct(int $amount, Currency $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;

    }//end __construct()


    /**
     * Возвращает количество
     *
     * @return integer
     */
    public function getAmount(): int
    {
        return $this->amount;

    }//end getAmount()


    /**
     * Возвращает представление денег в формате с плавающей точкой
     *
     * @return float|null
     */
    public function getDecimal(): ?float
    {
        if (null === $this->decimal) {
            $this->decimal = ($this->amount / 100);
        }

        return $this->decimal;

    }//end getDecimal()


    /**
     * Возвращает валюту
     *
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;

    }//end getCurrency()


}//end class
