<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->viewname = $this->uri->segment(2);
        $this->load->library(array('form_validation', 'Session'));
    }

    /**
     * 
     * 
     */
    public function index() {

        $data['main_content'] = '/Dashboard';

        // Maintenance
        $data['totalMaintenanceMonth'] = $this->getMaintenanceChartData($isCurrentMonth = true, $isCurrentDay = false); // Monthly count total maintenance
        $data['totalMaintenanceDay'] = $this->getMaintenanceChartData($isCurrentMonth = false, $isCurrentDay = true); // Daily count total maintenance
        // Collection Order
        $data['totalCollectionOrderMonth'] = $this->getCollectionOrderChartData($isCurrentMonth = true, $isCurrentDay = false); // Monthly count total collection order
        $data['totalCollectionOrderDay'] = $this->getCollectionOrderChartData($isCurrentMonth = false, $isCurrentDay = true); // Daily count total collection order
        // Delivery Order
        $data['totalDeliveryOrderMonth'] = $this->getDeliveryOrderChartData($isCurrentMonth = true, $isCurrentDay = false); // Monthly count total delivery order
        $data['totalDeliveryOrderDay'] = $this->getDeliveryOrderChartData($isCurrentMonth = false, $isCurrentDay = true); // Daily count total delivery order


        $data['totalInstallationMonth'] = $this->getInstallationChartData($isCurrentMonth = true);
        $data['totalPulloutMonth'] = $this->getPulloutChartData($isCurrentMonth = true);

        $data['maintenanceZoneWiseData'] = $this->getMaintenaceZoneWiseData($isCurrentMonth = true);

        //logged in user data 
        $login_id = $this->session->userdata('LOGGED_IN')['ID'];
        $umatch = "login_id =" . $login_id;
        $ufields = array("created_date");
        $data['logged_user'] = $this->common_model->get_records(LOGIN, $ufields, '', '', $umatch);
        //logged in user data ends

        $data['header'] = array('menu_module' => 'Dashboard', 'menu_child' => 'Dashboard');
        //$data['main_content'] = '/Dashboard';

        $data['footerJs'][0] = base_url('uploads/assets/js/highcharts.js');
        //$data['footerJs'][1] = base_url('uploads/assets/js/chart-custom.js');
        $data['footerJs'][1] = base_url('uploads/custom/js/Dashboard/chart-custom.js');

        if ($this->input->is_ajax_request()) {
            $this->load->view('Dashboard', $data);
        } else {
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    public function logout() {
        $user_session = $this->session->userdata('LOGGED_IN');
        if ($user_session) {
            $this->session->unset_userdata('LOGGED_IN');
            $error_msg = ERROR_START_DIV . lang('SUCCESS_LOGOUT') . ERROR_END_DIV;
            $this->session->set_userdata('ERRORMSG', $error_msg);
            $this->session->sess_destroy();
            redirect(base_url('Login'));
        } else {
            redirect(base_url());
        }
    }

    /**
     * 
     * @param type $isCurrentMonth
     * @return type
     */
    protected function getMaintenanceChartData($isCurrentMonth = false, $isCurrentDay = false) {

        $tableName = MAINTENANCE . ' as m';
        $fields = array('COUNT(m.maintenance_id) as totalMaintenance',
            'COUNT(CASE WHEN c.code_name = "open" THEN m.maintenance_id ELSE NULL END) as openMaintenance',
            'COUNT(CASE WHEN c.code_name = "closed" THEN m.maintenance_id ELSE NULL END) as closedMaintenance');

        $join_tables = array(
            CODELOOKUP . ' as c' => 'm.maintenance_status = c.code_id',
        );

        if ($isCurrentMonth) {
            $currentMonth = date('Y-m');
            $whereCond = array('m.is_delete' => '0', 'c.isactive' => 'active', 'DATE_FORMAT(m.updated_at, "%Y-%m")=' => $currentMonth);
        } elseif ($isCurrentDay) {
            $currentDay = date('Y-m-d');
            $whereCond = array('m.is_delete' => '0', 'c.isactive' => 'active', 'DATE_FORMAT(m.updated_at, "%Y-%m-%d")=' => $currentDay);
        } else {
            $whereCond = array('m.is_delete' => '0', 'c.isactive' => 'active');
            //$whereCond = array('m.is_delete' => '0', 'c.isactive' => 'active', 'c.code_name' => $applyStatus);
        }

        $maintenanceData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

        //echo $this->db->last_query();
        // exit;

        $countTotalMaintenance = 0;
        if (!empty($maintenanceData[0])) {
            $countTotalMaintenance = $maintenanceData[0];
        }

        return $countTotalMaintenance;
    }

    /**
     * 
     * @param type $isCurrentMonth
     * @param type $isCurrentDay
     * @return type
     */
    protected function getCollectionOrderChartData($isCurrentMonth = false, $isCurrentDay = false) {

        /* Start - Filter Query */
        $tableName = COLLECTION_ORDER . ' as co';
        $fields = array('COUNT(co.collection_id) as totalCollectionOrder',
            'COUNT(CASE WHEN c.code_name = "open" THEN co.collection_id ELSE NULL END) as openCollectionOrder',
            'COUNT(CASE WHEN c.code_name = "closed" THEN co.collection_id ELSE NULL END) as closedCollectionOrder');

        $join_tables = array(
            CODELOOKUP . ' as c' => 'co.collection_order_status = c.code_id',
        );

        if ($isCurrentMonth) {
            $currentMonth = date('Y-m');
            $whereCond = array('co.is_delete' => '0', 'c.isactive' => 'active', 'DATE_FORMAT(co.co_date_time,"%Y-%m")=' => $currentMonth);
        } elseif ($isCurrentDay) {
            $currentDay = date('Y-m-d');
            $whereCond = array('co.is_delete' => '0', 'c.isactive' => 'active', 'DATE_FORMAT(co.co_date_time, "%Y-%m-%d")=' => $currentDay);
        } else {
            $whereCond = array('co.is_delete' => '0', 'c.isactive' => 'active');
            //$whereCond = array('co.is_delete' => '0', 'c.isactive' => 'active', 'c.code_name' => $applyStatus);
        }

        $collectionOrderData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

        //echo $this->db->last_query();
        $countTotalCollectionOrder = 0;
        if (!empty($collectionOrderData[0])) {
            $countTotalCollectionOrder = $collectionOrderData[0];
        }

        return $countTotalCollectionOrder;
    }

    /**
     * 
     * @param type $isCurrentMonth
     * @param type $isCurrentDay
     * @return type
     */
    protected function getDeliveryOrderChartData($isCurrentMonth = false, $isCurrentDay = false) {

        /* Start - Filter Query */
        $tableName = DELIVERY_ORDER . ' as do';
        $fields = array('COUNT(do.delivery_order_id) as totalDeliveryOrder',
            'COUNT(CASE WHEN c.code_name = "In Progress" THEN do.delivery_order_id ELSE NULL END) as openDeliveryOrder',
            'COUNT(CASE WHEN c.code_name = "Successfully delivered" THEN do.delivery_order_id ELSE NULL END) as closedDeliveryOrder');

        $join_tables = array(
            CODELOOKUP . ' as c' => 'do.delivery_status = c.code_id',
        );

        if ($isCurrentMonth) {
            $currentMonth = date('Y-m');
            $whereCond = array('do.is_deleted' => '0', 'c.isactive' => 'active', 'DATE_FORMAT(do.delivery_date, "%Y-%m")=' => $currentMonth);
        } elseif ($isCurrentDay) {
            $currentDay = date('Y-m-d');
            $whereCond = array('do.is_deleted' => '0', 'c.isactive' => 'active', 'DATE_FORMAT(do.delivery_date, "%Y-%m-%d")=' => $currentDay);
        } else {
            $whereCond = array('do.is_deleted' => '0', 'c.isactive' => 'active');
            //$whereCond = array('do.is_delete' => '0', 'c.isactive' => 'active', 'c.code_name' => $applyStatus);
        }

        $collectionOrderData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

        //echo $this->db->last_query();
        $countTotalCollectionOrder = 0;
        if (!empty($collectionOrderData[0])) {
            $countTotalCollectionOrder = $collectionOrderData[0];
        }

        return $countTotalCollectionOrder;
    }

    /**
     * 
     * @param type $isCurrentMonth
     * @return type
     */
    protected function getInstallationChartData($isCurrentMonth = false) {

        /* Start - Filter Query */
        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';

        $fields = array('COUNT(cmi.customer_machine_information_id) as totalInstallation');

        if ($isCurrentMonth) {
            $currentMonth = date('Y-m');
            $whereCond = array('cmi.is_delete' => '0', 'cmi.machine_assign_type' => 'Installation', 'DATE_FORMAT(cmi.installation_date,"%Y-%m")=' => $currentMonth);
        } else {
            $whereCond = array('do.is_deleted' => '0', 'cmi.machine_assign_type' => 'Installation');
        }

        $installationData = $this->common_model->get_records($tableName, $fields, '', '', $whereCond, '', '', '', '', '', '', '');

        //echo $this->db->last_query();
        $countTotalInstallation = 0;
        if (!empty($installationData[0])) {
            $countTotalInstallation = $installationData[0];
        }

        return $countTotalInstallation;
    }

    /**
     * 
     * @param type $isCurrentMonth
     * @return type
     */
    protected function getPulloutChartData($isCurrentMonth = false) {

        /* Start - Filter Query */
        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';

        $fields = array('COUNT(cmi.customer_machine_information_id) as totalPullout');

        if ($isCurrentMonth) {
            $currentMonth = date('Y-m');
            $whereCond = array('cmi.is_delete' => '0', 'cmi.machine_assign_type' => 'Pullout', 'DATE_FORMAT(cmi.installation_date,"%Y-%m")=' => $currentMonth);
        } else {
            $whereCond = array('do.is_deleted' => '0', 'cmi.machine_assign_type' => 'Pullout');
        }

        $pulloutData = $this->common_model->get_records($tableName, $fields, '', '', $whereCond, '', '', '', '', '', '', '');

        //echo $this->db->last_query();
        $countTotalPullout = 0;
        if (!empty($pulloutData[0])) {
            $countTotalPullout = $pulloutData[0];
        }

        return $countTotalPullout;
    }

    /**
     * 
     * @param type $isCurrentMonth
     * @return type
     */
    protected function getMaintenaceZoneWiseData($isCurrentMonth = false) {

        $tableName = MAINTENANCE . ' as m';
        $fields = array('l.firstname as zone_name',
            'COUNT(CASE WHEN c.code_name = "open" THEN m.maintenance_id ELSE NULL END) as openMaintenance',
            'COUNT(CASE WHEN c.code_name = "closed" THEN m.maintenance_id ELSE NULL END) as closedMaintenance',
            'COUNT(CASE WHEN c.code_name = "OnHold" THEN m.maintenance_id ELSE NULL END) as holdMaintenance',
            'COUNT(CASE WHEN c.code_name = "Failed" THEN m.maintenance_id ELSE NULL END) as failedMaintenance',
        );

        $join_tables = array(
            //CUSTOMER_MACHINE_INFORMATION . ' as cmi' => 'm.customer_id  = cmi.customer_id',
            CODELOOKUP . ' as c' => 'm.maintenance_status = c.code_id',
            LOGIN . ' as l' => 'm.assigned_to = l.login_id',
        );

        $groupBy = 'm.assigned_to';

        if ($isCurrentMonth) {
            $currentMonth = date('Y-m');
            $whereCond = array('m.is_delete' => '0', 'c.isactive' => 'active', 'DATE_FORMAT(m.updated_at,"%Y-%m")=' => $currentMonth);
        } else {
            $whereCond = array('m.is_delete' => '0', 'c.isactive' => 'active');
            //$whereCond = array('m.is_delete' => '0', 'c.isactive' => 'active', 'c.code_name' => $applyStatus);
        }

        $maintenanceZoneData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $groupBy, '');

        //echo $this->db->last_query();
         //exit;

        $countTotalMaintenanceZone = 0;
        if (!empty($maintenanceZoneData[0])) {
            $countTotalMaintenanceZone = $maintenanceZoneData;
        }

        return $countTotalMaintenanceZone;
    }

}
