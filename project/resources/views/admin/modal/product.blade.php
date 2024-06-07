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
        var method = this.querySelector('input[name="_method"]') ? 'PUT' : 'POST';


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(Object.fromEntries(formData.entries())),
            dataType: 'json',
            processData: false,
            contentType: 'application/json',
            cache: false,
            success: function(result) {
                const product = result.product;
                const discounts = result.discounts;

                let total_discount = 0;
                if (discounts && discounts.length > 0 && discounts.some(discount => discount.pivot
                        .is_predefined)) {
                    discounts.forEach(discount => {
                        if (discount.pivot.is_predefined) {
                            total_discount += discount.discount;
                        }
                    });
                    $price = product.price - (product.price * total_discount) / 100;
                }
                $('#addProductModal').modal('hide');
                content = `
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
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center product-price">
                                            ${result.discounts && result.discounts.length > 0 ?
                                                result.discounts.map(discount => discount.is_predefined ?
                                                `<span>
                                                    ${price.toLocaleString('en-US')} đ
                                                </span>` :'').join('') :
                                                `<span>  ${result.product.price.toLocaleString('en-US')} đ
                                                </span>`
                                            }
                                        </div>
                                    </td>
                                    <td class ="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                        <div class ="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            ${Number(result.product.amount).toLocaleString('de-DE')}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 ">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
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
                                            </div>

                                    </td>`;
                if (method === 'PUT') {
                    const row = document.querySelector(
                        `tr[data-product-id="${result.product.id}"]`);
                    if (row) {
                        row.innerHTML = content;
                    }
                } else if (method === 'POST') {
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-product-id', result.product
                        .id);
                    newRow.setAttribute('data-bs-toggle', 'collapse');
                    newRow.setAttribute('data-bs-target', `.detail-${result.product.id} `);
                    newRow.innerHTML = content;
                    document.querySelector('tbody').appendChild(newRow);
                    console.log(newRow);
                }
                const images = document.getElementById("images").files;
                const imageFormData = new FormData();
                for (let i = 0; i < images.length; i++) {
                    imageFormData.append('images[]', images[i]);
                }
                $.ajax({
                    url: 'product/' + result.product.id + '/upload-images',
                    type: 'POST',
                    data: imageFormData,
                    processData: false,
                    enctype: 'multipart/form-data',
                    contentType: false,
                    success: function(fileResponse) {
                        pictureContent = `<td colspan = "7">
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
                                            <form action="javascript:void(0)" enctype="multipart/form-data" id="deletePictureForm"
                        onsubmit="deleteImages(event, ${ result.product.id })">
                                                <input type = "hidden"
                                                name = "selected_pictures"
                                                id = "selected_pictures">
                                                <div class="d-flex align-items-center px-6 gap-4 flex-column-max-lg" id="pictures-container">
                                                    <div id="similarProduct-${result.product.id}" class="carousel carousel-dark slide w-100 max-w-1516" data-bs-ride="false">
                                                        <div class="carousel-inner">
                                                            ${fileResponse.pictures && fileResponse.pictures.length > 0 ? `
                                                                <button class="carousel-control-prev z-2 justify-content-start" type="button" data-bs-target="#similarProduct-${result.product.id}" data-bs-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                </button>
                                                                <button class="carousel-control-next z-2 justify-content-end" type="button" data-bs-target="#similarProduct-${result.product.id}" data-bs-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                </button>
                                                            ` : ''}
                                                        </div>
                                                    </div>
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
                                                    d = "M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                </button>
                                            </div>`
                        console.log('File uploaded:', fileResponse);
                        if (method === 'PUT') {
                            const detailRow = document.querySelector(
                                `tr.detail-${result.product.id}.collapse`);
                            detailRow.innerHTML = pictureContent + `
                                        <table class = "w-100"  id="discount-table">
                                            <thead>
                                                <tr data-pivot-id="${result.pivot.id}">
                                                    <th class ="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50  text-center">
                                                        Code giảm giá
                                                    </th>
                                                    <th class ="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                                                        Tên giảm giá
                                                    </th>
                                                    <th class = "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                                                        Phần trăm giảm giá
                                                    </th>
                                                <th
                                            class ="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Số lượng giảm giá

                                            </th>
                                            <th class ="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Ngày hết hạn
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Đang áp dụng
                                                </th> <th
                                            class =
                                            "px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">Thao tác
                                                </th>

                                                </tr> <thead> <tbody>    ${result.discounts ? result.discounts.map(discount => `<tr>
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

                                                            ${Number(discount.amount).toLocaleString('de-DE')}
                                                        </div>


                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                                        <div
                                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                            ${new Date(discount.expired_at).toLocaleDateString('en-GB')}
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
                                                        class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 ">
        <div class="d-flex justify-content-center align-items-center gap-2">
   <form action="javascript:void(0)" enctype="multipart/form-data" id="removeDiscountForm-${result.pivot_id}m"
                            onsubmit="removeDiscount(event, ${productId},${discount.id},${result.pivot.id})>

                                                            <button type="submit" form="removeDiscountForm-${result.pivot_id}"
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
                                                <form action="javascript:void(0)" enctype="multipart/form-data" id="applyDiscountForm-${result.pivot_id}"
                            onsubmit="apply(event, ${productId},${discount.id},${result.pivot.id})>
                                                            <button type="submit"  form="applyDiscountForm-${result.pivot_id}"
                                                            class=" p-2 border rounded-pill bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
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
                                                }

                                            </tbody> <table> </td> <tr> `;
                        } else if (method === 'POST') {
                            const newRowDetail = document.createElement('tr');
                            newRowDetail.classList.add(
                                `detail-${result.product.id}`);
                            newRowDetail.classList.add(`collapse`);
                            newRowDetail.innerHTML = pictureContent;

                            document.querySelector('tbody').appendChild(
                                newRowDetail);

                        }
                        const carouselInner = document.querySelector(
                            `#similarProduct-${result.product.id} .carousel-inner`
                        );
                        if (fileResponse.pictures && fileResponse.pictures.length >
                            0) {
                            carouselInner.innerHTML = fileResponse.pictures.reduce((
                                acc, picture, index) => {
                                if (index % 3 === 0) acc.push([]);
                                acc[acc.length - 1].push(picture);
                                return acc;
                            }, []).map((chunk, chunkIndex) =>
                                `<div class="carousel-item ${chunkIndex === 0 ? 'active' : ''}">
                                                <div class="card-group justify-content-evenly">
                                                    ${chunk.map(picture => `
                                                        <div class="border rounded border-gray-300 picture-item" data-id="${picture.id}">
                                                            <img class="img-fluid custom-img rounded" src="/product/${picture.link}" alt="">
                                                        </div>
                                                    `).join('')}
                                                </div>
                                        </div>`).join('');
                        }
                    },
                    error: function(fileError) {
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (const [key, value] of Object.entries(errors)) {
                                console.log(key, value);
                            }
                        }
                    }
                });
                swal({
                    title: 'Thành công!',
                    text: result.message,
                    icon: 'success',
                    button: 'OK',
                    timer: 1000
                });
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
</script>
