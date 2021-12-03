<template>
<q-page>
  <div class="row">
    <div class="col-12">
      <q-table
        title="Documentos "
        :rows="data"
        :columns="columns"
        :filter="filter"
        row-key="name"
        :rows-per-page-options="[50,100,200,0]"
      >
        <template v-slot:top-right>
          <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-archivo="props">
          <q-td key="archivo" :props="props">
<!--            <a :href="url+'/../imagenes/'+props.row.archivo" target="_blank">{{props.row.archivo}}</a>-->
            {{props.row.archivo}}
          </q-td>
        </template>
        <template v-slot:body-cell-opcion="props">
          <q-td key="opcion" :props="props">
            <q-btn-group>
              <q-btn dense round flat color="positive" @click="solicitar(props.row.id)" icon="check_circle" label="solicitar"></q-btn>
            </q-btn-group>
          </q-td>
        </template>

      </q-table>
    </div>
  </div>
</q-page>
</template>
<script>
import {date} from "quasar";

export default {
  data(){
    return{
      data:[],
      filter:'',
      utl:process.env.API,
      columns: [
        // {name: 'fondo', label: 'Fondo', align: 'left', field: row=>row.fondo, sortable: true},
        {name: 'archivo', label: 'Archivo', align: 'left', field: 'archivo', sortable: true},
        // { name: 'gestion', align: 'center', label: 'Gestion', field: 'gestion', sortable: true },
        // { name: 'tomo', align: 'center', label: 'tomo', field: 'tomo', sortable: true },
        // { name: 'numtotal', align: 'center', label: 'numtotal', field: 'numtotal', sortable: true },
        // { name: 'detalle', align: 'center', label: 'detalle', field: 'detalle', sortable: true },
        // { name: 'estado', align: 'center', label: 'estado', field: 'estado', sortable: true },
        { name: 'categoria', align: 'center', label: 'categoria', field: row=>row.categoria.nombre, sortable: true },
        { name: 'subcategoria', align: 'center', label: 'subcategoria', field: row=>row.subcategoria.nombre, sortable: true },
        { name: 'opcion', label: 'Opcion', field:'opcion'}

      ],
    }
  },
  created() {
    this.misdatos()
  },
  methods:{
    solicitar(documento_id){
      // console.log(documento_id)
      this.$q.loading.show();
      this.$axios.post(process.env.API+'/prestamo',{documento_id}).then(res=>{
        // this.data=res.data;
        // console.log(res.data)
        this.$q.loading.hide();
        this.$q.notify({
          message:'Solicitud enviada',
          color:'green',
          icon:'done'
        })
      }).catch(error=>{
        this.$q.loading.hide();
        this.$q.notify({
          message:error.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    },
    misdatos(){
      this.$q.loading.show();
      this.$axios.get(process.env.API+'/documento').then(res=>{
        this.data=res.data;
        // console.log(this.data)
        this.$q.loading.hide();
      })
    },
  }
}
</script>
<style scoped>
</style>
