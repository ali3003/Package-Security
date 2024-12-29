<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\VEmail;
use App\Jobs\SendEmail;
use App\Mail\authEmail;
use App\Helper\HelperClass;
use Illuminate\Support\Str;
use App\Services\JWTService;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use App\Mail\reSetPasswordEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $jwtService;
    public function __construct(JWTService $jWTService)
    {
        $this->jwtService = $jWTService;
    }
    public function createAccount(Request $request)
    {
        $validator = HelperClass::createAccount($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }
        $tIme=time();
        $account = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "last_login_at"=>$tIme
        ]);

        $code = Str::random(4);

        VEmail::create([
            'email' => $request->email,
            'code' => $code
        ]);

        SendEmail::dispatch('sendCode', $request->email, $request->name, $code);
        return HelperClass::sendResponse(message: 'Account Created successfully', data: ["JWT" => HelperClass::getJwtToken($this->jwtService, $account->id,$tIme)], statusCode: 201);
    }
    public function requestEmailConformationCode(Request $request)
    {
        $validator = HelperClass::requestEmailConformationCode($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }

        $decodedJwt = $this->jwtService->decode($request->jwt);
        $userId = $decodedJwt->sub ?? null;

        if (!$userId) {
            return HelperClass::sendResponse(message: 'Invalid token. User not found.', statusCode: 400);
        }

        $user = User::find($userId);
        if (!$user) {
            return HelperClass::sendResponse(
                message: 'There was an error. Your account may not be found or email does not match.',
                statusCode: 400
            );
        }

        $code = Str::random(4);

        $verEmail = VEmail::where('email', $user->email)->first();
        if (!$verEmail) {
            return HelperClass::sendResponse(
                message: 'Verification email record not found.',
                statusCode: 400
            );
        }

        $verEmail->update(['code' => $code]);

        SendEmail::dispatch('sendCode', $user->email, $request->name, $code);
        return HelperClass::sendResponse(
            message: 'Code sent successfully.',
            statusCode: 201
        );
    }
    public function logToAccount(Request $request)
    {
        $validator = HelperClass::logToAccount($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }

        $account = User::where('email', $request->email)->first();

        if (!$account || !Hash::check($request->password, $account->password)) {
            return HelperClass::sendResponse('e', 'Invalid email or password', statusCode: 401);
        }
        $tIme=time();
        $token = HelperClass::getJwtToken($this->jwtService, $account->id,$tIme);

        $account->update(['last_login_at' => $tIme]);

        SendEmail::dispatch('loginEvent', $account->email, $account->name, Carbon::now(), "current location because we accept requests from localhost only");

        return HelperClass::sendResponse(
            message: 'Logged in successfully',
            data: ["JWT" => $token],
            statusCode: 200
        );
    }

    public function resetPassword(Request $request)
    {
        $validator = HelperClass::checkPassword($request);
        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }

        $user = User::where("email", $request->email)->first();
        if (!$user) {
            return HelperClass::sendResponse('e', 'Email does not exist.', statusCode: 404);
        }

        $token = Str::random(60);

        $resetRecord = ResetPassword::where('email', $request->email)->first();
        if ($resetRecord) {
            $resetRecord->update([
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        } else {
            ResetPassword::create([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        SendEmail::dispatch('resetPassword', $user->email, $user->name, $token);

        return HelperClass::sendResponse('s', 'Reset password email sent successfully.', statusCode: 201);
    }

    public function conformEmail(Request $request)
    {
        $validator = HelperClass::checkAccount($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }

        $decoded = $this->jwtService->decode($request->jwt);
        if (!$decoded || !isset($decoded->sub)) {
            return HelperClass::sendResponse('e', "Invalid token.", statusCode: 400);
        }

        $user = User::find($decoded->sub);

        if (!$user) {
            return HelperClass::sendResponse('e', "User not found.", statusCode: 404);
        }

        if ($user->email_verified_at !== null) {
            return HelperClass::sendResponse('e', "Email already verified.", statusCode: 400);
        }

        $userVerifyEmail = VEmail::where("email", $user->email)->first();

        if (!$userVerifyEmail) {
            return HelperClass::sendResponse('e', "Verification record not found.", statusCode: 404);
        }

        if ($userVerifyEmail->code === $request->code) {
            $userVerifyEmail->delete();
            $user->email_verified_at = now();
            $user->save();

            return HelperClass::sendResponse('s', "Email confirmation successful.");
        }

        return HelperClass::sendResponse('e', "Invalid verification code.", statusCode: 400);
    }
    public function setNewPassword(Request $request)
    {
        $validator = HelperClass::updatePassword($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }

        $passToken = ResetPassword::where('token', $request->token)->first();
        if ($passToken) {
            $user = User::where('email', $passToken->email)->first();

            if ($user) {
                $user->password = bcrypt($request->password);
                $user->save();

                $passToken->delete();
                SendEmail::dispatch(
                    'actionEmail',
                    $user->email,
                    $user->name,
                    'Password Changed',
                    'Dear user, we wanted to inform you that your password has been successfully updated. If you did not request this change, please contact our support team immediately. ( witch we have not )'
                );
                return HelperClass::sendResponse('s', 'Password has been reset successfully.');
            } else {
                return HelperClass::sendResponse('e', 'User not found for the provided token.', statusCode: 404);
            }
        } else {
            return HelperClass::sendResponse('e', 'Invalid or expired reset token.', statusCode: 400);
        }
    }
}
