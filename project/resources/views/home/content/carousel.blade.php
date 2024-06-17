<div class="container d-flex flex-lg-row flex-column justify-content-center align-items-center">
    <div
        class="col-8 position-relative d-flex overflow-hidden justify-content-center bg-gray-100 gap-4 py-4 rounded flex-column align-items-center max-w-3xl">
        <div id="carouselExampleIndicators" class="carousel slide d-lg-block d-none w-100" data-bs-ride="carousel">
            <div class="carousel-inner overflow-hidden h-md-96 w-100 rounded">
                {{-- <div class="carousel-item overflow-hidden active w-100 h-100">
                    <img src="https://i.pinimg.com/1200x/ed/cd/32/edcd32b829a5c6e614a6d6383c562742.jpg"
                        class="d-block rounded w-100 h-100  object-fit-cover banner" alt="" />
                    <button class="position-absolute z-3 rounded button-carousel fw-bold  fs-5">
                        Xem thêm</button>
                </div>
                <div class="carousel-item overflow-hidden w-100 h-100 ">
                    <img src="https://i.pinimg.com/736x/72/db/6b/72db6bb11a1553d416ea79f7b0f9990d.jpg"
                        class="d-block w-100 h-100 rounded  banner" alt="" />
                    <button class="position-absolute z-3 rounded button-carousel fw-bold  fs-5">
                        Xem thêm</button>
                </div>
                <div class="carousel-item overflow-hidden w-100 h-100 ">
                    <img src="https://mir-s3-cdn-cf.behance.net/project_modules/hd/d7dfad107187879.5fa16aecd773f.jpg"
                        class="d-block  w-100 h-100 rounded banner" alt="" />
                    <button class="position-absolute z-3 rounded button-carousel fw-bold  fs-5">
                        Xem thêm</button>
                </div> --}}
                @foreach ($banners as $banner)
                    <div class="carousel-item overflow-hidden w-100 h-100 {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ $banner->image }}" class="d-block w-100 h-100 rounded banner" alt="" />
                        <a href="{{ $banner->link }}"
                            class="position-absolute z-3 rounded button-carousel fw-bold  fs-5 text-decoration-none">
                            Xem thêm</a>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev z-2" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next z-2" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>
    <div id="carouselExampleIndicators" class="carousel slide relative max-w-3xl" data-bs-ride="carousel">
        <ol class="carousel-indicators flex-column">

            @foreach ($banners as $banner)
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}"
                    class="active w-100-rem h-30 m-0"
                    aria-label="Slide {{ $loop->index + 1 }}">
                    <img src="{{ $banner->image }}" alt="" class="border rounded banner" />
                    <button class="z-3 position-absolute indicator-button">
                        <a href="{{ $banner->link }}" class="text-decoration-none">
                            <svg class="w-6 h-6 text-dark indicator-icon" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8.891 15.107 15.11 8.89m-5.183-.52h.01m3.089 7.254h.01M14.08 3.902a2.849 2.849 0 0 0 2.176.902 2.845 2.845 0 0 1 2.94 2.94 2.849 2.849 0 0 0 .901 2.176 2.847 2.847 0 0 1 0 4.16 2.848 2.848 0 0 0-.901 2.175 2.843 2.843 0 0 1-2.94 2.94 2.848 2.848 0 0 0-2.176.902 2.847 2.847 0 0 1-4.16 0 2.85 2.85 0 0 0-2.176-.902 2.845 2.845 0 0 1-2.94-2.94 2.848 2.848 0 0 0-.901-2.176 2.848 2.848 0 0 1 0-4.16 2.849 2.849 0 0 0 .901-2.176 2.845 2.845 0 0 1 2.941-2.94 2.849 2.849 0 0 0 2.176-.901 2.847 2.847 0 0 1 4.159 0Z" />
                            </svg>
                        </a>
                    </button>
                </li>
            @endforeach
            {{-- <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active w-100-rem h-30 m-0"
                aria-current="true" aria-label="Slide 1">
                <img src="https://i.pinimg.com/1200x/ed/cd/32/edcd32b829a5c6e614a6d6383c562742.jpg" alt=""
                    class="border rounded banner" />
                <button class="z-3 position-absolute indicator-button"><svg class="w-6 h-6 text-dark indicator-icon"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.891 15.107 15.11 8.89m-5.183-.52h.01m3.089 7.254h.01M14.08 3.902a2.849 2.849 0 0 0 2.176.902 2.845 2.845 0 0 1 2.94 2.94 2.849 2.849 0 0 0 .901 2.176 2.847 2.847 0 0 1 0 4.16 2.848 2.848 0 0 0-.901 2.175 2.843 2.843 0 0 1-2.94 2.94 2.848 2.848 0 0 0-2.176.902 2.847 2.847 0 0 1-4.16 0 2.85 2.85 0 0 0-2.176-.902 2.845 2.845 0 0 1-2.94-2.94 2.848 2.848 0 0 0-.901-2.176 2.848 2.848 0 0 1 0-4.16 2.849 2.849 0 0 0 .901-2.176 2.845 2.845 0 0 1 2.941-2.94 2.849 2.849 0 0 0 2.176-.901 2.847 2.847 0 0 1 4.159 0Z" />
                    </svg>
                </button>
            </li>
            <li class="active w-100-rem h-30 m-0" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2">
                <img src="https://i.pinimg.com/736x/72/db/6b/72db6bb11a1553d416ea79f7b0f9990d.jpg" alt=""
                    class="border rounded banner" />
                <button class="z-3 position-absolute indicator-button"><svg class="w-6 h-6 text-dark indicator-icon"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.891 15.107 15.11 8.89m-5.183-.52h.01m3.089 7.254h.01M14.08 3.902a2.849 2.849 0 0 0 2.176.902 2.845 2.845 0 0 1 2.94 2.94 2.849 2.849 0 0 0 .901 2.176 2.847 2.847 0 0 1 0 4.16 2.848 2.848 0 0 0-.901 2.175 2.843 2.843 0 0 1-2.94 2.94 2.848 2.848 0 0 0-2.176.902 2.847 2.847 0 0 1-4.16 0 2.85 2.85 0 0 0-2.176-.902 2.845 2.845 0 0 1-2.94-2.94 2.848 2.848 0 0 0-.901-2.176 2.848 2.848 0 0 1 0-4.16 2.849 2.849 0 0 0 .901-2.176 2.845 2.845 0 0 1 2.941-2.94 2.849 2.849 0 0 0 2.176-.901 2.847 2.847 0 0 1 4.159 0Z" />
                    </svg>
                </button>
            </li>
            <li data-bs-target="#carouselExampleIndicators" class="active w-100-rem h-30 m-0" data-bs-slide-to="2"
                aria-label="Slide 3">
                <img src="https://mir-s3-cdn-cf.behance.net/project_modules/hd/d7dfad107187879.5fa16aecd773f.jpg"
                    alt="" class="border rounded banner" />
                <button class="z-3 position-absolute indicator-button"><svg class="w-6 h-6 text-dark indicator-icon"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.891 15.107 15.11 8.89m-5.183-.52h.01m3.089 7.254h.01M14.08 3.902a2.849 2.849 0 0 0 2.176.902 2.845 2.845 0 0 1 2.94 2.94 2.849 2.849 0 0 0 .901 2.176 2.847 2.847 0 0 1 0 4.16 2.848 2.848 0 0 0-.901 2.175 2.843 2.843 0 0 1-2.94 2.94 2.848 2.848 0 0 0-2.176.902 2.847 2.847 0 0 1-4.16 0 2.85 2.85 0 0 0-2.176-.902 2.845 2.845 0 0 1-2.94-2.94 2.848 2.848 0 0 0-.901-2.176 2.848 2.848 0 0 1 0-4.16 2.849 2.849 0 0 0 .901-2.176 2.845 2.845 0 0 1 2.941-2.94 2.849 2.849 0 0 0 2.176-.901 2.847 2.847 0 0 1 4.159 0Z" />
                    </svg>
                </button>
            </li> --}}
        </ol>
    </div>
</div>
