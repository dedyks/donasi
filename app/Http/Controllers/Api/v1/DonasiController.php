<?php

namespace App\Http\Controllers\Api\v1;
use App\Donasi;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;


class DonasiController extends Controller
{
  public $path;
  public $dimensions;
  public $pathdir;
  const MODEL = "App\Donasi";

  use RESTActions;

    public function create(Request $request)
    {
      $donasiData = new Donasi();
      $requestData = $request->all();

      $validator = Validator::make($requestData,$donasiData->rules);
      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }
      $requestData['donation_amount']=(int)$requestData['donation_amount'];
      $requestData['status']='PENDING';

      return $this->respond('created', Donasi::create($requestData));
    }

    public function get($id)
    {
      $model = Donasi::with('kampanye','user')->where('_id',$id)->first();
      if(is_null($model)){
        return $this->respond('not_found');
      }
      return $this->respond('done', $model);  
    }
     
    public function bayarDonasi($id)
    {
      $model = Donasi::find($id);
      if(is_null($model)){
        return $this->respond('not_found');
      }
      $model->status='PAID';

     $model->kampanye()->increment('donation_collected',$model->donation_amount);
     $model->kampanye()->increment('total_donatur');

      return $this->respond('done', $model);
    }

    public function sendEmailBerhasilDonasi()
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
}
