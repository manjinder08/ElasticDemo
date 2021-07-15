<?php
use App\Http\Controllers\MyController;
use App\Articles\ArticlesRepository;
use App\Models\Article;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {      //default
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';

Route::get('search', function (ArticlesRepository $repository) {
    $articles = $repository->search(request('q'));
  

    return view('Dash', [
        'articles' => $articles,
    ]);
});


Route::get('/', function () {
    return view('Dash', [
        'articles' =>  App\Models\Article::all(),
    ]);
});


Route::get('/redis', function () {
    return view('/RedisSearch', [
        'articles' =>  App\Models\Article::all(),
    ]);
});

Route::get('/redissearch', function(MyController $r){
    
    if($a=Redis::get('data')){  
        echo "here..........";

        dd($a);      
        //return json_decode($a);
    }
    
    $a = $r->Searchredis(request('query'));
    
    // dd($a);
 // return $a;
    // Redis::setex('data', 60*24, $a);
    // return json_decode($a);
});