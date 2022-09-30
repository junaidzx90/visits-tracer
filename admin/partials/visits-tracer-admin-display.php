<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Visits_Tracer
 * @subpackage Visits_Tracer/admin/partials
 */
?>

<?php
$defaultZone = wp_timezone_string();
if($defaultZone){
    date_default_timezone_set($defaultZone);
}

$tomorrow = strtotime("tomorrow");
$todaysCodes = get_option("vt_results_$tomorrow");
?>

<h3>Todays Codes</h3>
<hr>

<div class="vt_filter">
    <label for="vt_filter">Search code</label>
    <input type="text" placeholder="code" id="vt_filter">
</div>
<div id="vt_codes">
    <?php
    if(is_array($todaysCodes)){
        foreach($todaysCodes as $code){
            echo '<div class="vt_code">'.$code.'</div>';
        }
    }
    ?>
</div>