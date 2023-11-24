<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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



}
