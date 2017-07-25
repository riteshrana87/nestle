<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="description" content="" />
<meta name="author" content="" />

<title><?php echo (isset($meta_title)) ? $meta_title . ' - Nestle' : 'Nestle'; ?></title>
<!-- BOOTSTRAP CORE STYLE  -->
<link href="<?= base_url() ?>uploads/assets/css/bootstrap.css" rel="stylesheet" />

<link href="<?= base_url() ?>uploads/assets/css/bootstrap-datetimepicker.css" rel="stylesheet" />
<!-- FONT AWESOME ICONS  -->
<link href="<?= base_url() ?>uploads/assets/css/font-awesome.css" rel="stylesheet" />
<!-- CUSTOM STYLE  -->
<link href="<?= base_url() ?>uploads/assets/css/style.css" rel="stylesheet" />

<?php
/*
  @Author : Ritesh rana
  @Desc   : Used for the custom CSS
  @Input 	:
  @Output	:
  @Date   : 06/03/2017
 */
if (isset($headerCss) && count($headerCss) > 0) {
    foreach ($headerCss as $css) {
        ?>
        <link href="<?php echo $css; ?>" rel="stylesheet" type="text/css" />
        <?php
    }
}
?>