<?php

namespace EfTech\SportClub\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Клиент
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="customers",
 *     indexes={
 *         @ORM\Index(name="customers_sex_idx", columns={"sex"}),
 *         @ORM\Index(name="customers_birthdate_idx", columns={"birthdate"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="customers_passport_unq", columns={"passport"})
 *     }
 * )
 */
class Customer extends AbstractUser
{
    /**
     * пол клиента
     *
     * @ORM\Column(name="sex", type="string", length=1, nullable=false)
     *
     * @var string
     */
    private string $sex;

    /**
     * д.р. клиента
     *
     * @ORM\Column(name="birthdate", type="datetime_immutable", nullable=false)
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $birthdate;

    /**
     * паспорт клиента
     *
     * @ORM\Column(name="passport", type="string", length=12, nullable=false)
     *
     * @var string
     */
    private string $passport;

    /**
     * Абонементы, оформленные на клиента
     *
     * @ORM\OneToMany(
     *     targetEntity=\EfTech\SportClub\Entity\Pass::class,
     *     mappedBy="customer"
     * )
     *
     * @var Collection|Pass[]
     */
    private Collection $pass;

    /**
     * Конструктор клиента
     *
     * @param integer           $id             - идентификатор клиента
     * @param string            $fullName       - ФИО клиента
     * @param string            $phone          - телефон клиента
     * @param DateTimeImmutable $birthdate      - дата рождения клиента
     * @param string            $passport       - паспортные данные клиента
     * @param string            $sex            - пол
     * @param array             $pass           - абонементы, оформленные на клиента
     */
    public function __construct(
        int               $id,
        string            $fullName,
        string            $phone,
        DateTimeImmutable $birthdate,
        string            $passport,
        string            $sex,
        array             $pass
    ) {
        parent::__construct(
            $id,
            $fullName,
            $phone
        );
        $this->birthdate = $birthdate;
        $this->passport = $passport;
        $this->sex = $sex;
        $this->pass = new ArrayCollection($pass);

    }//end __construct()

    /**
     * Получить пол клиента
     *
     * @return string
     */
    final public function getSex(): string
    {
        return $this->sex;

    }//end getSex()

    /**
     * Получить дату рождения клиента
     *
     * @return DateTimeImmutable
     */
    final public function getBirthdate(): DateTimeImmutable
    {
        return $this->birthdate;

    }//end getBirthdate()

    /**
     * Получить пасспортные данные клиента
     *
     * @return string
     */
    public function getPassport(): string
    {
        return $this->passport;

    }//end getPassport()

    /**
     * Получить продукты, купленные клиентом
     *
     * @return PurchasedItem[]
     */
    public function getPurchasedItems(): array
    {
        $purchasedItems = [];
        foreach ($this->pass as $itemPass) {
            foreach ($itemPass->getPurchasedItems() as $purchasedItem) {
                $purchasedItems[] = $purchasedItem;
            }
        }
        return $purchasedItems;
    }

    /**
     * Получить абонементы, оформленные на клиента
     *
     * @return Pass[]
     */
    public function getPass(): array
    {
        return $this->pass->toArray();
    }


}//end class
