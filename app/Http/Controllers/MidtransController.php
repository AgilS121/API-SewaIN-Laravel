<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Midtrans\Config;
use Midtrans\Notification;

use App\Models\Sewas;
use App\Models\Barangs;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3dss');
    }

    public function buy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'id_sewa' => 'required',
            'total_harga' => 'required',
            'bank' => 'required|in:bca,bni'
        ]);

        if($validator->fails())
        {
            return response()->json(['message'=>'invalid','data'=>$validator->errors()]);
        }

        try {
            $apakahLogin = Auth::check();
            // dd($apakahLogin);

            if($apakahLogin == true)
            {
                $dataLogin = Auth::user();
                // dd($dataLogin->status);
                if ($dataLogin->status == "members"){
                    $sewa = Sewas::findOrFail($request->id_sewa);
                    // dd($dataLogin->id);
                    $barang = Barangs::findOrFail($sewa->id_barang);

                    DB::beginTransaction();

                    $serverKey = config('services.midtrans.server_key');
                    $total_harga = $barang->harga * $sewa->jumlah_sewa;

                    $response = Http::withBasicAuth($serverKey, '')
                        ->post('https://api.sandbox.midtrans.com/v2/charge', [
                            'payment_type' => 'bank_transfer',
                            'transaction_details' => [
                                'order_id' => 'ORDER-' . $sewa->id,
                                'gross_amount' => $total_harga,
                            ],
                            'customer_details' => [
                                'name' => $dataLogin->name,
                                'email' => $dataLogin->email,
                            ],
                            'bank_transfer' => [
                                'bank' => $request->bank
                            ]
                        ]);

                    if($response->failed())
                    {
                        return response()->json(['message' => 'failed charge']);
                    }
                    $result = $response->json();
                    if($result['status_code'] != '201')
                    {
                        return response()->json(['message' => $result['status_message'], 500]);
                    }

                    $vaNumber = $response['va_numbers'][0]['va_number'];

                    DB::table('midtrans_transactions')->insert([
                        'id_sewa' => $sewa->id,
                        'status' => 'BOOKED',
                        'payment_type' => 'Bank Transfer',
                        'transaction_time' => Carbon::now(),
                        'gross_amount' => $total_harga,
                        'transaction_id' => Str::random(6),
                        'va_number' => $vaNumber,
                        'bank' => $request->bank,
                        'created_at' => now()
                    ]);

                    DB::table('barangs')->where('id', $barang->id)->update([
                        'stok' => $barang->stok - $sewa->jumlah_sewa
                    ]);

                    DB::commit();
                    return response()->json($response->json());
                } else if($dataLogin->status == "penyewa") {
                    $sewa = Sewas::findOrFail($request->id_sewa);
                    // dd($sewa->id);
                    $barang = Barangs::findOrFail($sewa->id_barang);
                    // dd($barang)

                    DB::beginTransaction();

                    $serverKey = config('services.midtrans.server_key');
                    $total_harga = $barang->harga * $sewa->jumlah_sewa;

                    $response = Http::withBasicAuth($serverKey, '')
                        ->post('https://api.sandbox.midtrans.com/v2/charge', [
                            'payment_type' => 'bank_transfer',
                            'transaction_details' => [
                                'order_id' => 'ORDER-' . $sewa->id,
                                'gross_amount' => $total_harga,
                            ],
                            'customer_details' => [
                                'name' => $dataLogin->name,
                                'email' => $dataLogin->email,
                            ],
                            'bank_transfer' => [
                                'bank' => $request->bank
                            ]
                        ]);

                    if($response->failed())
                    {
                        return response()->json(['message' => 'failed charge']);
                    }
                    $result = $response->json();
                    if($result['status_code'] != '201')
                    {
                        return response()->json(['message' => $result['status_message'], 500]);
                    }

                    $vaNumber = $response['va_numbers'][0]['va_number'];

                    DB::table('midtrans_transactions')->insert([
                        'id_sewa' => $sewa->id,
                        'status' => 'BOOKED',
                        'payment_type' => 'Bank Transfer',
                        'transaction_time' => Carbon::now(),
                        'gross_amount' => $total_harga,
                        'transaction_id' => Str::random(6),
                        'va_number' => $vaNumber,
                        'bank' => $request->bank,
                        'created_at' => now()
                    ]);

                    DB::table('barangs')->where('id', $barang->id)->update([
                        'stok' => $barang->stok - $sewa->jumlah_sewa
                    ]);

                    DB::commit();
                    return response()->json($response->json());
                } else {
                    return response()->json([
                        'message' => 'Login Terlebih Dahulu'
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Unauthorized',
                ]);
            }

        } catch (\Exception $e)
        {
            DB::rollback();
            return response()->json(['message'=>$e->getMessage()], 500);
        }
    }

}
