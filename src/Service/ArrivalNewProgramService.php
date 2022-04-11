<?php

namespace EfTech\SportClub\Service;

use EfTech\SportClub\Entity\Program\Status;
use EfTech\SportClub\Entity\Programme;
use EfTech\SportClub\Entity\ProgramRepositoryInterface;
use EfTech\SportClub\Service\ArrivalNewProgramService\NewProgramDto;
use EfTech\SportClub\Service\ArrivalNewProgramService\ResultRegisteringProgramDto;

/**
 * Сервис регистрации программ
 */
class ArrivalNewProgramService
{

    /**
     * Репозиторий для работы с программами
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
     * Регистрация новой программы
     *
     * @param NewProgramDto $programDto
     *
     * @return ResultRegisteringProgramDto
     */
    public function registerProgram(NewProgramDto $programDto): ResultRegisteringProgramDto
    {
        $entity = new Programme(
            $this->programRepository->nextId(),
            $programDto->getName(),
            $programDto->getDuration(),
            $programDto->getDiscount(),
            new Status(Status::STATUS_IN_STOCK)
        );
        $this->programRepository->add($entity);
        return new ResultRegisteringProgramDto(
            $entity->getId(),
            $entity->getArchivingMessage(),
            $entity->getStatus()->getName()
        );

    }//end registerProgram()


}//end class
