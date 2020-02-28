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
                        categories: [],
                    },
                },
                series: [{
                    name: this.$props.sensor.nome,
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
                    this.$refs.RTChart.appendData([{
                            data: [this.newData]
                            }], false);

                    this.chartOptions.xaxis.categories.push(this.label);
                }, 1000);
            },
            fetchData(){
                axios.post('/fetch/' + this.$props.user.id + '/' + this.$props.device.nome)
                .then( response =>{
                    this.newData = Number((response.data.sensori.find(sensore =>
                        sensore.nome ===this.$props.sensor.nome)
                    ).dato);
                    this.date = new Date(Date.now());
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
