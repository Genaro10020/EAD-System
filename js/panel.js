const app = {
  data() {
    return{
       /*/////////////////////////////////////////////////////////////////////////////////VARIBLES USUARIOS Y DEPARTAMENTOS INICIO*/
      ventana:'usuarios',
      accion:'insertar',
      accion_departamento:'',
      titulo_formulario_usuarios:'ALTA USUARIOS',
      texto_btn_submit:"Aceptar",
      bandera_alta_o_actualizar:1,
      nombre:'',
      nomina:'',
      contrasena:'',
      selector_planta:'',
      selector_area:'',
      selector_subarea:'',
      selector_tipo_usuario:'',
      selector_tipo_acceso:'',
      tipo_accesos:[
        'Admin',
        'Usuario'
      ],
      plantas:[],
      areas:[],
      subareas:[],
      tipos:[],
      usuarios:[],
      myModal:'',
      id_actualizar:0,
      departamento:'',
      nuevo_departamento:'',
      nuevo_tipo_usuario:'',
       /*///////////////////////////////////////////////////////////////////////////////////////VARIBLES SCORE INICIO*/
      h:'hola'

    }
  },
  mounted(){
    this.consultarUsuarios()
  },
  methods: {
     /*/////////////////////////////////////////////////////////////////////////////////USUARIOS*/
    consultarUsuarios(){
      axios.post('consulta_PlantasAreasSubareasUsuarios.php',{
      }).then(response =>{
        console.log(response.data)
        this.plantas = response.data.Plantas
        this.areas = response.data.Areas
        this.subareas= response.data.Subareas
        this.tipos= response.data.TiposUsuario
        this.usuarios= response.data.Usuarios
      }).catch(error =>{
        console.log('Erro :-('+error)
      })
    },
    ventanas(ventana){
      this.ventana = ventana
      this.consultarUsuarios()
    },
        nuevoActualizarUsuario(){
                axios.post('insertar_actualizar_eliminar_usuario.php',{
                  accion: this.accion,
                  nombre: this.nombre,
                  nomina: this.nomina,
                  contrasena: this.contrasena,
                  planta: this.selector_planta,
                  area: this.selector_area,
                  subarea:this.selector_subarea,
                  usuario:this.selector_tipo_usuario,
                  acceso: this.selector_tipo_acceso,
                  id:this.id_actualizar
              }).then(response=>{
                console.log(response.data)
                if(response.data==true){
                    this.bandera_alta_o_actualizar=1
                    this.accion='insertar'
                    this.texto_btn_submit='Aceptar'
                    this.titulo_formulario_usuarios='ALTA USUARIO'
                    this.consultarUsuarios();
                    this.nombre=''
                    this.nomina=''
                    this.contrasena=''
                    this.selector_planta=''
                    this.selector_area=''
                    this.selector_subarea=''
                    this.selector_tipo_usuario=''
                    this.selector_tipo_acceso=''
                }else{
                    alert("Algo salio mal al insertar :-(")
                }
              }).catch(error =>{
                console.log('Axios Erro :-('+error)
              })
        },
        eliminarUsuario(id){
              if(!confirm("¿Esta seguro que desea eliminar el usuario?")) return
              
                axios.post("insertar_actualizar_eliminar_usuario.php",{
                    accion:'eliminar',
                    id:id
                  }).then(response =>{
                    console.log(response.data)
                    if(response.data==true){
                        this.consultarUsuarios();
                    }else{
                        alert("No se elimino correctamente :-(")
                    }
                  }).catch(error=>{
                    alert("Axios error :-("+error)
                  })
          },
          actualizarUsuario(accion,id){
              this.accion=accion
              this.id_actualizar=id
              if(this.accion=="insertar"){
                this.bandera_alta_o_actualizar=1
                this.texto_btn_submit='Aceptar'
                this.titulo_formulario_usuarios='ALTA USUARIO'
                this.nombre=''
                this.nomina=''
                this.contrasena=''
                this.selector_planta=''
                this.selector_area=''
                this.selector_subarea=''
                this.selector_tipo_usuario=''
                this.selector_tipo_acceso=''

              }else if(this.accion=="actualizar"){
                this.bandera_alta_o_actualizar=2
                this.texto_btn_submit='Actualizar'
                this.titulo_formulario_usuarios='ACTUALIZAR USUARIO'
                  axios.post("consultar_datos_usuario.php",{
                      id:id
                  }).then(response =>{
                    console.log(response.data)
                      if (Object.keys(response.data).length > 0) {
                        this.nombre=response.data.nombre
                        this.nomina=response.data.nomina
                        this.contrasena=response.data.contrasena
                        this.selector_planta=response.data.planta
                        this.selector_area=response.data.area
                        this.selector_subarea=response.data.subarea
                        this.selector_tipo_usuario=response.data.tipo_usuario
                        this.selector_tipo_acceso=response.data.tipo_acceso
                } else {
                      console.log("El objeto está vacío.");
                }
                  }).catch(error =>{
                    alert("Axios error :-("+error)
                  })
              }
        },
          datosModalTipoUsuario(){
              this.myModal = new bootstrap.Modal(document.getElementById("modalUsuarios"))
              this.myModal.show()
        },
        tipoUsuariosCRUD(accion,usuario){
          if(accion=="eliminar"){
              if(!confirm("¿Esta seguro que desea eliminar este tipo de usuario?")) return
          }
          axios.post("crud_tipo_usuarios.php",{
            accion:accion,
            nuevo_tipo:this.nuevo_tipo_usuario,
            usuario:usuario
          }).then(response =>{
            console.log(response.data)
            if(response.data==true){
              this.nuevo_tipo_usuario = ''
              this.consultarUsuarios()
            }else{
              console.log("no se guardo correctamente")
            }
          })
        },
        /*/////////////////////////////////////////////////////////////////////////////////DEPARTAMENTOS*/
        datosModal(departamento,accion,id,nombre){
                    this.departamento = departamento
                    this.accion_departamento = accion
                    this.id = id
                    this.nuevo_departamento = nombre
                    this.myModal = new bootstrap.Modal(document.getElementById("modal"))
                    this.myModal.show()
          },
          cerrarModal(){
            this.myModal.hide()
          },
          nuevoDepartamento(){
             axios.post("nuevo_departamento.php",{
                  departamento:this.departamento,
                  nuevo_departamento:this.nuevo_departamento
                }).then(response =>{
                  console.log(response.data)
                  if(response.data==true){
                      this.nuevo_departamento=""
                      this.myModal.hide()
                      this.consultarUsuarios();
                  }else{
                      alert("No se agrego correctamente :-(")
                  }
                }).catch(error=>{
                  alert("Axios error :-("+error)
                })
          },
          actualizarDepartamento(){
             axios.post("actualizar_departamento.php",{
                  departamento:this.departamento, //bien al cliquear modal.
                  id:this.id, //bien al cliquear modal.
                  nombre:this.nuevo_departamento
                }).then(response =>{
                  console.log(response.data)
                  if(response.data==true){
                      this.myModal.hide()
                      this.consultarUsuarios();
                  }else{
                      alert("No se elimino correctamente :-(")
                  }
                }).catch(error=>{
                  alert("Axios error :-("+error)
                })
          },
          eliminarDepartamento(departamento,id){
           if(!confirm("¿Esta seguro/a que desea Eliminar la "+departamento+"?")) return
            axios.post("eliminar_departamento.php",{
                 departamento:departamento,
                 id:id
               }).then(response =>{
                 console.log(response.data)
                 if(response.data==true){
                     this.consultarUsuarios();
                 }else{
                     alert("No se elimino correctamente :-(")
                 }
               }).catch(error=>{
                 alert("Axios error :-("+error)
               })
         },
          /*/////////////////////////////////////////////////////////////////////////////////SCORECARD*/
  }
};

const App = Vue.createApp(app);

App.mount("#app");