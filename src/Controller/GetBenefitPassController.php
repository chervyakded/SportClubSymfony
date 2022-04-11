<?php

namespace EfTech\SportClub\Controller;

/**
 * Получение информации по одной книге
 */
class GetBenefitPassController extends GetBenefitPassCollectionController
{
    /**
     * @param  array $foundBenefitPass
     * @return integer
     */
    protected function buildHttpCode(array $foundBenefitPass): int
    {
        return 0 === count($foundBenefitPass) ? 404 : 200;
    }

    /**
     * @param  array $foundBenefitPass
     * @return array
     */
    protected function buildResult(array $foundBenefitPass): array
    {
        $preResult = parent::buildResult($foundBenefitPass);
        return 1 === count($preResult) ? current($preResult) : [
            'status'  => 'fail',
            'message' => 'entity not found',
        ];
    }
}
