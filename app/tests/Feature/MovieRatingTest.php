<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use App\Models\{Movie, MovieRating, User};
use Database\Seeders\MoviesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieRatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_like_movie()
    {
        //Setup
        $this->seed(UsersTableSeeder::class);
        $this->seed(MoviesTableSeeder::class);

        $user = User::first();
        $movie = Movie::first();

        Auth::login($user);

        //Act
        $response = $this->post('/api/movierating', [
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
        $this->seed(UsersTableSeeder::class);
        $this->seed(MoviesTableSeeder::class);

        $movie = Movie::first();

        //Act
        $response = $this->post('/api/movierating', [
            'movie_id' => $movie->id,
            'liked' => true,
        ]);

        //Assert
        $response->assertStatus(500);
        $this->assertDatabaseCount('movie_ratings', 0);
    }
}
