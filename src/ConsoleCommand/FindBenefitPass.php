<?php

namespace EfTech\SportClub\ConsoleCommand;

use EfTech\SportClub\Service\SearchBenefitPassService;
use EfTech\SportClub\Service\SearchBenefitPassService\BenefitPassDto;
use EfTech\SportClub\Service\SearchBenefitPassService\SearchBenefitPassCriteria;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FindBenefitPass extends Command
{
    /**
     * Сервис поиска льгот
     *
     * @var SearchBenefitPassService
     */
    private SearchBenefitPassService $searchBenefitPassService;

    /**
     * @param SearchBenefitPassService $searchBenefitPassService
     */
    public function __construct(
        SearchBenefitPassService $searchBenefitPassService
    ) {
        parent::__construct();
        $this->searchBenefitPassService = $searchBenefitPassService;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('sportClub:find-benefit-passes');
        $this->setDescription('Find benefit passes');
        $this->setHelp('Found benefit passes by criteria');
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
        $this->addOption(
            'type_benefit',
            't',
            InputOption::VALUE_REQUIRED,
            'Found type_benefit'
        );
        parent::configure();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $params = $input->getOptions();
        $benefitPassDto = $this->searchBenefitPassService->search(
            (new SearchBenefitPassCriteria())
                ->setCustomerId($params['customer_id'] ?? null)
                ->setPassId($params['pass_id'] ?? null)
                ->setDuration($params['duration'] ?? null)
                ->setTypeBenefit($params['type_benefit'] ?? null)
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


    private function buildJsonData(array $foundBenefitPasses): array
    {
        $result = [];
        foreach ($foundBenefitPasses as $foundBenefitPass) {
            $result[] = $this->serializeBenefitPass($foundBenefitPass);
        }
        return $result;
    }

    private function serializeBenefitPass(BenefitPassDto $benefitPassDto): array
    {
        return [
            'customer_id' => $benefitPassDto->getCustomer()->getCustomerId(),
            'full_name' => $benefitPassDto->getCustomer()->getFullName(),
            'sex' => $benefitPassDto->getCustomer()->getSex(),
            'birthdate' => $benefitPassDto->getCustomer()->getBirthdate()->format('d.m.Y'),
            'phone' => $benefitPassDto->getCustomer()->getPhone(),
            'passport' => $benefitPassDto->getCustomer()->getPassport(),
            'type_benefit' => $benefitPassDto->getTypeBenefit(),
            'number_document' => $benefitPassDto->getNumberDocument(),
            'end' => $benefitPassDto->getEnd(),
        ];
    }
}