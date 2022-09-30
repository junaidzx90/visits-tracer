<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Visits_Tracer
 * @subpackage Visits_Tracer/public/partials
 */
?>

<?php
$is_page_visits = $this->is_page_visits(get_post()->ID);
if(is_singular( 'post' )){
?>
<div id="vt_view">
    <input type="hidden" name="vt_post_id" value="<?php echo get_post()->ID ?>">
    <input type="hidden" name="vt_visits" value="<?php echo $this->get_visits_counts() ?>">
    <input type="hidden" name="is_page_visits" value="<?php echo (($is_page_visits) ? 'yes': 'no') ?>">
    <span class="minmaxbtn">Minimize</span>
    <div class="vt_contents">
        <h3 class="vt_alerts"></h3>
        <div class="hiddenAlert"></div>
        <h3 class="page_counts">
            Page: 
            <span class="page_visits"><?php echo $this->get_visits_counts() ?></span>
            <span>/</span>
            <span class="page_target"><?php echo ((get_option('vt_page_limit')) ? get_option('vt_page_limit'): 5) ?></span>
        </h3>
        <h3 class="vt_timer">Please wait <span class="run_timer">... seconds</span>.</h3>
        <div class="hiddenCode">
            <?php
            if(isset($_COOKIE['vt_unique_code'])){
                echo 'Code: <code>'.$_COOKIE['vt_unique_code'].'</code>';
            }
            ?>
        </div>
    </div>
</div>
<?php
}