<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\NotificationLog;
use App\User;
use App\Article;
use DB;
use MongoDB\BSON\ObjectID;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->body = $request->get('comment_body');
        $comment->name = Auth::user()->name;
        $comment->parent_id = null;
        $comment->user()->associate($request->user());
        $post = Article::with('user','comments')->where('_id', $request->get('article_id'))->first();
        $post->comments()->save($comment);


        $arrayFCMToken =  $post->user->fcm_token;
        $this->sendNotification($post,$comment,$arrayFCMToken);

        return response()->json([
            'message' => 'success!',
            'data' => $comment,
          ], 200);
    }

    public function replyStore(Request $request)
    {

        // $objectID = new ObjectID();
        // $oid = (string)$objectID;
        
        // $reply = Comment::where('_id',$request->input('comment_id'))->first();
        // return $reply;
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->name = Auth::user()->name;
        $reply->parent_id = $request->get('comment_id');
        $post = Article::with('user','comments')->where('_id', $request->get('article_id'))->first();

        $post->comments()->save($reply);

        return response()->json([
          'message' => 'success!',
          'data' => $post,
        ], 200);
    }

    public function delete(Request $request)
    {
        $data = Comment::find($request->input('comment_id'))->deleteWithReplies();

        return response()->json([
          'message' => 'success!',
          'data' => $data,
        ], 200);
    }

    public function sendNotification($article,$comment,$fcm_token): void {
      $redirectURL = ''.env('APP_BASEURL').'detailkonten?id='.$article->_id.'';
      $namaLiker = $comment->name;
      $content = ''.$namaLiker.' mengomentari artikel anda';
      $endpoint = 'https://fcm.googleapis.com/fcm/send';
      $client = new \GuzzleHttp\Client();
      try {
        $response = $client->request('POST', $endpoint,[
          'timeout' => 300,
          'headers' => [
            'Content-Type'     => 'application/json',
            'Authorization'      => 'key='.env('FCM_SERVER_KEY').''
        
          ],    
          'json' => [
            'notification' => [
              'title'=> $content,
              'body'=> ''.$comment->body.'',
              'icon'=> 'http://chittagongit.com/images/comment-icon-png/comment-icon-png-10.jpg',
              'click_action'=> $redirectURL 
            ],
            'registration_ids' => $fcm_token
            ]
          ]);      } catch (\Throwable $th) {
        //throw $th;
      }
      $dataUser = Auth()->user();
      NotificationLog::create([
        'user_id' => $article->user_id,
        'user_data' => [
          'name' => $dataUser->name,
          'photo_profile' => $dataUser->photo_profile,
          'sekolah' => $dataUser->sekolah,
        ],
        'message' => $content,
        'artikel_data' => [
          'article_id' =>$article->_id,
          'title' => $article->title,
          'image' => $article->image
        ],
        'type' => 'comment',
        'category' => null,
        'read' => false,


      ]);
      
        
    }
}
