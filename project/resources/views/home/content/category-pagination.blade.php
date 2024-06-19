<div id="categoryCarousel" class="carousel carousel-dark slide h-100" data-bs-ride="false">
    <div class="carousel-inner h-100">
        @php
            $chunkedCategories = $categories->chunk(3);
        @endphp
        @foreach ($chunkedCategories as $index => $chunk)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                <div class="card-group justify-content-center py-2 h-100  d-flex  flex-column align-items-center h-100">
                    @foreach ($chunk as $category)
                        <button value="{{ $category->id }}" id="category-{{ $category->id }}"
                            class="h-100 text-center w-80 py-3 rounded-pill border mb-2 text-uppercase fw-bolder carousel-button">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @if ($chunkedCategories->count() > 1)
        <button class="carousel-control-prev z-2 justify-content-start" type="button" data-bs-target="#categoryCarousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next z-2 justify-content-end" type="button" data-bs-target="#categoryCarousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    @endif
</div>
