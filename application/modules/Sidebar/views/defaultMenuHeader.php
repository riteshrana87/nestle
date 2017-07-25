<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- LOGO HEADER END-->
<section class="menu-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar-collapse collapse ">
                    <?php if (isset($this->session->userdata['LOGGED_IN'])) { ?>
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li <?php if (isset($param['menu_module']) && $param['menu_module'] == "Dashboard") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle <?php if (isset($param['menu_module']) && $param['menu_module'] == "order_management") { ?>active<?php } ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Order Management <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php if (checkPermission('DeliveryOrder', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "delivery_order") { ?>class="active"<?php } ?>><a href="<?php echo base_url('DeliveryOrder'); ?>">Delivery Order</a></li><?php } ?>
                                    <?php if (checkPermission('CollectionOrder', 'view')) { ?>
                                        <li <?php if (isset($param['menu_module']) && $param['menu_child'] == "collection_order") { ?>class="active"<?php } ?>><a href="<?php echo base_url('CollectionOrder'); ?>">Collection Order</a></li><?php } ?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle <?php if (isset($param['menu_module']) && $param['menu_module'] == "order_assignment") { ?>active<?php } ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Order Assignment <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php if (checkPermission('DeliveryOrderAssignment', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "delivery_order_assignment") { ?>class="active"<?php } ?>><a href="<?php echo base_url('DeliveryOrderAssignment'); ?>">Delivery Order</a></li>
                                    <?php } ?>

                                    <?php if (checkPermission('CollectionOrderAssignment', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "collection_order_assignment") { ?>class="active"<?php } ?>><a href="<?php echo base_url('CollectionOrderAssignment') ?>">Collection Order</a></li>
                                    <?php } ?>

                                    <?php if (checkPermission('MachineAssignment', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "machine_assignment") { ?>class="active"<?php } ?>><a href="<?php echo base_url('MachineAssignment') ?>">Machine Assignment</a></li>
                                    <?php } ?>


                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle <?php if (isset($param['menu_module']) && $param['menu_module'] == "maintenance") { ?>active<?php } ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Maintenance<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php if (checkPermission('Maintenance', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "maintenance") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Maintenance'); ?>">Maintenance Sales Person</a></li>
                                    <?php } ?>

                                    <?php if (checkPermission('AssignedMaintenance', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "assigned_maintenance") { ?>class="active"<?php } ?>><a href="<?php echo base_url('AssignedMaintenance') ?>">Maintenance Back Office</a></li>
                                    <?php } ?>

                                </ul>
                            </li>                           
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php if (checkPermission('Report', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "report") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Report') ?>">Generate Report</a></li>

                                    <?php } ?>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle <?php if (isset($param['menu_module']) && $param['menu_module'] == "masters") { ?>active<?php } ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Masters <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php if (checkPermission('User', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "user") { ?>class="active"<?php } ?>><a href="<?php echo base_url('User'); ?>">User Master</a></li>
                                    <?php } ?>
                                    <?php if (checkPermission('IngredientMaster', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "ingredientmaster") { ?>class="active"<?php } ?>><a href="<?php echo base_url('IngredientMaster'); ?>">Ingredient Master</a></li>
                                    <?php } ?>
                                    <?php if (checkPermission('IngredientType', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "ingredienttype") { ?>class="active"<?php } ?>><a href="<?php echo base_url('IngredientType'); ?>">Ingredient Items</a></li>
                                    <?php } ?>
                                    <?php if (checkPermission('Version', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "version") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Version'); ?>">Version Master</a></li>
                                    <?php } ?>

                                    <?php if (checkPermission('Inventory', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "inventory") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Inventory'); ?>">Inventory Master</a></li>
                                    <?php } ?>

                                    <?php if (checkPermission('Customer', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "customer") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Customer'); ?>">Customer Master - Sales Person</a></li>
                                    <?php } ?>
                                    <?php if (checkPermission('CustomerMachineInformation', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "Customermachineinformation") { ?>class="active"<?php } ?>><a href="<?php echo base_url('CustomerMachineInformation'); ?>">Customer Master - Back Office</a></li>
                                    <?php } ?>

                                    <?php if (checkPermission('Zone', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "zone") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Zone/assign'); ?>">Zone Assignment</a></li>
                                    <?php } ?>
                                    
                                    <?php if (checkPermission('Feedback', 'view')) { ?>
                                        <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "feedback") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Feedback'); ?>">Feedback</a></li>
                                    <?php } ?>
                                        
                                    <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "changepassword") { ?>class="active"<?php } ?>><a href="<?php echo base_url('MyProfile/ChangePassword'); ?>"><?php echo lang('CHANGE_PASSWORD'); ?></a></li>
                                        <?php if (checkPermission('Rolemaster', 'view')) { ?>
                                            <?php /* Comment Role Master ?>
                                              <li <?php if (isset($param['menu_child']) && $param['menu_child'] == "changepassword") { ?>class="active"<?php } ?>><a href="<?php echo base_url('Rolemaster');?>">Role Master</a></li>
                                              <?php */ ?>
                                        <?php } ?> 
                                    <!--<li><a href="#">Zone Assignment</a></li>-->
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- MENU SECTION END-->
