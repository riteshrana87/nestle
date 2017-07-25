<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Base Site URL
  |--------------------------------------------------------------------------
  |
  | URL to your CodeIgniter root. Typically this will be your base URL,
  | WITH a trailing slash:
  |
  | http://example.com/
  |
  | WARNING: You MUST set this value!
  |
  | If it is not set, then CodeIgniter will try guess the protocol and path
  | your installation, but due to security concerns the hostname will be set
  | to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
  | The auto-detection mechanism exists only for convenience during
  | development and MUST NOT be used in production!
  |
  | If you need to allow multiple domains, remember that this file is still
  | a PHP script and you can easily do that on your own.
  |
 */
/**
 * User Module
 * [controller name][action] = array('respective function name for the Controller')
 */
$config['User']['add'] = array('insertdata', 'registration', 'isDuplicateEmail', 'checkCRMUserCreateLimites', 'checkPMUserCreateLimites', 'checkSupportUserCreateLimites', 'assignModuleCount','getCountofCreatedUser','checkUserCounts','InsertTimeCheckUserCount','InsertTimeCheckUserCounts');
$config['User']['delete'] = array('deletedata', 'isDuplicateEmail');
$config['User']['edit'] = array('edit', 'updatedata', 'isDuplicateEmail', 'checkCRMUserCreateLimites', 'checkPMUserCreateLimites', 'checkSupportUserCreateLimites','getCountofCreatedUser','checkUserCounts','InsertTimeCheckUserCount','InsertTimeCheckUserCounts','insertTimecheckAvailability');
$config['User']['view'] = array('index', 'userlist', 'view', 'isDuplicateEmail', 'testmail');

$config['Home']['view'] = array('index', 'changeview', 'grantview', 'get_home_header', 'get_home_activity');
$config['Errors']['view'] = array('index');

// Rolemaster Module
$config['Rolemaster']['add'] = array('insertdata', 'add', 'addPermission', 'insertPerms', 'assignPermission', 'addModule', 'insertAssginPerms', 'insertModule', 'checkRoleStatus', 'checkRoleAssignedToUser', 'permissionTab','updateRolebasedUserCreationCount','assignModuleCount','editTimeCheckPurchasedUserLimit','updateTimeCheckUserAvailbility');
$config['Rolemaster']['delete'] = array('deletedata', 'deletePerms', 'deleteAssignperms', 'deleteModuleData', 'permissionTab','editTimeCheckPurchasedUserLimit','updateTimeCheckUserAvailbility');
$config['Rolemaster']['edit'] = array('edit', 'updatedata', 'editPerms', 'updatePerms', 'editPermission', 'editModule', 'updateModule', 'insertAssginPerms', 'permissionTab','updateRolebasedUserCreationCount','assignModuleCount','editTimeCheckPurchasedUserLimit','updateTimeCheckUserAvailbility');
$config['Rolemaster']['view'] = array('index', 'role_list', 'view_perms_to_role_list', 'checkRoleStatus', 'checkRoleAssignedToUser', 'permissionTab');


/*
 * ritesh rana
  Product Module
 */

$config['IngredientMaster']['add'] = array('insertdata', 'addcategory');
$config['IngredientMaster']['delete'] = array('deletedata');
$config['IngredientMaster']['edit'] = array('edit', 'updatedata');
$config['IngredientMaster']['view'] = array('index', 'view');

$config['IngredientType']['add'] = array('insertdata', 'additems');
$config['IngredientType']['delete'] = array('deletedata');
$config['IngredientType']['edit'] = array('edit', 'updatedata');
$config['IngredientType']['view'] = array('index', 'view');

$config['DeliveryOrder']['add'] = array('insertdata', 'add_record', 'category_data', 'subcategory_data','subcategory_all_data','customerData','customerDetail','download','getCustomerDetails','getPopUpData','getSelectedInventoryData','getInventoryList','getInvontoryByCustomerDetails');
$config['DeliveryOrder']['delete'] = array('deletedata','download');
$config['DeliveryOrder']['edit'] = array('edit_record', 'updatedata' ,'category_data', 'subcategory_data','subcategory_all_data','customerData','customerDetail','download','getCustomerDetails','getPopUpData','getSelectedInventoryData','getInventoryList','getInvontoryByCustomerDetails');
$config['DeliveryOrder']['view'] = array('index', 'view' ,'category_data', 'subcategory_data','subcategory_all_data','customerData','customerDetail','download','getCustomerDetails','getPopUpData','getSelectedInventoryData','getInventoryList','getInvontoryByCustomerDetails','viewLastFiveDeliveryOrderList');


// Customer
$config['Customer']['add'] = array('add','insertData', 'formValidation', 'getSelectedVersionData', 'getSelectedSrNumberData','machineInformation','isDuplicateCustomerCode');
$config['Customer']['edit'] = array('edit', 'updateData' ,'formValidation', 'getSelectedVersionData','getSelectedSrNumberData','machineInformation','isDuplicateCustomerCode');
$config['Customer']['delete'] = array('deleteCustomer');
$config['Customer']['view'] = array('index');

// Version
$config['Version']['add'] = array('add','insertData', 'formValidation', 'isDuplicateVersionName');
$config['Version']['edit'] = array('edit', 'updateData' ,'formValidation', 'isDuplicateVersionName');
$config['Version']['delete'] = array('');
$config['Version']['view'] = array('index');


// Inventory
$config['Inventory']['add'] = array('add','insertData', 'formValidation', 'getSelectedVersionData','isDuplicateSerialNumber');
$config['Inventory']['edit'] = array('edit', 'updateData' ,'formValidation', 'getSelectedVersionData','isDuplicateSerialNumber');
$config['Inventory']['delete'] = array('deleteInventory');
$config['Inventory']['view'] = array('index');


// Collection Order
$config['CollectionOrder']['add'] = array('add','insertData', 'formValidation', 'getCustomerCodeList','getCustomerDetails','uploadAttachment','checkCustomerCode','getPopUpData','getInvontoryByCustomerDetails','getSelectedInventoryData','getInventoryList');
$config['CollectionOrder']['edit'] = array('edit', 'updateData' ,'formValidation', 'getCustomerCodeList','getCustomerDetails','uploadAttachment','checkCustomerCode','getPopUpData','getInvontoryByCustomerDetails','getSelectedInventoryData','getInventoryList');
$config['CollectionOrder']['delete'] = array('deleteCollection');
$config['CollectionOrder']['view'] = array('index','checkCustomerCode','getPopUpData','getInvontoryByCustomerDetails','getSelectedInventoryData','getInventoryList');

// Zone Assign
$config['Zone']['add'] = array('assign','updateSelectedData', 'getBothSelectBox');
$config['Zone']['edit'] = array('assign', 'updateSelectedData' ,'getBothSelectBox');
$config['Zone']['delete'] = array();
$config['Zone']['view'] = array();


// Maintenance
$config['Maintenance']['add'] = array('add','insertData', 'formValidation', 'getCustomerCodeList','getPopUpData','getCustomerDetails');
$config['Maintenance']['edit'] = array('edit', 'updateData' ,'formValidation', 'getCustomerCodeList','getPopUpData','getCustomerDetails');
$config['Maintenance']['delete'] = array('deleteMaintenance');
$config['Maintenance']['view'] = array('index');


//Module Master
$config['ModuleMaster']['add'] = array('add','insertModule', 'formValidation');
$config['ModuleMaster']['edit'] = array('edit', 'updateModule' ,'formValidation');
$config['ModuleMaster']['delete'] = array('deleteModuleData');
$config['ModuleMaster']['view'] = array('index');

//MachineAssignment

$config['MachineAssignment']['add'] = array('add','insertData', 'formValidation', 'getSelectedVersionData', 'getSelectedSrNumberData','machineInformation','assignmentData','getPopUpData','getCustomerDetails','getVersionDataPullOut','getSrNumberDataPullOut','edit','updateEditData','editFormValidation');
$config['MachineAssignment']['edit'] = array('assignment', 'updateData' ,'formValidation', 'getSelectedVersionData','getSelectedSrNumberData','machineInformation','assignmentData','getPopUpData','getCustomerDetails','getVersionDataPullOut','getSrNumberDataPullOut','edit','updateEditData','editFormValidation');
$config['MachineAssignment']['delete'] = array('deleteAssignedMachine');
$config['MachineAssignment']['view'] = array('index');

//CustomerMachineInformation
$config['CustomerMachineInformation']['add'] = array('add','insertData', 'formValidation', 'getSelectedVersionData', 'getSelectedSrNumberData','machineInformation');
$config['CustomerMachineInformation']['edit'] = array('edit', 'updateData' ,'formValidation', 'getSelectedVersionData','getSelectedSrNumberData','machineInformation');
$config['CustomerMachineInformation']['delete'] = array('deleteAssignedMachineToCustomer');
$config['CustomerMachineInformation']['view'] = array('index');

// CollectionOrderAssignment
$config['CollectionOrderAssignment']['add'] = array('formValidation', 'getCustomerCodeList','getCustomerDetails','uploadAttachment','checkCustomerCode','uploadAttachment','checkCustomerCode','getPopUpData','getInvontoryByCustomerDetails','getSelectedInventoryData','getInventoryList');
$config['CollectionOrderAssignment']['edit'] = array('edit', 'updateData' ,'formValidation', 'getCustomerCodeList','getCustomerDetails','uploadAttachment','checkCustomerCode','uploadAttachment','checkCustomerCode','getPopUpData','getInvontoryByCustomerDetails','getSelectedInventoryData','getInventoryList');
$config['CollectionOrderAssignment']['delete'] = array('');
$config['CollectionOrderAssignment']['view'] = array('index','getCustomerDetails','uploadAttachment','checkCustomerCode','getPopUpData','getInvontoryByCustomerDetails','getSelectedInventoryData','getInventoryList');

//DeliveryOrderAssignment
$config['DeliveryOrderAssignment']['add'] = array('insertdata', 'add_record', 'category_data', 'subcategory_data','subcategory_all_data','customerData','customerDetail','download');
$config['DeliveryOrderAssignment']['delete'] = array('deletedata','download');
$config['DeliveryOrderAssignment']['edit'] = array('edit_record', 'updatedata' ,'category_data', 'subcategory_data','subcategory_all_data','customerData','customerDetail','download');
$config['DeliveryOrderAssignment']['view'] = array('index', 'view' ,'category_data', 'subcategory_data','subcategory_all_data','customerData','customerDetail','download');

//Maintenance Back Office
$config['AssignedMaintenance']['add'] = array('formValidation','updateAssignMaintenance','getMaintenanceDetails');
$config['AssignedMaintenance']['edit'] = array('edit', 'formValidation', 'updateAssignMaintenance','getMaintenanceDetails');
$config['AssignedMaintenance']['delete'] = array('deleteMaintenance');
$config['AssignedMaintenance']['view'] = array('index');

//Reports
$config['Report']['add'] = array('formValidation','index','showReportList','generateExcelFile','downloadExcelFile','generateExcelFileUrl','filterExcelData');
$config['Report']['edit'] = array('formValidation','index','showReportList','generateExcelFile','downloadExcelFile','generateExcelFileUrl','filterExcelData');
$config['Report']['delete'] = array('');
$config['Report']['view'] = array('index');


//FeedBack
$config['Feedback']['add'] = array('formValidation','add','insertData','getCustomeList','getPopUpData');
$config['Feedback']['edit'] = array('formValidation','edit','updateData','getCustomeList','getPopUpData');
$config['Feedback']['delete'] = array('deleteFeedback');
$config['Feedback']['view'] = array('index');
