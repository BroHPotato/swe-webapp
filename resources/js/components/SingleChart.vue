<template>
    <div>
        <select class="custom-select" @change="changePullrate($event)">
            <option value="4000" selected>4s</option>
            <option value="3000">3s</option>
            <option value="2000">2s</option>
            <option value="1000">1s</option>
            <option value="500">0.5s</option>
        </select>
        <apexchart
            ref="RTChart"
            height="300"
            type="line"
            :options="chartOptions"
            :series="series"
        >
        </apexchart>
        <apexchart
            ref="RTChartLine"
            height="130"
            type="area"
            :options="chartOptionsLine"
            :series="series"
        >
        </apexchart>
    </div>
</template>

<script>
    export default {
        props: ["sensor"],
        data: function () {
            return {
                chartOptions: {
                    chart: {
                        type: "line",
                        height: 400,
                    },
                    stroke: {
                        curve: "straight",
                    },
                    xaxis: {
                        type: 'datetime',
                        range: 10000, // mantiene in memoria 10 secondi
                        tickPlacement: 'between',
                    },
                    yaxis: {
                        min: 0,
                    },
                },
                chartOptionsLine: {
                    chart: {
                        type: "area",
                        height: 200,
                    },
                    stroke: {
                        curve: "straight",
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    xaxis: {
                        type: 'datetime',
                        tickPlacement: 'between',
                    },
                    yaxis: {
                        min: 0,
                        tickAmount: 3,
                    },
                },
                series: [
                    {
                        name: this.sensor.type,
                        data: [],
                    },
                ],
            };
        },
        created() {
            this.vars = {
                pull: null,
                newDataSeries: null,
                newLabel: null,
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
            fetchData() {
                axios
                    .get("/data/" + this.sensor.sensorId)
                    .then((response) => {
                        this.vars.newDataSeries = [
                            Date.now(),
                            response.data.value,
                        ];
                    })
                    .catch((errors) => {
                        this.vars.newDataSeries = [Date.now(), NaN];
                    });
            },
            startInterval(timer) {
                return setInterval(() => this.plot(), timer);
            },
            plot() {
                this.fetchData();
                this.$refs.RTChart.appendData(
                    [
                        {
                            data: [this.vars.newDataSeries],
                        },
                    ],
                    false
                );
                this.$refs.RTChartLine.appendData(
                    [
                        {
                            data: [this.vars.newDataSeries],
                        },
                    ],
                    false
                );
                console.log(this.series[0].data);
            },
        },
    };
</script>
