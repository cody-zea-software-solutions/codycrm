

$(function () {


  // =====================================
  // Number Of Sales
  // =====================================

      // AJAX request to fetch data from PHP script
      $.ajax({
        url: 'invoice-data.php',
        method: 'GET',
        success: function (data) {
            try {
                // Update the options object with the fetched data
                var options = {
                  series: [{
                      name: 'Sales',
                      data: Object.values(data) // Use sales counts directly from data object
                  }],
                  chart: {
                      type: 'bar',
                      height: 350
                  },
                  plotOptions: {
                      bar: {
                          horizontal: false,
                          columnWidth: '12%',
                          endingShape: 'rounded',
                          fill: {
                              colors: ['#e65b1b'] // Change color here
                          }
                      },
                  },
                  dataLabels: {
                      enabled: false
                  },
                  stroke: {
                      show: true,
                      width: 2,
                      colors: ['transparent']
                  },
                  xaxis: {
                      categories: Object.keys(data), // Use month-year strings as categories
                  },
                  yaxis: {
                      title: {
                          text: 'Number of Sales'
                      }
                  },
                  fill: {
                      opacity: 1
                  },
                  tooltip: {
                      y: {
                          formatter: function (val) {
                              return val;
                          }
                      }
                  }
              };
              

                // Render the chart with updated options
                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });


  // =====================================
  // Breakup
  // =====================================
  var breakup = {
    color: "#adb5bd",
    series: [38, 40, 25],
    labels: ["2022", "2021", "2020"],
    chart: {
      width: 180,
      type: "donut",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    plotOptions: {
      pie: {
        startAngle: 0,
        endAngle: 360,
        donut: {
          size: '75%',
        },
      },
    },
    stroke: {
      show: false,
    },

    dataLabels: {
      enabled: false,
    },

    legend: {
      show: false,
    },
    colors: ["#E6822D", "#EC9D5A", "#FBBE8B"],

    responsive: [
      {
        breakpoint: 991,
        
        options: {
          chart: {
            width: 150,
          },
        },
      },
    ],
    tooltip: {
      theme: "dark",
      fillSeriesColor: false,
    },
  };

  var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
  chart.render();



  // =====================================
  // Earning
  // =====================================
  var earning = {
    chart: {
      id: "sparkline3",
      type: "area",
      height: 60,
      sparkline: {
        enabled: true,
      },
      group: "sparklines",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#adb0bb",
    },
    series: [
      {
        name: "Earnings",
        color: "#FBBE8B",
        data: [25, 66, 20, 40, 12, 58, 20],
      },
    ],
    stroke: {
      curve: "smooth",
      width: 2,
    },
    fill: {
      colors: ["#f3feff"],
      type: "solid",
      opacity: 0.05,
    },

    markers: {
      size: 0,
    },
    tooltip: {
      theme: "dark",
      fixed: {
        enabled: true,
        position: "right",
      },
      x: {
        show: false,
      },
    },
  };
  new ApexCharts(document.querySelector("#earning"), earning).render();
})