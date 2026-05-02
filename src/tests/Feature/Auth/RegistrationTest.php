<?php

namespace Tests\Feature\Auth;

use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/student/signup');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Test::factory()->create(['year' => 1]);

        $response = $this->post('/student/signup', [
            'username' => 'newstudent',
            'year' => 1,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/student');
        $this->assertDatabaseHas('users', [
            'username' => 'newstudent',
            'year' => 1,
        ]);
    }

    public function test_signup_fails_when_username_is_duplicated(): void
    {
        Test::factory()->create(['year' => 1]);
        User::factory()->create(['username' => 'taken']);

        $response = $this->post('/student/signup', [
            'username' => 'taken',
            'year' => 1,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('username');
    }

    public function test_signup_fails_when_no_test_exists_for_year(): void
    {
        $response = $this->post('/student/signup', [
            'username' => 'newstudent',
            'year' => 1,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('year');
    }
}
