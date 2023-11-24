<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    /**
     * @OA\Get(
     *     path="/get-users",
     *     tags={"Users"},
     *     summary="Get all users",
     *     description="A sample greeting to test out the API",
     *     operationId="get-all-users",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getUsers() {
      $users = DB::table('users')->get();

      return response()->json($users);
    }


     /**
 * @OA\Post(
 *     path="/register",
 *     tags={"Users"},
 *     summary="User Register API's",
 *     @OA\RequestBody(
 *          description= "- Register to your account",
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="username", type="string", example="laksamana"),
 *              @OA\Property(property="email", type="email", example="laksamana.arya1412@gmail.com"),
 *              @OA\Property(property="password", type="password", example="1234"),
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successfully Register",
 *      ),
 *     @OA\Response(
 *         response=201,
 *         description="Successfully Register",
 *      ),
 *      @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *      ),
 *    )
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function registerUsers(Request $request) {
    $validator = Validator::make($request->all(), [
        'username' => 'required|string',
        'email' => 'required|string',
        'password' => 'required|string|confirmed'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $formField = $validator->validated();

    $formField['password'] = Hash::make($request->input('password'));
    $user = User::create($formField);

    $token = $user->createToken('myAppToken')->plainTextToken;

    $response = [
        'user' => $user,
        'token' => $token
    ];

    return response($response, 201);
}

}
