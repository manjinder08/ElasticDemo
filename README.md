<h3>ElasticSearch With Laravel 8</h3>
<table style="width:100%">
  <tr>
    <th>Technologies</th>
    <th>Versions</th> 
  </tr>
  <tr>
    <td>Laravel</td>
    <td>8.40</td>
  </tr>
  <tr>
    <td>ElasticSearch</td>
    <td>7.13</td>
   </tr>
  <tr>
    <td>Php</td>
    <td>^7.3|^8.0</td>
   </tr>
      <tr>
    <td>Rredis</td>
    <td>^1.1</td>
   </tr>
</table>

<h3>Installing ElasticSearch in laravel</h3>
<h4>Step 1</h4>
Install ElasticSearch on system.</br>
<b>link-> </b> https://www.elastic.co/guide/en/elasticsearch/reference/current/install-elasticsearch.html
<h4>Step 2</h4>
Make laravel project.</br>
<b>Command-> </b> composer require-project laravel/laravel ElasticDemo
<h4>Step 3</h4>
Install ElasticSearch in project.</br>
<b>Command-> </b> composer require elasticsearch/elasticsearch.
<h4>Step 4</h4>
Make model and factory via artisan.</br>
<b>Command-></b> php artisan make:model -mf Article </br>
Then Make some changes in Migration table 'create_articles_table'  migration inside the `database/migrations/` folder.</br>
<p style="color:#008000">
 Schema::create('articles', function (Blueprint $table) { </br>
     $table->id();</br>
     $table->string('title');</br>
     $table->text('body');</br>
     $table->json('tags');</br>
     $table->timestamps();</br>
 }); </p></br>
 </br>
 Article table looks like this (App/Models/Article.php).</br>
  <?php</br>
 namespace App\Models;</br>
 use Illuminate\Database\Eloquent\Factories\HasFactory;</br>
 use Illuminate\Database\Eloquent\Model;</br>
 class Article extends Model</br>
 {</br>
     use HasFactory;</br>
     protected $casts = [</br>
         'tags' => 'json',</br>
     ];</br>
 } </br>
</br>
Add some dummy data in table using <b>Database Seerder</b> at 'database/seeder/' looks like</br>
<?php</br>
 namespace Database\Seeders;</br>
 use App\Models\Article;</br>
 use Illuminate\Database\Seeder;</br>
 class DatabaseSeeder extends Seeder</br>
 {</br>
     public function run()</br>
     {</br>
         Article::factory()->times(50)->create();</br>
     }</br>
 } </br>
</br>
The seeder use laravel model factory to create 50 fake articles for us. Open up `database/factories/ArticleFactory.php` </br.
<?php</br></br>
 namespace Database\Factories;</br>
 use App\Models\Article;</br>
 use Illuminate\Database\Eloquent\Factories\Factory;</br>
 class ArticleFactory extends Factory</br>
 {</br>
     protected $model = Article::class;</br>
     public function definition()</br>
     {</br>
         return [</br>
             'title' => $this->faker->sentence(),</br>
             'body' => $this->faker->text(),</br>
             'tags' => collect(['php', 'ruby', 'java', 'javascript', 'bash'])</br>
                 ->random(2)</br>
                 ->values()</br>
                 ->all(),</br>
         ];
     }
 } 
</br>
<h4>Step 5</h4>
Let's fresh the migrate and seed the 50 fake articles in table.</br>
<b>command-></b> php artisan migrate:fresh --seed </br>

 




