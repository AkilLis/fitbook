<?php

use App\Events\UserOutTraining;
use App\GraphSearch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

	Auth::loginUsingId(2);
	//Auth::loginUsingId(1);

	Route::get('/userout', function() {
		event(new UserOutTraining(User::find(1)));
		return "running";
	});

	Route::get('/test', function () {
		return view('test');
	});

	Route::get('/', function () {
    	return view('index');
	});

	Route::get('/search', function(Request $request) {
		return view('search');
	});

	Route::get('/test/search', function (Request $request) {
		$param = $request->q;

		$results = GraphSearch::where(function ($query) use ($param) {
            $query->where('field1', 'like', '%'.$param.'%')
                  ->orWhere('field2', 'like', '%'.$param.'%')
                  ->orWhere('field3', 'like', '%'.$param.'%');
        })->take(8)->get();

        $results->load('searchable.graph');

        return Response::json([
        	'code' => 0,
        	'result' => $results,
        ]);
	});

	Route::get('/login', function() {
		return view('auth.login');
	});

	Route::get('/chart', function () {
		return view('chart');
	});

	Route::get('/dashboard', function() {

		if(Auth::check()) {
			//$club = Auth::user()->clubAsReception()->first();
			$club = \App\Club::find(1);
			return view('auth.reception.dashboard')->with('club', $club);
		}

	    return view('auth.reception.dashboard');
	});

	Route::get('/create-club', function(Request $request) {
	    return view('create-club');
	});

	Route::get('auth/verify-account', function() {
	    return view('auth.verify-account');
	});

	//Social Login
	Route::get('/login/{provider?}',[
	    'uses' => 'Auth\LoginController@getSocialAuth',
	    'as'   => 'auth.getSocialAuth'
	]);

	Route::get('/login/callback/{provider?}',[
	    'uses' => 'Auth\LoginController@getSocialAuthCallback',
	    'as'   => 'auth.getSocialAuthCallback'
	]);

	Route::post('auth/activate', function(Request $request) {
		if(User::checkUserAvailable($request->username))
			return redirect('/');

		$user = new User();
	    $user->fill($request->all());
		$user->is_active = 'Y';
		$user->save();
		Auth::login($user);
	    return redirect('/');
	});

	Route::resource('/subscriptions', 'SubscriptionController');
	Route::get('users/{username}', 'UserController@index');
	Route::get('users/{username}/edit', 'UserController@edit')->middleware('auth');
	
	Route::post('auth/login', 'Auth\LoginController@login');
	Route::post('/upload', 'FileManagerController@upload');
	Route::resource('/training', 'TrainingController');
	Route::put('/training', 'TrainingController@updateTraining');
	Route::get('/plan/{plan}', 'PlanController@show');
	Route::get('/plan/{plan}/comments', 'PlanController@comments');
	Route::post('/plan/{plan}/reaction', 'PlanController@toggleReaction');
	
	Route::group(['prefix' => '/{club}'], function () {

		Route::get('/', 'ClubController@index');
		Route::get('/edit', 'ClubEditController@edit');
		Route::get('/member', 'ClubController@memberPage');
		Route::get('/plan', 'ClubController@planPage');
		Route::get('/training', 'ClubController@trainingPage');
		Route::get('/service', 'ClubController@servicePage');
		Route::get('/info', 'ClubController@infoPage');	

	});

	

	Route::get('/auth/logout', 'Auth\LoginController@logout');
	
	

	
