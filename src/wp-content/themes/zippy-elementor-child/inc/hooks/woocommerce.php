<?php

/**
 * Add bulk action remove uncategorized
 */

// 1. Register bulk action
add_filter('bulk_actions-edit-product', function ($actions) {
    $actions['remove_uncategorized'] = __('Remove Uncategorized', 'woocommerce');
    return $actions;
});

// 2. Handle bulk action
add_filter('handle_bulk_actions-edit-product', function ($redirect, $action, $product_ids) {

    if ($action !== 'remove_uncategorized') {
        return $redirect;
    }

    $uncat_id = get_option('default_product_cat'); // Uncategorized ID

    foreach ($product_ids as $product_id) {
        $terms = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'ids']);

        // Remove Uncategorized
        $terms = array_diff($terms, [$uncat_id]);

        // Must keep at least 1 category
        if (empty($terms)) {
            continue;
        }

        wp_set_post_terms($product_id, $terms, 'product_cat');
    }

    return add_query_arg('removed_uncategorized', count($product_ids), $redirect);
}, 10, 3);

// 3. Admin notice
add_action('admin_notices', function () {
    if (!empty($_GET['removed_uncategorized'])) {
        echo '<div class="notice notice-success"><p>';
        echo sprintf(
            __('Removed Uncategorized from %d products.', 'woocommerce'),
            intval($_GET['removed_uncategorized'])
        );
        echo '</p></div>';
    }
});

/**
 * End Add removed Uncategorized
 */
