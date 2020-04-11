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
    </div>
</template>

<script>
export default {
    props: {
        sensor: { type: Object, default: null },
    },
    data: function () {
        return {
            chartOptions: {
                chart: {
                    type: "line",
                    height: 400,
                },
                toolbar: {
                    show: false,
                },
                markers: {
                    size: 1,
                },
                stroke: {
                    curve: "straight",
                },
                xaxis: {
                    type: "datetime",
                    range: 60000, // mantiene in memoria 10 secondi
                    tickPlacement: "between",
                    labels: {
                        format: "dd/MM/yy - HH:mm:ss",
                    },
                    title: {
                        text: "Tempo",
                    },
                },
                yaxis: {
                    min: 0,
                    title: {
                        text: "Valore",
                    },
                },
                legend: {
                    position: "top",
                    horizontalAlign: "right",
                    floating: true,
                    offsetY: -25,
                    offsetX: -5,
                },
                dataLabels: {
                    enabled: false,
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
            newDataSeries: [],
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
                    this.vars.newDataSeries.push([
                        response.data.time,
                        response.data.value,
                    ]);
                })
                .catch((errors) => {
                    this.vars.newDataSeries.push([Date.now(), NaN]);
                });
        },
        startInterval(timer) {
            return setInterval(() => {
                this.fetchData();
                this.series = [
                    {
                        data: this.vars.newDataSeries,
                    },
                ];
            }, timer);
        },
    },
};
</script>
