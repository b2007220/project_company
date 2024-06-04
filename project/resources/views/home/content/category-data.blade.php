    @foreach ($products as $product)
        <x-product-card :product-name="$product->name" :price="$product->price" :image-src="$product->pictures && $product->pictures->isNotEmpty() ? $product->pictures[0]->link : ''" :product-discount="$product->discounts && $product->discounts->isNotEmpty() ? $product->discounts[0]->discount : 0" :product-link="route('product', $product->id)" />
    @endforeach
    {!! $products->links() !!}
