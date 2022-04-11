<?php

namespace EfTech\SportClub\Controller;

use EfTech\SportClub\Service\SearchProgrammeService;
use EfTech\SportClub\Service\SearchProgrammeService\ProgrammeDto;
use EfTech\SportClub\Service\SearchProgrammeService\SearchProgrammeCriteria;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер работы с программами
 */
class GetProgramCollectionController extends AbstractController
{
    /**
     * Логер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Сервис поиска программ
     *
     * @var SearchProgrammeService
     */
    private SearchProgrammeService $searchProgrammeService;

    /**
     * @param LoggerInterface        $logger - логер
     * @param SearchProgrammeService $searchProgrammeService - сервис поиска программ
     */
    public function __construct(
        LoggerInterface $logger,
        SearchProgrammeService $searchProgrammeService
    ) {
        $this->logger                 = $logger;
        $this->searchProgrammeService = $searchProgrammeService;
    }

//    /**
//     * Валидирует параметры запроса
//     *
//     * @param  Request $serverRequest - объект серверного http запроса
//     * @return string|null - строка с ошибкой или null если ошибки нет
//     */
//    private function validateQueryParams(Request $serverRequest): ?string
//    {
//        $paramsValidation = [
//            'id'           => 'incorrect param id',
//            'id_programme' => 'incorrect id_programme',
//            'name'         => 'incorrect name programme',
//            'duration'     => 'incorrect duration programme',
//            'discount'     => 'incorrect discount programme',
//        ];
//        $queryParams      = array_merge($serverRequest->getQueryParams(), $serverRequest->getAttributes());
//        return Assert::arrayElementsIsString($paramsValidation, $queryParams);
//    }

    /**
     * Реализация поиска программ по критериям
     *
     * @param  Request $serverRequest - серверный объект запроса
     * @return Response - объект http ответа
     */
    public function __invoke(Request $serverRequest): Response
    {
        $this->logger->info('dispatch "program" url');
//        $resultParamValidation = $this->validateQueryParams($serverRequest);
        $resultParamValidation = null;
        if (null === $resultParamValidation) {
            $params       = array_merge(
                $serverRequest->query->all(),
                $serverRequest->attributes->all()
            );
            $foundProgram = $this->searchProgrammeService->search(
                (new SearchProgrammeCriteria())
                    ->setIdProgramme($params['id_programme'] ?? null)
                    ->setName($params['name'] ?? null)
                    ->setDuration($params['duration'] ?? null)
                    ->setDiscount($params['discount'] ?? null)
            );
            $httpCode     = $this->buildHttpCode($foundProgram);
            $result       = $this->buildResult($foundProgram);
        } else {
            $httpCode = 500;
            $result   = [
                'status' => 'fail',
                'result' => $resultParamValidation,
            ];
        }
        return $this->json($result, $httpCode);
    }

    /**
     * Подготавливает http код
     *
     * @param  array $foundProgram
     * @return integer
     */
    protected function buildHttpCode(array $foundProgram): int
    {
        return 200;
    }

    /**
     * Подготавливает данные для ответа
     *
     * @param  array $foundPrograms
     * @return array
     */
    protected function buildResult(array $foundPrograms): array
    {
        $result = [];
        foreach ($foundPrograms as $foundProgram) {
            $result[] = $this->serializeProgram($foundProgram);
        }
        return $result;
    }

    /**
     * Сериализация программ
     *
     * @param ProgrammeDto $programmeDto
     * @return array
     */
    private function serializeProgram(ProgrammeDto $programmeDto): array
    {
        return [
            'id_programme' => $programmeDto->getIdProgramme(),
            'name'         => $programmeDto->getName(),
            'duration'     => $programmeDto->getDuration(),
            'discount'     => $programmeDto->getDiscount(),
        ];
    }
}
