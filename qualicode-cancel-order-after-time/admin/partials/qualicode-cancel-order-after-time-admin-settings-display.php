<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://qualicode.pt
 * @since      1.0.0
 *
 * @package    Qualicode_CancelOrderAfterTime
 * @subpackage Qualicode_CancelOrderAfterTime/admin/partials
 */

$gateways = WC()->payment_gateways->get_available_payment_gateways();
$enabled_gateways = [];
if( $gateways ) {
    foreach( $gateways as $key => $gateway ) {
        if( $gateway->enabled == 'yes' ) {
            $enabled_gateways[$key] = $gateway;
            if(isset($_POST['qualicode-coat-'.$key])){
                if($_POST['qualicode-coat-'.$key] == '')
                    delete_option('qualicode-coat-'.$key, $_POST['qualicode-coat-'.$key]);
                else
                    update_option('qualicode-coat-'.$key, $_POST['qualicode-coat-'.$key]);

            }

        }
    }
}else{
    $error = __('No payment methods are active on WooCommerce','qualicode-cancel-order-after-time');
}

//settings save
$success = false;

?>

<style>
    .qtranxs-lang-switch-wrap{
        display:none;
    }
    .fcapi-wrapper{
        margin-top:25px;
        padding: 15px;
    }
    .fcapi-wrapper input[type="text"]{
        width: 100%;
        max-width: 500px;
    }
    .fcapi-wrapper fieldset{
        margin-top: 25px;
    }
</style>

<div class="fcapi-wrapper">
    <h1><?php echo __('Select your settings for each payment service','qualicode-cancel-order-after-time') ?></h1>
    <p>
        <b><?php echo __('Use 0 (zero) for never expiring, or define the expiry hours for each payment')?> <br> <small><?php echo __('Supported WooCommerce order statuses:')  ?> processing | on-hold </small> </b>
        <br><br>
        Define a CronJob on this URL every minute to execute order cleaning:<br>
        wget -q -O /dev/null "<?php echo plugin_dir_url('qualicode-cancel-order-after-time').'qualicode-cancel-order-after-time/qcoat-cron-execute.php?key='.md5(AUTH_SALT) ?>"
    </p>
    <hr> 
    <?php echo (isset($error) ?  $error : null); ?>
    <form method="POST">
        <?php
        foreach($enabled_gateways as $key => $values):?>
            <fieldset>
                <label for="qualicode-coat-<?php echo $key ?>"><?php echo $values->title ?></label><br/>
                <input type="number" min="0" id="qualicode-coat-<?php echo $key ?>" placeholder="" name="qualicode-coat-<?php echo $key ?>" value="<?php echo get_option('qualicode-coat-'.$key); ?>"> minute(s)
            </fieldset>

        <?php endforeach; ?>
        <?php if($enabled_gateways): ?>
            <?php echo submit_button(); ?>
        <?php endif; ?>
    </form>

</div>