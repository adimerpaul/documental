<template>
  <q-page >
    <q-card>
      <q-form @submit.prevent="consultar">
        <div class="row q-pa-md">
          <div class="col-4">
            <q-input outlined  type="date" label="Fecha inicio" v-model="fecha1" />
          </div>
          <div class="col-4">
            <q-input outlined  type="date" label="Fecha inicio" v-model="fecha2"/>
          </div>
          <div class="col-4 flex flex-center">
            <q-btn label="Consultar" icon="history" color="primary" type="submit"/>
          </div>
        </div>
      </q-form>
      <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>
    </q-card>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue';
import {date} from 'quasar'

export default defineComponent({
  name: 'PageIndex',
  data(){
    return {
      fecha1:date.formatDate(Date.now(),'YYYY-MM-DD'),
      fecha2:date.formatDate( Date.now(),'YYYY-MM-DD'),
      series: [{
        name: 'Registros',
        data: [1,1,1,1,1]
      }],
      chartOptions: {

        chart: {

          type: 'bar',
          height: 350
        },
        dataLabels: {
          enabled: true
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun'],
        },
        yaxis: {
          title: {
            text: 'Cantidad'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return " " + val + " "
            }
          }
        }
      }
    }
  },
  created() {
    // console.log(date.formatDate(Date.now(),'YYYY-MM-DD'))
    this.consultar()
  },
  methods:{
    consultar(){
      this.$q.loading.show()
      let fechas=[]
      let valores=[]
      this.$axios.post(process.env.API+'/consulta',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        res.data.forEach(r=>{
          fechas.push(r.fecha)
          valores.push(r.cantidad)
          // console.log(r)
          // this.$axios.post(process.env.API+'/detallesdia',{fecha:r}).then(res=>{
          //   console.log(res.data)
          // })
        })
        // console.log(valores)

        this.chartOptions={
          xaxis: {
            categories: fechas
          },
        }
        this.series= [{
          name: 'Registros por Dia',
          data: valores
        }],
        this.$q.loading.hide()
      })
    }
  }
})
</script>
