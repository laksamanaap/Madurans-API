<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
     /**
     * @OA\Get(
     *     path="/get-destinations",
     *     tags={"Destination"},
     *     summary="Get all destination",
     *     description="A sample greeting to test out the API",
     *     operationId="get-all-destination",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getDestinations() {
    
         $destinations = Destination::with('destinationImage', 'itinerary', 'review', 'facilities')
        ->get();

        $response = $destinations->map(function ($destination) {
            return [
                'id_destinasi' => $destination->id_destinasi,
                'images' => $destination->images,
                'title' => $destination->title,
                'rating' => $destination->rating,
                'trending' => $destination->trending,
                'location' => $destination->location,
                'description' => $destination->description,
                'created_at' => $destination->created_at,
                'updated_at' => $destination->updated_at,
                'soft_delete' => $destination->soft_delete,
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

        return response()->json($response, 200);
    }

     /**
     * @OA\Post(
     *     path="/get-destinations/{id_destinasi}",
     *     tags={"Destination"},
     *     summary="Get specific destinations",
     *     description="Get specific destinations",
     *     operationId="get-specific-destinations",
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
    public function getSpecificDestinations($id)
    {
        $destinationData = Destination::with('destinationImage','facilities', 'itinerary', 'review.users')
        ->where('destination.id_destinasi', $id)
        ->first();

    if (!$destinationData) {
        return response()->json(['message' => 'No destination found for the specified id_destinasi'], 404);
    } else {
        $response = [
            'id_destinasi' => intval($id),
            'images' => $destinationData->images,
            'title' => $destinationData->title,
            'rating' => $destinationData->rating,
            'trending' => $destinationData->trending,
            'location' => $destinationData->location,
            'description' => $destinationData->description,
            'created_at' => $destinationData->created_at,
            'updated_at' => $destinationData->updated_at,
            'destination_images' => $destinationData->destinationImage->map(function ($image) {
                return [
                    'id_destination_image' => $image->id_destination_images,
                    'image' => Storage::disk('public')->url($image->icon),

                ]; 
            }),
            'facilities' => $destinationData->facilities->map(function ($facility) {
                return [ 
                    'id_facility' => $facility->id_facility,
                    'facility_name' => $facility->facility_name
                ];
            }),
            'itineraries' => $destinationData->itinerary->map(function ($itinerary) {
                return [
                    'id_itinerary' => $itinerary->id_itinerary,
                    'itinerary_day' => $itinerary->itinerary_day,
                    'itinerary_location_description' => $itinerary->itinerary_location_description,
                    'itinerary_description' => $itinerary->itinerary_description
                ];
            }),
            'reviews' => $destinationData->review->map(function($review) {
                return [
                    'id_review' => $review->id_review,
                    'rating' => $review->rating,
                    'description' => $review->description,
                    'users' => $review->users,

                ]; 
            }),
        ];

        return response()->json(['data' => $response], 200);
    }

    }


     /**
     * @OA\Post(
     *     path="/create-destinations",
     *     tags={"Destination"},
     *     summary="Create Destination API's",
     *     @OA\RequestBody(
     *          description= "Create Destination API's",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="images", type="string", example="base64_image_1"),
     *              @OA\Property(property="title", type="email", example="Kerapan Sapi"),
     *              @OA\Property(property="rating", type="float", example="5"),
     *              @OA\Property(property="trending", type="boolean", example=true),
     *              @OA\Property(property="location", type="string", example="Pamekasan, Madura"),
     *              @OA\Property(property="description", type="string", 
     *                  example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nec erat felis. Nunc vitae quam eget leo venenatis vulputate in ut ante. Aenean vel lacus ac purus interdum gravida non id velit. Vivamus sit amet vehicula ante, non tristique leo. Duis iaculis feugiat metus quis posuere. Maecenas tristique, justo et porttitor dignissim, ipsum magna hendrerit neque, a egestas quam nulla nec ante. Maecenas at molestie tellus, eu laoreet augue."
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully Add Destination",
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successfully Add Destination",
     *      ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *      ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createDestinations(Request $request) {

        $validator = Validator::make($request->all(), [
            'images' => 'required|string',
            'title' => 'required|string',
            'rating' => 'required|numeric',
            'trending' => 'required|boolean',
            'location' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ],400);
        }

        $formFields = $validator->validate();

        $destination = Destination::create($formFields);

         return response()->json([
            'message' => 'Destination Created Successfully',
            'data' => $destination,
        ],200);
    }

    /**
     * @OA\Put(
     *     path="/update-destinations/{id_destinasi}",
     *     tags={"Destination"},
     *     summary="Update destination",
     *     @OA\RequestBody(
     *          description= "- Update destination",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id_destinasi", type="int", example="1"),
     *              @OA\Property(property="images", type="string", example="base64_image_1"),
     *              @OA\Property(property="title", type="email", example="Kerapan Sapi"),
     *              @OA\Property(property="rating", type="float", example="4.6"),
     *              @OA\Property(property="trending", type="boolean", example=true),
     *              @OA\Property(property="location", type="string", example="Pamekasan, Madura"),
     *              @OA\Property(property="description", type="string", 
     *                  example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nec erat felis. Nunc vitae quam eget leo venenatis vulputate in ut ante. Aenean vel lacus ac purus interdum gravida non id velit. Vivamus sit amet vehicula ante, non tristique leo. Duis iaculis feugiat metus quis posuere. Maecenas tristique, justo et porttitor dignissim, ipsum magna hendrerit neque, a egestas quam nulla nec ante. Maecenas at molestie tellus, eu laoreet augue."
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get token",
     *      ),
     *    )
     *
     *
     */

     public function updateDestinations(Request $request, $id_destinasi)
     {
        
        $requestData = $request->only([
            'id_destinasi',
            'images',
            'title',
            'rating',
            'trending',
            'location',
            'description',
        ]);
    
        $id_destinasi = $requestData['id_destinasi'];
        $imagesDestinasi = $requestData['images'];
        $titleDestinasi = $requestData['title'];
        $ratingDestinasi = $requestData['rating'];
        $trendingDestinasi = $requestData['trending'];
        $locationDestinasi = $requestData['location'];
        $descriptionDestinasi = $requestData['description'];
    
        $Destination = Destination::find($id_destinasi);
        $Destination->images = $imagesDestinasi;
        $Destination->title = $titleDestinasi;
        $Destination->rating = $ratingDestinasi;
        $Destination->trending = $trendingDestinasi;
        $Destination->location = $locationDestinasi;
        $Destination->description = $descriptionDestinasi;
     
        $Destination->save();
        return response()->json([
            'message' => 'Succesfully update data destination',
            'data' => $Destination
        ],200);
    
     } 


     /**
     * @OA\delete(
     *     path="/delete-destinations/{id_destinasi}",
     *     tags={"Destination"},
     *     summary="Delete destination",
     *     description="Delete Destination API's",
     *     operationId="delete-destination",
     *       @OA\Parameter(
     *          name="id_destinasi",
     *          description="id_destinasi",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function deleteDestinations($id_destinasi) {
      $destination = Destination::destroy($id_destinasi);

      return response()->json([
        'message' => 'Succesfully delete destination',
        'data' => $destination
      ]);
    }

    // Tes Commit

}
