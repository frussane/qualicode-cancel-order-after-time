<?php
    $tab = '';
    if(isset($_GET['tab']))
        $tab = sanitize_text_field($_GET['tab']);
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

    pre{
        background: white;
        border: 1px solid #c1c1c1;
        padding: 5px;
    }
</style>

<div class="fcapi-wrapper">
    <nav class="nav-tab-wrapper woo-nav-tab-wrapper">
        <a href="<?php echo esc_url(menu_page_url( $this->plugin_name.'-settings' , false)) ?>" class="nav-tab <?php echo ($tab == '' ? 'nav-tab-active' :  null )?>"><?php echo __('Cancel times','qualicode-cancel-order-after-time' ) ?></a>
        <a href="<?php echo esc_url(menu_page_url( $this->plugin_name.'-settings' , false).'&tab=settings') ?>" class="nav-tab <?php echo ($tab == 'settings' ? 'nav-tab-active' :  null )?>"><?php echo __('Settings','qualicode-cancel-order-after-time' ) ?></a>
        <a href="<?php echo esc_url(menu_page_url( $this->plugin_name.'-settings' , false).'&tab=emails') ?>" class="nav-tab <?php echo ($tab == 'emails' ? 'nav-tab-active' :  null )?>"><?php echo __('E-mails','qualicode-cancel-order-after-time' ) ?></a>
    </nav>

    <?php
        switch($tab){
            case 'settings':
                require_once "qualicode-cancel-order-after-time-admin-tab-settings.php";
                break;
            case 'emails':
                require_once "qualicode-cancel-order-after-time-admin-tab-emails.php";
                break;
            default:
                require_once "qualicode-cancel-order-after-time-admin-tab-general.php";
                break;

        }
    ?>

</div>