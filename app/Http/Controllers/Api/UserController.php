<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|string|email|unique:users',
            'document_type_id'  => 'required',
            'document_number'   => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code'      => 400,
                'errors'    => $validator->errors()
            ]);
        }

        User::create(array_merge(
            $validator->validate(),
            ['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'] // password
        ));

        return response()->json([
            'code'  => 200,
            'msg'   => 'Usuario registrado con éxito!'
        ]);
    }
}
