<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$map_path = array(
    1 => array('title' => 'Dashbord',
        'page' => array(
            'process_login' => 'mod_login/login_process.php',
            'register' => 'mod_login/register.php',
            'register_add' => 'mod_login/register_add.php',
            'index' => 'mod_main/index.php',
            'tabs' => 'mod_main/tabs.php',
            'module_main_grid' => 'mod_main/module_main_grid.php',
            'application_main_grid' => 'mod_main/application_main_grid.php',
            'user_directory_grid' => 'mod_main/user_directory_grid.php',
            'user_main_grid' => 'mod_main/user_main_grid.php',
            'user_main_grid_edit' => 'mod_main/user_main_grid_edit.php',
            'user_main_grid_edit_save' => 'mod_main/user_main_grid_edit_save.php',
            'user_main_grid_delete' => 'mod_main/user_main_grid_delete.php',
            'user_main_grid_add' => 'mod_main/user_main_grid_add.php',
            'user_main_grid_add_save' => 'mod_main/user_main_grid_add_save.php',
            'assign_role_grid' => 'mod_main/assign_role_grid.php',
            'user_role_grid' => 'mod_main/user_role_grid.php',
            'system_main_grid' => 'mod_main/system_main_grid.php',
            'campus_code_grid' => 'mod_main/master/campus_code_grid.php',
            'building_code_grid' => 'mod_main/master/building_code_grid.php',
            'area_code_grid' => 'mod_main/master/area_code_grid.php',
            'level_code_grid' => 'mod_main/master/level_code_grid.php',
            'location_main_grid' => 'mod_main/master/location_main_grid.php',
            'location_code_grid' => 'mod_main/master/location_code_grid.php',
        )
    ),
    2 => array('title' => 'Asset Management',
        'page' => array(
            'index' => 'mod_asset/index.php',
            'view_asset_grid' => 'mod_asset/view_asset_grid.php',
            'generate_barcode' => 'mod_asset/generate_barcode.php',
            'view_asset_add' => 'mod_asset/view_asset_add.php',
            'view_asset_add_save' => 'mod_asset/view_asset_add_save.php',
            'view_asset_edit' => 'mod_asset/view_asset_edit.php',
            'view_asset_edit_save' => 'mod_asset/view_asset_edit_save.php',
            'view_asset_upload' => 'mod_asset/view_asset_upload.php',
            'view_asset_upload_delete' => 'mod_asset/view_asset_upload_delete.php',
            'type_code_grid' => 'mod_asset/type_code_grid.php'
        )
    ),
    3 => array('title' => 'Maintenance Management',
        'page' => array(
            'index' => 'mod_maint/index.php',
            'work_order_main_grid' => 'mod_maint/work_order_main_grid.php',
            'work_order_field_grid' => 'mod_maint/work_order_field_grid.php',
            'work_order_priority_grid' => 'mod_maint/work_order_priority_grid.php',
            'work_order_status_grid' => 'mod_maint/work_order_status_grid.php',
            'work_order_type_grid' => 'mod_maint/work_order_type_grid.php',
            'work_order_failure_grid' => 'mod_maint/work_order_failure_grid.php'
        )
    ),
    4 => array('title' => 'Event Management',
        'page' => array(
            'index' => 'mod_event/index.php',
            'event_main_grid' => 'mod_event/event_main_grid.php',
            'event_location' => 'mod_event/event_location.php',
            'event_main_approval' => 'mod_event/event_main_approval.php',
            'resource_booking_main' => 'mod_event/external_user/resource_booking_main.php',
            'resource_booking_location' => 'mod_event/external_user/resource_booking_location.php',
            'resource_booking_detail' => 'mod_event/external_user/resource_booking_detail.php',
            'resource_booking_form' => 'mod_event/external_user/resource_booking_form.php',
            'resource_booking_form_save' => 'mod_event/external_user/resource_booking_form_save.php',
            'resource_booking_status' => 'mod_event/external_user/resource_booking_status.php',
            'admin_booking_approval' => 'mod_event/admin_booking_approval.php',
            'admin_booking_approval_detail' => 'mod_event/admin_booking_approval_detail.php',
            'admin_booking_approval_save' => 'mod_event/admin_booking_approval_save.php'
        )
    ),
    5 => array('title' => 'Tenant Management',
        'page' => array(
            'index' => 'mod_tenant/index.php',
            'bill_grid' => 'mod_tenant/bill_grid.php',
            'bill_grid_add' => 'mod_tenant/bill_grid_add.php',
            'bill_grid_add_save' => 'mod_tenant/bill_grid_add_save.php',
            'bill_grid_process' => 'mod_tenant/bill_grid_process.php',
            'bill_grid_process_save' => 'mod_tenant/bill_grid_process_save.php',
            'bill_grid_delete' => 'mod_tenant/bill_grid_delete.php',
            'bill_grid_rate' => 'mod_tenant/bill_grid_rate.php'
        )
    )
);
//dumper($map_path);
?>
