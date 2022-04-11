<?php

namespace EfTech\SportClub\Controller;

/**
 * Получение информации по одной книге
 */
class GetProgramController extends GetProgramCollectionController
{
    /**
     * @param  array $foundProgram
     * @return integer
     */
    protected function buildHttpCode(array $foundProgram): int
    {
        return 0 === count($foundProgram) ? 404 : 200;
    }

    /**
     * @param  array $foundProgram
     * @return array
     */
    protected function buildResult(array $foundProgram): array
    {
        $preResult = parent::buildResult($foundProgram);
        return 1 === count($preResult) ? current($preResult) : [
            'status'  => 'fail',
            'message' => 'entity not found',
        ];
    }
}
