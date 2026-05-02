<?php

namespace App\Services\Pdca;

use InvalidArgumentException;

class TabSaverFactory
{
    private const SAVERS = [
        'plan' => PlanTabSaver::class,
        'do' => DoTabSaver::class,
        'check' => CheckTabSaver::class,
        'action' => ActionTabSaver::class,
    ];

    public function make(string $tab): TabSaver
    {
        if (! isset(self::SAVERS[$tab])) {
            throw new InvalidArgumentException("Unknown PDCA tab: {$tab}");
        }

        return app(self::SAVERS[$tab]);
    }
}
