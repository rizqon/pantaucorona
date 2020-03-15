<div class="col-md-6">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Berita Stream</h3>
        </div>
        <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach($news as $berita)
                <li class="item">
                    <div class="product-img">
                        <img src="{{ $berita->urlToImage }}" alt="{{ $berita->title }}" class="img-size-50">
                    </div>
                    <div class="product-info">
                        <a href="{{ $berita->url }}" class="product-title" rel="nofollow" target="_blank">
                            {{ $berita->title }}
                        </a>
                        <span class="product-description">
                            {{ $berita->source->name }}
                        </span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
