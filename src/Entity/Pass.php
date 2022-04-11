<?php

namespace EfTech\SportClub\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Абонементы
 *
 * @ORM\Entity(repositoryClass=\EfTech\SportClub\Repository\PassDoctrineRepository::class)
 * @ORM\Table(
 *     name="pass",
 *     indexes={
 *         @ORM\Index(name="pass_customer_id_idx", columns={"customer_id"}),
 *         @ORM\Index(name="pass_customer_id_idx", columns={"employee_id"}),
 *         @ORM\Index(name="pass_discount_idx", columns={"discount"}),
 *         @ORM\Index(name="pass_duration_idx", columns={"duration"}),
 *     }
 * )
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=12)
 * @ORM\DiscriminatorMap(
 *     {
 *         "pass"         = \EfTech\SportClub\Entity\Pass::class,
 *         "benefit_pass" = \EfTech\SportClub\Entity\BenefitPass::class
 *     }
 * )
 */
class Pass
{
    /**
     * id абонемента
     *
     * @ORM\Id
     * @ORM\Column(name="pass_id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pass_id_seq")
     *
     * @var integer
     */
    private int $id;

    /**
     * срок работы абонемента
     *
     * @ORM\Column(name="duration", type="string", length=23, nullable=false)
     *
     * @var string
     */
    private string $duration;

    /**
     * скидка абонемента
     *
     * @ORM\Column(name="discount", type="string", length=4, nullable=false)
     *
     * @var string|null
     */
    private string $discount;

    /**
     * Сущность клиента, содержащая его id
     *
     * @ORM\ManyToOne(
     *     targetEntity=\EfTech\SportClub\Entity\Customer::class,
     *     inversedBy="pass"
     * )
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     *
     * @var Customer
     */
    private Customer $customer;

    /**
     * Список покупок
     *
     * @ORM\OneToMany(
     *     targetEntity=\EfTech\SportClub\Entity\PurchasedItem::class,
     *     mappedBy="pass"
     * )
     *
     * @var Collection
     */
    private Collection $purchasedItems;

    /**
     * Сущность сотрудника, содержащая его id
     *
     * @ORM\ManyToOne(targetEntity=\EfTech\SportClub\Entity\Employee::class)
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     *
     * @var Employee
     */
    private Employee $employee;

    /**
     * Конструктор абонемент
     *
     * @param integer     $id       - идентификатор абонемента
     * @param string      $duration - период действия
     * @param string|null $discount - скидка
     * @param Customer    $customer - клиент
     */
    public function __construct(
        int      $id,
        string   $duration,
        ?string  $discount,
        Customer $customer
    ) {
        $this->id       = $id;
        $this->duration = $duration;
        $this->discount = $discount;
        $this->customer = $customer;
    }//end __construct()

    /**
     * Получить id абонемента
     *
     * @return integer
     */
    final public function getId(): int
    {
        return $this->id;
    }//end getId()

    /**
     * Получить id клиента
     *
     * @return Customer
     */
    final public function getCustomer(): Customer
    {
        return $this->customer;
    }//end getCustomerId()

    /**
     * Получить срок действия абонемента
     *
     * @return string
     */
    final public function getDuration(): string
    {
        return $this->duration;
    }//end getDuration()

    /**
     * Получить размер скидки
     *
     * @return string
     */
    final public function getDiscount(): string
    {
        return $this->discount;
    }

    /**
     * @return Collection
     */
    public function getPurchasedItems(): Collection
    {
        return $this->purchasedItems;
    }//end getDiscount()
}//end class
