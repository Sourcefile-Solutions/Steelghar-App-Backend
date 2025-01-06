<form action="{{ route('console.products.roof.store') }}" method="post" id="product-form">
    @csrf
    <div class="card mt-5 ">
        <input type="hidden" name="category_id" value="3">
        <div class="row g-6 g-xl-9 mt-5 p-5">
            <div class="col-md-4 fv-row">
                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                    <span class="required">Image</span>
                </label>
                <div class="image-input image-input-empty" data-kt-image-input="true" id="banner_img"
                    style="background-image: url('/console/assets/media/svg/files/blank-image.svg')">
                    <div class="image-input-wrapper stock-image w-175px h-125px"></div>
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Add Logo Image">
                        <i class="bi bi-pencil-fill fs-7"></i>
                        <input type="file" name="product_image" accept=".png, .jpg, .jpeg" />
                    </label>

                </div>
                <div class="form-text">Allowed file types: png, jpg, jpeg, webp.</div>
                <span class="text-danger fw-bold error-text" id="img-error"></span>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control"
                                placeholder="Enter Product Name" />

                            <span class="text-danger fw-bold error-text"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Product Status</label>
                            <select class="form-select" aria-label="Select example" name="status">
                                <option value="1">Active</option>
                                <option value="0">Blocked</option>
                            </select>
                            <span class="text-danger fw-bold error-text"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="card card-flush py-4 mt-5">
        <div class="card-header">
            <div class="card-title">
                <h2>Attributes</h2>
            </div>
        </div>
        <div class="card-body pt-0">

            <div id="product_attributes">

                <div class="form-group mt-5">
                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                        <i class="ki-duotone ki-plus fs-3"></i>
                        Add
                    </a>
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                    <div data-repeater-list="product_attributes">
                        <div data-repeater-item>
                            <div class="form-group row">

                                <div class="col-md-3">
                                    <label class="form-label">Thickness</label>
                                    <select name="thickness" id="" class="form-control mb-2 mb-md-0">
                                        <option value="">Select Thickness</option>
                                        @foreach ($roofThickness as $thickness)
                                            <option value="{{ $thickness->id }}">{{ $thickness->thickness }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Price(+/-)</label>
                                    <input type="text" name="price" class="form-control mb-2 mb-md-0"
                                        placeholder="Enter price" value="" onkeyup="price(this)" />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Pric/Kg</label>
                                    <input type="text" name="kg" class="form-control mb-2 mb-md-0"
                                        placeholder="Enter Pric/Kg" value=" {{ $roofPrice }}" disabled />
                                </div>

                                <div class="col-md-3">
                                    <a href="javascript:;" data-repeater-delete
                                        class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                        <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span></i>
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Form group-->

                <!--begin::Form group-->

                <!--end::Form group-->
            </div>

        </div>
    </div>

    <div class="card mt-5 ">
        <div class="row g-6 g-xl-9  p-5 pb-10">
            <div class="col-md-6">
                <label class="form-label">SEO Title</label>
                <input type="text" class="form-control" name="seo_title" placeholder="Enter SEO Title" />
                <span class="text-danger fw-bold error-text"></span>
            </div>
            <div class="col-md-6">
                <label class="form-label">SEO Keywords</label>
                <input type="text" class="form-control" name="seo_keyword" placeholder="Enter SEO Keywords" />
                <span class="text-danger fw-bold error-text"></span>
            </div>
            <div class="col-md-12">
                <label class="form-label">SEO Description</label>
                <textarea name="seo_description" class="form-control" cols="10" rows="4"
                    placeholder="Enter SEO description"></textarea>
                <span class="text-danger fw-bold error-text"></span>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="modal-footer">
            <button type="button" class="btn btn-dark me-5" id="product-form-cancel">Cancel</button>

            <button type="button" class="btn btn-primary" id="product-form-submit">
                <span class="indicator-label">Update</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
</form>


<script>
    if (typeof window.ProductAdd === 'function') {
        delete window.ProductAdd;
    }



    const roofPrice = {{ $roofPrice }}
    let newPrice;

    function price(e) {
        const parent = e.parentElement.parentElement;
        if (isFinite(e.value)) newPrice = Number(roofPrice) + Number(e.value);
        else newPrice = roofPrice;
        parent.childNodes[5].childNodes[3].value = newPrice
    }

    function ProductAdd() {


        const form = document.querySelector("#product-form"),
            submitBtn = document.getElementById("product-form-submit"),
            cancelBtn = document.getElementById("product-form-cancel");

        const field = Array.from(form.elements);

        const errorText = document.querySelectorAll(".error-text")


        function validateForm(e) {
            field.forEach((i) => {
                i.setCustomValidity("");
                i.classList.remove("is-invalid");
            });
            errorText.forEach(e => {
                e.innerText = ''
            });

            if (!form.product_name.value) {
                form.product_name.setCustomValidity("error");
                form.product_name.nextElementSibling.innerText =
                    "product name number is required!";
            }

            // if (!form.product_image.value) {
            //     form.product_image.setCustomValidity("error");
            //     document.getElementById("img-error").innerText = "product image is required!";
            // }

            // if (!form.thickness_id.value) {
            //     form.thickness_id.setCustomValidity("error");
            //     form.thickness_id.nextElementSibling.innerText = "thickness is required!";
            // }


            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopImmediatePropagation();
                field.forEach((i) => {
                    if (!i.checkValidity()) {
                        i.classList.add("is-invalid");
                    }
                });
            }
        }

        // form.thickness_id.addEventListener('change', function(e) {
        //     const weight = thicknesses.find(t => t.id == e.target.value);
        //     form.tmtweight.value = weight.weight + " Kg"
        // })

        submitBtn.addEventListener("click", validateForm);

        submitBtn.addEventListener("click", function(e) {



                e.preventDefault();
                submitBtn.setAttribute("data-kt-indicator", "on")
                submitBtn.disabled = !0
                axios.post(form.getAttribute('action'), new FormData(form))
                    .then(function(response) {
                        if (response.data.status == "success") {
                            Swal.fire({
                                title: response.data.title,
                                text: response.data.message,
                                icon: response.data.status,
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                                // footer: "<span>By clicking View Lead navigate to this lead's view page</span>",
                                allowOutsideClick: () => false
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    location.href = '/products';
                                }
                            })



                        }

                    })
                    .catch(function(error) {
                        if (error.response.status === 422) {
                            let dataMessage = error.response.data.message;
                            let dataErrors = error.response.data.errors;
                            for (const errorsKey in dataErrors) {
                                if (!dataErrors.hasOwnProperty(errorsKey)) continue;

                                if (errorsKey == "product_image") document.getElementById(
                                    "img-error").innerText = dataErrors[errorsKey]
                                else if (errorsKey == "brand") document.getElementById(
                                    "brand-error").innerText = dataErrors[errorsKey]

                                else {
                                    form.elements[errorsKey].classList.add("is-invalid");
                                    form.elements[errorsKey].nextElementSibling.innerText = dataErrors[
                                        errorsKey];
                                }
                            }
                        }
                    })
                    .then(function() {
                        submitBtn.removeAttribute('data-kt-indicator');
                        submitBtn.disabled = false;
                    });


            }),

            cancelBtn.addEventListener("click", function(t) {
                t.preventDefault(),
                    Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        },
                    }).then(function(t) {
                        t.value ?
                            (form.reset(), field.forEach((i) => {
                                i.setCustomValidity("");
                                i.classList.remove("is-invalid");
                            })) :
                            "cancel" === submitBtn.dismiss && Swal.fire({
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                    });
            })


        return {
            init: function() {

            }
        }
    };
    ProductAdd()
</script>
