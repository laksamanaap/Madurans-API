<?php

namespace App\Http\Controllers;

use App\Models\Facilities;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FacilitiesController extends Controller
{
     /**
     * @OA\Get(
     *     path="/get-facilities",
     *     tags={"Facilities"},
     *     summary="Get all facilities",
     *     description="A sample greeting to test out the API",
     *     operationId="get-all-facilities",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getFacilities(Request $request) {

       $Facility = Facilities::all();

        return response()->json($Facility);
    }


 /**
 * @OA\Post(
 *     path="/create-facilities",
 *     tags={"Facilities"},
 *     summary="Create Facilities API's",
 *     @OA\RequestBody(
 *          description="Create Facilities API's",
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="id_destinasi", type="number", example="1"),
 *              @OA\Property(
 *                  property="facility_name",
 *                  type="array",
 *                  @OA\Items(type="string", example="Sleeping Room"),
 *                  @OA\Items(type="string", example="Bathroom"),
 *                  @OA\Items(type="string", example="Transport"),
 *              ),
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Created",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *     ),
 * )
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function createFacilities(Request $request) {
    $validator = Validator::make($request->all(), [
        'id_destinasi' => 'required|numeric',
        'facility_name' => 'required|array' // Validate each item in the array
    ]);

    if ($validator->fails()) {
        return response()->json([
           'error' => $validator->errors()
        ]);
    }

    $formData = $validator->validate();
    $formData['id_destinasi'] = $request->input('id_destinasi');

    // dd($formData);

    $destination = Destination::find($formData['id_destinasi']);

    if (!$destination) {
        return response()->json(['error' => 'Destination not found.'], 404);
    } else {
        try {
            foreach ($formData['facility_name'] as $facilityName) {
            $facilities = Facilities::create([
                    'id_destinasi' => $formData['id_destinasi'],
                    'facility_name' => $formData['facility_name'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }

            return response()->json([
                'message' => 'Facilities successfully created',
                'data' => $facilities
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create facilities.'], 500);
        }
    }
}



}
