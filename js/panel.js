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
      arreglo: [],
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
        ////////////////////////////////////////////////////////////////////////////////////*GESTION DE SESSION*/
      myModal:'',
      login:false,
      agregar_compromiso: false,
      actualizar_compromiso: false,
      existeImagenSeleccionada: false,
      documento_session:[],
      random:'',
      compromisos:[],
      compromiso:'',
      fecha_compromiso:'',
      select_session_equipo:'',
      select_etapa:'',
      select_fase:'',
      fases_etapa:'',
      fecha_session:'',
      integrantes_EADXid:[],
      EADIntegrantes:[],
      IDsIntegrantes:[],
      planta:'',
      area:'',
      asistieron:[],
      seguimiento_session:[],
      fases_seleccionadas:[],
      fases_usadas:[],
      porcentaje:[10,20,30,40,50,60,80,90,100],
      faseUsadaEnOtroSeguimiento:[],
      input_actualizar:'',
      actualizar_session:false,
      index_session_actualizar:'',
      id_gestion_session:'',
      cantidadFasesP:'',
      cantidadFasesD:'',
      cantidadFasesC:'',
      cantidadFasesA:'',
      sumaFasesP:'',
      sumaFasesD:'',
      sumaFasesC:'',
      sumaFasesA:'',
      llevaP:0,
      faltaP:100,
      llevaD:0,
      faltaD:100,
      llevaC:0,
      faltaC:100,
      llevaA:0,
      faltaA:100,
      
      //////////////////////////////////////////////////////////////////////////////////////**PREGUNTAS*/

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
      input_nombre_proyecto:[],
      editar_nombre_proyecto:'',
      id_foro:'',
      responsable_compromiso:'',
      compromiso_status:0,
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
      etapas:'',
      ////////////////////////////////////////////////////////////////////////////////////*GRAFICAS*/
      anio_grafica:'',
      mes_grafica:'',
      grafica: 'Rechazos',
      anios: [2024,2025,2026,2027,2028,2029,2030,2031,2032,2033,2034,2035],
      equipo_grafica:'',
      numerosTablas: [15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 'DIA'],
      numerosTablas2: [1, 2],
      numerosTablas3: [150, 145, 140, 135, 130, 125, 120, 115, 110, 105, 100, 95, 90, 85, 80, 'DIA'],
      nuneroTablasEficiencia: ['130%', '120%', '110%', '100%', '90%', '80%', '70%', '60%', '50%', '40%', '30%', '20%', '10%', '0%', 'DIA'],
      numeroTablasAccidentes: [5, 4, 3, 2, 1, 'DIA'],
      numeroTablasActosInseguros: [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 'DIA'],
      numeroTablasProyectos: [100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 0, 'DIA'],
      tipoTabla: ['Rechazos', 'Merma', 'Eficiencia', 'Accidentes', 'Actos Inseguros', 'Ausentismo', 'Cumplimiento del proyecto'],
      tipoTablas: '',
      clasificaciones: ['ITEM', 'CAUSA', 'CANTIDAD'],
      datosDiasMerma: ["20", 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
      sumaTabla: 0,
      datosGraficaRechazo: [],
      datosGraficaMerma: [],
      datosGraficaEficiencia: [],
      datosGraficaAccidentes: [],
      datosGraficaActosInseguros: [],
      datosGraficaAusentismo: [],
      datosGraficaCumplimientoProyecto: [],
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
    /*/////////////////////////////////////////////////////////////////////////////////PREGUNTAS*/
    consultarPreguntas(){
      axios.get('preguntasController.php',{
      

      }).then((response)=>{
        console.log("Preguntas",response.data)
      }).catch(error => {
        console.log("Error en axios :-("+error);
      }).finally({

      });
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
    /*cicloAnios() {
      for (let i = 2023; i < 2050; i++) {
        this.anios.push(i)
      }
    },*/
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
    ///////////////////////////////////////////////GESTION DE SESIONES////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    modalDocumentoGestionSession(){
      this.myModal = new bootstrap.Modal(document.getElementById("modal"));
      this.myModal.show();
    },
    buscarDocumentos(){
      var id = this.select_session_equipo.split('<->')[0];
      axios.post("buscar_documentos.php", {
        id_equipo:id
      }).then(response => {
            this.documento_session = response.data
            if (this.documento_session.length > 0) {
              console.log(this.documento_session + "Archivos encontrados.")
              this.random = Math.random()
            } else {
              console.log(this.documento_session + "Sin imagen encontrada.")
            }
        })
        .catch(error => {
          console.log(error);
        });
    },
    uploadFile() {
      this.login = true
      var id = this.select_session_equipo.split('<->')[0];

      let formData = new FormData();
      var files = this.$refs.ref_imagen.files;
      var totalfiles = this.$refs.ref_imagen.files.length;
    
      for (var index = 0; index < totalfiles; index++) {
        formData.append("files[]", files[index]);//arreglo de documentos_seguimiento
      }
      formData.append("id_equipo", id);
      axios.post("subir_documento.php", formData,
        {
          headers: { "Content-Type": "multipart/form-data" }
        }).then(response => {
          console.log(response.data);
          if(response.data.length>0){
                this.documento_session = response.data;
                  if (this.documento_session.length > 0) {
                    document.getElementById("input_file_seguimiento").value = ""
                    this.existeImagenSeleccionada = false;
                    this.random = Math.random()
                  }
          }else{
            this.login = false
            alert("Verifique la extension del archivo o Intente nuevamente.")
          }
        })
        .catch(error => {
          this.login = false
          console.log(error);
        }).finally(() => {
          this.login = false
        });
    },
    eliminarDocumento(ruta){

      var ruta = ruta;
      var partes = ruta.split("/");
      var nombreArchivo = partes[partes.length - 1];

      Swal.fire({
        //title: "Desea eliminar el registro?",
        html: "<label>Esta seguro de eliminar el archivo! <b>"+nombreArchivo+"</b></label>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed){
            axios.post("eliminar_documento.php",{
              ruta_eliminar: ruta
              }).then( reponse=>{
              console.log(reponse)
              if(reponse.data=="Archivo Eliminado"){
                alert("Archivo/Documento Eliminado con Éxito")
                this.buscarDocumentos()
              }else if(reponse.data=="No Eliminado"){
                  alert("Algo no salio bien no se logro Eliminar.")
              }else{
                  alert("Error al eliminar el Documento.")
              }
            }).catch(error =>{
              console.log("Error :-("+error)
            })
        }
      });

     }, 
    varificandoSelecionSeguimiento() {
      var imagen_seleccion = document.getElementById('input_file_seguimiento').value;
      if (imagen_seleccion != null) {
        this.existeImagenSeleccionada = true;
      }
    },
    consultarCantidadFaseXEtapas(){
       axios.get("avanceFaseController.php",{
          params:{
            accion:"consultarFases",
          }
        }).then(response =>{
          if(!response.data[0]==true){
            return "No se logro contar la cantidad de fase por etapa"+console.log(response.data[0]);
          } 
           console.log('TotalFasesXetapa',response.data)
           this.cantidadFasesP = response.data[1][0].cantidad
           this.cantidadFasesD = response.data[1][1].cantidad 
           this.cantidadFasesC = response.data[1][2].cantidad
           this.cantidadFasesA = response.data[1][3].cantidad
        }).catch(error =>{
            console.log("Error en axios :-("+error);
        }).finally({

        })
    },
    circulosPDCA(){
      //P
      const ctxP = document.getElementById('pdcaP');
      if (!ctxP) {
        console.error("No se obtuvo elemento pdcs.");
        return;
      }

      // Destruye el gráfico existente si ya existe
      let existingChart = Chart.getChart(ctxP);
      if (existingChart) {
        existingChart.destroy();
      }

      
      const dataP = {
        labels: [
         // 'Green',
         // 'White',
        ],
        datasets: [{
          label: [],
          data: [this.llevaP, this.faltaP],
          backgroundColor: [
            'rgb( 26, 193, 54 )',
            'rgb(255, 255, 255)',
          ],
          borderColor: [
            'rgb(26, 193, 54)',
          ],
          borderWidth: 1,
          hoverOffset: 4
        }]
      };

      new Chart(ctxP, {
        type: 'doughnut',
        data: dataP,
        options: {
          plugins: {},
          layout: {
              padding: {
                  bottom: 10, // Ajusta este valor según sea necesario
              }
          }
      }
      });

          //D
          const ctxD = document.getElementById('pdcaD');
          if (!ctxD) {
            console.error("No se obtuvo elemento pdcs.");
            return;
          }

          // Destruye el gráfico existente si ya existe
          let existingChartD = Chart.getChart(ctxD);
          if (existingChartD) {
            existingChartD.destroy();
          }

          
          const dataD = {
            labels: [
             // 'Green',
             // 'White',
            ],
            datasets: [{
              label: [],
              data: [this.llevaD, this.faltaD],
              backgroundColor: [
                'rgb( 26, 193, 54 )',
                'rgb(255, 255, 255)',
              ],
              borderColor: [
                'rgb(26, 193, 54)',
              ],
              borderWidth: 1,
              hoverOffset: 4
            }]
          };
          new Chart(ctxD, {
            type: 'doughnut',
            data: dataD,
            options: {
              plugins: {},
              layout: {
                  padding: {
                      bottom: 10, // Ajusta este valor según sea necesario
                  }
              }
          }
          });

          //C
          const ctxC = document.getElementById('pdcaC');
          if (!ctxC) {
            console.error("No se obtuvo elemento pdcs.");
            return;
          }

          
          // Destruye el gráfico existente si ya existe
          let existingChartC = Chart.getChart(ctxC);
          if (existingChartC) {
            existingChartC.destroy();
          }

          const dataC = {
            labels: [
             // 'Green',
             // 'White',
            ],
            datasets: [{
              label: [],
              data: [this.llevaC, this.faltaC],
              backgroundColor: [
                'rgb( 26, 193, 54 )',
                'rgb(255, 255, 255)',
              ],
              borderColor: [
                'rgb(26, 193, 54)',
              ],
              borderWidth: 1,
              hoverOffset: 4
            }]
          };
          new Chart(ctxC, {
            type: 'doughnut',
            data: dataC,
            options: {
              plugins: {},
              layout: {
                  padding: {
                      bottom: 10, // Ajusta este valor según sea necesario
                  }
              }
          }
          });

          //A
          const ctxA = document.getElementById('pdcaA');
          if (!ctxA) {
            console.error("No se obtuvo elemento pdcs.");
            return;
          }

          // Destruye el gráfico existente si ya existe
          let existingChartA = Chart.getChart(ctxA);
          if (existingChartA) {
            existingChartA.destroy();
          }

          
          const dataA = {
            labels: [
             // 'Green',
             // 'White',
            ],
            datasets: [{
              label: [],
              data: [this.llevaA, this.faltaA],
              backgroundColor: [
                'rgb( 26, 193, 54 )',
                'rgb(255, 255, 255)',
              ],
              borderColor: [
                'rgb(26, 193, 54)',
              ],
              borderWidth: 1,
              hoverOffset: 4
            }]
          };
          new Chart(ctxA, {
            type: 'doughnut',
            data: dataA,
           options: {
              plugins: {},
              layout: {
                  padding: {
                      bottom: 10, // Ajusta este valor según sea necesario
                  }
              }
          }
          });
    },
    porcetajeTotal(){
      var porcentaje = ((this.llevaP+this.llevaD+this.llevaC+this.llevaA)/4).toFixed(2)
      return  porcentaje > 0 ? porcentaje + '%' : '0%';
    },
    tomarDiaActual(){
      var fechaActual = new Date();
      var dia = fechaActual.getDate().toString().padStart(2, '0');
      var mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0'); // Se suma 1 porque los meses van de 0 a 11
      var año = fechaActual.getFullYear();
      var fechaFormateada = año + '-' + mes + '-' + dia;
      this.fecha_session = fechaFormateada;
      
      if(this.select_session_equipo!=''){
          this.buscarDocumentos()
      }
      
      setTimeout(()=>{
        this.circulosPDCA()
      },300)
      
    },
    /*modalCompromisos(){
      this.myModal = new bootstrap.Modal(document.getElementById("modal_compromisos"));
      this.myModal.show();
    },
    modalAsitencia(){
      this.myModal = new bootstrap.Modal(document.getElementById("modal_asistencia"));
      this.myModal.show();
    },*/
    consultarEADXID(){
      var id = this.select_session_equipo.split('<->')[0];
      this.planta_ead = this.select_session_equipo.split('<->')[2];
      this.area_ead = this.select_session_equipo.split('<->')[3];
      axios.post('crud_ead.php', {
          accion:'consutarEAD',
          id_ead:id
      }).then(response =>{
        if(response.data[0][0]!=true && response.data[0][1]!=true){
            return console.log(response.data)
        }else{
          this.EADIntegrantes = response.data[3];
          this.IDsIntegrantes = response.data[3].map(integrante => integrante.id);
          this.asistieron = response.data[3].map(integrante => integrante.id);
          this.tomarDiaActual()
        }
      }).catch(error =>{
        console.log("Erro en axios"+ error)
      })
    },
    consultarAvanceEtapas(){
      axios.get('avanceEtapasController.php', {
        params:{
          accion:'Consultar'
        }
      }).then(response =>{
          console.log('Etapas',response.data)
          if(response.data[0]==true){
            this.etapas=response.data[1];
          }else{
            console.log("Error en la consulta");
          }
      }).catch({

      })
    },
    consultarFaseXetapaSeleccionada(){
      this.fases_seleccionadas =[];
      var id = this.select_etapa.split('<->')[0];
      axios.get("avanceFaseController.php",{
        params:{
          accion:"ConsultarXIDEtapa",
          id_etapa:id
        }
      }).then(response =>{
          if(response.data[0]!=true){ return console.log(response.data);}
          this.fases_etapa = response.data[1];
          this.select_fase = ""

      }).catch(error =>{
          console.log("Error en axios :-("+error);
      }).finally({

      })
    },
    fasesUtilizadas(){
       //buscado todas las fases ya usadas de esa etapa
       var tamanio=this.seguimiento_session.length
       var arregloSeguimiento=this.seguimiento_session
       var fasesUsadas= [];
 
       var id = this.select_etapa.split('<->')[0];
       for (let i = 0; i < tamanio; i++) {
         if(JSON.parse(arregloSeguimiento[i].etapa)[0]===id){
          fasesUsadas = fasesUsadas.concat(JSON.parse(arregloSeguimiento[i].fase));
         }
       }
       this.fases_usadas = fasesUsadas
       //this.fases_seleccionadas = fasesUsadas;
    },
    faseUsada(fase){
      if(this.actualizar_session){
        return this.faseUsadaEnOtroSeguimiento.includes(fase);
      }else{
        return this.fases_usadas.includes(fase);
      }
    },
    consultarSeguimientoSession(){
      var id_equipo = this.select_session_equipo.split('<->')[0];
      axios.get("gestionSesionesController.php",{
        params:{
          accion:"ConsultarSeguimiento",
          id_equipo:id_equipo
        }
      }).then(response =>{
        //console.log("Tomando las Etapas",response.data[1].map(datos=>datos.etapa))
        if(response.data[0]==true){
            this.seguimiento_session = response.data[1];
            console.log("Seguimiento",response.data[1])
            var seguimiento = response.data[1]
            var suma1 = 0;var suma2 = 0;var suma3 = 0;var suma4 = 0;
            for (let i = 0; i < seguimiento.length; i++) {
              if(parseInt(JSON.parse(seguimiento[i].etapa)[0])===1){//P Que se llevan
                suma1+=JSON.parse(seguimiento[i].fase).length
              }
              if(parseInt(JSON.parse(seguimiento[i].etapa)[0])===2){//D Que se llevan
                suma2+=JSON.parse(seguimiento[i].fase).length
              }
              if(parseInt(JSON.parse(seguimiento[i].etapa)[0])===3){//C Que se llevan
                suma3+=JSON.parse(seguimiento[i].fase).length
              }
              if(parseInt(JSON.parse(seguimiento[i].etapa)[0])===4){//A Que se llevan
                suma4+=JSON.parse(seguimiento[i].fase).length
              }
             //console.log("PARSEANDO"+i,parseInt(JSON.parse(seguimiento[i].etapa)[0]))
            }

            this.sumaFasesP=suma1
            this.sumaFasesD=suma2
            this.sumaFasesC=suma3
            this.sumaFasesA=suma4

            var valorMaximo = 100
            this.llevaP = parseFloat((100 / this.cantidadFasesP * this.sumaFasesP).toFixed(2));
            this.llevaD = parseFloat((100 / this.cantidadFasesD * this.sumaFasesD).toFixed(2));
            this.llevaC = parseFloat((100 / this.cantidadFasesC * this.sumaFasesC).toFixed(2));
            this.llevaA = parseFloat((100 / this.cantidadFasesA * this.sumaFasesA).toFixed(2));
            

            this.faltaP=valorMaximo - this.llevaP
            this.faltaD=valorMaximo - this.llevaD
            this.faltaC=valorMaximo - this.llevaC
            this.faltaA=valorMaximo - this.llevaA
            
            this.circulosPDCA()
            this.fasesUtilizadas()
        }else{
          console.log("Error en la consulta"+response.data[0])
        }
      
      }).catch(error=>{
        console.log("Error en axios :-( "+error);
      })
    },
    convertirArregloFase(stringFases) {
      var arreglo = JSON.parse(stringFases);
        for (var i = 0; i < arreglo.length; i++) {
          arreglo[i] = arreglo[i].trim();
        }
        return arreglo;
    },

    guardarActualizarSession(accion){
      if(this.select_session_equipo==""){return Swal.fire({
                                          //title: "Guardado",
                                          text: "Favor de seleccionar un Equipo",
                                          icon: "question"
                                        });}
      if(this.select_etapa==""){return Swal.fire({
                                          //title: "Guardado",
                                          text: "Seleccione una Etapa",
                                          icon: "question"
                                        });}
      if(this.fases_seleccionadas.length<=0){return  Swal.fire({
                                            //title: "Guardado",
                                            text: "Seleccione minimo una Fase",
                                            icon: "question"
                                          });}
      if(this.fecha_session==""){return alert ("Seleccione Fecha")}

      var id_equipo = this.select_session_equipo.split('<->')[0];
      var porcentaje = (this.asistieron.length / this.IDsIntegrantes.length)*100;
      porcentaje = porcentaje.toFixed(2);

      var arregloEtapa = [];
      arregloEtapa [0] = this.select_etapa.split('<->')[0]
      arregloEtapa [1] = this.select_etapa.split('<->')[1]
      axios.post('gestionSesionesController.php', {
        accion:accion,
        id_gestion_session: this.id_gestion_session,
        id_equipo: id_equipo,
        fecha:this.fecha_session,
        etapa:arregloEtapa,
        fases:this.fases_seleccionadas,
        ids_integrantes: this.IDsIntegrantes,
        asistieron: this.asistieron,
        porcentaje: porcentaje,
      }).then(response =>{
         if(response.data==true){
              if(accion=="Guardar"){
                Swal.fire({
                  title: "Guardado",
                  text: "Registro guardado con éxito",
                  icon: "success"
                });
              }else if(accion=="Actualizar"){
                Swal.fire({
                  title: "Actualizado",
                  text: "Registro Actualizado con éxito",
                  icon: "success"
                });
              }
            this.reseteandoDatos()
            this.consultarSeguimientoSession()
         }else{
          alert("Problemas al guardar el Seguimiento");
          console.log("FALLO",response.data)
         }
      }).catch({

      })
    },
    
    tomandoEtapa(arregloIdEtapa){
      var arreglo = JSON.parse(arregloIdEtapa)//tomando unicamente etapa
     return arreglo[1];
    },
    actualizarSession(index,id_seguimiento){
      this.id_gestion_session =id_seguimiento;
      this.actualizar_session=true
      this.index_session_actualizar = index;
      console.log(this.seguimiento_session[index])
      this.asistieron = JSON.parse(this.seguimiento_session[index].asistencia)
      var IdEtapa = [];
      IdEtapa = JSON.parse(this.seguimiento_session[index].etapa)
      var id_etapa = IdEtapa[0]
      var etapa= IdEtapa[1]
      this.select_etapa=id_etapa+"<->"+etapa;
      console.log(this.asistieron)
      this.consultarFaseXetapaSeleccionada()
      this.fases_seleccionadas = JSON.parse(this.seguimiento_session[index].fase)

      var tamanio=this.seguimiento_session.length
      var arregloSeguimiento=this.seguimiento_session
      var fasesUsadas= [];

      var id = this.select_etapa.split('<->')[0];
      for (let i = 0; i < tamanio; i++) {
        if(JSON.parse(arregloSeguimiento[i].etapa)[0]===id){
         fasesUsadas = fasesUsadas.concat(JSON.parse(arregloSeguimiento[i].fase));
        }
      }
      var usadas = fasesUsadas
      var seleccionadas = this.fases_seleccionadas
        // Filtrar this.fases_seleccionadas eliminando los elementos que están presentes en this.fases_usadas

      const fases_seleccionadas_sin_coincidencias = usadas.filter(fase => !seleccionadas.includes(fase));
      this.faseUsadaEnOtroSeguimiento=fases_seleccionadas_sin_coincidencias
    },
    reseteandoDatos(){
      this.actualizar_session=false
      this.index_session_actualizar=''
      this.select_etapa = ''
      this.fases_seleccionadas =[];
      this.fases_etapa = [];
      this.tomarDiaActual()
      this.asistieron=this.EADIntegrantes.map(integrante=>integrante.id)
    },
    consultarCompromisos(){
          this.compromiso = ''
          this.fecha_compromiso = ''
          this.actualizar_compromiso = false;
          this.agregar_compromiso=false
          
      var id_equipo = this.select_session_equipo.split('<->')[0];
      axios.get('compromisosController.php', {
        params:{
          accion:'Consultar',
          id_equipo:id_equipo
        }
      }).then(response =>{
        console.log('Compromisos', response.data)
          if(response.data[0]==true && response.data[2]==true){
            this.compromisos=response.data[1];
          }else{
            console.log("Error en la consulta"+response.data);
          }
      }).catch({

      })
    },
    agregarCompromiso(){
      this.agregar_compromiso = true;
      this.compromiso = ''
      this.fecha_compromiso = ''
      this.responsable_compromiso =''
      this.input_actualizar = '',
      this.actualizar_compromiso = false
    },
    cancelarCompromiso(){
      this.compromiso = ''
      this.fecha_compromiso = ''
      this.responsable_compromiso =''
      this.agregar_compromiso=false
    },
    
    guardarCompromiso(){
      if(this.compromiso=='' || this.responsable_compromiso=='' || this.fecha_compromiso==''){return alert("Todos los campos de compromiso son requeridos.")}
      var id_equipo = this.select_session_equipo.split('<->')[0];
      axios.post("compromisosController.php",{
       id_equipo:id_equipo,
       compromiso:this.compromiso,
       responsable:this.responsable_compromiso,
       fecha:this.fecha_compromiso
      }).then(response =>{
        if(response.data==true){
          alert("Compromiso Guardado con Éxito.");
          this.compromiso = ''
          this.fecha_compromiso = ''
          this.consultarCompromisos();
        }else{
          console.log(response.data);
        }
      }).catch(error => {
        console.log("Error en axios:"+error);
      })
    },

    actualizandoCompromiso(id_compromiso){
      if(this.compromiso=='' ||this.responsable_compromiso=='' || this.fecha_compromiso==''){return alert("Todos los campos de compromiso son requeridos.")}
      axios.put("compromisosController.php",{
       accion:'Actualizar Compromiso',
       id_compromiso:id_compromiso,
       compromiso:this.compromiso,
       responsable:this.responsable_compromiso,
       fecha:this.fecha_compromiso
      }).then(response =>{
        console.log('Compromisos',response.data)
        if(response.data==true){
          alert("Compromiso Actualizado con Éxito.");
          this.compromiso = ''
          this.fecha_compromiso = ''
          this.actualizar_compromiso = false;
          this.consultarCompromisos();
        }else{
          console.log(response.data);
        }
      }).catch(error => {
        console.log("Error en axios:"+error);
      })
    },
    actualizarPorcentajeCompromiso(compromiso_id){
      var porcentaje = document.getElementById("selectPorcentaje"+compromiso_id).value;
      axios.put("compromisosController.php",{
        accion:'Actualizar Porcentaje',
        compromiso_id:compromiso_id,
        porcentaje:porcentaje
       }).then(response =>{
        //console.log(response.data)
         if(response.data==true){
           alert("Porcentaje actualizado con Éxito.");
           this.compromiso = ''
           this.fecha_compromiso = ''
           this.actualizar_compromiso = false;
           this.consultarCompromisos();
         }else{
           console.log(response.data);
         }
       }).catch(error => {
         console.log("Error en axios:"+error);
       })

    },
    actualizarCompromiso(index){
      this.actualizar_compromiso = true;
      this.agregar_compromiso=false
      this.input_actualizar = index  
      this.compromiso=this.compromisos[index-1].compromiso;
      this.responsable_compromiso=this.compromisos[index-1].id_responsable;
      this.fecha_compromiso=this.compromisos[index-1].fecha;
    },
    cancelarActualizarCompromiso(){
      this.compromiso = ''
      this.fecha_compromiso = ''
      this.actualizar_compromiso = false;
    },
    cambiarformato(fecha){
     var apart = fecha.split('-');
     return apart[2]+"/"+apart[1]+"/"+apart[0]
    },
    eliminarCompromiso(id_compromiso){
      Swal.fire({
        //title: "Desea eliminar el registro?",
        html: "<label>Esta seguro de eliminar este compromiso</label>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed){
          axios.delete("compromisosController.php",{
            params:{
              id_compromiso:id_compromiso
            }
            }).then(response =>{
                if(response.data==true){
                    Swal.fire({
                      title: "Eliminado",
                      text: "Se elimino con éxito",
                      icon: "success"
                    });
                  this.consultarCompromisos();
                }else{
                  console.log("No se logro eliminar"+ response.data)
                  Swal.fire({
                    title: "Mensaje",
                    text: "No se logro eliminar",
                    icon: "warning"
                  });
                }
            }).catch(err =>{
                console.log("Error en axios: "+err)
            })
        }
      });
    },
  
    eliminarGestionSession(id_session){

      Swal.fire({
        //title: "Desea eliminar el registro?",
        text: "Esta seguro de eliminar este registro!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
              //console.log(id_session)
              axios.delete("gestionSesionesController.php",{
                params : {
                    id_session:id_session
                }
              }).then(response=>{
                if(response.data==true){
                    Swal.fire({
                      //title: "Eliminado!",
                      text: "Registro Eliminado.",
                      icon: "success"
                    });
                    this.consultarSeguimientoSession()
                }else{
                    alert("Problemas al Eliminar");
                    console.log("Problema al eliminar",response.data);
                }
              }).catch(error=>{
                console.log("Error en axios"+error)
              })
        }
      });


      //if(!confirm("Esta seguro que desea eliminar este registro")){ return}

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
      this.id_foro = id;
      axios.get("competenciasController.php",{
        params:{
          accion:"DetallesForo",
          id:id
        }
      }).then(response=>{
        if(response.data){
          console.log('Consulta Foro',response.data);
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
                          this.editar_nombre_proyecto = ''; //la reseteo despues de la consulta para que el nombre se refleje sin un pequeño salto, si la borras no perjudica en el funcionanmiento
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
    estatusForo(id_foro,nombre_foro,estatus){
      var nuevoEstatus;
        if(estatus=="Abierto"){
          nuevoEstatus="Cerrado";
        }
        if(estatus=="Cerrado"){
          nuevoEstatus="Abierto";
        }
      //if(!confirm("El "+"'"+nombre_foro+"'"+" cambiará al estado: "+nuevoEstatus)){return}   
      axios.put("foroController.php",{
        id_foro:id_foro,
        nuevoEstatus:nuevoEstatus
      }).then(response =>{
          if(response.data!=true){return alert("Algo salio mal")}else{
            this.consultarForos();
          }
      }).catch(error =>{
          console.log(error)
      })
    },
    editarNombreProyecto(index){
      console.log(index)
      this.editar_nombre_proyecto = index
    },
    guardarNombreProyecto(id_ead_foro,index){
      var nuevo_nombre = document.getElementById("input"+index).value;
      axios.put("competenciasController.php",{
          accion:'',
          id_ead_foro:id_ead_foro,
          nombre_proyecto: nuevo_nombre
      }).then(response=>{
          console.log(response.data)
          if(response.data==true){
            this.consultarDetallesForo(this.id_foro)
            
          }else{
            alert("No se guardo el nombre del Proyecto");
          }
      }).catch({

      }).finally({
        
      });
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
    ///////////////////////////////////////////////GRAFICAS/////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    diasDelMesAnio(){
      var anio
      var mes
        console.log(this.anio_grafica+''+this.mes_grafica)
        if(this.anio_grafica!='' && this.mes_grafica!=''){
          if(this.mes_grafica=='Enero'){mes = 1}
          if(this.mes_grafica=='Febrero'){mes = 2}
          if(this.mes_grafica=='Marzo'){mes = 3}
          if(this.mes_grafica=='Abril'){mes = 4}
          if(this.mes_grafica=='Mayo'){mes = 5}
          if(this.mes_grafica=='Junio'){mes = 6}
          if(this.mes_grafica=='Julio'){mes = 7}
          if(this.mes_grafica=='Agosto'){mes = 8}
          if(this.mes_grafica=='Septiembre'){mes = 9}
          if(this.mes_grafica=='Octubre'){mes = 10}
          if(this.mes_grafica=='Noviembre'){ mes = 11}
          if(this.mes_grafica=='Diciembre'){mes = 12}
          
          anio = this.anio_grafica;
          var ultimoDiaMes = new Date(anio, mes, 0);
          return ultimoDiaMes.getDate()
        }
    },  
    tablaGraficas() {
      setTimeout(()=>{
       var datos = [];
       console.log("RECHAZOS",this.datosGraficaRechazo.length)
        if(this.tipoTablas=='Rechazos'){
          datos = this.datosGraficaRechazo
        }else if(this.tipoTablas=='Merma'){
          datos = this.datosGraficaMerma
        }else if(this.tipoTablas=='Eficiencia'){
          datos = this.datosGraficaEficiencia
        }else if(this.tipoTablas=='Accidentes'){
          datos = this.datosGraficaAccidentes
        }else if(this.tipoTablas=='Actos Inseguros'){
          datos = this.datosGraficaActosInseguros
        }else if(this.tipoTablas=='Ausentismo'){
          datos = this.datosGraficaAusentismo
        }else if(this.tipoTablas=='Cumplimiento del proyecto'){
          datos = this.datosGraficaCumplimientoProyecto
        }
        console.log("Tabla: ",this.tipoTablas,"datos: ",datos)
        const ctx = document.getElementById('myChart');
        if (!ctx) {
          console.error("No se pudo obtener la referencia al elemento canvas.");
          return;
        }

        // Destruye el gráfico existente si ya existe
        let existingChart = Chart.getChart(ctx);
        if (existingChart) {
          existingChart.destroy();
        }

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
            datasets: [{
              label: this.tipoTablas,
              data: datos,
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              },
              x: {
                beginAtZero: true
              }
            }
          }
        });
      },200)
    },
    consultadoValoresGrafica(){
     if(this.tipoTablas && this.equipo_grafica && this.anio_grafica && this.mes_grafica){
      var mes;
      if(this.mes_grafica=='Enero'){mes = 1}
      if(this.mes_grafica=='Febrero'){mes = 2}
      if(this.mes_grafica=='Marzo'){mes = 3}
      if(this.mes_grafica=='Abril'){mes = 4}
      if(this.mes_grafica=='Mayo'){mes = 5}
      if(this.mes_grafica=='Junio'){mes = 6}
      if(this.mes_grafica=='Julio'){mes = 7}
      if(this.mes_grafica=='Agosto'){mes = 8}
      if(this.mes_grafica=='Septiembre'){mes = 9}
      if(this.mes_grafica=='Octubre'){mes = 10}
      if(this.mes_grafica=='Noviembre'){ mes = 11}
      if(this.mes_grafica=='Diciembre'){mes = 12}


      var id_equipo = this.equipo_grafica.split('<->')[0];
        axios.get("graficasController.php",{
          params:{
            grafica:this.tipoTablas,
            id_equipo:id_equipo,
            anio:this.anio_grafica,
            mes:mes
          }
        }).then(response =>{
          //console.log("consulta grafica",response.data)
          if(response.data[0]==true){
              const nuevoArreglo = [];
              response.data[1].forEach(valores => {
                  nuevoArreglo[(valores.dia-1)] = valores.valor;//la resto ya que el arreglo empieza en 0
              });
              if(this.tipoTablas=='Rechazos'){
                this.datosGraficaRechazo = nuevoArreglo
              }else if(this.tipoTablas=='Merma'){
                this.datosGraficaMerma = nuevoArreglo
              }else if(this.tipoTablas=='Eficiencia'){
                this.datosGraficaEficiencia = nuevoArreglo
              }else if(this.tipoTablas=='Accidentes'){
                this.datosGraficaAccidentes = nuevoArreglo
              }else if(this.tipoTablas=='Actos Inseguros'){
                this.datosGraficaActosInseguros = nuevoArreglo
              }else if(this.tipoTablas=='Ausentismo'){
                this.datosGraficaAusentismo = nuevoArreglo
              }else if(this.tipoTablas=='Cumplimiento del proyecto'){
                this.datosGraficaCumplimientoProyecto = nuevoArreglo
              }
              this.tablaGraficas()

          }else{
            console.log("Algo salio mal al consultar los datos de la grafica")
          }
        }).catch(error =>{
          console.log("Error en axios :-("+error)
        })
     }
    },
    insertandoValores(index){
      var valor = 0;
      if(this.tipoTablas=='Rechazos'){
        valor = parseFloat(document.getElementById('graficaRechazo' + index).value);
        this.datosGraficaRechazo[index] = valor;
        this.sumaTabla = this.datosGraficaRechazo.reduce((total, valor) => total + valor, 0);
      }else if(this.tipoTablas=='Merma'){
        valor = parseFloat(document.getElementById('graficaMerma' + index).value);
        this.datosGraficaMerma[index] = valor;
        this.sumaTabla = this.datosGraficaMerma.reduce((total, valor) => total + valor, 0);
      }else if(this.tipoTablas=='Eficiencia'){
        valor = parseFloat(document.getElementById('graficaEficiencia' + index).value);
        this.datosGraficaEficiencia[index] = valor;
        this.sumaTabla = this.datosGraficaEficiencia.reduce((total, valor) => total + valor, 0);
      }else if(this.tipoTablas=='Accidentes'){
        valor = parseFloat(document.getElementById('graficaAccidentes' + index).value);
        this.datosGraficaAccidentes[index] = valor;
        this.sumaTabla = this.datosGraficaAccidentes.reduce((total, valor) => total + valor, 0);
      }else if(this.tipoTablas=='Actos Inseguros'){
        valor = parseFloat(document.getElementById('graficaActosInseguros' + index).value);
        this.datosGraficaActosInseguros[index] = valor;
        this.sumaTabla = this.datosGraficaActosInseguros.reduce((total, valor) => total + valor, 0);
      }else if(this.tipoTablas=='Ausentismo'){
        valor = parseFloat(document.getElementById('graficaAusentismo' + index).value);
        this.datosGraficaAusentismo[index] = valor;
        this.sumaTabla = this.datosGraficaAusentismo.reduce((total, valor) => total + valor, 0);
      }else if(this.tipoTablas=='Cumplimiento del proyecto'){
        valor = parseFloat(document.getElementById('graficaCumplimiento' + index).value);
        this.datosGraficaCumplimientoProyecto[index] = valor;
        this.sumaTabla = this.datosGraficaCumplimientoProyecto.reduce((total, valor) => total + valor, 0);
      }
      
        var dia = (index+1)
        this.saveDateDay(dia,valor)
    },
    saveDateDay(dia,valor){
      var mes;
      if(this.mes_grafica=='Enero'){mes = 1}
      if(this.mes_grafica=='Febrero'){mes = 2}
      if(this.mes_grafica=='Marzo'){mes = 3}
      if(this.mes_grafica=='Abril'){mes = 4}
      if(this.mes_grafica=='Mayo'){mes = 5}
      if(this.mes_grafica=='Junio'){mes = 6}
      if(this.mes_grafica=='Julio'){mes = 7}
      if(this.mes_grafica=='Agosto'){mes = 8}
      if(this.mes_grafica=='Septiembre'){mes = 9}
      if(this.mes_grafica=='Octubre'){mes = 10}
      if(this.mes_grafica=='Noviembre'){ mes = 11}
      if(this.mes_grafica=='Diciembre'){mes = 12}

       var id_equipo = this.equipo_grafica.split('<->')[0];
       var nombre_ead = this.equipo_grafica.split('<->')[1];
       var planta = this.equipo_grafica.split('<->')[2];
       var area = this.equipo_grafica.split('<->')[3];
       
        axios.post("graficasController.php",{
          planta: planta,
          area: area,
          id_equipo: id_equipo,
          nombre_ead: nombre_ead,
          grafica: this.tipoTablas,
          anio: this.anio_grafica,
          mes: mes,
          dia: dia,
          valor:valor
        }).then(response=>{
          if(response.data==true){
                Swal.fire({
                  title: "Guardado",
                  text: "Se guardo con éxito",
                  icon: "success"
                });
          }else{
            console.log("Datos Guardados"+response.data)
          }
          this.tablaGraficas()
        }).catch(error=>{
            console.log(error)
        }).finally(()=>{

        })
    },

  }
};


const App = Vue.createApp(app);

App.mount("#app");

