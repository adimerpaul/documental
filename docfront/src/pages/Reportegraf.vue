<template>
  <q-page >
    <q-card>
    <div class="row">

    <div class="col-xs-12 col-md-4">
    <q-card dense class="my-card bg-primary text-white" >
      <q-card-section>
      <div class="row">
      <div class="col-10">
        <div class="text-h6">Numeros de Registros </div>
        <div class="text-subtitle2">by John Doe</div>
      </div>  
      <div class="col-2">
        <q-icon color="white" name="description" size="xl"/>      
      </div>
      </div>
       </q-card-section>
      </q-card>      
    </div>

    </div>
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
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <div style='text-align:center'> <b>N DE DOCUMENTOS REGISTRADOS</b></div>
          <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>
        </div>
        <div class="col-6">
          <div style='text-align:center'> <b>N DE DOCUMENTOS POR CATEGORIA</b></div>
          <apexchart type="donut" height="350" :options="chartOptions2" :series="seriecategoria"></apexchart>

        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <div style='text-align:center'> <b>N DE DOCUMENTOS POR SUB-CATEGORIA</b></div>
          <apexchart type="donut" height="350" :options="chartOptions3" :series="seriesubcategoria"></apexchart>

        </div>
        <div class="col-sm-12 col-md-6">
          <div style='text-align:center'> <b>N DE DOCUMENTOS PRESTADOS</b></div>
          <apexchart type="bar" height="350" :options="chartOptions4" :series="serieprestamo"></apexchart>

        </div>
      </div>
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
      seriecategoria: [{
        name: 'Registros',
        data: [1,1,1,1,1]
      }],
      colors: [
        "#33b2df",
        "#546E7A",
        "#d4526e",
        "#13d8aa",
        "#A5978B",
        "#2b908f",
        "#f9a3a4",
        "#90ee7e",
        "#f48024",
        "#69d2e7"
      ],
            seriesubcategoria: [{
        name: 'Registros',
        data: [1,1,1,1,1]
      }],
                serieprestamo: [{
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
      },
    chartOptions2: {
        dataLabels: {
          enabled: true
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        }
      },
      
      chartOptions3: {
        dataLabels: {
          enabled: true
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
      },
            chartOptions4: {
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
              colors: [
       
        "#546E7A",
        "#d4526e",
        "#13d8aa",
        "#A5978B",
        "#2b908f",
        "#f9a3a4",
        "#90ee7e",
        "#f48024",
        "#69d2e7"
      ],
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
    this.consultar2()
    this.consultar3()
    this.consultar4()
  },
  methods:{
      consultar(){
      let fechas=[]
      let valores=[]
      this.$axios.post(process.env.API+'/consulta',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        res.data.forEach(r=>{
          fechas.push(r.fecha)
          valores.push(r.cantidad)
        })
        this.chartOptions={
          xaxis: {
            categories: fechas
          },
        }
        this.series= [{
          name: 'Registros por Dia',
          data: valores
        }];
      });
    },
    consultar2(){
      this.$q.loading.show()
      let nombres=[]
      let valores=[]
      this.$axios.post(process.env.API+'/concategoria').then(res=>{
        console.log(res.data)
        res.data.forEach(r=>{
          nombres.push(r.nombre)
          valores.push(r.cantidad)
        })
        this.chartOptions2={
          labels: 
             nombres
          ,
        }
        this.seriecategoria= 
           valores
        ;
        this.$q.loading.hide()
      })
    },
        consultar3(){
      this.$q.loading.show()
      let nombres=[]
      let valores=[]
      this.$axios.post(process.env.API+'/consubcategoria').then(res=>{
        console.log(res.data)
        res.data.forEach(r=>{
          nombres.push(r.nombre)
          valores.push(r.cantidad)
        })
        this.chartOptions3={
          labels: nombres
          ,
        }
        this.seriesubcategoria=          valores
        ;
        this.$q.loading.hide()
      })
    },
            consultar4(){
      this.$q.loading.show()
      let fechas=[]
      let valores=[]
      this.$axios.post(process.env.API+'/conprestamo',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        res.data.forEach(r=>{
          fechas.push(r.fechaprestamo)
          valores.push(r.cantidad)
        })
        this.chartOptions4={
          xaxis: {
            categories: fechas
          },
        }
        this.serieprestamo= [{
          name: 'Registros por Dia',
          data: valores
        }];
        this.$q.loading.hide()
      })
    },

  }
})
</script>
