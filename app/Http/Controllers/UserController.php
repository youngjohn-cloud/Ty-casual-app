<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created User in storage.
     */
    public function store(Request $request)
    {
        // Validate User requests
        $validate = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'gender' => 'nullable|in:male,female,others',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => "Registration failed",
                'errors' => $validate->errors(),
            ], 400);
        }
        // Verification for Email verification
        $verification_code = rand(100000, 999999);
        Log::info($verification_code);

        // Handle profile upload
        if ($request->hasFile('profile_picture')) {
            // Store the profile in the User public storage
            $profile_path = $request->file('profile_picture')->store('profile', 'public');
        }

        // Create a new user 
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->verification_code = $verification_code;
        $user->gender = $request->gender;
        $user->profile_picture = $profile_path ?? null;
        $user->save();

        // Send the verification code to the provided email address
        if ($request->email) {
            Mail::to($user->email)->send(new EmailVerification($user));
        }
        // Return a Response of the newly registered User
        return response()->json([
            'message' => 'Email verification code sent',
            'user' => $user,
        ], 201);
    }

    // Verify User Email address
    public function verifyEmail(Request $request)
    {
        // Validate the request
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => "Verification failed",
                'errors' => $validate->errors(),
            ], 400);
        }


        $user = User::where('email', $request->email)->first();
        // check if the email is confirmed
        if (!$user) {
            return response()->json([
                'message' => $request->email .  ' do not exist',
            ], 404);
        }
        // Check if the verification code matches
        if ($user->verification_code != $request->verification_code) {
            return response()->json([
                'message' => $request->verification_code . ' is not valid',
            ], 400);
        }

        // Mark the email as verified
        $user->email_verified_at = now();
        $user->verification_code = null; // Clear the verification code
        $user->save();

        return response()->json([
            'message' => 'Email verified successfully',
        ], 200);
    }

    // Resend verification code
    public function resendVerificaticonCode(Request $request)
    {
        // Validate the request
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => "Resend verification code failed",
                'errors' => $validate->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        // check if the email is confirmed
        if (!$user) {
            return response()->json([
                'message' => $request->email .  ' do not exist',
            ], 404);
        }
        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Email already verified',
            ], 400);
        }

        // Generate a new verification code
        $verification_code = rand(100000, 999999);
        $user->verification_code = $verification_code;
        $user->save();

        // Send the verification code to the provided email address
        Mail::to($user->email)->send(new EmailVerification($user));

        return response()->json([
            'message' => 'Verification code resent successfully',
        ], 200);
    }

    /**
     * Display the specified User.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified User in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified User from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
