@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <form action="{{ URL::to('admin/payment/update') }}" method="POST" class="payments" enctype="multipart/form-data">
                            @csrf
                            <div class="accordion accordion-flush" id="accordionExample">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($getpayment as $key => $pmdata)
                                    @php
                                        $transaction_type = $pmdata->id;
                                        $paymentname = $pmdata->payment_name;
                                        if ($transaction_type == 1) {
                                            $image_tag_name = 'cod_image';
                                        } elseif ($transaction_type == 2) {
                                            $image_tag_name = 'wallet_image';
                                        } elseif ($transaction_type == 3) {
                                            $image_tag_name = 'razorpay_image';
                                        } elseif ($transaction_type == 4) {
                                            $image_tag_name = 'stripe_image';
                                        } elseif ($transaction_type == 5) {
                                            $image_tag_name = 'flutterwave_image';
                                        } elseif ($transaction_type == 6) {
                                            $image_tag_name = 'paystack_image';
                                        } elseif ($transaction_type == 7) {
                                            $image_tag_name = 'mercadopago_image';
                                        } elseif ($transaction_type == 8) {
                                            $image_tag_name = 'myfatoorah_image';
                                        } elseif ($transaction_type == 9) {
                                            $image_tag_name = 'paypal_image';
                                        }elseif ($transaction_type == 10) {
                                            $image_tag_name = 'toyyibpay_image';
                                        }else {
                                            $image_tag_name = '';
                                        }
                                    @endphp
                                    <input type="hidden" name="transaction_type[]" value="{{ $transaction_type }}">
                                    <div class="accordion-item card rounded border mb-3">
                                        <h2 class="accordion-header" id="heading{{ $transaction_type }}">
                                            <button class="accordion-button rounded collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#targetto-{{ $i }}-{{ $transaction_type }}"
                                                aria-expanded="false"
                                                aria-controls="targetto-{{ $i }}-{{ $transaction_type }}">
                                                <b>{{ $paymentname }}</b>
                                            </button>
                                        </h2>
                                        <div id="targetto-{{ $i }}-{{ $transaction_type }}"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $transaction_type }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    @if (in_array($transaction_type, [3, 4, 5, 6,7,8,9,10]))
                                                        <div class="col-md-6">
                                                            <p class="form-label">{{ trans('labels.environment') }}</p>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="environment[{{ $transaction_type }}]" id="{{ $transaction_type }}_{{$key}}_environment" value="1" {{ $pmdata->environment == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="{{ $transaction_type }}_{{$key}}_environment"> {{ trans('labels.sandbox') }} </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="environment[{{ $transaction_type }}]" id="{{ $transaction_type }}_{{ $i }}_environment" value="2" {{ $pmdata->environment == 2 ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="{{ $transaction_type }}_{{ $i }}_environment"> {{ trans('labels.production') }} </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex justify-content-end align-items-center"> 
                                                            <input id="checkbox-switch-{{ $transaction_type }}" type="checkbox" class="checkbox-switch" name="is_available[{{ $transaction_type }}]" value="1" {{ $pmdata->is_available == 1 ? 'checked' : '' }}>
                                                            <label for="checkbox-switch-{{ $transaction_type }}" class="switch"> 
                                                                <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                                                                <span class="switch__left ps-2">{{ trans('labels.off') }}</span>
                                                                <span class="switch__right pe-2">{{ trans('labels.on') }}</span>
                                                            </label>
                                                        </div>
                                                        @if ($transaction_type == 7 || $transaction_type == 8)
                                                        <div class="col-md-12">
                                                        <input type="hidden"  id="{{ $transaction_type }}_publickey"  class="form-control" name="public_key[{{ $transaction_type }}]" placeholder="{{ trans('labels.public_key') }}" value="{{ $pmdata->public_key }}">
                                                        @elseif($transaction_type == 9)
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="{{ $transaction_type }}_publickey" class="form-label"> {{ trans('labels.client_id') }} </label>
                                                                <input type="text" required id="{{ $transaction_type }}_publickey"  class="form-control" name="public_key[{{ $transaction_type }}]" placeholder="{{ trans('labels.client_id') }}" value="{{ $pmdata->public_key }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">   
                                                        @else    
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="{{ $transaction_type }}_publickey" class="form-label"> {{ trans('labels.public_key') }} </label>
                                                                <input type="text" required id="{{ $transaction_type }}_publickey"  class="form-control" name="public_key[{{ $transaction_type }}]" placeholder="{{ trans('labels.public_key') }}" value="{{ $pmdata->public_key }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        @endif    
                                                            <div class="form-group">
                                                                <label for="{{ $transaction_type }}_secretkey" class="form-label"> {{ trans('labels.secret_key') }}</label>
                                                                <input type="text" required id="{{ $transaction_type }}_secretkey"  class="form-control" name="secret_key[{{ $transaction_type }}]" placeholder="{{ trans('labels.secret_key') }}" value="{{ $pmdata->secret_key }}">
                                                            </div>
                                                        </div>
                                                        @if ($transaction_type == 5)
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="encryption_key" class="form-label">{{ trans('labels.encryption_key') }} </label>
                                                                    <input type="text" required id="encryptionkey" class="form-control"  name="encryption_key" placeholder="{{ trans('labels.encryption_key') }}" value="{{ $pmdata->encryption_key }}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="image" class="form-label"> {{ trans('labels.image') }} </label>
                                                                <input type="file" class="form-control" name="{{ $image_tag_name }}"> 
                                                                <img src="{{ Helper::image_path($pmdata->image) }}" alt="" class="img-fluid rounded hw-50 mt-1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="{{ $transaction_type }}currency" class="form-label"> {{ trans('labels.currency') }} </label>
                                                                <input type="text" required id="{{ $transaction_type }}currency"  class="form-control" name="currency[{{ $transaction_type }}]" placeholder="{{ trans('labels.currency') }}" value="{{ $pmdata->currency }}">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="image" class="form-label"> {{ trans('labels.image') }} </label>
                                                                <input type="file" class="form-control" name="{{ $image_tag_name }}"> 
                                                                <img src="{{ Helper::image_path($pmdata->image) }}" alt="" class="img-fluid rounded hw-50 mt-1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex justify-content-end align-items-center"> 
                                                            <input id="checkbox-switch-{{ $transaction_type }}" type="checkbox" class="checkbox-switch" name="is_available[{{ $transaction_type }}]" value="1" {{ $pmdata->is_available == 1 ? 'checked' : '' }}>
                                                            <label for="checkbox-switch-{{ $transaction_type }}" class="switch"> 
                                                                <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                                                                <span class="switch__left ps-2">{{ trans('labels.off') }}</span>
                                                                <span class="switch__right pe-2">{{ trans('labels.on') }}</span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group text-end">
                                <button class="btn btn-primary" @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{trans('labels.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/payment.js') }}"></script>
@endsection
