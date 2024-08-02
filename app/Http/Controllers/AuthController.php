<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResourceCollection;

/**
 * @group Login
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
    * Login
    *
    * [Obtenha o token JWT passando as credenciais]
    *
    * @bodyParam email string required Email do usuário. Exemplo: teste@teste.com.br
    * @bodyParam password string required Senha do usuário. Exemplo: 1234
    *
    * @response {
    *  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    *  "token_type": "bearer",
    *  "expires_in": 3600,
    *    }
    *]
    * @response 401 {
    *  "error": "Unauthorized"
    * }
    */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Me
     * @authenticated
     *
     * Retorna o usuário logado
     * @header Authorization Bearer {token}
     * @response {
     *      "id": 99999,
     *      "name": "Aluno teste",
     *      "email": "email@teste.com.br"
     *  }
     *
     */
    public function me()
    {
        return response()->json(
            UsersResourceCollection::make(auth()->user())
        );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
