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

 Schema::create('articles', function (Blueprint $table) {
     $table->id();
     $table->string('title');
     $table->text('body');
     $table->json('tags');
     $table->timestamps();
 }); 
 </br>
 Article table looks like this (App/Models/Article.php).</br>
  <?php
 namespace App\Models;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 class Article extends Model
 {
     use HasFactory;
     protected $casts = [
         'tags' => 'json',
     ];
 } 
</br>
Add some dummy data in table using <b>Database Seerder</b> at 'database/seeder/' looks like</br>
<?php
 namespace Database\Seeders;
 use App\Models\Article;
 use Illuminate\Database\Seeder;
 class DatabaseSeeder extends Seeder
 {
     public function run()
     {
         Article::factory()->times(50)->create();
     }
 } 
</br>
The seeder use laravel model factory to create 50 fake articles for us. Open up `database/factories/ArticleFactory.php` </br.
<?php
 namespace Database\Factories;
 use App\Models\Article;
 use Illuminate\Database\Eloquent\Factories\Factory;
 class ArticleFactory extends Factory
 {
     protected $model = Article::class;
     public function definition()
     {
         return [
             'title' => $this->faker->sentence(),
             'body' => $this->faker->text(),
             'tags' => collect(['php', 'ruby', 'java', 'javascript', 'bash'])
                 ->random(2)
                 ->values()
                 ->all(),
         ];
     }
 } 
</br>
<h4>Step 5</h4>
Let's fresh the migrate and seed the 50 fake articles in table.</br>
<b>command-></b> php artisan migrate:fresh --seed </br>

 




