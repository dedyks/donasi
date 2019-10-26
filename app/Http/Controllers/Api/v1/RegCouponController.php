<?php

namespace App\Http\Controllers\Api\v1;

use App\RegCoupon;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class RegCouponController extends Controller
{
    //
    public function index()
    {
      $regCoupon = RegCoupon::orderBy('created_at', 'desc')->get();

      return response()->json([
        'message' => 'success',
        'data' => $regCoupon
      ], 200);
    }

    public function create(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'coupon_code' => 'required',
        'coupon_title' => 'required',
        'coupon_quota' => 'nullable',
        'expired_date' => 'nullable',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'messsage' => $validator->errors()
        ], 417);
      }

      $flag = RegCoupon::where('coupon_code', $request->coupon_code);
      if ($flag->count() == 1) {
        return response()->json([
          'message' => 'Kode kupon pendaftaran tidak boleh sama, gunakan kode yang unik'
        ], 409);
      }

      if (!$request->coupon_quota && $request->coupon_quota !== 0){
        $coupon_quota = 9999;
      } else {
        $coupon_quota = $request->coupon_quota;
      }

      if (!$request->expired_date){
        $expired_date = '31-12-2099';
      } else {
        $expired_date = $request->expired_date;
      }

      RegCoupon::create([
        'coupon_code' => $request->coupon_code,
        'coupon_title' => $request->coupon_title,
        'coupon_quota' => $coupon_quota,
        'coupon_used' => 0,
        'expired_date' => $expired_date,
        'status' => 'true'
      ]);

      return response()->json([
        'message' => 'success'
      ], 200);
    }

    public function update(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'coupon_code' => 'required',
        'coupon_title' => 'required',
        'coupon_quota' => 'nullable',
        'expired_date' => 'nullable',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'messsage' => $validator->errors()
        ], 417);
      }

      $regCoupon = RegCoupon::find($id);

      if (!$regCoupon){
        return response()->json([
          'message' => 'not found'
        ], 404);
      }

      $regCoupon->coupon_code = $request->coupon_code;
      $regCoupon->coupon_title = $request->coupon_title;
      if (!$request->coupon_quota && $request->coupon_quota !== 0){
        $regCoupon->coupon_quota = 9999;
      } else {
        $regCoupon->coupon_quota = $request->coupon_quota;
      }
      if (!$request->expired_date){
        $regCoupon->expired_date = '31-12-2099';
      } else {
        $regCoupon->expired_date = $request->expired_date;
      }

      $regCoupon->save();

      return response()->json([
        'message' => 'update success'
      ], 200);
    }

    public function delete($id)
    {
      $regCoupon = RegCoupon::find($id);

      if (!$regCoupon){
        return response()->json([
          'message' => 'not found'
        ], 404);
      }

      $regCoupon->delete();
      return response()->json([
        'message' => 'delete success'
      ], 200);
    }

    public function useRegCoupon($coupon_code)
    {
      $regCoupon = RegCoupon::where('coupon_code', $coupon_code)->first();
      if (!$regCoupon){
        return response()->json([
          'message' => 'kupon tidak ditemukan'
        ], 404);
      }

      $couponUsed = User::where('reg_coupon', $coupon_code)->count();
      $regCoupon->coupon_used = $couponUsed;
      $regCoupon->save();

      if ($regCoupon->coupon_used>=$regCoupon->coupon_quota || date('d-m-Y')>$regCoupon->expired_date){
        return response()->json([
          'message' => 'kupon sudah tidak bisa digunakan'
        ], 403);
      }

      return response()->json([
        'message' => 'success',
        'data' => $regCoupon->coupon_title
      ], 200);
    }
}
