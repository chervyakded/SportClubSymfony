<?php

namespace EfTech\SportClub\Controller;

use EfTech\SportClub\Service\SearchPassService;
use EfTech\SportClub\Service\SearchPassService\PassDto;
use EfTech\SportClub\Service\SearchPassService\SearchPassCriteria;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GetPassCollectionController extends AbstractController
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
     * Путь до файла с данными об абонементах
     *
     * @var SearchPassService
     */
    private SearchPassService $searchPassService;

    /**
     * @param ValidatorInterface $validator         - сервис валидации
     * @param LoggerInterface    $logger            - логер
     * @param SearchPassService  $searchPassService - путь до файла с данными об абонементах
     */
    public function __construct(
        ValidatorInterface $validator,
        LoggerInterface    $logger,
        SearchPassService  $searchPassService
    ) {
        $this->validator         = $validator;
        $this->logger            = $logger;
        $this->searchPassService = $searchPassService;
    }

    /**
     * Валидирует параметры запроса
     *
     * @param  Request $serverRequest - объект серверного http запроса
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
                'pass_id' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect pass id'
                    ])
                ]),
                'duration' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect duration'
                    ])
                ]),
                'discount' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect discount'
                    ])
                ]),
                'customer_id' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer id'
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
     * Реализация поиска абонементов по критериям
     *
     * @param  Request $serverRequest - серверный объект запроса
     * @return Response - объект http ответа
     * @throws \Exception
     */
    public function __invoke(Request $serverRequest): Response
    {
        $this->logger->info('dispatch "pass" url');
        $resultParamValidation = $this->validateQueryParams($serverRequest);
        if (null === $resultParamValidation) {
            $params    = array_merge(
                $serverRequest->query->all(),
                $serverRequest->attributes->all()
            );
            $foundPass = $this->searchPassService->search(
                (new SearchPassCriteria())
                    ->setPassId($params['pass_id'] ?? null)
                    ->setDuration($params['duration'] ?? null)
                    ->setDiscount($params['discount'] ?? null)
                    ->setCustomerId($params['customer_id'] ?? null)
                    ->setCustomerFullName($params['customer_full_name'] ?? null)
                    ->setCustomerSex($params['customer_sex'] ?? null)
                    ->setCustomerBirthdate($params['customer_birthdate'] ?? null)
                    ->setCustomerPhone($params['customer_phone'] ?? null)
                    ->setCustomerPassport($params['customer_passport'] ?? null)
            );
            $httpCode = $this->buildHttpCode($foundPass);
            $result   = $this->buildResult($foundPass);
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
     * @param  array $foundPass
     * @return integer
     */
    protected function buildHttpCode(array $foundPass): int
    {
        return 200;
    }

    /**
     * Подготавливает данные для ответа
     *
     * @param  array $foundPasses
     * @return array
     */
    protected function buildResult(array $foundPasses): array
    {
        $result = [];
        foreach ($foundPasses as $foundPass) {
            $result[] = $this->serializePass($foundPass);
        }
        return $result;
    }

    /**
     * Сериализация абонементов
     *
     * @param PassDto $passDto
     * @return array
     */
    private function serializePass(PassDto $passDto): array
    {
        return [
            'pass_id'     => $passDto->getPassId(),
            'duration'    => $passDto->getDuration(),
            'discount'    => $passDto->getDiscount(),
            'customer_id' => $passDto->getCustomerId(),
        ];
    }
}
