<table class="min-w-100">
    <thead>
        <tr>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Email tài khoản
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Tên tài khoản
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Số điện thoại tài khoản
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Địa chỉ tài khoản
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Trạng thái tài khoản
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Vai trò tài khoản
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Thao tác
            </th>
        </tr>
    </thead>

    <tbody class="bg-white">
        @foreach ($accounts as $account)
            <tr data-account-id="{{ $account->id }}">
                <td class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        @if ($account->email)
                            {{ $account->email }}
                        @else
                            Chưa cập nhật
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        @if ($account->name)
                            {{ $account->name }}
                        @else
                            Chưa cập nhật
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        @if ($account->phone)
                            {{ $account->phone }}
                        @else
                            Chưa cập nhật
                        @endif
                    </div>
                </td>

                <td class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center pl-2">
                        @if ($account->address)
                            {{ $account->address }}
                        @else
                            Chưa cập nhật
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm">

                    @if ($account->is_active)
                        <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-green-300 text-white p-2 fw-bolder border rounded">Đang hoạt
                                động</span>
                        </div>
                    @else
                        <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-red-700 text-white p-2 fw-bolder border rounded">Vô hiệu
                                hóa</span>
                        </div>
                    @endif
                </td>

                <td class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm">


                    @if ($account->role === 'ADMIN')
                        <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-orange-300 text-white p-2 fw-bolder border rounded">Quản trị
                                viên</span>
                        </div>
                    @else
                        <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-blue-300 text-white p-2 fw-bolder border rounded">Người
                                dùng</span>
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm leading-5 text-gray-500  border-bottom border-gray-200">
                    <div class=" d-flex justify-content-center align-items-center gap-2">
                        <form onsubmit="disableAccount({{ $account->id }})">

                            @if ($account->is_active)
                                <button type="submit"
                                    class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                    Vô hiệu hóa
                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            @else
                                <button type="submit"
                                    class="text-decoration-none p-2 border rounded-pill fw-bolder bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                                    Kích hoạt
                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            @endif
                        </form>
                        <button type="button"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                            data-bs-toggle="modal" data-bs-target="#adjustAccountModal"
                            data-account="{{ json_encode($account) }}">
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
        @endforeach
    </tbody>
</table>
{!! $accounts->links() !!}
