@extends('layouts.app')
@section('content')
    <div class="site__body">


        <div class="block py-5">
            <div class="container container--max--lg">
                <div class="card">
                    <div class="card-body card-body--padding--2">
                        <div class="row">
                            <div class="col-12 col-lg-12 pb-4 pb-lg-0">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($fab != null)
                                    @if ($fab->approval_status == 'PENDING')
                                        <h2><span>Fabricator Status : </span><span class="text-info">Pending</span></h2>
                                    @elseif ($fab->approval_status == 'APPROVED')
                                        <h2><span>Fabricator ID : </span><span
                                                class="text-success"><b>{{ $fab->fab_id }}</b></span></h2>
                                    @elseif ($fab->approval_status == 'REJECTED')
                                        <h2><span>Reject Reason : </span><span
                                                class="text-success">{{ $fab->reason }}</span>
                                        </h2>
                                        <form method="post" action="{{ route('fabricators.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="form-name">Company Name</label>
                                                    <input type="text" id="form-name" class="form-control"
                                                        placeholder="Enter Company Name" name="company_name"
                                                        value="{{ old('company_name') }}" />
                                                    @error('company_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Company Phone</label>
                                                    <input type="tell" class="form-control"
                                                        placeholder="Enter Company Phone" name="phone"
                                                        value="{{ old('phone') }}" maxlength="10"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="form-email">Company Email</label>
                                                    <input type="email" id="form-email" class="form-control"
                                                        placeholder="Enter Email Address" name="email"
                                                        value="{{ old('email') }}" max="10" />
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Company GST</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter GST Number" name="gst"
                                                        value="{{ old('gst') }}" />
                                                    @error('gst')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>PAN Number</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter PAN Number" name="pan"
                                                        value="{{ old('pan') }}" />
                                                    @error('pan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Aadhar Number</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Aadhar Number" name="aadhaar"
                                                        value="{{ old('aadhaar') }}" maxlength="12"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                    @error('aadhaar')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Bussiness Detail Agreement<small class="text-danger">(Must be
                                                            less
                                                            than
                                                            2MB)</small></label>
                                                    <input type="file" class="form-control"
                                                        placeholder="Bussiness Detail Agreement" name="business_agreement"
                                                        accept=".png, .jpg, .jpeg, .pdf" />
                                                    @error('business_agreement')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Photo of Fabricator<small class="text-danger">(Must be less than
                                                            2MB)</small></label>
                                                    <input type="file" class="form-control"
                                                        placeholder="Photo of Fabricator" name="photo"
                                                        accept=".png, .jpg, .jpeg" />
                                                    @error('photo')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-danger btn-lg">
                                                Submit
                                            </button>

                                        </form>
                                    @elseif($fab->approval_status == 'BLOCKED')
                                        <h2><span>Fabricator Status : </span><span class="text-danger">Blocked</span></h2>
                                    @endif
                                @else
                                    <form method="post" action="{{ route('fabricators.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="form-name">Company Name</label>
                                                <input type="text" id="form-name" class="form-control"
                                                    placeholder="Enter Company Name" name="company_name"
                                                    value="{{ old('company_name') }}" />
                                                @error('company_name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Company Phone</label>
                                                <input type="tell" class="form-control"
                                                    placeholder="Enter Company Phone" name="phone"
                                                    value="{{ old('phone') }}" maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                @error('phone')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="form-email">Company Email</label>
                                                <input type="email" id="form-email" class="form-control"
                                                    placeholder="Enter Email Address" name="email"
                                                    value="{{ old('email') }}" max="10" />
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Company GST</label>
                                                <input type="text" class="form-control" placeholder="Enter GST Number"
                                                    name="gst" value="{{ old('gst') }}" />
                                                @error('gst')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>PAN Number</label>
                                                <input type="text" class="form-control" placeholder="Enter PAN Number"
                                                    name="pan" value="{{ old('pan') }}" />
                                                @error('pan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Aadhar Number</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Aadhar Number" name="aadhaar"
                                                    value="{{ old('aadhaar') }}" maxlength="12"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                @error('aadhaar')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Bussiness Detail Agreement<small class="text-danger">(Must be less
                                                        than
                                                        2MB)</small></label>
                                                <input type="file" class="form-control"
                                                    placeholder="Bussiness Detail Agreement" name="business_agreement"
                                                    accept=".png, .jpg, .jpeg, .pdf" />
                                                @error('business_agreement')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Photo of Fabricator<small class="text-danger">(Must be less than
                                                        2MB)</small></label>
                                                <input type="file" class="form-control"
                                                    placeholder="Photo of Fabricator" name="photo"
                                                    accept=".png, .jpg, .jpeg" />
                                                @error('photo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-danger btn-lg">
                                            Submit
                                        </button>

                                    </form>
                                @endif


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
@endsection
