<?php namespace App\Http\Controllers\Api\v1;
use DB;
use App\Users;
use App\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class QuizController extends Controller
{
    const MODEL = "App\Quiz";

    use RESTActions;


    public function all()
    {

       $users =  Quiz::whereNull('deleted_at')->get();


        return response()->json([
            'message' => 'ok',
            'data' => $users
          ], 200);

    }

    public function getTantangan($id)
    {

       $data =  Quiz::with('modul')->find($id);


        return response()->json([
            'message' => 'ok',
            'data' => $data
          ], 200);

    }




    public function enrollModul(Request $request)
    {
        $modul_id = $request->input('modul_id');
        $user_id = $request->input('user_id');

        $quiz = Quiz::where('modul_id',$modul_id)->where('user_id',$user_id)->first();
        if($quiz===null){
          $data = Quiz::create([
            'modul_id' => $modul_id,
            'user_id' => $user_id,
            'flag' => 'enrolled',
            'penilaian' => '',
            'image' => [],
            'deskripsi' => '',
            'assessor_id' => '',
            'status' => ''
          ]);


          return response()->json([
            'message' => 'Enroll Success!',
            'data' => $data
          ], 201);
        }
        else
        {
          return response()->json([
            'message' => 'User sudah mendaftar Modul yang sama',
          ], 200);
        }

    }
    public function leaveModul(Request $request)
    {
        $modul_id = $request->input('modul_id');
        $user_id = $request->input('user_id');
        $data = Quiz::where([
            'modul_id' => $modul_id,
            'user_id' => $user_id,
            'flag' => 'enrolled'
          ])->delete();

          return response()->json([
            'data' => $data,
            'message' => 'left Modul!'
          ], 204);

    }



    public function test(Request $request)
    {
        $input =$request->user_id;
        $data = Quiz::find($input)->with('user','modul','assessor')->first();
        return response()->json([
            'message' => 'ok',
            'data'  => $data
          ], 200);
    }

}
