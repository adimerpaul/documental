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

        </div>
      </q-form>
      <div class="row">
            <q-btn color="secondary" label="Documentos Registrados" @click="consultar"/>
            <q-btn color="amber" glossy label="Documentos Categoria" @click="consultar2"/>
            <q-btn color="brown-5" label="Documentos Prestados" @click="consultar3"/>
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
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
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
      this.$axios.post(process.env.API+'/repcategoria',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        setTimeout(function(){
          myWindow.print();
          myWindow.close();
        },500);
      });
    },
        consultar3(){
      this.$axios.post(process.env.API+'/repprestamo',{fecha1:this.fecha1,fecha2:this.fecha2}).then(res=>{
        let myWindow = window.open("", "Imprimir", "width=1000,height=1000");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        setTimeout(function(){
          myWindow.print();
          myWindow.close();
        },500);
      });
    },


  }
})
</script>
