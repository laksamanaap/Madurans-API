<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    // Tes Commit, Change config global git name

    /**
     * @OA\Get(
     *     path="/get-users",
     *     tags={"User Authentication"},
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
 *     tags={"User Authentication"},
 *     summary="User Register API's",
 *     @OA\RequestBody(
 *          description= "- Register to your account",
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="username", type="string", example="laksamana"),
 *              @OA\Property(property="email", type="email", example="laksamana.arya1412@gmail.com"),
 *              @OA\Property(property="password", type="string", example="1234"),
 *              @OA\Property(property="password_confirmation", type="string", example="1234")

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

    // Validate
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $formField = $validator->validated();

    $formField['password'] = Hash::make($request->input('password'));

     // Check if the email is already in use
     if (User::where('email', $formField['email'])->exists()) {
        return response()->json(['error' => 'Email is already in use.'], 409);
    }
    $user = User::create($formField);

    $token = $user->createToken('myAppToken')->plainTextToken;

    return response()->json([
        'message' => 'Register Success',
        'data' => $user,
        'access_token' => $token,
        'token_type' => 'Bearer'
    ]);
}

  /**
 * @OA\Post(
 *     path="/login",
 *     tags={"User Authentication"},
 *     summary="User Login API's",
 *     @OA\RequestBody(
 *          description= "- Login to your account",
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="email", type="string", example="laksamana.arya1412@gmail.com"),
 *              @OA\Property(property="password", type="string", example="1234")
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successfully Login",
 *      ),
 *     @OA\Response(
 *         response=201,
 *         description="Successfully Login",
 *      ),
 *      @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *      ),
 * )
 */

public function loginUsers(Request $request)
{
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = Auth::user();

    // Ensure the user is not null
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Create a token for the user
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login Success',
        'data' => $user,
        'access_token' => $token,
        'token_type' => 'Bearer'
    ]);
}

}
