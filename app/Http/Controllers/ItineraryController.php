<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
}
