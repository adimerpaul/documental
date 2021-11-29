<template>
  <div class="q-pa-md">
    <q-btn label="Nueva Documento" color="positive" @click="alert = true" icon="add_circle" class="q-mb-xs" />

    <q-dialog v-model="alert" >
      <q-card style="width: 700px; max-width: 80vw;">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6">Crear Documento</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onSubmit"
            @reset="onReset"
            class="q-gutter-md"
          >
            <q-select dense outlined v-model="categoria" :options="cat" label="Categoria" @update:model-value="cargarsubcat"/>
            <q-select dense outlined v-model="subcategoria" :options="subcat" label="SubCategoria" required/>
            <div class="row">
              <div class="col-6">
            <q-input
              outlined
              dense
              v-model="dato.fondo"
              type="text"
              label="Fondo"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa codigo']"
            />
              </div>
              <div class="col-6">
                                          <q-input
              outlined
              dense
              v-model="dato.gestion"
              type="number"
              label="gestion"
              lazy-rules
              :rules="[ val => val>1000 && val< 9999 || 'Por favor ingrese año']"
            />
              </div>

            </div>
            <div class="row">
              <div class="col-6">
                
            <q-input
              outlined
              dense
              v-model="dato.tomo"
              type="text"
              label="No Tomo"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa tomo']"
            />
              </div>
              <div class="col-6">
                            <q-input
              outlined
              dense
              v-model="dato.numtotal"
              type="text"
              label="No Folio"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa Folio']"
            />
              </div>
            </div>
                        <q-input
              outlined
              dense
              v-model="dato.detalle"
              type="text"
              label="Ruta"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa Ruta']"
            />
            <div>
              <div>Nombre Archivo:{{dato.fondo}}-{{categoria.value.sigla}}-{{subcategoria.value.sigla}}-{{dato.gestion}}-{{dato.tomo}}-{{dato.numtotal}}-{{subcategoria.value.nombre}}</div>
              <br>
              <q-btn label="Crear" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>


      </q-card>
    </q-dialog>
    <q-table
      title="Documentos / Archivos"
      :rows="data"
      :columns="columns"
      :filter="filter"
      row-key="name"
    >
          <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
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
              type="text"
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
            <div class="col-33">
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
      cat:[],
      subcat:[],
      categoria:{},
      subcategoria:{},
      columns: [
    {
          name: 'fondo',
          label: 'Fondo',
          align: 'left',
          field: row=>row.fondo,
          sortable: true
        },
        {
          name: 'archivo',
          label: 'Archivo',
          align: 'left',
          field: 'archivo',
          sortable: true
        },
        { name: 'gestion', align: 'center', label: 'Gestion', field: 'gestion', sortable: true },
        { name: 'tomo', align: 'center', label: 'tomo', field: 'tomo', sortable: true },
        { name: 'numtotal', align: 'center', label: 'numtotal', field: 'numtotal', sortable: true },
        { name: 'detalle', align: 'center', label: 'detalle', field: 'detalle', sortable: true },
        { name: 'estado', align: 'center', label: 'estado', field: 'estado', sortable: true },
        { name: 'categoria', align: 'center', label: 'categoria', field: row=>row.categoria.nombre, sortable: true },
        { name: 'subcategoria', align: 'center', label: 'subcategoria', field: row=>row.subcategoria.nombre, sortable: true },
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
    this.categorias();
    this.misdatos();
  },
  methods:{
    misdatos(){
      this.$q.loading.show();
        this.$axios.get(process.env.API+'/documento').then(res=>{
           this.data=res.data;
        })
        this.$q.loading.hide();

    },
      cargarsubcat(){
          this.subcat=[]
        this.categoria.value.subcategorias.forEach(element => {
              this.subcat.push({label:element.nombre,value:element});
          });
              this.subcategoria=this.subcat[0]

      },
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
    categorias(){
      this.$q.loading.show();
      this.cat=[]
      this.$axios.get(process.env.API+'/categoria').then(res=>{
        console.log(res.data)
        res.data.forEach(element => {
            this.cat.push({label:element.nombre,value:element});
        });
       this.categoria=this.cat[0];
       this.cargarsubcat()
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
      this.dato.archivo=this.dato.fondo+'-'+this.categoria.value.sigla+'-'+this.subcategoria.value.sigla+'-'+this.dato.gestion+'-'+this.dato.tomo+'-'+this.dato.numtotal+'-'+this.subcategoria.value.nombre;
      this.dato.categoria_id=this.categoria.value.id;
      this.dato.subcategoria_id=this.subcategoria.value.id;
      this.dato.fecha=date.formatDate(Date.now(),'YYYY-MM-DD');
      this.$q.loading.show();

      this.$axios.post(process.env.API+'/documento', this.dato).then(res=>{
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Creado correctamente'
        });
        this.alert=false;
        this.misdatos();
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

    onDel(){
        this.$q.loading.show();
        this.$axios.delete(process.env.API+'/documento/'+this.dato2.id).then(res=>{
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
  },
  
}
</script>
