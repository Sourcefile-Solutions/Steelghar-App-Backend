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
                        Add Roofing</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Add Roofing</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container ">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="roofing_add_form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('roofing.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Product Source</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-4 mb-10 fv-row">
                                        <label class="required form-label">Category</label>
                                        <select name="category_id" class="form-control form-control-solid" id="category">
                                            <option value="" disabled selected>Select Category</option>
                                            {{-- @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach --}}
                                            <option value="9">Roofing</option>
                                        </select>
                                    </div>

                                    <div class="col-4 mb-10 fv-row" id="subcat">
                                        <label class="form-label">Subcategory</label>
                                        <select name="subcategory_id" class="form-control form-control-solid"
                                            id="subcategory" disabled>
                                            <option value="" disabled selected>Select Subcategory</option>
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 fv-row">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Product Image</span>
                                        </label>
                                        <div class="image-input image-input-empty" data-kt-image-input="true" id="logo_img"
                                            style="background-image: url('{{ asset('') }}console/assets/media/svg/files/blank-image.svg')">
                                            <div class="image-input-wrapper stock-image w-175px h-125px"></div>
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="Add Logo Image">
                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                <input type="file" name="color_image" accept=".png, .jpg, .jpeg" />
                                            </label>

                                        </div>
                                        <div class="form-text">Allowed file types: png, jpg, jpeg, webp.</div>
                                    </div>

                                    <div class="col-4 mb-10 fv-row productName">
                                        <label class="required form-label">Product Name</label>
                                        <input type="text" name="color" class="form-control mb-2"
                                            placeholder="Product Name" value="{{ old('color') }}" />
                                    </div>


                                    <div class="col-4 mb-10 fv-row" id="brand">
                                        <label class="form-label">Brands</label>
                                        <select class="form-select form-select-sm form-select-solid" data-control="select2"
                                            data-close-on-select="false" data-placeholder="Select an option"
                                            data-allow-clear="true" multiple="multiple" name="brand[]">
                                            <option></option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4 mb-10 fv-row" id="dimension">
                                        <label class="form-label">Dimension</label>
                                        <input type="text" name="dimension" class="form-control mb-2"
                                            placeholder="Dimension" value="{{ old('dimension') }}" />
                                    </div>

                                    <div class="col-4 mb-10 fv-row">
                                        <label class="form-label">Status</label>
                                        <select type="text" name="status" class="form-control mb-2">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                        @error('status')
                                            <div class="alert text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-4 mb-10 fv-row" id="thicknesstmt">
                                        <label class="form-label">Thickness</label>
                                        <select name="thickness_id" class="form-control form-control-solid"
                                            id="tmtthickness">
                                            <option value="" disabled selected>Select Thickness</option>
                                            @foreach ($tmtdetails as $tmt)
                                                <option value="{{ $tmt->id }}">{{ $tmt->thickness }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4 mb-10 fv-row" id="tmtweight">
                                        <label class="form-label">Weight</label>
                                        <input type="text" name="tmtweight" class="form-control mb-2"
                                            placeholder="TMT Weight" value="{{ old('tmtweight') }}" readonly
                                            id="weighttmt" />
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Attributes</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">

                                <!--begin::Repeater-->
                                <div id="product_attributes">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="product_attributes">
                                            <div data-repeater-item>
                                                <div class="form-group row">

                                                    <div class="col mb-10 fv-row thickness">
                                                        <label class="form-label">Thickness</label>
                                                        <input type="text" name="thickness" class="form-control mb-2"
                                                            placeholder="Thickness" value="{{ old('thickness') }}" />
                                                    </div>

                                                    <div class="col mb-10 fv-row height">
                                                        <label class="form-label">Height (ft)</label>
                                                        <input type="text" name="height" class="form-control mb-2"
                                                            placeholder="Height" value="{{ old('height') }}" />
                                                    </div>

                                                    <div class="col-2 mb-10 fv-row weight">
                                                        <label class="form-label">Weight</label>
                                                        <input type="text" name="weight" class="form-control mb-2"
                                                            placeholder="Weight" value="{{ old('weight') }}" />
                                                    </div>

                                                    <div class="col mb-10 fv-row price">
                                                        <label class="form-label">Price(+/-)</label>
                                                        <input type="text" name="price" class="form-control mb-2"
                                                            placeholder="Price" value="" onkeyup="price(this)" />
                                                    </div>


                                                    <div class="col mb-10 fv-row price_kg">
                                                        <label class="form-label">Price/Kg</label>
                                                        <input type="text" name="price_kg" class="form-control mb-2"
                                                            placeholder="Price/Kg" value="20" readonly />
                                                    </div>
                                                    <div class="col">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="ki-duotone bi-trash3-fill fs-5"><span
                                                                    class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
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
                                    <div class="form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                            <i class="ki-duotone bi-plus-lg fs-3"></i>
                                            Add
                                        </a>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                                <!--end::Repeater-->

                            </div>
                        </div>
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Product SEO</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-6 mb-10 fv-row">
                                        <label class="form-label">Seo Title</label>
                                        <input type="text" name="seo_title" class="form-control mb-2"
                                            placeholder="Seo Title" value="{{ old('seo_title') }}" />
                                    </div>

                                    <div class="col-6 mb-10 fv-row">
                                        <label class="form-label">Seo Keywords</label>
                                        <input type="text" name="seo_keyword" class="form-control mb-2"
                                            placeholder="Seo Keyword" value="{{ old('seo_keyword') }}" />
                                    </div>

                                    <div class="col-12 mb-10 fv-row">
                                        <label class="form-label">Seo Description</label>
                                        <textarea name="seo_description" class="form-control mb-2" placeholder="Seo Description">{{ old('seo_description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('products.index') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <button id="product_submit" type="submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('console/assets/steelghar/roofing/create.js') }}"></script>

    <script>
        $(document).ready(function() {

            const productName = document.querySelector(".productName");
            const label = productName.childNodes[1];
            const placeholder = productName.childNodes[3];


            $("#brand").hide();
            $("#thicknesstmt").hide();
            $("#tmtweight").hide();
            $("#dimension").show();
            $("#steelattribute").show();
            $("#subcat").show();
            $("#category").change(function() {
                if ($(this).val() === '1') {
                    $("#brand").show();
                    $("#dimension").hide();
                    $("#thicknesstmt").show();
                    $("#tmtweight").show();
                    $("#steelattribute").hide();
                    $("#subcat").hide();
                    $(".height").hide();

                    label.textContent = "Product Name";
                    placeholder.setAttribute("placeholder", "Product Name");
                } else if ($(this).val() === '7') {
                    $("#brand").hide();
                    $("#dimension").hide();
                    $("#thicknesstmt").hide();
                    $("#tmtweight").hide();
                    $("#steelattribute").show();
                    $("#subcat").show();
                    $(".thickness").hide();
                    $(".height").show();
                    $(".weight").hide();
                    $(".price").hide();

                    var price = 0;
                    label.textContent = "Product Name";
                    placeholder.setAttribute("placeholder", "Product Name");


                    axios.get('/api/pricing')
                        .then(
                            function(response) {
                                price = response.data;
                                $('.price_kg').children('input').val(price)
                            }
                        );

                    // console.log()

                    $('#product_attributes').repeater({
                        initEmpty: false,

                        defaultValues: {
                            'text-input': 'foo'
                        },

                        show: function() {
                            $(this).slideDown();

                            $("#brand").hide();
                            $("#dimension").hide();
                            $("#thicknesstmt").hide();
                            $("#tmtweight").hide();
                            $("#steelattribute").show();
                            $("#subcat").show();
                            $(".thickness").hide();
                            $(".height").show();
                            $(".weight").hide();
                            $(".price").hide();


                            $('.price_kg').children('input').val(price)

                        },

                        hide: function(deleteElement) {
                            $(this).slideUp(deleteElement);
                        }
                    });


                } else if ($(this).val() === '9') {
                    $('[data-repeater-item]').slice(1).remove();
                    $("#brand").hide();
                    $("#dimension").hide();
                    $("#thicknesstmt").hide();
                    $("#tmtweight").hide();
                    $("#steelattribute").show();
                    $("#subcat").show();
                    $(".thickness").show();
                    $(".height").hide();
                    $(".weight").hide();
                    $(".price").hide();

                    label.textContent = "Color Name";
                    placeholder.setAttribute("placeholder", "Color Name");
                    var price = 0;

                    // axios.get('/api/pricing')
                    //     .then(
                    //         function(response) {
                    //             price = response.data;
                    //             $('.price_kg').children('input').val(price)
                    //         }
                    //     );


                    $('#product_attributes').repeater({
                        initEmpty: false,

                        defaultValues: {
                            'text-input': 'foo'
                        },

                        show: function() {
                            $(this).slideDown();

                            $("#brand").hide();
                            $("#dimension").hide();
                            $("#thicknesstmt").hide();
                            $("#tmtweight").hide();
                            $("#steelattribute").show();
                            $("#subcat").show();
                            $(".thickness").show();
                            $(".height").hide();
                            $(".weight").hide();
                            $(".price").hide();

                        },

                        hide: function(deleteElement) {
                            $(this).slideUp(deleteElement);
                        }
                    });
                } else {
                    $("#brand").hide();
                    $("#dimension").show();
                    $("#thicknesstmt").hide();
                    $("#tmtweight").hide();
                    $("#steelattribute").show();
                    $("#subcat").show();
                    $(".height").hide();
                    $(".thickness").show();
                    $(".weight").show();
                    $(".price").show();

                    label.textContent = "Product Name";
                    placeholder.setAttribute("placeholder", "Product Name");

                    $('#product_attributes').repeater({
                        initEmpty: false,

                        defaultValues: {
                            'text-input': 'foo'
                        },

                        show: function() {
                            $(this).slideDown();

                            $("#brand").hide();
                            $("#dimension").show();
                            $("#thicknesstmt").hide();
                            $("#tmtweight").hide();
                            $("#steelattribute").show();
                            $("#subcat").show();
                            $(".height").hide();
                            $(".thickness").show();
                            $(".weight").show();
                            $(".price").show();
                        },

                        hide: function(deleteElement) {
                            $(this).slideUp(deleteElement);
                        }
                    });
                }
            });

            const tmtthickness = document.getElementById("tmtthickness")

            tmtthickness.addEventListener('change', function(e) {
                // console.log(e.target.value);
                $.ajax({
                    type: "get",
                    url: BASE_URL + "/tmtweight/" + e.target.value,
                    success: function(response) {
                        $('#weighttmt').val(response);
                    }
                });
            })
        });
    </script>
    <script src="{{ asset('') }}console/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    {{-- <script>
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
    </script> --}}
    <script>
        function price(e) {
            let selectElement = document.getElementById('category');
            var selectedOption = selectElement.options[selectElement.selectedIndex]
            var selectedValue = selectedOption.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/demo1/console/get-base-price/' + selectedValue, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        var basePrice = response.basePrice;

                        const parent = e.parentElement.parentElement;
                        abc = Number(basePrice) + Number(e.value);
                        parent.childNodes[7].childNodes[3].value = abc;
                    } else {
                        // Handle error if any
                        console.error('Failed to fetch base price.');
                    }
                }
            };

            xhr.send();
        }
    </script>
@endsection
