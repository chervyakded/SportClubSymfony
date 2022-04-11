<?php

namespace EfTech\SportClub\Entity;

use EfTech\SportClub\Entity\Program\Status;
use EfTech\SportClub\Exception\InvalidDataStructureException;
use EfTech\SportClub\Exception\RuntimeException;
use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Программы
 *
 * @ORM\Entity(repositoryClass=\EfTech\SportClub\Repository\ProgramDoctrineRepository::class)
 * @ORM\Table(
 *     name="programmes",
 *     indexes={
 *         @ORM\Index(name="programmes_discount_idx", columns={"discount"}),
 *         @ORM\Index(name="programmes_duration_idx", columns={"duration"}),
 *         @ORM\Index(name="programmes_name_idx", columns={"name"}),
 *     }
 * )
 */
class Programme implements JsonSerializable
{
    /**
     * id программы
     *
     * @ORM\Id
     * @ORM\Column(name="id_programme", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="programmes_id_seq")
     *
     * @var integer
     */
    private int $id;

    /**
     * название программы
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     *
     * @var string
     */
    private string $name;

    /**
     * срок работы программы
     *
     * @ORM\Column(name="duration", type="string", length=25, nullable=false)
     *
     * @var string
     */
    private string $duration;

    /**
     * Уровень сложности программы
     *
     * @ORM\Column(name="discount", type="string", length=50, nullable=false)
     *
     * @var string
     */
    private string $discount;

    /**
     * Статус программы
     *
     * @ORM\ManyToOne(targetEntity=\EfTech\SportClub\Entity\Program\Status::class)
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     *
     * @var Status
     */
    private Status $status;


    /**
     * Конструктор программы
     *
     * @param integer $id       - идентификатор программы
     * @param string  $name     - наименование программы
     * @param string  $duration - период действия программы
     * @param string  $discount - уровень сложности программы
     * @param Status  $status   - статус программы
     */
    public function __construct(
        int    $id,
        string $name,
        string $duration,
        string $discount,
        Status $status
    ) {
        $this->id       = $id;
        $this->name     = $name;
        $this->duration = $duration;
        $this->discount = $discount;
        $this->status   = $status;

    }//end __construct()


    /**
     * Получить id
     *
     * @return integer
     */
    final public function getId(): int
    {
        return $this->id;

    }//end getId()


    /**
     * Получить название программы
     *
     * @return string
     */
    final public function getName(): string
    {
        return $this->name;

    }//end getName()


    /**
     * Получить срок действия программы
     *
     * @return string
     */
    final public function getDuration(): string
    {
        return $this->duration;

    }//end getDuration()


    /**
     * Получить скидку программы
     *
     * @return string
     */
    final public function getDiscount(): string
    {
        return $this->discount;

    }//end getDiscount()


    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;

    }//end getStatus()


    /**
     * Выводит описание архивируемой программы
     *
     * @return string
     */
    public function getArchivingMessage(): string
    {
        return "Название: {$this->getName()}. Время: {$this->getDuration()}. Уровень подготовки: {$this->getDiscount()}.";

    }//end getArchivingMessage()


    /**
     * Реализация функции jsonSerialize
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id_programme' => $this->getId(),
            'name'         => $this->getName(),
            'duration'     => $this->getDuration(),
            'discount'     => $this->getDiscount(),
        ];

    }//end jsonSerialize()


    /**
     * Перенос программы в архив
     *
     * @return $this
     */
    public function moveToArchive(): self
    {
        if (Status::STATUS_ARCHIVE === $this->status->getName()) {
            throw new RuntimeException(
                "Программа с id {$this->getId()} уже находится в архиве"
            );
        }

        $this->status = new Status(Status::STATUS_ARCHIVE);
        return $this;

    }//end moveToArchive()


    /**
     * Создание объекта из массива
     *
     * @param  array $data
     * @return Programme
     * @throws InvalidDataStructureException - некорректная структура файла
     */
    public static function createFromArray(array $data): Programme
    {
        $requiredFields = [
            'id_programme',
            'name',
            'duration',
            'discount',
            'status',
        ];

        $missingFields = array_diff($requiredFields, array_keys($data));

        if (count($missingFields) > 0) {
            $errMsg = sprintf('Отсутствуют обязательные элементы: %s', implode(',', $missingFields));
            throw new InvalidDataStructureException($errMsg);
        }

        return new static(
            $data['id_programme'],
            $data['name'],
            $data['duration'],
            $data['discount'],
            $data['status']
        );

    }//end createFromArray()


}//end class
