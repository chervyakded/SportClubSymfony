<?php

namespace EfTech\SportClub\Service;

use EfTech\SportClub\Entity\BenefitPass;
use EfTech\SportClub\Entity\BenefitPassRepositoryInterface;
use Psr\Log\LoggerInterface;
use EfTech\SportClub\Service\SearchBenefitPassService\BenefitPassDto;
use EfTech\SportClub\Service\SearchBenefitPassService\CustomerDto;
use EfTech\SportClub\Service\SearchBenefitPassService\SearchBenefitPassCriteria;

/**
 * Сервис поиска льгот
 */
class SearchBenefitPassService
{
    /**
     * Логер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Репозиторий для работы со льготами
     *
     * @var BenefitPassRepositoryInterface
     */
    private BenefitPassRepositoryInterface $benefitPassRepository;

    /**
     * @param LoggerInterface $logger - логер
     * @param BenefitPassRepositoryInterface $benefitPassRepository - репозиторий для работы со льготами
     */
    public function __construct(
        LoggerInterface                $logger,
        BenefitPassRepositoryInterface $benefitPassRepository
    ) {
        $this->logger = $logger;
        $this->benefitPassRepository = $benefitPassRepository;

    }//end __construct()

    /**
     * Ищем сущности по заданным критериям
     * @param SearchBenefitPassCriteria $searchCriteria
     * @return array
     */
    public function search(SearchBenefitPassCriteria $searchCriteria): array
    {
        $criteria = $this->searchCriteriaToArray($searchCriteria);
        $entitiesCollection = $this->benefitPassRepository->findBy($criteria);
        $dtoCollection = [];
        foreach ($entitiesCollection as $entity) {
            $dtoCollection[] = $this->createDto($entity);
        }
        $this->logger->info('found benefit passes: ' . count($entitiesCollection));
        return $dtoCollection;
    }//end search()

    private function searchCriteriaToArray(SearchBenefitPassCriteria $searchCriteria): array
    {
        $criteriaForRepository = [
            'customer_id'        => $searchCriteria->getCustomerId(),
            'customer_fullName'  => $searchCriteria->getCustomerFullName(),
            'customer_sex'       => $searchCriteria->getCustomerSex(),
            'customer_birthdate' => $searchCriteria->getCustomerBirthdate(),
            'customer_phone'     => $searchCriteria->getCustomerPhone(),
            'customer_passport'  => $searchCriteria->getCustomerPassport(),
            'id'              => $searchCriteria->getPassId(),
            'duration'        => $searchCriteria->getDuration(),
            'discount'        => $searchCriteria->getDiscount(),
            'type_benefit'    => $searchCriteria->getTypeBenefit(),
            'number_document' => $searchCriteria->getNumberDocument(),
            'end'             => $searchCriteria->getEnd(),
        ];
        return array_filter(
            $criteriaForRepository,
            static function ($item): bool {
                return null !== $item;
            }
        );
    }//end searchCriteriaToArray()

    private function createDto(BenefitPass $benefitPass): BenefitPassDto
    {
        $customer = $benefitPass->getCustomer();
        return new BenefitPassDto(
            $benefitPass->getId(),
            new CustomerDto(
                $customer->getId(),
                $customer->getFullName(),
                $customer->getSex(),
                $customer->getBirthdate(),
                $customer->getPhone(),
                $customer->getPassport(),
            ),
            $benefitPass->getDuration(),
            $benefitPass->getDiscount(),
            $benefitPass->getTypeBenefit(),
            $benefitPass->getNumberDocument(),
            $benefitPass->getEnd()
        );
    }//end createDto()
}//end class
