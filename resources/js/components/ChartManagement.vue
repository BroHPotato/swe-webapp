<template>
    <chart-component
        v-bind:width=1000
        v-bind:height=300
        v-bind:chartData="datacollection"
    ></chart-component>
</template>

<script>
    import ChartComponent from "./ChartComponent";
    export default {
        props:  {
            user: Object,
            device: Object,
            sensor: Object,
        },
        data () {
            return {
                datacollection: null
            }
        },
        components: {
            ChartComponent
        },
        mounted() {
            console.log(this)
            this.startInterval()
        },
        methods: {
            startInterval: function () {
                setInterval(() => {
                    this.fillData()
                }, 1000);
            },
            fillData () {
                var temp =[1];
                console.log(this.$set(this, 'datacollection', this.change_data()));
                console.log(this.datacollection);
            },
            change_data(){
              return {
                  datasets: [
                      {
                          data: [this.datacollection.datasets,this.fetch_data()]
                      }
                  ]
              }
            },
            fetch_data(){
                return Math.random(0,10);
            }
        }
    }
</script>
