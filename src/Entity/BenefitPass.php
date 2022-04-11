<?php

namespace EfTech\SportClub\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Льготы
 *
 * @ORM\Entity(repositoryClass=\EfTech\SportClub\Repository\BenefitPassDoctrineRepository::class)
 * @ORM\Table(
 *     name="benefit_pass",
 *     indexes={
 *         @ORM\Index(name="benefit_pass_type_benefit_idx", columns={"type_benefit"}),
 *         @ORM\Index(name="benefit_pass_number_document_idx", columns={"number_document"}),
 *         @ORM\Index(name="benefit_pass_end_idx", columns={"end_of_benefit_pass"}),
 *     }
 * )
 */
class BenefitPass extends Pass
{
    /**
     * тип льготы
     *
     * @ORM\Column(name="type_benefit", type="string", length=25, nullable=false)
     *
     * @var string
     */
    private string $type_benefit;

    /**
     * номер льготы
     *
     * @ORM\Column(name="number_document", type="string", length=15, nullable=false)
     *
     * @var string
     */
    private string $number_document;

    /**
     * конец срока продления льготы
     *
     * @ORM\Column(name="end_of_benefit_pass", type="string", length=10, nullable=false)
     *
     * @var string|null
     */
    private string $end;

    /**
     * Конструктор льготного абонемента
     *
     * @inheritDoc
     * @param string      $type_benefit    - тип льготы
     * @param int         $number_document - номер льготы
     * @param string|null $end             - конец срока продления льготы
     */
    public function __construct(
        int      $id,
        string   $duration,
        ?string  $discount,
        Customer $customer,
        string   $type_benefit,
        int      $number_document,
        ?string  $end
    ) {
        parent::__construct(
            $id,
            $duration,
            $discount,
            $customer
        );
        $this->type_benefit    = $type_benefit;
        $this->number_document = $number_document;
        $this->end             = $end;
    }//end __construct()

    /**
     * Получить тип льготы
     *
     * @return string
     */
    final public function getTypeBenefit(): string
    {
        return $this->type_benefit;
    }//end getTypeBenefit()

    /**
     * Получить номер документа
     *
     * @return string
     */
    final public function getNumberDocument(): string
    {
        return $this->number_document;
    }//end getNumberDocument()

    /**
     * Получить дату окончания действия льготы
     *
     * @return string
     */
    final public function getEnd(): string
    {
        return $this->end;
    }//end getEnd()
}//end class
