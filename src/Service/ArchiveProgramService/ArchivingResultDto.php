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
    private int $id;

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
     * @param integer $id
     * @param string  $archivingMessage
     * @param string  $status
     */
    public function __construct(
        int    $id,
        string $archivingMessage,
        string $status
    ) {
        $this->id               = $id;
        $this->archivingMessage = $archivingMessage;
        $this->status           = $status;
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getArchivingMessage(): string
    {
        return $this->archivingMessage;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
