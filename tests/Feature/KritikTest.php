<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class KritikTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guests_cannot_post_a_comment(): void
    {
        $film = Film::query()->firstOrFail();

        $response = $this->post(route('kritik.store', $film->id), [
            'isi' => 'Komentar dari tamu',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('kritiks', [
            'film_id' => $film->id,
            'isi' => 'Komentar dari tamu',
        ]);
    }

    public function test_authenticated_users_can_post_a_comment(): void
    {
        $user = User::query()->firstOrFail();
        $film = Film::query()->firstOrFail();

        $response = $this->actingAs($user)->post(route('kritik.store', $film->id), [
            'isi' => 'Komentar dari pengguna',
        ]);

        $response->assertRedirect(route('movies.show', $film->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kritiks', [
            'user_id' => $user->id,
            'film_id' => $film->id,
            'isi' => 'Komentar dari pengguna',
        ]);
    }

    public function test_a_comment_requires_content(): void
    {
        $user = User::query()->firstOrFail();
        $film = Film::query()->firstOrFail();

        $response = $this->actingAs($user)->post(route('kritik.store', $film->id), [
            'isi' => '',
        ]);

        $response->assertSessionHasErrors('isi');
    }

    public function test_guests_see_a_login_prompt_instead_of_the_comment_form(): void
    {
        $film = Film::query()->firstOrFail();

        $response = $this->get(route('movies.show', $film->id));

        $response->assertOk();
        $response->assertSee('Silakan login terlebih dahulu melalui menu utama untuk menulis komentar.');
        $response->assertSee(route('login', ['redirect' => route('movies.show', $film->id)]), false);
        $response->assertSee('>LOGIN</a>', false);
        $response->assertSee('name="redirect"', false);
        $response->assertDontSee('name="isi"', false);
    }

    public function test_authenticated_users_see_the_comment_form_with_their_name(): void
    {
        $user = User::query()->firstOrFail();
        $film = Film::query()->firstOrFail();

        $response = $this->actingAs($user)->get(route('movies.show', $film->id));

        $response->assertOk();
        $response->assertSee(route('kritik.store', $film->id), false);
        $response->assertSee($user->name);
        $response->assertSee('name="isi"', false);
        $response->assertSee('placeholder="Tulis komentar/ulasan Anda..."', false);
        $response->assertSee('value="SEND"', false);
    }

    public function test_guest_header_shows_the_login_and_register_action(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('LOGIN / REGISTER');
        $response->assertDontSee('DASHBOARD');
    }

    public function test_authenticated_header_shows_the_dashboard_and_logout_actions(): void
    {
        $user = User::query()->firstOrFail();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertOk();
        $response->assertSee('DASHBOARD');
        $response->assertSee('LOGOUT');
        $response->assertDontSee('LOGIN / REGISTER');
    }

    public function test_login_redirects_back_to_the_film_page_when_redirect_is_supplied(): void
    {
        $user = User::factory()->create(['password' => 'password123']);
        $film = Film::query()->firstOrFail();

        $response = $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => 'password123',
            'redirect' => route('movies.show', $film->id),
        ]);

        $response->assertRedirect(route('movies.show', $film->id));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_ignores_a_redirect_to_another_host(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $response = $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => 'password123',
            'redirect' => 'https://example.com/phishing',
        ]);

        $response->assertRedirect(route('admin.films.index'));
    }

    public function test_the_main_login_page_is_accessible_with_a_redirect_url(): void
    {
        $film = Film::query()->firstOrFail();

        $response = $this->get(route('login', [
            'redirect' => route('movies.show', $film->id),
        ]));

        $response->assertOk();
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="redirect"', false);
    }
}
