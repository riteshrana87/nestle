
<script>
    //maintenance Monthly
    var monthly_open_total_maintenance = <?php echo $totalMaintenanceMonth['openMaintenance'] ?>;
    var monthly_closed_total_maintenance = <?php echo $totalMaintenanceMonth['closedMaintenance'] ?>;

    //maintenance Daily
    var daily_open_total_maintenance = <?php echo $totalMaintenanceDay['openMaintenance'] ?>;
    var daily_closed_total_maintenance = <?php echo $totalMaintenanceDay['closedMaintenance'] ?>;

    //CO Monthly
    var monthly_open_total_co = <?php echo $totalCollectionOrderMonth['openCollectionOrder'] ?>;
    var monthly_closed_total_co = <?php echo $totalCollectionOrderMonth['closedCollectionOrder'] ?>;

    //CO Daily
    var daily_open_total_co = <?php echo $totalCollectionOrderDay['openCollectionOrder'] ?>;
    var daily_closed_total_co = <?php echo $totalCollectionOrderDay['closedCollectionOrder'] ?>;

    //DO Monthly
    var monthly_open_total_do = <?php echo $totalDeliveryOrderMonth['openDeliveryOrder'] ?>;
    var monthly_closed_total_do = <?php echo $totalDeliveryOrderMonth['closedDeliveryOrder'] ?>;

    //DO Daily
    var daily_open_total_do = <?php echo $totalDeliveryOrderDay['openDeliveryOrder'] ?>;
    var daily_closed_total_do = <?php echo $totalDeliveryOrderDay['closedDeliveryOrder'] ?>;

    //Installation and Pullout Monthly
    var monthly_open_total_installation = <?php echo $totalInstallationMonth['totalInstallation'] ?>;
    var monthly_open_total_pullout = <?php echo $totalPulloutMonth['totalPullout'] ?>;

</script>

<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Dashboard - Nestle</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maintenance Monthly
                    </div>
                    <div class="panel-body">
                        <div id="chart-maintenance-monthly" class="chart-container"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maintenance Daily
                    </div>
                    <div class="panel-body">
                        <div id="chart-maintenance-day" class="chart-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Collection Order Monthly
                    </div>
                    <div class="panel-body">
                        <div id="chart-co-monthly" class="chart-container"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Collection Order Daily
                    </div>
                    <div class="panel-body">
                        <div id="chart-co-day" class="chart-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Delivery Order Monthly
                    </div>
                    <div class="panel-body">
                        <div id="chart-do-monthly" class="chart-container"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Delivery Order Daily
                    </div>
                    <div class="panel-body">
                        <div id="chart-do-day" class="chart-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Installation and Pullout Monthly
                    </div>
                    <div class="panel-body">
                        <div id="chart-installation-pullout-monthly" class="chart-container"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maintenance By Technicians
                    </div>
                    <div class="panel-body">
                        <table class='table table-bordered table-striped'>
                            <tr>
                                <th>Zone Name</th>
                                <th>Open</th>
                                <th>Hold</th>
                                <th>Delayed</th>
                            </tr>
                            <?php
                            if (!empty($maintenanceZoneWiseData)) {
                                foreach ($maintenanceZoneWiseData as $maintenaceZoneList) {
                                    if (!empty($maintenaceZoneList['zone_name'])) {
                                        ?>
                                        <tr>
                                            <td><?php echo $maintenaceZoneList['zone_name']; ?></td>
                                            <td><?php echo $maintenaceZoneList['openMaintenance']; ?></td>
                                            <td><?php echo $maintenaceZoneList['holdMaintenance']; ?></td>
                                            <td><?php echo $maintenaceZoneList['failedMaintenance']; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else {
                                ?>
                                <tr>
                                    <td colspan="4">
                                        <?php echo "No Record Found" ?>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
