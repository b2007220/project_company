<div id="categoryCarousel" class="carousel carousel-dark slide h-100 w-100" data-bs-ride="false">
    <div class="carousel-inner h-100 px-2">
        @php
            $chunkedCategories = $categories->chunk(3);
        @endphp
        @foreach ($chunkedCategories as $index => $chunk)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100 w-100">
                <div
                    class="card-group justify-content-center py-2 h-100  d-flex  flex-column align-items-center h-100 w-100">
                    @foreach ($chunk as $category)
                        <div class="category-menu w-80 mb-2">
                            @if ($category->children->isEmpty())
                                <button value="{{ $category->id }}" id="category-{{ $category->id }}"
                                    class="text-uppercase  border-0 bg-transparent  fs-5  w-100 py-2 rounded-pill justify-content-start d-flex pl-3 bg-primary-hover">
                                    {{ $category->name }}
                                </button>
                            @else
                                <div class="d-flex justify-content-between align-items-center rounded-pill">
                                    <button value="{{ $category->id }}" id="category-{{ $category->id }}"
                                        class=" py-2 text-uppercase border-0 bg-transparent pl-3 fs-5 text-center w-80 justify-content-start d-flex bg-primary-hover rounded-pill">
                                        {{ $category->name }}
                                    </button>
                                    <button
                                        class="navbar-toggler  d-flex justify-content-center align-items-center text-uppercase fw-bolder pr-3 "
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#sub-category-{{ $category->id }}" aria-controls="productSort"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M5 12h14m-7 7V5" />
                                        </svg>
                                    </button>

                                </div>
                                <div class="collapse bg-transparent pb-3 " id="sub-category-{{ $category->id }}">
                                    @foreach ($category->children as $subCategory)
                                        <button value="{{ $subCategory->id }}" id="category-{{ $subCategory->id }}"
                                            class="list-group-item list-group-item-action border-0 rounded-pill p-2 mb-2 bg-transparent fs-5 text-uppercase bg-primary-hover">
                                            {{ $subCategory->name }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @if ($chunkedCategories->count() > 1)
        <button class="carousel-control-prev z-2 justify-content-start" type="button"
            data-bs-target="#categoryCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next z-2 justify-content-end " type="button" data-bs-target="#categoryCarousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    @endif
</div>
