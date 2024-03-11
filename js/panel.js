var arreglo = [];
const app = {
  data() {
    return {
      /*/////////////////////////////////////////////////////////////////////////////////VARIBLES USUARIOS Y DEPARTAMENTOS INICIO*/
      var_actualizarEAD:false,
      tipo_usuario: '',
      ventana: 'Usuarios',
      accion: 'insertar',
      accion_departamento: '',
      titulo_formulario_usuarios: 'ALTA USUARIOS',
      texto_btn_submit: "Aceptar",
      bandera_alta_o_actualizar: 1,
      nombre: '',
      nomina: '',
      contrasena: '',
      selector_planta: '',
      selector_area: '',
      selector_subarea: '',
      selector_tipo_usuario: '',
      selector_tipo_acceso: '',
      tipo_accesos: ['Admin', 'Usuario'],
      plantas: [],
      areas: [],
      subareas: [],
      tipos: [],
      usuarios: [],
      myModal: '',
      id_actualizar: 0,
      departamento: '',
      nuevo_departamento: '',
      nuevo_tipo_usuario: '',
      arreglo: [100],
      evaluadores:[],
      /*///////////////////////////////////////////////////////////////////////////////////////VARIBLES SCORECARD*/
      tipoPlantillas: ['Placas', 'Formacion', 'Etiquetado', 'Ensamble'],
      ver_plantillas: '',
      objetivos: [],
      scorecard: [],
      plantilla: '',
      ugb: '',
      meses: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      mes_seleccionado: 'Enero',
      anios: [],
      anio_seleccionado: 2023,
      select_plantillas: 'Placas',
      plantillas: ['Placas', 'Formación', 'Etiquetado', 'Ensamble'],
      filasSC: ['Rechazos', 'Merma y desperdicio', 'Eficiencia', 'Accidentes', 'Actos inseguros', 'PB de sangre', 'Ausentismo', '5´s', 'Sugerencias de mejora', 'Cumplimiento de proyecto'],
      columnasSC: ['Unidades', 'Valor actual', 'Puntos obtenidos', 'Ponderación', 'Puntos evaluados'],
      ////////////////////////////////////////////////////////////////////////////////////*CREAR EAD */
      colaboradores: [],
      nombre_ead: '',
      select_planta: '',
      select_area: '',
      select_proceso: '',
      select_lider_equipo: '',
      select_coordinador: '',
      select_jefe_area: '',
      select_ing_proceso: '',
      select_ing_calidad: '',
      select_supervisor: '',
      checkIntegrantes: [],
      nombresIntegrantes:[],
      idsIntegrantes:[],
      consultaEAD:[],
      integrantesEAD:[],
      idEquipo:[],

      //////////////////////////////////////////////////////////////////////////////////////**CREAR COMPENTENCIAS */
      foros:[],
      EADFiltrado:[],
      areasEADs:[] ,
      plantasEADs: [] ,
      nombre_foro:'',
      select_planta_foro:'',
      select_area_foro:'',
      fecha_foro:'',
      ckeckEADForo:[],
      ckeckEvaluadores:[],
      accion_evaluador:'',
      nombre_evaluador:'',
      nomina_evaluador:'',
      contrasena_evaluador:'',
      correo_evaluador:'',
      id_evaluador:'',
      posicion_evaluador:'',
      tituloModal:'',
      eadsForo:[],	
      evaluadoresForo:[],	
      calificacionEvaluadorForo:[],
      sum:0,
      promedioCalificaciones:0,
      //////////////////////////////////////////////////////////////////////////////////////*EVALUAR*/
      equiposEvaluador:[],
      etapas_preguntas:'',
      preguntas_evaluar:'',
      selectedOption:null,
      datosEvaluar:[],
      total_maximos:0,
      sumaPuntosMaximos: 0,
      sumaPuntosReales: 0,
      sumaPonderacion: 0,
      calificacionEAD: 0,
      id_ead_foro:'',
      id_calificacion:'',
      mensaje:'',
      examenFinalizado:'',
      ////////////////////////////////////////////////////////////////////////////////////*GRAFICAS*/
      grafica: 'Rechazos',
      numerosTablas: [15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 'DIA'],
      numerosTablas2: [1, 2],
      numerosTablas3: [150, 145, 140, 135, 130, 125, 120, 115, 110, 105, 100, 95, 90, 85, 80, 'DIA'],
      nuneroTablasEficiencia: ['130%', '120%', '110%', '100%', '90%', '80%', '70%', '60%', '50%', '40%', '30%', '20%', '10%', '0%', 'DIA'],
      numeroTablasAccidentes: [5, 4, 3, 2, 1, 'DIA'],
      numeroTablasActosInseguros: [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 'DIA'],
      numeroTablasProyectos: [100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 0, 'DIA'],
      tipoTabla: ['Rechazos', 'Merma', 'Eficiencia', 'Accidentes', 'Actos inseguros', 'Ausentismo', 'Cumplimiento del proyecto'],
      tipoTablas: '',
      clasificaciones: ['ITEM', 'CAUSA', 'CANTIDAD'],
      datosDiasMerma: ["20", 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
      sumaTabla: 0,
      datosGraficaRechazo: [],
      ////////////////////////////////////////////////////////////////////////////////////*COMPETENCIA PLACAS*/
      filasCP: ['UP', 'Planta', 'Posicion', 'EADs', 'Proyecto', 'Evaluador', 'Calificacion final', 'Posicion final'],

    }
  },
  mounted() {
    this.consultarUsuarios()
    this.datosTipoUsuario()//tomo datos de session
  },
  methods: {
   /*/////////////////////////////////////////////////////////////////////////////////TIPOS ACCESO*/
    datosTipoUsuario(){
     axios.post("datos_user.php",{
     }).then(response =>{
      this.tipo_usuario = response.data[0]
        if(response.data[0] =="Evaluador"){
          this.ventanas('Evaluar');
          this.consultarCompetenciaIDevaluador();
        }
     }).catch(error =>{
      console.log('Error en  axios tipoUser '+error);
     })
    },
    /*/////////////////////////////////////////////////////////////////////////////////USUARIOS*/
    consultarUsuarios() {
      axios.post('consulta_PlantasAreasSubareasUsuarios.php', {
      }).then(response => {
        //console.log(response.data)
        this.plantas = response.data.Plantas
        this.areas = response.data.Areas
        this.subareas = response.data.Subareas
        this.tipos = response.data.TiposUsuario
        this.usuarios = response.data.Usuarios

        //this.evaluadores = this.usuarios.filter(usuario => usuario.tipo_usuario === "Evaluador")//filtra

      }).catch(error => {
        //console.log('Erro :-(' + error)
      })
    },
    ventanas(ventana) {
      this.ventana = ventana
      this.consultarUsuarios()
    },

    /*/////////////////////////////////////////////////////////////////////////////////CONSULTA COLABORADORS*/
    consultarColaboradores() {
      axios.post('consulta_colaboradores.php', {
      }).then(response => {
        //console.log(response.data)
        this.colaboradores = response.data.Colaboradores
      }).catch(error => {
        //console.log('Erro :-(' + error)
      })
    },
    graficas(grafica) {
      this.grafica = grafica
    },
    nuevoActualizarUsuario() {
      axios.post('insertar_actualizar_eliminar_usuario.php', {
        accion: this.accion,
        nombre: this.nombre,
        nomina: this.nomina,
        contrasena: this.contrasena,
        planta: this.selector_planta,
        area: this.selector_area,
        subarea: this.selector_subarea,
        usuario: this.selector_tipo_usuario,
        acceso: this.selector_tipo_acceso,
        id: this.id_actualizar
      }).then(response => {
        //console.log(response.data)
        if (response.data == true) {
          this.bandera_alta_o_actualizar = 1
          this.accion = 'insertar'
          this.texto_btn_submit = 'Aceptar'
          this.titulo_formulario_usuarios = 'ALTA USUARIO'
          this.consultarUsuarios();
          this.nombre = ''
          this.nomina = ''
          this.contrasena = ''
          this.selector_planta = ''
          this.selector_area = ''
          this.selector_subarea = ''
          this.selector_tipo_usuario = ''
          this.selector_tipo_acceso = ''
        } else {
          alert("Algo salio mal al insertar :-(")
        }
      }).catch(error => {
        //console.log('Axios Erro :-(' + error)
      })
    },
    eliminarUsuario(id) {
      if (!confirm("¿Esta seguro que desea eliminar el usuario?")) return

      axios.post("insertar_actualizar_eliminar_usuario.php", {
        accion: 'eliminar',
        id: id
      }).then(response => {
        //console.log(response.data)
        if (response.data == true) {
          this.consultarUsuarios();
        } else {
          alert("No se elimino correctamente :-(")
        }
      }).catch(error => {
        alert("Axios error :-(" + error)
      })
    },
    actualizarUsuario(accion, id) {
      this.accion = accion
      this.id_actualizar = id
      if (this.accion == "insertar") {
        this.bandera_alta_o_actualizar = 1
        this.texto_btn_submit = 'Aceptar'
        this.titulo_formulario_usuarios = 'ALTA USUARIO'
        this.nombre = ''
        this.nomina = ''
        this.contrasena = ''
        this.selector_planta = ''
        this.selector_area = ''
        this.selector_subarea = ''
        this.selector_tipo_usuario = ''
        this.selector_tipo_acceso = ''

      } else if (this.accion == "actualizar") {
        this.bandera_alta_o_actualizar = 2
        this.texto_btn_submit = 'Actualizar'
        this.titulo_formulario_usuarios = 'ACTUALIZAR USUARIO'
        axios.post("consultar_datos_usuario.php", {
          id: id
        }).then(response => {
          //console.log(response.data)
          if (Object.keys(response.data).length > 0) {
            this.nombre = response.data.nombre
            this.nomina = response.data.nomina
            this.contrasena = response.data.contrasena
            this.selector_planta = response.data.planta
            this.selector_area = response.data.area
            this.selector_subarea = response.data.subarea
            this.selector_tipo_usuario = response.data.tipo_usuario
            this.selector_tipo_acceso = response.data.tipo_acceso
          } else {
            //console.log("El objeto está vacío.");
          }
        }).catch(error => {
          alert("Axios error :-(" + error)
        })
      }
    },
    datosModalTipoUsuario() {
      this.myModal = new bootstrap.Modal(document.getElementById("modalUsuarios"))
      this.myModal.show()
    },
    tipoUsuariosCRUD(accion, usuario) {
      if (accion == "eliminar") {
        if (!confirm("¿Esta seguro que desea eliminar este tipo de usuario?")) return
      }
      axios.post("crud_tipo_usuarios.php", {
        accion: accion,
        nuevo_tipo: this.nuevo_tipo_usuario,
        usuario: usuario
      }).then(response => {
        //console.log(response.data)
        if (response.data == true) {
          this.nuevo_tipo_usuario = ''
          this.consultarUsuarios()
        } else {
          //console.log("no se guardo correctamente")
        }
      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////DEPARTAMENTOS*/
    datosModal(departamento, accion, id, nombre) {
      this.departamento = departamento
      this.accion_departamento = accion
      this.id = id
      this.nuevo_departamento = nombre
      this.myModal = new bootstrap.Modal(document.getElementById("modal"))
      this.myModal.show()
    },
    cerrarModal() {
      this.myModal.hide()
    },
    nuevoDepartamento() {
      axios.post("nuevo_departamento.php", {
        departamento: this.departamento,
        nuevo_departamento: this.nuevo_departamento
      }).then(response => {
        //console.log(response.data)
        if (response.data == true) {
          this.nuevo_departamento = ""
          this.myModal.hide()
          this.consultarUsuarios();
        } else {
          alert("No se agrego correctamente :-(")
        }
      }).catch(error => {
        alert("Axios error :-(" + error)
      })
    },
    actualizarDepartamento() {
      axios.post("actualizar_departamento.php", {
        departamento: this.departamento, //bien al cliquear modal.
        id: this.id, //bien al cliquear modal.
        nombre: this.nuevo_departamento
      }).then(response => {
        //console.log(response.data)
        if (response.data == true) {
          this.myModal.hide()
          this.consultarUsuarios();
        } else {
          alert("No se elimino correctamente :-(")
        }
      }).catch(error => {
        alert("Axios error :-(" + error)
      })
    },
    eliminarDepartamento(departamento, id) {
      if (!confirm("¿Esta seguro/a que desea Eliminar la " + departamento + "?")) return
      axios.post("eliminar_departamento.php", {
        departamento: departamento,
        id: id
      }).then(response => {
        //console.log(response.data)
        if (response.data == true) {
          this.consultarUsuarios();
        } else {
          alert("No se elimino correctamente :-(")
        }
      }).catch(error => {
        alert("Axios error :-(" + error)
      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////SCORECARD*/
    consultarObjetivos() {
      axios.post("objetivos.php", {
        accion: 'Consultar'
      }).then(response => {
        //console.log(response.data)
        this.objetivos = response.data
      }).catch(error => {
        alert("Axios error :-(" + error)
      })
    },
    consultarScoreCard() {
      axios.post("scorecard.php", {
        accion: 'Consultar',
        plantilla: this.ver_plantillas
      }).then(response => {
        //console.log(response.data)
        this.scorecard = response.data
      }).catch(error => {
        alert("Axios error :-(" + error)
      })
    },
    crearScoreCard() {
      //if(!confirm("¿Desea crear un nuevo ScoreCard?")) return
      if (this.ugb != "" || this.mes_seleccionado != '0') {
        axios.post("scorecard.php", {
          accion: 'Insertar',
          ugb: this.ugb,
          mes: this.mes_seleccionado,
          anio: this.anio_seleccionado,
          plantilla: this.select_plantillas
        }).then(response => {
          //console.log(response.data)
          if (response.data.bien == true) {
            this.consultarScoreCard()
            this.myModal.hide()
            this.ugb = ""
          } else {
            alert("No se creo correctamente el ScoreCard")
          }
        }).catch(error => {
          alert("Axios error :-(" + error)
        })
      } else {
        alert("Todos los campos son requeridos.")
      }
    },
    modalScorecard() {
      this.myModal = new bootstrap.Modal(document.getElementById("modal"))
      this.myModal.show()
    },
    cicloAnios() {
      for (let i = 2023; i < 2100; i++) {
        this.anios.push(i)
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////CREACIÓN DE EQUIPOS DE ALTO DESEMPEÑO */
    consultarEAD(){
      axios.post("crud_ead.php",{
        accion:'consultar'
      }).then(response => {
        //console.log("Consulta EAD",response.data)
        if(response.data[0][0]==true){
          //this.consultaEAD =response.data[1]
              var numeros = Object.keys(response.data[1]).map(Number); //tomando los indices del objeto
              const comparar = (a, b) => b - a;// b es mayo que a positivo contrario negativo y si son iguales el resultado es 0
              const ordenando = numeros.sort(comparar) //metodo que me pemite hacer la comparacion de dos variables sort
              //console.log('Ordenando', ordenando); // [1, 2, 3, 4, 5]
              const nuevoOrden = ordenando.map(num => response.data[1][num.toString()]);
              //console.log('Nuevo Orden', nuevoOrden); // [1, 2, 3, 4, 5]
              this.consultaEAD = nuevoOrden;

            if (response.data[0][1]==true) {             
              this.integrantesEAD = response.data[3]
              //console.log("Integrantes EAD",this.integrantesEAD)
            }else{
              console.log("no se logro consultar los Integrantes EAD")
            }
        }
      }).catch(error => {
        console.log("Error en la consulta :-( "+ error)
      }).finally(() => {

      })
    },
    filtraLiderEquipo() {
      return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Lider de Equipo');
    },
    filtraCordinador() {
      return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Coordinador');
    },
    filtraJefeArea() {
      return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Jefe de Área');
    },
    filtraIngenieroProceso() {
      return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Ingeniero de Proceso');
    },
    filtraIngenieroCalidad() {
      return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Ingeniero de Calidad');
    },
    filtraSupervisor() {
      return this.usuarios.filter(usuario => usuario.tipo_usuario === 'Supervisor')
    },
    seleccionadosIntegrantes(){
      this.ids =[]
      this.idsIntegrantes =[]
      this.nombresIntegrantes =[]
      var nombres = [];
      var ids = [];
      if(this.checkIntegrantes!== null && this.checkIntegrantes.length>0){
        for(var i=0;i<this.checkIntegrantes.length;i++){
          var nombre = this.checkIntegrantes[i].split('<->')[1];
          var id = this.checkIntegrantes[i].split('<->')[0];
          nombres.push(nombre)
          ids.push(id)
        }
      }
      this.nombresIntegrantes = nombres;//simplemente para mostrar los nombres seleccionados
      this.ids = ids;
    },
    crearEAD(accion) {
      if(!this.nombre_ead){ return alert("Favor de agregar Nombre de EAD")}
      if(!this.select_planta){ return alert("Seleccione Planta")}
      if(!this.select_area){ return alert("Seleccione Área")}
      if(!this.select_proceso){ return alert("Seleccione Proceso")}
      if(!this.select_lider_equipo){ return alert("Seleccione Líder de Equipo")}
      if(!this.select_coordinador){ return alert("Seleccione Coordinador")}
      if(!this.select_jefe_area){ return alert("Seleccione Jefe de Área")}
      if(!this.select_ing_proceso){ return alert("Seleccione Ing. de Proceso")}
      if(!this.select_ing_calidad){ return alert("Seleccione Ing. de Cálidad")}
      if(!this.select_supervisor){ return alert("Seleccione Supervisor")}
      if(this.checkIntegrantes.length<7){return alert ("Minimo 7 Integranes")}


      axios.post("crud_ead.php", {
        accion: accion,
        nombre: this.nombre_ead,
        planta: this.select_planta,
        area: this.select_area,
        proceso: this.select_proceso,
        lider: this.select_lider_equipo,
        coordinador: this.select_coordinador,
        jefe_area: this.select_jefe_area,
        ing_proceso: this.select_ing_proceso,
        ing_calidad: this.select_ing_calidad,
        supervisor: this.select_supervisor,
        ids_integrantes:this.ids,
        idEquipo:this.idEquipo
      }).then(response => {
        //console.log(response.data)
        if (response.data[0][0] !== true) {alert("los datos no se guardaron correctamente");return;}
        if(accion=="actualizar"){
          if (response.data[0][1] !== true ||response.data[0][2] !== true ) {alert("los datos no se guardaron correctamente");return;}
        }
          alert("Se guardo con Éxito")
          this.var_actualizarEAD = false;
          this.nombre_ead = ''
          this.select_planta= ''
          this.select_area= ''
          this.select_proceso= ''
          this.select_lider_equipo= ''
          this.select_coordinador= ''
          this.select_jefe_area= ''
          this.select_ing_proceso= ''
          this.select_ing_calidad= ''
          this.select_supervisor= ''
          this.idsIntegrantes =[]
          this.nombresIntegrantes =[]
          this.ids =[]
          this.checkIntegrantes = []
          this.consultarEAD();
        
      }).catch(error => {
        alert("Axios CrearEAD :-(" + error)
      })
    },
    datosParaEditarEAD(id_equipo,index){

     console.log("ID EAD: "+id_equipo)
       this.idEquipo = id_equipo
      this.idsIntegrantes =[]
      this.nombresIntegrantes =[]
      this.ids =[]
      this.checkIntegrantes = []
      this.var_actualizarEAD = true;
      this.nombre_ead = this.consultaEAD[index][0].nombre_ead
      this.select_planta= this.consultaEAD[index][0].planta
      this.select_area= this.consultaEAD[index][0].area
      this.select_proceso= this.consultaEAD[index][0].proceso
      this.select_lider_equipo= this.consultaEAD[index][0].lider_equipo
      this.select_coordinador= this.consultaEAD[index][0].coordinador
      this.select_jefe_area= this.consultaEAD[index][0].jefe_area
      this.select_ing_proceso= this.consultaEAD[index][0].ing_procesos
      this.select_ing_calidad= this.consultaEAD[index][0].ing_calidad
      this.select_supervisor= this.consultaEAD[index][0].supervisor
      var arregloColaboradores = [];
      this.integrantesEAD[id_equipo].forEach(function(element){
        //console.log(element.id+'<->'+element.colaborador)
        arregloColaboradores.push(element.id+'<->'+element.colaborador);
      });
      this.checkIntegrantes = arregloColaboradores; //actualizo el check con los integrantes del equipo
      this.seleccionadosIntegrantes() //lo llamo para recuperar ids y nombres
    },
    cancelarActualizar(){
      this.var_actualizarEAD = false;
      this.nombre_ead = ''
      this.select_planta= ''
      this.select_area= ''
      this.select_proceso= ''
      this.select_lider_equipo= ''
      this.select_coordinador= ''
      this.select_jefe_area= ''
      this.select_ing_proceso= ''
      this.select_ing_calidad= ''
      this.select_supervisor= ''
      this.idsIntegrantes =[]
      this.nombresIntegrantes =[]
      this.ids =[]
      this.checkIntegrantes = []
    },
    eliminarEquipo(id_equipo,nombre){
      console.log(id_equipo)
      if(!confirm("Desea Eliminar el EAD con nombre: "+nombre)){return} 
      axios.post("crud_ead.php",{
        id_equipo:id_equipo,
        accion:'eliminar'
      }).then(response =>{
        console.log(response.data);
        if(response.data[0][0]!=true || response.data[0][1]!=true){return "No se elimino correctamente el equipo"}
        alert("Se elimino correctamente");
        this.consultarEAD();
      }).catch(error =>{
        console.log("Error en axios: "+error)

      })
    },
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////CREAR COMPETENCIAS/////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    consultarForos(){// se activa cuando selecciono una area
      //console.log(this.select_planta_foro+" "+this.select_area_foro)
          axios.get("competenciasController.php",{
            params: {
              accion:'Consultar'
            }
          }).then(response =>{
            console.log(response.data);
            if(response.data[0]==true){
              this.foros = response.data[1];
            }else{
              console.log("error en la consulta de foros")
            }
            //this.EADFiltrado = response.data[0];
          }).catch(error =>{
            console.log("Error en axios: "+error)
          })
    },
    consultarPlantasEADs(){//Se activa al seleccionar la opcion de crear competencias
      axios.post("crud_ead.php",{
           accion:'consultarPlantasEADs',
       }).then(response =>{
         console.log(response.data);
         this.plantasEADs = response.data[4].plantas;
       }).catch(error =>{
         console.log("Error en axios: "+error)
       })
    },
    cosultarEADxArea(){ //se activa cuando selecciono una Planta
      this.EADFiltrado = [];
      this.select_area_foro = "";
      axios.post("crud_ead.php",{
           accion:'consultarAreasEADs',
           planta:this.select_planta_foro,
       }).then(response =>{
         console.log(response.data);
         this.areasEADs = response.data[4].areas;
       }).catch(error =>{
         console.log("Error en axios: "+error)
       })
    },
    cosultarEADxPlantaxArea(){// se activa cuando selecciono una area
      //console.log(this.select_planta_foro+" "+this.select_area_foro)
      if(this.select_planta_foro !="" &&  this.select_area_foro !=""){
          axios.get("competenciasController.php",{
            params: {
              accion:'Filtrar',
              planta:this.select_planta_foro,
              area:this.select_area_foro
            }
          }).then(response =>{
            //console.log(response.data);
            this.EADFiltrado = response.data[0];
          }).catch(error =>{
            console.log("Error en axios: "+error)
          })
      }
    },
    modalEvaluadores(accion){
      this.accion_evaluador = accion
      if(accion == 'Crear'){
        //limpio el formulario
        this.nombre_evaluador = ''
        this.nomina_evaluador = ''
        this.contrasena_evaluador = ''
        this.correo_evaluador = ''
        this.myModal = new bootstrap.Modal(document.getElementById('modal_evaluadores'));
        this.myModal.show();
      }

      if(accion=='Actualizar'){
        console.log(this.ckeckEvaluadores)
        if(this.ckeckEvaluadores.length==1){
          this.myModal = new bootstrap.Modal(document.getElementById('modal_evaluadores'));
          this.myModal.show();
          var id_evaluador = this.ckeckEvaluadores[0]
          var objetoEncontrado = this.evaluadores.find(function(objeto) {//busco el id en el objeto para asigar los datos
            return objeto.id === id_evaluador;
          });
          if (objetoEncontrado) {
            console.log("SE ENCONTRO",objetoEncontrado);
            this.nombre_evaluador = objetoEncontrado.nombre
            this.nomina_evaluador = objetoEncontrado.nomina
            this.contrasena_evaluador = objetoEncontrado.contrasena
            this.correo_evaluador = objetoEncontrado.correo
          } else {
            alert("Problemas para actulizar al Evaluador")
          }
        }else if(this.ckeckEvaluadores.length>1){
          alert("Solo se puedo actulizar 1 evaluador, no varios a la vez.")
        }else{
          alert("Selecciona un evaluador para actulizarlo.")
        }
      }
    },
    consultarEvaludores(){
      axios.post("insertar_actualizar_eliminar_evaluador.php",{
        accion: 'consultar'
      }).then(response => {
        console.log(response.data)
        this.evaluadores = response.data;
      }).catch(error =>{
        console.log("Algo salio mal en Axios: "+error);
      })
    },
    guardarEvaluador(accion){// insertar y guardar
      var id_evaluador;
      if(accion=="actualizar"){
        id_evaluador = parseInt(this.ckeckEvaluadores[0]);
      }
      if(this.nombre_evaluador=='' || this.nomina_evaluador=='' || this.contrasena_evaluador == '' || this.correo_evaluador == ''){return alert("No deje campos vacios")}
      axios.post("insertar_actualizar_eliminar_evaluador.php",{
        nombre:this.nombre_evaluador,
        nomina:this.nomina_evaluador,
        contrasena:this.contrasena_evaluador,
        correo:this.correo_evaluador,
        accion: accion,
        id_evaluador:id_evaluador

      }).then(response => {
        if(response.data==true){
            alert("Operación realizada con éxito");
            this.consultarEvaludores()
            this.nombre_evaluador = ''
            this.nomina_evaluador = ''
            this.contrasena_evaluador = ''
            this.correo_evaluador = ''
            this.myModal.hide();
        }else{
          alert("Algo salio mal")
        }
      }).catch(error =>{
          console.log("error en axios: "+error)
      })
    },
    eliminarEvaluador(){// insertar y guardar
      if(this.ckeckEvaluadores.length==1){
        if(!confirm("Seguro que desea eliminar este evaluador?")){return}
        axios.post("insertar_actualizar_eliminar_evaluador.php",{
          accion: 'eliminar',
          id_evaluador:this.ckeckEvaluadores[0]
        }).then(response => {
          if(response.data==true){
              alert("Se elimino con éxito");
              this.ckeckEvaluadores = []
              this.consultarEvaludores()
          }else{
            alert("No se puede eliminar, cuenta con evaluaciones realizadas.")
          }
        }).catch(error =>{
            console.log("error en axios: "+error)
        })
      }else if(this.ckeckEvaluadores.length<=0){
        alert("Seleccion un Evaluador para eliminar")
      }else if(this.ckeckEvaluadores.length>1){
        alert("Solo se puedo eliminar 1 evaluador, no varios a la vez.")
      }
    },
    crearForo(){
      if(!this.nombre_foro){return alert("Agregue el nombre al foro")}
      if(!this.select_planta_foro){return alert("Seleccione Planta")}
      if(!this.select_area_foro){return alert("Seleccione Área")}
      if(!this.fecha_foro){return alert("Seleccione una Fecha")}
      if(this.ckeckEADForo.length<=0){return alert("Seleccione los EAD's")}
      if(this.ckeckEvaluadores.length<=0){return alert("Seleccione Evaluadores")}

      axios.post("competenciasController.php",{
        accion:"CrearForo",
        nombre_foro:this.nombre_foro,
        planta:this.select_planta_foro,
        area:this.select_area_foro,
        fecha:this.fecha_foro,
        ids_ead:this.ckeckEADForo,
        evaluadores:this.ckeckEvaluadores
      }).then(response =>{
        console.log("Crear Foro",response.data)
        if (response.data[0][0] !== true) {
          return alert("Algo salio mal");
        } else if (response.data[0][1] !== true) {
          return alert("Algo salio mal");
        } else if (response.data[0][2] !== true) {
          return alert("Algo salio mal");
        } else {
          this.nombre_foro = "";
          this.select_planta_foro = "";
          this.select_area_foro = "";
          this.fecha_foro = "";
          this.ckeckEADForo = [];
          this.ckeckEvaluadores = [];
          this.EADFiltrado = [];
          alert("Foro guardado correctamente.");
          this.consultarForos()
        }

      }).catch(error =>{
        console.log("error en axios: CrearForo(): "+error);
      });
    },
    modalForosDetalles(nombre){
      this.myModal = new bootstrap.Modal(document.getElementById('modal_foros_detalles')); 
      this.myModal.show();
      this.tituloModal = nombre;
    },
    consultarDetallesForo(id){
      axios.get("competenciasController.php",{
        params:{
          accion:"DetallesForo",
          id:id
        }
      }).then(response=>{
        if(response.data){
          console.log('Cosulta Foro',response.data);
          if(response.data[0]==true){
            this.eadsForo= response.data[1];
              if(response.data[2]==true){
                this.evaluadoresForo= response.data[3];
                    if(response.data[4]==true){
                      this.calificacionEvaluadorForo= response.data[5];

                          const valoresSuma =  this.eadsForo.map(objeto => parseFloat((objeto.suma/this.evaluadoresForo.length).toFixed(2)));
                          var suma =0;
                          for (let i = 0; i < valoresSuma.length; i++) {
                            const element = valoresSuma[i];
                              suma += element;
                          }
                          //console.log(suma)
                          this.promedioCalificaciones = parseFloat((suma.toFixed(2))/this.eadsForo.length).toFixed(2);

                    }else{
                      console.log("error en la consulta de calificacion por evaluador"+response.data[4]);
                    }
              }else{
                console.log("error en la consulta de evaluadores por foro"+response.data[3]);
              }
          }else{
            console.log("Error en la consulta Detalle Foro. Error: ", response.data[0]);
          }
        }
      }).catch(error=>{
          console.log("Error en axios "+error)
      })
    },
     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////EVALUAR/////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    consultarCompetenciaIDevaluador(){
      axios.get("evaluarController.php",{
        params:{
          accion: 'IDEvaluador'
        }
      }).then(response=>{
        console.log(response.data)
        if(response.data[0]==true){
          this.equiposEvaluador = response.data[1];
        }else{
          console.log("Error en la consulta IDEvaluador "+response.data[0])
        }
      }).catch(error=>{
        console.log("Error en axios: "+error)
      });
    },
    modalPreguntas(nombre_equipo){
      this.mensaje = ''
      this.myModal = new bootstrap.Modal(document.getElementById('modalEvaluacion'));
      this.myModal.show();
      this.tituloModal = nombre_equipo;
    },
    IDCalifiacion(id_calificacion,id_ead_foro){//varible que utilizare para insertar la calificacion en tabla calificacion con el ID 
      this.id_calificacion = id_calificacion;
      this.id_ead_foro = id_ead_foro;
    },
    consultarPreguntasEvaluador(id_ead_foro){
      axios.get("evaluacionPreguntasController.php",{
        params:{
          accion:'preguntasEvaluador',
          id_ead_foro: id_ead_foro
        }
      }).then(response => {
        console.log('Preguntas',response.data);
        if(response.data[0]==true){
          this.preguntas_evaluar = response.data[1];
          this.datosEvaluar = response.data[2];
          this.examenFinalizado = response.data[4];

          let sumaPuntosMaximos = 0;
          let sumaPuntosReales = 0;
          let sumaPonderacion = 0;
          let calificacion = 0;

            // Iteramos sobre las claves del objeto datosEvaluar
            for (let etapa in this.datosEvaluar) {
                sumaPuntosMaximos += this.datosEvaluar[etapa].puntos_maximos;
                sumaPuntosReales += this.datosEvaluar[etapa].puntos_reales;
                sumaPonderacion += this.datosEvaluar[etapa].ponderacion;
            }  
            this.sumaPuntosMaximos = sumaPuntosMaximos;
            this.sumaPuntosReales = sumaPuntosReales;
            this.sumaPonderacion= sumaPonderacion;

            calificacion = (((sumaPuntosReales/sumaPuntosMaximos)*sumaPonderacion/100)*100).toFixed(2)
            this.calificacionEAD = calificacion;
         //this.etapas_preguntas = response.data = response.data[2];
        }else{
          console.log("Algo no salio bien en la consulta");
        }
      }).catch(error=>{
          console.log('Error axios'+error)
      })
    },
    guardarValor(id_pregunta,id_ead_foro,valor){
    
     switch (valor) {
        case 0:
          this.mensaje = "0: No Cumplimiento (La pregunta no se abordó en absoluto)."
        break;
        case 1:
          this.mensaje = "1: Cumplimiento Mínimo (Se abordó superficialmete, insuficiente y poco clara)."
        break;
        case 2:
          this.mensaje = "2: Cumplimiento Básico (Se abordó de manera mínima, carece de detalles)."
        break;
        case 3:
          this.mensaje = "3: Cumplimiento Satisfactorio (Se abordó adecuadamente, respuesta clara y completa, pero sin destacar)."
        break;
        case 4:
          this.mensaje = "4: Cumplimiento Notable (Se abordó de manera excelente, respuesta detallada y esfuerzo adicional)."
        break;
        case 5:
          this.mensaje = "5: Excelencia (Se abordó de manera excepcional, respuesta sobresaliente, creativa y original)."
     
      default:
        break;
     }
      this.title = 

      axios.post("evaluacionPreguntasController.php",{
        id_pregunta:id_pregunta,
        id_ead_foro:id_ead_foro,
        valor:valor
      }).then(response => {
        //console.log("GUARDAR PREGUNTA",response.data)
        if(response.data[0]==true){
          //console.log("Se guardo: "+id_pregunta)
          this.consultarPreguntasEvaluador(id_ead_foro)// para actualizar la calificacion tiempo real pero es pesado.
        }else{
          console.log("Algo no salio al guardar");
        }
      }).catch(error=>{
          console.log('Error axios'+error)
      })
    },
    enviarCalificacion(){
      console.log("IDCalificaicon",this.id_calificacion);
      console.log("Calificacion",this.calificacionEAD);
      axios.put("evaluacionPreguntasController.php",{
        id_calificacion:this.id_calificacion,
        calificacionEAD:this.calificacionEAD,
      }).then(response => {
        //console.log('ENVIANDO CALIFICACION',response.data)
        if(response.data[0]==true){
          alert("La Calificación fue Guardada Correctamente!");
          this.myModal.hide();
          this.consultarCompetenciaIDevaluador();
        }else{
          console.log("Algo no salio al guardar");
        }
      }).catch(error=>{
          console.log('Error axios'+error)
      })
    },
    contestarEvaluacion(){
        alert("Favor de contestar todas las preguntas")
    },
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////INICIO DE LAS FUNCIONES/////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    tablaGraficas(index, valor) {

      this.arreglo[index] = valor
      //console.log('tablaGraficas');

      const ctx = document.getElementById('myChart');

      if (!ctx) {
        console.error("No se pudo obtener la referencia al elemento canvas.");
        return;
      }

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
          datasets: [{
            label: 'Rechazos',
            data: this.arreglo,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

    },
    graficasEAD() {
      if (this.tipoTabla == 'Rechazos') {
        this.insertandoValores(0)
      } else if (this.tipoTabla == 'Merma') {
        this.insertandoValores(0)
      }


    },

    insertandoValores(index) {
      //console.log(index)
      var valor = parseFloat(document.getElementById('graficaRechazo' + index).value) || 0;
      //console.log("index:" + index)
      //console.log("valor:" + valor)
      //console.log(arreglo)
      this.datosGraficaRechazo[index] = valor;
      this.sumarDatosGraficas()
      document.getElementById('myChart').remove();
      // Crea un nuevo elemento canvas
      var newCanvas = document.createElement('canvas');
      newCanvas.id = 'myChart';
      // Agrega el nuevo elemento al DOM (por ejemplo, como un hijo de algún contenedor)
      var container = document.getElementById('divCanvas'); // Reemplaza 'container' con el ID de tu contenedor
      container.appendChild(newCanvas);

      this.tablaGraficas(index, valor)
    },

    sumarDatosGraficas() {
      this.sumaTabla = this.datosGraficaRechazo.reduce((total, valor) => total + valor, 0);
    }

  }
};


const App = Vue.createApp(app);

App.mount("#app");


////////////////////////////////////////////// chartjs para crear graficas
