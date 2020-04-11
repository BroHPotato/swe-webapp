<template>
    <div>
        <apexchart
            ref="RTChart"
            height="400"
            type="line"
            :options="chartOptions"
            :series="series"
        >
        </apexchart>
        <div ref="variance"></div>
    </div>
</template>

<script>
import covariance from "@elstats/covariance";
import Pearson from "correlation-rank";
import Spearman from "spearman-rho";
export default {
    props: {
        sensor1: { type: Object, default: null },
        sensor2: { type: Object, default: null },
        variance: { type: Number, default: 0 },
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
                    // logarithmic: true,
                    title: {
                        text: "Valore",
                    },
                    forceNiceScale: true,
                },
                dataLabels: {
                    enabled: false,
                },
            },
            series: [
                {
                    name: this.sensor1.type,
                    data: [],
                },
                {
                    name: this.sensor2.type,
                    data: [],
                },
            ],
        };
    },
    created() {
        this.vars = {
            newDataSeries1: [],
            newDataSeries2: [],
            data1: [],
            data2: [],
        };
    },
    mounted() {
        this.fetchData();
        this.startInterval(3000);
    },
    methods: {
        fetchData() {
            axios
                .get("/data/" + this.sensor1.sensorId)
                .then((response) => {
                    this.vars.newDataSeries1.push([
                        new Date(response.data.time).toISOString(),
                        response.data.value,
                    ]);
                    this.vars.data1.push(response.data.value);
                })
                .catch((errors) => {
                    this.vars.newDataSeries1 = [
                        new Date(Date.now()).toISOString(),
                        NaN,
                    ];
                });
            axios
                .get("/data/" + this.sensor2.sensorId)
                .then((response) => {
                    this.vars.newDataSeries2.push([
                        new Date(response.data.time).toISOString(),
                        response.data.value,
                    ]);
                    this.vars.data2.push(response.data.value);
                })
                .catch((errors) => {
                    this.vars.newDataSeries2 = [
                        new Date(Date.now()).toISOString(),
                        NaN,
                    ];
                });
        },
        startInterval(timer) {
            return setInterval(() => {
                this.fetchData();
                this.calculateVariance();
                this.series = [
                    {
                        data: this.vars.newDataSeries1,
                    },
                    {
                        data: this.vars.newDataSeries2,
                    },
                ];
            }, timer);
        },
        calculateVariance() {
            const variance = [
                "Nessuna",
                "Covarianza",
                "Correlazione di Pearson",
                "Correlazione di Spearman",
            ];
            let calc = NaN;
            switch (this.variance) {
                case 1:
                    calc = covariance(this.vars.data1, this.vars.data2);
                    break;
                case 2:
                    calc = Pearson.rank(this.vars.data1, this.vars.data2);
                    break;
                case 3:
                    new Spearman(this.vars.data1, this.vars.data2)
                        .calc()
                        .then((value) => {
                            calc = value;
                            this.$refs.variance.innerHTML =
                                variance[this.variance] +
                                " : " +
                                calc.toFixed(3);
                        });
                    break;
                default:
                    calc = NaN;
                    break;
            }
            if (!isNaN(calc)) {
                this.$refs.variance.innerHTML =
                    variance[this.variance] + " : " + calc.toFixed(3);
            }
        },
    },
};
</script>
