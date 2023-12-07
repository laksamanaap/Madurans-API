<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/search",
     *     tags={"Search"},
     *     summary="Search for products",
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         description="Search query",
     *         @OA\Schema(type="string"),
     *     ),
     *      @OA\Parameter(
     *         name="rating",
     *         in="query",
     *         required=true,
     *         description="Search rating",
     *         @OA\Schema(type="number"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful search"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     * )
     */
     public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string',
            'rating' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Bad request'], 400);
        }

        $query = $request->input('query');
        $rating = $request->input('rating');

        $results = Destination::where(function ($queryBuilder) use ($query, $rating) {
            $queryBuilder->where('title', 'like', '%' . $query . '%')
                ->orWhere('rating', '>=', $rating);
        })->get();

        if ($results->isEmpty()) {
            return response()->json(['messages' => ['No data found with your query!']]);
        } else {
            return response()->json(['data' => $results]);
        }
    }
}
