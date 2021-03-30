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
                update_option('qualicode-coat-'.$key, json_encode($_POST['qualicode-coat-'.$key]));
            }

        }
    }
}else{
    $error = __('No payment methods are active on WooCommerce','qualicode-cancel-order-after-time');
}

//settings save
$success = false;
?>

    <h3><?php echo __('Select your settings for each payment service','qualicode-cancel-order-after-time') ?></h3>
        <?php echo __('Configure the following CronJob on your host in order for the plugin to be activelly running - we advide running it every minute, to ensure precision','qualicode-cancel-order-after-time') ?>
        <pre>wget -q -O /dev/null "<?php echo plugin_dir_url('qualicode-cancel-order-after-time').'qualicode-cancel-order-after-time/qcoat-cron-execute.php?key='.md5(AUTH_SALT) ?>"</pre>

    <hr>
    <?php echo (isset($error) ?  $error : null); ?>
    <form class="qualicode-flex-form" method="POST">
        <div class="form_wrapper_grid">
            <?php
            foreach($enabled_gateways as $key => $values):?>
                <?php
                    $gatewayOptions = (array)json_decode(get_option('qualicode-coat-'.$key));
                ?>
                <fieldset class="qualicode-block">
                    <label for="qualicode-coat-<?php echo $key ?>"><?php echo $values->title ?></label><br/>
                    <input <?php echo ($gatewayOptions['time_unit'] == 'off' ? 'disabled' : null) ?> class="input-coat" type="number" min="1" id="qualicode-coat-<?php echo $key ?>" placeholder="" name="qualicode-coat-<?php echo $key ?>[time]" value="<?php echo $gatewayOptions['time'] ?>">
                    <select class="change-qualic-event" name="qualicode-coat-<?php echo $key ?>[time_unit]">
                        <option <?php echo ($gatewayOptions['time_unit'] == 'off' ? 'selected' : null) ?> value="off"><?php echo __('Off','qualicode-cancel-order-after-time')  ?></option>
                        <option <?php echo ($gatewayOptions['time_unit'] == 'minutes' ? 'selected' : null) ?> value="minutes"><?php echo __('Minutes','qualicode-cancel-order-after-time')  ?></option>
                        <option <?php echo ($gatewayOptions['time_unit'] == 'hours' ? 'selected' : null) ?> value="hours"><?php echo __('Hours','qualicode-cancel-order-after-time')  ?></option>
                        <option <?php echo ($gatewayOptions['time_unit'] == 'days' ? 'selected' : null) ?> value="days"><?php echo __('Days','qualicode-cancel-order-after-time')  ?></option>
                    </select>
<!--                    <label style="font-weight:400"><input type="checkbox" name="qualicode-coat---><?php //echo $key ?><!--[cancel_email]" value="1">--><?php //echo __('Send cancelation e-mail','qualicode-cancel-order-after-time') ?><!--</label>-->
                </fieldset>

            <?php endforeach;


            ?>
        </div>




        <?php if($enabled_gateways): ?>
            <?php echo submit_button(); ?>
        <?php endif; ?>
    </form>

<style>
    .form_wrapper_grid{
        display:grid;
        grid-template-columns: repeat(5, 1fr);
        grid-column-gap: 20px;
        grid-row-gap: 20px;
    }

    .form_wrapper_grid fieldset.qualicode-block{
        width:100%;
        background:white;
        overflow:hidden;
        border-radius: 5px;
        padding: 15px;
        margin-top: 0;
        box-sizing: border-box;
        text-align:center;
        height:175px;
    }

    .form_wrapper_grid fieldset.qualicode-block label{
        font-weight: bold;
        display:block;
    }

    .form_wrapper_grid fieldset.qualicode-block input[type="number"]{
        border: 0;
        border-bottom: 1px solid #c3c3c3;
        border-radius: 0;
        display:block;
        margin: 0 auto;
        text-align:center;
        max-width:100px;
        margin-bottom: 5px;
    }

    .form_wrapper_grid select,
    .form_wrapper_grid select:focus,
    .form_wrapper_grid select:active{
        border:none;
        box-shadow:none;
    }

</style>

<script>
    jQuery(document).on('change','.change-qualic-event', function(ev){
        let val = jQuery(ev.target).val();
        if(val == 'off'){
            hideInputText(ev.target)
        }else{
            showInputText(ev.target);
        }
    });

    function hideInputText(selectEl){
        jQuery(selectEl).siblings( ".input-coat" ).prop('disabled',true);
    }

    function showInputText(selectEl){
        jQuery(selectEl).siblings( ".input-coat" ).prop('disabled',false);
        jQuery(selectEl).siblings( ".input-coat" ).val(1);
    }

</script>