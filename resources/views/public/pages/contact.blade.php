@extends('public.layouts.app')
@section('content')
    <div class="site__body">

        <div class="block-header block-header--has-breadcrumb block-header--has-title">
            <div class="container">
                <div class="block-header__body">

                    <h1 class="block-header__title">Contact Us</h1>
                </div>
            </div>
        </div>
        <div class="block mb-5">
            <div class="container container--max--lg">
                <div class="card">
                    <div class="card-body card-body--padding--2">
                        <div class="row">
                            <div class="col-12 col-lg-6 pb-4 pb-lg-0">
                                <div class="mr-1">
                                    <h4 class="contact-us__header card-title">Our Address</h4>
                                    <div class="contact-us__address">
                                        {{-- <p>
                                            Bengaluru,Karnataka<br />Email:
                                            admin@steelghar.com<br />Phone Number:+91 7678675645
                                        </p> --}}
                                        <p>
                                            Bengaluru,Karnataka<br />Email:
                                            {{ $settings->email }}<br />Phone Number:+91 {{ $settings->phone }}
                                        </p>
                                        <p>
                                            <strong>Comment</strong><br />Thank you for your interest in Steel Ghar. At
                                            Steel Ghar, customer satisfaction is our priority. We look forward to hearing
                                            from you and assisting you with all your steel needs.
                                        </p>
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

        <div class="block-map mb-0 block">
            <div class="block-map__body">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15547.060895167795!2d77.6870402!3d13.0506107!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1156ce4e8687%3A0x7bbc95e824eea77f!2sSteel%20Ghar!5e0!3m2!1sen!2sin!4v1731558660979!5m2!1sen!2sin"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
