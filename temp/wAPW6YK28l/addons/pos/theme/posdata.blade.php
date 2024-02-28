@foreach($getitem as $item)
<div class="col-md-6 col-lg-4">
    <div class="card" onclick="GetProductOverview('{{$item->id}}')">
        <img class="img-fluid image" src='{{$item["itemimage"]->image }}' alt="" style="height: 200px; width: 100%; object-fit: scale-down; background-color: #eee;">
        <div class="middle">
            <button href="#" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
        </div>
        <div class="card-body">
            <h5 class="card-title">
                {!! \Illuminate\Support\Str::limit(htmlspecialchars($item->item_name, ENT_QUOTES, 'UTF-8'), $limit = 18, $end = '...') !!}
            </h5>
            <h5 class="card-text">
                @foreach ($item->variation as $key => $value)
                    {{Auth::user()->currency}}{{number_format($value->product_price, 2)}}
                    @break
                @endforeach
            </h5>                                   
        </div>
    </div>
</div>
<!-- End Col -->
@endforeach