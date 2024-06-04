<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới sản phẩm
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm" enctype="multipart/form-data" action="javascript:void(0)">
                    <input type="hidden" id="productId" name="id" value="" />
                    <label for="productName" class="my-2">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="productName" name="name"
                        placeholder="Nhập tên sản phẩm" required />
                    <label for="productDescription" class="my-2">Mô tả</label>
                    <textarea class="form-control" id="productDescription" name="description" placeholder="Nhập mô tả" required></textarea>
                    <label for="categories" class="my-2">Loại sản phẩm</label>
                    <select class="form-select max-w-100 overflow-auto" multiple name="categories" id="categories">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label for="productPrice" class="my-2">Giá</label>
                    <input type="number" class="form-control" id="productPrice" name="price" placeholder="Nhập giá"
                        required />
                    <label for="productQuantity" class="my-2">Số lượng</label>
                    <input type="number" class="form-control" id="productQuantity" name="amount"
                        placeholder="Nhập số lượng" required />
                    <label for="images">Hình ảnh</label>
                    <input type="file" name="images" id="images" class="form-control" multiple>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="productForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Thêm mới
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addProductModal = document.getElementById("addProductModal");
        addProductModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute("data-mode");
            const modalTitle = document.getElementById("modalTitle");
            const productForm = document.getElementById("productForm");
            const productId = document.getElementById("productId");
            const productName = document.getElementById("productName");
            const productDescription = document.getElementById("productDescription");
            const productPrice = document.getElementById("productPrice");
            const productQuantity = document.getElementById("productQuantity");
            const categories = document.getElementById("categories");

            productForm.reset();
            if (mode === "edit") {
                const product = JSON.parse(button.getAttribute("data-product"));
                modalTitle.textContent = "Chỉnh sửa sản phẩm";
                productForm.action = `product/update/${product.id}`;
                productId.value = product.id;
                productName.value = product.name;
                productDescription.value = product.description;
                productPrice.value = product.price;
                productQuantity.value = product.amount;
                const categoryIds = product.categories.map(category => category.id);
                for (let option of categories.options) {
                    option.selected = categoryIds.includes(parseInt(option.value));
                }
                let methodInput = productForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.setAttribute('type', 'hidden');
                    methodInput.setAttribute('name', '_method');
                    productForm.appendChild(methodInput);
                }
                methodInput.value = 'PUT';
            } else {
                modalTitle.textContent = "Thêm mới sản phẩm";
                productForm.action = `product/add`;
                productId.value = "";
                productName.value = "";
                productDescription.value = "";
                productPrice.value = "";
                productQuantity.value = "";
                for (let option of categories.options) {
                    option.selected = false;
                }
                const methodInput = productForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    productForm.removeChild(methodInput);
                }
            }
        });
    });

    document.getElementById("productForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const selectedCategories = [];
        const categories = document.getElementById("categories");


        const selectedOptions = [...categories.selectedOptions];
        selectedOptions.forEach(option => {
            selectedCategories.push(option.value);
        });
        formData.append('categories', selectedCategories);
        const url = this.action;
        const method = this.querySelector('input[name="_method"]') ? 'PUT' : 'POST';


        const images = document.getElementById("images").files;
        console.log(images);
        const selectedPicture = [];
        for (i = 0; i < images.length; i++) {
            selectedPicture.push(images[i]);
        }
        formData.append('images', selectedPicture);


        formData.append('images', images);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            }
        });


        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(Object.fromEntries(formData.entries())),
            processData: false,
            contentType: false,
            cache: false,
            success: function(result) {
                $('#addProductModal').modal('hide');
                if (method === 'PUT') {
                    const row = document.querySelector(
                        `tr[data-product-id="${result.product.id}"]`);
                    const detailRow = document.querySelector(
                        `tr.detail-${result.product.id}.collapse`);
                    if (row) {
                        row.innerHTML = `
                                    <td class ="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                                            <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                ${result.product.name}
                                            </div>
                                    </td>

                                    <td class ="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.product.description}
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center flex-column">
                                            ${result.categories ? result.categories.map(category =>
                                            ` <span> ${category.name} </span>`).join('') : ''}
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.product.price.toLocaleString('en-US')} đ
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.discounts && result.discounts.length> 0 ? result.discounts.map(discount => discount.is_predefined ?
                                                `<span>
                                                    ${(result.product.price-(result.product.price * discount.discount) / 100).toLocaleString('en-US')} đ
                                                </span>` :'').join('') :
                                                `<span>${result.product.price.toLocaleString('en-US')} đ
                                                </span>`
                                    }
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.product.amount.toLocaleString('en-US')}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                                        <form action = "javascript:void(0)"
                                        enctype = "multipart/form-data"
                                        onsubmit = "confirmation(event, ${result.product.id})">
                                            <button type = "submit" class ="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">Xóa
                                                <svg class = "w-6 h-6 text-white"
                                                    aria-hidden = "true"
                                                    xmlns = "http://www.w3.org/2000/svg"
                                                    width = "24"
                                                    height = "24"
                                                    fill = "none"
                                                    viewBox = "0 0 24 24">    <path stroke = "currentColor"
                                                    stroke-linecap = "round"
                                                    stroke-linejoin = "round"
                                                    stroke-width = "2"
                                                    d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </button>
                                        </form>
                                        <button type = "button"
                                            class ="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                                            data-bs-toggle = "modal"
                                            data-bs-target = "#addProductModal"
                                            data-mode = "edit"
                                            data-product = '${JSON.stringify(result.product)}'>
                                                Chỉnh sửa
                                                <svg class = "w-6 h-6 text-white"
                                                aria-hidden = "true"
                                                xmlns = "http://www.w3.org/2000/svg"
                                                width = "24"
                                                height = "24"
                                                fill = "none"
                                                viewBox = "0 0 24 24">    <path stroke = "currentColor"
                                                stroke-linecap = "round"
                                                stroke-linejoin = "round"
                                                stroke-width = "2"
                                                d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                        </button>
                                    </td>`;
                        detailRow.innerHTML = `<td colspan = "12">
                                            <div class = "d-flex justify-content-between align-items-center">
                                                <h5 class = "p-3"> Hình ảnh của sản phẩm </h5>
                                                <button type = "submit"
                                                    form = "deletePictureForm"
                                                    class ="p-2 m-3 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">Xóa ảnh
                                                    <svg class = "w-6 h-6  text-white"
                                                    aria-hidden = "true"
                                                    xmlns = "http://www.w3.org/2000/svg"
                                                    width = "24"
                                                    height = "24"
                                                    fill = "none"
                                                    viewBox = "0 0 24 24">    <path stroke = "currentColor"
                                                    stroke-linecap = "round"
                                                    stroke-linejoin = "round"
                                                    stroke-width = "2"
                                                    d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <form
                                            id = "deletePictureForm">
                                            @csrf
                                            @method('DELETE')
                                                <input type = "hidden"
                                                name = "selected_pictures"
                                                id = "selected_pictures">
                                                    <div class = "d-flex align-items-center px-6 gap-4 flex-column-max-lg"
                                                        id = "pictures-container">
                                                        ${result.product.pictures ? result.product.pictures.map(picture => `
                                                            <div class = "border rounded border-gray-300 picture-item"
                                                                data-id = "${picture.id}">
                                                                <img class = "img-fluid custom-img rounded"
                                                                    src = "{{ asset('product/${picture.link}') }}"
                                                                    alt = "">
                                                            </div>`).join('') : ''
                                                    }
                                                    </div>


                                            </form>
                                            <div class = "d-flex justify-content-between align-items-center"><h5 class = "p-3 "> Giảm giá của sản phẩm </h5>
                                                <button class ="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1"
                                                    data-bs-toggle = "modal"
                                                    data-bs-target = "#addProductDiscountModal"
                                                    data-product = "${JSON.stringify(result.product)}">Thêm mới
                                                    <svg class = "w-6 h-6  text-white"
                                                    aria-hidden = "true"
                                                    xmlns = "http://www.w3.org/2000/svg"
                                                    width = "24"
                                                    height = "24"
                                                    fill = "none"
                                                    viewBox = "0 0 24 24">    <path stroke = "currentColor"
                                                    stroke-linecap = "round"
                                                    stroke-linejoin = "round"
                                                    stroke-width = "2"
                                                    d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        <table class = "w-100">
                                            <thead>
                                                <tr>
                                                    <th class ="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50  text-center">
                                                        Code giảm giá
                                                    </th>
                                                    <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Tên giảm giá
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Phần trăm giảm giá
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Số lượng giảm giá
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Ngày hết hạn
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Đang áp dụng
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Thao tác
                                                </th>

                                                </tr> <thead> <tbody>    ${
                                                    result.discounts ? result.discounts.map(discount => `<tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                                            ${discount.code}
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                                            ${discount.name}
                                                        </div>

                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                                            ${discount.discount}
                                                        </div>

                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                                            ${discount.amount}
                                                        </div>


                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                            ${new Date(result.discount.expired_at).toLocaleDateString('en-GB')}
                                                        </div>

                                                    </td>

                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                            ${discount.pivot.is_predefined ? '<span class="text-success">Áp dụng trực tiếp</span>' : '<span class="text-danger">Chưa áp dụng</span>'}
                                                        </div>

                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
        <div class="d-flex justify-content-center align-items-center gap-2"><form
                                                            method="POST" onsubmit="return confirmation(event, this)">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
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
                                                        <form
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit" class=" p-2 border rounded-pill bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                                                                Áp dụng
                                                                <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                </svg>
                                                            </button>
                                                        </form></div>

                                                    </td>
                                                </tr>`).join('') : ''
                                                };

                                            </tbody> <table> </td> <tr> `;
                    }
                    swal({
                        title: 'Thành công!',
                        text: result.message,
                        icon: 'success',
                        button: 'OK',
                        timer: 1000
                    });
                } else if (method === 'POST') {
                    console.log(result);
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-product-id', result.product
                        .id);
                    newRow.setAttribute('data-bs-toggle', 'collapse');
                    newRow.setAttribute('data-bs-target', `.detail-${
                                                result.product.id
                                            }
                                            `);
                    newRow.innerHTML =
                        `<td class ="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.product.name}
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.product.description}
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center flex-column">
                                            ${result.categories ? result.categories.map(category =>
                                                ` <span> ${category.name} </span>`).join('') : ''
                                            }
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.product.price.toLocaleString('en-US')}đ
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.discounts && result.discounts.length> 0 ? result.discounts.map(discount => discount.is_predefined ?
                                            `<span>
                                                ${(result.product.price-(result.product.price * discount.discount) / 100).toLocaleString('en-US')} đ
                                            </span>` :'').join('') :
                                            `<span>
                                                ${result.product.price.toLocaleString('en-US')} đ
                                            </span>`
                                                }
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${result.product.amount.toLocaleString('en-US')}
                                        </div>

                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                                        <form action = "javascript:void(0)"
                                            enctype = "multipart/form-data"
                                            onsubmit = "confirmation(event, ${result.product.id})">
                                            <button type = "submit" class ="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                                Xóa
                                                <svg class = "w-6 h-6 text-white"
                                                aria-hidden = "true"
                                                xmlns = "http://www.w3.org/2000/svg"
                                                width = "24"
                                                height = "24"
                                                fill = "none"
                                                viewBox = "0 0 24 24">
                                                <path stroke = "currentColor"
                                                stroke-linecap = "round"
                                                stroke-linejoin = "round"
                                                stroke-width = "2"
                                                d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </button>
                                        </form>
                                        <button type = "button"
                                            class ="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                                            data-bs-toggle = "modal"
                                            data-bs-target = "#addProductModal"
                                            data-mode = "edit"
                                            data-product = '${JSON.stringify(result.product)}'>
                                            Chỉnh sửa
                                            <svg class = "w-6 h-6 text-white"
                                            aria-hidden = "true"
                                            xmlns = "http://www.w3.org/2000/svg"
                                            width = "24"
                                            height = "24"
                                            fill = "none"
                                            viewBox = "0 0 24 24">
                                            <path stroke = "currentColor"
                                            stroke-linecap = "round"
                                            stroke-linejoin = "round"
                                            stroke-width = "2"
                                            d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    </td>
                                <tr> `;
                    const newRowDetail = document.createElement('tr');
                    newRowDetail.classList.add(
                        `detail-${result.product.id}`);
                    newRowDetail.classList.add(`collapse`);
                    newRowDetail.innerHTML = `
                                        <td colspan = "12">
                                            <div class = "d-flex justify-content-between align-items-center">
                                                <h5 class = "p-3"> Hình ảnh của sản phẩm </h5>
                                                <button type = "submit"
                                                    form = "deletePictureForm"
                                                    class ="p-2 m-3 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">Xóa ảnh
                                                    <svg class = "w-6 h-6  text-white"
                                                    aria-hidden = "true"
                                                    xmlns = "http://www.w3.org/2000/svg"
                                                    width = "24"
                                                    height = "24"
                                                    fill = "none"
                                                    viewBox = "0 0 24 24">    <path stroke = "currentColor"
                                                    stroke-linecap = "round"
                                                    stroke-linejoin = "round"
                                                    stroke-width = "2"
                                                    d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                <button>
                                            </div>
                                            <form
                                            id = "deletePictureForm">
                                            @csrf
                                            @method('DELETE')
                                                <input type = "hidden"
                                                name = "selected_pictures"
                                                id = "selected_pictures">
                                                    <div class = "d-flex align-items-center px-6 gap-4 flex-column-max-lg"
                                                        id = "pictures-container">
                                                        ${result.product.pictures ? result.product.pictures.map(picture => `
                                                            <div class = "border rounded border-gray-300 picture-item"
                                                                data-id = "${picture.id}">
                                                                <img class = "img-fluid custom-img rounded"
                                                                    src = "{{ asset('product/${picture.link}') }}"
                                                                    alt = "">
                                                            </div>`).join('') : ''
                                                    }
                                                    </div>


                                            </form>
                                            <div class = "d-flex justify-content-between align-items-center"><h5 class = "p-3 "> Giảm giá của sản phẩm </h5>
                                                <button class ="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1"
                                                    data-bs-toggle = "modal"
                                                    data-bs-target = "#addProductDiscountModal"
                                                    data-product = "${JSON.stringify(result.product)}">Thêm mới
                                                    <svg class = "w-6 h-6  text-white"
                                                    aria-hidden = "true"
                                                    xmlns = "http://www.w3.org/2000/svg"
                                                    width = "24"
                                                    height = "24"
                                                    fill = "none"
                                                    viewBox = "0 0 24 24">    <path stroke = "currentColor"
                                                    stroke-linecap = "round"
                                                    stroke-linejoin = "round"
                                                    stroke-width = "2"
                                                    d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                <button>
                                            </div>
                                        <table class = "w-100">
                                            <thead>
                                                <tr>
                                                    <th class ="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50  text-center">
                                                        Code giảm giá
                                                    </th>
                                                    <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Tên giảm giá
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Phần trăm giảm giá
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Số lượng giảm giá
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Ngày hết hạn
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Đang áp dụng
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Thao tác
                                                </th>

                                                </tr> <thead> <tbody>    ${
                                                    result.discounts ? result.discounts.map(discount => `<tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                                            ${discount.code}
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                                            ${discount.name}
                                                        </div>

                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                                            ${discount.discount}
                                                        </div>

                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                                            ${discount.amount}
                                                        </div>


                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                            ${new Date(result.discount.expired_at).toLocaleDateString('en-GB')}
                                                        </div>

                                                    </td>

                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                            ${discount.pivot.is_predefined ? '<span class="text-success">Áp dụng trực tiếp</span>' : '<span class="text-danger">Chưa áp dụng</span>'}
                                                        </div>

                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
        <div class="d-flex justify-content-center align-items-center gap-2"><form
                                                            method="POST" onsubmit="return confirmation(event, this)">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
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
                                                        <form
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit" class=" p-2 border rounded-pill bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                                                                Áp dụng
                                                                <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                </svg>
                                                            </button>
                                                        </form></div>

                                                    </td>
                                                </tr>`).join('') : ''
                                                };

                                            </tbody> <table> </td> <tr> `;

                    document.querySelector('tbody').appendChild(newRow);
                    document.querySelector('tbody').appendChild(
                        newRowDetail);

                    swal({
                        title: 'Thành công!',
                        text: result.message,
                        icon: 'success',
                        button: 'OK',
                        timer: 1000
                    });
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                    }
                }
            }
        });
    });


    // $('#categories').select2({

    //     theme: "bootstrap-5",
    //     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    //     placeholder: $(this).data('placeholder'),
    //     closeOnSelect: false,
    // });
</script>
