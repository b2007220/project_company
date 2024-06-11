@foreach ($products as $product)
    @php
        $productDiscount = 0;
        if ($product->discounts && $product->discounts->isNotEmpty()) {
            foreach ($product->discounts as $discount) {
                if ($discount->pivot->is_predefined) {
                    $productDiscount += $discount->discount;
                }
            }
        }
    @endphp
    <x-product-card :product-name="$product->name" :price="$product->price" :image-src="$product->pictures && $product->pictures->isNotEmpty() ? $product->pictures[0]->link : ''" :product-discount="$product->discounts && $product->discounts->isNotEmpty() ? $productDiscount : 0" :product-link="route('product', $product->id)" />
@endforeach
