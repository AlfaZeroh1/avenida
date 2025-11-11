$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            iphone: 2666,
            ipad: null,
            itouch: 2647
        }, {
            period: '2010 Q2',
            iphone: 2778,
            ipad: 2294,
            itouch: 2441
        }],
        xkey: 'period',
        ykeys: ['iphone', 'ipad', 'itouch'],
        labels: ['iPhone', 'iPad', 'iPod Touch'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });


    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 50,
	    c: 70
        },
	{
	  y: '2007',
	  a: 200,
	  b: 300,
	  c: 150
	},
	{
	  y: '2007',
	  a: 200,
	  b: 300,
	  c: 150
	},
	{
	  y: '2007',
	  a: 200,
	  b: 300,
	  c: 150
	},
	{
	  y: '2007',
	  a: 200,
	  b: 300,
	  c: 150
	},
	{
	  y: '2007',
	  a: 200,
	  b: 300,
	  c: 150
	}
	],
        xkey: 'y',
	ymin: 0,
        ykeys: ['a','b','c'],
        labels: ['Invoiced','Paid','Balance'],
        hideHover: 'auto',
        resize: true
    });
    
});
