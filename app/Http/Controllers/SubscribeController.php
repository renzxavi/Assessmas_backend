<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use Illuminate\Validation\ValidationException;

class SubscribeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:subscribes,email',
            ]);

            $subscriber = Subscribe::create([
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Thank you for subscribing!',
                'data' => $subscriber
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The email is already registered or invalid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing request'
            ], 500);
        }
    }
}