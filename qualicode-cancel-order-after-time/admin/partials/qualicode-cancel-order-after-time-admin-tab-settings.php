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

$orderStatus = wc_get_order_statuses();

if( isset($_POST['orderStatusToConsider']) ) {
    $activeStatus = $_POST['orderStatusToConsider'];
    update_option('qualicode-coat-order-statuses', json_encode($activeStatus));
}else{
    $activeStatus = json_decode(get_option('qualicode-coat-order-statuses'));
}

?>

    <h3><?php echo __('Select on which order status should this plugin act on','qualicode-cancel-order-after-time') ?></h3>
    <hr>
    <?php echo (isset($error) ?  $error : null); ?>
    <form method="POST">
        <?php
        foreach($orderStatus as $key => $values):?>
            <fieldset>
                <label>
                    <input type="checkbox" <?php echo (in_array($key, $activeStatus) ? 'checked="checked"' : null) ?> name="orderStatusToConsider[]" value="<?php echo $key ?>" />
                    <?php echo '<b>'.$values.'</b> ('.$key.')';?>
                </label>

            </fieldset>
        <?php endforeach; ?>
        <?php if($orderStatus): ?>
            <?php echo submit_button(); ?>
        <?php endif; ?>
    </form>