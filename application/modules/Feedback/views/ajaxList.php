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
                <th <?php
                if (isset($sortfield) && $sortfield == 'auditor') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('auditor', '<?php echo $sorttypepass; ?>')">Auditor</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'feedback_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('feedback_date', '<?php echo $sorttypepass; ?>')">Feedback Date</th>
                
                <th <?php
                if (isset($sortfield) && $sortfield == 'customer_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('customer_name', '<?php echo $sorttypepass; ?>')">Customer Name</th>
                
                <th <?php
                if (isset($sortfield) && $sortfield == 'ticket_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('ticket_date', '<?php echo $sorttypepass; ?>')">Ticket Date</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'subject') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('subject', '<?php echo $sorttypepass; ?>')">Subject</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'ticket_number') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('ticket_number', '<?php echo $sorttypepass; ?>')">Ticket Number</th>
                
                <th <?php
                if (isset($sortfield) && $sortfield == 'phone_number') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('phone_number', '<?php echo $sorttypepass; ?>')">Phone Number</th>

                <th class="text-center">Action</th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
        <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
            <?php if (isset($listRecords) && count($listRecords) > 0) { ?>
                <?php foreach ($listRecords as $data) { ?>
                    <tr>
                        <td><?php echo $data['auditor'] ?></td>
                        <td><?php echo $data['feedback_date'] ?></td>
                        <td><?php echo $data['customer_name'] ?></td>
                        <td><?php echo $data['ticket_date'] ?></td>
                        <td><?php echo $data['subject'] ?></td>
                        <td><?php echo $data['ticket_number'] ?></td>
                        <td><?php echo $data['phone_number'] ?></td>

                        <td class="text-center">
                            <?php if (checkPermission('Feedback', 'edit')) { ?>
                                <a class="btn btn-link" title="Edit" href="<?php echo base_url($crnt_view . '/edit/' . $data['feedback_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <?php } ?>
                            <?php if (checkPermission('Feedback', 'delete')) { ?>
                                <a class="btn btn-link" title="Delete" id='delete' name='delete' onclick="return delete_feedback(<?php echo $data['feedback_id'] ?>, $(this));"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="10" class="text-center"><?= lang('common_no_record_found') ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="clearfix visible-xs-block"></div>
<div class="row" id="common_tb">
    <?php if (isset($pagination) && !empty($pagination)) { ?>
        <div class="col-sm-12">
            <?php echo $pagination; ?>
        </div>
    <?php } ?>
</div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    