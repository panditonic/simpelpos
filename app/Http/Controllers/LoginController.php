<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Update last login time
            // $user->update([
            //     'last_login_at' => now(),
            //     'last_login_ip' => $request->ip()
            // ]);

            // Generate session token if needed
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                // 'user' => [
                //     'id' => $user->id,
                //     'name' => $user->name,
                //     'email' => $user->email,
                //     'email_verified_at' => $user->email_verified_at,
                // ]
                'user' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Logged out successfully'
        // ]);

        return redirect()->to("/login");
    }

    /**
     * Check if user is authenticated
     */
    public function checkAuth()
    {
        if (Auth::check()) {
            return response()->json([
                'authenticated' => true,
                // 'user' => [
                //     'id' => Auth::user()->id,
                //     'name' => Auth::user()->name,
                //     'email' => Auth::user()->email,
                // ]
                'user' => Auth::user()
            ]);
        }

        return response()->json([
            'authenticated' => false
        ]);
    }

    /**
     * Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found in our records',
                'errors' => $validator->errors()
            ], 422);
        }

        // In a real application, you would send a password reset email
        // For now, we'll just return a success message
        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to your email!'
        ]);
    }

    /**
     * Get user dashboard data
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            // 'user' => [
            //     'id' => $user->id,
            //     'name' => $user->name,
            //     'email' => $user->email,
            //     'email_verified_at' => $user->email_verified_at,
            //     'created_at' => $user->created_at,
            //     'last_login_at' => $user->last_login_at,
            //     'last_login_ip' => $user->last_login_ip,
            // ]
            'user' => $user
        ]);
    }
}