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
Then Make some changes in Migration table 'create_articles_table'  migration inside the `database/migrations/` folder. </br>
</br>
<b>
             Schema::create('articles', function (Blueprint $table) { </br>
                 $table->id();</br>
                 $table->string('title');</br>
                 $table->text('body');</br>
                 $table->json('tags');</br>
                 $table->timestamps();</br>
             });</b> </br>
 </br>
 Article table looks like this (App/Models/Article.php).</br>
                     <b> <?php</br>
                     namespace App\Models;</br>
                     use Illuminate\Database\Eloquent\Factories\HasFactory;</br>
                     use Illuminate\Database\Eloquent\Model;</br>
                     class Article extends Model</br>
                     {</br>
                         use HasFactory;</br>
                         protected $casts = [</br>
                             'tags' => 'json',</br>
                         ];</br>
                     } </b></br>
</br>

Add some dummy data in table using <b>Database Seerder</b> at 'database/seeder/' looks like</br>
                    <b><?php</br>
                     namespace Database\Seeders;</br>
                     use App\Models\Article;</br>
                     use Illuminate\Database\Seeder;</br>
                     class DatabaseSeeder extends Seeder</br>
                     {</br>
                         public function run()</br>
                         {</br>
                             Article::factory()->times(50)->create();</br>
                         }</br>
                     } </b></br>
</br>

The seeder use laravel model factory to create 50 fake articles for us. Open up `database/factories/ArticleFactory.php` </br>
                        <b><?php</br>
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
                         } </b>
</br>
<h4>Step 5</h4>

Let's fresh the migrate and seed the 50 fake articles in table.</br>
<b>command-></b> php artisan migrate:fresh --seed </br>

<h4>Step 6</h4>
make <b>ArticlesRepository</b> in 'App/Article'. </br>
code like this-></br>
<b>namespace App\Articles; </br>
interface ArticlesRepository </br>
{ </br>
    public function search(string $query=''): Collection; </br>
}</b> </br>

Next:- Make <b>EloquentSearchRepository<b>  in 'App/Article'. </br>
code like :-</br>
<b>namespace App\Articles;</br>
 class EloquentSearchRepository implements ArticlesRepository</br>
 {</br>
     public function search(string $query=''): Collection </br>
     {</br>
        return Article::query()</br>
             
            ->Where('body', 'LIKE', "%{$query}%")</br>
            ->orWhere('title', 'LIKE', "%{$query}%")</br>
            ->orWhere('tags', 'LIKE', "%{$query}%")</br>
             ->get();</br>

     }</br>
 } </br> <b>
<h4>Step 7</h4>
<h3>Integrating Elasticsearch </h3>
Here we are going to use <b>Model Observer</b> .</br>
<b>Command-></b>php artisan make:observer ElasticsearchObserver --model=Article  </br>
The artisan command will make <b>Observers</b> directory if it is not there (App/Observers). </br>
ElasticsearchObserver.php file is in observers where you can find the code. </br>

Now we make <b>Searchable</b> Trait in same observer directory.
</br> follow same directory for searchable.php code.

<h4>Step 8</h4>

Now we use the searchable trait in <b>Article.php</b> model. code like:- </br>
<b><?php
</br>
namespace App\Models;
</br>
use Illuminate\Database\Eloquent\Factories\HasFactory;</br>
use Illuminate\Database\Eloquent\Model;</br>
use App\Observers\Searchable;</br>

class Article extends Model</br>
{</br>
    use HasFactory;  </br>
    use Searchable;  </br>
    protected $casts = [   </br>
        'tags' => 'json',  </br>
    ];   </br>
}   </br>
</b>
</br>

 <h4>Step 9</h4>
<b>The Elasticsearch Repository</b>
now we are ready to use <b>Elasticsearch</b> with our Article model. We have <b>eloquent repository</b> as a <b>backup</b> ,if our elastic search fail.</br>
code is in <b>App/Articles/ElasticsearchRepository.php</b> </br>

 <h4>Step 10</h4>
Now we are going to register our repositories in <b>AppServiceProvider</b> which is in App/Providers. </br>
 code like:- </br>
<b>
public function register() </br>
    {
        $this->app->bind(Articles\ArticlesRepository::class, function ($app) { </br>

            if (!config('services.search.enabled')) {</br>
                return new Articles\EloquentSearchRepository();</br>
            }

            return new Articles\ElasticsearchRepository(</br>
                $app->make(Client::class)</br>
            );
        });</br>

        $this->bindSearchClient();</br>
    }

    private function bindSearchClient()</br>
    {
        $this->app->bind(Client::class, function ($app) {</br>
            return ClientBuilder::create()</br>
                ->setHosts($app['config']->get('services.search.hosts'))</br>
                ->build();</br>
        });</br>
    }</br>
</b>

<h4>

