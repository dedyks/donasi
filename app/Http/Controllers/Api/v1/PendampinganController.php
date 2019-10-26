<?php

namespace App\Http\Controllers\Api\v1;

use App\Users;
use App\NotificationLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PendampinganController extends Controller
{
    public function index()
    {
        // All threads, ignore deleted/archived participants
        $threads = Thread::getAllLatest()->with('users')->get();
        // All threads that user is participating in
        // $data = Thread::forUser('5cff10db0224ac337d010f75')->latest('updated_at')->get();
        // $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();
        // All threads that user is participating in, with new messages
        //$threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();
        return response()->json([
          'message' => 'success!',
          'data' => $threads,
        ], 200);
    }

    public function message($id)
    {
        $participants = Participant::with('user:name,role')->where('thread_id', $id)->orderBy('created_at', 'asc')->get();

        $message = Message::with('user:name,role')->where('thread_id', $id)->orderBy('created_at', 'asc')->get();
        $participant = Participant::firstOrCreate([
            'thread_id' => $id,
            'user_id' => Auth::id(),
        ]);
        $participant->last_read = new Carbon();
        $participant->save();

        return $message;
    }

    public function messagePaginate($id)
    {
        $participants = Participant::with('user:name,role')->where('thread_id', $id)->orderBy('created_at', 'asc')->get();

        $message = Message::with('user:name,role')->where('thread_id', $id)->orderBy('created_at', 'desc')->paginate(15);
        $participant = Participant::firstOrCreate([
            'thread_id' => $id,
            'user_id' => Auth::id(),
        ]);
        $participant->last_read = new Carbon();
        $participant->save();

        return $message;
    }

    public function thread2UsersUnread(Request $request)
    {
        $user1_id = Auth::id();
        $user_id_lawan = $request->input('user_id_lawan');
        $threads = Thread::whereHas('participants', function ($query) use ($user1_id) {
            $query->where('user_id', $user1_id);
        })->whereHas('participants', function ($query) use ($user_id_lawan) {
            $query->where('user_id', $user_id_lawan);
        })->first();

        $message = Message::with('user:name,role')->where('thread_id', $threads->id)->orderBy('created_at', 'asc')->get();

        return response()->json([
        'message' => 'OK',
        'thread' => $threads,
        'message' => $message,
      ], 200);
    }

    public function thread2Users(Request $request)
    {
        $user1_id = Auth::id();
        $user_id_lawan = $request->input('user_id_lawan');
        $threads = Thread::whereHas('participants', function ($query) use ($user1_id) {
            $query->where('user_id', $user1_id);
        })->whereHas('participants', function ($query) use ($user_id_lawan) {
            $query->where('user_id', $user_id_lawan);
        })->first();

        $message = $this->message($threads->id);

        return response()->json([
        'message' => 'OK',
        'thread' => $threads,
        'message' => $message,
      ], 200);
    }

    public function test()
    {
        $threads = Thread::getAllLatest()->get();

        return response()->json([
          'message' => 'OK',
          'data' => $threads,
        ], 200);
    }

    public function show($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
            'message' => 'ID thread '.$id.'tidak ada',
          ], 200);
        }
        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();
        // don't show the current user in list
        $userId = Auth::id();
        //$users = Users::whereNotIn('_id', $thread->participantsUserIds($userId))->get();
        $thread->markAsRead($userId);

        return response()->json([
          'message' => 'OK',
          'thread' => $thread,
        ], 200);
    }

    public function update($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
            'message' => 'ID thread tidak ada',
          ], 200);
        }
        $thread->activateAllParticipants();
        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => Input::get('message'),
        ]);
        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);
        $participant->last_read = new Carbon();
        $participant->save();

        $user_lawan = Participant::where('thread_id', $thread->id)->where('user_id', '!=', Auth::id())->first();
        $user_lawan_data = Users::find($user_lawan->user_id);
        $arrayFCMToken = $user_lawan_data->fcm_token;
        $inpMessage = Input::get('message');

        $data = $this->sendNotification($user_lawan_data->id, $inpMessage, $arrayFCMToken);
        // $userData = Users::where('_id', $user_lawan->user_id)->select('fcm_token')->first();
        // $arrayFCMToken = $userData->fcm_token;
        // try {
        //     //code...
        //     $this->sendNotification(Auth::user(), Input::get('message'), $arrayFCMToken);
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }

        // $participant = Participant::with('user:name,role')->where('thread_id',$id)->orderBy('created_at', 'asc')->get();
        // $message = Message::with('user:name,role')->where('thread_id',$id)->orderBy('created_at', 'asc')->get();

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant(Input::get('recipients'));
        }

        return $this->message($id);
    }

    public function countUnread($id)
    {
        $participant = Participant::where('thread_id', $id)
      ->where('user_id', Auth::id())
      ->first();

        $last_read = $participant->last_read->toDateTimeString();
        $data = Message::where('thread_id', $id)
      ->where('created_at', '>', new Carbon($last_read))
      ->get();
        // $this->updated_at->gt($participant->last_read;

        return response()->json([
        'message' => 'ini adalah jumlah pesan yang belum dibaca',
        'data' => $data->count(),
        'pesan_baru' => $data,
      ], 200);
    }

    public function countUnreadAssessor()
    {
        $murids = Users::where('assessor_id', Auth::id())
      ->pluck('_id')
      ->toArray();

        foreach ($murids as $murid) {
            // code...
            $assessor_id = Auth::id();
            $threads = Thread::whereHas('participants', function ($query) use ($assessor_id) {
                $query->where('user_id', $assessor_id);
            })->whereHas('participants', function ($query) use ($murid) {
                $query->where('user_id', $murid);
            })->first();
            $threads_id[] = $threads->id;
            // $message = $this->message($threads->id);
        }
        foreach ($threads_id as $thread_id) {
            // code...
            $participant = Participant::where('thread_id', $thread_id)
    ->where('user_id', Auth::id())
    ->first();
            try {
                //code...

                $last_read = $participant->last_read->toDateTimeString();
                $data = Message::where('thread_id', $thread_id)
  ->where('created_at', '>', new Carbon($last_read))
  ->get();
            } catch (\Throwable $th) {
                //throw $th;
                $participant->last_read = new Carbon();
            }
            $last_read = $participant->last_read->toDateTimeString();
            $data = Message::where('thread_id', $thread_id)
    ->where('created_at', '>', new Carbon($last_read))
    ->get();
            $messages[] = $data->count();
        }

        return response()->json([
        'message' => 'ini adalah jumlah pesan yang belum dibaca',
        // 'data' => $data->count(),
        'pesan_baru' => $messages,
      ], 200);
    }

    public function countUnreadAssessorAndroid()
    {
        // $participant = Participant::where('thread_id', $id)
        // ->where('user_id', Auth::id())
        // ->first();

        //   $last_read = $participant->last_read->toDateTimeString();
        //   $data = Message::where('thread_id', $id)
        // ->where('created_at', '>', new Carbon($last_read))
        // ->get();

        // return response()->json([
        //   'message' => 'ini adalah jumlah pesan yang belum dibaca',
        //   'data' => $data->count(),
        //   'pesan_baru' => $data,
        // ], 200);

        $murids = Users::where('assessor_id', Auth::id())
      ->pluck('_id')
      ->toArray();

        foreach ($murids as $murid) {
            // code...
            $assessor_id = Auth::id();
            $threads = Thread::whereHas('participants', function ($query) use ($assessor_id) {
                $query->where('user_id', $assessor_id);
            })->whereHas('participants', function ($query) use ($murid) {
                $query->where('user_id', $murid);
            })->first();
            $threads_id[] = $threads->id;
            // $message = $this->message($threads->id);
        }
        foreach ($threads_id as $thread_id) {
            // code...
            $participant = Participant::where('thread_id', $thread_id)
    ->where('user_id', Auth::id())
    ->first();
            try {
                //code...

                $last_read = $participant->last_read->toDateTimeString();
                $data = Message::where('thread_id', $thread_id)
  ->where('created_at', '>', new Carbon($last_read))
  ->get();
            } catch (\Throwable $th) {
                //throw $th;
                $participant->last_read = new Carbon();
            }
            $last_read = $participant->last_read->toDateTimeString();
            $data = Message::where('thread_id', $thread_id)
    ->where('created_at', '>', new Carbon($last_read))
    ->get();
            $messages[] = $data;
        }

        return response()->json([
        'message' => 'ini adalah jumlah pesan yang belum dibaca',
        // 'data' => $data->count(),
        'pesan_baru' => $messages,
      ], 200);
    }

    public function store()
    {
        $input = Input::all();
        $thread = Thread::create([
              'subject' => $input['subject'],
          ]);
        // Message
        $message = Message::create([
              'thread_id' => $thread->id,
              'user_id' => Auth::id(),
              'body' => $input['message'],
          ]);
        // Sender
        $participant = Participant::create([
              'thread_id' => $thread->id,
              'user_id' => Auth::id(),
              'last_read' => new Carbon(),
          ]);
        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant($input['recipients']);
        }

        return response()->json([
            'message' => 'success!',
            'thread' => $thread,
            'messages' => $message,
            'particapants' => $participant,
          ], 200);
    }

    public function showGroupChat()
    {
        $user = Auth::user();
        $thread = Thread::where('school_id', $user->schoolgsm_id)->first();

        // $thread = $threads->filter(function(Thread $thread) {
        //     return $thread->participants->count() == 2;
        // })->first();
        // return $threads;
        $message = $this->message($thread->id);

        return response()->json([
      'message' => 'OK',
      'thread' => $thread,
      'message' => $message,
    ], 200);
    }

    public function sendNotification($user_id, $message, $fcm_token)
    {
        $redirectURL = ''.env('APP_BASEURL').'assessor/pendampingan/pagependampingan';
        $dataSender = Auth::user();
        $content = ''.$dataSender->name.' memberikan pesan baru';
        $endpoint = 'https://fcm.googleapis.com/fcm/send';
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('POST', $endpoint, [
            'timeout' => 300,
            'headers' => [
              'Content-Type' => 'application/json',
              'Authorization' => 'key='.env('FCM_SERVER_KEY').'',
            ],
            'json' => [
              'notification' => [
                'title' => $content,
                'body' => ''.$message.'',
                'icon' => 'https://cdn3.iconfinder.com/data/icons/cosmo-color-basic-1/40/favorite-512.png',
                'click_action' => $redirectURL,
              ],
              'registration_ids' => $fcm_token,
              ],
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        NotificationLog::create([
        'user_id' => $user_id,
        'user_data' => [
          'name' => $dataSender->name,
          'photo_profile' => $dataSender->photo_profile,
        ],
        'message' => $content,
        'body' => $message,
        'type' => 'message',
        'category' => null,
        'read' => false,
      ]);

        // $response = $client->request('POST', $endpoint, [
        // 'timeout' => 300,
        // 'headers' => [
        //   'Content-Type' => 'application/json',
        //   'Authorization' => 'key='.env('FCM_SERVER_KEY').'',
        // ],
        // 'json' => [
        //   'notification' => [
        //     'title' => $content,
        //     'body' => ''.$message.'',
        //     'icon' => 'https://cdn3.iconfinder.com/data/icons/cosmo-color-basic-1/40/favorite-512.png',
        //     'click_action' => $redirectURL,
        //   ],
        //   'registration_ids' => $fcm_token,
        //   ],
        // ]);
        // $dataUser = Auth()->user();
        // NotificationLog::create([
        //   'user_id' => Auth::id(),
        //   'user_data' => [
        //     'name' => $dataUser->name,
        //     'photo_profile' => $dataUser->photo_profile,
        //     'sekolah' => $dataUser->sekolah,
        //   ],
        //   'title' => $content,
        //   'body' => $message,
        //   'artikel_data' => [
        //   ],
        //   'type' => 'pendampingan',
        //   'category' => null,
        //   'read' => false,
        // ]);
    }
}
