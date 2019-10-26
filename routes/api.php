<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => 'auth'], function () {
});

Route::middleware('auth:api')->group(function () {
    Route::post('v1/refresh-token', 'Api\v1\PassportController@refreshToken');
    Route::get('v1/logout', 'Api\v1\PassportController@logout');
    //comment
    Route::post('v1/comment/store', 'Api\v1\CommentController@store');
    Route::post('v1/comment/reply', 'Api\v1\CommentController@replyStore');
    Route::post('v1/comment/delete', 'Api\v1\CommentController@delete');

    //pendampingan
    Route::post('v1/pendampingan', 'Api\v1\PendampinganController@store');

    //quiz di modul
    Route::post('v1/modul/quiz', 'Api\v1\ModulsController@balasQuiz');

    //profile
    Route::get('v1/user/{id}', 'Api\v1\UsersController@profile');

    Route::post('v1/user/{id}', 'Api\v1\UsersController@updateProfile');
    //fcm
    Route::post('v1/login/fcm', 'Api\v1\PassportController@FCMAfterLogin');

    //user
    Route::get('v1/users/self', 'Api\v1\UsersController@selfProfile');
    Route::get('v1/users/quiz', 'Api\v1\UsersController@listQuiz');
    Route::post('v1/users/photo-profile', 'Api\v1\UsersController@uploadPhotoProfile');
    Route::get('v1/users/activity', 'Api\v1\UsersController@userActivity');
    Route::post('v1/users/choose/assessor/{id}', 'Api\v1\UsersController@chooseAssessor');
    Route::get('v1/users/choose/assessor', 'Api\v1\UsersController@listAssessor');
    Route::post('v1/users/request/assessor', 'Api\v1\UsersController@requestAssessor');
    Route::post('v1/users/{id}/request-assessor', 'Api\v1\UsersController@sendRequestAssessor');

    Route::post('v1/users/request/sekolah', 'Api\v1\UsersController@requestSekolah');

    Route::get('v1/users/article/liked', 'Api\v1\ArticleController@getLiked');
    Route::post('v1/users/article/liked/{id}', 'Api\v1\ArticleController@likeArticle');
    Route::post('v1/users/article/unliked/{id}', 'Api\v1\ArticleController@unlikeArticle');

    Route::get('v1/users/article/favorite', 'Api\v1\ArticleController@getFavorite');
    Route::post('v1/users/article/favorite/{id}', 'Api\v1\ArticleController@favoriteArticle');

    //users kupon
    Route::post('v1/users/kupon/add', 'Api\v1\UsersController@addKupon');
    Route::get('v1/users/kupon/list', 'Api\v1\UsersController@listKuponUser');

    Route::post('v1/users/kupon/delete', 'Api\v1\UsersController@deleteKupon');

    //Pendampingan resources
    Route::get('v1/pendampingan/test', 'Api\v1\PendampinganController@test');
    Route::get('v1/pendampingan/lobby', 'Api\v1\PendampinganController@showGroupChat');

    Route::get('v1/pendampingan', 'Api\v1\PendampinganController@index');
    Route::get('v1/pendampingan/create', 'Api\v1\PendampinganController@create');
    Route::get('v1/pendampingan/show/{id}', 'Api\v1\PendampinganController@show');
    Route::put('v1/pendampingan/update/{id}', 'Api\v1\PendampinganController@update');
    Route::post('v1/pendampingan/thread2users', 'Api\v1\PendampinganController@thread2Users');
    Route::post('v1/pendampingan/thread2users/unread', 'Api\v1\PendampinganController@thread2UsersUnread');

    Route::get('v1/pendampingan/count/{id}', 'Api\v1\PendampinganController@countUnread');
    Route::get('v1/pendampingan/message/{id}', 'Api\v1\PendampinganController@message');
    Route::get('v1/pendampingan/message/{id}/paginate', 'Api\v1\PendampinganController@messagePaginate');

    Route::get('v1/pendampingan/countAssessor', 'Api\v1\PendampinganController@countUnreadAssessor');
    Route::get('v1/pendampingan/countAssessorAndroid', 'Api\v1\PendampinganController@countUnreadAssessorAndroid');

    //modul resources
    Route::get('v1/modul/{id}', 'Api\v1\ModulController@modulById');

    Route::post('v1/article/store', 'Api\v1\ArticleController@store');
    Route::post('v1/article/update/{id}', 'Api\v1\ArticleController@update');

    Route::post('v1/article/createlink/{id}', 'Api\v1\ArticleController@createLinkEdit');
    Route::post('v1/article/deletelink/{id}', 'Api\v1\ArticleController@deleteLinkEdit');
    Route::post('v1/berbagi/{id}', 'Api\v1\ArticleController@editPostLinkEdit');
    Route::delete('v1/article/delete', 'Api\v1\ArticleController@delete');
    Route::get('v1/article/search', 'Api\v1\ArticleController@search');

    //notification resources
    Route::post('v1/notification/token', 'Api\v1\NotificationController@updateToken');
    Route::get('v1/notification', 'Api\v1\NotificationController@get');
    Route::post('v1/notification/read-all', 'Api\v1\NotificationController@readAll');
    Route::post('v1/notification/read/{id}', 'Api\v1\NotificationController@readNotif');
    Route::post('v1/notification/unread/{id}', 'Api\v1\NotificationController@unreadNotif');
    Route::get('v1/notification/update/fcm-token/{token}', 'Api\v1\UsersController@updateFCMToken');
    Route::get('v1/notification/delete/fcm-token/{token}', 'Api\v1\UsersController@deleteFCMToken');

    Route::get('v1/notification/test/{token}', 'Api\v1\NotificationController@test');

    Route::get('/v1/users/home', 'Api\v1\UsersController@homeUser');

    //modul sesuai tingkat pendidikan sekolah user

    Route::get('v1/modul/aspect-grade/{aspect}/{grade}', 'Api\v1\ModulController@modulByAspectGrade');
    Route::get('v1/modul-spesial', 'Api\v1\ModulController@modulSpesial');
});

//untuk versioning, nantinya endpoint akan seperti ini {{url}}/api/v1/login
Route::group(['prefix' => 'v1'], function () {
    //kupon

    //filter artikel

    //Auth routes
    Route::get('use-reg-coupon/{coupon_code}', 'Api\v1\RegCouponController@useRegCoupon');
    Route::post('login', 'Api\v1\PassportController@login');
    Route::post('register', 'Api\v1\PassportController@register');
    Route::post('testregister', 'Api\v1\PassportController@emailRegister');
    Route::get('sekolah/crawl/{npsn}', 'Api\v1\SchoolGsmController@crawl');

    Route::get('wilayahKabGet', 'Api\v1\SchoolGsmController@dataMasterKemendikbud');
    Route::get('rekapSekolahGET', 'Api\v1\SchoolGsmController@dataJumlahSekolahPerWilayahKemendikbud');
    Route::get('detailSekolahGET', 'Api\v1\SchoolGsmController@dataDetailSekolahKemendikbud');

    //pendampingan

    //Sekolah resources
    Route::get('/school-gsm/user-trend', 'Api\v1\UsersController@userRegisteredChart');
    Route::get('/school-gsm', 'Api\v1\SchoolGsmController@get');
    Route::get('/school-gsm/model-daerah', 'Api\v1\SchoolGsmController@getModelDaerah');
    Route::get('/school-gsm/terdaftar-daerah', 'Api\v1\SchoolGsmController@getTerdaftarDaerah');

    Route::post('/school-gsm/per-daerah', 'Api\v1\SchoolGsmController@sekolahPerDaerah');
    Route::get('/school-gsm/map', 'Api\v1\SchoolGsmController@dataGraphMap');
    Route::get('/school-gsm/top', 'Api\v1\SchoolGsmController@topSekolahperDaerah');
    Route::post('/school-gsm/list/model-gsm', 'Api\v1\SchoolGsmController@listSekolahModelGsm');
    Route::post('/school-gsm/list/terdaftar', 'Api\v1\SchoolGsmController@listSekolahTerdaftar');

    Route::get('/sekolah/{id}', 'Api\v1\SchoolGsmController@sekolahById');
    Route::get('/sekolah/label/{label}', 'Api\v1\SchoolGsmController@sekolahByLabel');

    //User resources
    Route::get('/users', 'Api\v1\UsersController@all');
    Route::get('/users/{id}', 'Api\v1\UsersController@get');
    Route::post('/users/choose/assessor', 'Api\v1\UsersController@get');
    Route::post('/userstest', 'Api\v1\UsersController@RegisterTestBerhasil');
    Route::post('/daftar', 'Api\v1\UsersController@RegisterTest');

    //quiz
    Route::post('/quiz/test', 'Api\v1\QuizController@test');

    //Modul resources
    Route::get('modul', 'Api\v1\ModulController@index');
    Route::get('modul/aspect/{aspect}', 'Api\v1\ModulController@modulByAspect');

    Route::get('modul/grade/{grade}', 'Api\v1\ModulController@modulByGrade');

    Route::get('/modul/quiz/assessor', 'Api\v1\ModulsController@getAllQuiz');

    //jawab tantanngan
    Route::post('modul/tantangan/jawab', 'Api\v1\ModulsController@jawabTantangan');
    Route::get('modul/tantangan/{id}', 'Api\v1\QuizController@getTantangan');

    //Quiz resources
    Route::post('users/modul/enroll', 'Api\v1\QuizController@enrollModul');
    Route::delete('users/modul/leave', 'Api\v1\QuizController@leaveModul');
    Route::get('quiz/test', 'Api\v1\QuizController@all');

    //users resources
    Route::post('/users/modul', 'Api\v1\UsersController@modulDiambil');

    //article resources
    //article resources
    Route::get('/article', 'Api\v1\ArticleController@get');
    Route::get('/article/filter/by', 'Api\v1\ArticleController@getFilter');

    Route::get('/article/{id}', 'Api\v1\ArticleController@getByID');

    Route::get('/article/test', 'Api\v1\ArticleController@test');
    Route::get('/users/test', 'Api\v1\UsersController@test');
    Route::get('/article/likes/{id}', 'Api\v1\ArticleController@getLikerName');
    Route::get('/article/by-user/{user_id}', 'Api\v1\ArticleController@byUser');
    Route::get('/article/kupon/list', 'Api\v1\ArticleController@getListKupon');

    Route::get('/article/filter/propinsi', 'Api\v1\SchoolGsmController@getListPropinsi');
    Route::get('/article/filter/kabupaten', 'Api\v1\SchoolGsmController@getListKabupaten');

    //Reset password routes
    Route::group(['prefix' => 'password'], function () {
        Route::post('create', 'Api\v1\PasswordResetController@create');
        Route::get('find/{token}', 'Api\v1\PasswordResetController@find');
        Route::post('reset', 'Api\v1\PasswordResetController@reset');
    });
    //Elearning password routes
    Route::get('elearning/analytic', 'Api\v1\SchoolGsmController@analytic');

    //Pendampingan resources

    //Assessor scopes
    Route::post('/assessor/login', 'Api\v1\PassportController@assessorLogin');

    //Admin scopes
    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', 'Api\v1\PassportController@adminLogin');
        Route::middleware(['auth:api', 'scope:admin'])->group(function () {
            Route::post('modul/create', 'Api\v1\ModulController@create');
            Route::get('modul/{id}', 'Api\v1\ModulController@modulByIdDashboard');
            Route::post('modul/{id}', 'Api\v1\ModulController@update');
            Route::delete('modul/{id}', 'Api\v1\ModulController@deleteModul');
            Route::delete('modul/{id}/{filename}', 'Api\v1\ModulController@deleteImage');
            Route::get('quiz/index', 'Api\v1\AdminController@userQuizIndex');
            Route::post('user/role/{id}', 'Api\v1\AdminController@changeRole');
            Route::post('sekolah/store', 'Api\v1\SchoolGsmController@store');
            Route::post('sekolah/label/{id}', 'Api\v1\SchoolGsmController@changeSchoolLabel');
            Route::delete('sekolah/delete/{id}', 'Api\v1\SchoolGsmController@deleteSchool');
            Route::get('sekolah/request-list', 'Api\v1\AdminController@listRequestSekolah');
            Route::post('sekolah/confirm/{id}', 'Api\v1\AdminController@confirmRequestSekolah');
            Route::get('assessor/request-list', 'Api\v1\AdminController@listRequestAssessor');
            Route::post('assessor/confirm/{id}', 'Api\v1\AdminController@confirmRequestAssessor');
            Route::get('rapor', 'Api\v1\RaporController@index');
            Route::get('rapor/by-sekolah/{id}', 'Api\v1\RaporController@raporBySekolahId');
            Route::post('rapor/kerangka', 'Api\v1\RaporController@createKerangka');
            Route::get('rapor/kerangka/index', 'Api\v1\RaporController@kerangkaIndex');
            Route::post('rapor/kerangka/{id}', 'Api\v1\RaporController@updateKerangka');
            Route::get('rapor/sekolah/{id}', 'Api\v1\RaporController@raporSekolahBySekolahId');
            Route::get('rapor/sekolah/id/{id}', 'Api\v1\RaporController@raporSekolahById');
            Route::post('rapor/sekolah', 'Api\v1\RaporController@createRaporSekolah');
            Route::post('rapor/sekolah/id/{id}', 'Api\v1\RaporController@updateRaporSekolah');
            //perkuponan
            Route::post('kupon/create', 'Api\v1\AdminController@createKupon');
            Route::post('kupon/{id}', 'Api\v1\AdminController@updateKupon');
            Route::post('kupon/delete/{id}', 'Api\v1\AdminController@deleteKupon');
            Route::get('kupon', 'Api\v1\AdminController@listKupon');
            //register coupon
            Route::get('reg-coupon', 'Api\v1\RegCouponController@index');
            Route::post('reg-coupon', 'Api\v1\RegCouponController@create');
            Route::post('reg-coupon/{id}', 'Api\v1\RegCouponController@update');
            Route::delete('reg-coupon/{id}', 'Api\v1\RegCouponController@delete');
        });
        Route::middleware(['auth:api', 'scope:assessor'])->group(function () {
            Route::get('user', 'Api\v1\AdminController@index');
            Route::get('user/{id}', 'Api\v1\AdminController@userById');
            Route::get('user/role/{role}', 'Api\v1\AdminController@userByRole');
            Route::get('quiz', 'Api\v1\AdminController@userQuizIndexByAssessorId');
            Route::get('quiz/assessor/all', 'Api\v1\AdminController@userQuizIndexByAssessorIdAll');
            Route::get('quiz/{id}', 'Api\v1\AdminController@userQuizById');
            Route::post('quiz/{id}', 'Api\v1\AdminController@userQuizFeedback');
            Route::get('quiz/user/{id}', 'Api\v1\AdminController@userQuizByUserId');
            Route::post('user/level/{id}', 'Api\v1\AdminController@changeUserLevel');
            Route::post('rapor', 'Api\v1\RaporController@createRapor');
            Route::post('rapor/{id}', 'Api\v1\RaporController@updateRapor');
            Route::post('rapor-image', 'Api\v1\RaporController@createRaporWithImage');
            Route::post('rapor-image/{id}', 'Api\v1\RaporController@updateRaporWithImage');
            Route::delete('rapor-image/{id}/{filename}', 'Api\v1\RaporController@deleteImage');
            Route::get('rapor/id/{id}', 'Api\v1\RaporController@raporById');
            Route::get('rapor/user/{id}', 'Api\v1\RaporController@raporByUser');
            Route::get('rapor/assessor/{id}', 'Api\v1\RaporController@raporByAssessor');
            Route::get('rapor/kerangka', 'Api\v1\RaporController@kerangka');
            Route::get('assessor/user-list/{id}', 'Api\v1\UsersController@listUserByAssessor');
            Route::delete('rapor/id/{id}', 'Api\v1\RaporController@deleteRapor');
        });
    });
});

Route::group(['prefix' => 'api/v2'], function () {
    //reserved
});
