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
            height="400"
            type="line"
            :options="chartOptions"
            :series="series"
        >
        </apexchart>
    </div>
</template>

<script>
import covariance from '@elstats/covariance';
import pearson from 'correlation-rank';
import spearman from 'spearman-rho';
export default {
    props: ["sensor1", "sensor2", "variance"],
    data: function () {
        let variance = ['Nessuna','Covarianza', 'Correlazione di Pearson', 'Correlazione di Spearman'];
        return {
            chartOptions: {
                chart: {
                    type: "line",
                    height: 400,
                },
                toolbar: {
                    show: false
                },
                markers: {
                    size: 1
                },
                stroke: {
                    curve: "straight",
                },
                xaxis: {
                    type: 'datetime',
                    range: 60000, // mantiene in memoria 10 secondi
                    tickPlacement: 'between',
                    labels: {
                        format: 'dd/MM/yy - HH:mm:ss',
                    },
                    title: {
                        text: 'Tempo'
                    },
                },
                yaxis: {
                    //logarithmic: true,
                    title: {
                        text: 'Valore'
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
                },{
                    name: variance[this.variance],
                    data: [],
                },
            ],
        };
    },
    created() {
        this.vars = {
            pull: null,
            newDataSeries1: [],
            newDataSeries2: [],
            newDataVariance: [],
            data1:[],
            data2:[],
            date:null,
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
                .get("/data/" + this.sensor1.sensorId)
                .then((response) => {
                    this.vars.newDataSeries1.push([
                        new Date(response.data.time).toISOString(),
                        response.data.value,
                    ]);
                    this.vars.data1.push(response.data.value);
                })
                .catch((errors) => {
                    this.vars.newDataSeries1 = [new Date(Date.now()).toISOString(), NaN];
                });
            axios
                .get("/data/" + this.sensor2.sensorId)
                .then((response) => {
                    this.vars.newDataSeries2.push([
                        new Date(response.data.time).toISOString(),
                        response.data.value,
                    ]);
                    this.vars.data2.push(response.data.value);
                    this.vars.date=new Date(response.data.time).toISOString();
                })
                .catch((errors) => {
                    this.vars.newDataSeries2 = [new Date(Date.now()).toISOString(), NaN];
                });
        },
        startInterval(timer) {
            return setInterval(() => {
                this.fetchData();
                this.calculateVariance();
                this.series = [{
                    data: this.vars.newDataSeries1
                }, {
                    data: this.vars.newDataSeries2,
                },{
                    data: this.vars.newDataVariance,
                }];
            }, timer);
        },
        calculateVariance(){
            let calc = NaN;
            switch (this.variance) {
                case 1:
                    calc = this.vars.date, covariance(this.vars.data1, this.vars.data2);
                    break;
                case 2:
                    calc = pearson.rank(this.vars.data1, this.vars.data2);
                    break;
                case 3:
                    (new spearman(this.vars.data1, this.vars.data2)).calc().then(value => {
                        calc=value;
                    });
                    break;
                default:
                    calc=NaN;
                    break;
            }
            if (!isNaN(calc)){
                this.vars.newDataVariance.push([this.vars.date, calc.toFixed(3)]);
            }
        }
    },
};
</script>
