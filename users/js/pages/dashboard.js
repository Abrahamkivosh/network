

// Get the canvas element and its context
const liveBandwidthChartCanvas = document.getElementById(
  "liveBandwidthUsageChart"
);
const ctx = liveBandwidthChartCanvas.getContext("2d");

// Create initial data arrays for download and upload
const initialData = {
  download: [],
  upload: [],
};

// Configure the chart options

// Configure the chart options
const chartOptions = {
  type: "line",
  data: {
    labels: [],
    datasets: [
      {
        label: "Download",
        data: initialData.download,
        borderColor: "lightgreen",
        backgroundColor: "rgba(144, 238, 144, 0.2)",
        fill: true,
        lineTension: 0,
        pointRadius: 3,
        pointHoverRadius: 5,
        pointHitRadius: 10,
      },
      {
        label: "Upload",
            borderColor: "lightcoral",
        backgroundColor: "rgba(240, 128, 128, 0.2)",
        fill: true,
        data: initialData.upload,
        lineTension: 0,
        pointRadius: 3,
        pointHoverRadius: 5,
        pointHitRadius: 10,
        
      },
    ],

    options: {
        responsive: true,
        maintainAspectRatio: false,

        layout: {
            padding: 0,
        },

       
      },
   

  },
};

// Create the chart
const liveBandwidthChart = new Chart(ctx, chartOptions);


// update chart
function updateChart(downloadValue, uploadValue) {
    const currentTime = new Date().toLocaleTimeString();

  // Update the chart data
  liveBandwidthChart.data.datasets[0].data = downloadValue;
  liveBandwidthChart.data.datasets[1].data = uploadValue;
    liveBandwidthChart.data.labels.push(currentTime);

  
    // / Limit the number of data points to keep the chart clean 
    const maxDataPoints = 10;
    if (liveBandwidthChart.data.labels.length > maxDataPoints) {
      liveBandwidthChart.data.labels.shift();
      liveBandwidthChart.data.datasets[0].data.shift();
      liveBandwidthChart.data.datasets[1].data.shift();
    }

  // Update the chart
  liveBandwidthChart.update();
}

// Call the updateChart function every 5 seconds
setInterval(function () {
   
    while (initialData.download.length < 10) {
        const randomDownloadValue = Math.abs(Math.random() * 100) ; // Replace with your download data
        const randomUploadValue = Math.abs(Math.random() * 100) ; // Replace with your upload data

        initialData.download.push(randomDownloadValue);
        initialData.upload.push(randomUploadValue);
    }
    updateChart(initialData.download, initialData.upload);
}
, 1000);



