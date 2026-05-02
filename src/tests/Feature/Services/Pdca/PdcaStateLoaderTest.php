<?php

namespace Tests\Feature\Services\Pdca;

use App\Services\Pdca\PdcaStateLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesPdcaScenario;
use Tests\TestCase;

class PdcaStateLoaderTest extends TestCase
{
    use CreatesPdcaScenario;
    use RefreshDatabase;

    public function test_load_returns_scoped_collections(): void
    {
        $this->createPdcaScenario();

        $state = app(PdcaStateLoader::class)->load($this->user, $this->test->id);

        $this->assertCount(1, $state['scores']);
        $this->assertCount(1, $state['reviews']);
        $this->assertCount(1, $state['tasks']);
    }

    public function test_load_scopes_to_user_and_test(): void
    {
        $this->createPdcaScenario();
        $otherUser = \App\Models\User::factory()->create();
        \App\Models\Task::factory()->create([
            'user_id' => $otherUser->id,
            'test_id' => $this->test->id,
            'subject_id' => $this->subject->id,
        ]);

        $state = app(PdcaStateLoader::class)->load($this->user, $this->test->id);

        $this->assertCount(1, $state['tasks']);
    }
}
