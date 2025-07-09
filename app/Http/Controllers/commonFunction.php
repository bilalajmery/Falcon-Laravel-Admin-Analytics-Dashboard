<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class commonFunction extends Controller
{
    public function tryCatchResponse($th)
    {
        try {

            if (env('SEND_ERROR_MAIL')) {
                $sendEmail = $this->sendErrorEmail($th);
                if (isset($sendEmail['error'])) {
                    return response()->json(['error' => true, 'message' => $sendEmail['issue']]);
                }
            }

            return response()->json([
                'error' => true,
                'message' => 'Something went wrong. Please try again later.',
                'issue' => $th->getMessage(),
                'Line No' => $th->getLine(),
                'Directory' => $th->getFile(),
            ], 500);
        } catch (\Throwable $th) {
            return ['error' => true, 'message' => 'Error In TryCatch Function'];
        }
    }

    public function sendErrorEmail($exception)
    {
        try {

            $response = Http::post('https://error-mailer.ellipticals.website/api/error', [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'subject' => 'Got Error In CC CROP Project',
            ]);

            if ($response->successful()) {
                if (isset($response->json()['error'])) {
                    if ($response->json()['error'] == true) {
                        return ['error' => true, 'issue' => $response->json()['message']];
                    }
                }
            } else {
                return ['error' => true, 'issue' => $response->json()];
            }
        } catch (\Throwable $th) {
            return ['error' => true, 'issue' => $th->getMessage()];
        }
    }

    public function generateOtp(): string
    {
        return (string) random_int(100000, 999999);
    }

    public function uIdGenerate()
    {
        return Str::uuid();
    }

    public function storeImage($image, $path)
    {
        try {

            // $client = new Client();
            // $response = $client->post(env('ASSETS_STORE_URL'), [
            //     'multipart' => [
            //         [
            //             'name' => 'image',
            //             'contents' => fopen($image->getPathname(), 'r'),
            //             'filename' => $image->getClientOriginalName(),
            //         ],
            //         [
            //             'name' => 'path',
            //             'contents' => $path,
            //         ],
            //     ],
            // ]);

            // return json_decode($response->getBody()->getContents(), true);

            // // Get file details
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $mimeType = $image->getMimeType();
            $size = $image->getSize();

            $name = strtolower(str_replace(' ', '-', pathinfo($originalName, PATHINFO_FILENAME) . '-' . time() . '-' . mt_rand(10000000, 99999999) . '.' . $extension));

            $image->move(public_path($path), $name);

            $fullPath = url($path . '/' . $name);

            return [
                'error' => false,
                'path' => $fullPath,
                'extension' => $extension,
                'mimeType' => $mimeType,
                'size' => $size,
                'name' => $originalName,
            ];

        } catch (\Throwable $th) {
            // Return error message in case of failure
            return [
                'error' => true,
                'message' => $th->getMessage(),
            ];
        }
    }

    public function sendOtp($otp, $user)
    {
        $response = Http::post('https://new-mail-sender.ellipticals.website/api/otp', [
            'smtp_host' => env('MAIL_HOST'),
            'smtp_port' => env('MAIL_PORT'),
            'smtp_username' => env('MAIL_USERNAME'),
            'smtp_password' => env('MAIL_PASSWORD'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'from_name' => env('MAIL_FROM_NAME'),
            'template' => 'test',
            'subject' => 'Your One Time Password',
            'otp' => $otp,
            'email' => $user->email,
            'name' => $user->name,
            'companyName' => 'FALCON DASHBOARD',
            'companyLogo' => 'https://static.vecteezy.com/system/resources/thumbnails/008/214/517/small_2x/abstract-geometric-logo-or-infinity-line-logo-for-your-company-free-vector.jpg',
        ]);

        if ($response->successful()) {
            return [
                'message' => 'OTP sent successfully',
            ];
        }

        return [
            'error' => true,
            'message' => $response->json()['message'],
        ];
    }
}
