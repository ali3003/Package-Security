<?php

namespace App\Http\Controllers;

use App\Helper\HelperClass;
use App\Services\JWTService;
use Illuminate\Http\Request;
use App\Models\PasswordStorage;

class PasswordsController extends Controller
{
    protected $jwtService;
    /**
     * __construct
     *
     * @param  mixed $jWTService
     * @return void
     */
    public function __construct(JWTService $jWTService)
    {
        $this->jwtService = $jWTService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = HelperClass::CheckGetAllPasswords($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }
        return HelperClass::sendResponse(data: PasswordStorage::where('user_id', $this->jwtService->decode($request->jwt)->sub)->get(['id', 'name', 'description', 'password', 'updated_at']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = HelperClass::CheckPasswordSaveRequirement($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }
        PasswordStorage::create([
            'user_id' => $this->jwtService->decode($request->jwt)->sub,
            'name' => $request->name,
            'description' => $request->description,
            'password' => $request->password,
        ]);
        return HelperClass::sendResponse(message: "password stored successfully", statusCode: 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = HelperClass::validateUpdatePasswordStorage($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }
        PasswordStorage::find($request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'password' => $request->password,
        ]);
        return HelperClass::sendResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validator = HelperClass::validateDeletePasswordStorage($request);

        if ($validator->fails()) {
            return HelperClass::sendResponse('e', $validator->errors(), statusCode: 400);
        }
        PasswordStorage::find($request->id)->delete();
        return HelperClass::sendResponse();
    }
}
