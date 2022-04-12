<?php

namespace EfTech\SportClub\ConsoleCommand;

use EfTech\SportClub\Service\SearchPassService\SearchPassCriteria;
use EfTech\SportClub\Service\SearchPurchaseItemService;
use EfTech\SportClub\Service\SearchPurchaseItemService\PurchasedItemDto;
use EfTech\SportClub\Service\SearchPurchaseItemService\CustomerDto;
use EfTech\SportClub\Service\SearchPurchaseItemService\SearchPurchasedItemCriteria;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FindPurchasedItems extends Command
{
    /**
     * Сервис поиска продуктов
     *
     * @var SearchPurchaseItemService
     */
    private SearchPurchaseItemService $searchPurchaseItemService;

    /**
     * @param SearchPurchaseItemService $searchPurchaseItemService
     */
    public function __construct(
        SearchPurchaseItemService $searchPurchaseItemService
    ) {
        parent::__construct();
        $this->searchPurchaseItemService = $searchPurchaseItemService;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('sportClub:find-purchased-items');
        $this->setDescription('Find purchased items');
        $this->setHelp('Found purchased items by criteria');
        $this->addOption(
            'purchased_item_id',
            'i',
            InputOption::VALUE_REQUIRED,
            'Found purchased_item_id'
        );
        $this->addOption(
            'customer_id',
            'c',
            InputOption::VALUE_REQUIRED,
            'Found customer_id'
        );
        $this->addOption(
            'price',
            'p',
            InputOption::VALUE_REQUIRED,
            'Found price'
        );
        parent::configure();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $params = $input->getOptions();
        $benefitPassDto = $this->searchPurchaseItemService->search(
            (new SearchPurchasedItemCriteria())
                ->setPurchasedItemId($params['pass_id'] ?? null)
                ->setCustomerId($params['customer_id'] ?? null)
                ->setPrice($params['duration'] ?? null)
        );
        $jsonData = $this->buildJsonData($benefitPassDto);
        $output->writeln(
            json_encode(
                $jsonData,
                JSON_THROW_ON_ERROR |
                JSON_PRETTY_PRINT |
                JSON_UNESCAPED_UNICODE
            )
        );
        return self::SUCCESS;
    }

    private function buildJsonData(array $foundPurchasedItems): array
    {
        $result = [];
        foreach ($foundPurchasedItems as $foundPurchasedItem) {
            $result[] = $this->serializePurchasedItem($foundPurchasedItem);
        }
        return $result;
    }

    private function serializePurchasedItem(CustomerDto $customerDto): array
    {
        $jsonData = [
            'customer_id' => $customerDto->getId(),
            'full_name' => $customerDto->getFullName(),
            'sex' => $customerDto->getSex(),
            'birthdate' => $customerDto->getBirthdate()->format('d.m.Y'),
            'phone' => $customerDto->getPhone(),
            'passport' => $customerDto->getPassport(),
        ];
        /** @var PurchasedItemDto $purchasedItem */
        foreach ($customerDto->getPurchasedItemDto() as $purchasedItemDto) {
            $jsonData['purchased_items'] = array_values(array_map(static function (PurchasedItemDto $purchasedItemDto) {
                return [
                    'purchased_item_id' => $purchasedItemDto->getPurchasedItemId(),
                    'pass_id' => $purchasedItemDto->getPassId(),
                    'id_programme' => $purchasedItemDto->getIdProgramme(),
                    'price' => $purchasedItemDto->getPrice(),
                    'currency' => $purchasedItemDto->getCurrency(),
                ];
            }, $customerDto->getPurchasedItemDto()));
        }
        return $jsonData;
    }
}