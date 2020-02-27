<template>
    <div>
        <apexchart width="800" ref="RTChart" type="area" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>

<script>
    let date = new Date(Date.now());
    let label = date.getHours() + " : " + date.getMinutes() + " : " + date.getSeconds();
    let newData;
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
                        categories: [this.label],
                    },
                },
                series: [{
                    name: this.$props.sensor.nome,
                    data: []
                }]
            }
        },
        mounted(){
          this.startInterval();
        },
        methods: {
            startInterval() {
                setInterval(() => {
                    if(this.series[0].data.length >= 10){
                        this.series[0].data.shift();
                        this.chartOptions.xaxis.categories.shift();
                    }
                    this.fetch_data();
                    console.log(this.newData);
                    this.$refs.RTChart.appendData([{
                            data: [this.newData]
                            }], false);
                    this.date = new Date(Date.now());
                    this.label = this.date.getHours() + " : " + this.date.getMinutes() + " : " + this.date.getSeconds();
                    this.chartOptions.xaxis.categories.push(this.label);
                }, 1000);
            },
            fetch_data(){
                var toreturn;
                axios.post('/fetch/' + this.$props.user.id + '/' + this.$props.device.nome)
                .then( response =>{
                    this.newData = Number((response.data.sensori.find(sensore =>
                        sensore.nome ===this.$props.sensor.nome)
                    ).dato);
                })
                .catch(errors => {
                    this.newData = NaN;
                });

            }
        }
    };
</script>
