<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if (!empty($customerInfo)) {

    foreach ($customerInfo as $customerInfoData) {
        
        $radiolabel = '';
        if (!empty($customerInfoData['customer_code'])) {
            $radiolabel .= $customerInfoData['customer_code'] . ', ';
        }

        if (!empty($customerInfoData['customer_name'])) {
            $radiolabel .= $customerInfoData['customer_name'] . ', ';
        }

        if (!empty($customerInfoData['location'])) {
            $radiolabel .= $customerInfoData['location'] . ', ';
        }

        if (!empty($customerInfoData['emirate_name'])) {
            $radiolabel .= $customerInfoData['emirate_name'];
        }
        ?>
        <p>            
            <input class='customerRadio' type='radio' name='customer_radio' value="<?php echo $customerInfoData['customer_id'] ?>"  checked /> <?php echo $radiolabel; ?>
        </p>
        <?php
    }
}
?>