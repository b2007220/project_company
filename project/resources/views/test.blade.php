<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang thông tin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <nav class="container-fluid bg-white border-black border-opacity-25">
        <div class="d-flex flex-wrap justify-content-between align-items-center mx-auto container p-4">
            <a href="index.html" class="d-flex align-items-center text-decoration-none">
                <img src="fast-delivery.png" class="h-20 w-20" alt="Logo" />
                <span class="align-self-center fs-2 fw-bold text-nowrap text-dark space-x-3">Cửa hàng Online</span>
            </a>
            <div class="dropdown d-flex align-items-center order-md-2">
                <button class="d-flex bg-white small rounded-circle border-primary me-md-0 p-0" type="button"
                    id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="http://www.w3.org/2000/svg" alt="" class="w-8 h-8 border rounded-circle" />
                </button>
                <div class="dropdown-menu z-3 position-absolute text-base bg-white border rounded shadow"
                    aria-labelledby="userMenu">
                    <div class="border-bottom px-4 py-3">
                        <span class="d-block small text-body">Tên khách hàng</span>
                        <span class="d-block small text-body-secondary text-truncate">Nguyễn Văn A</span>
                    </div>
                    <div class="border-bottom">
                        <ul class="pt-2 pl-0">
                            <li class="d-block py-2 px-3 text-dark rounded p-md-0">
                                <a class="dropdown-item d-block px-3 py-2 small text-dark" href="#">Thông tin</a>
                            </li>
                            <li class="d-block py-2 px-3 text-dark rounded p-md-0">
                                <a class="dropdown-item d-block px-3 py-2 small text-dark" href="order.html">Lịch sử mua
                                    hàng</a>
                            </li>
                            <li class="d-block py-2 px-3 text-dark rounded p-md-0">
                                <a class="dropdown-item d-block px-3 py-2 small text-dark" href="#">Đổi mật
                                    khẩu</a>
                            </li>
                            <li class="d-block py-2 px-3 text-dark rounded p-md-0">
                                <a class="dropdown-item d-block px-3 py-2 small text-dark" href="#">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                    <div class="border-bottom px-4 py-3">
                        <a href=""
                            class="d-block small text-body-secondary text-truncate text-decoration-none fs-6">Admin</a>
                    </div>
                </div>
                <button
                    class="navbar-toggler d-inline-flex align-items-center p-2 justify-center small text-dark border rounded d-md-none space-x-3"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser" aria-controls="navbarUser"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    <nav
        class="container-fluid navbar navbar-expand-lg position-relative border border-light-subtle bg-secondary-subtle">
        <div
            class="container collapse navbar-collapse d-flex flex-wrap align-items-center justify-content-between mx-auto">
            <div class="align-items-center justify-content-between w-100 flex-md w-auto-md" id="navbarUser">
                <div
                    class="navbar-nav align-items-center d-flex fs-5 p-md-0rounded bg-secondary-subtle flex-row-md mt-0-md border-gray-500 p-0">
                    <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0 space-x-8" href="index.html">Trang
                        chủ</a>
                    <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0 space-x-8" href="shopping.html">Sản
                        phẩm</a>
                    <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0 space-x-8" href="cart.html">Giỏ
                        hàng</a>
                    <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0 space-x-8" href="aboutus.html">Hỗ
                        trợ</a>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <section class="py-3 py-md-5">
            <div class="container">
                <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
                    <div class="col-12 col-lg-6 col-xl-5">
                        <img class="img-fluid rounded border" loading="lazy"
                            src="https://t4.ftcdn.net/jpg/03/06/69/49/360_F_306694930_S3Z8H9Qk1MN79ZUe7bEWqTFuonRZdemw.jpg"
                            alt="" />
                    </div>
                    <div class="col-12 col-lg-6 col-xl-7">
                        <div class="row justify-content-xl-center">
                            <div class="col-12 col-xl-11">
                                <h2 class="mb-3">Who Are We?</h2>
                                <p class="lead fs-4 text-secondary mb-3">
                                    We are a dedicated team committed to providing exceptional
                                    shopping experiences and delivering top-quality products.
                                    Our mission is to assist individuals in creating remarkable
                                    lifestyles through our curated selection of goods.
                                </p>
                                <p class="mb-5">
                                    As a thriving retail establishment, we prioritize
                                    collaboration, innovation, and customer delight. We
                                    constantly seek innovative methods to enhance both our
                                    products and service. Our passion lies in fostering lasting
                                    relationships and exceeding expectations, ensuring customer
                                    satisfaction remains our priority.
                                </p>
                                <div class="row gy-4 gy-md-0 gx-xxl-5X">
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex">
                                            <div class="me-4 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-telephone-fill"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h2 class="h4 mb-3">Contact</h2>
                                                <p class="text-secondary mb-0">
                                                    Interesting in this website? Contact us for more
                                                    information.
                                                </p>
                                                <p class="text-primary">09xxxxxxx</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex">
                                            <div class="me-4 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                                                    <path
                                                        d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h2 class="h4 mb-3">Address</h2>
                                                <p class="text-secondary mb-0">
                                                    Feel free to visit our office at any time
                                                </p>
                                                <p class="text-primary">
                                                    xxx, Ho Chi Minh City, Viet Nam
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-white">
        <div class="mx-auto w-100 container">
            <div class="row g-3 px-4 py-6 py-lg-5">
                <div class="col-6 col-md-3">
                    <h2 class="mb-6 small fw-bold text-dark text-uppercase">Company</h2>
                    <ul class="fw-bold pl-0">
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">About</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Careers</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Brand Center</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Blog</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="mb-6 small fw-bold text-dark text-uppercase">
                        Help center
                    </h2>
                    <ul class="fw-bold pl-0">
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Twitter</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Facebook</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Contact Us</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Discord Server</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="mb-6 small fw-bold text-dark text-uppercase">Legal</h2>
                    <ul class="fw-bold pl-0">
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Privacy Policy</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Licensing</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Terms &amp; Conditions</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="mb-6 small fw-bold text-dark text-uppercase">
                        Download
                    </h2>
                    <ul class="fw-bold pl-0">
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">iOS</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Careers</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">Windows</a>
                        </li>
                        <li class="mb-3 underline-hover">
                            <a href="" class="text-decoration-none text-muted">MacOS</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="px-4 py-6 bg-body-secondary d-md-flex align-items-md-center justify-content-md-between">
                <div class="d-flex mt-4 justify-content-sm-center mt-md-0">
                    <a href="" class="text-body-tertiary space-x-5 text-decoration-none">
                        <svg class="w-4 h-4 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 8 19">
                            <path fill-rule="evenodd"
                                d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="" class="text-body-tertiary space-x-5 text-decoration-none">
                        <svg class="w-4 h-4 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 21 16">
                            <path
                                d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z" />
                        </svg>
                    </a>
                    <a href="" class="text-body-tertiary space-x-5 text-decoration-none">
                        <svg class="w-4 h-4 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 17">
                            <path fill-rule="evenodd"
                                d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="" class="text-body-tertiary space-x-5 text-decoration-none">
                        <svg class="w-4 h-4 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="" class="text-body-tertiary space-x-5 text-decoration-none">
                        <svg class="w-4 h-4 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.51 8.51 0 0 1-2.2-5.707v-.262a31.64 31.64 0 0 0 8.777-1.219c.243.477.477.964.692 1.449-.114.032-.227.067-.336.1a13.569 13.569 0 0 0-6.942 5.636l.009.003ZM10 18.556a8.508 8.508 0 0 1-5.243-1.8 11.717 11.717 0 0 1 6.7-5.332.509.509 0 0 1 .055-.02 35.65 35.65 0 0 1 1.819 6.476 8.476 8.476 0 0 1-3.331.676Zm4.772-1.462A37.232 37.232 0 0 0 13.113 11a12.513 12.513 0 0 1 5.321.364 8.56 8.56 0 0 1-3.66 5.73h-.002Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
