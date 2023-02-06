@extends('layouts.nologin')

@section('content')


					 @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
	
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" method="POST" action="{{ route('password.email') }}">
							  @csrf
  
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">Forgot Password ?</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Enter your email to reset your password.</div>
								<!--end::Link-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-gray-900 fs-6">{{ __('E-Mail Address') }}</label>
								<input class="form-control form-control-solid @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required  type="email" autocomplete="off" />
								  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="d-flex flex-wrap justify-content-center pb-lg-0">
								<button type="submit" id="" class="btn btn-lg btn-primary fw-bolder me-4" >
									<span class="indicator-label"> {{ __('Send Password Reset Link') }}</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<a class="btn btn-lg btn-danger "href="{{route('login')}}"> Back  To login </a>
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					
 @endsection 