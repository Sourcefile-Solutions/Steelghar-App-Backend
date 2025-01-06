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
                        Add Product</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('public.home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Add Product</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">


                <div id="productForm">
                    @include('console.product.roof.create')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
        // category_id.addEventListener("change", handleCategory);
    </script>
@endsection
