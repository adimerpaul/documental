<template>
  <div class="q-pa-md">
    <q-btn label="Nueva Categoria" color="positive" @click="alert = true" icon="add_circle" class="q-mb-xs" />
    <q-dialog v-model="alert">
      <q-card>
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Crear Categoria</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onSubmit"
            @reset="onReset"
            class="q-gutter-md"
          >
            <q-input
              filled
              v-model="dato.codigo"
              type="number"
              label="Codigo"
              hint="Ingresar Codigo"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa codigo']"
            />
            <q-input
              filled
              v-model="dato.nombre"
              type="text"
              label="Nombre"
              hint="Ingresar nombre"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa nombre']"
            />
            <q-input
              filled
              v-model="dato.sigla"
              type="text"
              label="Sigla"
              hint="Ingresar sigla"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa sigla']"
            />

            <div>
              <q-btn label="Crear" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>


      </q-card>
    </q-dialog>
    <q-table
      title="Categorias"
      :rows="data"
      :columns="columns"
      :filter="filter"
      row-key="codigo"
      :rows-per-page-options="[50,100,200,0]"
    >
          <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-subcategorias="props">
        <q-td key="subcategorias" :props="props">
          <ul style="border: 0px;margin: 0px;padding: 0px;list-style: none" v-for="s in props.row.subcategorias" :key="s.id">
            <li style="border: 0px;margin: 0px;padding: 0px;list-style: none">{{ s.codigo }} {{ s.nombre }}</li>
          </ul>
        </q-td>
      </template>
      <template v-slot:body-cell-opcion="props">
          <q-td key="opcion" :props="props">
            <q-btn dense round flat color="green" @click="verRow(props)" icon="list"></q-btn>
            <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit"></q-btn>
            <q-btn dense round flat color="red" @click="deleteRow(props)" icon="delete"></q-btn>
          </q-td>
      </template>

    </q-table>

    <q-dialog v-model="dialog_mod">
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">Modificar</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onMod"
            class="q-gutter-md"
          >
            <q-input
              filled
              v-model="dato2.codigo"
              type="number"
              label="Codigo"
              hint="Ingresar Codigo"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa codigo']"
            />
            <q-input
              filled
              v-model="dato2.nombre"
              type="text"
              label="Nombre"
              hint="Ingresar nombre"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa nombre']"
            />
            <q-input
              filled
              v-model="dato2.sigla"
              type="text"
              label="Sigla"
              hint="Ingresar sigla"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa sigla']"
            />

            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>


<q-dialog v-model="dialog_ver" full-width>
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">{{dato2.nombre}}: Sub Categorias</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
                <q-form
            @submit="onSub"
            @reset="onReset"
            class="q-gutter-md"
          >
          <div class="row">
          <div class="col-3">
          <q-input
              filled
              dense
              v-model="subc.codigo"
              type="text"
              label="Codigo"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa codigo']"
            /> </div>
          <div class="col-3">
               <q-input
              filled dense
              v-model="subc.nombre"
              type="text"
              label="Nombre"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa nombre']"
            /></div>
          <div class="col-3">
            <q-input
              filled dense
              v-model="subc.sigla"
              type="text"
              label="Sigla"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa sigla']"
            /> </div>
            <div class="col-3">
             <q-btn label="Modificar" @click="onModsub" color="yellow" icon="edit" v-if="boolmod"/>
             <q-btn label="Crear" type="submit" color="positive" icon="add_circle" v-else />
             </div>
            </div>
          </q-form>

      <q-table
      title="Sub Categorias"
      :rows="sub"
      :columns="columns2"
      :filter="filter2"
      dense>
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter2" placeholder="Buscar">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template v-slot:body-cell-opcion="props">
          <q-td key="opcion" :props="props">
            <q-btn dense round flat color="yellow" @click="subeditRow(props)" icon="edit"></q-btn>
            <q-btn dense round flat color="red" @click="subdeleteRow(props)" icon="delete"></q-btn>
          </q-td>
      </template>
      </q-table>
        </q-card-section>
      </q-card>
    </q-dialog>


    <q-dialog v-model="dialog_del" >
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="clear" color="red" text-color="white" />
          <span class="q-ml-sm">Seguro de eliminar Registro.</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Eliminar" color="deep-orange" @click="onDel"/>
          <q-btn flat label="Cancelar" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

  </div>

</template>

<script>
import {date} from "quasar";

export default {
  data () {
    return {
      url:process.env.API,
      fecha:{
        inicio:date.formatDate(Date.now(),'YYYY-MM-DD'),
        fin:date.formatDate(Date.now(),'YYYY-MM-DD'),
      },
      alert: false,
      dialog_mod:false,
      dialog_del:false,
      dialog_ver:false,
      boolmod:false,
      filter:'',
      filter2:'',
      dato:{},
      dato2:{},
      subc:{},
      modprod:{},
      columns: [
        {name: 'codigo', label: 'Codigo', align: 'left', field: row=>row.codigo, sortable: true},
        {name: 'nombre', label: 'Nombre', align: 'left', field: 'nombre', sortable: true},
        {name: 'subcategorias', label: 'Subcategorias', align: 'left', field: 'subcategorias', sortable: true},
        { name: 'sigla', align: 'center', label: 'Sigla', field: 'sigla', sortable: true },
        { name: 'fecha', align: 'center', label: 'Fecha', field: 'fecha' },
        { name: 'opcion', label: 'Opcion', field:'opcion'}

      ],
      columns2: [
        {
          name: 'codigo',
          required: true,
          label: 'codigo',
          align: 'left',
          field: row => row.codigo,
          // format: val => `${val}`,
          sortable: true
        },
        { name: 'nombre', align: 'center', label: 'Nombre', field: 'nombre', sortable: true },
        { name: 'sigla', align: 'center', label: 'Sigla', field: 'sigla', sortable: true },
        { name: 'fecha', align: 'right', label: 'fecha', field: 'fecha', sortable: true },
        { name: 'opcion', align: 'right', label: 'Opcion', field: 'opcion' },

      ],
      data: [
      ],
      prod2: [
      ]
    }
  },
  created() {
    this.misdatos();
  },
  methods:{
        subdeleteRow (props) {
      this.$q.dialog({
        title: 'Eliminar',
        message: 'Esta seguro de Eliminar?',
        cancel: true,
      }).onOk(() => {
                this.$q.loading.show();
        this.$axios.delete(process.env.API+'/subcategoria/'+props.row.id).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Eliminado correctamente'
        });
        this.dialog_ver=false;
        this.misdatos();})
      }).onOk(() => {
        // console.log('>>>> second OK catcher')
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    },
    misdatos(){
      this.$q.loading.show();
      this.$axios.get(process.env.API+'/categoria').then(res=>{
        console.log(res.data)
        this.data=res.data;

        this.$q.loading.hide();
      })
    },
    subeditRow(props){
      this.subc=props.row;
      this.boolmod=true;
    },
    editRow(categoria){
        // console.log(categoria.row);
        this.onReset()
        this.boolmod=false;
        this.dato2= categoria.row;
        this.dialog_mod=true;
    },
    verRow(categoria){
      this.boolmod=false;
      this.onReset()
        this.dato2= categoria.row;
        // console.log(categoria.row);
        this.sub= categoria.row.subcategorias;
        this.dialog_ver=true;
    },

    deleteRow(categoria){
        // console.log(categoria.row);
        this.dato2= categoria.row;
        this.dialog_del=true;
    },


    onSubmit () {

        this.dato.fecha=date.formatDate(Date.now(),'YYYY-MM-DD');
      this.$q.loading.show();

      this.$axios.post(process.env.API+'/categoria', this.dato).then(res=>{
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Creado correctamente'
        });
        this.alert=false;
        this.dato={};
        this.misdatos();
      })
    },
        onSub() {

        this.subc.fecha=date.formatDate(Date.now(),'YYYY-MM-DD');
        this.subc.categoria_id=this.dato2.id;
      this.$q.loading.show();

      this.$axios.post(process.env.API+'/subcategoria', this.subc).then(res=>{
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Creado correctamente'
        });
        this.misdatos();
        this.dialog_ver=false;
        this.onReset()
      })
    },

    onMod(){
        this.$q.loading.show();
        this.$axios.put(process.env.API+'/categoria/'+this.dato2.id,this.dato2).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.dialog_mod=false;
        this.misdatos();})
    },

        onModsub(){
        this.$q.loading.show();
        this.$axios.put(process.env.API+'/subcategoria/'+this.subc.id,this.subc).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.dialog_ver=false;
        this.onReset()
        this.misdatos();})
    },

    onDel(){
        this.$q.loading.show();
        this.$axios.delete(process.env.API+'/categoria/'+this.dato2.id).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Eliminado correctamente'
        });
        this.dialog_del=false;
        this.misdatos();})
    },

    onReset () {
      this.dato.sigla = null;
      this.dato.nombre = null;
      this.dato.codigo = null;
      this.subc.sigla=null
      this.subc.nombre=null
      this.subc.codigo=null
    }
  }
}
</script>
