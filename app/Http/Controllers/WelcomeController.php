<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = User::where("U_UserID", "=", 6)->first();
        return response()->json($user);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function mainLogo()
    {
        return response()->json(asset('imgs/logo.png'));
    }
}
