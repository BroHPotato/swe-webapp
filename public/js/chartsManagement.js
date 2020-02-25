//add data to the chart
function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
}
//remove data from the chart
function removeData(chart) {
    chart.data.labels.shift();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.shift();
    });
}
//fetches and update the chart
function update_data(myChart){
    var data = fetch_data();
    date = new Date(Date.now());
    label = date.getHours() + " : " + date.getMinutes() + " : " + date.getSeconds();
    if (myChart.data.labels.length>5) {
        removeData(myChart);
    }
    addData(myChart, label, data);
    myChart.update(0);
}
//support function (call to API)
function fetch_data() {
    return (Math.random() * 10);
}
