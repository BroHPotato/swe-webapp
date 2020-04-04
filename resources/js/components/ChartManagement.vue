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
            type="area"
            height="400"
            :options="chartOptions"
            :series="series"
        ></apexchart>
    </div>
</template>

<script>
// let date;
// let label;
// let newData;
export default {
    props: {
        deviceId: Number,
        sensorId1: Number,
        sensorId2: Number,
    },
    data: function() {
        return {
            chartOptions: {
                chart: {
                    height: 400,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'datetime',
                    categories: []
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
            },
            series: [{
                name: this.$props.sensorId1,
                data: [],
            },{
                name: this.$props.sensorId2,
                data: [],
            }],
        }
    },
    mounted() {
        this.fetchData();
        pull = this.startInterval(4000);
    },
    methods: {
        startInterval(timer) {
            return setInterval(() => {
                if (this.series[0].data.length >= 10) {
                    this.removeData();
                }
                this.fetchData();
                this.chartOptions.xaxis.categories.push(this.label);
                this.$refs.RTChart.appendData(
                    [
                        {
                            data: [this.newData],
                        },
                    ],
                    false
                );
            }, timer);
        },
        changePullrate(timer) {
            clearInterval(pull);
            pull = this.startInterval(timer.target.value);
        },
        fetchData() {
            axios
                .get(
                    "/data/devices/" +
                        this.$props.deviceId +
                        "/sensors/" +
                        this.$props.sensorId1
                )
                .then((response) => {
                    const r = response.data;
                    this.newData = Number(r.value);
                    this.date = new Date(Number(r.timestamp));
                    this.label =
                        this.date.getHours() +
                        " : " +
                        this.date.getMinutes() +
                        " : " +
                        this.date.getSeconds();
                })
                .catch((errors) => {
                    this.newData = NaN;
                });
        },
        removeData() {
            this.series[0].data.shift();
            this.chartOptions.xaxis.categories.shift();
        },
    },
}
</script>
