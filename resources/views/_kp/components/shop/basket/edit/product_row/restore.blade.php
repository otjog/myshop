<span class="text-muted">Товар был удален из корзины.</span>
<form class="shop-buy-form " method="post" role="form" action="{{route('baskets.store')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="product_id" value="{{ $product->id}}">
    <input type="hidden" name="quantity" value="1" >
    <input class="btn btn-link" type="submit" value="Восстановить" />
</form>