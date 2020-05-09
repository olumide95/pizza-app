<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Login customer
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request): JsonResponse
    {

        $validator = $request->validate([
            'email'     => 'required',
            'password'  => 'required|min:6'
        ]);

        if (!Auth::attempt($validator)) {
             return $this->respondWithError('Credentials are incorrect, please try again!', 401);
        }

      
        $user = User::where('email',$request->email)->first();

        return $this->respondWithSuccess([
            'message' => 'Authentication successful',
            'user' => $user,
            'token' => $user->createJWT()
        ]);
        
    }


    /**
     * Register customer
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): JsonResponse
    {

        $validator = $request->validate([
            'name'     => 'required',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:6|confirmed',
        ]);

        $data = $request->all();

        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (!$user) {
             return $this->respondWithError('Error creating customer, please try again!', 401);
        }
      
        return $this->respondWithSuccess([
            'message' => 'Customer Created Successfully',
            'user' => $user,
            'token' => $user->createJWT()

        ]);
        
    }

}
