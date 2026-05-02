<?php

namespace Tests\Feature\Livewire\Students;

use App\Livewire\Students\Home;
use App\Models\Subject;
use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_mount_lists_tests_for_user_year(): void
    {
        $userTest = Test::factory()->create(['year' => 1]);
        Test::factory()->create(['year' => 1]);
        Test::factory()->create(['year' => 2]);
        $user = User::factory()->create(['year' => 1, 'test_id' => $userTest->id]);

        $component = Livewire::actingAs($user)->test(Home::class);

        $this->assertCount(2, $component->get('tests'));
    }

    public function test_create_new_pdca_creates_score_and_review_per_subject(): void
    {
        $test = Test::factory()->create(['year' => 1]);
        $subjects = Subject::factory()->count(3)->create();
        $test->subjects()->attach($subjects->pluck('id'));
        $user = User::factory()->create([
            'year' => 1,
            'test_id' => $test->id,
        ]);

        Livewire::actingAs($user)
            ->test(Home::class)
            ->set('selectedTestId', $test->id)
            ->call('createNewPdca');

        $this->assertDatabaseCount('scores', 3);
        $this->assertDatabaseCount('reviews', 3);
    }
}
