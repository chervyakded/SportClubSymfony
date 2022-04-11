<?php

namespace EfTech\SportClub\Controller;

use EfTech\SportClub\Service\SearchPurchaseItemService;
use EfTech\SportClub\Service\SearchPurchaseItemService\CustomerDto;
use EfTech\SportClub\Service\SearchPurchaseItemService\PurchasedItemDto;
use EfTech\SportClub\Service\SearchPurchaseItemService\SearchPurchasedItemCriteria;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GetPurchasedItemsCollectionController extends AbstractController
{
    /**
     * Сервис валидации
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * Логер
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Сервис поиска продуктов
     * @var SearchPurchaseItemService
     */
    private SearchPurchaseItemService $searchPurchaseItemService;

    /**
     * @param ValidatorInterface        $validator                 - сервис валидации
     * @param LoggerInterface           $logger                    - логер
     * @param SearchPurchaseItemService $searchPurchaseItemService - сервис поиска продуктов
     */
    public function __construct(
        ValidatorInterface        $validator,
        LoggerInterface           $logger,
        SearchPurchaseItemService $searchPurchaseItemService
    ) {
        $this->validator                 = $validator;
        $this->logger                    = $logger;
        $this->searchPurchaseItemService = $searchPurchaseItemService;
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
                'id' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect id'
                    ])
                ]),
                'customer_id' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer id'
                    ])
                ]),
                'customer_full_name' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer full name'
                    ])
                ]),
                'customer_sex' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer sex'
                    ])
                ]),
                'customer_birthdate' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer birthdate'
                    ])
                ]),
                'customer_phone' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer phone'
                    ])
                ]),
                'customer_passport' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect customer passport'
                    ])
                ]),
                'price' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect price'
                    ])
                ]),
                'currency' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect currency'
                    ])
                ]),
                'purchased_item_id' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect purchased item id'
                    ])
                ]),
                'pass_id' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect pass id'
                    ])
                ]),
                'id_programme' => new Assert\Optional([
                    new Assert\Type([
                        'type' => 'string',
                        'message' => 'incorrect id programme'
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
     * Реализация поиска продуктов по критериям
     *
     * @param Request $serverRequest - серверный объект запроса
     * @return Response - объект http ответа
     * @throws \Exception
     */
    public function __invoke(Request $serverRequest): Response
    {
        $this->logger->info('dispatch "purchased_items" url');
        $resultParamValidation = $this->validateQueryParams($serverRequest);
        if (null === $resultParamValidation) {
            $params = array_merge(
                $serverRequest->query->all(),
                $serverRequest->attributes->all()
            );
            $foundPurchasedItem = $this->searchPurchaseItemService->search(
                (new SearchPurchasedItemCriteria())
                    ->setCustomerId($params['customer_id'] ?? null)
                    ->setCustomerFullName($params['customer_full_name'] ?? null)
                    ->setCustomerSex($params['customer_sex'] ?? null)
                    ->setCustomerBirthdate($params['customer_birthdate'] ?? null)
                    ->setCustomerPhone($params['customer_phone'] ?? null)
                    ->setCustomerPassport($params['customer_passport'] ?? null)
                    ->setPurchasedItemId($params['purchased_item_id'] ?? null)
                    ->setPass($params['pass_id'] ?? null)
                    ->setProgramId($params['id_programme'] ?? null)
                    ->setPrice($params['price'] ?? null)
            );
            $result = $this->buildResult($foundPurchasedItem);
            $httpCode = $this->buildHttpCode($foundPurchasedItem);
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
     * @param array $foundPurchasedItems
     * @return array
     */
    protected function buildResult(array $foundPurchasedItems): array
    {
        $result = [];
        foreach ($foundPurchasedItems as $foundPurchasedItem) {
            $result[] = $this->serializePurchasedItem($foundPurchasedItem);
        }
        return $result;
    }

    /**
     * Сериализация клиентов и их покупок
     *
     * @param CustomerDto $customerDto
     * @return array
     */
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
            $jsonData['purchased_items'][] = [
                'purchased_item_id' => $purchasedItemDto->getPurchasedItemId(),
                'pass_id' => $purchasedItemDto->getPassId(),
                'id_programme' => $purchasedItemDto->getIdProgramme(),
                'price' => $purchasedItemDto->getPrice(),
                'currency' => $purchasedItemDto->getCurrency(),
            ];
        }
        return $jsonData;
    }

    /**
     * Подготавливает http код
     *
     * @param array $foundPurchasedItem
     * @return integer
     */
    protected function buildHttpCode(array $foundPurchasedItem): int
    {
        return 200;
    }
}
