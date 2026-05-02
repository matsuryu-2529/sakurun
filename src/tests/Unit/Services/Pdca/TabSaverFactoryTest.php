<?php

namespace Tests\Unit\Services\Pdca;

use App\Services\Pdca\ActionTabSaver;
use App\Services\Pdca\CheckTabSaver;
use App\Services\Pdca\DoTabSaver;
use App\Services\Pdca\PlanTabSaver;
use App\Services\Pdca\TabSaverFactory;
use InvalidArgumentException;
use Tests\TestCase;

class TabSaverFactoryTest extends TestCase
{
    public function test_make_returns_each_concrete_saver(): void
    {
        $factory = new TabSaverFactory();

        $this->assertInstanceOf(PlanTabSaver::class, $factory->make('plan'));
        $this->assertInstanceOf(DoTabSaver::class, $factory->make('do'));
        $this->assertInstanceOf(CheckTabSaver::class, $factory->make('check'));
        $this->assertInstanceOf(ActionTabSaver::class, $factory->make('action'));
    }

    public function test_make_throws_for_unknown_tab(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TabSaverFactory())->make('unknown');
    }
}
