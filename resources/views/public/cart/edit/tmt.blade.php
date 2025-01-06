<div>
    <form action="#" method="post" id="updateTmt">
        <div class="form-row pt-3 pl-1 pr-1">

            <div class="form-group col-md-4">
                <select name="brand" id="" class="tmtBrand"
                    style="color: #262626;background-color: #ebebeb;border: 1px solid #ebebeb;height: 36px;padding: 7.5px 10px;font-size: 16px;line-height: 19px;width: -webkit-fill-available;">
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" data-price="{{ $brand->price }}"
                            {{ $cartProduct->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group col-md-4">
                <input type="text" name="weight" value="{{ $cartProduct->length * $tmtweight }}"
                    class="form-control" placeholder="Kgs">
            </div>


            <div class="form-group col-md-4">
                <input type="text" name="length" value="{{ $cartProduct->length }}" class="form-control"
                    placeholder="Length">
            </div>

            <div class="form-group col-md-4">
                <b> Price ₹<span class="price-value">{{ $price }}</span></b>
            </div>

            <div class="form-group col-md-4">

            </div>

            <div class="form-group col-md-4 text-lg-right ">
                <Button type="button" class="btn btn-dark" id="tmtUpdateBtn">Update</Button>
            </div>

        </div>
    </form>
</div>


{{-- $brands --}}
<script>
    (function() {
        const tmtWeight = {{ $tmtweight }};

        const updateTmt = document.querySelector('#updateTmt');
        const weightInput = updateTmt.querySelector('[name="weight"]');
        const lengthInput = updateTmt.querySelector('[name="length"]');
        const brand = updateTmt.querySelector('[name="brand"]');
        weightInput.addEventListener('keyup', tmtCalculation);
        lengthInput.addEventListener('keyup', tmtCalculation);
        console.log(weightInput)

        function tmtCalculation(e) {
            const brandPrice = brand.options[brand.selectedIndex].dataset.price;
            if (e.target.name == "weight") {
                const length = e.target.value / tmtWeight;
                updateTmt.querySelector('.price-value').innerText = (e.target.value * brandPrice).toFixed(2);
                updateTmt.querySelector('[name="length"]').value = length.toFixed(2);
            } else if (e.target.name == "length") {
                const weight = e.target.value * tmtWeight;
                updateTmt.querySelector('.price-value').innerText = (weight * brandPrice).toFixed(2);
                updateTmt.querySelector('[name="weight"]').value = weight.toFixed(2);
            }
        }

        brand.addEventListener('change', function(e) {
            const so = e.target.options[e.target.selectedIndex];
            updateTmt.querySelector('.price-value').innerText = (so.dataset.price * tmtWeight)
                .toFixed(2);
            weightInput.value = tmtWeight;
            lengthInput.value = 1;
        })


        const tmtUpdateBtn = document.getElementById('tmtUpdateBtn');

        tmtUpdateBtn.addEventListener('click', function() {
            update()
        })

        const update = async () => {
            const response = await axios({
                method: 'post',
                url: "update-to-cart/" + {{ $cartProduct->id }},
                data: {
                    weight: weightInput.value,
                    length: lengthInput.value,
                    brand_id: brand.value
                },
                headers: {
                    "Content-Type": "multipart/form-data",
                    "X-CSRF-TOKEN": csrfToken
                },
            });

            if (response.data.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: response.data.message,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                })
                location.reload()
            } else if (response.data.status == "error") {
                Swal.fire({
                    icon: 'error',
                    title: response.data.message,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                })
            }
        }

    })();
</script>
