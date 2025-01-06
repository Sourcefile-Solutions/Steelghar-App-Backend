<div class="product-card" data-weight="{{ $product->weight }}">

    <div class="product-card__image">
        <div class="image image--type--product">
            <a class="image__body"><img class="image__tag" src="{{ asset('') }}storage/{{ $product->product_image }}"
                    alt="" /></a>
        </div>
    </div>

    <div class="product-card__info px-2">

        <div class="product-card__name py-2">
            <div class="font-weight-bold">
                <span>{{ $product->product_name }}</span>
            </div>

        </div>
        <small class="mx-3 badge bg-warning">Starts From :
            ₹{{ $product->price_start }}</small>

        <div class="pt-3 pr-2  pl-2">
            <small class="font-weight-bold ">Brand</small>
            <div class="d-flex ">
                <div class="select">

                    <select name="brand" class="border rounded brand tmtBrand">
                        <option selected disabled value="">Choose
                            a Brand</option>
                        @foreach ($product->brands as $brand)
                            <option value="{{ $brand->id }}" data-price="{{ $brand->price }}"
                                data-tmtweight="{{ $product->weight }}">
                                {{ $brand->brand_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>




        <div class="form-row pt-3 pl-1 pr-1">
            <div class="form-group col-md-6">
                <small class="font-weight-bold ">Weight</small>
                <input type="text" name="weight" value="{{ $product->weight }}" class="form-control"
                    placeholder="Kgs" disabled>
            </div>
            <div class="form-group col-md-6">
                <small class="font-weight-bold ">Length</small>
                <input type="text" name="length" value="1" class="form-control" placeholder="Length" disabled>
            </div>
        </div>

    </div>


    <div class="product-card__footer px-2">


        <div class="product-card__prices">
            <small class="text-danger price-tag">~ Price</small><br>
            <div class="product-card__price product-card__price--current tmt_price ml-3">
                ₹<span class="price-value">{{ $product->price_start }}</span>
            </div>
        </div>



        <button class="product-card__addtocart-icon" type="button" aria-label="Add to cart"
            onclick="addtocart(this,{{ json_encode($product) }})">
            <svg width="20" height="20">
                <circle cx="7" cy="17" r="2" />
                <circle cx="15" cy="17" r="2" />
                <path
                    d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z" />
            </svg>
        </button>
        <button class="product-card__addtocart-full" type="button">
            Add to cart
        </button>




        <button class="product-card__wishlist" type="button">
            <svg width="16" height="16">
                <path
                    d="M13.9,8.4l-5.4,5.4c-0.3,0.3-0.7,0.3-1,0L2.1,8.4c-1.5-1.5-1.5-3.8,0-5.3C2.8,2.4,3.8,2,4.8,2s1.9,0.4,2.6,1.1L8,3.7l0.6-0.6C9.3,2.4,10.3,2,11.3,2c1,0,1.9,0.4,2.6,1.1C15.4,4.6,15.4,6.9,13.9,8.4z" />
            </svg>
            <span>Add to wishlist</span>
        </button>
        <button class="product-card__compare" type="button">
            <svg width="16" height="16">
                <path d="M9,15H7c-0.6,0-1-0.4-1-1V2c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v12C10,14.6,9.6,15,9,15z" />
                <path d="M1,9h2c0.6,0,1,0.4,1,1v4c0,0.6-0.4,1-1,1H1c-0.6,0-1-0.4-1-1v-4C0,9.4,0.4,9,1,9z" />
                <path d="M15,5h-2c-0.6,0-1,0.4-1,1v8c0,0.6,0.4,1,1,1h2c0.6,0,1-0.4,1-1V6C16,5.4,15.6,5,15,5z" />
            </svg>
            <span>Add to compare</span>
        </button>
    </div>

</div>



<script>
    var tmtBrand = document.querySelectorAll('.tmtBrand');


    function tmtCalculation(e) {
        var productCard = e.target.closest('.product-card');
        var tmtWeight = productCard.dataset.weight;
        var brand = productCard.querySelector('[name="brand"]');
        var brandPrice = brand.options[brand.selectedIndex].dataset.price;
        if (e.target.name == "weight") {
            var length = e.target.value / tmtWeight;
            productCard.querySelector('.price-value').innerText = (e.target.value * brandPrice).toFixed(2);
            productCard.querySelector('[name="length"]').value = length.toFixed(2);
        } else if (e.target.name == "length") {
            var weight = e.target.value * tmtWeight;
            productCard.querySelector('.price-value').innerText = (weight * brandPrice).toFixed(2);
            productCard.querySelector('[name="weight"]').value = weight.toFixed(2);
        }
    }

    tmtBrand.forEach(element => {
        element.addEventListener('change', function(e) {
            var so = e.target.options[e.target.selectedIndex];
            var productCard = e.target.closest('.product-card');
            productCard.querySelector('.price-value').innerText =
                (so.dataset.price * so.dataset.tmtweight).toFixed(2);
            var weightInput = productCard.querySelector('[name="weight"]');
            weightInput.value = so.dataset.tmtweight;
            weightInput.disabled = false;
            weightInput.addEventListener('keyup', tmtCalculation);
            var lengthInput = productCard.querySelector('[name="length"]');
            lengthInput.disabled = false;
            lengthInput.addEventListener('keyup', tmtCalculation);
        })
    })
    var cartWebCount = document.getElementById('cartWebCount');
    var cartMobCount = document.getElementById('cartMobCount');
</script>
