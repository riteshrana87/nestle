<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$profile_src = base_url() . "uploads/images/profile-default.png";
if (isset($user_info['PROFILE_PHOTO']) && $user_info['PROFILE_PHOTO'] != '') {
    $explode_name = explode('.', $user_info['PROFILE_PHOTO']);
    $thumbnail_name = $explode_name[0] . '_thumb.' . $explode_name[1];
    $file = (FCPATH . "uploads/profile_photo/" . $thumbnail_name);

    if (file_exists($file)) {
        $profile_src = base_url() . "uploads/profile_photo/" . $thumbnail_name;
    } else {
        $profile_src = base_url() . "uploads/images/profile-default.png";
    }
}
?>
<div class="navbar navbar-inverse set-radius-zero">
    <div class="container">
        <div class="navbar-header">
          <?php if (isset($this->session->userdata['LOGGED_IN'])) { ?>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
          <?php }else { ?>
          <?php } ?>
            <a class="navbar-brand" href="<?php echo base_url(); ?>" >
                <img src="http://www.nestleprofessionalme.com/sites/all/themes/nestle/logo.png" alt="Home" style="max-width: 130%;">
                <?php /* ?><span style="COLOR: #FFF;FONT-SIZE: 40PX;LINE-HEIGHT: 40px;FONT-WEIGHT: BOLD;">IBT</span> <?php ?>
                  <?php ?><img src="<?php echo base_url();?>uploads/assets/img/logo-new.png"/><?php */ ?>
            </a>

        </div>

        <div class="pull-right">
            <div class="user-settings-wrapper">
                <ul class="nav">
                    <li style="" class="">					
                        <a href="#" class="cust-link-hover" style="color: rgb(255, 255, 255);text-decoration: underline;width: auto;height: auto;background: none;">
                            Go to http://www.nestleprofessionalme.com/
                        </a>
                    </li>
                    <?php if (isset($this->session->userdata['LOGGED_IN'])) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" style="font-size: 20px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media">

                                    <a class="media-left" href="#">
                                        <img src="<?= $profile_src ?>" alt="" class="img-rounded" />
                                    </a>
                                    <div class="media-body">
                                        <?php if (isset($user_info) && !empty($user_info)) { ?>
                                            <h4 class="media-heading"><?php echo $user_info['FIRSTNAME'] . ' ' . $user_info['LASTNAME']; ?> </h4>
                                        <?php } ?>
                                    </div>
                                </div>
                                <hr />
                                <div class="text-center">
                                    <a href="<?php echo base_url('MyProfile'); ?>" class="btn btn-info btn-sm">Full Profile</a>
                                    <a href="<?php echo base_url('Dashboard/logout/'); ?>" class="btn btn-danger btn-sm">Logout</a>
                                </div>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li style="display: none" class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" >
                            </a>
                        </li>
                    <?php } ?>
                </ul>

            </div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>