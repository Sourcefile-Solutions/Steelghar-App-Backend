function addToWishlist(event, productId) {
    event.preventDefault();
    $.ajax({
        url: BASE_URL + "/add-to-wishlist/" + productId, // Update the URL to match your route
        method: "GET",
        data: {
            product_id: productId,
            // _token: "{{ csrf_token() }}",
        },
        success: function (response) {
            console.log(response);
            if (response.exists) {
                // Product already exists in the wishlist, show SweetAlert
                Swal.fire({
                    icon: "info",
                    title: "Oops...",
                    text: response.message,
                });
            } else {
                // alert(888);
                // Product added to the wishlist successfully, show success SweetAlert
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.message,
                });
            }
        },
        error: function (xhr, status, error) {
            console.error(error); // Log any errors
        },
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const brands = document.querySelectorAll("select.roof_thickness");

    brands.forEach(function (brand) {
        const options = brand.querySelectorAll("option"); // Fix: use 'brand' instead of 'brands'
        const height_parent = brand.parentElement.parentElement.parentElement;
        const height_child = height_parent.querySelector('input[name="size"]');
        const length_child = height_parent.querySelector(
            'input[name="sheets"]'
        );
        const price_parent =
            height_parent.parentElement.querySelector(".price-value");
        const price_tag =
            height_parent.parentElement.querySelector(".price-tag");

        // Array to hold the options with data-price
        const optionsWithDataPrice = [];

        options.forEach(function (option) {
            if (option.dataset.price_kg) {
                optionsWithDataPrice.push(option);
            }
        });

        // Now optionsWithDataPrice contains all options with data-price for the current select box
        console.log("aaa", optionsWithDataPrice);

        let minPrice = Infinity;

        optionsWithDataPrice.forEach(function (option) {
            let price = (option.dataset.price_kg * 1).toFixed(2); // Fix: use option.dataset.price

            //     let price = (
            //         option.dataset.price_kg
            //    ).toFixed(2); // Fix: use option.dataset.price

            if (parseFloat(price) < minPrice) {
                minPrice = parseFloat(price);
            }

            console.log("min", minPrice);

            price_parent.textContent = minPrice.toFixed(2);
        });

        brand.addEventListener("change", function (e) {
            let selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value === "") {
                height_child.value = "";
                length_child.value = "";
                height_child.disabled = true;
                length_child.disabled = true;
                price_parent.textContent = "";
            } else {
                let tmt_price = selectedOption.dataset.price_kg;
                // let tmt_height = selectedOption.dataset.height;

                height_child.value = 1;
                length_child.value = 1;
                height_child.disabled = false;
                length_child.disabled = false;
                price_tag.classList.remove("text-danger");
                price_tag.classList.add("text-success");
                price_tag.textContent = "Price";
                price_tag.style.fontSize = "large";

                let final_price = (tmt_price * 1).toFixed(2);
                price_parent.textContent = final_price;
            }
        });
    });
});

function roofSize(e) {
    // console.log(Number(e.value));
    // console.log(e);
    const brand_parent = e.parentElement.parentElement.parentElement;
    console.log(brand_parent);
    const brand_child =
        brand_parent.childNodes[3].childNodes[1].childNodes[1].value;
    selectBox = brand_parent.childNodes[3].childNodes[1].childNodes[1];
    const selected_brand = selectBox.options[selectBox.selectedIndex];

    let sheets = brand_parent.childNodes[5].childNodes[3].childNodes[1].value;
    let cost =
        brand_parent.childNodes[3].childNodes[3].childNodes[1].childNodes[3]
            .dataset.price_kg;
    console.log(tmt_height);

    // const brand_price = selected_brand.dataset.price;
    // const tmt_height = selected_brand.dataset.tmtheight;

    const length_parent = e.parentElement.parentElement;
    const length_child = length_parent.childNodes[3].childNodes[1];
    let length = Number(e.value) / Number(sheets);
    console.log(length);
    let final_length = length.toFixed(2);
    length_child.value = final_length;

    let changing_price = Number(cost) * Number(e.value) * 1.3;

    const final_price = changing_price.toFixed(2);

    let price_parent =
        e.parentElement.parentElement.parentElement.parentElement;
    let price_child =
        price_parent.childNodes[7].childNodes[1].childNodes[4].childNodes[1]
            .childNodes[0];
    price_child.textContent = final_price;

    // console.log(brand_child.dataset.tmtweight);
}

function sheets(e) {
    const brand_parent = e.parentElement.parentElement.parentElement;
    const brand_child =
        brand_parent.childNodes[3].childNodes[1].childNodes[1].value;
    selectBox = brand_parent.childNodes[3].childNodes[1].childNodes[1];
    const selected_brand = selectBox.options[selectBox.selectedIndex];
    const brand_price = selected_brand.dataset.price_kg;
    // const height = selected_brand.dataset.height;

    let size = brand_parent.childNodes[5].childNodes[1].childNodes[1].value;
    let cost =
        brand_parent.childNodes[3].childNodes[3].childNodes[1].childNodes[3]
            .dataset.price_kg;
    // console.log(cost);

    const weight_parent = e.parentElement.parentElement;
    const weight_child = weight_parent.childNodes[1].childNodes[1];
    let weight = Number(e.value) * Number(size);
    let final_weight = weight.toFixed(2);
    // weight_child.value = final_weight;

    let changing_price = Number(cost) * Number(final_weight) * 1.3;
    const final_price = changing_price.toFixed(2);

    let price_parent =
        e.parentElement.parentElement.parentElement.parentElement;
    let price_child =
        price_parent.childNodes[7].childNodes[1].childNodes[4].childNodes[1]
            .childNodes[0];
    price_child.textContent = final_price;
}
