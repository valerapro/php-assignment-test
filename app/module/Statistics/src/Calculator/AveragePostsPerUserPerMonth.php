<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class Calculator
 *
 * @package Statistics\Calculator
 */
class AveragePostsPerUserPerMonth extends AbstractCalculator
{

    protected const UNITS = 'posts';

    /**
     * @var array
     */
    private array $authorsPostCount = [];

    /**
     * @var array
     */
    private array $period = [];

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $key = $postTo->getDate()->format('\M\o\n\t\h M, Y');
        $this->period[$key] = $key;

        $authorId = $postTo->getAuthorId();
        $this->authorsPostCount[$authorId] = ($this->authorsPostCount[$authorId] ?? 0) + 1;
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        $stats = new StatisticsTo();
        foreach ($this->authorsPostCount as $authorId => $authorsPostCount) {
            $value = round($authorsPostCount / count($this->period));

            $child = (new StatisticsTo())
                ->setName($this->parameters->getStatName())
                ->setSplitPeriod("User ID '$authorId'")
                ->setValue($value)
                ->setUnits(self::UNITS);

            $stats->addChild($child);
        }

        return $stats;
    }
}
