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
      tipo_accesos:['Admin','Usuario'],
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
       /*///////////////////////////////////////////////////////////////////////////////////////VARIBLES SCORECARD*/
       tipoPlantillas:['Placas','Formacion','Etiquetado','Ensamble'],
       ver_plantillas:'',
       objetivos:[],
       scorecard:[],
       plantilla:'',
       ugb:'',
       meses:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
       mes_seleccionado:'Enero',
       anios:[],
       anio_seleccionado:2023,
       select_plantillas:'Placas',
       plantillas:['Placas','Formación','Etiquetado','Ensamble'],
       filasSC: ['Reclamos','Merma y desperdicio','Eficiencia','Accidentes','Actos inseguros','PB de sangre','Ausentismo','5´s','Sugerencias de mejora','Cumplimiento de proyecto'],
       columnasSC: ['Valor actual','Puntos obtenidos','Ponderacion','Puntos evaluados'],
       ////////////////////////////////////////////////////////////////////////////////////*CREAR EAD */
       colaboradores:[],
       select_nombre:'',
       select_planta:'',
       select_area:'',
       select_proceso:'',
       select_lider_equipo:'',
       select_coordinador:'',
       select_jefe_area:'',
       select_ing_proceso:'',
       select_ing_calidad:'',
       select_supervisor:'',
       numerosTablas: [15,14,13,12,11,10,9,8,7,6,5,4,3,2,1,0,'DIA'],
       numerosTablas2: [1,2],
       numerosTablas3: [150,145,140,135,130,125,120,115,110,105,100,95,90,85,80,'DIA'],
       nuneroTablasEficiencia: ['130%','120%','110%','100%','90%','80%','70%','60%','50%','40%','30%','20%','10%','0%','DIA'],
       numeroTablasAccidentes: [5,4,3,2,1,'DIA'],
       numeroTablasActosInseguros: [10,9,8,7,6,5,4,3,2,1,'DIA'],
       numeroTablasProyectos: [100,90,80,70,60,50,40,30,20,10,0,'DIA'],
       tipoTabla: ['Rechazos','Merma','Eficiencia','Accidentes','Actos inseguros','Ausentismo','Cumplimiento del proyecto'],
       tipoTablas: '',
       clasificaciones: ['ITEM','CAUSA','CANTIDAD'],
       ////////////////////////////////////////////////////////////////////////////////////*GRAFICAS*/
       grafica: 'Rechazos',
      ////////////////////////////////////////////////////////////////////////////////////*COMPETENCIA PLACAS*/
      filasCP: ['UP','Planta','Posicion','EADs','Proyecto','Evaluador','Calificacion final','Posicion final']

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

       /*/////////////////////////////////////////////////////////////////////////////////CONSULTA COLABORADORS*/
       consultarColaboradores(){
        axios.post('consulta_colaboradores.php',{
        }).then(response =>{
          console.log(response.data)
          this.colaboradores = response.data.Colaboradores
        }).catch(error =>{
          console.log('Erro :-('+error)
        })
      },
      graficas(grafica){
        this.grafica = grafica
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
          consultarObjetivos(){
            axios.post("objetivos.php",{
              accion:'Consultar'
            }).then(response =>{
              console.log(response.data)
              this.objetivos = response.data
            }).catch(error=>{
              alert("Axios error :-("+error)
            })
         },
         consultarScoreCard(){
            axios.post("scorecard.php",{
              accion:'Consultar',
              plantilla:this.ver_plantillas
            }).then(response =>{
              console.log(response.data)
              this.scorecard = response.data
            }).catch(error=>{
              alert("Axios error :-("+error)
            })
         },
         crearScoreCard(){
          //if(!confirm("¿Desea crear un nuevo ScoreCard?")) return
          if(this.ugb != "" || this.mes_seleccionado!='0'){
            axios.post("scorecard.php",{
              accion:'Insertar',
              ugb:this.ugb,
              mes:this.mes_seleccionado,
              anio:this.anio_seleccionado,
              plantilla:this.select_plantillas
          }).then(response =>{
            console.log(response.data)
               if(response.data.bien==true){
                   this.consultarScoreCard()
                   this.myModal.hide()
                   this.ugb=""
                }else{
                    alert("No se creo correctamente el ScoreCard")
                }
          }).catch(error=>{
             alert("Axios error :-("+error)
          })
        }else{
          alert("Todos los campos son requeridos.")
        }
         },
         modalScorecard(){
            this.myModal = new bootstrap.Modal(document.getElementById("modal"))
            this.myModal.show()
        },
        cicloAnios(){
          for (let i = 2023; i < 2100; i++) {
            this.anios.push(i)
          }
        },
        /*/////////////////////////////////////////////////////////////////////////////////CREACIÓN DE EQUIPOS DE ALTO DESEMPEÑO */
        /*Aqui tu metodo o filtro Rubén */
        filtraLiderEquipo(){
             return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Lider de Equipo');
        },
        filtraCordinador(){
             return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Coordinador');
        },
        filtraJefeArea(){
          return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Jefe de Área');
        },
        filtraIngenieroProceso(){
          return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Ingeniero de Proceso');
        },
        filtraIngenieroCalidad(){
          return this.usuarios.filter(usuario => usuario.tipo_usuario ==='Ingeniero de Calidad');
        },
        filtraSupervisor(){
          return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Supervisor')
        },
        crearEAD(){
          axios.post("ead.php",{
              nombre:this.select_nombre,
              planta:this.select_planta,
              area:this.select_area,
              proceso:this.select_proceso,
              lider:this.select_lider_equipo,
              coordinador:this.select_coordinador,
              jefe_area:this.select_jefe_area,
              ing_proceso:this.select_ing_proceso,
              ing_calidad:this.select_ing_calidad,
              supervisor:this.select_supervisor
          }).then(response=>{
            console.log(response.data)
          }).catch(error=>{
            alert("Axios CrearEAD :-("+error)
          })
        }
        
  }
};

const App = Vue.createApp(app);

App.mount("#app");