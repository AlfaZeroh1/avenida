
    Morris.Area({
        element: 'morris-area-chart',
        data: <?php echo json_encode($arrays);?>,
        xkey: <?php echo $lxkey; ?>,
        ykeys: [<?php echo $lykeys; ?>],
        labels: [<?php echo $llabels; ?>],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
    
    Morris.Bar({
        element: 'morris-bar-chart',
        data: <?php echo json_encode($bar);?>,
        xkey: 'y',
        ymin: 0,
        ykeys: ['a','b','c'],
        labels: ['Invoiced','Paid','Balance'],
        hideHover: 'auto',
        xLabelAngle: 60,
        resize: true
    });
    
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