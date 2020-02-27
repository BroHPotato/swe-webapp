<script>
    import { Line, mixins } from 'vue-chartjs'
    const { reactiveProp } = mixins
    export default {
        extends: Line,
        mixins: [mixins, reactiveProp],
        props:['options'],
        mounted(){
            this.renderChart(this.chartData, this.options);
        }
    }
</script>
