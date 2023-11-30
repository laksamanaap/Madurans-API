<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/get-Review",
     *     tags={"Review"},
     *     summary="Get all Review",
     *     description="A sample greeting to test out the API",
     *     operationId="get-all-Review",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getReview(Request $request) {

        $Review = DB::table('review')->get();

        return response()->json($Review);
    }
}
