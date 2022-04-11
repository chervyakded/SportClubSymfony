<?php

namespace EfTech\SportClub\ValueObject;

use EfTech\SportClub\Exception\DomainException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Валюта
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="currency",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="currency_code_unq", columns={"code"}),
 *         @ORM\UniqueConstraint(name="currency_name_unq", columns={"name"})
 *     }
 * )
 */
class Currency
{
    /**
     * id продукта
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="currency_id_seq")
     */
    private ?int $id = null;

    /**
     * Код валюты
     *
     * @ORM\Column(name="code", type="string", length=3, nullable=false)
     *
     * @var string
     */
    private string $code;

    /**
     * Имя валюты
     *
     * @ORM\Column(name="name", type="string", length=3, nullable=false)
     *
     * @var string
     */
    private string $name;

    /**
     * Описание валюты
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     *
     * @var string
     */
    private string $description;


    /**
     * @param string $code - код валюты
     * @param string $name - имя валюты
     * @param string $description - описание валюты
     */
    public function __construct(
        string $code,
        string $name,
        string $description
    ) {
        $this->validate($code, $name, $description);
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;

    }//end __construct()

    private function validate(
        string $code,
        string $name,
        string $description
    ) {
        if (1 !== preg_match('/^\d{3}$/', $code)) {
            throw new DomainException('Некорректный формат кода валюты');
        }
        if (1 !== preg_match('/^[A-Z]{3}$/', $name)) {
            throw new DomainException('Некорректное имя валюты');
        }
        if (strlen($description) > 255) {
            throw new DomainException('Длина описания валюты не может превышать 255 символов');
        }
        if ('' === trim($description)) {
            throw new DomainException('Описание валюты не может быть пустой строкой');
        }
    }


    /**
     * Код валюты (RUB)
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;

    }//end getCode()


    /**
     * Имя валюты (Рубль)
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;

    }//end getName()

    /**
     * Описание валюты
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}//end class
