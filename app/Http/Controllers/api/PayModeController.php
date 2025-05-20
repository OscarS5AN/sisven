<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PayMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayModeController extends Controller
{
    public function index()
    {
        $payModes = PayMode::all();
        return response()->json(['pay_modes' => $payModes]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'observation' => ['nullable', 'string', 'max:200']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
                'statusCode' => 400
            ], 400);
        }

        $payMode = PayMode::create($request->all());
        return response()->json(['pay_mode' => $payMode], 201);
    }

    public function show($id)
    {
        $payMode = PayMode::find($id);
        if (is_null($payMode)) {
            return response()->json(['message' => 'Pay mode not found'], 404);
        }
        return response()->json(['pay_mode' => $payMode]);
    }

    public function update(Request $request, $id)
    {
        $payMode = PayMode::find($id);
        if (is_null($payMode)) {
            return response()->json(['message' => 'Pay mode not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'observation' => ['nullable', 'string', 'max:200']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
                'statusCode' => 400
            ], 400);
        }

        $payMode->update($request->all());
        return response()->json(['pay_mode' => $payMode]);
    }

    public function destroy($id)
    {
        $payMode = PayMode::find($id);
        if (is_null($payMode)) {
            return response()->json(['message' => 'Pay mode not found'], 404);
        }

        $payMode->delete();
        return response()->json(['pay_modes' => PayMode::all(), 'success' => true]);
    }
}