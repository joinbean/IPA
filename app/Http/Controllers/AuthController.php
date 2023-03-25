<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/register",
     * operationId="Register",
     * tags={"user"},
     * summary="User Register",
     * description="User Register here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "password",},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="password"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                  property="access_token",
     *                  type="string",
     *                  example="3|W4pFsiVbdGz9C0f0ZAaDtMSLnTxNMex7j5WM2V7F"
     *              ),
     *              @OA\Property(
     *                  property="token_type",
     *                  type="string",
     *                  example="Bearer"
     *              ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Unauthorized"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Die E-Mail Adresse ist im falschen Format"
     *              ),
     *          ),
     *      ),
     * )
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * operationId="authLogin",
     * tags={"user"},
     * summary="User Login",
     * description="Login User Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="password")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                  property="access_token",
     *                  type="string",
     *                  example="3|W4pFsiVbdGz9C0f0ZAaDtMSLnTxNMex7j5WM2V7F"
     *              ),
     *              @OA\Property(
     *                  property="token_type",
     *                  type="string",
     *                  example="Bearer"
     *              ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Unauthorized"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="The route could not be found"
     *              ),
     *          ),
     *      ),
     * )
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $validated['email'])->firstOrFail();
   	  	$user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
