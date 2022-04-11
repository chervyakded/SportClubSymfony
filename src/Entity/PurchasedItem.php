<?php

namespace EfTech\SportClub\Entity;

use Doctrine\ORM\Mapping as ORM;
use EfTech\SportClub\ValueObject\Currency;

/**
 * Купленные продукты
 *
 * @ORM\Entity(repositoryClass=\EfTech\SportClub\Repository\CustomerDoctrineRepository::class)
 * @ORM\Table(
 *     name="purchased_item",
 *     indexes={
 *         @ORM\Index(name="purchased_item_id_programme_idx", columns={"id_programme"}),
 *         @ORM\Index(name="purchased_item_pass_id_idx", columns={"pass_id"}),
 *         @ORM\Index(name="purchased_item_price_idx", columns={"price"})
 *     }
 * )
 */
class PurchasedItem
{
    /**
     * id продукта
     *
     * @ORM\Id()
     * @ORM\Column(name="purchased_item_id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="purchased_item_id_seq")
     *
     * @var int
     */
    private int $purchasedItemId;

    /**
     * Сущность абонемента, содержащая его id
     *
     * @ORM\ManyToOne(
     *     targetEntity=\EfTech\SportClub\Entity\Pass::class,
     *     inversedBy="purchasedItems"
     * )
     * @ORM\JoinColumn(name="pass_id", referencedColumnName="pass_id")
     *
     * @var Pass
     */
    private Pass $pass;

    /**
     * id программы
     *
     * @ORM\Column(name="id_programme", type="integer", nullable=false)
     *
     * @var int
     */
    private int $programId;

    /**
     * Цена продукта
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     *
     * @var int
     */
    private int $price;

    /**
     * @ORM\ManyToOne(targetEntity=\EfTech\SportClub\ValueObject\Currency::class)
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     *
     * @var Currency
     */
    private Currency $currency;

    /**
     * Конструктор продукта
     *
     * @param int $purchasedItemId - id продукта
     * @param Pass $pass           - сущность абонемента, содержащая его id
     * @param int $programId       - id программы
     * @param int $price           - цена продукта
     * @param Currency $currency   - сущность валюты
     */
    public function __construct(
        int      $purchasedItemId,
        Pass     $pass,
        int      $programId,
        int      $price,
        Currency $currency
    ) {
        $this->purchasedItemId = $purchasedItemId;
        $this->pass            = $pass;
        $this->programId       = $programId;
        $this->price           = $price;
        $this->currency        = $currency;
    }//end __construct()

    /**
     * @return string
     */
    public function getPurchasedItemId(): string
    {
        return $this->purchasedItemId;
    }

    /**
     * @return Pass
     */
    public function getPass(): Pass
    {
        return $this->pass;
    }

    /**
     * @return string
     */
    public function getProgramId(): string
    {
        return $this->programId;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}//end class
