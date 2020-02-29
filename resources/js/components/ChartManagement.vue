<template>
    <div>
        <apexchart width="800" ref="RTChart" type="area" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>

<script>
    var date;
    var label;
    var newData;
    export default {
        props:  {
            user: Object,
            device: Object,
            sensor: Object,
        },
        data: function() {
            return {
                chartOptions: {
                    chart: {
                        type: 'line',
                        zoom: {
                            enabled: true
                        },
                        animations: {
                            enabled: false,
                        },
                    },
                    xaxis: {
                        categories: [''],
                    },
                },
                series: [{
                    name: this.$props.sensor.sensorId,
                    data: []
                }]
            }
        },
        mounted(){
            this.fetchData();
            this.startInterval();
        },
        methods: {
            startInterval() {
                setInterval(() => {
                    if(this.series[0].data.length >= 10){
                        this.removeData();
                    }
                    this.fetchData();
                    this.chartOptions.xaxis.categories.push(this.label);
                    this.$refs.RTChart.appendData([{
                            data: [this.newData]
                            }], false);

                }, 5000);
            },
            fetchData(){
                axios.get('/fetch/' + this.$props.user.id + '/' + this.$props.device.deviceId)
                .then( response =>{
                    let r = (response.data.sensorsList.find(sensor =>
                            sensor.sensorId ===this.$props.sensor.sensorId)
                    );
                    this.newData = Number(r.value);
                    this.date = new Date(Number(r.timestamp));
                    this.label = this.date.getHours() + " : " + this.date.getMinutes() + " : " + this.date.getSeconds();
                })
                .catch(errors => {
                    this.newData = NaN;
                });
            },
            removeData(){
                this.series[0].data.shift();
                this.chartOptions.xaxis.categories.shift();
            }
        }
    };
</script>
