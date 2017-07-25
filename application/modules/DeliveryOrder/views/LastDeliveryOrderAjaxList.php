<script>
    var baseurl = '<?php echo base_url(); ?>';
</script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$formAction = !empty($editRecord) ? 'updatedata' : 'insertdata';
$path = $crnt_view . '/' . $formAction;
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Delivery Order history</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       Last Five Delivery Order List &nbsp;
                        
                        <div class="pull-right">
                            
                        </div>
                        
                    </div>
                    <div class="panel-body">
                        <div class="clearfix"></div>
                        <?php echo $this->session->flashdata('msg'); ?>
                        <div class="clearfix"></div>
                        <div class="whitebox">
                            <?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($sortby) && $sortby == 'asc') {
    $sorttypepass = 'desc';
} else {
    $sorttypepass = 'asc';
}
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Order Id</th>                
                <th>Order Date</th>                
                <th> Ingredient Details</th>
                <th> Remarks</th>
		<th> Agent Name</th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
        <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
           
                <?php 
                    if(isset($orderLists) && count($orderLists) > 0 ){
                        foreach ($orderLists as $order_Lists_data){ ?>
                         <tr>
                        <td><?php echo $order_Lists_data['order_id']; ?></td>
                        <td><?php echo $order_Lists_data['order_date']; ?></td>
                        <td>
                            <table class="table table-striped table-bordered table-hover" width='100%'>
                                <thead>
                                    <th>Ingredient</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Bill Amount</th>
                                </thead>
                                <tbody>
                                    <?php $get_list =  prepateOrderList($order_Lists_data['order_id']); ?>
                                        <?php if(isset($get_list) && count($get_list) > 0){ ?>
                                            <?php foreach($get_list as $data){ ?>
                                                <tr>
                                                <td><?php echo $data['Ingredient']; ?></td>
                                                <td><?php echo $data['type']; ?></td>
                                                <td><?php echo $data['quantity']; ?></td>
                                                <td><?php echo $data['price']; ?></td>
                                                <td><?php echo $data['sub_total']; ?></td>
                                                </tr> 
                                        <?php } ?>
                                    <?php } ?>                         
                                </tbody>
                            </table>
                        </td>
                        <td><?php echo $order_Lists_data['remarks']; ?></td>
                        <td><?php echo $agent_name; ?></td>
                 </tr>
                <?php } }else{ ?>
                 <tr> No Records Found</tr>
                <?php }?>
        </tbody>
    </table>
</div>
<div class="clearfix visible-xs-block"></div>

                            <!-- Listing of User List Table: End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>