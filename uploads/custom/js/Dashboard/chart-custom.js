$(function () {

    monthly('Maintenance', 'chart-maintenance-monthly', monthly_open_total_maintenance, monthly_closed_total_maintenance); //Maintenance Monthly
    daily('Maintenance', 'chart-maintenance-day', daily_open_total_maintenance, daily_closed_total_maintenance); //Maintenance Daily

    monthly('Collection Order', 'chart-co-monthly', monthly_open_total_co, monthly_closed_total_co); //CO Monthly
    daily('Collection Order', 'chart-co-day', daily_open_total_co, daily_closed_total_co); //CO Daily

    monthly('Delivery Order', 'chart-do-monthly', monthly_open_total_do, monthly_closed_total_do,'In Progress','Successfully Delivered'); //DO Monthly
    daily('Delivery Order', 'chart-do-day', daily_open_total_do, daily_closed_total_do,'In Progress','Successfully Delivered'); //DO Daily

    monthly('Installation and Pullout', 'chart-installation-pullout-monthly', monthly_open_total_installation, monthly_open_total_pullout, 'Installation', 'Pullout'); //DO Monthly
});

//Monthly Chart
function monthly(type, divID, openCount, closedCount, dataName1 = 'Open', dataName2 = 'Closed') {

    //Monthly
    var Monthly = Highcharts.chart(divID, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: type + ' - Monthly'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
                name: 'Monthly',
                colorByPoint: true,
                data: [{
                        name: dataName1 + ' (' + openCount + ')',
                        y: openCount,
                        color: '#DE3A15'
                    }, {
                        name: dataName2 + ' (' + closedCount + ')',
                        y: closedCount,
                        sliced: false,
                       // selected: true,
                        color: '#FF9A00'
                    }]
            }],
        credits: {
            enabled: false
        },
    });

}

//Daily Chart
function daily(type, divID, openCount, closedCount, dataName1 = 'Open', dataName2 = 'Closed') {

    //Monthly
    var Daily = Highcharts.chart(divID, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: type + ' - Daily'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
                name: 'Daily',
                colorByPoint: true,
                data: [{
                        name: dataName1 + ' (' + openCount + ')',
                        y: openCount,
                        color: '#DE3A15'
                    }, {
                        name: dataName2 + ' (' + closedCount + ')',
                        y: closedCount,
                        sliced: false,
                        //selected: true,
                        color: '#FF9A00'
                    }]
            }],
         credits: {
            enabled: false
        },
    });

}