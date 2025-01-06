@extends('public.layouts.app')
@section('content')
    <div class="site__body">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Brands</h1>
                </div>
            </div>
        </div>
        <div class="block block-split">
            <div class="container">
                <div class="block-split__row no-gutters">
                    <div class="block-split__item block-split__item-content col-auto">
                        <div class="block">
                            <div class="categories-list categories-list--layout--columns-4-full">
                                <ul class="categories-list__body">
                                    @foreach ($brands as $brand)
                                        <li class="categories-list__item">
                                            <a href="#">
                                                <div class="image image--type--category">
                                                    <div class="image__body">
                                                        <img class="image__tag"
                                                            src="{{ asset('') }}storage/{{ $brand->logo }}"
                                                            alt="" />
                                                    </div>
                                                </div>
                                            </a>

                                        </li>
                                    @endforeach
                                    <li class="categories-list__divider"></li>

                                    <li class="categories-list__divider"></li>
                                </ul>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="block-space block-space--layout--before-footer"></div>
            </div>
        </div>
    </div>
@endsection
