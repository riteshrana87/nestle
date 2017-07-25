<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label col-sm-3"><?= $this->lang->line('co_location'); ?></label>
        <div class="col-sm-9">
            <span id='location' name='location'>
                <?= !empty($customer_info[0]['location']) ? $customer_info[0]['location'] : $this->lang->line('NA');?>
            </span>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label col-sm-3">Customer Name</label>
        <div class="col-sm-9">
            <span id='customer_name' name='customer_name'>
                <?= !empty($customer_info[0]['customer_name']) ? $customer_info[0]['customer_name'] : $this->lang->line('NA');?>
            </span>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label col-sm-3">Contact Number</label>
        <div class="col-sm-9">
            <span id='customer_number' name='customer_number'>
                <?= !empty($customer_info[0]['contact_number']) ? $customer_info[0]['contact_number'] : $this->lang->line('NA');?>
            </span>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label col-sm-3">Serial Number:</label>
        <div class="col-sm-9">
            <span id='customer_name' name='customer_name'>
                <?= !empty($customer_info[0]['customer_code']) ? $customer_info[0]['customer_code'] : $this->lang->line('NA');?>
            </span>
        </div>
    </div>
</div>