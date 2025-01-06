@extends('console.layouts.app')
@section('content')
    <script>
        let ZZZ = {{ $attributes->count() }}
    </script>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Edit Product</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('console.home') }}" class="text-muted text-hover-primary">Home</a>
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
            <div id="kt_app_content_container" class="app-container">
                <form id="product_update_form" class="form d-flex flex-column flex-lg-row"
                    action="{{ route('console.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
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
                                        <select name="category_id" class="form-control form-control-solid" id="category"
                                            disabled>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4 mb-10 fv-row" id="subcat">
                                        <label class="form-label">Subcategory</label>
                                        <select name="subcategory_id" class="form-control form-control-solid" disabled>
                                            <option value="" disabled selected>Select Subcategory</option>
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}"
                                                    {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                                    {{ $subcategory->subcategory_name }}
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
                                            style="background-image: url('{{ asset('') }}storage/{{ $product->product_image }}')">
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
                                    </div>

                                    <div class="col-4 mb-10 fv-row productName">
                                        <label class="required form-label">Product Name</label>
                                        <input type="text" name="product_name" class="form-control mb-2"
                                            placeholder="Product Name" value="{{ $product->product_name }}" />
                                    </div>

                                    @php
                                        $product_brand = $product->brand
                                            ? explode(',', $product->brand)
                                            : ($product_brand = []);
                                    @endphp


                                    <div class="col-4 mb-10 fv-row" id="brand">
                                        <label class="form-label">Brands</label>
                                        <select class="form-select form-select-sm form-select-solid" data-control="select2"
                                            data-close-on-select="false" data-allow-clear="true" multiple="multiple"
                                            name="brand[]">
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ in_array($brand->id, $product_brand) ? 'selected' : '' }}>
                                                    {{ $brand->brand_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="col-4 mb-10 fv-row" id="dimension">
                                        <label class="form-label">Dimension</label>
                                        <input type="text" name="dimension" class="form-control mb-2"
                                            placeholder="Dimension" value="{{ $product->dimension }}" />
                                    </div>

                                    <div class="col-4 mb-10 fv-row" id="thicknesstmt">
                                        <label class="form-label">Thickness</label>
                                        <select name="thickness_id" class="form-control form-control-solid"
                                            id="tmtthickness">
                                            <option value="" selected>Select Thickness</option>
                                            @foreach ($tmtdetails as $tmt)
                                                <option value="{{ $tmt->id }}"
                                                    {{ $product->thickness_id == $tmt->id ? 'selected' : '' }}>
                                                    {{ $tmt->thickness }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4 mb-10 fv-row" id="tmtweight">
                                        <label class="form-label">TMT Weight</label>
                                        <input type="text" name="tmtweight" class="form-control mb-2"
                                            placeholder="TMT Weight" value="{{ $product->tmtweight }}" id="weighttmt"
                                            readonly />
                                    </div>


                                    <div class="col-4 mb-10 fv-row">
                                        <label class="form-label">Status</label>
                                        <select type="text" name="status" class="form-control mb-2">
                                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Block
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="alert text-danger">{{ $message }}</div>
                                        @enderror
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
                                <div>
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="product_attributes">
                                            <div>
                                                @foreach ($attributes as $attribute)
                                                    <div class="form-group row">
                                                        <input type="hidden"
                                                            name="product_attributes[{{ $loop->index }}][att_id]"
                                                            value="{{ $attribute->id }}">
                                                        <div class="col-2 mb-10 fv-row thickness">
                                                            <label class="form-label">Thickness</label>
                                                            <input type="text"
                                                                name="product_attributes[{{ $loop->index }}][thickness]"
                                                                class="form-control mb-2" placeholder="Thickness"
                                                                value="{{ $attribute->thickness }}" />
                                                        </div>

                                                        <div class="col-2 mb-10 fv-row roofthickness">
                                                            <label class="form-label">Thickness</label>
                                                            <input type="text"
                                                                name="product_attributes[{{ $loop->index }}][roof_thickness]"
                                                                class="form-control mb-2" placeholder="Thickness"
                                                                value="{{ $attribute->roof_thickness }}" />
                                                        </div>

                                                        <div class="col-2 mb-10 fv-row height">
                                                            <label class="form-label">Height (ft)</label>
                                                            <input type="text"
                                                                name="product_attributes[{{ $loop->index }}][height]"
                                                                class="form-control mb-2" placeholder="Height"
                                                                value="{{ $attribute->height }}" />
                                                        </div>

                                                        <div class="col-2 mb-10 fv-row weight">
                                                            <label class="form-label">Weight</label>
                                                            <input type="text"
                                                                name="product_attributes[{{ $loop->index }}][weight]"
                                                                class="form-control mb-2" placeholder="Weight"
                                                                value="{{ $attribute->weight }}" />
                                                        </div>

                                                        <div class="col-2 mb-10 fv-row price">
                                                            <label class="form-label">Price(+/-)</label>
                                                            <input type="text"
                                                                name="product_attributes[{{ $loop->index }}][price]"
                                                                class="form-control mb-2 attribute_price"
                                                                placeholder="Price" value="{{ $attribute->price }}" />
                                                        </div>


                                                        <div class="col-2 mb-10 fv-row price_kg">
                                                            <label class="form-label">Price/Kg</label>
                                                            <input type="text"
                                                                name="product_attributes[{{ $loop->index }}][price_kg]"
                                                                class="form-control mb-2" placeholder="Price/Kg"
                                                                value="{{ $attribute->price_kg }}" readonly />
                                                        </div>

                                                        <div class="col-md-2">
                                                            <a href="javascript:;" onclick="deletejj(this)"
                                                                class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                <i class="ki-duotone bi-trash3-fill fs-5"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span><span
                                                                        class="path3"></span><span
                                                                        class="path4"></span><span
                                                                        class="path5"></span></i>
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form group-->

                                </div>


                                <div id="product_attributes">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="product_attributes">
                                            <div data-repeater-item class="aaa">

                                                <div class="form-group row">
                                                    <input type="hidden" name="att_id" value="">
                                                    <div class="col-2 mb-10 fv-row thickness">
                                                        <label class="form-label">Thickness</label>
                                                        <input type="text" name="thickness" class="form-control mb-2"
                                                            placeholder="Thickness" value="" />
                                                    </div>

                                                    <div class="col-2 mb-10 fv-row roofthickness">
                                                        <label class="form-label">Thickness</label>
                                                        <input type="text" name="roof_thickness"
                                                            class="form-control mb-2" placeholder="Thickness"
                                                            value="" />
                                                    </div>

                                                    <div class="col-2 mb-10 fv-row height">
                                                        <label class="form-label">Height</label>
                                                        <input type="text" name="weight" class="form-control mb-2"
                                                            placeholder="Weight" value="" />
                                                    </div>

                                                    <div class="col-2 mb-10 fv-row weight">
                                                        <label class="form-label">Weight</label>
                                                        <input type="text" name="weight" class="form-control mb-2"
                                                            placeholder="Weight" value="" />
                                                    </div>

                                                    <div class="col-2 mb-10 fv-row price">
                                                        <label class="form-label">Price(+/-)</label>
                                                        <input type="text" name="price"
                                                            class="form-control attribute_price mb-2" placeholder="Price"
                                                            value="" />
                                                    </div>


                                                    <div class="col-2 mb-10 fv-row price_kg">
                                                        <label class="form-label">Price/Kg</label>
                                                        <input type="text" name="price_kg" class="form-control mb-2"
                                                            placeholder="Price/Kg" value="" readonly />
                                                    </div>

                                                    <div class="col-md-2">
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
                                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary"
                                            id="addbtn">
                                            <i class="ki-duotone bi-plus-lg fs-3"></i>
                                            Add
                                        </a>
                                    </div>
                                    <!--end::Form group-->
                                </div>
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
                                            placeholder="Seo Title" value="{{ $product->seo_title }}" />
                                    </div>

                                    <div class="col-6 mb-10 fv-row">
                                        <label class="form-label">Seo Keywords</label>
                                        <input type="text" name="seo_keyword" class="form-control mb-2"
                                            placeholder="Seo Keyword" value="{{ $product->seo_keyword }}" />
                                    </div>

                                    <div class="col-12 mb-10 fv-row">
                                        <label class="form-label">Seo Description</label>
                                        <textarea name="seo_description" class="form-control mb-2" placeholder="Seo Description">{{ $product->seo_description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('console.products.index') }}" id="kt_ecommerce_add_product_cancel"
                                class="btn btn-light me-5">Cancel</a>
                            <button id="product_submit" type="submit" class="btn btn-primary">
                                <span class="indicator-label">Save Changes</span>
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
    <script src="{{ asset('console/assets/steelghar/product/update.js') }}"></script>

    <script>
        $(document).ready(function() {

            catval = $("#category").val();
            if (catval === "1") {
                $("#brand").show();
                $(".roofthickness").hide();
                $("#dimension").hide();
                $("#thicknesstmt").show();
                $("#tmtweight").show();
                $("#steelattribute").hide();
                $("#subcat").hide();
                $(".height").hide();
            } else if (catval === '7') {
                $("#brand").hide();
                $("#dimension").hide();
                $(".roofthickness").hide();
                $("#thicknesstmt").hide();
                $("#tmtweight").hide();
                $("#steelattribute").show();
                $("#subcat").show();
                $(".thickness").hide();
                $(".height").show();
                $(".weight").hide();
                $(".price").hide();

                $('#product_attributes').repeater({
                    initEmpty: false,

                    defaultValues: {
                        'text-input': 'foo'
                    },

                    show: function() {
                        $(this).slideDown();

                        $("#brand").hide();
                        $("#dimension").hide();
                        $(".roofthickness").hide();
                        $("#thicknesstmt").hide();
                        $("#tmtweight").hide();
                        $("#steelattribute").show();
                        $("#subcat").show();
                        $(".thickness").hide();
                        $(".height").show();
                        $(".weight").hide();
                        $(".price").hide();
                    },

                    hide: function(deleteElement) {
                        $(this).slideUp(deleteElement);
                    }
                });
            } else if (catval === '9') {
                $("#brand").hide();
                $(".roofthickness").show();
                $("#dimension").hide();
                $("#thicknesstmt").hide();
                $("#tmtweight").hide();
                $("#steelattribute").show();
                $("#subcat").show();
                $(".thickness").hide();
                $(".height").hide();
                $(".weight").hide();
                $(".price").hide();
                placeholder.setAttribute("placeholder", "Color Name");
                var price = 0;

                $('#product_attributes').repeater({
                    initEmpty: false,

                    defaultValues: {
                        'text-input': 'foo'
                    },

                    show: function() {
                        $(this).slideDown();

                        $("#brand").hide();
                        $("#dimension").hide();
                        $(".roofthickness").show();
                        $("#thicknesstmt").hide();
                        $("#tmtweight").hide();
                        $("#steelattribute").show();
                        $("#subcat").show();
                        $(".thickness").hide();
                        $(".height").hide();
                        $(".weight").hide();
                        $(".price").hide();


                        $('.price_kg').children('input').val(price)

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

    <script>
        function deletejj(e) {
            // e.parentElement.parentElement.remove();
            console.log(e.parentElement)
        }
        $(document).ready(function() {

            const attribute_price = document.querySelectorAll('.attribute_price');
            attribute_price.forEach(element => {
                element.addEventListener('keyup', (e) => {
                    price(e.target)
                })
            });
        });
    </script>

    <script src="{{ asset('') }}console/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    {{-- <script>
        $('#product_attributes').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function(e) {
                $(this).slideDown();

                this.childNodes[1].childNodes[7].childNodes[3].addEventListener('keyup', (e) => {
                    price(e.target)
                });
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
                        parent.childNodes[9].childNodes[3].value = abc;
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
