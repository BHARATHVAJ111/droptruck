<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginApiController extends Controller
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
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    

    public function front(){
        $detail = User::all();

        if ($detail->count() > 0) {
            $data = [
                'status' => 200,
                'details' => $detail
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'details' => 'No Records Found'
            ];

            return response()->json($data, 404);
        }
    }

    public function insert(Request $request){
        
        $validator = Validator::make($request->all(), [
            
            'email' => 'required|email',
            'password' => 'required|min:8',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => "insert data first"
            ], 422);
        } else {
            $detail = User::create([
                
                'email' => $request->email,
                'password' => $request->password,
              
                
            ]);
        }

        if ($detail) {
            return response()->json([
                'status' => 200,
                'message' => 'data insert successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'data not insert successfully',
            ], 500);
        }


    }

    public function login(Request $request){
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|email|string|max:255',
            'password' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validatedData->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Check if the user is active
            if ($user->status == 0) {
                $data = [
                    'status' => 400,
                    'message' => 'User is inactive'
                ];
                return response()->json($data, 400);
            }

            // Verify the password using Hash::check()
            if (Hash::check($request->password, $user->password)) {
                $data = [
                    'status' => 200,
                    'message' => 'User Login Successfully',
                    'data' => $user
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    'status' => 404,
                    'message' => 'Invalid Login Credentials'
                ];
                return response()->json($data, 404);
            }
        } else {
            $data = [
                'status' => 404,
                'message' => 'Invalid Login Credentials'
            ];
            return response()->json($data, 404);
        }
    }
}

