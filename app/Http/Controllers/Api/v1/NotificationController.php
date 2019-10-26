<?php

namespace App\Http\Controllers\Api\v1;

use App\User;

use App\NotificationLog;
use App\Users;
use Illuminate\Support\Facades\Auth;
use Validator;
use Image;
use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function get(){
    $data = NotificationLog::where('user_id',Auth::id())->orderBy('created_at', 'desc')->simplePaginate(5);
    $unread = NotificationLog::where('user_id',Auth::id())->where('read',false)->count();
    return response()->json([
      'message' => 'success!',
      'unread_count' => $unread,
      'data' => $data,
    ], 200);

  }

  public function readAll(){
    $data = NotificationLog::where('user_id',Auth::id())->update(['read' => true]);
    return response()->json([
      'message' => 'success!',
      'data' => $data,
    ], 200);
  }

  public function readNotif($id)
  {
    $data = NotificationLog::where('_id',$id)->update(['read'=>true]);
    return response()->json([
      'message' => 'success!',
      'data' => $data,
    ], 200);
  }

  public function unreadNotif($id)
  {
    $data = NotificationLog::where('_id',$id)->update(['read'=>false]);
    return response()->json([
      'message' => 'success!',
      'data' => $data,
    ], 200);
  }

  public function test($fcm)
  {
    $redirectURL = ''.env('APP_BASEURL').'detailkonten?id=';
    $namaLiker = Auth::user()->name;
    $content = 'Test menyukai artikel anda';
    $endpoint = 'https://fcm.googleapis.com/fcm/send';
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', $endpoint,[
    'timeout' => 300,
    'headers' => [
      'Content-Type'     => 'application/json',
      'Authorization'      => 'key='.env('FCM_SERVER_KEY').''
  
    ],    
    'json' => [
      'notification' => [
        'title'=> 'test',
        'body'=> 'body test',
        'icon'=> 'https://cdn3.iconfinder.com/data/icons/cosmo-color-basic-1/40/favorite-512.png',
        'click_action'=> $redirectURL 
      ],
      'to' => $fcm
      ]
    ]);
  }
}
