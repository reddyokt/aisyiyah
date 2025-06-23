
// function getChartColorsArray(chartId) {
//   if (document.getElementById(chartId) !== null) {
//     var colors = document.getElementById(chartId).getAttribute("data-colors");

//     if (colors) {
//       colors = JSON.parse(colors);
//       return colors.map(function (value) {
//         var newValue = value.replace(" ", "");

//         if (newValue.indexOf(",") === -1) {
//           var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
//           if (color) return color; else return newValue;
//           ;
//         } else {
//           var val = value.split(',');

//           if (val.length == 2) {
//             var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
//             rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
//             return rgbaColor;
//           } else {
//             return newValue;
//           }
//         }
//       });
//     }
//   }
// } //
// // Total Revenue Chart
// //

// // Kader Chart
// const totalPda = $(".totalPDA").val();
// const pdaList = $(".pdaList").val();
// const valTotalPda = Object.values(JSON.parse(totalPda));
// const valPdaList = JSON.parse(pdaList);
// var roleCode = $('#roleCode').val();
// var LinechartsalesColors = getChartColorsArray("kader_chart");

// if (LinechartsalesColors && (roleCode == 'SUP' || roleCode == 'PWA1')) {
//   var options = {
//     chart: {
//       height: 343,
//       type: 'line',
//       stacked: false,
//       toolbar: {
//         show: false
//       }
//     },
//     stroke: {
//       width: [0, 2, 4],
//       curve: 'smooth'
//     },
//     plotOptions: {
//       bar: {
//         columnWidth: '30%'
//       }
//     },
//     colors: LinechartsalesColors,
//     series: [{
//       name: 'Kader',
//       type: 'column',
//       data: valTotalPda
//     }],
//     fill: {
//       opacity: [0.85, 0.25, 1],
//       gradient: {
//         inverseColors: false,
//         shade: 'light',
//         type: "vertical",
//         opacityFrom: 0.85,
//         opacityTo: 0.55,
//         stops: [0, 100, 100, 100]
//       }
//     },
//     xaxis: {
//       type: 'text',
//       categories: valPdaList,
//     },
//     yaxis: {
//       title: {
//         text: 'Jumlah Kader'
//       }
//     },
//     tooltip: {
//       shared: true,
//       intersect: false,
//       y: {
//         formatter: function formatter(y) {
//           if (typeof y !== "undefined") {
//             return y.toFixed(0) + " orang";
//           }

//           return y;
//         }
//       }
//     },
//     grid: {
//       borderColor: '#f1f1f1'
//     }
//   };
//   var chart = new ApexCharts(document.querySelector("#kader_chart"), options);
//   chart.render();
// }


// // AUM Chart
// const totalAum = $(".totalPDAAum").val();
// const pdaLists = $(".pdaLists").val();
// const valTotalAum = Object.values(JSON.parse(totalAum));
// const valPdaLists = JSON.parse(pdaLists);
// var roleCode = $('#roleCodes').val();
// var LinechartsalesColors = getChartColorsArray("aum_chart");

// if (LinechartsalesColors && (roleCode == 'SUP' || roleCode == 'PWA1')) {
//   var options = {
//     chart: {
//       height: 343,
//       type: 'line',
//       stacked: false,
//       toolbar: {
//         show: false
//       }
//     },
//     stroke: {
//       width: [0, 2, 4],
//       curve: 'smooth'
//     },
//     plotOptions: {
//       bar: {
//         columnWidth: '30%'
//       }
//     },
//     colors: LinechartsalesColors,
//     series: [{
//       name: 'AUM',
//       type: 'column',
//       data: valTotalAum
//     }],
//     fill: {
//       opacity: [0.85, 0.25, 1],
//       gradient: {
//         inverseColors: false,
//         shade: 'light',
//         type: "vertical",
//         opacityFrom: 0.85,
//         opacityTo: 0.55,
//         stops: [0, 100, 100, 100]
//       }
//     },
//     xaxis: {
//       type: 'text',
//       categories: valPdaLists,
//     },
//     yaxis: {
//       title: {
//         text: 'Jumlah AUM'
//       }
//     },
//     tooltip: {
//       shared: true,
//       intersect: false,
//       y: {
//         formatter: function formatter(y) {
//           if (typeof y !== "undefined") {
//             return y.toFixed(0) + " AUM";
//           }

//           return y;
//         }
//       }
//     },
//     grid: {
//       borderColor: '#f1f1f1'
//     }
//   };
//   var chart = new ApexCharts(document.querySelector("#aum_chart"), options);
//   chart.render();
// }


// var PiechartPieColors = getChartColorsArray("pie_chart");

// const prokerData = $(".prokerData").val();
// const valProkerData = Object.values(JSON.parse(prokerData));

// if (PiechartPieColors) {
//   var options = {
//     chart: {
//       height: 320,
//       type: 'pie'
//     },
//     series: valProkerData,
//     labels: ["Terealisasi", "Tidak Terealisasi", 'On Progress'],
//     colors: PiechartPieColors,
//     legend: {
//       show: true,
//       position: 'bottom',
//       horizontalAlign: 'center',
//       verticalAlign: 'middle',
//       floating: false,
//       fontSize: '14px',
//       offsetX: 0
//     },
//     responsive: [{
//       breakpoint: 600,
//       options: {
//         chart: {
//           height: 240
//         },
//         legend: {
//           show: false
//         }
//       }
//     }]
//   };
//   var chart = new ApexCharts(document.querySelector("#pie_chart"), options);
//   chart.render();
// }

// var BarchartColumnColors = getChartColorsArray("column_chart");

// if (BarchartColumnColors) {
//   var options = {
//     chart: {
//       height: 350,
//       type: 'bar',
//       toolbar: {
//         show: false
//       }
//     },
//     plotOptions: {
//       bar: {
//         horizontal: false,
//         columnWidth: '45%',
//         endingShape: 'rounded'
//       }
//     },
//     dataLabels: {
//       enabled: false
//     },
//     stroke: {
//       show: true,
//       width: 2,
//       colors: ['transparent']
//     },
//     series: [{
//       name: 'Net Profit',
//       data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
//     }, {
//       name: 'Revenue',
//       data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
//     }, {
//       name: 'Free Cash Flow',
//       data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
//     }],
//     colors: BarchartColumnColors,
//     xaxis: {
//       categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct']
//     },
//     yaxis: {
//       title: {
//         text: '$ (thousands)'
//       }
//     },
//     grid: {
//       borderColor: '#f1f1f1'
//     },
//     fill: {
//       opacity: 1
//     },
//     tooltip: {
//       y: {
//         formatter: function formatter(val) {
//           return "$ " + val + " thousands";
//         }
//       }
//     }
//   };
//   var chart = new ApexCharts(document.querySelector("#column_chart"), options);
//   chart.render();
// }


// // AUM Chart
const totalAum = $(".totalPDAAum").val();
const pdaLists = $(".pdaLists").val();
const valTotalAum = Object.values(JSON.parse(totalAum));
const valPdaLists = JSON.parse(pdaLists);

	var optionsPda = {
		chart: {
			type: 'bar',
		},
    plotOptions: { 
      bar: { 
        horizontal: false, 
        borderRadius: 10, 
        columnWidth: '30%', 
      }
    }, 
		series: [{
			name: labelPdaLists,
			data: valTotalAum
		}],
		xaxis: {
			categories: valPdaLists
		},
		yaxis: {
			labels: {
			formatter: (value) => {
				return value.toFixed(0)
			},
			}
		},
	};
	var chartPda = new ApexCharts(document.querySelector("#aum_chart"), optionsPda);
	chartPda.render();


const totalPda = $(".totalPDA").val();
const pdaList = $(".pdaList").val();
const valTotalPda = Object.values(JSON.parse(totalPda));
const valPdaList = JSON.parse(pdaList);

	var optionsPda = {
		chart: {
			type: 'bar',
		},
		series: [{
			name: labelPdaList,
			data: valTotalPda
		}],
		xaxis: {
			categories: valPdaList
		},
		yaxis: {
			labels: {
			formatter: (value) => {
				return value.toFixed(0)
			},
			}
		},
	};
	var chartPda = new ApexCharts(document.querySelector("#kader_chart"), optionsPda);
	chartPda.render();


const prokerData = $(".prokerData").val();
const valProkerData = Object.values(JSON.parse(prokerData));
var optionsPie = {
	series: valProkerData,
	chart: {
		width: 380,
		type: 'pie',
	},
  	labels: [labelTerealisasi, labelTidak, labelProgress],
  	responsive: [{
    	breakpoint: 480,
    	options: {
     	 	chart: {
        		width: 200
      		},
      		legend: {
        		position: 'bottom'
      		}
    	}
  	}],
    colors:["#1abc9c", "#fc0a0a", "#f0b630"]
};
var chartPie = new ApexCharts(document.querySelector("#pie_chart"), optionsPie);
chartPie.render();
