@extends('public.layouts.app')
<style>
    .warpper {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tab {
        cursor: pointer;
        padding: 10px 20px;
        margin: 0px 2px;
        background: #fff;
        display: inline-block;
        color: #000;
        border-radius: 3px 3px 0px 0px;
        box-shadow: 0 0.5rem 0.8rem #00000080;
        font-size: 60px
    }

    .panels {
        background: #fffffff6;
        box-shadow: 0 2rem 2rem #00000080;
        min-height: 200px;
        width: 100%;
        max-width: 500px;
        border-radius: 3px;
        overflow: hidden;
        padding: 20px;
    }

    .panel {
        display: none;
        animation: fadein .8s;
    }

    @keyframes fadein {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .panel-title {
        font-size: 1.5em;
        font-weight: bold
    }

    .radio {
        display: none;
    }

    #one:checked~.panels #one-panel,
    #two:checked~.panels #two-panel,
    #three:checked~.panels #three-panel {
        display: block
    }

    #one:checked~.tabs #one-tab,
    #two:checked~.tabs #two-tab,
    #three:checked~.tabs #three-tab {
        /* background: #fffffff6;
        color: #000; */
        border-top: 3px solid #000;
        font-size: 60px;
    }

    .button-cover:before {
        counter-increment: button-counter;
        content: counter(button-counter);
        position: absolute;
        right: 0;
        bottom: 0;
        color: #d7e3e3;
        font-size: 12px;
        line-height: 1;
        padding: 5px;
    }

    .button-cover,
    .knobs,
    .layer {
        position: absolute;
        top: -3;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .button {
        position: relative;
        top: 50%;
        width: 106px;
        /* height: 36px; */
        margin: -20px auto 0 auto;
        overflow: hidden;
    }

    .button.r,
    .button.r .layer {
        border-radius: 100px;
    }

    .button.b2 {
        border-radius: 2px;
    }

    .checkbox {
        position: relative;
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 3;
    }

    .knobs {
        z-index: 2;
    }

    .layer {
        width: 100%;
        background-color: #ebf7fc;
        transition: 0.3s ease all;
        z-index: 1;
    }

    /* Button 10 */
    #button-10 .knobs:before,
    #button-10 .knobs:after,
    #button-10 .knobs span {
        position: absolute;
        top: 5px;
        width: 53px;
        height: 9px;
        font-size: 15px;
        font-weight: bold;
        text-align: center;
        line-height: 1;
        padding: 16px 0px;
        border-radius: 2px;
        transition: 0.3s ease all;
    }

    #button-10 .knobs:before {
        content: "";
        left: 4px;
        top: 11px;
        background-color: #03a9f4;
    }

    #button-10 .knobs:after {
        content: "ft";
        right: 4px;
        color: #4e4e4e;
    }

    #button-10 .knobs span {
        display: inline-block;
        left: 4px;
        color: #fff;
        z-index: 1;
    }

    #button-10 .checkbox:checked+.knobs span {
        color: #4e4e4e;
    }

    #button-10 .checkbox:checked+.knobs:before {
        left: 42px;
        background-color: #f44336;
    }

    #button-10 .checkbox:checked+.knobs:after {
        color: #fff;
    }

    #button-10 .checkbox:checked~.layer {
        background-color: #fcebeb;
    }
</style>

@section('content')
    <div class="site__body">

        <div class="warpper pt-5 m-2">
            <input class="radio" id="one" name="group" type="radio" checked>
            <input class="radio" id="two" name="group" type="radio">
            <input class="radio" id="three" name="group" type="radio">
            <div class="tabs">
                <label class="tab" id="one-tab" for="one"><i class="fa-regular fa-square"></i></label>
                <label class="tab" id="two-tab" for="two"><i class="fa-regular fa-square"></i></label>
                <label class="tab" id="three-tab" for="three"><i class="fa-regular fa-circle"></i></label>

            </div>
            <div class="panels">
                <div class="panel text-center" id="one-panel">
                    <h5 class="text-center">Square Hollow Section</h5>
                    <img src="/public/assets/images/s1.jpeg" alt="" />
                    <form id="squareForm">
                        <div class="form-row">
                            <div class="form-group col-2">

                                <h3>h/b</h3>
                            </div>

                            <div class="form-group col-6">

                                <input type="text" class="form-control" name="height" placeholder="Height/Breadth" />
                            </div>
                            <div class="form-group col-4 d-flex">

                                <div class="container">


                                    <div class="button-cover">
                                        <div class="button b2" id="button-10">
                                            <input type="checkbox" class="checkbox" />
                                            <div class="knobs">
                                                <span>mm</span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-2">

                                <h3>t</h3>
                            </div>

                            <div class="form-group col-6">

                                <input type="text" class="form-control" name="thickness" placeholder="Thickness" />
                            </div>
                            <div class="form-group col-4 pr-5">

                                <button type="submit" class="btn btn-primary btn-sm " style="background-color: #03a9f4;">
                                    mm
                                </button>
                            </div>
                        </div>

                        {{-- <div class="form-row">
                            <div class="form-group col-2">

                                <h3>l</h3>
                            </div>

                            <div class="form-group col-6">

                                <input type="text" class="form-control" name="length" placeholder="Length" />
                            </div>
                            <div class="form-group col-4">

                                <div class="container">


                                    <div class="button-cover">
                                        <div class="button b2" id="button-10">
                                            <input type="checkbox" id="squareFeet" class="checkbox" name="unit"
                                                onchange="squareCalculation()" />
                                            <div class="knobs">
                                                <span>m</span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> --}}


                    </form>

                    <h5 class="text-center">Weight : <span id="squareWeight">0.0</span>Kg</h5>
                </div>

                <div class="panel text-center" id="two-panel">
                    <h5 class="text-center">Rectangle Hollow Section</h5>
                    <img src="/public/assets/images/s1.jpeg" alt="" />
                    <form id="rectangleForm">
                        <div class="form-row">
                            <div class="form-group col-2">

                                <h3>h</h3>
                            </div>

                            <div class="form-group col-6">

                                <input type="text" class="form-control" name="height" placeholder="Height" />
                            </div>
                            <div class="form-group col-4 d-flex">

                                <div class="container">


                                    <div class="button-cover">
                                        <div class="button b2" id="button-10">
                                            <input type="checkbox" class="checkbox" />
                                            <div class="knobs">
                                                <span>mm</span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-2">

                                <h3>b</h3>
                            </div>

                            <div class="form-group col-6">

                                <input type="text" class="form-control" name="breadth" placeholder="Breadth" />
                            </div>
                            <div class="form-group col-4">

                                <div class="container">


                                    <div class="button-cover">
                                        <div class="button b2" id="button-10">
                                            <input type="checkbox" class="checkbox" />
                                            <div class="knobs">
                                                <span>mm</span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-2">

                                <h3>t</h3>
                            </div>

                            <div class="form-group col-6">

                                <input type="text" class="form-control" name="thickness" placeholder="Thickness" />
                            </div>
                            <div class="form-group col-4 pr-5">

                                <button type="submit" class="btn btn-primary btn-sm "
                                    style="background-color: #03a9f4;">
                                    mm
                                </button>
                            </div>
                        </div>



                    </form>
                    <h5 class="text-center">Weight : <span id="rectangleWeight">0.0</span>Kg</h5>

                </div>

                <div class="panel text-center" id="three-panel">
                    <h5 class="text-center">Circle Hollow Section</h5>
                    <img src="/public/assets/images/c1.jpeg" alt="" class="w-50" />
                    <form id="circleForm">

                        <div class="form-row">
                            <div class="form-group col-2">

                                <h3>d</h3>
                            </div>

                            <div class="form-group col-6">

                                <input type="text" class="form-control" name="diameter" placeholder="diameter" />
                            </div>
                            <div class="form-group col-4 d-flex">

                                <div class="container">


                                    <div class="button-cover">
                                        <div class="button b2" id="button-10">
                                            <input type="checkbox" class="checkbox" />
                                            <div class="knobs">
                                                <span>mm</span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-2">

                                <h3>t</h3>
                            </div>
                            <div class="form-group col-6">

                                <input type="text" class="form-control" name="thickness" placeholder="Thickness" />
                            </div>
                            <div class="form-group col-4 d-flex">

                                <div class="container">


                                    <div class="button-cover">
                                        <div class="button b2" id="button-10">
                                            <input type="checkbox" class="checkbox" />
                                            <div class="knobs">
                                                <span>m</span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </form>
                    <h5 class="text-center">Weight : <span id="circleWeight">0.0</span>Kg</h5>

                </div>

            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const squareWeight = document.querySelector("#squareWeight"),
            squareCalculation = () => {
                let e = squareForm.height.value,
                    r = squareForm.thickness.value;
                if (e && r) {
                    let t = (((((e * 4) / 3.14) - r) * r) * 0.02465) * 6
                    squareWeight.innerText = t.toFixed(2)
                } else squareWeight.innerText = "0.0"
            },
            squareForm = document.querySelector("#squareForm"),
            squareInputs = squareForm.querySelectorAll("input");
        squareInputs.forEach(e => {
            e.addEventListener("keyup", function(e) {
                squareCalculation()
            })
        });


        const rectangleWeight = document.querySelector("#rectangleWeight"),
            rectangleCalculation = () => {
                let e = rectangleForm.breadth.value,
                    t = rectangleForm.height.value,
                    l = rectangleForm.thickness.value;
                if (e && t && l) {
                    let a = ((((((Number(t) + Number(e)) * 2) / 3.14) - l) * l) * 0.02465) * 6
                    rectangleWeight.innerText = a.toFixed(2);
                } else rectangleWeight.innerText = "0.0"
            };
        (rectangleInputs = (rectangleForm = document.querySelector("#rectangleForm")).querySelectorAll("input")).forEach(
            e => {
                e.addEventListener("keyup", function(e) {
                    rectangleCalculation()
                })
            });

        const circleWeight = document.querySelector("#circleWeight"),
            circleCalculation = () => {
                let e = circleForm.diameter.value,
                    c = circleForm.thickness.value;
                if (e && c) {
                    const a = (((e - c) * c) * 0.02465) * 6;
                    circleWeight.innerText = a.toFixed(2);
                } else circleWeight.innerText = "0.0"
            },
            circleForm = document.querySelector("#circleForm");
        circleForm.querySelectorAll("input").forEach(e => {
            e.addEventListener("keyup", function(e) {
                circleCalculation()
            })
        });
    </script>
@endsection
