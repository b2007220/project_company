<div class="flex-grow-1 flex-shrink-1 overflow-x-hidden overflow-y-auto d-flex">
    <div class="container-fluid px-6 py-2 mx-auto">
        <div class="mt-4">
            <div class="d-flex flex-wrap -mx-6 justify-content-evenly">
                <div class="max-w-100 px-6 min-w-112">
                    <div class="d-flex align-items-center px-5 py-6 bg-white rounded shadow">
                        <div class="p-3 bg-indigo-600 bg-opacity-75 rounded-circle">
                            <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl fw-bolder text-gray-700">
                                {{ $newUsers }}
                            </h4>
                            <div class="text-gray-500">Người dùng mới</div>
                        </div>
                    </div>
                </div>

                <div class="max-w-100 px-6 mt-6 mt-sm-0 min-w-112">
                    <div class="d-flex align-items-center px-5 py-6 bg-white rounded shadow">
                        <div class="p-3 bg-orange-600 bg-opacity-75 rounded-circle">
                            <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl fw-bolder text-gray-700">
                                {{ $totalOrders }}
                            </h4>
                            <div class="text-gray-500">Tổng đơn đã được đặt</div>
                        </div>
                    </div>
                </div>

                <div class="max-w-100 px-6 mt-6 mt-sm-0 min-w-112">
                    <div class="d-flex align-items-center px-5 py-6 bg-white rounded shadow">
                        <div class="p-3 bg-pink-600 bg-opacity-75 rounded-circle">
                            <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl fw-bolder text-gray-700">
                                {{ $availableProducts }}
                            </h4>
                            <div class="text-gray-500">Sản phẩm còn trong kho</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
