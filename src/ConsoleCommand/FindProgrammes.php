<?php

namespace EfTech\SportClub\ConsoleCommand;

use EfTech\SportClub\Service\SearchProgrammeService;
use EfTech\SportClub\Service\SearchProgrammeService\ProgrammeDto;
use EfTech\SportClub\Service\SearchProgrammeService\SearchProgrammeCriteria;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FindProgrammes extends Command
{
    /**
     * Сервис поиска программ
     *
     * @var SearchProgrammeService
     */
    private SearchProgrammeService $searchProgrammeService;

    /**
     * @param SearchProgrammeService $searchProgrammeService
     */
    public function __construct(
        SearchProgrammeService $searchProgrammeService
    ) {
        parent::__construct();
        $this->searchProgrammeService = $searchProgrammeService;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('sportClub:find-programmes');
        $this->setDescription('Find programmes');
        $this->setHelp('Found programmes by criteria');
        $this->addOption(
            'id_programme',
            'i',
            InputOption::VALUE_REQUIRED,
            'Found id_programme'
        );
        $this->addOption(
            'name',
            'm',
            InputOption::VALUE_REQUIRED,
            'Found name'
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
    $benefitPassDto = $this->searchProgrammeService->search(
        (new SearchProgrammeCriteria())
            ->setIdProgramme($params['id_programme'] ?? null)
            ->setName($params['name'] ?? null)
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

    private function buildJsonData(array $foundPrograms): array
    {
        $result = [];
        foreach ($foundPrograms as $foundProgram) {
            $result[] = $this->serializeProgram($foundProgram);
        }
        return $result;
    }

    private function serializeProgram(ProgrammeDto $programmeDto): array
    {
        return [
            'id_programme' => $programmeDto->getIdProgramme(),
            'name' => $programmeDto->getName(),
            'duration' => $programmeDto->getDuration(),
            'discount' => $programmeDto->getDiscount(),
        ];
    }
}