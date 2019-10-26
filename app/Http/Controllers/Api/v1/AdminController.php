<?php

namespace App\Http\Controllers\Api\v1;

use App\Quiz;
use App\SchoolGsm;
use App\Users;
use App\User;
use App\Kupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Validator;
use Image;
use File;
class AdminController extends Controller
{
    //
    public $dimensions;
    public $path;
    public $pathdir;

    public function __construct()
    {
        $this->path = 'public/images';
        $this->pathdir = storage_path('app/' . $this->path);
        $this->dimensions = ['245', '300', '500'];
    }
    public function index()
    {
      $users = User::with('schoolgsm')->get(['_id', 'name', 'detail.position', 'schoolgsm_id', 'role']);

      return response()->json([
        'message' => 'success',
        'data' => $users
      ], 200);
    }

    public function userById($id)
    {
      $user = User::with('schoolgsm')->get()->find($id);

      return response()->json([
        'data' => $user
      ], 200);
    }

    public function userByRole($role)
    {
      $request = new Request([
        'role' => $role
      ]);
      $input = $request->all();
      $validator = Validator::make($input, [
        'role' => [
          'required',
          Rule::in(['admin', 'assessor', 'user']),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $users = User::with('schoolgsm')->where('role', '=', $request->role)->get();

      return $users;
    }

    public function changeRole(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'role' => [
          'required',
          Rule::in(['admin', 'assessor', 'user']),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $user = User::find($id);
      $user->role = $request->role;
      $user->assessor_kuota_max = 25;
      $user->assessor_kuota_now = User::where('assessor_id', auth()->user()->id)->count();
      $user->save();

      return response()->json([
        'message' => 'Role changed.',
        'email' => $user->email,
        'role' => $user->role
      ], 200);
    }

    public function userQuizIndex()
    {
      $quiz = Quiz::with('user', 'modul')->where('flag', '=', 'answered')->orderBy('created_at', 'desc')->get();

      return response()->json([
        'data' => $quiz
      ], 200);
    }

    public function userQuizIndexByAssessorId()
    {
      $quiz = Quiz::with('user', 'modul')->orderBy('created_at', 'desc')->where('flag', 'answered')->get()->where('user.assessor_id', auth()->user()->id);
      $quiz1 = array();
      if ($quiz){
        foreach ($quiz as $quizout){
          $quiz1[] = $quizout;
        }
        return response()->json([
          'message' => 'success',
          'data' => $quiz1
        ], 200);
      } else {
        return response()->json([
          'data' => '',
          'message' => 'Quiz not found.'
        ], 404);
      }
    }

    public function userQuizIndexByAssessorIdAll()
    {
      $quiz = Quiz::with('user', 'modul')->orderBy('created_at', 'desc')->where('flag', 'answered')->orWhere('flag','scored')->get()->where('user.assessor_id', auth()->user()->id);
      $quiz1 = array();
      if ($quiz){
        foreach ($quiz as $quizout){
          $quiz1[] = $quizout;
        }
        return response()->json([
          'message' => 'success',
          'data' => $quiz1
        ], 200);
      } else {
        return response()->json([
          'data' => '',
          'message' => 'Quiz not found.'
        ], 404);
      }
    }

    public function userQuizByUserId($id)
    {
      $quiz = Quiz::with('user', 'modul')->where('user_id', '=', $id)->orderBy('created_at', 'desc')->get();
      if ($quiz){
        return response()->json([
          'data' => $quiz
        ], 200);
      } else {
        return response()->json([
          'message' => 'Quiz not found.'
        ], 404);
      }
    }

    public function userQuizById($id)
    {
      $quiz = Quiz::with('user', 'modul')->get()->find($id);
      $sekolah_id = $quiz->user;
      $sekolah = SchoolGsm::get(['sekolah'])->find($sekolah_id->schoolgsm_id);
      $quiz->sekolah = $sekolah;

      if ($quiz){
        return response()->json([
          'message' => 'success',
          'data' => $quiz
        ], 200);
      } else {
        return response()->json([
          'message' => 'Quiz not found.'
        ], 404);
      }
    }
    public function userQuizFeedback(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'penilaian' => 'required',
        'status' => [
          'required',
          Rule::in(['revisi', 'lulus']),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $quiz = Quiz::with('user', 'modul')->get()->find($id);
      if ($quiz){
        $quiz->penilaian = $request->penilaian;
        $quiz->status = $request->status;
        $quiz->flag = 'scored';
        $quiz->assessor_id = auth()->user()->id;
        $quiz->save();
        return response()->json([
          'message' => 'Your feedback has been sent.',
          'data' => $quiz
        ], 200);
      } else {
        return response()->json([
          'message' => 'Quiz not found.'
        ], 404);
      }
    }

    public function listRequestAssessor()
    {
      $user = User::with('schoolgsm')->where('request', 'true')->where('role', 'user')->get();
      if ($user){
        return response()->json([
          'message' => 'success',
          'data' => $user
        ], 200);
      } else {
        return response()->json([
          'message' => 'Not found',
          'data' => ''
        ], 417);
      }
    }

    public function confirmRequestAssessor(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'confirmation' => [
          'required',
          Rule::in(['accept', 'decline']),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $user = User::with('schoolgsm')->get()->find($id);
      if ($user){
        if ($request->confirmation == 'accept'){
          $user->role = 'assessor';
          $user->request = 'true';
          $user->assessor_kuota_max = 25;
          $user->assessor_kuota_now = User::where('assessor_id', auth()->user()->id)->count();
          $user->save();

          return response()->json([
            'message' => 'Success, user become assessor.'
          ], 200);
        } else if ($request->confirmation == 'decline'){
          $user->request = 'false';
          $user->save();

          return response()->json([
            'message' => 'Success, user\'s request declined.'
          ], 200);
        }
      } else {
        return response()->json([
          'message' => 'Not found'
        ], 417);
      }
    }

    public function changeUserLevel(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'level' => [
          'required',
          Rule::in(['basic', 'advanced']),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $user = User::with('schoolgsm')->get()->find($id);
      if ($user) {
        $user->level = $request->level;
        $user->save();

        return response()->json([
          'message' => 'Success'
        ], 200);
      } else {
        return response()->json([
          'message' => 'Not found'
        ], 417);
      }
    }

    public function createKupon(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'kode_kupon' => 'required',
        'nama_training' => 'required',
        'deskripsi_kupon' => 'nullable'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'message' => $validator->errors()
        ], 417);
      }

      $kodeKupon = $request->input('kode_kupon');
      $deskripsiKupon = $request->input('deskripsi_kupon');
      $namaTraining = $request->input('nama_training');

      if (Kupon::where('kode_kupon', $kodeKupon)->first())
        return response()->json([
          'message' => 'Kode kupon tidak boleh sama, gunakan kode yang unik.'
        ], 417);

      if (!File::isDirectory($this->pathdir)) {
        File::makeDirectory($this->pathdir, 0777, true);
      }

      $images = [];

      if ($request->hasFile('image')) {
        foreach ($request->file('image') as $image) {
          $res = $this->createImage($image);
          $images[] = $res;
        }
      }

      $data = Kupon::create([
       'kode_kupon' => $kodeKupon,
       'deskripsi_kupon' => $deskripsiKupon,
       'nama_training' => $namaTraining,
       'image' => $images,
      ]);

      return response()->json([
        'message' => 'Kupon terbuat',
        'data' => $data,
      ], 201);
    }

    public function listKupon()
    {
      $data = Kupon::orderBy('created_at', 'desc')->get();

      return response()->json([
        'message' => 'list semua kupon',
        'data' => $data,
      ], 200);
    }

    public function updateKupon(Request $request,$id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'nama_training' => 'required',
        'deskripsi_kupon' => 'nullable'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'message' => $validator->errors()
        ], 417);
      }

      $kupon = Kupon::find($id);
      $kupon->nama_training = $request->input('nama_training');
      $kupon->deskripsi_kupon = $request->input('deskripsi_kupon');
      $kupon->save();
      if ($request->hasFile('image')) {
        foreach ($request->file('image') as $image) {
          $res = $this->createImage($image);
          $images[] = $res;
        }

        $kupon->push('image', $images);
      }
      return response()->json([
        'message' => 'Kupon berhasil diperbarui.'
      ], 200);
    }

    public function deleteKupon($id)
    {
      $kupon = Kupon::find($id)->delete();
      return response()->json([
        'message' => 'kupon deleted',
        'data' => $kupon,
      ], 200);
    }

    public function createImage($image)
    {
      $filename = Carbon::now()->timestamp . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

      foreach ($this->dimensions as $row) {
        $canvas = Image::canvas($row, $row);
        $resizeImage = Image::make($image)->resize($row, $row, function($constraint) {
          $constraint->aspectRatio();
        });

        if (!File::isDirectory($this->pathdir . '/' . $row)) {
            File::makeDirectory($this->pathdir . '/' . $row, 0777, true);
        }

        $canvas->insert($resizeImage, 'center');
        $canvas->save($this->pathdir . '/' . $row . '/' . $filename);
      }

      $image->storeAs($this->path, $filename);

      $res = [
        'title' => $image->getClientOriginalName(),
        'filename' => $filename,
        'path' => $this->path,
        'dimension' => implode('|', $this->dimensions),
        'created_at' => $now = Carbon::now()->format('Yyyy-mm-dd Hh:mm:ss'),
        'updated_at' => $now
      ];

      return $res;
    }

    public function listRequestSekolah()
    {
      $user = User::with('schoolgsm')->where('requestSekolah', 'true')->get(['_id', 'name', 'schoolgsm_id', 'requestSekolah']);
      return response()->json([
        'message' => 'Success',
        'data' => $user
      ], 200);
    }

    public function confirmRequestSekolah(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'confirmation' => [
          'required',
          Rule::in(['accept', 'decline']),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $user = User::with('schoolgsm')->get()->find($id);
      if ($user){
        if ($request->confirmation == 'accept'){
          $user->requestSekolah = 'false';
          $sekolah = SchoolGsm::find($user->schoolgsm['_id']);
          $sekolah->model_gsm = [
            'updated_date' => Carbon::now()->toDateTimeString(),
            'flag' => 'model_gsm'
          ];
          $user->save();
          $sekolah->save();

          return response()->json([
            'message' => 'Success, school become Sekolah Model GSM.'
          ], 200);
        } else if ($request->confirmation == 'decline'){
          $user->requestSekolah = 'false';
          $user->save();

          return response()->json([
            'message' => 'Success, school\'s request declined.'
          ], 200);
        }
      } else {
        return response()->json([
          'message' => 'Not found'
        ], 417);
      }
    }
}
