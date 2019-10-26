<?php

namespace App\Http\Controllers\Api\v1;

use App\Rapor;
use App\SchoolGsm;
use App\User;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Image;
use Validator;

class RaporController extends Controller
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
      $rapors = Rapor::with('user', 'assessor')->get();

      return $rapors;
    }

    public function raporById($id)
    {
      $rapor = Rapor::with('user', 'assessor')->get()->find($id);
      if ($rapor){
        return response()->json([
          'data' => $rapor
        ], 200);
      } else {
        return response()->json([
          'message' => 'Rapor not found.'
        ], 404);
      }
    }

    public function raporByUser($id)
    {
      $rapor = Rapor::with('user', 'assessor')->where('user_id', $id)->get();
      if ($rapor){
        return response()->json([
          'data' => $rapor
        ], 200);
      } else {
        return response()->json([
          'message' => 'Rapor by user not found.'
        ], 404);
      }
    }

    public function raporByAssessor($id)
    {
      $rapor = Rapor::with('user', 'assessor')->where('assessor_id', $id)->get();
      if ($rapor){
        return response()->json([
          'data' => $rapor
        ], 200);
      } else {
        return response()->json([
          'message' => 'Rapor by assessor not found.'
        ], 404);
      }
    }

    public function raporBySekolahId($id)
    {
      $rapor = Rapor::with('user', 'assessor')->get(['_id', 'judul', 'user_id', 'assessor_id', 'updated_at', 'created_at'])->where('user.schoolgsm_id', $id);

      if ($rapor){
        $rapor1 = [];
        foreach ($rapor as $raporout){
          $rapor1[] = $raporout;
        }
        return response()->json([
          'message' => 'success',
          'data' => $rapor1
        ], 200);
      } else {
        return response()->json([
          'message' => 'Rapor by schoolgsm_id not found.'
        ], 404);
      }
    }

    public function kerangka()
    {
      $rapor = Rapor::where('tipe', 'kerangka')->orderBy('updated_at', 'desc')->first();

      if ($rapor){
        return response()->json([
          'data' => $rapor
        ], 200);
      } else {
        return response()->json([
          'message' => 'Kerangka not found.'
        ], 404);
      }
    }

    public function kerangkaIndex()
    {
      $rapor = Rapor::where('tipe', 'kerangka')->orderBy('updated_at', 'desc')->get();

      if ($rapor){
        return response()->json([
          'message' => 'success',
          'data' => $rapor
        ], 200);
      } else {
        return response()->json([
          'message' => 'Kerangka not found.'
        ], 404);
      }
    }

    public function createKerangka(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'kerangka' => 'nullable'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      if ($request->has('kerangka')) {
        foreach ($request->kerangka as $point) {
          $kerangka[] = [
            'aspek' => $point['aspek'],
            'poin' => $point['poin']
          ];
        }

        Rapor::create([
          'tipe' => 'kerangka',
          'assessor_id' => auth()->user()->id,
          'kerangka' => $kerangka
        ]);

        return response()->json([
          'message' => 'Create success!'
        ], 200);
      } else {
        return response()->json([
          'message' => 'Input field is null'
        ], 417);
      }
    }

    public function updateKerangka(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'kerangka' => 'nullable'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $rapor = Rapor::find($id);
      $rapor->kerangka = $request->kerangka;
      $rapor->save();

      return response()->json([
        'message' => 'Update success'
      ], 200);
    }

    public function createRapor(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'user_id' => 'required',
        'judul' => 'required',
        'laporan' => 'nullable'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $kerangka = Rapor::where('tipe', 'kerangka')->orderBy('updated_at', 'desc')->first();

      Rapor::create([
        'tipe' => 'rapor',
        'assessor_id' => auth()->user()->id,
        'kerangka' => $kerangka->kerangka,
        'user_id' => $request->user_id,
        'judul' => $request->judul,
        'laporan' => $request->laporan
      ]);

      return response()->json([
        'message' => 'Create success'
      ], 200);
    }

    public function updateRapor(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'laporan' => 'nullable'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $rapor = Rapor::find($id);
      $rapor->laporan = $request->laporan;
      $rapor->save();

      return response()->json([
        'message' => 'Update success'
      ], 200);
    }

    public function createRaporWithImage(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'user_id' => 'required',
        'judul' => 'required',
        'laporan' => 'nullable',
        'image.*' => 'nullable|max:2000|mimes:jpg,jpeg,png'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $kerangka = Rapor::where('tipe', 'kerangka')->orderBy('updated_at', 'desc')->first();

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

      Rapor::create([
        'tipe' => 'rapor',
        'assessor_id' => auth()->user()->id,
        'kerangka' => $kerangka->kerangka,
        'user_id' => $request->user_id,
        'judul' => $request->judul,
        'laporan' => $request->laporan,
        'image' => $images
      ]);

      return response()->json([
        'message' => 'Create success'
      ], 200);
    }

    public function updateRaporWithImage(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'laporan' => 'nullable',
        'image.*' => 'nullable|max:2000|mimes:jpg,jpeg,png'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $rapor = Rapor::find($id);
      $rapor->laporan = $request->laporan;
      $rapor->save();

      if ($request->hasFile('image')) {
        foreach ($request->file('image') as $image) {
          $res = $this->createImage($image);
          $images[] = $res;
        }

        $rapor->push('image', $images);
      }

      return response()->json([
        'message' => 'Update success'
      ], 200);
    }

    public function deleteRapor($id)
    {
      $rapor = Rapor::find($id);
      if ($rapor) {
        if ($rapor->assessor_id == auth()->user()->id) {
          $rapor->delete();
          return response()->json([
            'message' => 'Success, selected rapor deleted.'
          ], 200);
        } else {
          return response()->json([
            'message' => 'You are not allowed.'
          ]);
        }
      } else {
        return response()->json([
          'message' => 'Rapor not found'
        ], 404);
      }
    }

    public function raporSekolahBySekolahId($id)
    {
      $raporSekolah = Rapor::with('assessor')->where('tipe', 'raporSekolah')->where('user_id', $id)->orderBy('updated_at', 'desc')->get(['_id', 'judul', 'assessor_id', 'updated_at', 'created_at']);

      if ($raporSekolah){
        return response()->json([
          'message' => 'success',
          'data' => $raporSekolah
        ], 200);
      } else {
        return response()->json([
          'message' => 'Rapor not found.'
        ], 404);
      }
    }

    public function raporSekolahById($id)
    {
      $raporSekolah = Rapor::find($id);
      $sekolah = SchoolGsm::find($raporSekolah->user_id);
      $raporSekolah->user = $sekolah;

      if ($raporSekolah){
        return response()->json([
          'message' => 'success',
          'data' => $raporSekolah
        ], 200);
      } else {
        return response()->json([
          'message' => 'Rapor not found.'
        ], 404);
      }
    }

    public function createRaporSekolah(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'user_id' => 'required',
        'judul' => 'required',
        'laporan' => 'nullable',
        'image.*' => 'nullable|max:2000|mimes:jpg,jpeg,png'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $kerangka = Rapor::where('tipe', 'kerangka')->orderBy('updated_at', 'desc')->first();

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

      Rapor::create([
        'tipe' => 'raporSekolah',
        'assessor_id' => auth()->user()->id,
        'kerangka' => $kerangka->kerangka,
        'user_id' => $request->user_id,
        'judul' => $request->judul,
        'laporan' => $request->laporan,
        'image' => $images
      ]);

      return response()->json([
        'message' => 'Create success'
      ], 200);
    }

    public function updateRaporSekolah(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'laporan' => 'nullable',
        'image.*' => 'nullable|max:2000|mimes:jpg,jpeg,png'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $rapor = Rapor::find($id);
      $rapor->laporan = $request->laporan;
      $rapor->save();

      if ($request->hasFile('image')) {
        foreach ($request->file('image') as $image) {
          $res = $this->createImage($image);
          $images[] = $res;
        }

        $rapor->push('image', $images);
      }

      return response()->json([
        'message' => 'Update success'
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

    public function deleteImage($id, $filename)
    {
      $rapor = Rapor::find($id);
      $message = 'Images not deleted.';

      if (!$rapor) {
        return response()->json([
          'message' => 'Rapor not found',
          'notes' => $message
        ], 404);
      } else {
        if (File::exists($this->pathdir . '/' . $filename)) {
          File::delete($this->pathdir . '/' . $filename);
          foreach ($this->dimensions as $row) {
            if (File::exists($this->pathdir . '/' . $row . '/' . $filename)) {
              File::delete($this->pathdir . '/' . $row . '/' . $filename);
            }
          }
          $message = "Images deleted.";
        }

        $rapor->pull('image', ['filename' => $filename]);

        $rapor = Rapor::find($id);

        return response()->json([
          'message' => 'Delete success',
          'notes' => $message,
          'rapor' => $rapor
        ], 200);
      }
    }
}
