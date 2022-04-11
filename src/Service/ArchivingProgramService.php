<?php

namespace EfTech\SportClub\Service;

use EfTech\SportClub\Entity\Programme;
use EfTech\SportClub\Entity\ProgramRepositoryInterface;
use EfTech\SportClub\Service\ArchiveProgramService\ArchivingResultDto;
use EfTech\SportClub\Service\ArchiveProgramService\Exception\ProgramNotFoundException;

/**
 * Сервис архивации программ
 */
class ArchivingProgramService
{

    /**
     * Репозиторий для работы с текстовыми документами
     *
     * @var ProgramRepositoryInterface
     */
    private ProgramRepositoryInterface $programRepository;


    /**
     * @param ProgramRepositoryInterface $programRepository
     */
    public function __construct(ProgramRepositoryInterface $programRepository)
    {
        $this->programRepository = $programRepository;

    }//end __construct()


    /**
     * Архивирует программу с заданным id
     *
     * @param  integer $programId
     * @return ArchivingResultDto
     */
    public function archive(int $programId): ArchivingResultDto
    {
        $entities = $this->programRepository->findBy(['id_programme' => $programId]);
        if (1 !== count($entities)) {
            throw new ProgramNotFoundException(
                'Не удалось отправить программу в архив. Программа с id '.$programId.' не найден'
            );
        }

        /*
            @var Programme $entity
        */
        $entity = current($entities);
        $entity->moveToArchive();
        $this->programRepository->save($entity);
        return new ArchivingResultDto(
            $entity->getId(),
            $entity->getArchivingMessage(),
            $entity->getStatus()
        );

    }//end archive()


}//end class
