<?php

function eg_my_custom_retry_rule( $rule_raw, $retry_number, $order_id ) {

	if( $retry_number == 0 ) {
		$tag = 'FailedPayment1st';
		
		if( $retry_number == 3 ) {
			$tag = 'FailedPayment4th';
		}
		
		$order = wc_get_order( $order_id );
		$billing_email  = $order->get_billing_email();
    
    $user = get_user_by('email', $billing_email );
		
		$plaintext = $order_id;
		$cipher = "AES-256-CBC";
		$key = "nd33kald";
		$iv = "ah7dk20s";
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, 0, $iv);
		$cc = base64_encode($ciphertext);

		$update_data = array(
      'retry_key' => $cc
    )

    wp_fusion()->user->push_user_meta( $user->ID, $update_data );
    
    $tags = array($tag);
    wp_fusion()->user->apply_tags( $tags );

	}

    return $rule_raw;
}
//add_filter( 'wcs_get_retry_rule_raw', 'eg_my_custom_retry_rule', 10, 3 );
