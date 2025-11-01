<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;

class TestSmsController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
        ]);

        $mobile = $request->mobile;
        $code = rand(100000, 999999);

        $sms = new SmsService();
        $result = $sms->sendVerificationCode($mobile, $code);

        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'پیامک با موفقیت ارسال شد.',
                'code' => $code, // فقط برای تست نمایش داده می‌شود
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'ارسال پیامک با خطا مواجه شد.',
        ], 500);
    }
}
