<?php

function custom_retry_rules( $default_retry_rules_array ) {
    return array(
            array(
                'retry_after_interval'            => 1 * DAY_IN_SECONDS,
                'email_template_customer'         => '',
                'email_template_admin'            => 'WCS_Email_Payment_Retry',
                'status_to_apply_to_order'        => 'pending',
                'status_to_apply_to_subscription' => 'active',
            ),
            array(
                'retry_after_interval'            => 3 * DAY_IN_SECONDS,
                'email_template_customer'         => '', 
                'email_template_admin'            => '',
                'status_to_apply_to_order'        => 'pending',
                'status_to_apply_to_subscription' => 'active',
            ),
            array(
                'retry_after_interval'            => WEEK_IN_SECONDS,
                'email_template_customer'         => '', 
                'email_template_admin'            => '',
                'status_to_apply_to_order'        => 'pending',
                'status_to_apply_to_subscription' => 'on-hold',
            ),
            array(
                'retry_after_interval'            => 10 * DAY_IN_SECONDS,
                'email_template_customer'         => '', 
                'email_template_admin'            => '',
                'status_to_apply_to_order'        => 'pending',
                'status_to_apply_to_subscription' => 'on-hold',
            ),
            array(
                'retry_after_interval'            => 14 * DAY_IN_SECONDS,
                'email_template_customer'         => '', 
                'email_template_admin'            => 'WCS_Email_Payment_Retry',
                'status_to_apply_to_order'        => 'pending',
                'status_to_apply_to_subscription' => 'on-hold',
            ),
        );
}
add_filter( 'wcs_default_retry_rules', 'custom_retry_rules' );


