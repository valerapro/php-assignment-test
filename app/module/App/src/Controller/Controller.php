<?php

namespace App\Controller;

use App\Service\UtilsService;

/**
 * Class Controller
 *
 * @package App\Controller
 */
abstract class Controller implements ControllerInterface
{

    /**
     * @param array  $vars
     * @param string $template
     * @param bool   $useLayout
     */
    public function render(array $vars, string $template, $useLayout = true)
    {
        $templateFile = sprintf(__DIR__ . '/../../view/%s.phtml', $template);
        if (!file_exists($templateFile)) {
            throw new \RuntimeException(sprintf('Template %s not found', $template));
        }

        extract($vars);

        $content = $templateFile;

        if (true === $useLayout) {
            include __DIR__ . '/../../view/layout.phtml';

            return;
        }

        include $content;
    }

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
