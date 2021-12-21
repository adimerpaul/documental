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
      <div class="row">
            <q-btn color="secondary" label="Documentos Registrados" @click="consultar"/>
            <q-btn color="amber" glossy label="Documentos Categoria" />
            <q-btn color="brown-5" label="Documentos Prestados" />
            <!--<q-btn color="deep-orange" glossy label="Deep Orange" />
             <q-btn color="purple" label="Purple" />-->
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
      numdoc:0,
      numpres:0,
      numdev:0,

    }
  },
  created() {
    // console.log(date.formatDate(Date.now(),'YYYY-MM-DD'))
  },
  methods:{

      consultar(){
      this.$axios.post(process.env.API+'/reporte',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        console.log(res.data)
        let myWindow = window.open("", "Imprimir", "width=200,height=100");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        setTimeout(function(){
          myWindow.print();
          myWindow.close();
        },500);
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
