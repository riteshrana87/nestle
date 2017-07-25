<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Last Five Delivery Order List</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Last Five Delivery Order List
                    </div>
                    <div class="panel-body">
                       
                        <div class="clearfix"></div>
                        <?php echo $this->session->flashdata('msg'); ?>
                        <div class="clearfix"></div>
                        <div class="whitebox" id="common_div">
                            <?php $this->load->view('LastDeliveryOrderAjaxList'); ?>
                            <!-- Listing of User List Table: End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>