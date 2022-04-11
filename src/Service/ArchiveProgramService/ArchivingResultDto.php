<?php

namespace EfTech\SportClub\Service\ArchiveProgramService;

/**
 * Результат архивации программы
 */
final class ArchivingResultDto
{

    /**
     * id программы
     *
     * @var integer
     */
    private int $programId;

    /**
     * Сообщение об архивации
     *
     * @var string
     */
    private string $archivingMessage;

    /**
     * Статус программы
     *
     * @var string
     */
    private string $status;


    /**
     * @param integer $programId
     * @param string  $archivingMessage
     * @param string  $status
     */
    public function __construct(
        int $programId,
        string $archivingMessage,
        string $status
    ) {
        $this->programId        = $programId;
        $this->archivingMessage = $archivingMessage;
        $this->status           = $status;

    }//end __construct()


    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->programId;

    }//end getId()


    /**
     * @return string
     */
    public function getArchivingMessage(): string
    {
        return $this->archivingMessage;

    }//end getArchivingMessage()


    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;

    }//end getStatus()


}//end class
