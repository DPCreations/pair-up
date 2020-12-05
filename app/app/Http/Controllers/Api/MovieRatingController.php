<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovieRating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MovieRatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'movie_id' => 'required|integer',
            'liked' => 'required|boolean'
        ]);

        return MovieRating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'movie_id' => $request->get('movie_id')
        ], [
            'liked' => $request->get('liked')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param MovieRating $movieRating
     * @return Response
     */
    public function show(MovieRating $movieRating): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param MovieRating $movieRating
     * @return Response
     */
    public function update(Request $request, MovieRating $movieRating): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MovieRating $movieRating
     * @return Response
     */
    public function destroy(MovieRating $movieRating): Response
    {
        //
    }
}
