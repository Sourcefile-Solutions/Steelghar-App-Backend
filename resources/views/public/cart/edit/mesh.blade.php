<div>
    <form action="#" method="post" id="updateMesh">
        <div class="form-row pt-3 pl-1 pr-1">

            <div class="form-group col-md-4">

                <select name="product_attribute_id" class="brand meshHeight"
                    style="color: #262626;background-color: #ebebeb;border: 1px solid #ebebeb;height: 36px;padding: 7.5px 10px;font-size: 16px;line-height: 19px;width: -webkit-fill-available;">
                    @foreach ($attributes as $attribute)
                        <option value="{{ $attribute->id }}" data-height="{{ $attribute->height }}"
                            data-price="{{ $attribute->price }}"
                            {{ $cartProduct->product_attribute_id == $attribute->id ? 'selected' : '' }}>
                            {{ $attribute->height }} ft</option>
                    @endforeach
                </select>

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
            <div class="form-group col-md-4">

            </div>
            <div class="form-group col-md-4 text-lg-right ">
                <Button type="button" class="btn btn-dark" id="meshUpdateBtn">Update</Button>
            </div>

        </div>
    </form>
</div>


{{-- $brands --}}
<script>
    (function() {
        const categoryPrice = {{ $categoryPrice }};
        const updateMesh = document.querySelector('#updateMesh');
        const attributeInput = updateMesh.querySelector('[name="product_attribute_id"]');
        const lengthInput = updateMesh.querySelector('[name="length"]');
        lengthInput.addEventListener('keyup', meshCalculation);

        function meshCalculation(e) {
            const height = attributeInput.options[attributeInput.selectedIndex].dataset.height;
            const heightPrice = attributeInput.options[attributeInput.selectedIndex].dataset.price;
            updateMesh.querySelector('.price-value').innerText =
                ((categoryPrice + Number(heightPrice)) * height * e.target.value).toFixed(2);
        }
        attributeInput.addEventListener('change', function(e) {
            const so = e.target.options[e.target.selectedIndex];
            updateMesh.querySelector('.price-value').innerText = ((Number(categoryPrice) + Number(so.dataset
                .price)) * Number(so
                .dataset.height)).toFixed(2)
            lengthInput.value = 1;
        })




        const meshUpdateBtn = document.getElementById('meshUpdateBtn');

        meshUpdateBtn.addEventListener('click', function() {
            update()
        })

        const update = async () => {
            const response = await axios({
                method: 'post',
                url: "update-to-cart/" + {{ $cartProduct->id }},
                data: {
                    length: lengthInput.value,
                    product_attribute_id: attributeInput.value
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
