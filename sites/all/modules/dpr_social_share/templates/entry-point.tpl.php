<?php
//drupal_add_js(drupal_get_path('module', 'dpr_social_share') . '/scripts/dpr-social-share.js');

drupal_add_css(drupal_get_path('module', 'dpr_social_share') . '/css/dpr-social-share.css', array('group' => CSS_DEFAULT));
?>
<div id="dpr_social_share">
    <?php
    module_load_include('php', 'dpr_social_share', '/templates/social-share-popover.tpl');
    ?>
</div>