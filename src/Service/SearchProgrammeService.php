<?php

namespace EfTech\SportClub\Service;

use EfTech\SportClub\Entity\Programme;
use EfTech\SportClub\Entity\ProgramRepositoryInterface;
use Psr\Log\LoggerInterface;
use EfTech\SportClub\Service\SearchProgrammeService\ProgrammeDto;
use EfTech\SportClub\Service\SearchProgrammeService\SearchProgrammeCriteria;

/**
 * Сервис поиска программ
 */
class SearchProgrammeService
{

    /**
     * Логер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Репозиторий для работы с программами
     *
     * @var ProgramRepositoryInterface
     */
    private ProgramRepositoryInterface $programRepository;


    /**
     * @param LoggerInterface            $logger            - логер
     * @param ProgramRepositoryInterface $programRepository - репозиторий для работы с программами
     */
    public function __construct(
        LoggerInterface $logger,
        ProgramRepositoryInterface $programRepository
    ) {
        $this->logger            = $logger;
        $this->programRepository = $programRepository;

    }//end __construct()


    /**
     * Поиск сущности по заданным критериям
     *
     * @param  SearchProgrammeCriteria $searchCriteria
     * @return array
     */
    public function search(SearchProgrammeCriteria $searchCriteria): array
    {
        $criteria           = $this->searchCriteriaToArray($searchCriteria);
        $entitiesCollection = $this->programRepository->findBy($criteria);
        $dtoCollection      = [];
        foreach ($entitiesCollection as $entity) {
            $dtoCollection[] = $this->createDto($entity);
        }
        $this->logger->info('found programmes: '.count($entitiesCollection));
        return $dtoCollection;
    }

    private function searchCriteriaToArray(SearchProgrammeCriteria $searchCriteria): array
    {
        $criteriaForRepository = [
            'id'       => $searchCriteria->getIdProgramme(),
            'name'     => $searchCriteria->getName(),
            'duration' => $searchCriteria->getDuration(),
            'discount' => $searchCriteria->getDiscount(),
        ];
        return array_filter(
            $criteriaForRepository,
            static function ($item): bool {
                return null !== $item;
            }
        );

    }//end searchCriteriaToArray()


    /**
     * Логика создания ProgrammeDto
     *
     * @param  Programme $programme
     * @return ProgrammeDto
     */
    private function createDto(Programme $programme): ProgrammeDto
    {
        return new ProgrammeDto(
            $programme->getId(),
            $programme->getName(),
            $programme->getDuration(),
            $programme->getDiscount(),
        );

    }//end createDto()


}//end class
