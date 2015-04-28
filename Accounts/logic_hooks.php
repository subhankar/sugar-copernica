<?php

    $hook_version = 1;
    $hook_array = Array();

    $hook_array['after_save'] = Array();
    $hook_array['after_save'][] = Array(
        //Processing index. For sorting the array.
        1,
       
        //Label. A string value to identify the hook.
        'after_save example',
       
        //The PHP file where your class is located.
        'custom/modules/Accounts/copernica_logic_hook.php',
       
        //The class the method is in.
        'copernica_class',
       
        //The method to call.
        'updateCopernica'
    );

?>