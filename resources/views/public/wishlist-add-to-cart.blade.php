<div class="">

    @if ($product->category_id == 1)
        @include('public.products.wishlist.tmt-product')
    @elseif ($product->category_id == 2)
        @include('public.products.wishlist.mesh-product')
    @elseif ($product->category_id == 3)
        @include('public.products.wishlist.roofing-product')
    @else
        @include('public.products.wishlist.other-product')
    @endif

</div>
