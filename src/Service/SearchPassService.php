<?php

namespace EfTech\SportClub\Service;

use EfTech\SportClub\Entity\Pass;
use EfTech\SportClub\Entity\PassRepositoryInterface;
use Psr\Log\LoggerInterface;
use EfTech\SportClub\Service\SearchPassService\PassDto;
use EfTech\SportClub\Service\SearchPassService\SearchPassCriteria;

/**
 * Сервис поиска абонементов
 */
class SearchPassService
{

    /**
     * Логер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Репозиторий для работы с абонементами
     *
     * @var PassRepositoryInterface
     */
    private PassRepositoryInterface $passRepository;


    /**
     * @param LoggerInterface         $logger         - логер
     * @param PassRepositoryInterface $passRepository
     */
    public function __construct(
        LoggerInterface $logger,
        PassRepositoryInterface $passRepository
    ) {
        $this->logger         = $logger;
        $this->passRepository = $passRepository;

    }//end __construct()


    /**
     * Поиск сущности по заданным критериям
     *
     * @param  SearchPassCriteria $searchCriteria
     * @return array
     */
    public function search(SearchPassCriteria $searchCriteria): array
    {
        $criteria           = $this->searchCriteriaToArray($searchCriteria);
        $entitiesCollection = $this->passRepository->findBy($criteria);
        $dtoCollection      = [];
        foreach ($entitiesCollection as $entity) {
            $dtoCollection[] = $this->createDto($entity);
        }

        $this->logger->info('found passes: '.count($entitiesCollection));
        return $dtoCollection;

    }//end search()


    private function searchCriteriaToArray(SearchPassCriteria $searchCriteria): array
    {
        $criteriaForRepository = [
            'id'       => $searchCriteria->getPassId(),
            'duration' => $searchCriteria->getDuration(),
            'discount' => $searchCriteria->getDiscount(),
            'customer_id'        => $searchCriteria->getCustomerId(),
            'customer_full_name' => $searchCriteria->getCustomerFullName(),
            'customer_sex'       => $searchCriteria->getCustomerSex(),
            'customer_birthdate' => $searchCriteria->getCustomerBirthdate(),
            'customer_phone'     => $searchCriteria->getCustomerPhone(),
            'customer_passport'  => $searchCriteria->getCustomerPassport(),
        ];
        return array_filter(
            $criteriaForRepository,
            static function ($item): bool {
                return null !== $item;
            }
        );

    }//end searchCriteriaToArray()


    private function createDto(Pass $pass): PassDto
    {
        return new PassDto(
            $pass->getId(),
            $pass->getDuration(),
            $pass->getDiscount(),
            $pass->getCustomer()->getId(),
        );

    }//end createDto()


}//end class
