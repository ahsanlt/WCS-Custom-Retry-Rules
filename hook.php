<?php

function eg_my_custom_retry_rule( $rule_raw, $retry_number, $order_id ) {

	$curl = curl_init();

	$arr = array(
		'retry_number' => $retry_number,
		'order_id' => $order_id
	);

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://76710bc1a82e89b75a60d4c4f4476542.m.pipedream.net',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_POSTFIELDS => json_encode( $arr ),
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);

	if( $retry_number == 0 ) {
		$tag = 'FailedPayment1st';
		
		if( $retry_number == 3 ) {
			$tag = 'FailedPayment4th';
		}
		
		$order = wc_get_order( $order_id );
		$billing_email  = $order->get_billing_email();
		
		$plaintext = $order_id;
		$cipher = "AES-256-CBC";
		$key = "nd33kald";
		$iv = "ah7dk20s";
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, 0, $iv);
		$cc = base64_encode($ciphertext);

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://apricity.api-us1.com/admin/api.php?api_action=contact_sync&api_key=7f94e31128b15f09534ccd989eeaad7da5766ddcd30f7e0cc541510ac8144242031b34ca&api_output=json',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'email='.$billing_email.'&tags='.$tag.'&field%5B%25FAILED_PAYMENT_HASH%25%2C0%5D='.$cc,
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Cookie: PHPSESSID=f7567ba137b33eaeee9d3e710ee2cf99; em_acp_globalauth_cookie=9e77c6e5-45dc-4fa1-823b-d8d3f83fe437'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

	}

    return $rule_raw;
}
//add_filter( 'wcs_get_retry_rule_raw', 'eg_my_custom_retry_rule', 10, 3 );

