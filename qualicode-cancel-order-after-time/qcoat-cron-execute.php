<?php

require_once('../../../wp-load.php');

if(isset($_GET['key']) && $_GET['key'] == md5(AUTH_SALT)){
    $args = array(
        'limit' => '-1',
        'type'=> 'shop_order',
        'status'=> array( 'wc-on-hold','wc-pending' )
    );

    $orders = wc_get_orders($args);

    if($orders){
        foreach($orders as $order){
            $timestampWentToPayment = get_post_meta($order->get_id(), 'qualicode-coat-time-on-pending', true);
            if($timestampWentToPayment){
                $paymentMethod  = $order->get_payment_method();
                $hoursLimit     = get_option('qualicode-coat-'.$paymentMethod);
                if(!empty($hoursLimit) && $hoursLimit > 0){
                    $expiryEpoch = strtotime('+'.$hoursLimit.' minutes',$timestampWentToPayment);
                    $nowEpoch    = strtotime('now');
                    if($expiryEpoch <= $nowEpoch){
                        $order->update_status( 'cancelled', 'Order status automatically changed because of expired payment method' );
                        $order->save();
                    }
                }
            }
        }
    }
}