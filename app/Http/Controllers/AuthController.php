<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class AuthController extends HelperController
{
    // Register a new user
    public function register(RegisterRequest $request)
    {
        // Validate the request data using RegisterRequest
        $validatedData = $request->validated(); // Automatically validates the input

        // Hash the password before storing it
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Create the user in the database
        $user = User::create($validatedData);

        // Respond with a success message
        return $this->sendResponse($user, 'User  register successfully.');
    }

    // User login method
    public function login(LoginRequest $request)
    {
        // Validate login credentials using LoginRequest
        $validatedData = $request->validated(); // Automatically validates the input

        // Check user credentials
        $credentials = $request->only('email', 'password');

        // Attempt to generate a token for the user
        if (!$token = auth()->attempt($credentials)) {
            return $this->sendError('Unauthorized.', ['error' => 'Invalid email or password']);
        }

        // Send success response with the generated token
        $success = $this->respondWithToken($token);
        return $this->sendResponse($success, 'User logged in successfully.');
    }

    // Logout user
    public function logout(Request $request)
    {
        // Log out the user by invalidating the token
        auth()->logout();
        return $this->sendResponse([], 'User logged out successfully.');
    }

    // Refresh JWT token
    public function refresh(Request $request)
    {
        // Refresh the token and return the new token structure
        $success = $this->respondWithToken(auth()->refresh());
        return $this->sendResponse($success, 'User token refreshed successfully.');
    }

    // Fetch user profile data
    public function profile(Request $request)
    {
        // Return authenticated user information
        $success = auth()->user();
        return $this->sendResponse($success, 'User data fetched from the database.');
    }

    // Helper method to structure the token response
    private function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }

    //getSingleUser
    public function getSingleUser(Request $request)
    {
        // Return authenticated user information
        return $this->sendResponse("asdfasdfasdfasdf", 'User data fetched from the database.');
    }

}
