<?php
if(isset($editRecord) && $editRecord == "updatedata"){
    $record = "updatedata";
}else{
    $record = "insertdata";
}
?>
<script>
    var formAction = "<?php echo $record;?>";
    var check_email_url = "<?php echo base_url('User/isDuplicateEmail'); ?>";
</script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$formAction = !empty($editRecord)?'edit':'addcategory';
$path = $form_action_path;
if(isset($readonly)){
    $disable = $readonly['disabled'];
}else{
    $disable = "";
}
$main_user_data = $this->session->userdata('LOGGED_IN');
$main_user_id = $main_user_data['ID'];
?>
<?php  echo $this->session->flashdata('verify_msg'); ?>
<div class="content-wrapper">
    <div class="container">
      <div clas="row">
        <div class="col-md-12 error-list">
          <?= isset($validation) ? $validation : ''; ?>
        </div>
      </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">
                    <?PHP if($formAction == "addcategory"){ ?>
                        <?=$this->lang->line('Add_Category');?>
                    <?php }elseif($formAction == "edit" && !isset($readonly)){ ?>
                        <?=$this->lang->line('edit_ingredient')?>
                    <?php }elseif(isset($readonly)){?>
                        <?=$this->lang->line('View_Category')?>
                    <?php }?>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?PHP if($formAction == "addcategory"){ ?>
                            <?=$this->lang->line('ingredient');?>
                        <?php }elseif($formAction == "edit" && !isset($readonly)){ ?>
                            <?=$this->lang->line('ingredient')?>
                        <?php }elseif(isset($readonly)){?>
                            <?=$this->lang->line('View_Category')?>
                        <?php }?>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <?php
                        $attributes = array("name" => "category", "id" => "category", "data-parsley-validate" => "" ,"class" => "form-horizontal");

                        echo form_open_multipart($path, $attributes);
                        ?>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cat_name" class="control-label col-sm-3 required">Ingredient Name<?php if($disable ==""){?><?php }?></label>
                                <div class="col-sm-9">
                                    <?php if($disable ==""){ ?>
                                        <input class="form-control" name="cat_name" placeholder="Enter Ingredient Name" type="text" value="<?PHP if($formAction == "addcategory"){ echo set_value('cat_name');?><?php }else{?><?=!empty($editRecord[0]['cat_name'])?$editRecord[0]['cat_name']:''?><?php }?>" data-parsley-pattern="/^([^0-9]*)$/" required="" <?php echo $disable; ?> />
                                    <?php }else{?>
                                        <p><?php echo $editRecord[0]['cat_name']; ?></p>
                                    <?php }?>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cat_description" class="control-label col-sm-3">Description<?php if($disable ==""){?><?php }?></label>
                                <div class="col-sm-9">
                                <?php if($disable ==""){ ?>
                                        <textarea class="form-control" name="description" placeholder="Enter Description" type="text" <?php echo $disable; ?> ><?PHP if($formAction == "addcategory"){ echo set_value('description');?><?php }else{?><?=!empty($editRecord[0]['description'])?$editRecord[0]['description']:''?><?php }?></textarea>
                                    <?php }else{?>
                                        <p><?php echo $editRecord[0]['description']; ?></p>
                                    <?php }?>
                            </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required" for="status">
                                    Status
                                </label>
                                <div class="col-sm-9">
                                    <?php if($disable ==""){?>
                                        <select class="form-control " data-parsley-errors-container="#STATUS_error" placeholder="Category Status"  name="status" id="status" required <?php echo $disable; ?> >
                                            <?php
                                            $options = array(array('s_status'=>lang('active')) ,array('s_status'=>lang('inactive')));

                                            if(isset($editRecord[0]['status']) && $editRecord[0]['status'] != ""){
                                                $selected = $editRecord[0]['status'];
                                            }else{
                                                $selected = lang('active');
                                            }
                                            ?>
                                            <?php foreach($options as $rows){
                                                if($selected == $rows['s_status']){?>

                                                    <option selected value="<?php echo $rows['s_status'];?>"><?php echo $rows['s_status'];?></option>
                                                <?php }else{?>

                                                    <option value="<?php echo $rows['s_status'];?>"><?php echo $rows['s_status'];?></option>
                                                <?php }}?>
                                        </select>
                                    <?php }elseif($disable =! ""){?>
                                        <?php if( isset($editRecord[0]['status']) && $editRecord[0]['status'] == 1){?>
                                            <p><?=lang('active')?></p>
                                        <?php }else{?>
                                            <p><?=lang('inactive')?></p>
                                        <?php }?>

                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="clearfix"></div>
                            <div class="col-sm-12 text-center">
                                <div class="bottom-buttons">
                                    <?php if(!isset($readonly)){ ?>
                                        <input name="cat_id" id="cat_id" type="hidden" value="<?=!empty($editRecord[0]['cat_id'])?$editRecord[0]['cat_id']:''?>" />
                                        <input type="hidden" id="form_secret" name="form_secret"  value="<?php echo createFormToken();?>">
                                        <?php if($formAction == "addcategory"){?>
                                            <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="Save" />
                                        <?php }else{?>
                                            <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="Update" />
                                        <?php }?>
                                       
                                        <a href="<?php echo base_url('IngredientMaster') ?>" class="btn btn-default">Cancel</a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php echo form_close(); ?> </div>
                    </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>