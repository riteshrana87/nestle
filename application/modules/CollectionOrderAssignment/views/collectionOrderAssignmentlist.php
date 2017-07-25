<?php
defined('BASEPATH') OR exit('No direct script access allowed')
?>
<script>
    var deleteCollectionOrderURL = "<?php echo base_url('CollectionOrderAssignment/deleteCollection'); ?>";
</script>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Collection Order Assignment Listing</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Collection Order Assignment Listing
                    </div>
                    <div class="panel-body">
                        <div class="pull-right m-b-10" id="searchForm">
                            <div class="form-inline">
                                <div class="input-group search">
                                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                    <input class="" type="hidden" name="uri_segment" id="uri_segment" value="<?= (!empty($uri_segment)) ? $uri_segment : '0' ?>" >
                                    <input type="text" name="searchtext" id="searchtext" class="form-control" placeholder="<?= $this->lang->line('EST_LISTING_SEARCH_FOR') ?>" value="<?= !empty($searchtext) ? $searchtext : '' ?>">
                                </div>
                                <button onclick="data_search('changesearch')" class="btn btn-primary"  title="<?= $this->lang->line('search') ?>"><?= $this->lang->line('common_search_title') ?> <i class="fa fa-search fa-x"></i></button>
                                <button class="btn btn-default" onclick="reset_data()" title="<?= $this->lang->line('reset') ?>"><?= $this->lang->line('common_reset_title') ?><i class="fa fa-refresh fa-x"></i></button>
                                <?php /* <a href="#" class="btn btn-primary">Search</a>
                                  <a href="#" class="btn btn-default">Reset</a> */ ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div id='flashMsg' name='flashMsg'></div>
                        <?php echo $this->session->flashdata('msg'); ?>
                        <div class="clearfix"></div>
                        <!--  -->
                        <div class="whitebox" id="common_div">
                            <?php $this->load->view('ajaxList'); ?>
                            <!-- Listing of User List Table: End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>