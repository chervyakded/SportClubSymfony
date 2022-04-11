<?php

namespace EfTech\SportClub\Service;

use EfTech\SportClub\Entity\Customer;
use EfTech\SportClub\Entity\CustomerRepositoryInterface;
use Psr\Log\LoggerInterface;
use EfTech\SportClub\Service\SearchPurchaseItemService\CustomerDto;
use EfTech\SportClub\Service\SearchPurchaseItemService\PurchasedItemDto;
use EfTech\SportClub\Service\SearchPurchaseItemService\SearchPurchasedItemCriteria;

/**
 * Сервис поиска продуктов
 */
class SearchPurchaseItemService
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
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @param LoggerInterface $logger - логер
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        LoggerInterface                  $logger,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->logger = $logger;
        $this->customerRepository = $customerRepository;
    }

    public function search(SearchPurchasedItemCriteria $searchCriteria): array
    {
        $criteria = $this->searchCriteriaToArray($searchCriteria);
        $entitiesCollection = $this->customerRepository->findBy($criteria);
        $dtoCollection = [];
        foreach ($entitiesCollection as $entity) {
            $dtoCollection[] = $this->createDto($entity);
        }
        $this->logger->info('found purchased items: ' . count($entitiesCollection));
        return $dtoCollection;
    }

    private function searchCriteriaToArray(SearchPurchasedItemCriteria $searchCriteria): array
    {
        $criteriaForRepository = [
            'customer_id'        => $searchCriteria->getCustomerId(),
            'customer_fullName'  => $searchCriteria->getCustomerFullName(),
            'customer_sex'       => $searchCriteria->getCustomerSex(),
            'customer_birthdate' => $searchCriteria->getCustomerBirthdate(),
            'customer_phone'     => $searchCriteria->getCustomerPhone(),
            'customer_passport'  => $searchCriteria->getCustomerPassport(),
            'purchasedItemId' => $searchCriteria->getPurchasedItemId(),
            'pass'            => $searchCriteria->getPass(),
            'programId'       => $searchCriteria->getProgramId(),
            'price'           => $searchCriteria->getPrice()
        ];
        return array_filter(
            $criteriaForRepository,
            static function ($item): bool {
                return null !== $item;
            }
        );
    }

    /**
     * @param Customer $customer
     * @return CustomerDto
     */
    private function createDto(Customer $customer): CustomerDto
    {
        $purchasedItemDto = [];
        foreach ($customer->getPurchasedItems() as $purchasedItem) {
            $purchasedItemDto[] = new PurchasedItemDto(
                $purchasedItem->getPurchasedItemId(),
                $purchasedItem->getPass()->getId(),
                $purchasedItem->getProgramId(),
                $purchasedItem->getPrice(),
                $purchasedItem->getCurrency()->getName()
            );
        }
        return new CustomerDto(
            $customer->getId(),
            $customer->getFullName(),
            $customer->getSex(),
            $customer->getBirthdate(),
            $customer->getPhone(),
            $customer->getPassport(),
            $purchasedItemDto
        );
    }
}
