<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use App\Models\PasswordReset;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:255|confirmed|min:6'
        ], [
            // Pesan validasi
        ]);

        if ($validator->fails()) {
            // Validasi gagal
            $errors = $validator->errors();

            // Periksa jenis kesalahan dan atur status code yang sesuai
            if ($errors->has('email')) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errors->first('email')
                ], 422);
            }

            if ($errors->has('password')) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errors->first('password')
                ], 422);
            }

            // Kesalahan lainnya
            return response()->json([
                'status' => 'error',
                'message' => $errors->all()
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'status' => 'penyewa',
        ]);

        // Mengirim email verifikasi
        $this->sendVerifyMail($user->email);

        return response()->json([
            'status' => 'success',
            'message' => 'User baru berhasil dibuat',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        // dd($user);

        $user->update($request->all());
        return new UserResource($user);
    }

    public function sendVerifyMail($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            $random = Str::random(40);
            $domain = URL::to('/');
            $url = $domain . '/verify-mail/' . $random;

            $data['url'] = $url;
            $data['email'] = $email;
            $data['name'] = $user->name;
            $data['title'] = "Confirm your email to register SewaIN, " . $user->name;
            $data['body'] = "Please click the link below to verify your email.";

            Mail::send('verifyMail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });

            $user->remember_token = $random;
            $user->save();

            return response()->json(['success' => true, 'msg' => 'Email sent successfully']);
        } else {
            return response()->json(['success' => false, 'msg' => 'User not found']);
        }
    }


    public function verificationMail($token)
    {
        $user = User::where('remember_token', $token)->first();

        if ($user) {
            $datetime = Carbon::now()->format('Y-m-d H:i:s');

            $user->remember_token = null;
            $user->is_verified = 1;
            $user->email_verified_at = $datetime;
            $user->save();

            return "<h1>Email Verified successfully</h1>";
        } else {
            return view('404');
        }
    }


    public function forgetPassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            // dd($request->email);

            if ($user) {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/reset-password?token='.$token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset";
                $data['body'] = "Please Click on the link below to reset your password";

                Mail::send('forgetPasswordMail', ['data' => $data], function($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime
                    ]
                );

                return response()->json(['success' => true, 'msg' => 'Please check your email to reset your password']);
            } else {
                return response()->json(['success' => false, 'msg' => 'User not found']);
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }


    public function resetPasswordLoad(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->first();
        // dd($resetData);

        if(isset($request->token) && $resetData){
            // dd($resetData->email);
            $user = User::where('email', $resetData->email)->get();
            // dd($user);
            return view('resetPassword', compact('user'));
        } else {
            return view('404');
        }
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::find($request->id);
        $user->password = bcrypt($request->password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return "<h1>Your password has been reset successfully</h1>";
    }
}
