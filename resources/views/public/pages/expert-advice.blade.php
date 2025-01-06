@extends('public.layouts.app')
@section('content')
    <div class="site__body">
        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Expert Advice</h1>
                </div>
            </div>
        </div>


        <div class="block">
            <div class="container container--max--lg">
                <div class="card">
                    <div class="card-body card-body--padding--2">
                        <div class="row">
                            <div class="col-12 col-lg-6 pb-4 pb-lg-0">
                                <div class="mr-1">
                                    <div class="post-card__image">
                                        <a href="#"><img src="/public/assets/images/posts/ex.jpg" alt=""
                                                class="rounded-lg w-100"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="ml-1">
                                    <h4 class="contact-us__header card-title">
                                        Leave us a Message
                                    </h4>

                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            <p class="font-weight-bold">{{ session('success') }}</p>
                                            <small class="font-weight-bold">Our representative will contact you
                                                shortly.</small>
                                        </div>
                                    @else
                                        <form id="expertAdviceForm" method="post"
                                            action="{{ route('public.expert-advice-store') }}">
                                            @csrf

                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                    <p class="font-weight-bold"> {{ session('error') }}</p>
                                                </div>
                                            @endif
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="form-name">Your Name</label>
                                                    <input type="text" class="form-control" placeholder="Your Name"
                                                        name="name" value="{{ old('name') }}">
                                                    @error('name')
                                                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="form-email">Email</label>
                                                    <input type="email" class="form-control" placeholder="Email Address"
                                                        name="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <small class="text-danger font-weight-bold">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="form-subject">Phone</label>
                                                <input type="text" class="form-control" placeholder="Phone"
                                                    name="phone" value="{{ old('phone') }}">
                                                @error('phone')
                                                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="form-message">Message</label>
                                                <textarea id="form-message" class="form-control" rows="4" name="message">{{ old('message') }}</textarea>
                                                @error('message')
                                                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-danger rounded-pill">
                                                Send Message
                                            </button>
                                        </form>
                                    @endif


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
