<div class="product-price">
    <strong id="chosen_price" class="h4 fw-600 text-primary">
        @if ($product_stock)
            {{ single_price($product_stock->price * $qty - $detailedProduct->trade_old_battery_price) }}
        @else
            {{ single_price($detailedProduct->unit_price * $qty - $detailedProduct->trade_old_battery_price) }}
        @endif
    </strong>
</div>
