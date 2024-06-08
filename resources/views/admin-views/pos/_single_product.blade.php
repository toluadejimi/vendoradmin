<div class="product-card card quick-View"
data-id="{{$product->id}}">
    <div class="card-header inline_product clickable p-0 initial--31">
        <div class="d-flex align-items-center justify-content-center h-100 d-block w-100 ">
            <img
            src="{{ \App\CentralLogics\Helpers::onerror_image_helper(
                $product['image'] ?? '',
                asset('storage/app/public/product').'/'.$product['image'] ?? '',
                asset('public/assets/admin/img/160x160/img2.jpg'),
                'product/'
            ) }}" 
            data-onerror-image="{{asset('public/assets/admin/img/160x160/img2.jpg')}}"
                class="w-100 h-100 object-cover onerror-image" alt="image">
        </div>
    </div>

    <div class="card-body inline_product text-center p-1 clickable initial--32">
        <div class="position-relative product-title1 text-dark font-weight-bold text-capitalize">
            {{ Str::limit($product['name'], 12,'...') }}
        </div>
        <div class="justify-content-between text-center">
            <div class="product-price text-center">

                <span class="text-accent text-dark font-weight-bold">
                    {{\App\CentralLogics\Helpers::format_currency($product['price']-\App\CentralLogics\Helpers::product_discount_calculate($product, $product['price'], $store_data)['discount_amount'])}}
                </span>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('public/assets/admin')}}/js/view-pages/common.js"></script>
