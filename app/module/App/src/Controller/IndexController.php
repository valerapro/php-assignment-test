<?php

namespace App\Controller;

/**
 * Class IndexController
 *
 * @package App\Controller
 */
class IndexController extends Controller
{

    public function indexAction()
    {
        $options = [];
        $date    = new \DateTime();
        for ($month = 0; $month < 6; $month++) {
            $options[$month]['option'] = $date->format('F, Y');
            $options[$month]['value'] = $date->getTimestamp();
            $date->modify('-1 month');
        }

        $this->render(['options' => $options], 'homepage');
    }
}
