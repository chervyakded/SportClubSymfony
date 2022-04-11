<?php

namespace EfTech\SportClub\Service\SearchProgrammeService;

class ProgrammeDto
{

    /**
     * id программы
     *
     * @var integer
     */
    private int $id_programme;

    /**
     * Название программы
     *
     * @var string
     */
    private string $name;

    /**
     * Длительность программы
     *
     * @var string
     */
    private string $duration;

    /**
     * Уровень сложности программы
     *
     * @var string
     */
    private string $discount;


    /**
     * @param integer $id_programme - id программы
     * @param string  $name         - название программы
     * @param string  $duration     - длительность программы
     * @param string  $discount     - уровень сложности программы
     */
    public function __construct(
        int $id_programme,
        string $name,
        string $duration,
        string $discount
    ) {
        $this->id_programme = $id_programme;
        $this->name         = $name;
        $this->duration     = $duration;
        $this->discount     = $discount;

    }//end __construct()


    /**
     * Получить id программы
     *
     * @return integer
     */
    public function getIdProgramme(): int
    {
        return $this->id_programme;

    }//end getIdProgramme()


    /**
     * Получить название программы
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;

    }//end getName()


    /**
     * Получить длительность программы
     *
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;

    }//end getDuration()


    /**
     * Получить уровень сложности программы
     *
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;

    }//end getDiscount()


}//end class
