@if (count($getitem) > 0)
    <div class="row item-list-view">
        @foreach ($getitem as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mt-4 mb-2">
                <div class="card card-section text-center">
                    @php
                        $image_name = $item['item_image']->image_name;
                        $image_url = $item['item_image']->image_url;
                    @endphp
                    @if ($item->addons_id != '' || count($item->variation) > 0)
                        <div class="ribbon"><span>{{ trans('labels.customizable') }}</span></div>
                    @endif
                    <img src="{{ $image_url }}" class="listing-view-image mx-auto" alt="...">
                    <div class="card-body py-3">
                        <h6 class="card-title fw-bold mb-2"> <img
                                @if ($item->item_type == 1) src="{{ Helper::image_path('veg.svg') }}" @else src="{{ Helper::image_path('nonveg.svg') }}" @endif
                                class="item-type-img" alt=""> {{ $item->item_name }}</h6>
                        <div class="item-details px-2">
                            <p class="d-flex justify-content-between my-0">{{ trans('labels.category') }}
                                <span>{{ @$item['category_info']->category_name }}</span></p>
                            <p class="d-flex justify-content-between my-0">{{ trans('labels.preparation_time') }}
                                <span>{{ $item->preparation_time }}</span></p>
                            <p class="d-flex justify-content-between my-0">{{ trans('labels.tax') }}
                                <span>{{ number_format($item->tax, 2) }}%</span></p>
                        </div>
                    </div>
                    <div class="card-footer py-0">
                        <div class="row justify-content-center">
                            @if ($item->addons_id != '' || count($item->variation) > 0)
                                <a class="btn px-2 text-dark"
                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="showitem('{{ $item->id }}','{{ URL::to('admin/pos/show-item') }}')" @endif><i
                                        class="fa fa-shopping-bag px-1"></i>{{ trans('labels.add_to_cart') }}</a>
                            @else
                                <a class="btn px-2 text-dark"
                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="addcart('{{ $item->id }}','{{ $item->item_name }}','{{ $item->item_type }}','{{ $image_name }}','{{ $item->tax }}','{{ $item->price }}','{{ URL::to('admin/pos/addtocart') }}')" @endif><i
                                        class="fa fa-shopping-bag px-1"></i>{{ trans('labels.add_to_cart') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            {{ $getitem->appends(request()->query())->links() }}
        </div>
    </div>
@else
    <div class="row">

        <div class="card col-md-12">
            <div class="card-body d-flex justify-content-center">
                <h4 class="card-header text-muted">{{ trans('labels.no_data') }}</h4>
            </div>
        </div>

    </div>
@endif
