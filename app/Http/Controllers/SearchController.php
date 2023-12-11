<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/search",
     *     tags={"Search"},
     *     summary="Search for destination",
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

        $results = Destination::with(['destinationImage', 'facilities', 'itinerary', 'review.users'])
        ->where('title', 'like', '%' . $query . '%')
        ->when($rating >= 1, function ($queryBuilder) use ($rating) {
            $queryBuilder->where('rating', '=', $rating);
        })
        ->get();

        if ($results->isEmpty()) {
           return response()->json(['message' => 'No destinations found for the specified criteria'], 404);
        } else {
          $formattedResults = $results->map(function ($destination) {
            return [
                'id_destinasi' => $destination->id_destinasi,
                'title' => $destination->title,
                'rating' => $destination->rating,
                'trending' => $destination->trending,
                'location' => $destination->location,
                'description' => $destination->description,
                'created_at' => $destination->created_at,
                'updated_at' => $destination->updated_at,
                'destination_images' => $destination->destinationImage->map(function ($image) {
                    return [
                        'id_destination_image' => $image->id_destination_images,
                        'image' => Storage::disk('public')->url($image->icon),
                    ];
                }),
                'facilities' => $destination->facilities->map(function ($facility) {
                    return [
                        'id_facility' => $facility->id_facility,
                        'facility_name' => $facility->facility_name
                    ];
                }),
                'itineraries' => $destination->itinerary->map(function ($itinerary) {
                    return [
                        'id_itinerary' => $itinerary->id_itinerary,
                        'itinerary_day' => $itinerary->itinerary_day,
                        'itinerary_location_description' => $itinerary->itinerary_location_description,
                        'itinerary_description' => $itinerary->itinerary_description
                    ];
                }),
                'reviews' => $destination->review->map(function ($review) {
                    return [
                        'id_review' => $review->id_review,
                        'rating' => $review->rating,
                        'description' => $review->description,
                        'users' => $review->users,
                        ];
                    }),
                ];
            });
           return response()->json($formattedResults);
        }
    }
}
