// var chart = AmCharts.makeChart( "chart_area1", {
//   "type": "serial",
//   "theme": "none",
//   "dataProvider": [ {
//     "country": "USA",
//     "visits": 500,
//     "color": "#8e24aa"
//   }, {
//     "country": "China",
//     "visits": 200,
//     "color": "#ff6e40"
//   }, {
//     "country": "Japan",
//     "visits": 350,
//     "color": "#8e24aa"
//   }, {
//     "country": "Germany",
//     "visits": 400,
//     "color": "#ff6e40"
//   }, {
//     "country": "UK",
//     "visits": 180,
//     "color": "#8e24aa"
//   }, {
//     "country": "India",
//     "visits": 450,
//     "color": "#ff6e40"
//   }, {
//     "country": "Sri Lanka",
//     "visits": 35,
//     "color": "#8e24aa"
//   }, {
//     "country": "France",
//     "visits": 98,
//     "color": "#ff6e40"
//   } ],
//   "valueAxes": [ {
//     //"title": "Axis title",
//     "titleColor": "#565656",
//     "titleFontSize": 12,
//     "gridColor": "transparents",
//     "dashLength": 0,
//     "color": "#565656",
//     "fontSize": 9,
//     "axisColor": "transparents",
//     "axisThickness": 0,
//   } ],
//   "gridAboveGraphs": true,
//   "startDuration": 1,
//   "graphs": [ {
//     "balloonText": "[[category]]: <b>[[value]]</b>",
//     "fillAlphas": 1,
//     "fillColors": "#8e24aa",
//     //"fillColorsField": "color",
//     "lineAlpha": 0,
//     "lineThickness": 0,
//     "type": "column",
//     "valueField": "visits"
//   } ],
//   "chartCursor": {
//     "categoryBalloonEnabled": false,
//     "cursorAlpha": 0,
//     "zoomable": false
//   },
//   "categoryField": "country",
//   "categoryAxis": {
//     //"title": "Axis title 2",
//     "titleColor": "#565656",
//     "titleFontSize": 12,
//     "gridColor": "transparents",
//     "dashLength": 0,
//     "color": "#565656",
//     "fontSize": 9,
//     "axisColor": "transparents",
//     "axisThickness": 0,
//   },
//   "export": {
//     "enabled": true
//   }
// } );

// var chart = AmCharts.makeChart("chart_area2",{
//   "type": "pie",
//   "startDuration": 1,
//   "titleField": "category",
//   "valueField": "column-1",
//   "showZeroSlices": true,
//   "groupedAlpha": 0,
//   "legend": {
//     "useGraphSettings": true,
//     "align": "center",
//     "fontSize": 9,
//     "markerLabelGap": 5,
//     "markerSize": 5,
//     "markerType": "circle",
//     "markerBorderThickness": 0,
//     "marginLeft": 0,
//     "marginRight": 0,
//     "showEntries":true,
//     "switchable": false,
//     "valueAlign": "left",
//   },
//   "dataProvider"  : [
//     {
//       "category": "category alpha",
//       "column-1": 8
//     },
//     {
//       "category": "category beta",
//       "column-1": 6
//     },
//     {
//       "category": "category gama",
//       "column-1": 2
//     }
//   ]
// });

// var chart = AmCharts.makeChart("chart_area3", {
//   "type": "serial",
//   "theme": "none",
//   "categoryField": "year",
//   "rotate": false,
//   "startDuration": 1,
//   "categoryAxis": {
//     "gridPosition": "start",
//     "titleColor": "#565656",
//     "titleFontSize": 12,
//     "gridColor": "transparents",
//     "dashLength": 0,
//     "color": "#565656",
//     "fontSize": 9,
//     "axisColor": "transparents",
//     "axisThickness": 0,
//   },
//   "trendLines": [],
//   "graphs": [
//     {
//       "balloonText": "Income:[[value]]",
//       "id": "AmGraph-1",
//       "fillAlphas": 1,
//       "fillColors": "#8e24aa",
//       "lineAlpha": 0,
//       "lineThickness": 0,
//       "title": "Income",
//       "type": "column",
//       "valueField": "income"
//     },
//     {
//       "balloonText": "Expenses:[[value]]",
//       "id": "AmGraph-2",
//       "fillAlphas": 1,
//       "fillColors": "#ff6e40",
//       "lineAlpha": 0,
//       "lineThickness": 0,
//       "title": "Expenses",
//       "type": "column",
//       "valueField": "expenses"
//     }
//   ],
//   "guides": [],
//   "valueAxes": [
//     {
//       // "id": "ValueAxis-1",
//       "axisAlpha": 0,
//       "titleColor": "#565656",
//       "titleFontSize": 12,
//       "gridColor": "transparents",
//       "dashLength": 0,
//       "color": "#565656",
//       "fontSize": 9,
//       "axisColor": "transparents",
//       "axisThickness": 0,
//     }
//   ],
//   "allLabels": [],
//   "balloon": {},
//   "titles": [],
//   "dataProvider": [
//     {
//       "year": 2005,
//       "income": 23.5,
//       "expenses": 18.1
//     },
//     {
//       "year": 2006,
//       "income": 26.2,
//       "expenses": 22.8
//     },
//     {
//       "year": 2007,
//       "income": 30.1,
//       "expenses": 23.9
//     },
//     {
//       "year": 2008,
//       "income": 29.5,
//       "expenses": 25.1
//     },
//     {
//       "year": 2009,
//       "income": 24.6,
//       "expenses": 25
//     }
//   ],
//     "export": {
//     	"enabled": true
//      }

// });

// var chart = AmCharts.makeChart("chart_area4", {
//   "type": "serial",
//   "theme": "none",
//   "categoryField": "year",
//   "rotate": true,
//   "startDuration": 1,
//   "categoryAxis": {
//     "gridPosition": "start",
//     "position": "left",
//     "titleColor": "#565656",
//     "titleFontSize": 12,
//     "gridColor": "transparents",
//     "dashLength": 0,
//     "color": "#565656",
//     "fontSize": 9,
//     "axisColor": "transparents",
//     "axisThickness": 0,
//   },
//   "trendLines": [],
//   "graphs": [
//     {
//       "id": "AmGraph-1",
//       "balloonText": "Income:[[value]]",
//       "fillAlphas": 1,
//       "fillColors": "#ff6e40",
//       "lineAlpha": 0,
//       "lineThickness": 0,
//       "title": "Income",
//       "type": "column",
//       "valueField": "income"
//     }
//   ],
//   "guides": [],
//   "valueAxes": [
//     {
//       "id": "ValueAxis-1",
//       "titleColor": "#565656",
//       "titleFontSize": 12,
//       "gridColor": "transparents",
//       "dashLength": 0,
//       "color": "#565656",
//       "fontSize": 9,
//       "axisColor": "transparents",
//       "axisThickness": 0,
//     }
//   ],
//   "allLabels": [],
//   "balloon": {},
//   "titles": [],
//   "dataProvider": [
//     {
//       "year": 1999,
//       "income": 23.5
//     },
//     {
//       "year": 2000,
//       "income": 26.2
//     },
//     {
//       "year": 2001,
//       "income": 25
//     },
//     {
//       "year": 2002,
//       "income": 29.5
//     },
//     {
//       "year": 2003,
//       "income": 24.6
//     }
//   ],
//   "export": {
//     "enabled": true
//   }
// });

// var chart = AmCharts.makeChart("chart_area7",{
//   "type": "pie",
//   "startDuration": 1,
//   "titleField": "category",
//   "valueField": "column-1",
//   "showZeroSlices": true,
//   "groupedAlpha": 0,
//   "labelsEnabled": false,
//   "legend": {
//     "useGraphSettings": true,
//     "align": "center",
//     "fontSize": 9,
//     "markerLabelGap": 5,
//     "markerSize": 5,
//     "markerType": "circle",
//     "markerBorderThickness": 0,
//     "marginLeft": 0,
//     "marginRight": 0,
//     "showEntries":true,
//     "switchable": false,
//     "valueAlign": "left",
//   },
//   "dataProvider"  : [
//     {
//       "category": "category alpha",
//       "column-1": 8
//     },
//     {
//       "category": "category beta",
//       "column-1": 6
//     },
//     {
//       "category": "category gama",
//       "column-1": 2
//     }
//   ]
// });