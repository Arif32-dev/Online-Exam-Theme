<?php
global $wpdb;
$table = $wpdb->prefix . 'department';
$dept_data = $wpdb->get_results("SELECT * FROM " . $table . "");
foreach ($dept_data as $dept) {

    ?>
     <a><?php echo $dept->dept_name ?></a>
    <?php

}