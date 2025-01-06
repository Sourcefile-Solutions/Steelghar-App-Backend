document.addEventListener("DOMContentLoaded", function () {
    const thicknesses = document.querySelectorAll("select.thickness");

    thicknesses.forEach(function (thickness) {
        const options = thickness.querySelectorAll("option");
        const weight_parent =
            thickness.parentElement.parentElement.parentElement;
        const price_parent =
            weight_parent.parentElement.querySelector(".price-value");
        // Array to hold the options with data-price_kg
        const optionsWithDataPriceKg = [];

        options.forEach(function (option) {
            if (option.dataset.price_kg) {
                optionsWithDataPriceKg.push(option);
                // console.log(optionsWithDataPriceKg.push(option));
            }
        });

        // Now optionsWithDataPriceKg contains all options with data-price_kg for the current select box
        console.log("aaa", optionsWithDataPriceKg);

        let minTootal = Infinity;
        let minTootalOption = null;

        optionsWithDataPriceKg.forEach(function (option) {
            let tootal = (
                option.dataset.weight * option.dataset.price_kg
            ).toFixed(2);

            if (parseFloat(tootal) < minTootal) {
                minTootal = parseFloat(tootal);
            }

            console.log("min", minTootal);

            price_parent.textContent = minTootal.toFixed(2);
        });
        thickness.addEventListener("change", function (e) {
            const weight_parent =
                thickness.parentElement.parentElement.parentElement;
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

            let selectedOption = this.options[this.selectedIndex];
            let price_kg = selectedOption.dataset.price_kg;
            let weight = selectedOption.dataset.weight;

            if (selectedOption.value === "") {
                weight_child.value = "";
                length_child.value = "";
                weight_child.disabled = true;
                length_child.disabled = true;
                price_parent.textContent = "";
            } else {
                weight_child.value = weight;
                length_child.value = 1.0;
                weight_child.disabled = false;
                length_child.disabled = false;
                price_tag.classList.remove("text-danger");
                price_tag.classList.add("text-success");
                price_tag.textContent = "Price";
                price_tag.style.fontSize = "large";

                let final_price = (price_kg * weight).toFixed(2);
                price_parent.textContent = final_price;
            }
        });
    });
});

function weight(e) {
    const thickness_parent = e.parentElement.parentElement.parentElement;
    const selectBox = thickness_parent.querySelector('select[name="weight"]');
    const selected_thickness = selectBox.options[selectBox.selectedIndex];
    const thickness_price = selected_thickness.dataset.price_kg;
    const thickness_weight = selected_thickness.dataset.weight;
    const length_parent = e.parentElement.parentElement;
    const length_child = length_parent.querySelector('input[name="length"]');

    let length = Number(e.value) / Number(thickness_weight);
    let final_length = length.toFixed(2);
    length_child.value = final_length;

    let changing_price = Number(thickness_price) * Number(e.value);
    const final_price = changing_price.toFixed(2);

    let price_parent =
        e.parentElement.parentElement.parentElement.parentElement;
    let price_child =
        price_parent.childNodes[7].childNodes[1].childNodes[4].childNodes[1]
            .childNodes[0];
    price_child.textContent = final_price;
}

function length(e) {
    const thickness_parent = e.parentElement.parentElement.parentElement;
    const thickness_child =
        thickness_parent.childNodes[3].childNodes[1].childNodes[1].value;
    selectBox = thickness_parent.childNodes[3].childNodes[1].childNodes[1];
    const selected_thickness = selectBox.options[selectBox.selectedIndex];
    const thickness_price = selected_thickness.dataset.price_kg;
    const thickness_weight = selected_thickness.dataset.weight;

    const weight_parent = e.parentElement.parentElement;
    const weight_child = weight_parent.childNodes[1].childNodes[1];

    let weight = Number(e.value) * Number(thickness_weight);
    let final_weight = weight.toFixed(2);
    // weight_child.value = final_weight;

    let changing_price = Number(thickness_price) * Number(final_weight);
    const final_price = changing_price.toFixed(2);

    let price_parent =
        e.parentElement.parentElement.parentElement.parentElement;
    let price_child =
        price_parent.childNodes[7].childNodes[1].childNodes[4].childNodes[1]
            .childNodes[0];
    price_child.textContent = final_price;
}
