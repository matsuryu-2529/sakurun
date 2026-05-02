<?php

namespace Tests\Feature\Livewire\Students;

use App\Livewire\Students\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_mount_loads_authenticated_user(): void
    {
        $user = User::factory()->create(['username' => 'taro', 'year' => 2]);

        Livewire::actingAs($user)
            ->test(Account::class)
            ->assertSet('username', 'taro')
            ->assertSet('year', 2);
    }

    public function test_open_and_close_name_modal(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Account::class)
            ->call('openNameModal')
            ->assertSet('showNameModal', true)
            ->call('closeNameModal')
            ->assertSet('showNameModal', false);
    }

    public function test_update_name_persists_username(): void
    {
        $user = User::factory()->create(['username' => 'before']);

        Livewire::actingAs($user)
            ->test(Account::class)
            ->set('username', 'after')
            ->call('updateName')
            ->assertSet('showNameModal', false);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'username' => 'after']);
    }

    public function test_update_year_persists_year(): void
    {
        $user = User::factory()->create(['year' => 1]);

        Livewire::actingAs($user)
            ->test(Account::class)
            ->set('year', 3)
            ->call('updateYear')
            ->assertSet('showYearModal', false);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'year' => 3]);
    }

    public function test_update_year_rejects_out_of_range(): void
    {
        $user = User::factory()->create(['year' => 1]);

        Livewire::actingAs($user)
            ->test(Account::class)
            ->set('year', 99)
            ->call('updateYear')
            ->assertHasErrors(['year' => 'max']);
    }

    public function test_update_password_with_correct_current_password(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Account::class)
            ->set('current_password', 'password')
            ->set('new_password', 'new-secret-12345')
            ->set('new_password_confirmation', 'new-secret-12345')
            ->call('updatePassword')
            ->assertSet('showPasswordModal', false);

        $this->assertTrue(Hash::check('new-secret-12345', $user->fresh()->password));
    }

    public function test_update_password_rejects_wrong_current_password(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Account::class)
            ->set('current_password', 'wrong-password')
            ->set('new_password', 'new-secret-12345')
            ->set('new_password_confirmation', 'new-secret-12345')
            ->call('updatePassword')
            ->assertHasErrors('current_password');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_logout_redirects_to_student_login(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Account::class)
            ->call('logout')
            ->assertRedirect('/student/login');

        $this->assertGuest();
    }
}
