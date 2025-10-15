<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator; // ¡Importamos la fachada Validator!

class SubscribeController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Definimos las reglas y los mensajes personalizados
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:subscribes,email',
            ], [
                // Mensajes personalizados para cada regla que quieras sobreescribir
                'email.required' => 'The email field is required.',
                'email.email' => 'The email format is invalid.',
                'email.unique' => 'This email has already been registered.', // ¡Este es el mensaje que se sobreescribe!
            ]);

            // Si la validación falla, lanzamos la excepción para que sea atrapada
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $subscriber = Subscribe::create([
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing!',
                'data' => $subscriber
            ], 201);

        } catch (ValidationException $e) {
            // Al atrapar la excepción, 'errors' ya contendrá los mensajes personalizados en español
            return response()->json([
                'success' => false,
                'message' => 'Validation error. Please review the fields.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Error de servidor (500)
            return response()->json([
                'success' => false,
                'message' => 'Error processing request'
            ], 500);
        }
    }
}
