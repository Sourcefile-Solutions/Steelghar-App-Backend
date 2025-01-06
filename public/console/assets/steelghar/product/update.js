"use strict";
// Class definition
var KTAppEcommerceAddProduct = (function () {
    let form;
    let subcat = document.getElementById("subcategory");
    let steelattribute = document.getElementById("steelattribute");
    const handleCategory = () => {
        document
            .querySelector('select[name="category_id"]')
            .addEventListener("change", function (e) {
                form.subcategory_id.innerHTML = "";
                const option = document.createElement("option");
                option.value = "";
                option.innerText = "No Sub Categories";
                form.subcategory_id.appendChild(option);
                const categoryId = this.value;
                axios
                    .get(
                        BASE_URL + "/get-subcategory-by-category/" + categoryId
                    )
                    .then(function (response) {
                        console.log(response);
                        if (response.data.status == "success") {
                            let subcategories = response.data.subcategories;
                            console.log(subcategories.length);
                            
                            if (subcategories.length) {
                                subcat.removeAttribute("disabled");
                                form.subcategory_id.innerHTML = "";
                                const option = document.createElement("option");
                                option.value = "";
                                option.innerText = "Select Sub Category";
                                form.subcategory_id.appendChild(option);
                                subcategories.forEach((subcategory) => {
                                    const option =
                                        document.createElement("option");
                                    option.value = subcategory.id;
                                    option.innerText =
                                        subcategory.subcategory_name;
                                    form.subcategory_id.appendChild(option);
                                });
                                categoryStatus = response.data.categoryStatus;
                            } 
                            else {
                                subcat.setAttribute("disabled");
                            }
                        } else if (
                            response.data.status == "error" ||
                            response.data.status == "info"
                        ) {
                            Swal.fire({
                                title: response.data.title,
                                text: response.data.message,
                                icon: response.data.status,
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            });
                        }
                    })
                    .catch(function (error) {})
                    .then(function () {
                        // btn.removeAttribute('data-kt-indicator');
                        // btn.disabled = false;
                    });
            });
    };


    // Submit form handler
    const handleSubmit = () => {
        // Define variables
        let validator;

        // Get elements

        const submitButton = document.getElementById("product_submit");

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(form, {
            fields: {
                product_name: {
                    validators: {
                        notEmpty: {
                            message: "Product name field is required",
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: "",
                }),
            },
        });

        // Handle submit button
        submitButton.addEventListener("click", (e) => {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log("validated!");

                    if (status == "Valid") {
                        submitButton.setAttribute("data-kt-indicator", "on");
                        submitButton.disabled = !0;
                        let formData = new FormData(form);
                        axios
                            .post(form.getAttribute("action"), formData)
                            .then(function (response) {
                                console.log(response);
                                if (response.data.status == "success") {
                                    form.reset();
                                    Swal.fire({
                                        title: response.data.title,
                                        text: response.data.message,
                                        icon: response.data.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn btn-primary",
                                        },
                                    }).then(function () {
                                        window.location =
                                            BASE_URL + "/products/";
                                    });
                                } else if (
                                    response.data.status == "error" ||
                                    response.data.status == "info"
                                ) {
                                    Swal.fire({
                                        title: response.data.title,
                                        text: response.data.message,
                                        icon: response.data.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn btn-primary",
                                        },
                                    });
                                }
                            })
                            .catch(function (error) {
                                if (error.response.status === 422) {
                                    let dataMessage =
                                        error.response.data.message;
                                    let dataErrors = error.response.data.errors;
                                    for (const errorsKey in dataErrors) {
                                        if (
                                            !dataErrors.hasOwnProperty(
                                                errorsKey
                                            )
                                        )
                                            continue;
                                        form.elements[errorsKey].classList.add(
                                            "is-invalid"
                                        );
                                        form.elements[
                                            errorsKey
                                        ].parentElement.children[1].innerText =
                                            dataErrors[errorsKey];
                                    }
                                    if (error.response) {
                                        Swal.fire({
                                            text: dataMessage,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton:
                                                    "btn btn-primary",
                                            },
                                        });
                                    }
                                }
                            })
                            .then(function () {
                                submitButton.removeAttribute(
                                    "data-kt-indicator"
                                );
                                submitButton.disabled = false;
                            });
                    } else {
                        Swal.fire({
                            html: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
            }
        });
    };

    // Public methods
    return {
        init: function () {
            form = document.getElementById("product_update_form");
            handleSubmit();
            handleCategory();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceAddProduct.init();
});
