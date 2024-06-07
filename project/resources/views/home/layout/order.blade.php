<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.components.head')
</head>

<body>
    @include('home.components.header')
    @include('home.components.navigation')
    <main>
        @include('home.content.order')
    </main>
    @include('home.components.footer')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabll max-h-lg-100 max-w-screen-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="exampleModalLabel" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                        Chi tiết đơn hàng
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-gray-100 pt-10 border-2 rounded max-w-5xl max-h-xl  pl-8 pr-8">
                        <h1 class="mb-10 text-center text-2xl font-bold">Giỏ hàng</h1>
                        <div class="mx-auto justify-content-center flex-md xl:px-0 max-h-92 gap-2">
                            <div class="position-relative shadow rounded border w-100 overflow-y-scroll-custom">
                                <table class="w-100 text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="fw-bold px-6 py-3">
                                                <span class="sr-only">Hình ảnh</span>
                                            </th>
                                            <th scope="col" class="fw-bold px-6 py-3">
                                                Tên sản phẩm
                                            </th>
                                            <th scope="col" class="fw-bold px-6 py-3">Số lượng</th>
                                            <th scope="col" class="fw-bold px-6 py-3">Giá tiền</th>
                                            <th scope="col" class="fw-bold px-6 py-3">
                                                Chi tiết sản phẩm
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="fw-bolder p-4">
                                                <img src="https://flowbite.com/docs/images/products/apple-watch.png"
                                                    class="w-16 md:w-32 max-w-100 max-h-full" alt="Apple Watch" />
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                Apple Watch
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                5
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                $599
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                <a href="#" class="">Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="fw-bolder p-4">
                                                <img src="https://flowbite.com/docs/images/products/apple-watch.png"
                                                    class="w-16 md:w-32 max-w-100 max-h-full" alt="Apple Watch" />
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                Apple Watch
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                5
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                $599
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                <a href="#" class="">Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="fw-bolder p-4">
                                                <img src="https://flowbite.com/docs/images/products/apple-watch.png"
                                                    class="w-16 md:w-32 max-w-100 max-h-full" alt="Apple Watch" />
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                Apple Watch
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                5
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                $599
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                <a href="#" class="">Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="fw-bolder p-4">
                                                <img src="https://flowbite.com/docs/images/products/apple-watch.png"
                                                    class="w-16 md:w-32 max-w-100 max-h-full" alt="Apple Watch" />
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                Apple Watch
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                5
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                $599
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                <a href="#" class="">Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="fw-bolder p-4">
                                                <img src="https://flowbite.com/docs/images/products/apple-watch.png"
                                                    class="w-16 md:w-32 max-w-100 max-h-full" alt="Apple Watch" />
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                Apple Watch
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                5
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                $599
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                <a href="#" class="">Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="fw-bolder p-4">
                                                <img src="https://flowbite.com/docs/images/products/apple-watch.png"
                                                    class="w-16 md:w-32 max-w-100 max-h-full" alt="Apple Watch" />
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                Apple Watch
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                5
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                $599
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                <a href="#" class="">Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="fw-bolder p-4">
                                                <img src="https://flowbite.com/docs/images/products/imac.png"
                                                    class="w-16 md:w-32 max-w-100 max-h-full" alt="Apple iMac" />
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                iMac 27"
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                5
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                $2499
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                <a href="#" class="">Chi tiết</a>
                                            </td>
                                        </tr>

                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="fw-bolder p-4">
                                                <img src="https://flowbite.com/docs/images/products/iphone-12.png"
                                                    class="w-16 md:w-32 max-w-100 max-h-full" alt="iPhone 12" />
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                IPhone 12
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                5
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                $999
                                            </td>
                                            <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                                                <a href="#" class="">Chi tiết</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Sub total -->
                            <div class="rounded border bg-white mt-0-md w-13-md p-3 overflow-y-scroll-custom">
                                <div class="mb-2 d-flex justify-content-between">
                                    <p class="text-gray-700">Tiền sản phẩm</p>
                                    <p class="text-gray-700">129.990 đồng</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-gray-700">Tiền phí ship</p>
                                    <p class="text-gray-700">4.990 đồng</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-gray-700">Phiếu giảm giá</p>
                                    <p class="text-gray-700">0 đồng</p>
                                </div>
                                <hr class="my-2" />
                                <div class="d-flex justify-content-between">
                                    <p class="text-lg fw-bold">Tổng tiền</p>
                                    <div class="">
                                        <p class="mb-1 text-lg fw-bold">134.980 đồng</p>
                                        <p class="text-sm text-gray-700">Đã bao gồm VAT</p>
                                    </div>
                                </div>
                                <hr class="my-2" />
                                <div class="d-flex justify-content-between">
                                    <p class="text-lg fw-bold">Giao đến</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-1 text-lg">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                        Necessitatibus dolores architecto veniam debitis et maxime
                                        voluptate magni voluptatibus sunt consectetur, id,
                                        exercitationem quasi ducimus pariatur cumque fugit
                                        doloremque inventore harum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">
                        Hủy bỏ đơn hàng
                    </button>
                    <button type="button" class="btn btn-primary">
                        Đặt lại đơn hàng
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
