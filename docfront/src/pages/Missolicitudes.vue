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

            <a  v-if="props.row.estado=='ACEPTADO'" :href="url+'/../imagenes/'+props.row.documento.archivo" target="_blank">{{props.row.documento.archivo}}</a>
            <template v-else>
              {{props.row.documento.archivo}}
            </template>
          </q-td>
        </template>
        <template v-slot:body-cell-categoria="props">
          <q-td key="categoria" :props="props">
            {{props.row.documento.categoria.codigo}} {{props.row.documento.categoria.nombre}}
          </q-td>
        </template>
        <template v-slot:body-cell-subcategoria="props">
          <q-td key="subcategoria" :props="props">
            {{props.row.documento.subcategoria.codigo}} {{props.row.documento.subcategoria.nombre}}
          </q-td>
        </template>
        <template v-slot:body-cell-estado="props">
          <q-td key="estado" :props="props">
            <q-badge :color="props.row.estado=='SOLICITADO'?'negative':'positive'">{{props.row.estado}}</q-badge>
          </q-td>
        </template>
        <template v-slot:body-cell-opcion="props">
          <q-td key="opcion" :props="props">
            <q-btn-group>
              <q-btn v-if="props.row.estado!='SOLICITADO'" dense round flat color="positive" @click="debolver(props.row)" icon="check_circle" label="devolver"></q-btn>
              <q-btn v-else dense round flat color="negative"  @click="cancelar(props.row)" icon="close" label="cancelar"></q-btn>
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
      // url:process.env.API,
      url:process.env.API,
      columns: [
        // {name: 'fondo', label: 'Fondo', align: 'left', field: row=>row.fondo, sortable: true},
        {name: 'archivo', label: 'Archivo', align: 'left', field: 'archivo', sortable: true},
        // { name: 'gestion', align: 'center', label: 'Gestion', field: 'gestion', sortable: true },
        // { name: 'tomo', align: 'center', label: 'tomo', field: 'tomo', sortable: true },
        // { name: 'numtotal', align: 'center', label: 'numtotal', field: 'numtotal', sortable: true },
        // { name: 'detalle', align: 'center', label: 'detalle', field: 'detalle', sortable: true },
        // { name: 'estado', align: 'center', label: 'estado', field: 'estado', sortable: true },
        { name: 'categoria', align: 'center', label: 'Categoria', field:'categoria', sortable: true },
        { name: 'subcategoria', align: 'center', label: 'Subcategoria', field: 'subcategoria', sortable: true },
        { name: 'estado', align: 'center', label: 'Estado', field: 'estado', sortable: true },
        { name: 'opcion', label: 'Opcion', field:'opcion'}

      ],
    }
  },
  created() {
    this.misdatos()
  },
  methods:{
    debolver(d){
      this.$q.loading.show();
      // d.estado='ACEPTADO'
        // d.observacion=''
        this.$axios.put(process.env.API+'/prestamo/'+d.id,{estado:'DEVUELTO',fechadevolucion:date.formatDate(Date.now(),'YYYY-MM-DD')}).then(res=>{
          console.log(res.data)
          this.$q.loading.hide();
          this.$q.notify({
            message:'Solicitud devuelta',
            color:'green',
            icon:'done'
          })
          this.misdatos()
        }).catch(error=>{
          this.$q.loading.hide();
          this.$q.notify({
            message:error.response.data.message,
            color:'red',
            icon:'error'
          })
        })
    },
    cancelar(d){
      this.$q.loading.show();
      this.$axios.delete(process.env.API+'/prestamo/'+d.id).then(res=>{
        this.$q.loading.hide();
        this.$q.notify({
          message:'Solicitud cancelada',
          color:'green',
          icon:'done'
        })
        this.misdatos()
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
      this.$axios.post(process.env.API+'/misprestamo').then(res=>{
        this.data=res.data;
        console.log(this.data)
        this.$q.loading.hide();
      })
    },
  }
}
</script>
<style scoped>
</style>
