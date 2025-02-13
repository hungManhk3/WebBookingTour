@extends('layouts.client')
@section('content')
    <div class="banner-title mb-5">
        <img src="{{ asset('images/bg-rice.png') }}" alt="banner title">
        <p class="title" style="color:rgb(234, 239, 243)">Liên hệ với chúng tôi</p>
    </div>
    <div class="box-contact">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <p class="contact-title">Chúng tôi luôn lắng nghe những góp ý của bạn</p>
                    <p class="contact-text">Gửi cho chúng tôi một tin nhắn, chúng tôi sẽ phản hồi bạn sớm nhất có thể</p>
                    <form action="{{ route('client.contact.store') }}" class="form-contact" id="formContact" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" placeholder="Tên của bạn" name="name" value="{{ old('name') }}">
                            <span class="text-danger" id="errorName"></span>
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="Email của bạn" name="email" value="{{ old('email') }}">
                            <span class="text-danger" id="errorEmail"></span>
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại của bạn" name="phone" value="{{ old('phone') }}">
                            <span class="text-danger" id="errorPhone"></span>
                            @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="message" rows="5" placeholder="Nội dung" name="message">{{ old('message') }}</textarea>
                            <span class="text-danger" id="errorMessage"></span>
                            @error('message')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-100 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Gửi lời nhắn</button>
                        </div>
                    </form>
                </div>
{{--                 
                <div class="col-12 col-lg-6">
                    <div class="office">
                        <img class="office-background" src="{{ asset('images/introduce2.png') }}" alt="introduce">
                        <div class="info-office">
                            <p class="office-title">Địa chỉ</p>
                            <div class="info-office-item">
                                <img src="{{ asset('images/icon/home.svg') }}" alt="address">
                                <div class="text-item">
                                    <p class="text-title">Địa chỉ</p>
                                    <p class="text-content">Thường Tín, Hà Nội</p>
                                </div>
                            </div>
                            <div class="info-office-item">
                                <img src="{{ asset('images/icon/phone.svg') }}" alt="phone">
                                <div class="text-item">
                                    <p class="text-title">Số điện thoại</p>
                                    <p class="text-content">+84 356 960 603</p>
                                </div>
                            </div>
                            <div class="info-office-item">
                                <img src="{{ asset('images/icon/email.svg') }}" alt="email">
                                <div class="text-item">
                                    <p class="text-title">Email</p>
                                    <p class="text-content">hungmanh@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 --}}
            </div>
        </div>
    </div>
    <div class="box-map-contact">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.7177028715264!2d105.83952637471378!3d21.00395018863132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac775d1a29b1%3A0x47ca351d075745a6!2zNTUgxJAuIEdp4bqjaSBQaMOzbmcsIMSQ4buTbmcgVMOibSwgSGFpIELDoCBUcsawbmcsIEjDoCBO4buZaSAxMDAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1729000251468!5m2!1svi!2s" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
@endsection
@section('js')
    <script>
        @if($errors->any())
        document.getElementById("formContact").scrollIntoView();
        @endif
    </script>
@endsection
