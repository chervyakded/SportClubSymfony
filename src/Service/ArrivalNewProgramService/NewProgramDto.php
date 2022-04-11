<?php

namespace EfTech\SportClub\Service\ArrivalNewProgramService;

/**
 * DTO - данные для регистрации новой программы
 */
final class NewProgramDto
{

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
     * Уровень подготовки программы
     *
     * @var string
     */
    private string $discount;


    /**
     * @param string $name     - название программы
     * @param string $duration - длительность программы
     * @param string $discount - уровень подготовки программы
     */
    public function __construct(
        string $name,
        string $duration,
        string $discount
    ) {
        $this->name     = $name;
        $this->duration = $duration;
        $this->discount = $discount;

    }//end __construct()


    /**
     * Возвращает название программы
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;

    }//end getName()


    /**
     * Возвращает длительность программы
     *
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;

    }//end getDuration()


    /**
     * Возвращает уровень подготовки программы
     *
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;

    }//end getDiscount()


}//end class
