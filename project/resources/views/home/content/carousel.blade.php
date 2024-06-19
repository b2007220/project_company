<div class="container d-flex flex-lg-row flex-column justify-content-center align-items-center">
    <div
        class="col-8 position-relative d-flex overflow-hidden justify-content-center bg-gray-100 gap-4 py-4 rounded flex-column align-items-center max-w-3xl">
        <div id="carouselExampleIndicators" class="carousel slide d-lg-block d-none w-100" data-bs-ride="carousel">
            <div class="carousel-inner overflow-hidden h-md-96 w-100 rounded">
                @foreach ($banners as $banner)
                    <div class="carousel-item overflow-hidden w-100 h-100 {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('banner/' . $banner->image) }}" class="d-block w-100 h-100 rounded banner"
                            alt="{{ $banner->link }}" />
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
                    class="active w-100-rem h-30 m-0" aria-label="Slide {{ $loop->index + 1 }}">
                    <img src="{{ asset('banner/' . $banner->image) }}" alt="{{ $banner->link }}"
                        class="border rounded banner" />
                </li>
            @endforeach
        </ol>
    </div>
</div>
