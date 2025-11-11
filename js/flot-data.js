
//Flot Pie Chart
$(function() {
	
    var data = [{
        label: "Invoiced",
        data: 9
    }, {
        label: "Paid",
        data: 20
    }, {
        label: "Balance",
        data: 30
    }];

    var plotObj = $.plot($("#flot-pie-chart"), data, {
        series: {
            pie: {
                show: true
            }
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            },
            defaultTheme: false
        }
    });

});
