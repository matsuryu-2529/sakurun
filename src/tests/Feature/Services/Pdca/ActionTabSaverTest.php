<?php

namespace Tests\Feature\Services\Pdca;

use App\Models\Review;
use App\Services\Pdca\ActionTabSaver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesPdcaScenario;
use Tests\TestCase;

class ActionTabSaverTest extends TestCase
{
    use CreatesPdcaScenario;
    use RefreshDatabase;

    public function test_save_persists_review_content(): void
    {
        $this->createPdcaScenario();
        $review = Review::where('user_id', $this->user->id)->first();

        app(ActionTabSaver::class)->save(
            $this->user,
            $this->test->id,
            $this->subject->id,
            ['review_contents' => [$review->id => '次回への振り返り']],
        );

        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'content' => '次回への振り返り']);
    }
}
