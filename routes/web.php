<?php
use App\Http\Controllers\Controller;
use App\Articles\ArticlesRepository;
use App\Models\Article;
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




// Route::get('/dashboard', function () {             //simple fetch
//     return view('dashboard', [
//         'articles' => App\Models\Article::all(),
//     ]);
// })->middleware(['auth'])->name('dashboard'); 


// Route::get('/Dash', function (ArticlesRepository $repository) {           //simple search
//     return view('Dash', [
//         'articles' => request()->has('q')
//             ? $repository->search(request('q'))
//             : App\Models\Article::all(),
//     ]);
// }); 