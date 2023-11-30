<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/get-review",
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


    /**
     * @OA\Get(
     *     path="/get-review/{id_destinasi}",
     *     tags={"Review"},
     *     summary="Get specific destination Review ",
     *     description="Get specific destination Review ",
     *     operationId="ShowReviewList",
     *     
     * @OA\Parameter(
     *          name="id_destinasi",
     *          description="id_destinasi",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * 
     * 
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getSpecificReviewFromDestination($id_destinasi) {
        $reviewData = Destination::with('review')->find($id_destinasi);

        return response()->json([
            'data' => $reviewData,
        ]);
    }


    /**
     * @OA\Post(
     *     path="/create-review",
     *     tags={"Review"},
     *     summary="Create Review API's",
     *     @OA\RequestBody(
     *          description= "Create Review API's",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id_destinasi", type="number", example="1"),
     *              @OA\Property(property="rating", type="number", example="4"),
     *              @OA\Property(property="description", type="string", example="Destinasi wisata kerapan sapi di Madura menyajikan pengalaman seru dengan perpaduan tradisi dan kecepatan. Acara ini tidak hanya menyuguhkan pertandingan seru antara sapi yang berlomba dengan kecepatan tinggi, tetapi juga memperkenalkan pengunjung pada keindahan budaya Madura."),
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully Add Review",
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successfully Add Review",
     *      ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *      ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createReview(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'id_destinasi' => 'required|numeric',
            'rating' => 'required|numeric',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
               'error' => $validator->errors()
            ]);
        }

        $formData = $validator->validate();
        $formData['id_destinasi'] = $request->input('id_destinasi');

        $destination = Destination::find($formData['id_destinasi']);

        if (!$destination) {
            return response()->json([
                'error' => 'Destination not found'
            ]);
        } else {
            try {
                $review = Review::create($formData);

                 return response()->json([
                    'message' => 'Itinerary successfully created',
                    'data' => $review
                ], 201);
            } catch (Exception $e) {
                return response()->json(['error' => 'Failed to create itinerary.'], 500);
            }
        }

        // $reviewData = Review::create($formData);

        // return response()->json([
        //     'message' => 'Review created successfully.',
        //     'data' => $reviewData
        // ]);

    }
}
