<?php

namespace App\Http\Controllers\Api\v1;

use Mailgun\Mailgun;
use App\RegCoupon;
use App\User;
use App\Users;
use App\Activation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Validator;
use App\SchoolGsm;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;

class PassportController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
          'full_name' => 'required|min:3',
          'email' => 'required|email|unique:users_donasi'
        ]);

        if ($validator->fails()) {
            return response()->json([
            $validator->errors(),
          ], 417);
        }
        $user = new User([
          'name' => $request->full_name,
          'email' => $request->email,
          'role' => 'user',
          'is_activated' => false,
          'password' => ''
        ]);
        $user->save();

        $objectID =str_random(35);
        $oid = (string)$objectID;

        $activation = new Activation([
          'email' => $request->email,
          'token' => $oid,
          'used' => false
        ]);
        $activation->save();

        $result = $this->sendEmailRegister($user,$activation->token);

        return response()->json([
          'name' => $user->name,
          'message' => 'Register success! cek email anda',
          'email' => $result,
        ], 201);
        }

    public function checkActivationToken($token)
    {
      $check = Activation::where('token',$token)->first();
      if ($check === null) {
        // user doesn't exist
        return response()->json([
          'message' => 'Token tidak valid',
        ], 404);
     }
     else{
      return response()->json([
        'message' => 'Token valid',
      ], 200);
     }
    }
    public function activation(Request $request)
    {
      $check = Activation::where('token',$request->input('token'))->where('used',false)->first();
      if ($check === null) {
        // user doesn't exist
        return response()->json([
          'message' => 'Token tidak valid',
        ], 404);
     }
     else{
       $dataUser = User::where('email',$check->email)->first();
       $dataUser->password = bcrypt($request->input('password'));
       $dataUser->is_activated = true;
       $dataUser->save();

       $check->used = true;
       $check->save();
      return response()->json([
        'message' => 'Berhasil aktivasi',
      ], 200);
     }  
    }

    public function createGroupChat($schoolData, $userData)
    {
        $thread = Thread::create([
              'subject' => 'sekolah',
              'school_id' => $schoolData->id,
          ]);
        // Message
        $message = Message::create([
              'thread_id' => $thread->id,
              'user_id' => $userData->id,
              'body' => '[BARU] Saya baru ditambahkan ke Group Chat',
          ]);
        // Sender
        $participant = Participant::create([
              'thread_id' => $thread->id,
              'user_id' => $userData->id,
              'last_read' => new Carbon(),
          ]);
        // Recipients

        return array([
            'thread' => $thread,
            'messages' => $message,
            'particapants' => $participant,
          ]);
    }


    public function sendWa(Request $request)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);
        $ToInput = $request->input('to');
        $BodyInput = $request->input('body');

        $message = $twilio->messages
                  ->create('whatsapp:+6282149324543', // to
                           array(
                               'from' => 'whatsapp:+14155238886',
                               'body' => $BodyInput,
                           )
                  );

        return response()->json([
                    'status' => 201,
                    'message' => 'Jika data tidak null, maka WA terkirim',
                    'data' => $message->sid,
                  ]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
          'email' => 'required|email',
          'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
              $validator->errors(),
            ], 417);
        }
        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            if ($user->role == 'admin') {
                //$token = $user->createToken('GSM', ['*'])->accessToken;
                $user->role = '*';
            }// else {
            //$token = $user->createToken('GSM', [$user->role])->accessToken;
            //}

            $oauthClient = (object) DB::collection('oauth_clients')->where('name', 'Laravel Password Grant Client')->first();
            $oauthClientId = (array) $oauthClient->_id;

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', env('APP_BASEURL').'oauth/token', [
              'timeout' => 10,
              'form_params' => [
                  'grant_type' => 'password',
                  'client_id' => $oauthClientId['oid'],
                  'client_secret' => $oauthClient->secret,
                  'username' => $request->email,
                  'password' => $request->password,
                  'scope' => $user->role,
              ],
            ]);

            //return json_decode((string) $response->getBody(), true);
            $result = json_decode((string) $response->getBody(), true);

  
           
            $userData = Users::with('quiz', 'schoolgsm')->get()->find($user->id);

            return response()->json([
              'token_type' => $result['token_type'],
              'token' => $result['access_token'],
              'refresh_token' => $result['refresh_token'],
              'expires_in' => Carbon::now()->addDays(1)->format('d-m-Y H:i:s'),
              'data' => $userData,
            ], 200);
        } else {
            return response()->json([
          'error' => 'Unauthorized',
        ], 401);
        }
    }

    public function adminLogin(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'email' => 'required|email',
        'password' => 'required',
      ]);

        if ($validator->fails()) {
            return response()->json([
          $validator->errors(),
        ], 417);
        }

        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $userData = Users::with('quiz', 'schoolgsm')->get()->find($user->id);
            if ($user->role == '*') {
                $user->role = '*';
            } else {
                return response()->json([
                  'error' => 'You are not allowed.',
                ], 401);
            }

            $oauthClient = (object) DB::collection('oauth_clients')->where('name', 'Laravel Password Grant Client')->first();
            $oauthClientId = (array) $oauthClient->_id;

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', env('APP_BASEURL').'oauth/token', [
              'form_params' => [
                  'grant_type' => 'password',
                  'client_id' => $oauthClientId['oid'],
                  'client_secret' => $oauthClient->secret,
                  'username' => $request->email,
                  'password' => $request->password,
                  'scope' => $user->role,
              ],
            ]);
            //return json_decode((string) $response->getBody(), true);
            $result = json_decode((string) $response->getBody(), true);

            if ($request->has('fcm_token')) {
                $user->push('fcm_token', $request->input('fcm_token'), true);
            }

            return response()->json([
              'token_type' => $result['token_type'],
              'token' => $result['access_token'],
              'refresh_token' => $result['refresh_token'],
              'expires_in' => Carbon::now()->addDays(1)->format('d-m-Y H:i:s'),
              'data' => $userData,
            ], 200);
        } else {
            return response()->json([
              'error' => 'Unauthorized',
            ], 401);
        }
    }

    public function FCMAfterLogin(Request $request)
    {
      // return $request->input('fcm_token');
      $user = auth()->user();
      if ($request->has('fcm_token')) {
        $user->push('fcm_token', $request->input('fcm_token'), true);
    }

    //clear unused token
    if (count($user->fcm_token) > 2) {
        //clear fail token
        $user->fcm_token = array_diff($user->fcm_token, ['loading...', 'Error retrieving Instance ID token.']);
        $user->save();

        $user->fcm_token = array_slice($user->fcm_token, -2, 2);
        $user->save();
    }
    return $user->fcm_token;

    }


    public function assessorLogin(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'email' => 'required|email',
        'password' => 'required',
      ]);

        if ($validator->fails()) {
            return response()->json([
          $validator->errors(),
        ], 417);
        }

        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $userData = Users::with('quiz', 'schoolgsm')->get()->find($user->id);
            if ($user->role == 'admin') {
                $user->role = '*';
            } elseif ($user->role == 'assessor') {
                $user->role = 'assessor';
            } else {
                return response()->json([
                  'error' => 'You are not allowed.',
                ], 401);
            }

            if ($request->has('fcm_token')) {
              $user->push('fcm_token', $request->input('fcm_token'), true);
          }
            $oauthClient = (object) DB::collection('oauth_clients')->where('name', 'Laravel Password Grant Client')->first();
            $oauthClientId = (array) $oauthClient->_id;

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', env('APP_BASEURL').'oauth/token', [
              'form_params' => [
                  'grant_type' => 'password',
                  'client_id' => $oauthClientId['oid'],
                  'client_secret' => $oauthClient->secret,
                  'username' => $request->email,
                  'password' => $request->password,
                  'scope' => $user->role,
              ],
            ]);
            //return json_decode((string) $response->getBody(), true);
            $result = json_decode((string) $response->getBody(), true);

            if ($request->has('fcm_token')) {
                $user->push('fcm_token', $request->input('fcm_token'), true);
            }
 //clear unused token
            if (count($user->fcm_token) > 2) {
                //clear fail token
                $user->fcm_token = array_diff($user->fcm_token, ['loading...', 'Error retrieving Instance ID token.']);
                $user->save();

                $user->fcm_token = array_slice($user->fcm_token, -2, 2);
                $user->save();
            }

            return response()->json([
              'token_type' => $result['token_type'],
              'token' => $result['access_token'],
              'refresh_token' => $result['refresh_token'],
              'expires_in' => Carbon::now()->addDays(1)->format('d-m-Y H:i:s'),
              'data' => $userData,
            ], 200);
        } else {
            return response()->json([
              'error' => 'Unauthorized',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $data = Auth()->user()->pull('fcm_token', $request->input('fcm_token'));
        $request->user()->token()->revoke();

        return response()->json([
        'message' => 'Logout success!',
      ]);
    }

    public function details()
    {
        return response()->json([
        'user' => auth()->user(),
      ], 200);
    }

    public function emailRegister()
    {
        $mgClient = Mailgun::create('cd1df471cdd5458ae38ea419ed745f26-7caa9475-ad9b11e6');

        try {
            $result = $mgClient->sendMessage('bumijaya.id',
            array('from' => 'Elearning GSM <postmaster@bumijaya.id>',
                'to' => 'dedysmd@hotmail.com',
                'subject' => 'Hello dedy',
                'text' => 'hellow', ));
        } catch (MissingRequiredMIMEParameters $e) {
        }

        return response()->json([
      'name' => 'dedy',
      'message' => 'Register success!',
      'data' => $result,
    ], 201);
    }

    public function sendEmailRegister($user, $token)
    {
        $dt = Carbon::now()->toFormattedDateString();
        $domain = env('MAILGUN_DOMAIN');
        $mailgun_api = env('MAILGUN_API');

        $mgClient = Mailgun::create($mailgun_api);

        $view = view('email.register', ['date' => $dt,
      'name' => 'dedy kurniawan santoso',
      'token' => $token,
      ])->render();
        try {
            $result = $mgClient->sendMessage($domain,
            array('from' => 'Donasi GSM <postmaster@'.env('MAILGUN_FROM').'>',
                'to' => $user->email,
                'subject' => 'Aktivasi Akun Donasi Anda',
                'html' => $view, ));
        } catch (MissingRequiredMIMEParameters $e) {
        }

        return $result;
    }

    public function createKodeReferral()
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Output: 54esmdr0qf
        $random = (string) substr(str_shuffle($permitted_chars), 0, 10);
        if ($this->checkKodeReferralExist($random)) {
            return $this->createKodeReferral();
        }

        return $random;
    }

    public function checkKodeReferralExist($random)
    {
        return Users::where('kode_referral', $random)->first();
    }

    public function createRandomLink()
    {
        $randVariable = (string) mt_rand(10000, 99999);
        if ($this->checkRandomLinkExist($randVariable)) {
            return $this->createRandomLink();
        }

        return $randVariable;
    }

    public function checkRandomLinkExist($random)
    {
        return Article::where('share_link', $random)->first();
    }

    public function refreshToken(Request $request)
    {
        $user = auth()->user();
        if ($user->role == 'admin') {
            $user->role = '*';
        }

        $oauthClient = (object) DB::collection('oauth_clients')->where('name', 'Laravel Password Grant Client')->first();
        $oauthClientId = (array) $oauthClient->_id;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', env('APP_BASEURL').'oauth/token', [
          'form_params' => [
              'grant_type' => 'refresh_token',
              'refresh_token' => $request->refresh_token,
              'client_id' => $oauthClientId['oid'],
              'client_secret' => $oauthClient->secret,
              'scope' => $user->role,
          ],
        ]);
        //return json_decode((string) $response->getBody(), true);
        $result = json_decode((string) $response->getBody(), true);

        return response()->json([
          'token_type' => $result['token_type'],
          'token' => $result['access_token'],
          'refresh_token' => $result['refresh_token'],
          'expires_in' => Carbon::now()->addDays(15)->format('d-m-Y'),
        ], 200);
    }
}
