<div>
    <form action="#" method="post" id="updateRoof">
        <div class="form-row pt-3 pl-1 pr-1">

            <div class="form-group col-md-4">
                <select name="product_attribute_id" class="brand roofThickness"
                    style="color: #262626;background-color: #ebebeb;border: 1px solid #ebebeb;height: 36px;padding: 7.5px 10px;font-size: 16px;line-height: 19px;width: -webkit-fill-available;">
                    <option selected disabled value="">
                        Thickness</option>
                    @foreach ($attributes as $attribute)
                        <option value="{{ $attribute->id }}" data-price="{{ $attribute->price }}"
                            data-thickness="{{ $attribute->thickness }}"
                            data-formula_value="{{ $attribute->formula_value }}"
                            {{ $cartProduct->product_attribute_id == $attribute->id ? 'selected' : '' }}>
                            {{ $attribute->thickness }} mm
                        </option>
                    @endforeach
                </select>
            </div>



            <div class="form-group col-md-4">
                <select name="color" class="brand roofThickness"
                    style="color: #262626;background-color: #ebebeb;border: 1px solid #ebebeb;height: 36px;padding: 7.5px 10px;font-size: 16px;line-height: 19px;width: -webkit-fill-available;">
                    @foreach ($colors as $color)
                        <option value="{{ $color->color }}"
                            {{ $cartProduct->product_attribute_id == $color->color ? 'selected' : '' }}>
                            {{ $color->color }}
                        </option>
                    @endforeach
                </select>
            </div>



            <div class="form-group col-md-4">
                <input type="text" name="size" value="{{ $cartProduct->size }}" class="form-control"
                    placeholder="size">
            </div>

            <div class="form-group col-md-4">
                <input type="text" name="no_of_sheet" value="{{ $cartProduct->no_of_sheet }}" class="form-control"
                    placeholder="no of sheet">
            </div>

            <div class="form-group col-md-4">
                <b> Price ₹<span class="price-value">{{ $price }}</span></b>
            </div>



            <div class="form-group col-md-4 text-lg-right ">
                <Button type="button" class="btn btn-dark" id="roofUpdateBtn">Update</Button>
            </div>

        </div>
    </form>
</div>


<script>
    (function() {
        const categoryPrice = {{ $categoryPrice }};

        const updateRoof = document.querySelector('#updateRoof');
        const attributeInput = updateRoof.querySelector('[name="product_attribute_id"]');
        const colorInput = updateRoof.querySelector('[name="color"]');
        const sizeInput = updateRoof.querySelector('[name="size"]');
        const sheetInput = updateRoof.querySelector('[name="no_of_sheet"]');
        attributeInput.addEventListener('keyup', roofCalculation);
        sizeInput.addEventListener('keyup', roofCalculation);
        sheetInput.addEventListener('keyup', roofCalculation);

        function roofCalculation(e) {
            let thicknessPrice = attributeInput.options[attributeInput.selectedIndex].dataset.price;
            let formula_value = attributeInput.options[attributeInput.selectedIndex].dataset.formula_value;
            if (e.target.name == "size") {
                updateRoof.querySelector('.price-value').innerText =
                    (formula_value * (Number(categoryPrice) + Number(thicknessPrice)) * Number(updateRoof
                        .querySelector('[name="no_of_sheet"]').value) * e.target.value).toFixed(2);
            } else if (e.target.name == "no_of_sheet") {
                updateRoof.querySelector('.price-value').innerText =
                    (formula_value * (Number(categoryPrice) + Number(thicknessPrice)) * Number(updateRoof
                        .querySelector('[name="size"]').value) * e.target.value).toFixed(2);
            }
        }

        attributeInput.addEventListener('change', function(e) {
            const so = e.target.options[e.target.selectedIndex];
            updateRoof.querySelector('.price-value').innerText = Number(so.dataset.formula_value) * (Number(
                categoryPrice) + Number(so
                .dataset.price)).toFixed(2)
            sizeInput.value = 1;
            sheetInput.value = 1
        })

        const roofUpdateBtn = document.getElementById('roofUpdateBtn');
        roofUpdateBtn.addEventListener('click', function() {
            update()
        })
        const update = async () => {
            const response = await axios({
                method: 'post',
                url: "update-to-cart/" + {{ $cartProduct->id }},
                data: {
                    size: sizeInput.value,
                    no_of_sheet: sheetInput.value,
                    product_attribute_id: attributeInput.value,
                    color: colorInput.value
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
