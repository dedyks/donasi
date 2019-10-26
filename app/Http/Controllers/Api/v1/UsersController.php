<?php

namespace App\Http\Controllers\Api\v1;

use DB;
use App\Users;
use App\User;
use App\Modul;
use App\Rapor;
use App\SchoolGsm;
use App\RequestAssessor;
use App\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Validator;
use Image;
use File;
use App\Kupon;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    public $path;
    public $dimensions;
    public $pathdir;

    const MODEL = "App\Users";

    use RESTActions;

    public function __construct()
    {
        $this->path = 'public/images';
        $this->pathdir = storage_path('app/'.$this->path);
        $this->dimensions = ['245', '300', '500'];
    }

    public function all()
    {
        $users = Users::with('schoolgsm')->get();

        return response()->json([
            'message' => $users,
            'school' => $users,
          ], 200);
    }

    public function store(Request $request)
    {
    }

    private function jumlahMale()
    {
        $data = Users::where('sex', 0)->count();

        return response()->json([
            'message' => 'Success!',
            'data' => $user,
          ], 200);
    }

    private function jumlahFemale()
    {
        $data = Users::where('sex', 1)->count();

        return response()->json([
            'message' => 'Success!',
            'data' => $user,
          ], 200);
    }

    private function jumlahSekolahUser()
    {
        $data = Users::distict('school.sekolah')->count();

        return response()->json([
            'message' => 'Success!',
            'data' => $user,
          ], 200);
    }

    public function userRegisteredChart()
    {

        $data = DB::raw('db.users.aggregate(
        [
        { $group : {
        date : { year: { $year: "$created_at" } , month: { $month: "$created_at" }, day: { $dayOfMonth: "$created_at" }},
        count: { $sum: 1 }
        }
        },
        { $sort: { date: 1 } }

        ]
        )');

        $dataTest = Users::raw(function ($collection) {
            return $collection->aggregate([
            [
                '$group' => [
                    '_id' => [
                        'month' => ['$month' => '$created_at'],
                        'day' => ['$dayOfMonth' => '$created_at'],
                        'year' => ['$year' => '$created_at'],
                    ],
                    'count' => [
                        '$sum' => 1,
                    ],
                ],
            ],
        ]);
        });

        return response()->json([
    'message' => "Success",
    'data' => $dataTest,
  ], 200);
    }

    public function test()
    {
        $input = $request->user_id;
        $data = Users::where('_id', $input)->with('quiz', 'schoolgsm')->get();

        return response()->json([
            'message' => 'ok',
            'data' => $data,
          ], 200);
    }

    public function modulDiambil(Request $request)
    {
        $user_id = $request->input('user_id');
        $modul = Modul::get();

        $user = Users::find($user_id)->with('quiz', 'schoolgsm')->first();

        return response()->json([
            'message' => 'OK',
            'data' => $user,
            'modul' => $modul,
          ], 200);
    }

    public function selfProfile()
    {
        $data = Users::with('assessor')->find(Auth()->id());

        return response()->json([
        'user' => $data,
      ], 200);
    }

    public function profile($id)
    {
        $profile = User::with('schoolgsm')->get()->find($id);

        if ($profile) {
            return response()->json([
          'user' => $profile,
        ], 200);
        } else {
            return response()->json([
          'message' => 'User not found.',
        ], 404);
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'name' => 'required',
        'attendedWorkshop' => 'required',
        'detail' => 'nullable',
      ]);

        if ($validator->fails()) {
            return response()->json([
          $validator->errors(),
        ], 417);
        }

        if (auth()->user()->id == $id) {
            $user = User::with('schoolgsm')->get()->find($id);
            $user->name = $request->name;
            $user->attendedWorkshop = $request->attendedWorkshop;
            $user->detail = $request->detail;

            $user->save();

            return response()->json([
          'message' => 'Your profile updated successfully.',
          'profile' => $user,
        ], 200);
        } else {
            return response()->json([
          'error' => 'You are not allowed to access this page.',
        ]);
        }
    }

    public function uploadPhotoProfile(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'image' => 'nullable|max:3000|mimes:jpg,jpeg,png',
      ]);

        if ($validator->fails()) {
            return response()->json([
          $validator->errors(),
        ], 417);
        }

        $userId = auth()->id();
        $data = Users::find($userId);
        $data->photo_profile = [];
        $data->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $res[] = $this->createImage($image);

            $data->push('photo_profile', $res);
        }

        return response()->json([
        'message' => 'Success',
        'data' => $data,
      ], 200);
    }

    public function listQuiz(Request $request)
    {
        $userId = auth()->id();
        $data = Users::with('quiz', 'schoolgsm')->get()->find($userId);

        return response()->json([
        'message' => 'OK',
        'data' => $data,
      ], 200);
    }

    public function userActivity(Request $request)
    {
        $userId = auth()->id();
        $modulDiambil = Quiz::with('modul:title,grade,aspect,created_at')->where('user_id', $userId)->get();

        $tantanganDijawab = Quiz::with('modul:title,grade,aspect,updated_at')->where('user_id', $userId)
        ->where(function ($query) {
            $query->where('flag', 'answered')
              ->orWhere('flag', 'scored');
        })->get();

        $tantanganDinilai = Quiz::with('modul')->where('user_id', $userId)->where('flag', 'scored')->get();

        return response()->json([
        'message' => 'OK',
        'modulDiambil' => $modulDiambil,
        'tantanganDijawab' => $tantanganDijawab,
        'tantanganDinilai' => $tantanganDinilai,
      ], 200);
    }

    public function chooseAssessor($id)
    {
        if (is_null(Users::find($id))) {
            return $this->respond('not_found');
        }

        $users = Users::find($id);
        if ($users->role !== 'assessor') {
            return response()->json([
          'message' => 'Bukan role assessor',
        ], 202);
        }
        $userId = auth()->id();
        $data = Users::get()->find($userId);

        if ($data->assessor_id === $id) {
            return response()->json([
          'message' => 'Tidak dapat memilih assessor yang sama kembali',
        ], 202);
        }
        $now = $users->assessor_kuota_now;
        $max = $users->assessor_kuota_max;

        if ($now < $max) {
            $data->assessor_id = $id;
            $data->save();
            //increment assessor_kuota_now
            $users->increment('assessor_kuota_now');
            //membuat Thread pendampingan
            $pendampingan = $this->createPendampinganChat($id);

            return response()->json([
          'message' => 'assessor terpilih',
          'data' => $data,
          'assessor' => $users,
          'pendampingan' => $pendampingan,
        ], 201);
        } elseif ($now = $max) {
            return response()->json([
          'message' => 'Kuota assessor sudah penuh',
          'data' => $users,
          'now' => $now,
          'max' => $max,
        ], 202);
        } else {
            return response()->json([
          'message' => 'Gagal memilih assessor',
          'data' => $users,
          'now' => $now,
          'max' => $max,
        ], 202);
        }
    }

    public function listAssessor()
    {
        $data = Users::where('role', 'assessor')->with('schoolGsm')->get();

        return response()->json([
        'message' => 'List assessor',
        'data' => $data,
      ], 200);
    }

    public function requestAssessor()
    {
        $user_id = Auth::id();
        $check = RequestAssessor::where('user_id', $user_id)->count();

        if ($check != 0) {
            return response()->json([
          'message' => 'Sudah mengajukan permintaan menjadi Assesor',
        ], 200);
        } else {
            $data = RequestAssessor::create([
          'user_id' => Auth::id(),
        ]);

            return response()->json([
          'message' => 'permintaan menjadi Assesor berhasil',
          'data' => $data,
        ], 201);
        }
    }

    public function createImage($image)
    {
        $filename = Carbon::now()->timestamp.'_'.uniqid().'.'.$image->getClientOriginalExtension();

        foreach ($this->dimensions as $row) {
            $canvas = Image::canvas($row, $row);
            $resizeImage = Image::make($image)->resize($row, $row, function ($constraint) {
                $constraint->aspectRatio();
            });

            if (!File::isDirectory($this->pathdir.'/'.$row)) {
                File::makeDirectory($this->pathdir.'/'.$row, 0777, true);
            }

            $canvas->insert($resizeImage, 'center');
            $canvas->save($this->pathdir.'/'.$row.'/'.$filename);
        }

        $image->storeAs($this->path, $filename);

        $res = [
        'title' => $image->getClientOriginalName(),
        'filename' => $filename,
        'path' => $this->path,
        'dimension' => implode('|', $this->dimensions),
        'created_at' => $now = Carbon::now()->format('Yyyy-mm-dd Hh:mm:ss'),
        'updated_at' => $now,
      ];

        return $res;
    }

    public function createPendampinganChat($assessor_id)
    {
        $thread = Thread::create([
              'subject' => 'pendampingan',
          ]);
        // Message
        $message = Message::create([
              'thread_id' => $thread->id,
              'user_id' => Auth::id(),
              'body' => 'Mohon bimbingannya',
          ]);
        // Sender
        $participant = Participant::create([
              'thread_id' => $thread->id,
              'user_id' => Auth::id(),
              'last_read' => new Carbon(),
          ]);
        // Recipients
        $thread->addParticipant($assessor_id);

        return array([
            'thread' => $thread,
            'messages' => $message,
            'particapants' => $participant,
          ]);
    }

    public function sendRequestAssessor($id)
    {
        if (auth()->user()->id == $id) {
            $user = User::with('schoolgsm')->get()->find($id);
            $user->request = 'true';

            $user->save();

            return response()->json([
            'message' => 'Success',
          ], 200);
        } else {
            return response()->json([
            'message' => 'You are not allowed to access this API',
          ]);
        }
    }

    public function listUserByAssessor($id)
    {
        $user = User::with('schoolgsm', 'assessor')->where('assessor_id', $id)->get();

        if ($user) {
            foreach ($user as $data) {
                $countLaporan = Rapor::where('user_id', $data['_id'])->count();
                $countChat = Message::where('user_id', $data['_id'])->count();
                $data->countLaporan = $countLaporan;
                $data->countChat = $countChat;
            }

            return response()->json([
            'message' => 'success',
            'data' => $user,
          ], 200);
        } else {
            return response()->json([
            'message' => 'not found',
            'data' => '',
          ]);
        }
    }

    public function RegisterTestBerhasil()
    {
        $user = new Users(['name' => 'contohnya saya']);

        $SchoolGsm = SchoolGsm::first();
        $data = Users::where('_id', $user->id)->first();
        $users = $SchoolGsm->users()->save($user);

        return response()->json([
          'message' => 'OK',
          'data' => print_r($data),
          'users' => print_r($users),
        ]);
    }

    public function RegisterTest(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:3',
        'c_password' => 'required|same:password',
        'attendedWorkshop' => 'required',
        'school' => 'required',
      ]);

        if ($validator->fails()) {
            return response()->json([
          $validator->errors(),
        ], 417);
        }
        $npsn = $request->input('school.npsn');
        $school = SchoolGsm::where('npsn', $npsn);
        $schoolHitung = $school->count();
        if ($schoolHitung == 1) {
            $schoolData = $school->first();

            $user = new Users([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'attendedWorkshop' => $request->attendedWorkshop,
                'schoolgsm_id' => $schoolData->_id,
                'role' => 'user',
                'request' => 'false',
                'level' => 'basic',
                'assessor_id' => null,
                'photo_profile' => [],
              ]);
            try {
                // Validate the value...
                //$result = app(PassportContoller::class)->sendEmailRegister($user,$school);
            } catch (Exception $e) {
                report($e);

                return false;
            }
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
            $user = new Users([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'attendedWorkshop' => $request->attendedWorkshop,
            'schoolgsm_id' => $schoolBaru->_id,
            'role' => 'user',
            'request' => 'false',
            'level' => 'basic',
            'assessor_id' => null,
            'photo_profile' => [],
          ]);

            //mengirim Email
           //$result = app(PassportContoller::class)->sendEmailRegister($user,$school);
        }

        $SchoolGsm = SchoolGsm::where('npsn', $npsn)->first();
        $user->save();

        // $user = new Users(['name' => 'Dedy Kurniawan Santoso']);
        // $SchoolGsm = SchoolGsm::first();
        // $users = $SchoolGsm->users()->save($user);
        $userFind = User::where('_id', $user->id)->first();

        $dataSekolah = $userFind->SchoolGsm()->save($SchoolGsm);
        // $result = $user->SchoolGsm()->save($SchoolGsm);
        return response()->json([
          'message' => 'OK',
          'data' => $dataSekolah,
          'user' => $user,
        ]);
    }

    public function updateFCMToken($token)
    {
        $userData = Auth::user();
        $userData->push('fcm_token', $token, true);

        return $userData;
    }

    public function deleteFCMToken($token)
    {
        $userData = Auth::user();
        $userData->pull('fcm_token', $token);

        return $userData;
    }

    public function addKupon(Request $request)
    {
        $kodeKupon = $request->input('kode_kupon');
        $dataKupon = Kupon::where('kode_kupon', $kodeKupon)->first();

        if ($dataKupon) {
            $dataUser = Auth::user()->push('kupon', $dataKupon->nama_training, true);

            return response()->json([
        'message' => 'Kupon berhasil ditambahkan',
        'data' => $dataKupon->nama_training,
            ], 201);
        } else {
            return response()->json([
      'message' => 'Kupon berhasil ditambahkan',
      'data' => $dataKupon->nama_training,
          ], 201);
        }
    }

    public function deleteKupon(Request $request)
    {
        $kodeKupon = $request->input('kupon');
        $dataUser = Auth::user()->pull('kupon', $kodeKupon);

        return response()->json([
      'message' => 'Kupon berhasil dihapus',
      'data' => Auth::user(),
    ], 404);
    }

    public function listKuponUser(Request $request)
    {
      $data =Auth::user()->kupon;
      return response()->json([
        'message' => 'Kupon per user',
        'data' => $data,
      ], 200);
    }

    public function homeUser()
    {
      $quizIkut = Quiz::with('modul')->where('user_id', auth()->user()->id)->whereIn('flag', ['enrolled','answered'])->take(5)->get();
      $quizSelesai = Quiz::with('modul')->where('user_id', auth()->user()->id)->where('flag', 'scored')->take(5)->get();
      $modulTerbaru = Modul::orderBy('created_at', 'desc')->take(5)->get();

      return response()->json([
        'message' => 'success',
        'quizIkut' => $quizIkut,
        'quizSelesai' => $quizSelesai,
        'modulTerbaru' => $modulTerbaru
      ], 200);
    }

    public function requestSekolah()
    {
      $data = User::find(auth()->user()->id);
      if (!isset($data->requestSekolah)) {
        $data->requestSekolah = 'false';
      }
      if ($data->requestSekolah == 'true') {
        return response()->json([
          'message' => 'Permohonan anda sedang diproses.'
        ], 202);
      } else if ($data->detail['position'] == 'Kepala Sekolah') {
        $data->requestSekolah = 'true';
        $data->save();
        return response()->json([
          'message' => 'Permohohan anda telah terkirim.'
        ], 200);
      } else {
        return response()->json([
          'message' => 'Permintaan menjadi Sekolah Model GSM hanya bisa dilakukan oleh Kepala Sekolah yang terverifikasi.'
        ], 403);
      }
    }
}
