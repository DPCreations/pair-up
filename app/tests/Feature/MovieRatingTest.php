<?php

namespace Tests\Feature;

use App\Models\{Movie, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieRatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_like_movie()
    {
        //Setup
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        //Act
        $response = $this->actingAs($user)->post('/api/movierating', [
            'movie_id' => $movie->id,
            'liked' => true,
        ]);

        //Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('movie_ratings', [
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'liked' => 1
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_like_movie()
    {
        //Setup
        $movie = Movie::factory()->create();

        //Act
        $response = $this->post('/api/movierating', [
            'movie_id' => $movie->id,
            'liked' => true,
        ]);

        //Assert
        $response->assertStatus(302);
        $this->assertDatabaseCount('movie_ratings', 0);
    }
}
