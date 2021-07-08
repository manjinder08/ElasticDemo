<?php
    namespace App\Observers;
    
    use Elasticsearch\Client;
    trait Searchable{
        
        
        public static function bootSearchable()
    {
        
        if (config('services.search.enabled')) {
            static::observe(ElasticsearchObserver::class);
        }
    }

    public function getSearchIndex()
    { echo "hellloooo<br>";
        return $this->getTable();
        
    }

    public function getSearchType()
    {echo "helo02";
        if (property_exists($this, 'useSearchType')) {
            echo "helo02";
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray()
    {echo "helo02";
        // By having a custom method that transforms the model
        // to a searchable array allows us to customize the
        // data that's going to be searchable per model.
        return $this->toArray();
    }
    // public function elasticsearchIndex(Client $elasticsearchClient)
    // { 
    //     $elasticsearchClient->index([
    //         'index' => $this->getTable(),
    //         'type' => '_doc',
    //         'id' => $this->getKey(),
    //         'body' => $this->toElasticsearchDocumentArray(),
    //     ]);
    // }
    // public function elasticsearchDelete(Client $elasticsearchClient)
    // {
    //     $elasticsearchClient->delete([
    //         'index' => $this->getTable(),
    //         'type' => '_doc',
    //         'id' => $this->getKey(),
    //     ]);
    // }
    // abstract public function toElasticsearchDocumentArray(): array;
    }
?>