<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * insert itu user
     */
    public function insertIntoUser()
    {
        $user = new User();
        $user->U_UserID = 6;
        $user->U_UserCode = 'TISNA2';
        $user->U_UserName = 'TISNA SAP 2';
        $user->U_Password = '$2y$10$ygyM4fHnFUlNjoWH0GppFeptL8ejB1apzMyZ9h2lj7lYB9D3LMLi2';
        $user->U_NIK = '88101989';
        $user->U_Division = 'IT SAP';
        $user->U_Department = 'IT';
        $user->U_IsAdminSubWH = 'Y';
        $user->U_IsActive = 'Y';
        $user->U_CreateDate = Carbon::now();
        $user->U_UpdateDate = null;
        $user->U_Email = null;
        $user->U_RememberToken = null;
        $user->save();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "U_UserCode" => "required|string",
            "U_Password" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
                "message" => "The given data was invalid",
            ], 422);
        } else {
            try {
                if ($this->checkExistUser($request->U_UserCode)) {
                    if ($user = $this->checkActiveUser($request->U_UserCode)) {
                        $credentials = ['U_UserCode' => $request->U_UserCode, 'password' => $request->U_Password];
                        try {
                            if (!$token = JWTAuth::attempt($credentials)) {
                                return response()->json([
                                    "error" => true,
                                    'message' => 'Invalid login credential'
                                ], 401);
                            }
                        } catch (JWTException $e) {
                            return response()->json([
                                "error" => true,
                                'message' => $e->getMessage()
                            ], 500);
                        }
                        //$user = $request->user();
                        $user = $this->getUser($request->U_UserCode);
                        //$this->insertSession($request, JWTAuth::setToken($token)->getPayload());
                        return response()->json([
                            "success" => true,
                            "error" => false,
                            "token" => $token,
                            "user" => $user
                        ]);
//                        if (Auth::attempt($credentials, false)) {
//                            return response()->json([
//                                "success" => true,
//                                "url" => env("APP_URL"),
//                                "error" => false
//                            ]);
//                        }
//
//                        return response()->json([
//                            "error" => true,
//                            "message" => "Wrong credentials! Please check your password!"
//                        ], 401);
                    } else {
                        return response()->json([
                            "error" => true,
                            "message" => "Your account is not active, please contact the Administrator!"
                        ], 401);
                    }
                } else {
                    return response()->json([
                        "error" => true,
                        "message" => "User Code does not exists!"
                    ], 401);
                }
            } catch (\Exception $exception) {
                return response()->json([
                    "error" => true,
                    "message" => $exception->getMessage(),
                    "trace" => $exception->getTrace()
                ], 401);
            }
        }
    }

    /**
     * @param $username
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUser($username)
    {
        return User::where('U_UserCode', $username)
            ->get();
    }

    /**
     * @param $username
     * @return bool
     */
    protected function checkExistUser($username)
    {
        $user = User::where("U_UserCode", "=", $username)
            ->first();
        if (is_null($user)) {
            return false;
        }
        return true;
    }

    /**
     * @param $username
     * @return bool|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object
     */
    protected function checkActiveUser($username)
    {
        $user = User::where("U_UserCode", "=", $username)
            ->where("U_IsActive", "=", "Y")
            ->first();
//        dd($user);
        if (is_null($user)) {
            return false;
        }
        return $user;
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
