<?php

namespace App\Http\Controllers\Api\v1;

use App\Modul;
use App\Quiz;
use App\SchoolGsm;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Image;
use Validator;

class ModulController extends Controller
{
    //
    public $dimensions;
    public $path;
    public $pathdir;
    public $grupSD;
    public $grupSMP;
    public $grupSMA;

    public function __construct()
    {
        $this->path = 'public/images';
        $this->pathdir = storage_path('app/' . $this->path);
        $this->dimensions = ['245', '300', '500'];
        $this->grupSD = ['SD', 'MI'];
        $this->grupSMP = ['SMP', 'MTS'];
        $this->grupSMA = ['SMA', 'MA', 'SMK'];
    }

    public function index()
    {
      $moduls = Modul::select('_id', 'aspect', 'grade', 'level', 'title')->get();

      return $moduls;
    }

    public function modulById($id)
    {
      $user_id = Auth::id();
      $modul = Modul::find($id);
      $tantangan =  Quiz::where('modul_id',$id)->where('user_id',$user_id)->first();

      return response()->json([
        'modul' => $modul,
        'tantangan' => $tantangan
      ], 200);

    }

    public function modulByIdDashboard($id)
    {
      $modul = Modul::find($id);

      if ($modul) {
        return $modul;
      } else {
        return response()->json([
          'message' => 'not found'
        ], 404);
      }
    }

    public function modulByAspect($aspect)
    {
      $request = new Request([
        'aspect' => $aspect
      ]);
      $input = $request->all();
      $validator = Validator::make($input, [
        'aspect' => [
          'required',
          Rule::in([
            'ekosistem-positif',
            'pembelajaran-riset',
            'pengembangan-karakter',
            'trisentra-pendidikan'
          ]),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $moduls = Modul::where('aspect', '=', $request->aspect)->select('_id', 'aspect', 'grade', 'title', 'description')->get();

      return $moduls;
    }


    public function modulByAspectGrade($aspect, $grade)
    {
      $request = new Request([
        'aspect' => $aspect,
        'grade' => $grade
      ]);
      $input = $request->all();
      $validator = Validator::make($input, [
        'aspect' => [
          'required',
          Rule::in([
            'ekosistem-positif',
            'pembelajaran-riset',
            'pengembangan-karakter',
            'trisentra-pendidikan'
          ]),
        ],
        'grade' => [
          'required',
          Rule::in([
            'basic',
            'advanced',
            'spesial'
          ]),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $school = SchoolGsm::find(auth()->user()->schoolgsm_id);

      if (in_array($school->bentuk, $this->grupSD)){
        $school->bentuk = 'SD';
      } elseif (in_array($school->bentuk, $this->grupSMP)) {
        $school->bentuk = 'SMP';
      } elseif (in_array($school->bentuk, $this->grupSMA)) {
        $school->bentuk = 'SMA';
      }

      $moduls = Modul::where('aspect', '=', $request->aspect)->where('grade', '=', $request->grade)->where('level', $school->bentuk)->select('_id', 'aspect', 'grade', 'title', 'description')->get();

      return $moduls;
    }


    public function modulByGrade($grade)
    {
      $request = new Request([
        'grade' => $grade
      ]);
      $input = $request->all();
      $validator = Validator::make($input, [
        'grade' => [
          'required',
          Rule::in([
            'basic',
            'advanced',
            'spesial'
          ]),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $moduls = Modul::where('grade', '=', $request->grade)->select('_id', 'aspect', 'grade', 'title', 'description')->get();

      return $moduls;
    }

    public function create(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'aspect' => 'required',
        'grade' => 'required',
        'level' => 'nullable',
        'title' => 'required',
        'description' => 'nullable',
        'notes' => 'nullable',
        'task' => 'nullable',
        'image.*' => 'nullable|max:2000|mimes:jpg,jpeg,png',
        'video' => 'nullable',
        'document' => 'nullable'
      ]);

      if ($validator->fails()) {
        return response()->json([
          'message' => $validator->errors()
        ], 417);
      }

      if (!File::isDirectory($this->pathdir)) {
          File::makeDirectory($this->pathdir, 0777, true);
      }

      $images = [];
      $videos = [];
      $documents = [];

      if ($request->hasFile('image')) {
        foreach ($request->file('image') as $image) {
          $res = $this->createImage($image);
          $images[] = $res;
        }
      }

      if ($request->has('video')) {
        foreach ($request->video as $video) {
          $videos[] = [
            'url' => $video
          ];
        }
      }

      if ($request->has('document')) {
        foreach ($request->document as $document) {
          $documents[] = [
            'url' => $document
          ];
        }
      }

      Modul::create([
        'aspect' => $request->aspect,
        'grade' => $request->grade,
        'level' => $request->level,
        'title' => $request->title,
        'description' => $request->description,
        'notes' => $request->notes,
        'task' => $request->task,
        'video' => $videos,
        'document' => $documents,
        'image' => $images
      ]);

      return response()->json([
        'message' => 'Create success!'
      ], 200);
    }

    public function update(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'aspect' => 'required',
        'grade' => 'required',
        'level' => 'required',
        'title' => 'required',
        'description' => 'nullable',
        'notes' => 'nullable',
        'task' => 'nullable',
        'image.*' => 'nullable|max:2000|mimes:jpg,jpeg,png',
        'video' => 'nullable',
        'document' => 'nullable'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $modul = new Modul;
      $modul = Modul::find($id);

      if ($request->has('video')) {
        foreach ($request->video as $video) {
          $videos[] = [
            'url' => $video
          ];
        }
      }

      if ($request->has('document')) {
        foreach ($request->document as $document) {
          $documents[] = [
            'url' => $document
          ];
        }
      }

      $modul->aspect = $request->aspect;
      $modul->grade = $request->grade;
      $modul->level = $request->level;
      $modul->title = $request->title;
      $modul->description = $request->description;
      $modul->notes = $request->notes;
      $modul->video = $videos;
      $modul->document = $documents;
      $modul->task = $request->task;
      $modul->reward = $request->reward;

      $modul->save();

      if ($request->hasFile('image')) {
        foreach ($request->file('image') as $image) {
          $res = $this->createImage($image);
          $images[] = $res;
        }

        $modul->push('image', $images);
      }

      return response()->json([
        'message' => 'Update success',
        'modul' => $modul
      ], 200);
    }

    public function deleteModul($id)
    {
      $modul = Modul::find($id);
      if (!$modul) {
        return response()->json([
          'message' => 'Modul not found'
        ], 404);
      } else {
        foreach ($modul->image as $image) {
          $this->deleteImage($id, $image['filename']);
        }
        $modul->delete();
      }

      return response()->json([
        'message' => 'Delete success'
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
      $modul = Modul::find($id);
      $message = 'Images not deleted.';

      if (!$modul) {
        return response()->json([
          'message' => 'Modul not found',
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

        $modul->pull('image', ['filename' => $filename]);

        $modul = Modul::find($id);

        return response()->json([
          'message' => 'Delete success',
          'notes' => $message,
          'modul' => $modul
        ], 200);
      }
    }

    public function modulSpesial()
    {
      $modul = Modul::where('grade', 'spesial')->select('_id', 'aspect', 'grade', 'title', 'description')->get();
      
      return response()->json([
        'message' => 'success',
        'data' => $modul
      ], 200);
    }
}
