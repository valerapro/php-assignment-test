<?php

namespace App\Traits;

use App\Service\UtilsService;

trait TraitValidateRequest
{

    /**
     * @param array $params
     * @return array
     * @throws \ErrorException
     */
    public function validateRequestIndexAction(array $params): array
    {
        $startDate = UtilsService::extractDate($params['start_date'] ?? null);
        $endDate = UtilsService::extractDate($params['end_date'] ?? null);
        if($startDate > $endDate){
            throw new \ErrorException('Params request invalid', 400);
        }
        return [$startDate, $endDate];
    }
}
