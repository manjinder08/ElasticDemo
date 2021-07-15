
    <div class="container">
        <div class="card">
            <div class="card-header">
                Articles <small></small>
            </div>
            <div class="card-body">
                <form action="{{ url('redissearch') }}" method="get">
                    <div class="form-group">
                        <input
                            type="text"
                            name="query"
                            class="form-control"
                            placeholder="Search..."
                            value="{{ request('query') }}"
                        />
                    </div>
                </form>
                @forelse ($articles as $article)
                    <article class="mb-3">
                        <h2>{{ $article->title }}</h2>

                        <p class="m-0">{{ $article->body }}</body>

                        <div>
                            @foreach ($article->tags as $tag)
                                <span class="badge badge-light">{{ $tag}}</span>
                            @endforeach
                        </div>
                    </article>
                @empty
                    <p>No articles found</p>
                @endforelse
              
            </div>
        </div>
    </div>
