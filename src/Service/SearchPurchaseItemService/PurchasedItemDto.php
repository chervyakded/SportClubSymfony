<?php

namespace EfTech\SportClub\Service\SearchPurchaseItemService;

class PurchasedItemDto
{
    /**
     * id продукта
     *
     * @var integer
     */
    private int $purchased_item_id;

    /**
     * id абонемента
     *
     * @var integer
     */
    private int $pass_id;

    /**
     * id программы
     *
     * @var integer
     */
    private int $id_programme;

    /**
     * Цена
     *
     * @var integer
     */
    private int $price;

    /**
     * Валюта
     *
     * @var string
     */
    private string $currency;

    /**
     * @param integer $purchased_item_id - id продукта
     * @param integer $pass_id           - id абонемента
     * @param integer $id_programme      - id программы
     * @param integer $price             - цена
     * @param string $currency           - валюта
     */
    public function __construct(
        int $purchased_item_id,
        int $pass_id,
        int $id_programme,
        int $price,
        string $currency
    ) {
        $this->purchased_item_id = $purchased_item_id;
        $this->pass_id           = $pass_id;
        $this->id_programme      = $id_programme;
        $this->price             = $price;
        $this->currency          = $currency;
    }//end __construct()

    /**
     * Получить id продукта
     *
     * @return integer
     */
    public function getPurchasedItemId(): int
    {
        return $this->purchased_item_id;
    }//end getPurchasedItemId()

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
     * Получить id программы
     *
     * @return integer
     */
    public function getIdProgramme(): int
    {
        return $this->id_programme;
    }//end getIdProgramme()

    /**
     * Получить цену
     *
     * @return integer
     */
    public function getPrice(): int
    {
        return $this->price;
    }//end getPrice()

    /**
     * Получить валюту
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }//end getCurrency()
}//end class
