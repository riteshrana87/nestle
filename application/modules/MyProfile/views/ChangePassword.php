<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">
                    <?= lang('CHANGE_PASSWORD') ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= lang('CHANGE_PASSWORD') ?>
                    </div>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <div class="panel-body">
                        <form action="<?php echo base_url();?>MyProfile/updatePassword" name="update_password" id="update_password" class="form-horizontal" data-parsley-validate="" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate>
                        <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cat_name" class="control-label col-sm-3 required"><?php echo lang('password'); ?></label>
                                <div class="col-sm-9">
                                    <input class="form-control" autocomplete="off" id="password" name="password" value=""  data-parsley-trigger="change" placeholder="<?php echo lang('PASSWORD'); ?>" type="password" required data-parsley-minlength="6">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cat_description" class="control-label col-sm-3 required"><?php echo lang('cpassword'); ?></label>
                                <div class="col-sm-9">
                                    <input class="form-control" required name="cpassword" id="cpassword" data-parsley-eq="#password" placeholder="<?php echo lang('CONFIRM_PASSWORD'); ?>" data-parsley-trigger="change" type="password" data-parsley-equalto="#password" data-parsley-minlength="6">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="clearfix"></div>
                            <div class="col-sm-12 text-center">
                                <div class="bottom-buttons">

                                    <input type="button" class="btn btn-primary" onclick="change_password()"  name="submit_btn" value="<?php echo lang('UPDATE');?>">
									<a href="<?php echo base_url('MyProfile/ChangePassword') ?>" class="btn btn-default">Cancel</a>
									
									<?php /*?><a href="<?php echo base_url('IngredientMaster') ?>" class="btn btn-default">Cancel</a> <?php */?>

                                </div>
                            </div>
                             </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>