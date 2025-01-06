@extends('public.layouts.app')
<style>
    .phone-input-container {
        display: flex;
        align-items: center;
    }

    .country-code {
        padding: 10px;
        border-right: 1px solid #ccc;
    }

    .phone-input {
        border: none;
        border-bottom: 2px solid;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
        font-size: 16px;
    }

    /* Style placeholder text */
    .phone-input::placeholder {
        color: #aaa;
    }

    /* Style input when focused */
    .phone-input:focus {
        outline: none;
        /* border-bottom-color: #007bff; */
        /* Change to your desired focus color */
    }
</style>
@section('content')
    <div class="site__body" style="
    background-color: #fdebee;
">
        <div class="block post-view p-2">

            <div class="container">
                <div class="post-view__body">
                    <div class="post-view__item post-view__item-post pt-5">
                        <div class="post-view__card">
                            <figure><a href="#"><img src="{{ asset('') }}public/assets/images/posts/loginpage.jpg"
                                        alt="" class="w-100
                                "></a></figure>
                            <h5 class="text-center">Login to View Your Profile</h5>
                            <div class="col-12 col-lg-12 py-5 px-4">
                                <div class="ml-1">
                                    <form>
                                        <div class="form-group">
                                            <div class="phone-input-container">
                                                <div class="country-code">+91</div>
                                                <input type="tel" id="phone" name="phone"
                                                    placeholder="Phone Number" class="phone-input" maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">

                                            </div>
                                            <div class="text-danger ml-5" id="phone-error"></div>
                                        </div>

                                        <div class="form-group" id="otpDiv">
                                            <div class="phone-input-container">
                                                <div class="country-code">OTP</div>
                                                <input type="tel" id="otp" class="phone-input"
                                                    placeholder="Enter OTP" maxlength="6"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            </div>
                                            <div class="text-danger ml-5" id="otp-error"></div>
                                        </div>
                                        <div class="mx-5">
                                            <button type="submit" class="btn btn-dark btn-lg rounded-lg w-100"
                                                id="submitbutton">
                                                Request OTP
                                            </button>

                                        </div>

                                        <div class="block-space block-space--layout--before-footer"></div>


                                        <p class="form-text text-muted text-center mb-0"><a
                                                href={{ route('public.register') }}>New
                                                Customer ? Create an Account</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        let t = !1,
            e = /^\d{10}$/,
            o = /^\d{6}$/;
        $("#otpDiv").hide(), $("#phone").on("keyup", function() {
            $("#phone-error").text("")
        }), $("#otp").on("keyup", function() {
            $("#otp-error").text("")
        }), $("#submitbutton").click(function(r) {
            return (r.preventDefault(), t) ? function e() {
                $("#submitbutton").prop("disabled", !0), $("#submitbutton").text(
                    "Please Wait.....");
                let r = $("#phone").val(),
                    n = $("#otp").val(),
                    s = !1;
                if (n ? o.test(n) || (s = !0, $("#otp-error").text("Invalid OTP")) : (s = !0, $(
                        "#OTP-error").text("Please Enter 6 digits OTP")), s) return $(
                    "#submitbutton").text("Verify Otp"), $("#submitbutton").prop("disabled",
                    !1), !1;
                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content")
                    },
                    url: "{{ route('public.otp-verify') }}",
                    data: {
                        phone: r,
                        otp: n
                    },
                    success: function(e) {
                        "success" == e.status ? ($("#submitbutton").hide(), location
                            .reload()) : (t = !0, $("#otpDiv").show(), $("#phone")
                            .prop("disabled", !1), alert(e.message), $(
                                "#submitbutton").text("Verify Otp")), $(
                            "#submitbutton").prop("disabled", !1)
                    },
                    error: function(t) {
                        422 == t.status && $("#otp-error").text(t.responseJSON.errors
                            .otp[0]), $("#submitbutton").prop("disabled", !1), $(
                            "#submitbutton").text("Verify Otp")
                    }
                })
            }() : function o() {
                $("#submitbutton").prop("disabled", !0), $("#submitbutton").text(
                    "Please Wait.....");
                let r = $("#phone").val(),
                    n = $("#otp").val(),
                    s = !1;
                if (r ? e.test(r) || (s = !0, $("#phone-error").text("Invalid Phone number")) : (
                        s = !0, $("#phone-error").text("Please Enter your phone number")), s)
                    return $("#submitbutton").text("Request OTP"), $("#submitbutton").prop(
                        "disabled", !1), !1;
                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content")
                    },
                    url: "{{ route('public.web-login') }}",
                    data: {
                        phone: r,
                        otp: n,
                        register: false
                    },
                    success: function(e) {
                        "success" == e.status ? (t = !0, $("#otpDiv").show(), $(
                                "#phone").prop("disabled", !0), $("#submitbutton")
                            .text("Verify Otp")) : (t = !1, $("#otpDiv").hide(), $(
                            "#phone").prop("disabled", !1), alert(e.message), $(
                            "#submitbutton").text("Request OTP")), $(
                            "#submitbutton").prop("disabled", !1)
                    },
                    error: function(t) {
                        422 == t.status && $("#phone-error").text(t.responseJSON.errors
                            .phone[0]), $("#submitbutton").prop("disabled", !1), $(
                            "#submitbutton").text("Request OTP")
                    }
                })
            }()
        })
    });
</script>
