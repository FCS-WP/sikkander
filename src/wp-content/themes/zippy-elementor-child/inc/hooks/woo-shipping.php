<?php

// add_filter('woocommerce_package_rates', 'inspect_shipping_rates', 10, 2);
function inspect_shipping_rates($rates, $package)
{

    $is_enabled = true;

    if (!$is_enabled) {
        return $rates;
    }

    $cart = WC()->cart;
    foreach ($rates as $rate_key => $rate) {
        if ($rate->get_method_id() !== 'flat_rate') {
            continue;
        }
        if (is_valid_for_free_shipping($cart)) {
            $rate->set_label('Free Shipping');
            $rate->set_cost(0);
            continue;
        }
    }
    return $rates;
}

function is_valid_for_free_shipping($cart)
{
    $limit_rate      = 100;
    $limit_items     = 2;
    $valid_categories = [''];

    $counter_items = 0;
    $cart_items    = $cart->get_cart();
    $bill_total = $cart->get_cart_contents_total();

    if ($bill_total > $limit_rate) {
        return true;
    }

    foreach ($cart_items as $item) {
        // Check if product belongs to any valid category
        if (has_term($valid_categories, 'product_cat', $item['product_id'])) {
            $counter_items += $item['quantity'];
        }
    }

    if ($counter_items > $limit_items) {
        return true;
    }

    return false;
}
