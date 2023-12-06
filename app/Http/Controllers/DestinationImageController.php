<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DestinationImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DestinationImageController extends Controller
{
        /**
         * @OA\Post(
         *      path="/store-images",
         *      operationId="storeDestinationsImages",
         *      tags={"Destination Image"},
         *      summary="Store partner images settings",
         *      description="Returns partner images settings data",
         *      @OA\RequestBody(
         *          description="<b>Note:</b><br> - <b>id_destinasi</b> is required.",
         *          required=true,
         *          @OA\JsonContent(
         *              type="object",
         *              @OA\Property(property="id_destinasi", type="int", example="1"),
         *              @OA\Property(
         *                  property="images",
         *                  type="array",
         *                  example={
         *                  "base_64string", 
         *                  "base_64string",
         *                  "base_64string",
         *                  "base_64string"
         *                   },
         *                  @OA\Items(type="string"),
         *              ),
         *          )
         *      ),
         *      @OA\Response(
         *          response=200,
         *          description="Successful Operation",
         *       ),
         *      @OA\Response(
         *          response=400,
         *          description="Bad Request"
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *      ),
         *      @OA\Response(
         *          response=500,
         *          description="Server Error"
         *      )
         * )
         */
        public function storeImages(Request $request)
        {
            $requestData = $request->only([
                'id_destinasi',
                'images',
            ]);

            $id_destinasi = $requestData['id_destinasi'] ?? null;
            $images = $requestData['images'] ?? null;

            if ($id_destinasi) $data = Destination::where('soft_delete', 0)
                ->find($id_destinasi);
            if (!$data) return response()->json([
                'message' => 'Destination not found'
            ], 404);


            if ($images) {
                // Handle PATH_URL images
                $otherImages = [];
                foreach ($images as $key => $value) {
                    if (str_contains($value, "http://") || str_contains($value, "https://")) {
                        $pathOtherStorage = parse_url($value, PHP_URL_PATH);
                        $pathOtherStorage = Str::after($pathOtherStorage, 'storage/');
                        array_push($otherImages, $pathOtherStorage);
                    }
                }

                // Get existing images for the partner
                $deleteOtherImage = DestinationImage::where('id_destinasi', $id_destinasi)
                    ->whereNotIn('icon', $otherImages)
                    ->get();

                // Delete other images
                foreach ($deleteOtherImage as $key => $value) {
                    # code...
                    if ($value->icon) {
                        $pathAfterStorage = parse_url($value->icon, PHP_URL_PATH);
                        $pathAfterStorage = Str::after($pathAfterStorage, 'storage/');
                        Storage::disk('public')->delete($pathAfterStorage);
                        $value->delete();
                    }
                }

                // Update or add new images
                foreach ($images as $key => $imageValue) {
                    if (is_string($imageValue) && preg_match('/^data:image\/\w+;base64,/', $imageValue)) {
                        $new_partner_image = new DestinationImage();
                        $new_partner_image->id_destinasi = $data->id_destinasi;
                        $image_64 = $imageValue; //your base64 encoded data

                        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

                        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

                        // find substring fro replace here eg: data:image/png;base64,
                        $image = str_replace($replace, '', $image_64);

                        $image = str_replace(' ', '+', $image);
                        $image = str_replace('svg+xml', 'svg', $image);

                        $image_name = Carbon::now()->timestamp . '-' . Str::random(10) . '.' . $extension;
                        $image_path = 'destination_images/' . $image_name;
                        $image_path = str_replace('svg+xml', 'svg', $image_path);
                        Storage::disk('public')->put($image_path, base64_decode($image));
                        $new_partner_image->icon = $image_path;
                        $new_partner_image->save();
                    }
                }
            }

            return response()->json([
                'message' => 'Succesfully store destination images',
                'data' =>  $new_partner_image   
            ],200);
        }


         /**
     * @OA\Post(
     *     path="/get-images/{id_destinasi}",
     *     tags={"Destination Image"},
     *     summary="Get images destinations",
     *     description="Get images destinations",
     *     operationId="get-specific-imagesDestination",
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
        public function getImages($id_destinasi) {

            $DestinationImageData = Destination::with('destinationImage')->find($id_destinasi);

            return response()->json([
                'message' => 'Succesfully get destination images',
                'data' =>  $DestinationImageData
            ]);

        }
}
