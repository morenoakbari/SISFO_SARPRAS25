<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserApiController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at')->get();

        return response()->json([
            'status' => true,
            'message' => 'List of registered users',
            'data' => $users
        ]);
    }
}
