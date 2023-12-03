<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ItineraryController extends Controller
{
     /**
     * @OA\Get(
     *     path="/get-itinerary",
     *     tags={"Itinerary"},
     *     summary="Get all itinerary",
     *     description="A sample greeting to test out the API",
     *     operationId="get-all-itinerary",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getItinerary(Request $request) {

        $Itinerary = DB::table('itinerary')->get();

        return response()->json($Itinerary);
    }


     /**
     * @OA\Post(
     *     path="/get-itinerary/{id_itinerary}",
     *     tags={"Itinerary"},
     *     summary="Get specific itinerary",
     *     description="Get specific itinerary",
     *     operationId="get-specific-itinerary",
     *     
     * @OA\Parameter(
     *          name="id_itinerary",
     *          description="id_itinerary",
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
    public function getSpecificItinerary($id) {

        $ItineraryData = Itinerary::where('itinerary.id_itinerary',$id)
        ->first();

        if (!$ItineraryData) {
            return response()->json(['message' => 'No itinerary found for the specified id_itinerary'],404);
        } else {
            return response()->json($ItineraryData);
        }

    }

    
      /**
     * @OA\Get(
     *     path="/get-itinerary/{id_destinasi}",
     *     tags={"Itinerary"},
     *     summary="Get specific destination itinerary ",
     *     description="Get specific destination itinerary ",
     *     operationId="ShowItineraryList",
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
    public function getSpecificItineraryFromDestination($id_destinasi) {
        $destinationData = Destination::with('itinerary')->find($id_destinasi);

        return response()->json([
            'data' => $destinationData->itinerary,
        ]);
    }


     /**
     * @OA\Post(
     *     path="/create-itinerary",
     *     tags={"Itinerary"},
     *     summary="Create Itinerary API's",
     *     @OA\RequestBody(
     *          description= "Create Itinerary API's",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id_destinasi", type="number", example="1"),
     *              @OA\Property(property="itinerary_day", type="string", example="1 Day"),
     *              @OA\Property(property="itinerary_location_description", type="string", example="Sampai di pamekasan"),
     *              @OA\Property(property="itinerary_description", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ipsum ipsum, scelerisque eget nisi sed, tempus ornare dui. Morbi volutpat, tortor dictum porta aliquam, ligula dolor gravida massa, ut blandit tortor nulla eget erat. In hac habitasse platea dictumst. In efficitur id dui at maximus")
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully Add Itinerary",
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successfully Add Itinerary",
     *      ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *      ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createItinerary(Request $request) {
        
       $validator = Validator::make($request->all(), [
        'id_destinasi' => 'required|numeric',
        'itinerary_day' => 'required|string',
        'itinerary_location_description' => 'required|string',
        'itinerary_description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $formFields = $validator->validate();
        $formFields['id_destinasi'] = $request->input('id_destinasi');

        $destination = Destination::find($formFields['id_destinasi']);

        if(!$destination){
            return response()->json(['error' => 'Destination not found.'], 404);
        } else {
            try {
                $itinerary = Itinerary::create($formFields);

                return response()->json([
                    'message' => 'Itinerary successfully created',
                    'data' => $itinerary
                ], 201);
            } catch (Exception $e) {
                return response()->json(['error' => 'Failed to create itinerary.'], 500);
            }
        }
    }


     /**
     * @OA\Put(
     *     path="/update-itinerary/{id_itinerary}",
     *     tags={"Itinerary"},
     *     summary="Update Itinerary",
     *     @OA\RequestBody(
     *          description= "- Update Itinerary",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id_itinerary", type="int", example="1"),
     *              @OA\Property(property="itinerary_day", type="string", example="Day 1"),
     *              @OA\Property(property="itinerary_location_description", type="string", example="Sampai di Pamekasan, Madura"),
     *              @OA\Property(property="itinerary_description", type="string", example="Ini deskripsi itinerary")
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
    public function updateItinerary(Request $request, $id_itinerary) {

        $requestData = $request->only([
            'id_itinerary',
            'itinerary_day',
            'itinerary_location_description',
            'itinerary_description'
        ]);

        $id_itinerary = $requestData['id_itinerary'];
        $itinerary_day = $requestData['itinerary_day'];
        $itinerary_location_description = $requestData['itinerary_location_description'];
        $itinerary_description = $requestData['itinerary_description'];

        $Itinerary = Itinerary::find( $id_itinerary);
        $Itinerary->itinerary_day = $itinerary_day;
        $Itinerary->itinerary_location_description = $itinerary_location_description;
        $Itinerary->itinerary_description = $itinerary_description;

        $Itinerary->save();

        return response()->json([
            'message' => 'Succesfully update itinerary',
            'data' => $Itinerary
        ],200);

    }



     /**
     * @OA\delete(
     *     path="/delete-itinerary/{id_itinerary}",
     *     tags={"Itinerary"},
     *     summary="Delete Itinerary API's",
     *     description="Delete Itinerary API's",
     *     operationId="delete-Itinerary",
     *       @OA\Parameter(
     *          name="id_itinerary",
     *          description="id_itinerary",
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
    public function deleteItinerary($id_itinerary) {

        $Itinerary = Itinerary::destroy($id_itinerary);

        return response()->json([
            'message' => 'Succesfully delete itinerary',
            'data' => $Itinerary
        ]);
    }


}
