@extends('layouts.admin.app')

@section('title',translate('messages.Payment Method'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->

        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('/public/assets/admin/img/payment.png')}}" class="w--22" alt="">
                </span>
                <span>
                    {{translate('messages.payment_gateway_setup')}}
                </span>
            </h1>
            @include('admin-views.business-settings.partials.third-party-links')
            <div class="d-flex flex-wrap justify-content-end align-items-center flex-grow-1">
                <div class="blinkings trx_top active">
                    <i class="tio-info-outined"></i>
                    <div class="business-notes">
                        <h6><img src="{{asset('/public/assets/admin/img/notes.png')}}" alt=""> {{translate('Note')}}</h6>
                        <div>
                            {{translate('Without configuring this section functionality will not work properly. Thus the whole system will not work as it planned')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card border-0">
            <div class="card-header card-header-shadow">
                <h5 class="card-title align-items-center">
                    <img src="{{asset('/public/assets/admin/img/payment-method.png')}}" class="mr-1" alt="">
                    {{translate('Payment Method')}}
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('cash_on_delivery'))
                        <form action="{{route('admin.business-settings.third-party.payment-method-update',['cash_on_delivery'])}}"
                            method="post" id="cash_on_delivery_status_form">
                            @csrf
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        {{translate('Cash On Delivery')}}
                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="{{translate('If_enabled_Customers_will_be_able_to_select_COD_as_a_payment_method_during_checkout')}}"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input type="hidden" name="toggle_type" value="cash_on_delivery">
                                <input
                                    type="checkbox" id="cash_on_delivery_status"
                                    data-id="cash_on_delivery_status"
                                    data-type="status"
                                    data-image-on="{{ asset('/public/assets/admin/img/modal/digital-payment-on.png') }}"
                                    data-image-off="{{ asset('/public/assets/admin/img/modal/digital-payment-off.png') }}"
                                    data-title-on="{{ translate('By Turning ON Cash On Delivery Option') }}"
                                    data-title-off="{{ translate('By Turning OFF Cash On Delivery Option') }}"
                                    data-text-on="<p>{{ translate('Customers will not be able to select COD as a payment method during checkout. Please review your settings and enable COD if you wish to offer this payment option to customers.') }}</p>"
                                    data-text-off="<p>{{ translate('Customers will be able to select COD as a payment method during checkout.') }}</p>"
                                    class="status toggle-switch-input dynamic-checkbox"
                                       name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                    <div class="col-md-4">
                        @php($digital_payment=\App\CentralLogics\Helpers::get_business_settings('digital_payment'))
                        <form action="{{route('admin.business-settings.third-party.payment-method-update',['digital_payment'])}}"
                            method="post" id="digital_payment_status_form">
                            @csrf
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        {{translate('digital payment')}}
                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="{{translate('If_enabled_Customers_will_be_able_to_select_digital_payment_as_a_payment_method_during_checkout')}}"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input type="hidden" name="toggle_type" value="digital_payment">
                                <input  type="checkbox" id="digital_payment_status"
                                       data-id="digital_payment_status"
                                       data-type="status"
                                       data-image-on="{{ asset('/public/assets/admin/img/modal/digital-payment-on.png') }}"
                                       data-image-off="{{ asset('/public/assets/admin/img/modal/digital-payment-off.png') }}"
                                       data-title-on="{{ translate('By Turning ON Digital Payment Option') }}"
                                       data-title-off="{{ translate('By Turning OFF Digital Payment Option') }}"
                                       data-text-on="<p>{{ translate('Customers will not be able to select digital payment as a payment method during checkout. Please review your settings and enable digital payment if you wish to offer this payment option to customers.') }}</p>"
                                       data-text-off="<p>{{ translate('Customers will be able to select digital payment as a payment method during checkout.') }}</p>"
                                       class="status toggle-switch-input dynamic-checkbox"
                                       name="status" value="1" {{$digital_payment?($digital_payment['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                    <div class="col-md-4">
                        @php($Offline_Payment=\App\CentralLogics\Helpers::get_business_settings('offline_payment_status'))
                        <form action="{{route('admin.business-settings.third-party.payment-method-update',['offline_payment_status'])}}"
                            method="post" id="offline_payment_status_form">
                            @csrf
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        {{translate('Offline_Payment')}}
                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="{{translate('If_enabled_Customers_will_be_able_to_select_offline_payment_as_a_payment_method_during_checkout')}}"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input type="hidden" name="toggle_type" value="offline_payment_status" >
                                <input  type="checkbox" id="offline_payment_status"
                                        data-id="offline_payment_status"
                                        data-type="status"
                                        data-image-on="{{ asset('/public/assets/admin/img/modal/digital-payment-on.png') }}"
                                        data-image-off="{{ asset('/public/assets/admin/img/modal/digital-payment-off.png') }}"
                                        data-title-on="{{ translate('By Turning ON Offline Payment Option') }}"
                                        data-title-off="{{ translate('By Turning OFF Offline Payment Option') }}"
                                        data-text-on="<p>{{ translate('Customers will not be able to select Offline Payment as a payment method during checkout. Please review your settings and enable Offline Payment if you wish to offer this payment option to customers.') }}</p>"
                                        data-text-off="<p>{{ translate('Customers will be able to select Offline Payment as a payment method during checkout.') }}</p>"
                                        class="status toggle-switch-input dynamic-checkbox"

                                        name="status" value="1" {{$Offline_Payment == 1?'checked':''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($published_status == 1)
        <br>
        <div>
            <div class="card">
                <div class="card-body d-flex flex-wrap justify-content-around">
                    <h4 class="w-50 flex-grow-1 module-warning-text">
                        <i class="tio-info-outined"></i>
                    {{ translate('Your_current_payment_settings_are_disabled,_because_you_have_enabled_payment_gateway_addon,_To_visit_your_currently_active_payment_gateway_settings_please_follow_the_link.') }}</h4>
                    <div>
                        <a href="{{!empty($payment_url) ? $payment_url : ''}}" class="btn btn-outline-primary"> <i class="tio-settings"></i> {{translate('Settings')}}</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @php($is_published = $published_status == 1 ? 'inactive' : '')
        <!-- Tab Content -->
        <div class="row digital_payment_methods  {{ $is_published }} mt-3 g-3">
            @foreach($data_values as $payment_key => $payment)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update'):'javascript:'}}" method="POST"
                              id="{{$payment->key_name}}-form" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header d-flex flex-wrap align-content-around">
                                <h5>
                                    <span class="text-uppercase">{{str_replace('_',' ',$payment->key_name)}}</span>
                                </h5>
                                <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                    <span
                                        class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('on') }}</span>
                                    <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('off') }}</span>
                                    <input type="checkbox" name="status" value="1"
                                           class="toggle-switch-input" {{$payment['is_active']==1?'checked':''}}>
                                    <span class="toggle-switch-label text">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                </label>
                            </div>

                            @php($additional_data = $payment['additional_data'] != null ? json_decode($payment['additional_data']) : [])
                            <div class="card-body">
                                <div class="payment--gateway-img">
                                    <img  id="{{$payment->key_name}}-image-preview" class="__height-80 onerror-image"
                                    data-onerror-image="{{asset('/public/assets/admin/img/payment/placeholder.png')}}"

                                @if ($additional_data != null)
                                    src="{{ \App\CentralLogics\Helpers::onerror_image_helper(
                                        $additional_data?->gateway_image,
                                        asset('storage/app/public/payment_modules/gateway_image').'/'.$additional_data?->gateway_image,
                                        asset('/public/assets/admin/img/payment/placeholder.png'),
                                        'payment_modules/gateway_image/'
                                    ) }}"

                                @else
                                src="{{asset('/public/assets/admin/img/payment/placeholder.png')}}"
                                @endif



                                         alt="public">
                                </div>

                                <input name="gateway" value="{{$payment->key_name}}" class="d-none">

                                @php($mode=$data_values->where('key_name',$payment->key_name)->first()->live_values['mode'])
                                <div class="form-floating mb-2" >
                                    <select class="js-select form-control theme-input-style w-100" name="mode">
                                        <option value="live" {{$mode=='live'?'selected':''}}>{{ translate('Live') }}</option>
                                        <option value="test" {{$mode=='test'?'selected':''}}>{{ translate('Test') }}</option>
                                    </select>
                                </div>

                                @php($skip=['gateway','mode','status'])
                                @foreach($data_values->where('key_name',$payment->key_name)->first()->live_values as $key=>$value)
                                    @if(!in_array($key,$skip))
                                        <div class="form-floating mb-2" >
                                            <label for="{{$payment_key}}-{{$key}}"
                                                   class="form-label">{{ucwords(str_replace('_',' ',$key))}}
                                                *</label>
                                            <input id="{{$payment_key}}-{{$key}}" type="text" class="form-control"
                                                   name="{{$key}}"
                                                   placeholder="{{ucwords(str_replace('_',' ',$key))}} *"
                                                   value="{{env('APP_ENV')=='demo'?'':$value}}">
                                        </div>
                                    @endif
                                @endforeach

                                @if($payment['key_name'] == 'paystack')
                                    <div class="form-floating mb-2" >
                                        <label for="Callback_Url" class="form-label">{{translate('Callback Url')}}</label>
                                        <input id="Callback_Url" type="text"
                                               class="form-control"
                                               placeholder="{{translate('Callback Url')}} *"
                                               readonly
                                               value="{{env('APP_ENV')=='demo'?'': route('paystack.callback')}}" {{$is_published}}>
                                    </div>
                                @endif

                                <div class="form-floating mb-2" >
                                    <label for="payment_gateway_title-{{$payment_key}}"
                                           class="form-label">{{translate('payment_gateway_title')}}</label>
                                    <input type="text" class="form-control"
                                           name="gateway_title" id="payment_gateway_title-{{$payment_key}}"
                                           placeholder="{{translate('payment_gateway_title')}}"
                                           value="{{$additional_data != null ? $additional_data->gateway_title : ''}}">
                                </div>

                                <div class="form-floating mb-2" >
                                    <label for="exampleFormControlInput1"
                                           class="form-label">{{translate('logo')}}</label>
                                    <input type="file" class="form-control" name="gateway_image" id="{{$payment->key_name}}-image" accept=".jpg, .png, .jpeg|image/*">
                                </div>

                                <div class="text-right mt-2 "  >
                                    <button type="submit" class="btn btn-primary px-5">{{translate('save')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- End Tab Content -->
    </div>





@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin/js/view-pages/business-settings-payment-page.js')}}"></script>
<script>
    "use strict";
    @if(!isset($digital_payment) || $digital_payment['status']==0)
        $('.digital_payment_methods').hide();
    @endif
</script>
@endpush
