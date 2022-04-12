<?php

namespace EfTech\SportClub\ConsoleCommand;

use EfTech\SportClub\Service\SearchPassService;
use EfTech\SportClub\Service\SearchPassService\PassDto;
use EfTech\SportClub\Service\SearchPassService\SearchPassCriteria;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FindPass extends Command
{
    /**
     * Сервис поиска абонементов
     *
     * @var SearchPassService
     */
    private SearchPassService $searchPassService;

    /**
     * @param SearchPassService $searchPassService
     */
    public function __construct(
        SearchPassService $searchPassService
    ) {
        parent::__construct();
        $this->searchPassService = $searchPassService;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('sportClub:find-passes');
        $this->setDescription('Find passes');
        $this->setHelp('Found passes by criteria');
        $this->addOption(
            'customer_id',
            'c',
            InputOption::VALUE_REQUIRED,
            'Found customer_id'
        );
        $this->addOption(
            'pass_id',
            'i',
            InputOption::VALUE_REQUIRED,
            'Found pass_id'
        );
        $this->addOption(
            'duration',
            'd',
            InputOption::VALUE_REQUIRED,
            'Found duration'
        );
        parent::configure();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $params = $input->getOptions();
        $benefitPassDto = $this->searchPassService->search(
            (new SearchPassCriteria())
                ->setCustomerId($params['customer_id'] ?? null)
                ->setPassId($params['pass_id'] ?? null)
                ->setDuration($params['duration'] ?? null)
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

    private function buildJsonData(array $foundPasses): array
    {
        $result = [];
        foreach ($foundPasses as $foundPass) {
            $result[] = $this->serializePass($foundPass);
        }
        return $result;
    }

    private function serializePass(PassDto $passDto): array
    {
        return [
            'pass_id' => $passDto->getPassId(),
            'duration' => $passDto->getDuration(),
            'discount' => $passDto->getDiscount(),
            'customer_id' => $passDto->getCustomerId(),
        ];
    }
}