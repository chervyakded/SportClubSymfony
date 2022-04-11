<?php

namespace EfTech\SportClub\Service\SearchProgrammeService;

/**
 * Логика поиска программ по критериям
 */
class SearchProgrammeCriteria
{

    /**
     * id программы
     *
     * @var integer|null
     */
    private ?int $id_programme = null;

    /**
     * Название программы
     *
     * @var string|null
     */
    private ?string $name = null;

    /**
     * Длительность программы
     *
     * @var string|null
     */
    private ?string $duration = null;

    /**
     * Уровень сложности программы
     *
     * @var string|null
     */
    private ?string $discount = null;

    /**
     * Перевод объекта в массив и удаление нулов
     *
     * @param  SearchProgrammeCriteria $criteria
     * @return array
     */
    public function isArray(SearchProgrammeCriteria $criteria): array
    {
        $programArr  = [
            'id_programme',
            'name',
            'duration',
            'discount',
        ];
        $criteriaArr = [];
        $i           = 0;
        foreach ((array) $criteria as $cr) {
            if ($cr !== null) {
                $criteriaArr += [$programArr[$i] => $cr];
            }
            $i++;
        }
        return $criteriaArr;
    }

    /**
     * Получить id программы
     *
     * @return integer|null
     */
    public function getIdProgramme(): ?int
    {
        return $this->id_programme;
    }//end getIdProgramme()

    /**
     * Изменить уровень сложности программы
     *
     * @param  string|null $discount
     * @return SearchProgrammeCriteria
     */
    public function setDiscount(?string $discount): SearchProgrammeCriteria
    {
        $this->discount = $discount;
        return $this;
    }//end setDiscount()

    /**
     * Изменить id программы
     *
     * @param  integer|null $id_programme
     * @return SearchProgrammeCriteria
     */
    public function setIdProgramme(?int $id_programme): SearchProgrammeCriteria
    {
        $this->id_programme = $id_programme;
        return $this;
    }//end setIdProgramme()

    /**
     * Получить название программы
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }//end getName()

    /**
     * Изменить название программы
     *
     * @param  string|null $name
     * @return SearchProgrammeCriteria
     */
    public function setName(?string $name): SearchProgrammeCriteria
    {
        $this->name = $name;
        return $this;
    }//end setName()

    /**
     * Получить длительность программы
     *
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }//end getDuration()

    /**
     * Изменить длительность программы
     *
     * @param  string|null $duration
     * @return SearchProgrammeCriteria
     */
    public function setDuration(?string $duration): SearchProgrammeCriteria
    {
        $this->duration = $duration;
        return $this;
    }//end setDuration()

    /**
     * Получить уровень сложности программы
     *
     * @return string|null
     */
    public function getDiscount(): ?string
    {
        return $this->discount;
    }//end getDiscount()
}//end class
