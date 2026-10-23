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
        $response->assertSee('Silakan Login terlebih dahulu untuk menulis komentar.');
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
    }
}
