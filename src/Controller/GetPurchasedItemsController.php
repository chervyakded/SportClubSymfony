<?php

namespace EfTech\SportClub\Controller;

/**
 * Получение информации по одной книге
 */
class GetPurchasedItemsController extends GetPurchasedItemsCollectionController
{
    /**
     * @param  array $foundPurchasedItem
     * @return integer
     */
    protected function buildHttpCode(array $foundPurchasedItem): int
    {
        return 0 === count($foundPurchasedItem) ? 404 : 200;
    }

    /**
     * @param  array $foundPurchasedItem
     * @return array
     */
    protected function buildResult(array $foundPurchasedItem): array
    {
        $preResult = parent::buildResult($foundPurchasedItem);
        return 0 !== count($preResult) ? $preResult : [
            'status'  => 'fail',
            'message' => 'entity not found',
        ];
    }
}
