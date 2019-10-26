<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use App\SchoolGsm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Validator;

class SchoolGsmController extends Controller
{
    protected $statusCodes = [
      'done' => 200,
      'created' => 201,
      'removed' => 204,
      'not_valid' => 400,
      'not_found' => 404,
      'conflict' => 409,
      'permissions' => 401,
    ];

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'npsn' => 'required',
      ]);

        if ($validator->fails()) {
            return response()->json([
          $validator->errors(),
        ], 417);
        }

        $npsn = $request->input('npsn');
        $school = SchoolGsm::where('npsn', $npsn);
        $schoolHitung = $school->count();
        $this->validate($request, [
            'npsn' => 'required|unique:schoolGsm',
          ]);

        $longitude = floatval($request->input('bujur'));
        $latitude = floatval($request->input('lintang'));

        $school = new SchoolGsm();
        $school->propinsi = $request->input('propinsi');
        $school->npsn = $request->input('npsn');
        $school->kode_kab_kota = $request->input('kode_kab_kota');
        $school->kabupaten_kota = $request->input('kabupaten_kota');
        $school->kode_kec = $request->input('kode_kec');
        $school->kecamatan = $request->input('kecamatan');
        $school->sekolah = $request->input('sekolah');
        $school->kecamatan = $request->input('kecamatan');
        $school->alamat_jalan = $request->input('alamat_jalan');
        $school->status = $request->input('status');
        $school->bentuk = $request->input('bentuk');
        $school->lokasi = [$longitude, $latitude];
        $school->model_gsm = [
          'updated_date' => null,
          'flag' => 'jejaring_gsm',
        ];

        $school->save();

        return response()->json([
            'message' => 'Success',
            'data' => $school,
          ], 201);
    }

    public function get()
    {
        $data = SchoolGsm::all();
        $school = SchoolGsm::with('user')->get();
        $user = SchoolGsm::first();

        return response()->json([
            'message' => 'success!',
            'school' => $school,
          ], 200);
    }

    public function getModelDaerah()
    {
        $school = SchoolGsm::where('model_gsm.flag', 'model_gsm')->groupBy('kabupaten_kota')->get();

        return response()->json([
            'message' => 'success!',
            'data' => $school,
          ], 200);
    }

    public function getTerdaftarDaerah()
    {
        $school = SchoolGsm::where('model_gsm.flag', 'jejaring_gsm')->groupBy('kabupaten_kota')->get();

        return response()->json([
            'message' => 'success!',
            'data' => $school,
          ], 200);
    }

    public function sekolahPerDaerah(Request $request)
    {
        $school = SchoolGsm::where('kecamatan', $request->input('kecamatan'))->get();

        return response()->json([
            'message' => 'success!',
            'data' => $school,
          ], 200);
    }

    public function deleteSchool($id)
    {
        $sekolah = SchoolGsm::find($id);
        if ($sekolah) {
            $sekolah->delete();

            return response()->json([
            'message' => 'Delete success',
          ], 200);
        } else {
            return response()->json([
            'message' => 'Sekolah not found',
          ], 404);
        }
    }

    public function dataGraphMap()
    {
        $sekolahGsm = SchoolGsm::where('model_gsm.flag', 'model_gsm')->select('sekolah', 'lokasi', 'propinsi', 'kabupaten_kota', 'kecamatan', 'alamat_jalan')->get()->map(function ($item) {
            $item->longitude = $item->lokasi[0];
            $item->latitude = $item->lokasi[1];

            return $item;
        });

        $sekolahNotGsm = SchoolGsm::where('model_gsm.flag', 'jejaring_gsm')->select('sekolah', 'lokasi', 'propinsi', 'kabupaten_kota', 'kecamatan', 'alamat_jalan')->get()->map(function ($item) {
            $item->longitude = $item->lokasi[0];
            $item->latitude = $item->lokasi[1];

            return $item;
        });

        return response()->json([
        'SekolahModelGsm' => $sekolahGsm,
        'SekolahTerdaftar' => $sekolahNotGsm,
      ], 200);
    }

    public function topSekolahperDaerah()
    {
        $sekolah = SchoolGsm::raw(function ($collection) {
            return $collection->aggregate([
            [
                '$group' => [
                    '_id' => ['kabupaten_sekolah' => '$kabupaten_kota'],
                    'count' => ['$sum' => 1],
                ],
            ],
            [
              '$sort' => ['count' => -1],
          ],
            [
              '$limit' => 10,
          ],
        ]);
        });

        return response()->json([
            'message' => 'success!',
            'data' => $sekolah,
          ], 200);
    }

    public function analytic()
    {
        $sekolahGsm = SchoolGsm::where('model_gsm.flag', 'model_gsm')->count();
        $sekolahTerdaftar = SchoolGsm::count();
        $jumlahUser = User::where('role', 'user')->count();
        $jumlahassessor = User::where('role', 'assessor')->count();

        return response()->json([
        'message' => 'success!',
        'sekolahGsm' => $sekolahGsm,
        'sekolahTerdaftar' => $sekolahTerdaftar,
        'jumlahUser' => $jumlahUser,
        'jumlahassessor' => $jumlahassessor,
      ], 200);
    }

    public function listSekolahModelGsm(Request $request)
    {
        $data = SchoolGsm::where('kabupaten_kota', $request->input('kabupaten_kota'))
      ->where('model_gsm.flag', 'model_gsm')
      ->orderBy('sekolah', 'ASC')->get();

        return response()->json([
        'message' => 'success!',
        'data' => $data,
      ], 200);
    }

    public function listSekolahTerdaftar(Request $request)
    {
        $data = SchoolGsm::where('kabupaten_kota', $request->input('kabupaten_kota'))
      ->where('model_gsm.flag', 'jejaring_gsm')
      ->orderBy('sekolah', 'ASC')->get();

        return response()->json([
        'message' => 'success!',
        'data' => $data,
      ], 200);
    }

    public function sekolahById($id)
    {
        $data = SchoolGsm::find($id);
        $data->user = User::where('schoolgsm_id', $id)->get();

        if ($data) {
            return response()->json([
          'message' => 'Success',
          'data' => $data,
        ], 200);
        } else {
            return response()->json([
          'message' => 'Not found',
        ], 417);
        }
    }

    public function sekolahByLabel($label)
    {
        $request = new Request([
        'label' => $label,
      ]);

        $input = $request->all();
        $validator = Validator::make($input, [
        'label' => [
          'required',
          Rule::in([
            'model_gsm',
            'emodel_gsm',
            'jejaring_gsm',
          ]),
        ],
      ]);

        if ($validator->fails()) {
            return response()->json([
          'message' => $validator->errors(),
        ], 417);
        }

        $data = SchoolGsm::where('model_gsm.flag', $label)->get();

        return response()->json([
        'message' => 'Success',
        'data' => $data,
      ], 200);
    }

    public function changeSchoolLabel(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'label' => [
          'required',
          Rule::in([
            'model_gsm',
            'emodel_gsm',
            'jejaring_gsm',
          ]),
        ],
      ]);

        if ($validator->fails()) {
            return response()->json([
          $validator->errors(),
        ], 417);
        }

        $data = SchoolGsm::find($id);

        if ($data) {
            $data->model_gsm = [
          'updated_date' => Carbon::now()->toDateTimeString(),
          'flag' => $request->label,
        ];
            $data->save();

            return response()->json([
          'message' => 'Success',
        ], 200);
        } else {
            return response()->json([
          'message' => 'School not found.',
        ], 417);
        }
    }

    public function getListPropinsi()
    {
        $data = SchoolGsm::distinct()->select('propinsi')->get();

        return response()->json([
        'message' => 'Success.',
        'data' => $data,
      ], 200);
    }

    public function getListKabupaten(Request $request)
    {
        if ($request->has('propinsi')) {
            $data = SchoolGsm::distinct()->where('propinsi', $request->input('propinsi'))->select('kabupaten_kota')->get();

            return response()->json([
        'message' => 'Success.',
        'data' => $data,
      ], 200);
        } else {
            $data = SchoolGsm::distinct()->select('kabupaten_kota')->get();

            return response()->json([
        'message' => 'Success.',
        'data' => $data,
      ], 200);
        }
    }

    public function crawl($npsn)
    {
        $client = new \GuzzleHttp\Client();
        $domDoc = new \DOMDocument();

        $url = 'http://referensi.data.kemdikbud.go.id/tabs.php?npsn='.$npsn;

        $res = $client->request('GET', $url);

        $html = (string) $res->getBody();

        // The @ in front of $domDoc will suppress any warnings
        libxml_use_internal_errors(true);
        $domHtml = $domDoc->loadHTML($html);

        $xpath = new \DOMXPath($domDoc);

        if (stripos($html, 'Silahkan koordinasi dengan dinas setempat') !== false) {
            return response()->json([
          'message' => 'NPSN tidak terdaftar!',
        ], 404);
        } elseif (stripos($html, 'L.Marker') !== false) {
            $locationString = stripos($html, 'L.Marker');
            // return
            $fullstring = substr($html, $locationString, 40);
            $lintang = $this->get_string_between($fullstring, '[', ',');
            $bujur = $this->get_string_between($fullstring, ',', ']');
            //discard white space
            $domDoc->preserveWhiteSpace = false;

            //the table by its tag name
            $tables = $domDoc->getElementsByTagName('table');
            $result['sekolah'] = $tables->item(2)->getElementsByTagName('tr')->item(0)->getElementsByTagName('td')->item(3)->nodeValue;

            $result['npsn'] = $tables->item(2)->getElementsByTagName('tr')->item(1)->getElementsByTagName('td')->item(3)->nodeValue;

            $result['alamat_jalan'] = $tables->item(2)->getElementsByTagName('tr')->item(2)->getElementsByTagName('td')->item(3)->nodeValue;
            $result['kecamatan'] = $tables->item(2)->getElementsByTagName('tr')->item(6)->getElementsByTagName('td')->item(3)->nodeValue;

            $result['kabupaten_kota'] = $tables->item(2)->getElementsByTagName('tr')->item(7)->getElementsByTagName('td')->item(3)->nodeValue;
            $result['propinsi'] = $tables->item(2)->getElementsByTagName('tr')->item(8)->getElementsByTagName('td')->item(3)->nodeValue;
            $result['status'] = $tables->item(2)->getElementsByTagName('tr')->item(9)->getElementsByTagName('td')->item(3)->nodeValue;

            $result['bentuk'] = $tables->item(2)->getElementsByTagName('tr')->item(13)->getElementsByTagName('td')->item(3)->nodeValue;
            if ($result['status'] = 'SWASTA') {
                $result['status'] = 'S';
            }
            if ($result['status'] = 'NEGERI') {
                $result['status'] = 'N';
            }

            $result['lintang'] = $lintang;
            $result['bujur'] = $bujur;

            return $result;
        }
    }

    public function get_string_between($string, $start, $end)
    {
        $string = ' '.$string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }

    public function dataMasterKemendikbud()
    {
        $endpoint = 'http://jendela.data.kemdikbud.go.id/api/index.php/cwilayah/wilayahKabGet';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET',$endpoint, [
          'timeout' => 300,
        ]);
      //   $response = $client->request('GET', $endpoint, [
      // 'timeout' => 300,
      // 'decode_content' => 'gzip'
      //  ]);
        #$parse = $response->getBody();

        return $response->getBody();
    }

    public function dataJumlahSekolahPerWilayahKemendikbud(Request $request)
    {
        $endpoint = 'http://jendela.data.kemdikbud.go.id/api/index.php/Csekolah/rekapSekolahGET';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $endpoint, ['query' => [
        'mst_kode_wilayah' => $request->input('mst_kode_wilayah'),
        'bentuk' => $request->input('bentuk'),
      ],
        'timeout' => 300,
    ]);

        return  $response->getBody();
    }

    public function dataDetailSekolahKemendikbud(Request $request)
    {
        $endpoint = 'http://jendela.data.kemdikbud.go.id/api/index.php/Csekolah/detailSekolahGET';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $endpoint, ['query' => [
        'mst_kode_wilayah' => $request->input('mst_kode_wilayah'),
        'bentuk' => $request->input('bentuk'),
    ],
    'timeout' => 300, ]);

        return  $response->getBody();
    }
}
