<?php

namespace EfTech\SportClub\Controller;

/**
 * Получение информации по одной книге
 */
class GetPassController extends GetPassCollectionController
{
    /**
     * @param  array $foundPass
     * @return integer
     */
    protected function buildHttpCode(array $foundPass): int
    {
        return 0 === count($foundPass) ? 404 : 200;
    }

    /**
     * @param  array $foundPasses
     * @return array
     */
    protected function buildResult(array $foundPasses): array
    {
        $preResult = parent::buildResult($foundPasses);
        return 1 === count($preResult) ? current($preResult) : [
            'status'  => 'fail',
            'message' => 'entity not found',
        ];
    }
}
