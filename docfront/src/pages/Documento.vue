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
              label="Nombre"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa Nombre']"
            />
<!--            <q-input-->
<!--              @update:model-value="val => { file = val[0] }"-->
<!--              filled-->
<!--              type="file"-->
<!--              @change="getImage"-->
<!--              hint="Native file"-->
<!--            />-->

            <input type="file" @change="getImage" >
            <div>
<!--              <template v-if="categoria.value!=undefined && subcategoria.value!=undefined">-->
              <div>Nombre Archivo:{{dato.fondo}}-{{categoria.value.sigla}}-{{subcategoria.value.sigla}}-{{dato.gestion}}-{{dato.tomo}}-{{dato.numtotal}}-{{dato.detalle}}</div>
<!--              </template>-->
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
      <template v-slot:body-cell-archivo="props">
        <q-td key="archivo" :props="props">
          <a :href="url+'/../imagenes/'+props.row.archivo" target="_blank">{{props.row.archivo}}</a>
        </q-td>
      </template>
      <template v-slot:body-cell-opcion="props">
          <q-td key="opcion" :props="props">
            <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit"></q-btn>
            <q-btn dense round flat color="accent" @click="archRow(props)" icon="upload_file"></q-btn>
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
            <q-select dense outlined v-model="categoria" :options="cat" label="Categoria" @update:model-value="cargarsubcat"/>
            <q-select dense outlined v-model="subcategoria" :options="subcat" label="SubCategoria" required/>
            <div class="row">
              <div class="col-6">
            <q-input
              outlined
              dense
              v-model="dato2.fondo"
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
                v-model="dato2.gestion"
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
              v-model="dato2.tomo"
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
              v-model="dato2.numtotal"
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
              v-model="dato2.detalle"
              type="text"
              label="Nombre"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa Nombre']"
            />

            <div>
              <div>Nombre Archivo:{{dato2.fondo}}-{{categoria.value.sigla}}-{{subcategoria.value.sigla}}-{{dato2.gestion}}-{{dato2.tomo}}-{{dato2.numtotal}}-{{dato2.detalle}}</div>
<br>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialog_arch">
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">Archivo Subir</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onArch"
            class="q-gutter-md"
          >
            <input type="file" @change="getImage" >

            <div>
<br>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
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
      imagen : null,
      fecha:{
        inicio:date.formatDate(Date.now(),'YYYY-MM-DD'),
        fin:date.formatDate(Date.now(),'YYYY-MM-DD'),
      },
      alert: false,
      dialog_mod:false,
      dialog_del:false,
      dialog_ver:false,
      dialog_arch:false,
      boolmod:false,
      filter:'',
      filter2:'',
      dato:{fondo:'APMT',gestion:date.formatDate(Date.now(),'YYYY'),tomo:'1',numtotal:'1'},
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
    // this.$q.loading.show();
    this.misdatos();

  },
  methods:{
    getImage(event){
      //Asignamos la imagen a  nuestra data
      // console.log(event.target)
      this.imagen = event.target.files[0];
    },
    misdatos(){
      this.$q.loading.show();
        this.$axios.get(process.env.API+'/documento').then(res=>{
           this.data=res.data;
          this.$q.loading.hide();
        })


    },
      cargarsubcat(){
        this.subcat=[]

        if (this.categoria.value.subcategorias.length>0){
        this.categoria.value.subcategorias.forEach(element => {
              this.subcat.push({label:element.nombre,value:element});
          });
              this.subcategoria=this.subcat[0]
        }else{
          // this.subcategoria={}
        }
      },
        
    categorias(){
      this.$q.loading.show();
      this.cat=[]
      this.$axios.get(process.env.API+'/categoria').then(res=>{
        // console.log(res.data)
        res.data.forEach(element => {
            this.cat.push({label:element.nombre,value:element});
        });
       this.categoria=this.cat[0];
       this.cargarsubcat()
        // this.$q.loading.hide();
      })
    },

    editRow(props){
        // console.log(categoria.row);
        this.onReset()
        this.boolmod=false;
        this.dato2= props.row;
        this.dialog_mod=true;
    },
        archRow(props){
        // console.log(categoria.row);
        this.onReset()
        this.dato2= props.row;
        this.dialog_arch=true;
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

      this.dato.archivo=this.dato.fondo+'-'+this.categoria.value.sigla+'-'+this.subcategoria.value.sigla+'-'+this.dato.gestion+'-'+this.dato.tomo+'-'+this.dato.numtotal+'-'+this.dato.detalle;
      this.dato.categoria_id=this.categoria.value.id;
      this.dato.subcategoria_id=this.subcategoria.value.id;
      this.dato.fecha=date.formatDate(Date.now(),'YYYY-MM-DD');
      this.$q.loading.show();
      var data = new  FormData();
      data.append('imagen', this.imagen);
      data.append('archivo', this.dato.archivo);
      data.append('categoria_id', this.dato.categoria_id);
      data.append('subcategoria_id', this.dato.subcategoria_id);
      data.append('fecha', this.dato.fecha);
      data.append('fondo', this.dato.fondo);
      data.append('gestion', this.dato.gestion);
      data.append('tomo', this.dato.tomo);
      data.append('numtotal', this.dato.numtotal);
      data.append('detalle', this.dato.detalle);

      this.$axios.post(process.env.API+'/documento', data).then(res=>{
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
        this.dato2.archivo=this.dato2.fondo+'-'+this.categoria.value.sigla+'-'+this.subcategoria.value.sigla+'-'+this.dato2.gestion+'-'+this.dato2.tomo+'-'+this.dato2.numtotal+'-'+this.dato2.detalle;
        this.dato2.categoria_id=this.categoria.value.id;
        this.dato2.subcategoria_id=this.subcategoria.value.id;
        this.$q.loading.show();
        this.$axios.put(process.env.API+'/documento/'+this.dato2.id,this.dato2).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.dialog_mod=false;
        this.misdatos();})
    },

    onArch(){
           var data2 = new  FormData();
           this.dato2.archivo=this.dato2.fondo+'-'+this.dato2.categoria.sigla+'-'+this.dato2.subcategoria.sigla+'-'+this.dato2.gestion+'-'+this.dato2.tomo+'-'+this.dato2.numtotal+'-'+this.dato2.detalle;

          data2.append('id', this.dato2.id);
          data2.append('archivo', this.dato2.archivo);
          data2.append('imagen', this.imagen);
          this.$axios.post(process.env.API+'/uparchivo', data2).then(res=>{
                     this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.misdatos();
        this.dialog_arch=false;
          })
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
