<?php

namespace App\Http\Controllers\Api\v1;
use App\Kampanye;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;


class KampanyeController extends Controller
{
  public $path;
  public $dimensions;
  public $pathdir;
  const MODEL = "App\Kampanye";

  use RESTActions;

  public function __construct()
  {
      $this->path = 'public/images';
      $this->pathdir = storage_path('app/' . $this->path);
      $this->dimensions = ['245', '300', '500'];
  }

    public function create(Request $request)
    {
      $kampanyeData = new Kampanye();
      $requestData = $request->all();

      $validator = Validator::make($requestData,$kampanyeData->rules);
      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }
      
      $requestData['donation_goal']=(int)$requestData['donation_goal'];
      $requestData['donation_collected']=0;
      $requestData['total_donatur']=0;

      return $this->respond('created', Kampanye::create($requestData));
    }

   

     
}
