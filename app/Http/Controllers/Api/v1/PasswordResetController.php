<?php

namespace App\Http\Controllers\Api\v1;
use Mailgun\Mailgun;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    //
    public function create(Request $request)
    {
      $request->validate([
        'email' => 'required|string|email'
      ]);

      $user = User::where('email', $request->email)->first();

      if (!$user) {
        return response()->json([
          'message' => 'The email address is not registered.'
        ], 404);
      }

      $passwordReset = PasswordReset::updateOrCreate(
        [
          'email' => $user->email
        ], [
          'email' => $user->email,
          'token' => str_random(60)
        ]
      );

    


      if ($user && $passwordReset) {
        $user->notify(
          new PasswordResetRequest($passwordReset->token)
        );
      }

       //mengirim Email
      $result =$this->sendEmailResetPassword($passwordReset);
    return response()->json([
      'data' => $passwordReset->email,
      'message' => 'We have sent you an email for your password reset link.',
      'result' =>$result
    ], 201);
    }

    public function find($token)
    {
      $passwordReset = PasswordReset::where('token', $token)->first();

      if (!$passwordReset){
        return response()->json([
          'message' => 'This password reset token is invalid.'
        ], 404);
      }

      if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
        $passwordReset->delete();

        return response()->json([
          'message' => 'This password reset token is expired.'
        ], 404);
      }

      return response()->json($passwordReset);
    }

    public function reset(Request $request)
    {
      $request->validate([
    
        'password' => 'required|string|confirmed',
        'token' => 'required|string'
      ]);

      $passwordReset = PasswordReset::where([
        ['token' => $request->token]
      ])->first();

      if (!$passwordReset){
        return response()->json([
          'message' => 'This password reset token is invalid.'
        ], 404);
      }

      $user = User::where('email', $passwordReset->email)->first();

      if (!$user) {
        return response()->json([
          'message' => 'The e-mail is not match with the token. Check your e-mail spelling.'
        ], 404);
      }

      $user->password = bcrypt($request->password);
      $user->save();

      $passwordReset->delete();

      $user->notify(new PasswordResetSuccess($passwordReset));

      return response()->json([
        'message' => 'Your password successfully changed. Please login with the new password.'
      ], 200);
    }

    public function sendEmailResetPassword($passwordReset)
    {
      $dt = Carbon::now()->toFormattedDateString();
      $mgClient = Mailgun::create('cd1df471cdd5458ae38ea419ed745f26-7caa9475-ad9b11e6');
      $domain = "bumijaya.id";
  
      $view = view('email.reset_password',['date' => $dt,
      'data' => $passwordReset
      ]);
      try {
        $result = $mgClient->sendMessage($domain,
            array('from' => 'Elearning GSM <postmaster@bumijaya.id>',
                'to' => $passwordReset->email,
                'subject' => 'Permintaan reset password',
                'html' => $view));
    } catch (MissingRequiredMIMEParameters $e) {
    }
    return $result;
    }
}
