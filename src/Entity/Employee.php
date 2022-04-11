<?php

namespace EfTech\SportClub\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Сотрудники
 *
 * @ORM\Entity()
 * @ORM\Table(name="employee")
 */
class Employee extends AbstractUser
{
    /**
     * Должность сотрудника
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=false)
     *
     * @var string
     */
    private string $position;

    /**
     * Зарплата сотрудника
     *
     * @ORM\Column(name="salary", type="integer", nullable=false)
     *
     * @var integer
     */
    private int $salary;

    /**
     * Конструктор сотрудник
     *
     * @inheritDoc
     * @param      string  $position - позиция
     * @param      integer $salary   - зарплата
     */
    public function __construct(
        int    $id,
        string $fullName,
        string $phone,
        string $position,
        int    $salary
    ) {
        parent::__construct(
            $id,
            $fullName,
            $phone
        );
        $this->position = $position;
        $this->salary   = $salary;
    }//end __construct()

    /**
     * Получить позицию сотрудника
     *
     * @return string
     */
    final public function getPosition(): string
    {
        return $this->position;
    }//end getPosition()

    /**
     * Получить зарплату сотрудника
     *
     * @return integer
     */
    final public function getSalary(): int
    {
        return $this->salary;
    }//end getSalary()
}//end class
