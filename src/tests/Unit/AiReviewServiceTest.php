<?php

/**
 * AiReviewService のテストファイル
 */

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AiReviewService;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * AiReviewService のテストクラス
 */
class AiReviewServiceTest extends TestCase
{
    use RefreshDatabase;

    private $_aiReviewService;

    /**
     * テストの初期化
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->_aiReviewService = new AiReviewService();
    }

    /**
     * 学習データが正常に分析されることをテスト
     *
     * @return void
     */
    public function test_can_analyze_learning_data()
    {
        $tasks = collect(
            [
                (object)[
                    'task_content' => '数学の復習',
                    'progress' => 80,
                    'study_time' => 120,
                    'completed' => false,
                ],
                (object)[
                    'task_content' => '問題演習',
                    'progress' => 30,
                    'study_time' => 60,
                    'completed' => false,
                ],
            ]
        );

        $scores = collect(
            [
                (object)[
                    'target_score' => 80,
                    'score' => 65,
                ],
            ]
        );

        $reviews = collect(
            [
                (object)[
                    'content' => '数学の計算が苦手です',
                ],
            ]
        );

        $result = $this->_aiReviewService->generateReview($tasks, $scores, $reviews);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    /**
     * 進捗が良好な場合の改善提案テスト
     *
     * @return void
     */
    public function test_generates_positive_feedback_for_good_progress()
    {
        $tasks = collect(
            [
                (object)[
                    'task_content' => '英語の単語学習',
                    'progress' => 90,
                    'study_time' => 180,
                    'completed' => true,
                ],
            ]
        );

        $scores = collect(
            [
                (object)[
                    'target_score' => 70,
                    'score' => 75,
                ],
            ]
        );

        $reviews = collect(
            [
                (object)[
                    'content' => '順調に進んでいます',
                ],
            ]
        );

        $result = $this->_aiReviewService->generateReview($tasks, $scores, $reviews);

        $this->assertStringContainsString('良い', $result);
        $this->assertStringContainsString('継続', $result);
    }

    /**
     * 進捗が遅れている場合の改善提案テスト
     *
     * @return void
     */
    public function test_generates_improvement_suggestions_for_poor_progress()
    {
        $tasks = collect(
            [
                (object)[
                    'task_content' => '物理の問題演習',
                    'progress' => 20,
                    'study_time' => 30,
                    'completed' => false,
                ],
            ]
        );

        $scores = collect(
            [
                (object)[
                    'target_score' => 80,
                    'score' => 50,
                ],
            ]
        );

        $reviews = collect(
            [
                (object)[
                    'content' => '理解が不十分です',
                ],
            ]
        );

        $result = $this->_aiReviewService->generateReview($tasks, $scores, $reviews);

        $this->assertStringContainsString('改善', $result);
        $this->assertStringContainsString('学習時間', $result);
    }

    /**
     * 空のデータに対するテスト
     *
     * @return void
     */
    public function test_handles_empty_data()
    {
        $tasks = collect([]);
        $scores = collect([]);
        $reviews = collect([]);

        $result = $this->_aiReviewService->generateReview($tasks, $scores, $reviews);

        $this->assertIsString($result);
        $this->assertStringContainsString('学習計画', $result);
    }

    /**
     * 目標達成率の計算テスト
     *
     * @return void
     */
    public function test_calculates_achievement_rate()
    {
        $tasks = collect(
            [
                (object)['progress' => 100, 'completed' => true],
                (object)['progress' => 50, 'completed' => false],
                (object)['progress' => 75, 'completed' => false],
            ]
        );

        $achievementRate = $this->_aiReviewService->calculateAchievementRate($tasks);

        $this->assertEquals(75.0, $achievementRate);
    }

    /**
     * 学習時間の合計計算テスト
     *
     * @return void
     */
    public function test_calculates_total_study_time()
    {
        $tasks = collect(
            [
                (object)['study_time' => 60],
                (object)['study_time' => 90],
                (object)['study_time' => 120],
            ]
        );

        $totalTime = $this->_aiReviewService->calculateTotalStudyTime($tasks);

        $this->assertEquals(270, $totalTime);
    }
}
