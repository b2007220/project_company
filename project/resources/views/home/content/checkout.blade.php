    <div class="container">
        <h2 class="fw-bold text-gray-900 d-flex justify-content-center text-uppercase py-3">
            Bảng thanh toán
        </h2>
        <hr class="h-px my-3 bg-gray-200" />
        <div class="row gap-3 mt-4">
            <div class="col-md-4 order-2 rounded bg-white p-3 shadow-md t-0-md w-13-md h-100 border-gray-300 border">
                <div class="mb-2 d-flex justify-content-between">
                    <p class="text-gray-700">Tiền sản phẩm</p>
                    <p class="text-gray-700">129.990 đồng</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-gray-700">Tiền phí ship</p>
                    <p class="text-gray-700">4.990 đồng</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-gray-700">Áp dụng phiếu giảm giá</p>
                    <p class="text-gray-700">0 đồng</p>
                </div>
                <hr class="my-4" />
                <div class="d-flex justify-content-between">
                    <p class="fs-5 fw-bold">Tổng tiền</p>
                    <div class="">
                        <p class="mb-1 fs-6 fw-bold">134.980 đồng</p>
                        <p class="small text-gray-700">Đã bao gồm VAT</p>
                    </div>
                </div>
            </div>

            <div class="col-md-7 order-1 rounded border px-5">
                <h4 class="my-3">Billing Form</h4>
                <div class="row">
                    <div class="col mb-4">
                        <label for="First name"> First Name </label>
                        <input type="text" class="form-control" placeholder="First name" aria-label="First name" />
                    </div>
                    <div class="col mb-4">
                        <label for="La\st name"> Last Name </label>
                        <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" />
                    </div>
                </div>

                <div class="input-group col mb-4">
                    <div class="input-group-text">@</div>
                    <input type="text" class="form-control" placeholder="Username" />
                </div>

                <div class="mb-4">
                    <label for="email">Email (optional)</label>
                    <input type="text" class="form-control" placeholder="you@example.com" aria-label="email" />
                </div>

                <div class="mb-4">
                    <label for="Address">Address</label>
                    <input type="text" class="form-control" placeholder="1234 Main St" aria-label="Address" />
                </div>

                <div class="mb-4">
                    <label for="Address2">Address 2 (optional)</label>
                    <input type="text" class="form-control" placeholder="Appartment or suite"
                        aria-label="Address2" />
                </div>

                <div class="row">
                    <div class="col">
                        <label for="country">Country</label>
                        <select class="form-select">
                            <option selected>Choose...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="state">State</label>
                        <select class="form-select">
                            <option selected>Choose...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="col mb-4">
                        <label for="zip">Zip Code</label>
                        <input type="text" class="form-control" aria-label="zip" />
                    </div>

                    <hr class="mb-4" />

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault">
                            Shipping address is the same as my billing address
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" />
                        <label class="form-check-label" for="flexCheckChecked">
                            Save this information for next time
                        </label>
                    </div>

                    <hr class="mb-4" />

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1"
                            checked />
                        <label class="form-check-label" for="flexRadioDefault1">
                            Credit card (Default)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                            id="flexRadioDefault2" />
                        <label class="form-check-label" for="flexRadioDefault2">
                            Debit card
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                            id="flexRadioDefault3" />
                        <label class="form-check-label" for="flexRadioDefault3">
                            Paypal
                        </label>
                    </div>

                    <div class="row">
                        <div class="col mb-4">
                            <label for="Card1"> Name on card </label>
                            <input type="text" class="form-control" aria-label="card1" />
                            <small class="text-muted">
                                Full name, as displayed on the card
                            </small>
                        </div>

                        <div class="col mb-4">
                            <label for="Card2"> Credit card Nummber </label>
                            <input type="text" class="form-control" placeholder="1234-5678-9012"
                                aria-label="Card2" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="Card3"> Expiry Date </label>
                            <input type="text" class="form-control" aria-label="card3" />
                        </div>

                        <div class="col mb-3">
                            <label for="Card4"> CVV </label>
                            <input type="text" class="form-control" aria-label="Card4" />
                        </div>
                    </div>
                </div>

                <hr class="mb-4" />

                <div class="d-grid gap-2 mb-4">
                    <button class="btn btn-primary btn-lg" type="button">
                        Thanh toán
                    </button>
                </div>
            </div>
        </div>
    </div>
