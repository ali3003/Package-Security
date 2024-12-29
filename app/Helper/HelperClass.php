<?php

namespace App\Helper;

use App\Models\User;
use App\Services\JWTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HelperClass
{
    protected $jwtService;
    public function __construct(JWTService $jWTService)
    {
        $this->jwtService = $jWTService;
    }
    // ! validation
    public static function createAccount(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:400|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
        ];

        $messages = [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name cannot exceed 50 characters',

            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email is already taken',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password cannot exceed 400 characters',
            'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, and one number',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
    public static function CheckPasswordSaveRequirement(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:250',
            'description' => 'required|string|max:400',
            'password' => 'required|string',
            'jwt' => 'required|string|regex:/^[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+$/',
        ];

        $messages = [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name cannot exceed 250 characters',

            'description.required' => 'Description is required',
            'description.string' => 'Description must be a valid string',
            'description.max' => 'Description cannot exceed 400 characters',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',

            'jwt.required' => 'There Is an Error',
            'jwt.string' => 'There Is an Error',
            'jwt.regex' => 'There Is an Error',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    public static function checkAccount(Request $request)
    {
        $rules = [
            'code' => 'required|string|size:4',
        ];

        $messages = [
            'code.required' => 'Code is required',
            'code.string' => 'Code must be a string',
            'code.size' => 'Code must be exactly 4 characters long',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
    public static function requestEmailConformationCode(Request $request)
    {
        $rules = [
            // 'email' => 'required|email|exists:users,email|exists:verify_email,email',
            'jwt' => 'required|string|regex:/^[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+$/',
        ];

        $messages = [
            // 'email.required' => 'Email is required.',
            // 'email.email' => 'Please provide a valid email address.',
            // 'email.exists' => 'The provided email does not exist or is not verified.',

            'jwt.required' => 'There Is an Error',
            'jwt.string' => 'There Is an Error',
            'jwt.regex' => 'There Is an Error',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
    public static function CheckGetAllPasswords(Request $request)
    {
        $rules = [
            'jwt' => 'required|string|regex:/^[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+$/',
        ];

        $messages = [
            'jwt.required' => 'There Is an Error',
            'jwt.string' => 'There Is an Error',
            'jwt.regex' => 'There Is an Error',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
    public static function validateUpdatePasswordStorage(Request $request)
    {
        $rules = [
            'id'=> 'required|integer|exists:password_storage,id',
            'name' => 'required|string|max:250',
            'description' => 'required|string|max:400',
            'password' => 'required|string',
            'jwt' => 'required|string|regex:/^[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+$/',

        ];

        $messages = [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name cannot exceed 250 characters',

            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description cannot exceed 400 characters',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',

            'jwt.required' => 'There Is an Error',
            'jwt.string' => 'There Is an Error',
            'jwt.regex' => 'There Is an Error',

            'id.required' => 'The ID field is required and cannot be empty.',
            'id.integer' => 'The ID must be a valid integer.',
            'id.exists' => 'The provided ID does not exist in the password storage.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
    public static function validateDeletePasswordStorage(Request $request)
    {
        $rules = [
            'id'=> 'required|integer|exists:password_storage,id',
            'jwt' => 'required|string|regex:/^[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+$/',

        ];

        $messages = [
            'jwt.required' => 'There Is an Error',
            'jwt.string' => 'There Is an Error',
            'jwt.regex' => 'There Is an Error',

            'id.required' => 'The ID field is required and cannot be empty.',
            'id.integer' => 'The ID must be a valid integer.',
            'id.exists' => 'The provided ID does not exist in the password storage.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
    public static function checkPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users,email',
        ];

        $messages = [
            'email.required' => 'Email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.exists' => 'This email does not exist in our records.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
    public static function logToAccount(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|max:400',
        ];

        $messages = [
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.exists' => 'Email does not exist in our records',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password cannot exceed 400 characters',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    public static function updatePassword(Request $request)
    {
        $rules = [
            'password' => [
                'required',
                'string',
                'min:8',
                'max:400',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'token' => 'required|string|size:60',
        ];

        $messages = [
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password cannot exceed 400 characters.',
            'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, and one number.',

            'token.required' => 'Token is required.',
            'token.string' => 'Token must be a valid string.',
            'token.size' => 'Token must be exactly 60 characters long.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }


    // ! response methods
    public static function sendResponse($state = 's', $message = null, $data = null, $statusCode = 200)
    {
        if ($state == 's') {
            $message = $message ?: 'Operation completed successfully.';
            $state = "success";
        } elseif ($state == 'e') {
            $message = $message ?: 'An error occurred.';
            $state = "error";
        } else {
            $message = $message ?: 'Unknown state.';
        }

        $response = [
            'state' => $state,
            'message' => $message,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }
    // ! jwt token methods
    public static function getJwtToken(JWTService $jwt, $id, $time)
    {
        return $jwt->encode([
            'iat' => $time,
            'sub' => $id
        ]);
    }
    public static function isUserIn(JwtService $jwt, Request $request)
    {
        $decoded = $jwt->decode($request->jwt);
        $user = User::find($decoded->sub);

        if ($user) {
            $isTokenRecent = (time() - $decoded->iat) < 30 * 24 * 60 * 60;
            $isLoginMatched = $user->last_login_at == $decoded->iat;
            $isEmailVerified = $user->email_verified_at !== null;

            if ($isTokenRecent && $isLoginMatched && $isEmailVerified) {
                return true;
            }
        }
        return false;
    }
}
