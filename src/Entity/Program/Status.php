<?php

namespace EfTech\SportClub\Entity\Program;

use EfTech\SportClub\Exception\RuntimeException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Статус
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="programme_status",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="programme_status_name_unq", columns={"name"})
 *     }
 * )
 */
class Status
{
    /**
     * Статус в наличии
     */
    public const STATUS_IN_STOCK = 'inStock';

    /**
     * Статус в наличии
     */
    public const STATUS_ARCHIVE = 'archive';

    /**
     * Список допустимых статусов
     */
    private const ALLOWED_STATUS = [
        self::STATUS_IN_STOCK => self::STATUS_IN_STOCK,
        self::STATUS_ARCHIVE => self::STATUS_ARCHIVE,
    ];

    /**
     * id программы
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="programme_status_id_seq")
     *
     * @var int
     */
    private int $id = -1;

    /**
     * Статус
     *
     * @ORM\Column(type="string", length=50, name="name", nullable=false)
     *
     * @var string
     */
    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    private function validate(string $name)
    {
        if (false === array_key_exists($name, self::ALLOWED_STATUS)) {
            throw new RuntimeException("Некорректный статус программы: $name");
        }
    }

    /**
     * Возвращает статус
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
