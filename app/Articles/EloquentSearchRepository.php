<?php
 namespace App\Articles;
 use App\Models\Article;
 use Illuminate\Database\Eloquent\Collection;

 class EloquentSearchRepository implements ArticlesRepository
 {
     public function search(string $query=''): Collection
     {
        return Article::query()
             
            ->Where('body', 'LIKE', "%{$query}%")
            ->orWhere('title', 'LIKE', "%{$query}%")
            ->orWhere('tags', 'LIKE', "%{$query}%")
             ->get();

     }
 } 