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


    public function getSpecificFacilitiesFromDestination($id_destinasi) {
        // $facilitiesData = Destination::with('facilities')->find($id_destinasi);
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


    /**
     * @OA\Put(
     *     path="/update-facilities/{id_facility}",
     *     tags={"Facilities"},
     *     summary="Update Facility",
     *     @OA\RequestBody(
     *          description= "- Update Facility",
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id_facility", type="number", example="1"),
     *              @OA\Property(property="id_destinasi", type="int", example="1"),
     *              @OA\Property(
     *                  property="facility_name",
     *                  type="array",
     *                  @OA\Items(type="string", example="Sleeping Room"),
     *                  @OA\Items(type="string", example="Bathroom"),
     *                  @OA\Items(type="string", example="Transport"),
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get token",
     *      ),
     *    )
     *
     *
     */
    public function updateFacilities(Request $request) {
        $requestData = $request->validate([
            'id_facility' => 'required|numeric',
            'id_destinasi' => 'required|numeric',
            'facility_name' => 'required|array' 
        ]);

        $id_facility = $requestData['id_facility'];
        $id_destinasi = $requestData['id_destinasi'];
        $facility_name = $requestData['facility_name'];

        $Facility = Facilities::find($id_facility);

        if (!$Facility) {
            return response()->json('Facility not found',404);
        }

        $Facility->id_facility = $id_facility;
        $Facility->id_destinasi = $id_destinasi;
        $Facility->facility_name = $facility_name;

        $Facility->save();

        return response()->json([
           'message' => 'Facility successfully updated',
           'data' => $Facility
       ],200);
    }



    /**
     * @OA\delete(
     *     path="/delete-facilities/{id_facility}",
     *     tags={"Facilities"},
     *     summary="Delete facilities API's",
     *     description="Delete facilities API's",
     *     operationId="delete-facilities",
     *       @OA\Parameter(
     *          name="id_facility",
     *          description="id_facility",
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
    public function deleteFacilities($id_facility) {
        $Facility = Facilities::destroy($id_facility);

        return response()->json([
            'message' => 'Facility successfully deleted',
            'data' => $Facility
        ]);
    }


}
