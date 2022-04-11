<?php

namespace EfTech\SportClub\Controller;

use EfTech\SportClub\Service\SearchBenefitPassService;
use EfTech\SportClub\Service\SearchBenefitPassService\BenefitPassDto;
use EfTech\SportClub\Service\SearchBenefitPassService\SearchBenefitPassCriteria;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GetBenefitPassCollectionController extends AbstractController
{
    /**
     * Сервис валидации
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

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
     * @param ValidatorInterface       $validator                - сервис валидации
     * @param LoggerInterface          $logger                   - логер
     * @param SearchBenefitPassService $searchBenefitPassService - сервис поиска льгот
     */
    public function __construct(
        ValidatorInterface       $validator,
        LoggerInterface          $logger,
        SearchBenefitPassService $searchBenefitPassService
    ) {
        $this->validator                = $validator;
        $this->logger                   = $logger;
        $this->searchBenefitPassService = $searchBenefitPassService;
    }

    /**
     * Валидирует параметры запроса
     *
     * @param Request $serverRequest - объект серверного http запроса
     * @return string|null - строка с ошибкой или null если ошибки нет
     * @throws \Exception
     */
    private function validateQueryParams(Request $serverRequest): ?string
    {
        $params = array_merge($serverRequest->attributes->all(), $serverRequest->query->all());
        $constraint = new Assert\Collection([
            'allowExtraFields' => true,
            'allowMissingFields' => false,
            'missingFieldsMessage' => 'Отсутствует обязательное поле: {{ field }}',
            'fields' => [
                'customer_id' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer id'
                    ])
                ]),
                'full_name' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer full name'
                    ])
                ]),
                'sex' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer sex'
                    ])
                ]),
                'birthdate' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer birthdate'
                    ])
                ]),
                'phone' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer phone'
                    ])
                ]),
                'passport' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer passport'
                    ])
                ]),
                'type_benefit' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect type benefit'
                    ])
                ]),
                'number_document' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect number document'
                    ])
                ]),
                'end' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect end of benefit pass'
                    ])
                ]),
            ]
        ]);
        $errors = $this->validator->validate($params, $constraint);
        $errStrCollection = array_map(
            static function ($v) {
                return $v->getMessage();
            },
            $errors->getIterator()->getArrayCopy()
        );
        return count($errStrCollection) > 0
            ? implode(',', $errStrCollection)
            : null;
    }

    /**
     * Реализация поиска льгот по критериям
     *
     * @param Request $serverRequest - серверный объект запроса
     * @return Response - объект http ответа
     * @throws \Exception
     */
    public function __invoke(Request $serverRequest): Response
    {
        $this->logger->info('dispatch "benefit_pass" url');
        $resultParamValidation = $this->validateQueryParams($serverRequest);
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
