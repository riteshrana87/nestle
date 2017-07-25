<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session'));
        $this->load->library('excel');

        $this->report_type_array = array(
            'maintenance_report' => 'Maintenance Reports',
            'collection_report' => 'Collection Reports',
            'delivery_report' => 'Delivery Reports',
            'feedback_report' => 'Feedback',
            'installation_report' => 'Installation',
            'pullout_report' => 'Pullout',
            'inventory_report' => 'Inventory',
            'customer_info_report' => 'Customer Information',
        );

        $this->report_status_array = array('open', 'closed');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Report Page
      @Input 	:
      @Output	:
      @Date   : 5th June 2017
     */

    public function index() {

        $this->formValidation(); // Form fields validation 

        if ($this->form_validation->run() == FALSE) {

            // report type list
            $data['report_type'] = $this->report_type_array;

            $data['footerJs'] = array(
                '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                '1' => base_url() . 'uploads/custom/js/Report/Report.js',
            );

            $data['crnt_view'] = $this->viewname;

            $data['meta_title'] = 'Report';

            $data['form_action_path'] = $this->viewname . '/';
            $data['main_content'] = '/report';
            $data['header'] = array('menu_module' => 'report', 'menu_child' => 'report');
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {

            // On success - download Excel file
            // $this->showReportList();
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Report Form Feilds Server Side validation
      @Input 	:
      @Output	:
      @Date   : 5th June 2017
     */

    public function formValidation() {
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('report_type', 'Report Type', 'trim|required|xss_clean');
    }

    /*
     * @Author : Maitrak Modi
     * @Desc   : Report Listing Data
     * @Input 	:
     * @Output	:
     * @Date   : 5th June 2017
     */

    public function showReportList() {

        $startDate = date('Y-m-d', strtotime($this->input->post('start_date')));
        $endDate = date('Y-m-d', strtotime($this->input->post('end_date')));
        $reportType = $this->input->post('report_type');
        $reportStatus = $this->input->post('report_status');

        // Check data are Empty or not
        if (!empty($startDate) && !empty($endDate) && !empty($reportType)) {

            $config['per_page'] = NO_OF_RECORDS_PER_PAGE;
            $data['perpage'] = NO_OF_RECORDS_PER_PAGE;

            $config['first_link'] = 'First';
            $config['uri_segment'] = 3;
            $uri_segment = $this->uri->segment(3);

            $config['base_url'] = base_url() . $this->viewname . '/showReportList/';

            $filterData = array(
                'startDate' => $startDate,
                'endDate' => $endDate,
                'reportType' => $reportType,
                'reportStatus' => $reportStatus,
                'uri_segment' => $uri_segment,
                'perPage' => $config['per_page']
            );

            /**             * ********************* Start - Maintenance Report ************************ */
            if ($reportType === 'maintenance_report') {

                $data['listRecords'] = $this->getMaintenanceData($filterData, $totalRows = false); // get Filter data
                $config['total_rows'] = $this->getMaintenanceData($filterData, $totalRows = true); // get Total data

                $this->ajax_pagination->initialize($config);
                $data['pagination'] = $this->ajax_pagination->create_links();
                $data['uri_segment'] = $uri_segment;

                $this->load->view($this->viewname . '/files/maintenance_report', $data);
            }
            /**             * **************************** End - Maintenance Report ************************ */
            /**             * ********************* Start - Collection Order Report ************************ **** */
            if ($reportType === 'collection_report') {

                $data['listRecords'] = $this->getCollectionOrderData($filterData, $totalRows = false); // get Filter data
                $config['total_rows'] = $this->getCollectionOrderData($filterData, $totalRows = true); // get Total data

                $this->ajax_pagination->initialize($config);
                $data['pagination'] = $this->ajax_pagination->create_links();
                $data['uri_segment'] = $uri_segment;

                $this->load->view($this->viewname . '/files/collection_report', $data);
            }
            /*             * * **************************** End - Collection Order Report ************************ */

            /*             * * ********************* Start - Delivery Order Report ************************ **** */
            if ($reportType === 'delivery_report') {

                $data['listRecords'] = $this->getDeliveryOrderData($filterData, $totalRows = false); // get Filter data
                $config['total_rows'] = $this->getDeliveryOrderData($filterData, $totalRows = true); // get Total data

                $this->ajax_pagination->initialize($config);
                $data['pagination'] = $this->ajax_pagination->create_links();
                $data['uri_segment'] = $uri_segment;

                $this->load->view($this->viewname . '/files/delivery_report', $data);
            }
            /**             * **************************** End - Delivery Order Report ************************ */
            /**             * ********************* Start - Feedback Report ************************ **** */
            if ($reportType === 'feedback_report') {

                $data['listRecords'] = $this->getFeedbackData($filterData, $totalRows = false); // get Filter data
                $config['total_rows'] = $this->getFeedbackData($filterData, $totalRows = true); // get Total data

                $this->ajax_pagination->initialize($config);
                $data['pagination'] = $this->ajax_pagination->create_links();
                $data['uri_segment'] = $uri_segment;

                $this->load->view($this->viewname . '/files/feedback_report', $data);
            }
            /**             * **************************** End - Feedback Report ************************ */
            /**             * ********************* Start - Machine Installation Report ************************ **** */
            if ($reportType === 'installation_report') {

                $data['listRecords'] = $this->getInstallationData($filterData, $totalRows = false); // get Filter data
                $config['total_rows'] = $this->getInstallationData($filterData, $totalRows = true); // get Total data

                $this->ajax_pagination->initialize($config);
                $data['pagination'] = $this->ajax_pagination->create_links();
                $data['uri_segment'] = $uri_segment;

                $this->load->view($this->viewname . '/files/installation_report', $data);
            }
            /**             * **************************** End - Machine Installation Report ************************ */
            /**             * ********************* Start - Machine Pullout Report ************************ **** */
            if ($reportType === 'pullout_report') {

                $data['listRecords'] = $this->getPulloutData($filterData, $totalRows = false); // get Filter data
                $config['total_rows'] = $this->getPulloutData($filterData, $totalRows = true); // get Total data

                $this->ajax_pagination->initialize($config);
                $data['pagination'] = $this->ajax_pagination->create_links();
                $data['uri_segment'] = $uri_segment;

                $this->load->view($this->viewname . '/files/pullout_report', $data);
            }
            /**             * **************************** End - Machine Pullout Report ************************ */
            /**             * ********************* Start - Inventory Report ************************ **** */
            if ($reportType === 'inventory_report') {

                $data['listRecords'] = $this->getInventoryData($filterData, $totalRows = false); // get Filter data
                $config['total_rows'] = $this->getInventoryData($filterData, $totalRows = true); // get Total data

                $this->ajax_pagination->initialize($config);
                $data['pagination'] = $this->ajax_pagination->create_links();
                $data['uri_segment'] = $uri_segment;

                $this->load->view($this->viewname . '/files/inventory_report', $data);
            }
            /**             * **************************** End - Inventory Report ************************ */
            /**             * ********************* Start - Inventory Report ************************ **** */
            if ($reportType === 'customer_info_report') {

                $data['listRecords'] = $this->getCustomerInformationData($filterData, $totalRows = false); // get Filter data
                $config['total_rows'] = $this->getCustomerInformationData($filterData, $totalRows = true); // get Total data

                $this->ajax_pagination->initialize($config);
                $data['pagination'] = $this->ajax_pagination->create_links();
                $data['uri_segment'] = $uri_segment;

                $this->load->view($this->viewname . '/files/customer_info_report', $data);
            }
            /**             * **************************** End - Inventory Report ************************ */
        }
    }

    /*
     * @Author : Maitrak Modi
     * @Desc   : generate query string for download file
     * @Input 	:
     * @Output	:
     * @Date   : 7th June 2017
     */

    public function generateExcelFileUrl() {

        $startDate = date('Y-m-d', strtotime($this->input->post('start_date')));
        $endDate = date('Y-m-d', strtotime($this->input->post('end_date')));
        $reportType = $this->input->post('report_type');
        $reportStatus = $this->input->post('report_status');

        $filterData = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'reportType' => $reportType,
            'reportStatus' => $reportStatus
        );

        $queryString = http_build_query($filterData);

        echo base_url('Report/filterExcelData') . '?' . $queryString;
        exit;
    }

    /*
     * @Author : Maitrak Modi
     * @Desc   : Based on query string filter data
     * @Input 	:
     * @Output	:
     * @Date   : 7th June 2017
     */

    public function filterExcelData() {

        // Get Data
        $startDate = date('Y-m-d', strtotime($this->input->get('startDate')));
        $endDate = date('Y-m-d', strtotime($this->input->get('endDate')));
        $reportType = $this->input->get('reportType');
        $reportStatus = $this->input->get('reportStatus');

        if (!empty($startDate) && !empty($endDate) && !empty($reportType)) {

            if (in_array($reportType, array_keys($this->report_type_array))) {

                $filterFinalData = array(
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'reportType' => $reportType,
                    'reportStatus' => $reportStatus,
                    'uri_segment' => '',
                    'perPage' => ''
                );

                // Allow report Status is Open and closed
                if (($reportType === 'maintenance_report' || $reportType === 'collection_report')) {

                    // Check status is in array or not
                    if (in_array($reportStatus, $this->report_status_array)) {

                        $this->generateExcelFile($filterFinalData); //Call Function for generate excel file
                    } else {
                        echo "Invalid URL";
                        exit;
                    }
                } else {
                    $this->generateExcelFile($filterFinalData); //Call Function for generate excel file
                }
            } else {
                echo "Invalid URL";
                exit;
            }
        } else {
            echo "Invalid URL";
            exit;
        }
    }

    /*
     * @Author : Maitrak Modi
     * @Desc   : Generate Report based on the data
     * @Input 	:
     * @Output	:
     * @Date   : 5th June 2017
     */

    protected function generateExcelFile($filterFinalData) {

        $reportType = $filterFinalData['reportType'];

        $this->activeSheetIndex = $this->excel->setActiveSheetIndex(0);

        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($this->report_type_array[$reportType]);

        /**         * ****************************** Start - Type Based Retrieve Data ******************************** */
        if ($reportType === 'maintenance_report') {

            $passHeaderArray = array('Customer Name', 'Customer Code', 'Location', 'Mobile Number', 'Machine Serial Number', 'Machine Id', 'Asset',
                'Contact Person', 'Contact Number', 'Request Type', 'Address Of Machine', 'Issues', 'Part Replaced', 'Response Date', 'Visited Date', 'Action Taken', 'Comments',
                'Resolution', 'Zone', 'maintenance Status', 'Preventive Type');

            //retrive maintenance table data
            $recordData = $this->getMaintenanceData($filterFinalData, $totalRows = false);
        }

        if ($reportType === 'collection_report') {

            $passHeaderArray = array('Customer Name', 'Customer Code', 'Location', 'Mobile Number',
                'Collection Order Id', 'Contact Name', 'Contact Number',
                'Comments', 'Pickup Location',
                'Collection Date Time', 'Last Due Date Time',
                'Collection Trip Failed', 'Reason for partial or failed collection',
                'Partial Collection Amount',
                'Machine Serial Number',
                'Route',
                'Zone',
                'Collection Order Status', 'Payment Terms',
                'Attachment',
                'Location Map Attachment',
                'Sales Representative');

            //retrive Collection Order table data
            $recordData = $this->getCollectionOrderData($filterFinalData, $totalRows = false);
        }

        if ($reportType === 'delivery_report') {

            $passHeaderArray = array('Customer Name', 'Customer Code', 'Location', 'Mobile Number', 'Conatct Person', 'Contact Number','Email',
                'Delivery Order Id', 'Caller Name', 'Caller Number', 'Delivery Location', 'Remarks', 'LPO Number',
                'Total Amount', 'Order Date', 'Delivery Order Date', 'Order Type','Priority',
                'Machine Serial Number',
                'Payment Terms',
                'Route',
                'Zone',
                'Sales Representative',
                'Delivery Status',
                'Attachment'
            );

            //retrive Delivery Order table data
            $recordData = $this->getDeliveryOrderData($filterFinalData, $totalRows = false);

            /* foreach($recordData as $deliverOrderData){

              $table = DELIVERY_ITEM_LIST;
              $match = "delivery_order_id = " . $deliverOrderData['delivery_order_id'];
              $field = array('*');
              $data['item_details'] = $this->common_model->get_records($table, $field, '', '', $match);
              if($data['item_details'] > 0){

              }
              }

              pr($recordData);
              exit; */
        }

        if ($reportType === 'feedback_report') {

            $passHeaderArray = array('Customer Name', 'Customer_Code', 'Location', 'Mobile Number', 'Auditor', 'Feedback Date', 'Ticket Date', 'Subject', 'Ticket Number', 'Phone Number', 'Overall Level of Satisfaction', 'Attitude of the Employee', 'Specific AFI\'s');
            //retrive Feedback table data
            $recordData = $this->getFeedbackData($filterFinalData, $totalRows = false);
        }

        if ($reportType === 'installation_report') {

            $passHeaderArray = array('Customer Name', 'Customer Code', 'Location', 'Mobile Number', 'Email',
                'Machine Serial Number', 'Assets Number', 'BMB', 'Sap Purchase Date', 'TA Depc. Date', 'Technical Status',
                'Type','Machine Picture','Machine Menu File','Serving Size',
                'Installation Date', 'Machine Installed Location', 'Special Note',
                'Route',
                'Zone',
                'Version Name',
                'Hot/Cold',
                'GEN',
                'Machine Abb',
                'MPR',
                'BevType'
            );
            
            //retrive Installation table data
            $recordData = $this->getInstallationData($filterFinalData, $totalRows = false);
        }

        if ($reportType === 'pullout_report') {

            //$passHeaderArray = array('Customer Name', 'Customer Code', 'Version Name', 'Serial Number', 'Type', 'Installed Date');
            $passHeaderArray = array('Customer Name', 'Customer Code', 'Location', 'Mobile Number', 'Email',
                'Machine Serial Number','Assets Number', 'BMB', 'Sap Purchase Date', 'TA Depc. Date', 'Technical Status',
                'Type','Machine Picture','Machine Menu File','Serving Size',
                'Installation Date', 'Machine Installed Location', 'Special Note',
                'Route',
                'Zone',
                'Version Name',
                'Hot/Cold',
                'GEN',
                'Machine Abb',
                'MPR',
                'BevType',
                'Pullout Location'
            );

            //retrive Pullout table data
            $recordData = $this->getPulloutData($filterFinalData, $totalRows = false);
        }

        if ($reportType === 'inventory_report') {

            $passHeaderArray = array('Machine Sr Number', 'Asset Number', 'BMB', 'Machine Id', 'Machine Tag Number', 'Machine Model Number',
                'Machine Name', 'Machine Manufacturing Year', 'Machine End Of Life', 'Mcahine Location', 'Machine Preparation Date',
                'Technical Status', 'Sap Purchase Date', 'TA Depc. Date', 'Installed Date',
                'Version Name',
                'Status',
                'Warehouse Location',
                'Hot/Cold',
                'GEN',
                'Machine Abb',
                'MPR',
                'BevType');

            //retrive Inventory table data
            $recordData = $this->getInventoryData($filterFinalData, $totalRows = false);
        }

        if ($reportType === 'customer_info_report') {

            $passHeaderArray = array('Customer Name', 'Customer code', 'Location', 'Mobile Number',
                'Trading Type', 'Email', 'Commercial/Institutional', 'PO Box', 'New Channel Classification',
                'Conatct Name', 'Contact Number', 'Contract Available', 'Special Note', 'Payment Terms',
                'Version Name',
                'Machine Serial Number','Sap Purchase Date', 'TA Depc. Date', 'Technical Status',
                'Installation Date', 'Machine Installed Location', 'Machine Comment','Machine Picture','Machine Menu File','Serving Size',
                'Emirate',
                'Zone',
                'Route',
                'Hot/Cold',
                'GEN',
                'Machine Abb',
                'MPR',
                'BevType',
                'Sales Representative');

            //retrive Customer information table data
            $recordData = $this->getCustomerInformationData($filterFinalData, $totalRows = false);
        }
        /**         * ****************************** End - Type Based Retrieve Data ******************************** */
        $exceldataHeader = "";
        $exceldataValue = "";
        $headerCount = 1;

        foreach ($recordData as $rowValue) {

            if ($headerCount === 1) {
                $exceldataHeader[] = $passHeaderArray; //array_keys($rowValue); // Set Header of the generated Excel File
                //continue;
            }
            $exceldataValue[] = $rowValue; // Set values
            $headerCount++;
        }

        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldataHeader, Null, 'A1'); // Set Header Data
        $this->excel->getActiveSheet()->fromArray($exceldataValue, Null, 'A2'); // Set Fetch Data

        if ($reportType === 'delivery_report') {
            $this->getDeliveryOrderItemListData($filterFinalData);
        }

        if ($reportType === 'collection_report') {
            $this->getCollectionOrderListData($filterFinalData);
        }

        $this->activeSheetIndex = $this->excel->setActiveSheetIndex(0);
        $fileName = $reportType . date('Y-m-d H:i:s') . '.xls'; // Generate file name

        $this->downloadExcelFile($this->excel, $fileName); // download function Xls file function call
    }

    /**
     * @Autor Maitrak Modi
     * @Desc downloadExcelfile
     * @param type $excel     
     * @return type
     * @Date 6th June 2017
     */
    Protected function downloadExcelFile($objExcel, $fileName) {

        $this->excel = $objExcel;

        //$filename = 'PHPExcelDemo.xls'; //save our workbook as this file name

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $fileName . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

        ob_end_clean();
        ob_start();

        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');

        exit;
    }

    /**
     * @Autor Maitrak Modi
     * @Desc Get Maintenance Data
     * @param type $fileterData
     * @param type $totalRows
     * @return type
     * @Date 6th June 2017
     */
    Protected function getMaintenanceData($fileterData, $totalRows = false) {

        /* Start - Filter Query */
        $tableName = MAINTENANCE . ' as m';

        $fields = array('ce.customer_name, ce.customer_code, ce.location, ce.mobile_number,
                        mi.machine_serial_number, mi.machine_id, mi.asset,
                        m.contact_person, m.contact_number, IF(m.request_type = "cm", "Corrective Maintenance", "Preventive Maintenance") as r_type,
                        m.address_of_machine, m.issues, m.part_replaced, m.responase_date, m.visited_date, m.action_taken, m.comments, m.resolution,
                        l.firstname as zone_name,
                        c.code_name,
                        m.preventive_maintenance
                ');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'm.customer_id  = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'm.location_id = mi.inventory_id',
            LOGIN . ' as l' => 'm.assigned_to = l.login_id',
            CODELOOKUP . ' as c' => 'm.maintenance_status = c.code_id',
        );

        //$whereCond = array();
        $whereCond = array('m.is_delete' => '0', 'DATE(m.updated_at) >=' => $fileterData['startDate'], 'DATE(m.updated_at) <=' => $fileterData['endDate'], 'c.code_name' => $fileterData['reportStatus']);


        if (!$totalRows) {

            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $fileterData['perPage'], $fileterData['uri_segment'], '', '', '', '');
            //echo $this->db->last_query(); exit;
        }
        if ($totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '1');
        }
    }

    /**
     * @Autor Maitrak Modi
     * @Desc Get Maintenance Data
     * @param type $fileterData
     * @param type $totalRows
     * @return type
     * @Date 6th June 2017
     */
    Protected function getCollectionOrderData($fileterData, $totalRows = false) {

        /* Start - Filter Query */
        $tableName = COLLECTION_ORDER . ' as co';
        $fields = array('ce.customer_name, ce.customer_code, ce.location, ce.mobile_number,
                        co.collection_order_id, co.contact_person, co.contact_number, 
                        co.comments, co.pickup_location,
                        co.co_date_time, co.last_due_date_time,
                        co.collection_trip_failed, co.reason_for_payment,
                        co.partial_collection_amount,
                        mi.machine_serial_number,
                        r.name as route_name,
                        l.firstname as zone_name,
                        c.code_name as co_status,
                        CONCAT(pt.name,"-",pt.description) as payment_term,
                        co.attachments,
                        co.location_attachments,
                        lp.firstname as sales_representative
                        ');

        $join_tables = array(
            CODELOOKUP . ' as c' => 'co.collection_order_status = c.code_id',
            CUSTOMER_ENROLMENT . ' as ce' => 'co.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'co.sr_number_installation  = mi.inventory_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
            LOGIN . ' as l' => 'co.zone = l.login_id',
            LOGIN . ' as lp' => 'co.sales_representative = lp.login_id',
            PAYMENT_TERMS . ' as pt' => 'co.payment_terms_id = pt.payment_terms_id',
        );

        $whereCond = array('co.is_delete' => '0', 'c.isactive' => 'active', 'DATE(co.co_date_time) >=' => $fileterData['startDate'], 'DATE(co.co_date_time)  <=' => $fileterData['endDate'], 'c.code_name' => $fileterData['reportStatus']);

        if (!$totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $fileterData['perPage'], $fileterData['uri_segment'], '', '', '', '');
            //echo $this->db->last_query(); exit;
        }
        if ($totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '1');
        }
    }

    /**
     * @Autor Maitrak Modi
     * @Desc Get Delivery Order Data
     * @param type $fileterData
     * @param type $totalRows
     * @return type
     * @Date 6th June 2017
     */
    Protected function getDeliveryOrderData($fileterData, $totalRows = false) {

        /* Start - Filter Query */
        $tableName = DELIVERY_ORDER . ' as do';

        $fields = array('ce.customer_name, ce.customer_code, ce.location, ce.mobile_number, ce.contact_name, ce.contact_number, ce.email,
            do.delivery_order, do.caller_name, do.caller_number, do.delivery_location, do.remarks, do.lpo_number, 
            do.total_amount, do.order_date, do.delivery_date, do.order_type, cp.code_name as priority,
            mi.machine_serial_number,
            CONCAT(pt.name,"-",pt.description) as payment_term,
            r.name as route_name,
            l.firstname as zone_name,
            lp.firstname as sales_representative,
            c.code_name as delivery_status,
            do.attachments
            ');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'ce.customer_id = do.customer_code',
            MACHINE_INVENTORY . ' as mi' => 'do.sr_number = mi.inventory_id',
            CODELOOKUP . ' as c' => 'do.delivery_status = c.code_id',
            PAYMENT_TERMS . ' as pt' => 'ce.payment_terms_id = pt.payment_terms_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
            LOGIN . ' as l' => 'do.zone = l.login_id',
            LOGIN . ' as lp' => 'do.created_by = lp.login_id',
            CODELOOKUP . ' as cp' => 'do.priority = cp.code_id',
        );


        $whereCond = array('do.is_deleted' => '0', 'c.isactive' => 'active', 'DATE(do.delivery_date) >=' => $fileterData['startDate'], 'DATE(do.delivery_date)  <=' => $fileterData['endDate'], 'c.code_name' => $fileterData['reportStatus']);

        if (!$totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $fileterData['perPage'], $fileterData['uri_segment'], '', '', '', '');
            // echo $this->db->last_query();
            // exit;
        }
        if ($totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '1');
        }
    }

    /**
     * @Autor Maitrak Modi
     * @Desc Get Feedback Data
     * @param type $fileterData
     * @param type $totalRows
     * @return type
     * @Date 22nd June 2017
     */
    Protected function getFeedbackData($fileterData, $totalRows = false) {

        /* Start - Filter Query */
        $tableName = FEEDBACK . ' as f';
        $fields = array('f.customer_name, ce.customer_code, ce.location, ce.mobile_number,
            f.auditor, f.feedback_date, f.ticket_date, f.subject, f.ticket_number, f.phone_number, f.satisfaction_level,
            f.attitude_of_emp, f.specific_afi');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'f.customer_id = ce.customer_id'
        );

        //$whereCond = array();
        $whereCond = array('f.is_delete' => '0', 'DATE(f.feedback_date) >=' => $fileterData['startDate'], 'DATE(f.feedback_date) <=' => $fileterData['endDate']);


        if (!$totalRows) {

            return $this->common_model->get_records($tableName, $fields, $join_tables, '', $whereCond, '', $fileterData['perPage'], $fileterData['uri_segment'], '', '', '', '');
            //echo $this->db->last_query(); exit;
        }
        if ($totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, '', $whereCond, '', '', '', '', '', '', '', '', '', '1');
        }
    }

    /**
     * @Autor Maitrak Modi
     * @Desc Get Machine Installation data
     * @param type $fileterData
     * @param type $totalRows
     * @return type
     * @Date 6th June 2017
     */
    Protected function getInstallationData($fileterData, $totalRows = false) {

        /* Start - Filter Query */
        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('ce.customer_name, ce.customer_code, ce.location, ce.mobile_number, ce.email,
                        mi.machine_serial_number, mi.asset, mi.bmb, mi.sap_purchase_date , mi.ta_depc_date, cts.code_name as technial_status,
                        cmi.machine_assign_type,cmi.machine_picture, cmi.machine_menu_file, cs.code_name as serving_size,
                        cmi.installation_date, cmi.machine_installed_location, cmi.machine_comment, 
                        r.name as route_name,
                        l.firstname as zone_name,
                        v.version_name,
                        ch.code_name as hot_cold_name,
                        cg.code_name as gen_name,
                        cma.code_name as machine_abb_name,
                        cmm.code_name as machine_mpr_name,
                        cbv.code_name as bev_type_name
            ');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
            VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
            LOGIN . ' as l' => 'cmi.zone = l.login_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
            CODELOOKUP . ' as ch' => 'v.hot_cold_type = ch.code_id',
            CODELOOKUP . ' as cg' => 'v.gen = cg.code_id',
            CODELOOKUP . ' as cma' => 'v.machine_abb = cma.code_id',
            CODELOOKUP . ' as cmm' => 'v.machine_mpr = cmm.code_id',
            CODELOOKUP . ' as cbv' => 'v.bev_type = cbv.code_id',
            CODELOOKUP . ' as cts' => 'mi.technial_status = cts.code_id',
            CODELOOKUP . ' as cs' => 'cmi.serving_size = cs.code_id',
        );

        $whereCond = array('cmi.is_delete' => '0', 'ce.is_delete' => '0', 'cmi.machine_assign_type' => 'Installation', 'DATE(cmi.installation_date) >=' => $fileterData['startDate'], 'DATE(cmi.installation_date)  <=' => $fileterData['endDate']);

        if (!$totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $fileterData['perPage'], $fileterData['uri_segment'], '', '', '', '');
            //echo $this->db->last_query(); exit;
        }
        if ($totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '1');
        }
    }

    /**
     * @Autor Maitrak Modi
     * @Desc Get Machine Pullout Data
     * @param type $fileterData
     * @param type $totalRows
     * @return type
     * @Date 6th June 2017
     */
    Protected function getPulloutData($fileterData, $totalRows = false) {

        /* Start - Filter Query */
        /* $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';

          $fields = array('ce.customer_name, ce.customer_code, v.version_name, mi.machine_serial_number, cmi.machine_assign_type, cmi.installation_date');

          $join_tables = array(
          CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
          MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
          VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
          ROUTE . ' as r' => 'ce.route_id = r.route_id',
          ); */

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('ce.customer_name, ce.customer_code, ce.location, ce.mobile_number, ce.email,
                        mi.machine_serial_number, mi.asset, mi.bmb, mi.sap_purchase_date , mi.ta_depc_date, cts.code_name as technial_status,
                        cmi.machine_assign_type,cmi.machine_picture, cmi.machine_menu_file, cs.code_name as serving_size,
                        cmi.installation_date, cmi.machine_installed_location, cmi.machine_comment, 
                        r.name as route_name,
                        l.firstname as zone_name,
                        v.version_name,
                        ch.code_name as hot_cold_name,
                        cg.code_name as gen_name,
                        cma.code_name as machine_abb_name,
                        cmm.code_name as machine_mpr_name,
                        cbv.code_name as bev_type_name,
                        plo.code_name
            ');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
            VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
            LOGIN . ' as l' => 'cmi.zone = l.login_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
            CODELOOKUP . ' as ch' => 'v.hot_cold_type = ch.code_id',
            CODELOOKUP . ' as cg' => 'v.gen = cg.code_id',
            CODELOOKUP . ' as cma' => 'v.machine_abb = cma.code_id',
            CODELOOKUP . ' as cmm' => 'v.machine_mpr = cmm.code_id',
            CODELOOKUP . ' as cbv' => 'v.bev_type = cbv.code_id',
            CODELOOKUP . ' as plo' => 'cmi.pullout_location_id  = plo.code_id',
            CODELOOKUP . ' as cts' => 'mi.technial_status = cts.code_id',
            CODELOOKUP . ' as cs' => 'cmi.serving_size = cs.code_id',
        );

        $whereCond = array('cmi.is_delete' => '0', 'ce.is_delete' => '0', 'cmi.machine_assign_type' => 'Pullout', 'DATE(cmi.installation_date) >=' => $fileterData['startDate'], 'DATE(cmi.installation_date)  <=' => $fileterData['endDate']);

        if (!$totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $fileterData['perPage'], $fileterData['uri_segment'], '', '', '', '');
            //echo $this->db->last_query(); exit;
        }
        if ($totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '1');
        }
    }

    /**
     * @Autor Maitrak Modi
     * @Desc Get Machine Inventory Data
     * @param type $fileterData
     * @param type $totalRows
     * @return type
     * @Date 6th June 2017
     */
    Protected function getInventoryData($fileterData, $totalRows = false) {

        /* Start - Filter Query */
        $tableName = MACHINE_INVENTORY . ' as mi';

        $fields = array('mi.machine_serial_number, mi.asset, mi.bmb, mi.machine_id, mi.machine_tag_number, mi.machine_model_number,
            mi.machine_name, mi.machine_manufacturing_year, mi.machine_end_of_life, mi.machine_location, mi.machine_preaparation_date, 
            cts.code_name as technial_status, mi.sap_purchase_date, mi.ta_depc_date, mi.installation_date,
            v.version_name,
            c.code_name,
            cwl.code_name as wareHouseLocation,
            ch.code_name as hot_cold_name,
            cg.code_name as gen_name,
            cma.code_name as machine_abb_name,
            cmm.code_name as machine_mpr_name,
            cbv.code_name as bev_type_name');

        $join_tables = array(
            VERSION_MASTER . ' as v' => 'mi.version_id = v.version_id',
            CODELOOKUP . ' as c' => 'mi.machine_status_id = c.code_id',
            CODELOOKUP . ' as cwl' => 'mi.machine_warehouse_location = cwl.code_id',
            CODELOOKUP . ' as cts' => 'mi.technial_status = cts.code_id',
            CODELOOKUP . ' as ch' => 'v.hot_cold_type = ch.code_id',
            CODELOOKUP . ' as cg' => 'v.gen = cg.code_id',
            CODELOOKUP . ' as cma' => 'v.machine_abb = cma.code_id',
            CODELOOKUP . ' as cmm' => 'v.machine_mpr = cmm.code_id',
            CODELOOKUP . ' as cbv' => 'v.bev_type = cbv.code_id',
        );

        $whereCond = array('mi.is_delete' => '0', 'DATE(mi.machine_preaparation_date) >=' => $fileterData['startDate'], 'DATE(mi.machine_preaparation_date)  <=' => $fileterData['endDate']);

        if (!$totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $fileterData['perPage'], $fileterData['uri_segment'], '', '', '', '');
            //echo $this->db->last_query(); exit;
        }
        if ($totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '1');
        }
    }

    /**
     * @Autor Maitrak Modi
     * @Desc Get Customer Information Data
     * @param type $fileterData
     * @param type $totalRows
     * @return type
     * @Date 6th June 2017
     */
    Protected function getCustomerInformationData($fileterData, $totalRows = false) {

        /* Start - Filter Query */

        /* $tableName = CUSTOMER_ENROLMENT . ' as ce';
          $fields = array('
          ce.customer_name, ce.customer_code, ce.location, ce.mobile_number,
          em.name as emirate_name, v.version_name');

          $join_tables = array(
          VERSION_MASTER . ' as v' => 'ce.version_id = v.version_id',
          EMIRATE . ' as em' => 'ce.emirates_id = em.emirate_id',
          ROUTE . ' as r' => 'ce.route_id = r.route_id',
          );
         */

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';

        $fields = array('ce.customer_name, ce.customer_code, ce.location, ce.mobile_number,
            td.code_name as tranding_type, ce.email, ce.commercial_institutional, ce.pob, ce.new_channel_classification, 
            ce.contact_name, ce.contact_number, ce.contract_available, ce.customer_special_note, CONCAT(pt.name,"-",pt.description) as payment_term,
            v.version_name,
            mi.machine_serial_number, mi.sap_purchase_date , mi.ta_depc_date, cts.code_name as technial_status,
            cmi.installation_date, cmi.machine_installed_location, cmi.machine_comment, cmi.machine_picture, cmi.machine_menu_file, cs.code_name as serving_size,
            em.name as emirate_name,
            l.firstname as zone_name,
            r.name as route_name,
            ch.code_name as hot_cold_name,
            cg.code_name as gen_name,
            cma.code_name as machine_abb_name,
            cmm.code_name as machine_mpr_name,
            cbv.code_name as bev_type_name,
            l.firstname as sales_representative
            ');

        $join_tables = array(
            VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            EMIRATE . ' as em' => 'ce.emirates_id = em.emirate_id',
            MACHINE_INVENTORY . ' as mi' => 'mi.inventory_id = cmi.sr_number_id',
            LOGIN . ' as l' => 'cmi.zone = l.login_id',
            CODELOOKUP . ' as td' => 'ce.trading_type_id = td.code_id',
            PAYMENT_TERMS . ' as pt' => 'ce.payment_terms_id = pt.payment_terms_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
            CODELOOKUP . ' as ch' => 'v.hot_cold_type = ch.code_id',
            CODELOOKUP . ' as cg' => 'v.gen = cg.code_id',
            CODELOOKUP . ' as cma' => 'v.machine_abb = cma.code_id',
            CODELOOKUP . ' as cmm' => 'v.machine_mpr = cmm.code_id',
            CODELOOKUP . ' as cbv' => 'v.bev_type = cbv.code_id',
            CODELOOKUP . ' as cs' => 'cmi.serving_size = cs.code_id',
            CODELOOKUP . ' as cts' => 'mi.technial_status = cts.code_id',
            LOGIN . ' as lp' => 'ce.sales_representative  = lp.login_id',
        );

        $whereCond = array('ce.is_delete' => '0', 'DATE(ce.created_at) >=' => $fileterData['startDate'], 'DATE(ce.created_at)  <=' => $fileterData['endDate']);

        if (!$totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $fileterData['perPage'], $fileterData['uri_segment'], '', '', '', '');
            //echo $this->db->last_query(); exit;
        }
        if ($totalRows) {
            return $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '1');
        }
    }

    /**
     * 
     * @param type $recordData
     * @param type $fileterData
     * @return boolean
     */
    protected function getDeliveryOrderItemListData($fileterData) {

        $tableName = DELIVERY_ITEM_LIST . ' as doi';

        $chequeField = array('doi.delivery_order_id, do.delivery_order, ca.cat_name, sca.subcat_name, doi.quantity, doi.price, doi.sub_total');

        $join_tables = array(
            DELIVERY_ORDER . ' as do' => 'doi.delivery_order_id = do.delivery_order_id',
            CATEGORY . ' as ca' => 'doi.ingredient_id  = ca.cat_id',
            SUBCATEGORY . ' as sca' => 'doi.subcat_id  = sca.subcat_id',
            CODELOOKUP . ' as c' => 'do.delivery_status = c.code_id',
        );

        $whereCond = array('do.is_deleted' => '0', 'c.isactive' => 'active', 'DATE(do.delivery_date) >=' => $fileterData['startDate'], 'DATE(do.delivery_date)  <=' => $fileterData['endDate'], 'c.code_name' => $fileterData['reportStatus']);
        $doItemInfoList = $this->common_model->get_records($tableName, $chequeField, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '', '');

        //pr($doItemInfoList);
        //exit;
        if (!empty($doItemInfoList['0'])) {

            $this->excel->createSheet();

            $this->activeSheetIndex = $this->excel->setActiveSheetIndex(1);

            $this->excel->getActiveSheet()->setTitle('DO_Items');

            $last_v = $doItemInfoList['0']['delivery_order'];

            foreach ($doItemInfoList as $doInfo) {

                if ($last_v != $doInfo['delivery_order']) {

                    $doInfoArray[] = array();
                }

                $doInfoArray[] = array(
                    'delivery_order_id' => $doInfo['delivery_order'],
                    'ingredient' => $doInfo['cat_name'],
                    'type' => $doInfo['subcat_name'],
                    'quantity' => $doInfo['quantity'],
                    'price' => $doInfo['price'],
                    'sub_total' => $doInfo['sub_total'],
                );

                $last_v = $doInfo['delivery_order'];
            }

            //pr($doInfoArray);
            //exit;
            $doHeader = array('Delivery Order Id', 'Ingredient', 'Type', 'Quantity', 'Price', 'Sub Total');

            $this->excel->getActiveSheet()->fromArray($doHeader, Null, 'A1'); // Set Header Data
            $this->excel->getActiveSheet()->fromArray($doInfoArray, Null, 'A2'); // Set Fetch Data
        }
        return true;
    }

    /**
     * 
     * @param type $recordData
     * @param type $fileterData
     * @return boolean
     */
    protected function getCollectionOrderListData($fileterData) {

        $tableName = CO_CHEQUE_INFO . ' as cc';
        $chequeField = array('cc.co_cheque_info_id, cc.collection_id, cc.reference, cc.invoice, cc.po, cc.amount,'
            . 'co.collection_order_id');

        $join_tables = array(
            COLLECTION_ORDER . ' as co' => 'cc.collection_id = co.collection_id',
            CODELOOKUP . ' as c' => 'co.collection_order_status = c.code_id',
        );

        $whereCond = array('co.is_delete' => '0', 'c.isactive' => 'active', 'DATE(co.co_date_time) >=' => $fileterData['startDate'], 'DATE(co.co_date_time)  <=' => $fileterData['endDate'], 'c.code_name' => $fileterData['reportStatus']);

        $chequeInfoList = $this->common_model->get_records($tableName, $chequeField, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '', '');
        // pr($chequeInfoList);
        // exit;
        if (!empty($chequeInfoList['0'])) {

            $this->excel->createSheet();

            $this->activeSheetIndex = $this->excel->setActiveSheetIndex(1);

            $this->excel->getActiveSheet()->setTitle('CO_Cheque_Info');

            $last_v = $chequeInfoList['0']['collection_order_id'];

            foreach ($chequeInfoList as $ccInfo) {

                if ($last_v != $ccInfo['collection_order_id']) {
                    $ccInfoArray[] = array();
                }
                $ccInfoArray[] = array(
                    'collection_order_id' => $ccInfo['collection_order_id'],
                    'reference' => $ccInfo['reference'],
                    'invoice' => $ccInfo['invoice'],
                    'po' => $ccInfo['po'],
                    'amount' => $ccInfo['amount']
                );
                $last_v = $ccInfo['collection_order_id'];
            }


            $coHeader = array('Collection Order Id', 'Reference', 'Invoice', 'PO', 'Amount');

            $this->excel->getActiveSheet()->fromArray($coHeader, Null, 'A1'); // Set Header Data
            $this->excel->getActiveSheet()->fromArray($ccInfoArray, Null, 'A2'); // Set Fetch Data   
        }
        return true;
    }

}
