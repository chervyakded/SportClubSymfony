<?php

namespace EfTech\SportClub\Controller;

use EfTech\SportClub\Service\SearchBenefitPassService;
use EfTech\SportClub\Service\SearchBenefitPassService\BenefitPassDto;
use EfTech\SportClub\Service\SearchBenefitPassService\SearchBenefitPassCriteria;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GetBenefitPassCollectionController extends AbstractController
{
    /**
     * Логер
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Сервис поиска льгот
     * @var SearchBenefitPassService
     */
    private SearchBenefitPassService $searchBenefitPassService;

    /**
     * @param LoggerInterface $logger - логер
     * @param SearchBenefitPassService $searchBenefitPassService - сервис поиска льгот
     */
    public function __construct(
        LoggerInterface          $logger,
        SearchBenefitPassService $searchBenefitPassService
    ) {
        $this->logger = $logger;
        $this->searchBenefitPassService = $searchBenefitPassService;
    }

//    /**
//     * Валидирует параметры запроса
//     *
//     * @param Request $serverRequest - объект серверного http запроса
//     * @return string|null - строка с ошибкой или null если ошибки нет
//     */
//    private function validateQueryParams(Request $serverRequest): ?string
//    {
//        $paramsValidation = [
//            'customer_id' => 'incorrect param "customer_id"',
//            'full_name' => 'incorrect param "full_name"',
//            'sex' => 'incorrect param "sex"',
//            'birthdate' => 'incorrect param "birthdate"',
//            'phone' => 'incorrect param "phone"',
//            'passport' => 'incorrect param "passport"',
//            'type_benefit' => 'incorrect param "type_benefit"',
//            'number_document' => 'incorrect param "number_document"',
//            'end' => 'incorrect param "end"',
//        ];
//        $queryParams = array_merge($serverRequest->getQueryParams(), $serverRequest->getAttributes());
//        return Assert::arrayElementsIsString($paramsValidation, $queryParams);
//    }

    /**
     * Реализация поиска льгот по критериям
     *
     * @param Request $serverRequest - серверный объект запроса
     * @return Response - объект http ответа
     */
    public function __invoke(Request $serverRequest): Response
    {
        $this->logger->info('dispatch "benefit_pass" url');
//        $resultParamValidation = $this->validateQueryParams($serverRequest);
        $resultParamValidation = null;
        if (null === $resultParamValidation) {
            $params = array_merge(
                $serverRequest->query->all(),
                $serverRequest->attributes->all()
            );
            $foundBenefitPasses = $this->searchBenefitPassService->search(
                (new SearchBenefitPassCriteria())
                    ->setCustomerId($params['customer_id'] ?? null)
                    ->setCustomerFullName($params['customer_full_name'] ?? null)
                    ->setCustomerSex($params['customer_sex'] ?? null)
                    ->setCustomerBirthdate($params['customer_birthdate'] ?? null)
                    ->setCustomerPhone($params['customer_phone'] ?? null)
                    ->setCustomerPassport($params['customer_passport'] ?? null)
                    ->setPassId($params['pass_id'] ?? null)
                    ->setDuration($params['duration'] ?? null)
                    ->setDiscount($params['discount'] ?? null)
                    ->setTypeBenefit($params['type_benefit'] ?? null)
                    ->setNumberDocument($params['number_document'] ?? null)
                    ->setEnd($params['end'] ?? null)
            );
            $result = $this->buildResult($foundBenefitPasses);
            $httpCode = $this->buildHttpCode($foundBenefitPasses);
        } else {
            $httpCode = 500;
            $result = [
                'status' => 'fail',
                'result' => $resultParamValidation,
            ];
        }
        return $this->json($result, $httpCode);
    }

    /**
     * Подготавливает данные для ответа
     *
     * @param array $foundBenefitPasses
     * @return array
     */
    protected function buildResult(array $foundBenefitPasses): array
    {
        $result = [];
        foreach ($foundBenefitPasses as $foundBenefitPass) {
            $result[] = $this->serializeBenefitPass($foundBenefitPass);
        }
        return $result;
    }

    /**
     * Сериализация льготных абонементов
     *
     * @param BenefitPassDto $benefitPassDto
     * @return array
     */
    private function serializeBenefitPass(BenefitPassDto $benefitPassDto): array
    {
        return [
            'customer_id' => $benefitPassDto->getCustomer()->getCustomerId(),
            'full_name'   => $benefitPassDto->getCustomer()->getFullName(),
            'sex'         => $benefitPassDto->getCustomer()->getSex(),
            'birthdate'   => $benefitPassDto->getCustomer()->getBirthdate()->format('d.m.Y'),
            'phone'       => $benefitPassDto->getCustomer()->getPhone(),
            'passport'    => $benefitPassDto->getCustomer()->getPassport(),
            'type_benefit'    => $benefitPassDto->getTypeBenefit(),
            'number_document' => $benefitPassDto->getNumberDocument(),
            'end'             => $benefitPassDto->getEnd(),
        ];
    }

    /**
     * Подготавливает http код
     *
     * @param array $foundBenefitPass
     * @return integer
     */
    protected function buildHttpCode(array $foundBenefitPass): int
    {
        return 200;
    }
}
