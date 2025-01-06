@extends('console.layouts.app')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <script>
            let ZZZ = 0
        </script>
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Edit Product</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('public.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Edit Product</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">


                <div id="productForm">
                    <form action="{{ route('console.edit-tmt-product', ['product' => $product->id]) }}" method="post"
                        id="product-form">

                        @csrf

                        <div class="card mt-5 ">
                            <input type="hidden" name="category_id" value="1">
                            <div class="row g-6 g-xl-9 mt-5 p-5">
                                <div class="col-md-4 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Image</span>
                                    </label>
                                    <div class="image-input image-input-empty" data-kt-image-input="true" id="banner_img"
                                        style="background-image: url('{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('/console/assets/media/svg/files/blank-image.svg') }}')">
                                        <div class="image-input-wrapper stock-image w-175px h-125px"></div>
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Add Logo Image">
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
                                                <label for="exampleFormControlInput1" class="required form-label">Product
                                                    Name</label>
                                                <input type="text" name="product_name" class="form-control"
                                                    placeholder="Enter Product Name" value="{{ $product->product_name }}" />

                                                <span class="text-danger fw-bold error-text"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="required form-label">Product
                                                    Status</label>
                                                <select class="form-select" aria-label="Select example" name="status">
                                                    <option value="1" {{ $product->status ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0" {{ $product->status ? '' : 'selected' }}>Blocked
                                                    </option>
                                                </select>
                                                <span class="text-danger fw-bold error-text"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1"
                                                    class="required form-label">Thickness</label>
                                                <select class="form-select" aria-label="Select example" name="thickness_id"
                                                    id="thickness_id">

                                                    @foreach ($thicknesses as $thickness)
                                                        <option value="{{ $thickness->id }}"
                                                            {{ $product->thickness_id == $thickness->id ? 'selected' : '' }}>
                                                            {{ $thickness->thickness }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                <span class="text-danger fw-bold error-text"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-10">
                                                <label for="exampleFormControlInput1" class="form-label">Weight</label>
                                                <input type="text" name="tmtweight" value="{{ $weight }}" disabled
                                                    class="form-control " />
                                                <span class="text-danger fw-bold error-text"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" mt-4 mb-4">
                                    <label for="exampleFormControlInput1" class="required form-label">Select Brands</label>
                                    <select class="form-select form-select-sm form-select-solid" data-control="select2"
                                        data-close-on-select="false" data-placeholder="Select an option"
                                        data-allow-clear="true" multiple="multiple" name="brand[]">
                                        <option></option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ in_array($brand->id, $selectedBrands) ? 'selected' : '' }}>
                                                {{ $brand->brand_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger fw-bold error-text" id="brand-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-5 ">
                            <div class="row g-6 g-xl-9  p-5 pb-10">
                                <div class="col-md-6">
                                    <label class="form-label">SEO Title</label>
                                    <input type="text" class="form-control" name="seo_title"
                                        value="{{ $product->seo_title }}" placeholder="Enter SEO Title" />
                                    <span class="text-danger fw-bold error-text"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">SEO Keywords</label>
                                    <input type="text" class="form-control" name="seo_keyword"
                                        value="{{ $product->seo_keyword }}" placeholder="Enter SEO Keywords" />
                                    <span class="text-danger fw-bold error-text"></span>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">SEO Description</label>
                                    <textarea name="seo_description" class="form-control" cols="10" rows="4"
                                        placeholder="Enter SEO description">{{ $product->seo_description }}</textarea>
                                    <span class="text-danger fw-bold error-text"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark me-5" id="product-form-cancel">Cancel</button>

                                <button type="button" id="product-form-submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const thicknesses = @json($thicknesses)

        console.log(thicknesses)
        if (typeof window.ProductAdd === 'function') {
            delete window.ProductAdd;
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

                if (!form.thickness_id.value) {
                    form.thickness_id.setCustomValidity("error");
                    form.thickness_id.nextElementSibling.innerText = "thickness is required!";
                }


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

            form.thickness_id.addEventListener('change', function(e) {
                const weight = thicknesses.find(t => t.id == e.target.value);
                form.tmtweight.value = weight.weight + " Kg"
            })

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
    <script src="{{ asset('') }}console/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>

    <script>
        $('#product_attributes').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
    <script src="{{ asset('console/assets/steelghar/product/create.js') }}"></script>
    <script>
        const category_id = document.getElementById('category_id');
        const productForm = document.getElementById('productForm');
        const handleCategory = async (e) => {
            try {
                const params = new URLSearchParams({
                    category_id: e.target.value,
                });
                const response = await fetch(`/get-product-form?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        "Content-Type": "multipart/form-data",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json();
                console.log(data.form);
                productForm.innerHTML = data.form

                const scripts = productForm.querySelectorAll('script');

                console.log(scripts)
                scripts.forEach(script => {
                    const newScript = document.createElement('script');
                    newScript.text = script.textContent;
                    document.body.appendChild(newScript);
                });

            } catch (error) {
                console.error('There has been a problem with your fetch operation:', error);
            } finally {
                console.log('Fetch attempt finished');
            }
        }
        category_id.addEventListener("change", handleCategory);
    </script>
@endsection
