<?php

namespace App\Http\Controllers\Api\v1;

use Mailgun\Mailgun;
use App\RegCoupon;
use App\User;
use App\Users;
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
          'name' => 'required|min:3',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:3',
          'c_password' => 'required|same:password',
          'attendedWorkshop' => 'required',
          'school' => 'required',
          'reg_coupon' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
            $validator->errors(),
          ], 417);
        }

        //<< validasi reg coupon
        $regCoupon = RegCoupon::where('coupon_code', $request->reg_coupon)->first();
        if (!$regCoupon) {
            return response()->json([
            'message' => 'kupon tidak ditemukan',
          ], 404);
        }
        $couponUsed = User::where('reg_coupon', $regCoupon)->count();
        $regCoupon->coupon_used = $couponUsed;
        $regCoupon->save();

        if ($regCoupon->coupon_used >= $regCoupon->coupon_quota || strtotime('now') > strtotime($regCoupon->expired_date)) {
            return response()->json([
            'message' => 'kupon sudah tidak bisa digunakan',
          ], 403);
        }
        //validasi reg coupon >>

        $npsn = $request->input('school.npsn');
        $school = SchoolGsm::where('npsn', $npsn);

        $schoolHitung = $school->count();
        if ($schoolHitung == 1) {
            $schoolData = $school->first();

            $user = User::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => bcrypt($request->password),
              'attendedWorkshop' => $request->attendedWorkshop,
              'schoolgsm_id' => $schoolData->_id,
              'sekolah' => $schoolData->sekolah,
              'role' => 'user',
              'request' => 'false',
              'level' => 'basic',
              'assessor_id' => null,
              'photo_profile' => [],
              'invited_by' => $request->input('invited_by'),
              'fcm_token' => [],
              'kupon' => [],
              'reg_coupon' => $request->reg_coupon,
            ]);
            $userID = $user->id;
            $thread = Thread::where('school_id', $schoolData->id)->first();
            // return $thread;
            $thread->addParticipant($userID);
            $message = Message::create([
              'thread_id' => $thread->id,
              'user_id' => $userID,
              'body' => '[BARU] Saya baru ditambahkan ke Group Chat',
          ]);
            // return $thread;
            try {
                // Validate the value...
                $result = $this->sendEmailRegister($user, $school);
            } catch (Exception $e) {
                report($e);

                return false;
            }

            return response()->json([
              'name' => $user->name,
              'message' => 'Register success!',
              'data' => $result,
            ], 201);
        } elseif ($schoolHitung == 0) {
            $longitude = floatval($request->input('school.bujur'));
            $latitude = floatval($request->input('school.lintang'));

            $school = new SchoolGsm();
            $school->propinsi = $request->input('school.propinsi');
            $school->npsn = $request->input('school.npsn');
            $school->kode_kab_kota = $request->input('school.kode_kab_kota');
            $school->kabupaten_kota = $request->input('school.kabupaten_kota');
            $school->kode_kec = $request->input('school.kode_kec');
            $school->kecamatan = $request->input('school.kecamatan');
            $school->sekolah = $request->input('school.sekolah');
            $school->kecamatan = $request->input('school.kecamatan');
            $school->alamat_jalan = $request->input('school.alamat_jalan');
            $school->status = $request->input('school.status');
            $school->bentuk = $request->input('school.bentuk');
            $school->lokasi = [$longitude, $latitude];
            $school->model_gsm = [
          'updated_date' => null,
          'flag' => 'jejaring_gsm',
        ];
            $school->save();

            $schoolBaru = SchoolGsm::where('npsn', $npsn)->first();
            $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => bcrypt($request->password),
          'attendedWorkshop' => $request->attendedWorkshop,
          'schoolgsm_id' => $schoolBaru->_id,
          'sekolah' => $schoolBaru->sekolah,
          'role' => 'user',
          'request' => 'false',
          'level' => 'basic',
          'assessor_id' => null,
          'photo_profile' => [],
          'invited_by' => $request->input('invited_by'),
          'fcm_token' => [],
          'kupon' => [],
          'reg_coupon' => $request->reg_coupons,
        ]);

            //mengirim Email
            $result = $this->sendEmailRegister($user, $school);
            $groupChat = $this->createGroupChat($schoolBaru, $user);

            return $groupChat;

            return response()->json([
          'name' => $user->name,
          'message' => 'Register success!, sekolah baru terbuat',
          'email' => $result,
        ], 201);
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

    public function sendEmailRegister($user, $school)
    {
        $dt = Carbon::now()->toFormattedDateString();
        $domain = env('MAILGUN_DOMAIN');
        $mailgun_api = env('MAILGUN_API');

        $mgClient = Mailgun::create($mailgun_api);

        $view = view('email.register', ['date' => $dt,
      'user' => $user,
      'school' => $school,
      ])->render();
        try {
            $result = $mgClient->sendMessage($domain,
            array('from' => 'Elearning GSM <postmaster@'.env('MAILGUN_FROM').'>',
                'to' => $user->email,
                'subject' => 'Pendaftaran Elearning Gerakan Sekolah Menyenangkan',
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
