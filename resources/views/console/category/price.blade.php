@extends('console.layouts.app')
@section('title', 'Category Prices')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 g-xl-10 mt-1">
                    <div class="col-md-12 mb-md-12">
                        <div class="row g-5 g-xl-12">
                            @php
                                function isLight($color)
                                {
                                    $r = hexdec(substr($color, 1, 2));
                                    $g = hexdec(substr($color, 3, 2));
                                    $b = hexdec(substr($color, 5, 2));

                                    $luminance = (0.2126 * $r + 0.7152 * $g + 0.0722 * $b) / 255;

                                    return $luminance > 0.5;
                                }
                            @endphp

                            @foreach ($prices as $price)
                                @php
                                    $randomColor = '#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0', STR_PAD_LEFT);

                                    $textColor = isLight($randomColor) ? 'text-dark' : 'text-white';
                                @endphp

                                <div class="col-md-6 col-xl-4 mb-xxl-10">
                                    <div class="card overflow-hidden mb-5" style="background: {{ $randomColor }};">
                                        <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                            <div class="mb-4 px-9">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="fs-1 fw-bold {{ $textColor }} me-2 lh-1"
                                                        data-kt-countup="true" data-kt-countup-value="{{ $price->price }}"
                                                        data-kt-countup-prefix="₹"
                                                        data-kt-countup-suffix=".00">{{ $price->price }}</span>
                                                </div>
                                                <span
                                                    class="fs-6 fw-semibold {{ $textColor }}">{{ $price->category_name }}</span>
                                                <span class="float-end">
                                                    <i class="bi bi-pencil-square fs-2 {{ $textColor }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_{{ $price->id }}"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @foreach ($prices as $price)
        <div class="modal fade" id="modal_{{ $price->id }}" tabindex="-1"
            aria-labelledby="modal_{{ $price->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_{{ $price->id }}Label">{{ $price->category_name }} Pricing
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form"
                        action="{{ route('console.category-prices.update', ['category_price' => $price->id]) }}"
                        method="POST" id="priceForm">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <input type="text" name="price" class="form-control"
                                placeholder="Enter {{ $price->category_name }} price" value="{{ $price->price }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert library -->
    <script>
        $(document).ready(function() {
            $('#priceForm').on('submit', function(event) {
                event.preventDefault();

                var form = $(this);
                var formData = form.serialize();
                $.ajax({

                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(88)
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while processing your request. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script> --}}
@endsection
