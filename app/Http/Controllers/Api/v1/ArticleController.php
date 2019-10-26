<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use App\NotificationLog;
use File;
use App\Users;
use Illuminate\Support\Facades\Auth;
use Validator;
use Image;
use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public $dimensions;
    public $path;
    public $pathdir;

    public function __construct()
    {
        $this->path = 'public/images';
        $this->pathdir = storage_path('app/'.$this->path);
        $this->dimensions = ['245', '300', '500'];
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'caption' => 'nullable',
       
        'content' => 'required',
      ]);

        if ($validator->fails()) {
            return response()->json([
          $validator->errors(),
        ], 417);
        }

        if (!File::isDirectory($this->pathdir)) {
            File::makeDirectory($this->pathdir, 0777, true);
        }
        $userData = Auth::user();
        $userName['author'] = $userData->name;
        $userName['user_id'] = $userData->_id;
        $images = [];
        $videos = [];
        $documents = [];
        $caption[] = $request->input('caption');

        if ($request->file('image')) {
            $x = 0;
            foreach ($request->file('image') as $image) {
                $captionFormated = $caption[0][$x];
                $res = $this->createImageBerbagi($image, $captionFormated, $userName);
                $images[] = $res;
                ++$x;
            }
        }

        if ($request->has('video')) {
            foreach ($request->video as $video) {
                $videos[] = [
              'url' => $video,
            ];
            }
        }

        if ($request->input('kupon') == '') {
            $kupon = 'elearning';
        } else {
            $kupon = $request->input('kupon');
        }
        $result = Article::create([
      'author' => $userData->name,
      'status' => null,
      'type' => null,
      'categories' => null,
      'tags' => null,
      'kupon' => $kupon,
      'guid' => null,
      'page' => null,
      'sticky' => null,
      'format' => null,
      'comment_status' => null,
      'featured_media' => null,
      'title' => $request->title,
      'content' => $request->content,
      'schoolgsm_id' => $userData->schoolgsm_id,
      'share_link' => null,
      'image' => $images,
      'video' => $videos,
      'user_id' => $userData->_id,
      'liked_ids' => [],
      'favorite_ids' => [],
    ]);

        return response()->json([
      'message' => 'Create success!',
      'data' => $result,
    ], 200);
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        $userData = Auth::user();
        $userName['author'] = $userData->name;
        $userName['user_id'] = $userData->_id;
        if ($userData->_id == $article->user_id) {
            $article->title = $request->input('title');
            $article->content = $request->input('content');
            $article->kupon = $request->input('kupon');
            $caption[] = $request->input('caption');
            if ($request->hasFile('image')) {
                $x = 0;
                foreach ($request->file('image') as $image) {
                    $captionFormated = $caption[0][$x];
                    $res = $this->createImageBerbagi($image, $captionFormated, $userName);
                    $images[] = $res;
                    ++$x;
                }
            }

            if ($request->has('video')) {
                foreach ($request->video as $video) {
                    $videos[] = [
            'url' => $video,
          ];
                }
            }
            $article->video = $videos;

            $article->image = $images;

            $article->save();

            return response()->json([
          'message' => 'Create success!',
          'data' => $article,
        ], 200);
        }
    }

    public function deleteImage($id, $filename)
    {
        $modul = Article::find($id);
        $message = 'Images not deleted.';

        if (!$modul) {
            return response()->json([
          'message' => 'article not found',
          'notes' => $message,
        ], 404);
        } else {
            if (File::exists($this->pathdir.'/'.$filename)) {
                File::delete($this->pathdir.'/'.$filename);
                foreach ($this->dimensions as $row) {
                    if (File::exists($this->pathdir.'/'.$row.'/'.$filename)) {
                        File::delete($this->pathdir.'/'.$row.'/'.$filename);
                    }
                }
                $message = 'Images deleted.';
            }

            $modul->pull('image', ['filename' => $filename]);

            return response()->json([
          'message' => 'Delete success',
          'notes' => $message,
        ], 200);
        }
    }

    public function get()
    {
        $data = Article::with('comments', 'liked', 'favorite', 'user', 'schoolgsm')->select('title', 'content', 'author', 'image', 'kupon', 'user_id', 'created_at')->orderBy('created_at', 'desc')->paginate(5);

        return response()->json([
            'message' => 'success!',
            'data' => $data,
          ], 200);
    }

    public function getFilter(Request $request)
    {
        $bentuk = $request->input('bentuk');
        $propinsi = $request->input('propinsi');
        $kabupaten_kota = $request->input('kabupaten_kota');
        $kupon = $request->input('kupon');

        $data = Article::with('comments', 'liked', 'favorite', 'user', 'schoolgsm')
        ->when($bentuk, function ($query, $bentuk) {
            return $query->whereHas('schoolgsm', function ($q) use ($bentuk) {
                return $q->where('bentuk', $bentuk);
            });
        })
        ->when($propinsi, function ($query, $propinsi) {
            return $query->whereHas('schoolgsm', function ($q) use ($propinsi) {
                return $q->where('propinsi', $propinsi);
            });
        })

        ->when($kabupaten_kota, function ($query, $kabupaten_kota) {
            return $query->whereHas('schoolgsm', function ($q) use ($kabupaten_kota) {
                return $q->where('kabupaten_kota', $kabupaten_kota);
            });
        })

        ->when($kupon, function ($query, $kupon) {
            return $query->where('kupon', $kupon);
        })
        ->orderBy('created_at', 'desc')->paginate(5);

        return response()->json([
            'message' => 'success!',
            'data' => $data,
          ], 200);
    }

    public function getListKupon()
    {
        $data = Article::distinct()->select('kupon')->get();

        return response()->json([
        'message' => 'daftar kupon!',
        'data' => $data,
      ], 200);
    }

    public function getByID($id)
    {
        $data = Article::with('comments', 'liked', 'favorite', 'user')->where('_id', $id)->select('title', 'content', 'kupon', 'author', 'image', 'user_id', 'created_at')->orderBy('created_at', 'desc')->first();

        return response()->json([
            'message' => 'success!',
            'data' => $data,
          ], 200);
    }

    public function delete(Request $request)
    {
        $data = Article::find($request->input('article_id'));

        if ($data->user_id === Auth::id()) {
            $data->delete();

            return response()->json([
          'message' => 'Delete success!',
        ], 200);
        } else {
            return response()->json([
        'message' => 'Gagal menghapus, bukan Original Poster',
      ], 401);
        }
    }

    public function byUser($user_id)
    {
        $data = Article::with('comments', 'liked', 'favorite', 'user')->where('user_id', $user_id)->select('title', 'kupon', 'content', 'author', 'image', 'user_id', 'created_at')->orderBy('created_at', 'desc')->paginate(5);

        return response()->json([
        'message' => 'success!',
        'data' => $data,
      ], 200);
    }

    public function test()
    {
        //show article with favortied by and liked
        // $data = Article::with('comments','favorite','liked')->where('_id','5d10da7907371535100038ee')->first();
        // return response()->json([
        //   'message' => 'success!',
        //   'data'  => $data,
        // ], 200);

        // // like an article by ID
        // $article = Article::where('_id','5d10da7907371535100038ee')->first();
        //   $user = Users::where('_id','5d04a51d0224ac09c05b9a04')->first();
        // $article->liked()->save($user);
        // return response()->json([
        //   'message' => 'success!',
        //   'data'  => $article,
        // ], 200);

        // //get favorite of user
        // $article = Article::whereIn('favorite_ids', ['5d04a51d0224ac09c05b9a04'])->get();
        // return response()->json([
        //   'message' => 'success!',
        //   'data'  => $article,
        // ], 200);

        //   //get liked by User
        //   $article = Article::whereIn('liked_ids', ['5d04a51d0224ac09c05b9a04'])->get();
        // return response()->json([
        //   'message' => 'success!',
        //   'data'  => $article,
        // ], 200);

        // dapatin siapa aja yang nge likes suatu article
        $article = Article::whereIn('liked_ids', ['5d04a51d0224ac09c05b9a04'])->first();
        $data = Users::select('name')->findMany($article->liked_ids);

        return response()->json([
        'message' => 'success!',
        'data' => $data,
      ], 200);
    }

    public function getLiked()
    {
        $user_id = Auth::id();
        $article = Article::with('comments', 'liked', 'favorite', 'user')->whereIn('liked_ids', [$user_id])
      ->select('title', 'content', 'author', 'image', 'user_id', 'created_at', 'kupon', 'liked_ids')->paginate(5);

        return response()->json([
        'message' => 'success!',
        'data' => $article,
      ], 200);
    }

    public function likeArticle($id)
    {
        // like an article by ID
        $article = Article::with('user')->where('_id', $id)->first();

        $article->liked()->save(Auth::user());

        $arrayFCMToken = $article->user->fcm_token;

        // $data = $this->sendNotification($article,'dMX32uAma-I:APA91bEHWmFA3OwU0edakX5yo-WKuq9VbmpTaFJ2EfG7n0Zrbtr4zu5iS_NyvcOZ-dKggXymktbFIOsSYfzUTrpsK14VVqXBXhhH4IkCXHtmbHyyEyM6I1Yni832TNBji-fnRkX2Zj_w');
        $data = $this->sendNotification($article, $arrayFCMToken);

        return response()->json([
        'message' => 'success!',
        'data' => $data,
      ], 200);
    }

    public function unlikeArticle($id)
    {
        // like an article by ID
        $article = Article::where('_id', $id)->pull('liked_ids', Auth::id());
        $article = Users::where('_id', Auth::id())->pull('liked_ids', $id);

        return response()->json([
        'message' => 'success unlike article!',
        'data' => $article,
      ], 200);
    }

    public function getFavorite()
    {
        $user_id = Auth::id();
        $article = Article::with('comments', 'liked', 'favorite', 'user')->whereIn('favorite_ids', [$user_id])
      ->select('title', 'content', 'author', 'image', 'user_id', 'kupon', 'created_at', 'liked_ids')->paginate();

        return response()->json([
        'message' => 'success!',
        'data' => $article,
      ], 200);
    }

    public function favoriteArticle($id)
    {
        // like an article by ID
        $article = Article::where('_id', $id)->first();
        $article->favorite()->save(Auth::user());

        return response()->json([
        'message' => 'success!',
        'data' => $article,
      ], 200);
    }

    public function getLikerName($id)
    {
        $article = Article::where('_id', $id)->first();
        $data = Users::select('name')->findMany($article->liked_ids);

        return response()->json([
      'message' => 'success!',
      'data' => $data,
    ], 200);
    }

    public function createLinkEdit($id)
    {
        $exist = Article::where('user_id', Auth::id())->where('_id', $id)->first();
        if ($exist) {
            $exist->share_link = $this->createRandomLink();
            $exist->save();

            return $exist;
        } else {
            return response()->json([
          'message' => 'Bukan Original Poster!',
        ], 401);
        }
    }

    public function deleteLinkEdit($id)
    {
        $exist = Article::where('user_id', Auth::id())->where('_id', $id)->first();
        if ($exist) {
            $exist->share_link = null;
            $exist->save();

            return $exist;
        } else {
            return response()->json([
          'message' => 'Bukan Original Poster!',
        ], 401);
        }
    }

    public function editPostLinkEdit(Request $request, $id)
    {
        $articleData = Article::where('share_link', $id)->first();
        $user['author'] = Auth::user()->name;
        $user['user_id'] = Auth::user()->_id;
        $caption[] = $request->input('caption');

        if ($request->file('image')) {
            $x = 0;
            foreach ($request->file('image') as $image) {
                $captionFormated = $caption[0][$x];
                $res = $this->createImageBerbagi($image, $captionFormated, $user);
                $images[] = $res;
                ++$x;
            }
        }
        $articleData->push('image', $images);

        return $articleData;
    }

    public function createRandomLink()
    {
        $randVariable = (string) mt_rand(10000, 99999);
        if ($this->checkRandomLinkExist($randVariable)) {
            return $this->createRandomLink();
        }

        return $randVariable;
    }

    public function checkRandomLinkExist($random)
    {
        return Article::where('share_link', $random)->first();
    }

    public function createImageBerbagi($image, $caption, $author)
    {
        $filename = Carbon::now()->timestamp.'_'.uniqid().'.'.$image->getClientOriginalExtension();

        foreach ($this->dimensions as $row) {
            $canvas = Image::canvas($row, $row);
            $resizeImage = Image::make($image)->resize($row, $row, function ($constraint) {
                $constraint->aspectRatio();
            });

            if (!File::isDirectory($this->pathdir.'/'.$row)) {
                File::makeDirectory($this->pathdir.'/'.$row, 0777, true);
            }

            $canvas->insert($resizeImage, 'center');
            $canvas->save($this->pathdir.'/'.$row.'/'.$filename);
        }

        $image->storeAs($this->path, $filename);

        $res = [
        'title' => $image->getClientOriginalName(),
        'filename' => $filename,
        'path' => $this->path,
        'caption' => $caption,
        'author' => $author['author'],
        'user_id' => $author['user_id'],
        'dimension' => implode('|', $this->dimensions),
        'created_at' => $now = Carbon::now()->format('Yyyy-mm-dd Hh:mm:ss'),
        'updated_at' => $now,
      ];

        return $res;
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $articleSearched = Article::where('title', 'like', '%'.$keyword.'%')->paginate(5);

        return response()->json([
        'message' => 'success!',
        'data' => $articleSearched,
      ], 200);
    }

    public function sendNotification($article, $fcm_token)
    {
        $redirectURL = ''.env('APP_BASEURL').'detailkonten?id='.$article->_id.'';
        $namaLiker = Auth::user()->name;
        $content = ''.$namaLiker.' menyukai artikel anda';
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
                'body' => ''.$article->title.'',
                'icon' => 'https://cdn3.iconfinder.com/data/icons/cosmo-color-basic-1/40/favorite-512.png',
                'click_action' => $redirectURL,
              ],
              'registration_ids' => $fcm_token,
              ],
            ]);
        } catch (\Throwable $th) {
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
          'article_id' => $article->_id,
          'title' => $article->title,
          'image' => $article->image,
        ],
        'type' => 'like',
        'category' => null,
        'read' => false,
      ]);

        //return $response;
    }
}
