<?php

namespace Tests\Feature\Auth;

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/teacher/login');

        $response->assertStatus(200);
    }

    public function test_teacher_can_authenticate_using_the_login_screen(): void
    {
        $teacher = Teacher::factory()->create();

        $response = $this->post('/teacher/login', [
            'username' => $teacher->username,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($teacher, 'teacher');
        $response->assertRedirect('/teacher');
    }

    public function test_teacher_can_not_authenticate_with_invalid_password(): void
    {
        $teacher = Teacher::factory()->create();

        $this->post('/teacher/login', [
            'username' => $teacher->username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('teacher');
    }

    public function test_teacher_can_logout(): void
    {
        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($teacher, 'teacher')->post('/teacher/logout');

        $this->assertGuest('teacher');
        $response->assertRedirect('/teacher/login');
    }
}
