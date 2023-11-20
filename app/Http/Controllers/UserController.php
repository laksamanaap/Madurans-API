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
     *     summary="Returns a Sample API response",
     *     description="Return all users registered",
     *     operationId="greet",
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
