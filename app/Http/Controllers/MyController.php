<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;

class MyController extends Controller
{
    public function Searchredis(string $q=''){
        return Article::query()
             
        ->Where('body', 'LIKE', "%{$q}%")
        ->orWhere('title', 'LIKE', "%{$q}%")
        ->orWhere('tags', 'LIKE', "%{$q}%")
         ->get();
    }
}
