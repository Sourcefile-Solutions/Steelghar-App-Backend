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
    const brands = document.querySelectorAll("select.brand");

    brands.forEach(function (brand) {
        const options = brand.querySelectorAll("option"); // Fix: use 'brand' instead of 'brands'
        const weight_parent = brand.parentElement.parentElement.parentElement;
        const weight_child = weight_parent.querySelector(
            'input[name="weight"]'
        );
        const length_child = weight_parent.querySelector(
            'input[name="length"]'
        );
        const price_parent =
            weight_parent.parentElement.querySelector(".price-value");
        const price_tag =
            weight_parent.parentElement.querySelector(".price-tag");

        // Array to hold the options with data-price
        const optionsWithDataPrice = [];

        options.forEach(function (option) {
            console.log(option.dataset);
            if (option.dataset.price) {
                optionsWithDataPrice.push(option);
            }
        });

        // Now optionsWithDataPrice contains all options with data-price for the current select box
        console.log("aaa", optionsWithDataPrice);

        let minPrice = Infinity;

        optionsWithDataPrice.forEach(function (option) {
            let price = (
                option.dataset.tmtweight * option.dataset.price
            ).toFixed(2); // Fix: use option.dataset.price

            if (parseFloat(price) < minPrice) {
                minPrice = parseFloat(price);
            }

            console.log("min", minPrice);

            price_parent.textContent = minPrice.toFixed(2);
        });

        brand.addEventListener("change", function (e) {
            let selectedOption = this.options[this.selectedIndex];

            if (selectedOption.value === "") {
                weight_child.value = "";
                length_child.value = "";
                weight_child.disabled = true;
                length_child.disabled = true;
                price_parent.textContent = "";
            } else {
                let tmt_price = selectedOption.dataset.price;
                let tmt_weight = selectedOption.dataset.tmtweight;

                weight_child.value = tmt_weight;
                length_child.value = 1;
                weight_child.disabled = false;
                length_child.disabled = false;
                price_tag.classList.remove("text-danger");
                price_tag.classList.add("text-success");
                price_tag.textContent = "Price";
                price_tag.style.fontSize = "large";

                let final_price = (tmt_price * tmt_weight).toFixed(2);
                price_parent.textContent = final_price;
            }
        });
    });
});

function tmtweight(e) {
    // console.log(Number(e.value));
    console.log(e);
    const brand_parent = e.parentElement.parentElement.parentElement;
    const brand_child =
        brand_parent.childNodes[3].childNodes[1].childNodes[1].value;
    selectBox = brand_parent.childNodes[3].childNodes[1].childNodes[1];
    const selected_brand = selectBox.options[selectBox.selectedIndex];
    const brand_price = selected_brand.dataset.price;
    const tmt_weight = selected_brand.dataset.tmtweight;
    const length_parent = e.parentElement.parentElement;
    const length_child = length_parent.childNodes[3].childNodes[1];
    let length = Number(e.value) / Number(tmt_weight);
    console.log(length);
    let final_length = length.toFixed(2);
    length_child.value = final_length;

    let changing_price = Number(brand_price) * Number(e.value);

    const final_price = changing_price.toFixed(2);

    let price_parent =
        e.parentElement.parentElement.parentElement.parentElement;
    let price_child =
        price_parent.childNodes[7].childNodes[1].childNodes[4].childNodes[1]
            .childNodes[0];
    price_child.textContent = final_price;

    // console.log(brand_child.dataset.tmtweight);
}

function tmtlength(e) {
    const brand_parent = e.parentElement.parentElement.parentElement;
    const brand_child =
        brand_parent.childNodes[3].childNodes[1].childNodes[1].value;
    selectBox = brand_parent.childNodes[3].childNodes[1].childNodes[1];
    const selected_brand = selectBox.options[selectBox.selectedIndex];
    const brand_price = selected_brand.dataset.price;
    const tmt_weight = selected_brand.dataset.tmtweight;

    const weight_parent = e.parentElement.parentElement;
    const weight_child = weight_parent.childNodes[1].childNodes[1];
    let weight = Number(e.value) * Number(tmt_weight);
    let final_weight = weight.toFixed(2);
    // weight_child.value = final_weight;

    let changing_price = Number(brand_price) * Number(final_weight);
    const final_price = changing_price.toFixed(2);

    let price_parent =
        e.parentElement.parentElement.parentElement.parentElement;
    let price_child =
        price_parent.childNodes[7].childNodes[1].childNodes[4].childNodes[1]
            .childNodes[0];
    price_child.textContent = final_price;
}
