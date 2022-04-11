<?php

namespace EfTech\SportClub\Service\ArrivalNewProgramService;

/**
 * Результат регистрации программы
 */
final class ResultRegisteringProgramDto
{

    /**
     * id программы
     *
     * @var integer
     */
    private int $id;

    /**
     * Сообщение о регистрации программы
     *
     * @var string
     */
    private string $registeringMessage;

    /**
     * Статус программы
     *
     * @var string
     */
    private string $status;


    /**
     * @param integer $id                 - id программы
     * @param string  $registeringMessage - сообщение о регистрации программы
     * @param string  $status             - статус программы
     */
    public function __construct(
        int $id,
        string $registeringMessage,
        string $status
    ) {
        $this->id                 = $id;
        $this->registeringMessage = $registeringMessage;
        $this->status             = $status;

    }//end __construct()


    /**
     * Возвращает id программы
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;

    }//end getId()


    /**
     * Возвращает сообщение о регистрации программы
     *
     * @return string
     */
    public function getRegisteringMessage(): string
    {
        return $this->registeringMessage;

    }//end getRegisteringMessage()


    /**
     * Возвращает статус программы
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;

    }//end getStatus()


}//end class
