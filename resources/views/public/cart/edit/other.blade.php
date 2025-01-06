<div>
    <form action="#" method="post" id="updateOther">
        <div class="form-row pt-3 pl-1 pr-1">

            <div class="form-group col-md-4">


                <select name="product_attribute_id" class="brand crThickness"
                    style="color: #262626;background-color: #ebebeb;border: 1px solid #ebebeb;height: 36px;padding: 7.5px 10px;font-size: 16px;line-height: 19px;width: -webkit-fill-available;">
                    <option selected disabled value="">Choose
                        Thickness</option>
                    @foreach ($attributes as $attribute)
                        <option value="{{ $attribute->id }}" data-price="{{ $attribute->price }}"
                            data-weight="{{ $attribute->weight }}"
                            {{ $cartProduct->product_attribute_id == $attribute->id ? 'selected' : '' }}>
                            {{ $attribute->thickness }} mm</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group col-md-4">
                <input type="text" name="weight" value="{{ $weight }}" class="form-control" placeholder="Kgs">
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
                <Button type="button" class="btn btn-dark" id="otherUpdateBtn">Update</Button>
            </div>

        </div>
    </form>
</div>


{{-- $brands --}}
<script>
    (function() {
        const categoryPrice = {{ $categoryPrice }};

        const updateOther = document.querySelector('#updateOther');
        const attributeInput = updateOther.querySelector('[name="product_attribute_id"]');
        const weightInput = updateOther.querySelector('[name="weight"]');
        const lengthInput = updateOther.querySelector('[name="length"]');

        weightInput.addEventListener('keyup', otherCalculation);
        lengthInput.addEventListener('keyup', otherCalculation);



        function otherCalculation(e) {
            const thicknessWeight = attributeInput.options[attributeInput.selectedIndex].dataset.weight;
            const thicknessPrice = attributeInput.options[attributeInput.selectedIndex].dataset.price;
            if (e.target.name == "weight") {
                const length = e.target.value / thicknessWeight;
                updateOther.querySelector('.price-value').innerText =
                    (e.target.value * (categoryPrice + Number(thicknessPrice))).toFixed(2);
                lengthInput.value = length.toFixed(2);
            } else if (e.target.name == "length") {
                const weight = e.target.value * thicknessWeight;
                updateOther.querySelector('.price-value').innerText =
                    (weight * (categoryPrice + Number(thicknessPrice))).toFixed(2);
                weightInput.value = weight.toFixed(2);
            }
        }

        attributeInput.addEventListener('change', function(e) {
            const so = e.target.options[e.target.selectedIndex];
            updateOther.querySelector('.price-value').innerText = ((Number(categoryPrice) + Number(so
                .dataset.price)) * Number(so.dataset.weight)).toFixed(2)
            weightInput.value = so.dataset.weight;
            lengthInput.value = 1;
        })




        const otherUpdateBtn = document.getElementById('otherUpdateBtn');

        otherUpdateBtn.addEventListener('click', function() {
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
