<?php namespace App\Http\Controllers\Api\v1;
use DB;
use App\Users;
use App\Modul;
use App\Quiz;
use Validator;
use Image;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Hash;
class ModulsController extends Controller
{
    const MODEL = "App\Modul";
    const QUIZ = "App\Quiz";

    public $path;
    public $dimensions;
    public $pathdir;
    use RESTActions;

    public function __construct()
    {
        $this->path = 'public/images';
        $this->pathdir = storage_path('app/' . $this->path);
        $this->dimensions = ['245', '300', '500'];
    }

   
    public function storeBasic(Request $request)
    {
        $m = self::MODEL;
        $data = new Modul;
        $data = $request->all();
        $data['categories'] = 'BASIC';
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        //JIKA FOLDERNYA BELUM ADA
        if (!File::isDirectory($this->path)) {
            //MAKA FOLDER TERSEBUT AKAN DIBUAT
            File::makeDirectory($this->path);
        }

        //MENGAMBIL FILE IMAGE DARI FORM
        $file = $request->file('image');

        //MEMBUAT NAME FILE DARI GABUNGAN TIMESTAMP DAN UNIQID()
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //UPLOAD ORIGINAN FILE (BELUM DIUBAH DIMENSINYA)
        Image::make($file)->save($this->path . '/' . $fileName);

        //LOOPING ARRAY DIMENSI YANG DI-INGINKAN
        //YANG TELAH DIDEFINISIKAN PADA CONSTRUCTOR
        foreach ($this->dimensions as $row) {
            //MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY
            $canvas = Image::canvas($row, $row);
            //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY
            //DENGAN MEMPERTAHANKAN RATIO
            $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                $constraint->aspectRatio();
            });

            //CEK JIKA FOLDERNYA BELUM ADA
            if (!File::isDirectory($this->path . '/' . $row)) {
                //MAKA BUAT FOLDER DENGAN NAMA DIMENSI
                File::makeDirectory($this->path . '/' . $row);
            }

            //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
            $canvas->insert($resizeImage, 'center');
            //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
            $canvas->save($this->path . '/' . $row . '/' . $fileName);
        }


        $data['categories'] = 'BASIC';
        $data['imageName'] = $fileName;
        $data['imageDimension'] = implode('|', $this->dimensions);
        $data['imagePath'] = $this->path;
        //SIMPAN DATA IMAGE YANG TELAH DI-UPLOAD
        return $this->respond(Response::HTTP_CREATED, $m::create($data));
    }
    public function storeAdvance(Request $request)
    {
        $m = self::MODEL;
        $data = new Modul;
        $data = $request->all();
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        //JIKA FOLDERNYA BELUM ADA
        if (!File::isDirectory($this->path)) {
            //MAKA FOLDER TERSEBUT AKAN DIBUAT
            File::makeDirectory($this->path);
        }

        //MENGAMBIL FILE IMAGE DARI FORM
        $file = $request->file('image');

        //MEMBUAT NAME FILE DARI GABUNGAN TIMESTAMP DAN UNIQID()
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //UPLOAD ORIGINAN FILE (BELUM DIUBAH DIMENSINYA)
        Image::make($file)->save($this->path . '/' . $fileName);

        //LOOPING ARRAY DIMENSI YANG DI-INGINKAN
        //YANG TELAH DIDEFINISIKAN PADA CONSTRUCTOR
        foreach ($this->dimensions as $row) {
            //MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY
            $canvas = Image::canvas($row, $row);
            //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY
            //DENGAN MEMPERTAHANKAN RATIO
            $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                $constraint->aspectRatio();
            });

            //CEK JIKA FOLDERNYA BELUM ADA
            if (!File::isDirectory($this->path . '/' . $row)) {
                //MAKA BUAT FOLDER DENGAN NAMA DIMENSI
                File::makeDirectory($this->path . '/' . $row);
            }

            //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
            $canvas->insert($resizeImage, 'center');
            //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
            $canvas->save($this->path . '/' . $row . '/' . $fileName);
        }


        $data['categories'] = 'ADVANCE';
        $data['imageName'] = $fileName;
        $data['imageDimension'] = implode('|', $this->dimensions);
        $data['imagePath'] = $this->path;
        //SIMPAN DATA IMAGE YANG TELAH DI-UPLOAD
        return $this->respond(Response::HTTP_CREATED, $m::create($data));
    }
    public function getBasic(Request $request)
    {
        $m = self::MODEL;
        return $this->respond(Response::HTTP_OK, $m::where('categories','=','BASIC')->get());

    }
    public function getAdvance(Request $request)
    {
        $m = self::MODEL;
        return $this->respond(Response::HTTP_OK, $m::where('categories','=','ADVANCE')->get());

    }
    public function edit(Request $request, $id)
    {
        $m = self::MODEL;
        $this->validate($request, $m::$rules);
        $model = $m::find($id);
        if(is_null($model)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        //JIKA FOLDERNYA BELUM ADA
        if (!File::isDirectory($this->path)) {
            //MAKA FOLDER TERSEBUT AKAN DIBUAT
            File::makeDirectory($this->path);
        }

        //MENGAMBIL FILE IMAGE DARI FORM
        $file = $request->file('image');

        //MEMBUAT NAME FILE DARI GABUNGAN TIMESTAMP DAN UNIQID()
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //UPLOAD ORIGINAN FILE (BELUM DIUBAH DIMENSINYA)
        Image::make($file)->save($this->path . '/' . $fileName);

        //LOOPING ARRAY DIMENSI YANG DI-INGINKAN
        //YANG TELAH DIDEFINISIKAN PADA CONSTRUCTOR
        foreach ($this->dimensions as $row) {
            //MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY
            $canvas = Image::canvas($row, $row);
            //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY
            //DENGAN MEMPERTAHANKAN RATIO
            $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                $constraint->aspectRatio();
            });

            //CEK JIKA FOLDERNYA BELUM ADA
            if (!File::isDirectory($this->path . '/' . $row)) {
                //MAKA BUAT FOLDER DENGAN NAMA DIMENSI
                File::makeDirectory($this->path . '/' . $row);
            }

            //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
            $canvas->insert($resizeImage, 'center');
            //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
            $canvas->save($this->path . '/' . $row . '/' . $fileName);
        }

        $data['imageName'] = $fileName;
        $data['imageDimension'] = implode('|', $this->dimensions);
        $data['imagePath'] = $this->path;
        $model->update($request->all());
        return $this->respond(Response::HTTP_OK, $model);
    }
    public function balasQuiz(Request $request)
    {
        $m = self::QUIZ;
        $data = new Quiz;
        $data = $request->all();
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);
		
        //JIKA FOLDERNYA BELUM ADA
        if (!File::isDirectory($this->path)) {
            //MAKA FOLDER TERSEBUT AKAN DIBUAT
            File::makeDirectory($this->path);
        }
		
        //MENGAMBIL FILE IMAGE DARI FORM
        $file = $request->file('image');
        
        //MEMBUAT NAME FILE DARI GABUNGAN TIMESTAMP DAN UNIQID()
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //UPLOAD ORIGINAN FILE (BELUM DIUBAH DIMENSINYA)
        Image::make($file)->save($this->path . '/' . $fileName);
		
        //LOOPING ARRAY DIMENSI YANG DI-INGINKAN
        //YANG TELAH DIDEFINISIKAN PADA CONSTRUCTOR
        foreach ($this->dimensions as $row) {
            //MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY 
            $canvas = Image::canvas($row, $row);
            //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY 
            //DENGAN MEMPERTAHANKAN RATIO
            $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                $constraint->aspectRatio();
            });
			
            //CEK JIKA FOLDERNYA BELUM ADA
            if (!File::isDirectory($this->path . '/' . $row)) {
                //MAKA BUAT FOLDER DENGAN NAMA DIMENSI
                File::makeDirectory($this->path . '/' . $row);
            }
        	
            //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
            $canvas->insert($resizeImage, 'center');
            //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
            $canvas->save($this->path . '/' . $row . '/' . $fileName);
        }
        
        $data['modul_id'] = $request->input('modul_id');
        $data['user_id'] = Auth::id();
        $data['imageName'] = $fileName;
        $data['imageDimension'] = implode('|', $this->dimensions);
        $data['imagePath'] = $this->path;

        //SIMPAN DATA IMAGE YANG TELAH DI-UPLOAD
        return $this->respond(Response::HTTP_CREATED, $m::create($data));

    }

    public function getAllQuiz(){
        $data =  Quiz::with('modul','user')->get();
    
        return response()->json([
            'message' => 'success!',
            'data' => $data
          ], 200);
    }

    public function getAllUserTakeQuiz(Request $request){
        $data =  Quiz::with('modul','user')->get();
    
        return response()->json([
            'message' => 'success!',
            'data' => $data
          ], 200);
    }

    public function jawabTantangan(Request $request)
    {
        $user_id = $request->input('user_id');
        $modul_id = $request->input('modul_id');
        $dataTantangan = Quiz::where('user_id',$user_id)
        ->where('modul_id',$modul_id)
        ->first();

        

        $dataTantangan->flag = "answered";
        $dataTantangan->deskripsi = $request->input('deskripsi');
        $dataTantangan->image = [];
        $dataTantangan->save();
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
              $res = $this->createImage($image);
              $images[] = $res;
            }
            $dataTantangan->push('image', $images);
          }

        return response()->json([
            'message' => 'success!',
            'data' => $dataTantangan
          ], 201);
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


}
