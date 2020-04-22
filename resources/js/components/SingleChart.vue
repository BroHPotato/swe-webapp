<template>
    <div>
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
        const now = Date.now();
        const temp = [];
        for (let i = 0; i < 20; i++) {
            temp.push([
                new Date(now - (20 - i) * 3000).toISOString(),
                Math.floor(Math.random() * 11),
            ]);
        }
        this.vars = {
            newDataSeries: temp,
        };
    },
    mounted() {
        this.fetchData();
        this.startInterval(3000);
    },
    methods: {
        fetchData() {
            axios
                .get("/data/" + this.sensor.sensorId)
                .then((response) => {
                    this.vars.newDataSeries.push([
                        new Date(response.data.time).toISOString(),
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
