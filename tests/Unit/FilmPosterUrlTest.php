<?php

namespace Tests\Unit;

use App\Models\Film;
use Tests\TestCase;

class FilmPosterUrlTest extends TestCase
{
    public function test_it_returns_remote_urls_as_is(): void
    {
        $film = new Film(['poster' => 'https://example.com/poster.jpg']);

        $this->assertSame('https://example.com/poster.jpg', $film->posterUrl());
    }

    public function test_it_keeps_the_storage_prefix_already_stored_in_the_database(): void
    {
        $film = new Film(['poster' => 'storage/images/c10.jpg']);

        $this->assertSame(asset('storage/images/c10.jpg'), $film->posterUrl());
    }

    public function test_it_resolves_images_served_from_the_public_directory(): void
    {
        $film = new Film(['poster' => 'images/c10.jpg']);

        $this->assertSame(asset('images/c10.jpg'), $film->posterUrl());
    }

    public function test_it_normalizes_a_leading_slash(): void
    {
        $film = new Film(['poster' => '/storage/posters/poster.jpg']);

        $this->assertSame(asset('storage/posters/poster.jpg'), $film->posterUrl());
    }

    public function test_it_falls_back_to_the_public_disk_for_bare_file_names(): void
    {
        $film = new Film(['poster' => 'poster.jpg']);

        $this->assertSame(asset('storage/poster.jpg'), $film->posterUrl());
    }

    public function test_it_returns_an_empty_string_when_no_poster_is_set(): void
    {
        $film = new Film(['poster' => null]);

        $this->assertSame('', $film->posterUrl());
    }
}
