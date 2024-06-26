<table class="min-w-100">
    <thead>
        <tr>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Tên loại sản phẩm
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Thao tác
            </th>
        </tr>
    </thead>
    <tbody class="bg-white">
        @foreach ($categories as $category)
            <tr data-category-id="{{ $category->id }}" data-bs-toggle="collapse" class="w-100"
                data-bs-target=".detail-{{ $category->id }}">
                <td class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm ">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ $category->name }}
                    </div>
                </td>
                <td
                    class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500  border-bottom border-gray-200">
                    <div class="  d-flex justify-content-center align-items-center gap-2">
                        <form action="javascript:void(0)" enctype="multipart/form-data"
                            onsubmit="confirmation(event, {{ $category->id }})">
                            <button type="submit"
                                class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                Xóa
                                <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </form>
                        <button type="button"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                            data-bs-toggle="modal" data-bs-target="#addCategoryModal" data-mode="edit"
                            data-category="{{ json_encode($category) }}">
                            Chỉnh sửa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="detail-{{ $category->id }} collapse w-100">
                <td colspan="2" class="w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="p-3">Chi tiết thể loại</h5>
                        <button type="submit" form=""
                            class="p-2 m-3 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                            Thêm loại
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <table class="min-w-100">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                                    Tên loại sản phẩm
                                </th>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($category->children as $subCategory)
                                <tr data-category-id="{{ $subCategory->id }}" data-bs-toggle="collapse" class="w-100"
                                    data-bs-target=".detail-{{ $subCategory->id }}">
                                    <td
                                        class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm ">
                                        <div
                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            {{ $subCategory->name }}
                                        </div>
                                    </td>
                                    <td
                                        class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500  border-bottom border-gray-200">
                                        <div class="  d-flex justify-content-center align-items-center gap-2">
                                            <form action="javascript:void(0)" enctype="multipart/form-data"
                                                onsubmit="confirmation(event, {{ $subCategory->id }})">
                                                <button type="submit"
                                                    class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                                    Xóa
                                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <button type="button"
                                                class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                                                data-bs-toggle="modal" data-bs-target="#addCategoryModal"
                                                data-mode="edit" data-category="{{ json_encode($subCategory) }}">
                                                Chỉnh sửa
                                                <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $categories->links() !!}
