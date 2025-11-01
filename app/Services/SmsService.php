<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SmsService
{
    protected string $apiKey = '23c9a86292fb4d1f9696e1ef749a02b7';
    protected string $from = '50004001668992'; // شماره فرستنده واقعی‌تو بذار اینجا

    /**
     * ارسال پیامک تأیید ثبت‌نام
     *
     * @param string $mobile شماره کاربر
     * @param string $code کد تایید (از بیرون میاد)
     */
    public function sendVerificationCode(string $mobile, string $code)
    {
        // زمان فعلی بر اساس تهران
        $now = Carbon::now('Asia/Tehran');
        $hour = (int) $now->format('H');

        // محدودیت بازه ارسال پیامک
        if ($hour < 8 || $hour >= 22) {
            return [
                'status' => 'error',
                'message' => 'ارسال پیامک فقط بین ساعت ۸ صبح تا ۱۰ شب مجاز است.',
                'time' => $now->format('H:i'),
            ];
        }

        // متن پیامک
        $message = "کد تایید شما: {$code}\nاین کد تا ۵ دقیقه معتبر است.";

        // آدرس API ملی‌پیامک
        $url = "https://console.melipayamak.com/api/send/simple/{$this->apiKey}";

        // داده‌های بدنه درخواست
        $payload = [
            'from' => $this->from,
            'to'   => $mobile,
            'text' => $message,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            if ($response->failed()) {
                return [
                    'status' => 'error',
                    'message' => 'ارتباط با سرور ‌پیامک برقرار نشد.',
                    'response' => $response->body(),
                ];
            }

            return [
                'status' => 'success',
                'message' => 'کد تأیید با موفقیت ارسال شد.',
                'response' => $response->json(),
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'خطا در ارسال پیامک: ' . $e->getMessage(),
            ];
        }
    }
}
