<?php

namespace EfTech\SportClub\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Общие свойства для всех подмножеств наследников (Клиент, Сотрудник)
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="abstract_users",
 *     indexes={
 *         @ORM\Index(name="abstract_users_full_name_idx", columns={"full_name"}),
 *         @ORM\Index(name="abstract_users_phone_idx", columns={"phone"}),
 *         @ORM\Index(name="abstract_users_type_idx", columns={"type"})
 *     }
 * )
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=30)
 * @ORM\DiscriminatorMap(
 *     {
 *         "customer" = \EfTech\SportClub\Entity\Customer::class,
 *         "employee" = \EfTech\SportClub\Entity\Employee::class
 *     }
 * )
 */
abstract class AbstractUser
{
    /**
     * id пользователя
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="abstract_users_id_seq")
     * @ORM\Column(type="integer", name="id", nullable=false)
     *
     * @var integer
     */
    private int $id;

    /**
     * ФИО пользователя
     *
     * @ORM\Column(type="string", length=255, name="full_name", nullable=false)
     *
     * @var string
     */
    private string $fullName;

    /**
     * Номер пользователя
     *
     * @ORM\Column(type="string", length=12, name="phone", nullable=false)
     *
     * @var string
     */
    private string $phone;

    /**
     * Конструктор AbstractUser
     *
     * @param integer $id       - идентификатор пользователя
     * @param string  $fullName - ФИО пользователя
     * @param string  $phone    - телефон пользователя
     */
    public function __construct(
        int $id,
        string $fullName,
        string $phone
    ) {
        $this->id        = $id;
        $this->fullName = $fullName;
        $this->phone     = $phone;
    }//end __construct()

    /**
     * Получить id пользователя
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }//end getId()

    /**
     * Получить ФИО пользователя
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }//end getFullName()

    /**
     * Получить телефон пользователя
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }//end getPhone()
}//end class
