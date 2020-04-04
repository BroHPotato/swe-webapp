<template>
    <div>
        <select class="custom-select" @change="changePullrate($event)">
            <option value="4000" selected>4s</option>
            <option value="3000">3s</option>
            <option value="2000">2s</option>
            <option value="1000">1s</option>
            <option value="500">0.5s</option>
        </select>
        <apexchart ref="RTChart" height="400" type="area" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>

<script>
    export default {
        props: [ 'sensor1', 'sensor2'],
        data: function() {
            return {
                chartOptions: {
                    chart: {
                        type: 'area',
                        height: 400,
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        size: 0,
                        style: 'hollow',
                    },
                    tooltip: {
                        intersect: true,
                        shared: false
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.9,
                            stops: [0, 100]
                        }
                    },
                    xaxis: {
                        type: "datetime",
                        labels: {
                            datetimeFormatter: {
                                year: 'yyyy',
                                month: 'MMM \'yy',
                                day: 'dd MMM',
                                hour: 'HH:mm'
                            }
                        }
                    },
                },
                series: [{
                    name: this.sensor1.type,
                    data: [[],[],[],[],[],[],[],[],[],[]]
                },{
                    name: this.sensor2.type,
                    data: [[],[],[],[],[],[],[],[],[],[]]
                }],
            }
        },
        created() {
            this.vars = {
                pull:null,
                newDataSeries1: null,
                newDataSeries2: null,
            };
        },
        mounted() {
            this.fetchData();
            this.vars.pull = this.startInterval(4000);
        },
        methods: {
            changePullrate(timer) {
                clearInterval(this.pull);
                this.pull = this.startInterval(timer.target.value);
            },
            removeData() {
                this.series[0].data.shift();
                this.series[1].data.shift();
                //this.chartOptions.xaxis.categories.shift();
            },
            fetchData() {
                axios.get(
                    "/data/" +
                    this.sensor1.sensorId
                ).then((response) => {
                    this.vars.newDataSeries1= [Date.now(), response.data.value];
                }).catch((errors) => {
                    this.vars.newDataSeries1 = [Date.now(), NaN];
                });
                axios.get(
                    "/data/" +
                    this.sensor2.sensorId
                ).then((response) => {
                    this.vars.newDataSeries2= [Date.now(), response.data.value];
                }).catch((errors) => {
                    this.vars.newDataSeries2 = [Date.now(), NaN];
                });
            },
            startInterval(timer) {
                return setInterval(() => this.plot(), timer);
            },
            plot(){
                this.removeData();
                this.fetchData();
                this.$refs.RTChart.appendData(
                    [{
                        data: [this.vars.newDataSeries1],
                    }, {
                        data: [this.vars.newDataSeries2],
                    }],
                    false
                );
                console.log(this.series[0].data)
            }

        },
    }
</script>
