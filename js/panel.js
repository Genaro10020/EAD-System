var arreglo = [];
const app = {
  data() {
    return {
      verMenu: 'Si',
      /*/////////////////////////////////////////////////////////////////////////////////VARIBLES USUARIOS Y DEPARTAMENTOS INICIO*/
      var_actualizarEAD: false,
      tipo_usuario: '',
      ventana: 'Usuarios',
      accion: 'insertar',
      loading: true,
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
      evaluadores: [],
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
      nombresIntegrantes: [],
      idsIntegrantes: [],
      consultaEAD: [],
      integrantesEAD: [],
      idEquipo: [],
      buscar_colaborador: '',
      ocultar_mostar_estrella: 'none',
      lider_anterior: '',
      equipoAsignarTabla: [],
      criterioAsignar: [],
      seleccionarAcceso: [],
      id_equipo_tabla: '',
      ////////////////////////////////////////////////////////////////////////////////////*GESTION DE SESSION*/
      myModal: '',
      login: false,
      agregar_compromiso: false,
      actualizar_compromiso: false,
      existeImagenSeleccionada: false,
      documento_session: [],
      random: '',
      compromisos: [],
      compromiso: '',
      fecha_compromiso: '',
      select_session_equipo: '',
      select_etapa: '',
      select_fase: '',
      fases_etapa: '',
      fecha_session: '',
      integrantes_EADXid: [],
      EADIntegrantes: [],
      IDsIntegrantes: [],
      planta: '',
      area: '',
      asistieron: [],
      seguimiento_session: [],
      fases_seleccionadas: [],
      fases_usadas: [],
      porcentaje: [10, 20, 30, 40, 50, 60, 80, 90, 100],
      faseUsadaEnOtroSeguimiento: [],
      input_actualizar: '',
      actualizar_session: false,
      index_session_actualizar: '',
      id_gestion_session: '',
      cantidadFasesP: '',
      cantidadFasesD: '',
      cantidadFasesC: '',
      cantidadFasesA: '',
      sumaFasesP: '',
      sumaFasesD: '',
      sumaFasesC: '',
      sumaFasesA: '',
      llevaP: 0,
      faltaP: 100,
      llevaD: 0,
      faltaD: 100,
      llevaC: 0,
      faltaC: 100,
      llevaA: 0,
      faltaA: 100,
      nombre_colaborador: '',
      nomina_colaborador: '',
      planta_colaborador: '',
      nueva_causa: false,
      actualizar_causa: '',
      nombre_indicador: '',
      tipo_unidad: '',
      linea_base: '',
      entitlement: '',
      meta_calculada: '',
      meta_retadora: '',
      anio_kpi: '',
      semana_kpi: '',
      semanas_anio: '',
      dato_semanal: '',
      seguimientoKPIs: [],
      datoGrafica_LineaBase: 0,
      datoGrafica_Entitlement: 0,
      datoGrafica_MetaCalculada: 0,
      datoGrafica_MetaRetadora: 0,
      datoGrafica_dato: 0,
      datoGrafica_semana_mes: 'Semana',
      datoGrafica_semana: '',
      checkMes: false,
      mes_cierre: '',
      mes_cierre_anterior: '',
      leyedasGafica: [],
      datosGrafica: [],
      actualizar_kpi: false,
      actualizar_datoKPI: false,
      idUpdateDatoKPI: '',
      justasArranque: [],
      seguimiento_completado:0,
      seleccion_eds_areas:'',
      //////////////////////////////////////////////////////////////////////////////////////**PREGUNTAS*/

      //////////////////////////////////////////////////////////////////////////////////////**CREAR COMPENTENCIAS */
      foros: [],
      EADFiltrado: [],
      areasEADs: [],
      plantasEADs: [],
      nombre_foro: '',
      select_planta_foro: '',
      select_area_foro: '',
      fecha_foro: '',
      ckeckEADForo: [],
      ckeckEvaluadores: [],
      accion_evaluador: '',
      nombre_evaluador: '',
      nomina_evaluador: '',
      contrasena_evaluador: '',
      correo_evaluador: '',
      id_evaluador: '',
      posicion_evaluador: '',
      tituloModal: '',
      eadsForo: [],
      evaluadoresForo: [],
      calificacionEvaluadorForo: [],
      sum: 0,
      promedioCalificaciones: 0,
      input_nombre_proyecto: [],
      editar_nombre_proyecto: '',
      id_foro: '',
      responsable_compromiso: '',
      compromiso_status: 0,
      foroGlobal: 'false',
      //////////////////////////////////////////////////////////////////////////////////////*EVALUAR*/
      equiposEvaluador: [],
      etapas_preguntas: '',
      preguntas_evaluar: '',
      selectedOption: null,
      datosEvaluar: [],
      total_maximos: 0,
      sumaPuntosMaximos: 0,
      sumaPuntosReales: 0,
      sumaPonderacion: 0,
      calificacionEAD: 0,
      id_ead_foro: '',
      id_calificacion: '',
      mensaje: '',
      examenFinalizado: '',
      etapas: '',
      comentario: '',
      contestado: [],
      //////////////////////////////////////////////////////////////////////////////////////*EVALUAR*/
      equipo_score: '',
      ////////////////////////////////////////////////////////////////////////////////////*GRAFICAS*/
      anio_grafica: '',
      mes_grafica: '',
      grafica: 'Rechazos',
      anios: [2024, 2025, 2026, 2027, 2028, 2029, 2030, 2031, 2032, 2033, 2034, 2035],
      equipo_grafica: '',
      numerosTablas: [15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 'DIA'],
      numerosTablas2: [1, 2],
      numerosTablas3: [150, 145, 140, 135, 130, 125, 120, 115, 110, 105, 100, 95, 90, 85, 80, 'DIA'],
      nuneroTablasEficiencia: ['130%', '120%', '110%', '100%', '90%', '80%', '70%', '60%', '50%', '40%', '30%', '20%', '10%', '0%', 'DIA'],
      numeroTablasAccidentes: [5, 4, 3, 2, 1, 'DIA'],
      numeroTablasActosInseguros: [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 'DIA'],
      numeroTablasProyectos: [100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 0, 'DIA'],
      criterioGrafica: [],
      idCriterioGrafica: '',
      clasificaciones: ['ITEM', 'CAUSA', 'CANTIDAD'],
      datosDiasMerma: ["20", 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
      sumaTabla: 0,
      sumasDinamicasSC: [],
      sumaTablaRechazo: 0,
      sumaTablaMerma: 0,
      sumaTablaEficiencia: 0,
      sumaTablaAccidentes: 0,
      sumaTablaActosInseguros: 0,
      sumaTablaActosAusentismo: 0,

      datosGrafica: [],
      datosGraficaMerma: [],
      datosGraficaEficiencia: [],
      datosGraficaAccidentes: [],
      datosGraficaActosInseguros: [],
      datosGraficaAusentismo: [],
      datosGraficaCumplimientoProyecto: [],
      responsable_causa: '',
      causa: '',
      dia_grafica: 1,
      causas: [],
      tGrafica: '',
      nombreDelCriterio: '',
      ////////////////////////////////////////////////////////////////////////////////////*COMPETENCIA PLACAS*/
      filasCP: ['UP', 'Planta', 'Posicion', 'EADs', 'Proyecto', 'Evaluador', 'Calificacion final', 'Posicion final'],
      ////////////////////////////////////////////////////////////////////////////////////*PONDERACION*/
      //filasSC: ['Rechazos', 'Merma y desperdicio', 'Eficiencia', 'Accidentes', 'Actos inseguros', 'PB de sangre', 'Ausentismo', '5´s', 'Sugerencias de mejora', 'Cumplimiento de proyecto'],//filas ScoreCard y Ponderación
      filasSC: [],
      nueva_ponderacion: false,
      nombre_ponderacion: '',
      newRechazo: false,
      newMerma: false,
      newEficiencia: false,
      newAccidentes: false,
      newActosInseguros: false,
      newPB: false,
      newAusentismo: false,
      new5s: false,
      newSugerencias: false,
      newCumplimiento: false,
      ponderaciones: [],
      tablasPonderaciones: [],
      valoresPon: "",
      inputDesactivado: '',
      inputNewName: '',
      tablasPonderacionesIDs: [],
      equipoPonderacion: false,
      criterios: [],
      datosTablaPonderacion: [],
      inputValorActual: [],
      puntosObtenidosInput: [],
      puntosObtenidos: [],
      tipo_criterio: 'Gráfica',
      nombre_nuevo_criterio: '',
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
      columnasSC: ['Unidades', 'Valor actual', 'Puntos obtenidos', 'Ponderación', 'Puntos evaluados'],
      asistenciaSC: 0,
      asistenciaPuntosCumplimiento: '',
      mes_score: '',
      anio_score: '',
      ponderacion_score: '',
      rechazosSC: 0,
      mermaSC: 0,
      eficienciaSC: 0,
      accidentesSC: 0,
      actosInsegurosSC: 0,
      ausentismoSC: 0,
      cumplimientoSC: 0,
      listaPonderaciones: [],
      puntosRechazo: 0,
      puntosMerma: 0,
      puntosEficiencia: 0,
      puntosAccidentes: 0,
      puntosActosInseguros: 0,
      puntosAusentismo: 0,
      puntosAsistencia: 0,
      inputPonderacionSC: '',
      inputColumnaPonderacion: [],
      inputPuntoEvaluados: [],
      criteriosDinamicasSC: [],
      puntosCriterios: [],
      puntosEvaluacion: [],
      totalSC: '',
      nombrePonderacionAsignada: '',
      scoreCardCompletado: '',
      consultaEADparaFiltrar:[],
      id_actual:'',
      promMermayDesperdicio:'',
      tamArregloMermaYDesp: '',
      totalGuardar:'',
      guardarptsOBT: [],
      datoNuevo: '',
      valorB:'',
      cumplimiento_scorecard:[],
      anioConsultar:'',
      areaConsultar:'',
      guardoNuevoDato:false,
      //PUNTAJES POR MES Y ANIO DE BATEO
      mes_bateo:'',
      anio_bateo:'',
      equiposConMasDe850:'',
      porcentajeArribaDe850:'',
      equiposPorMes:''
    }
  },
  mounted() {
    this.consultarUsuarios()
    this.ventanaSegunTipoUsuario()//tomo datos de session
    window.addEventListener('popstate', () => {
      window.history.forward();
      this.cerrarModalHistorial()
    });
  },
  methods: {
    cerrarModalHistorial() {
      this.myModal.hide();
    },
    /*/////////////////////////////////////////////////////////////////////////////////TIPOS ACCESO*/
    ventanaSegunTipoUsuario() {
      document.getElementById('app').style = "display:none;"
      axios.post("datos_user.php", {
      }).then(response => {
        document.getElementById('app').style = "display:block;"
        this.tipo_usuario = response.data[0]
        if (response.data[0] == "Evaluador") {
          this.ventanas('Evaluar');
          this.consultarCompetenciaIDevaluador();
        } else if (response.data[0] == "Coordinador") {
          this.ventanas('Gestion Sesiones');
          this.consultarEAD()
          this.consultarAvanceEtapas()
          this.tomarDiaActual()
          this.consultarCantidadFaseXEtapas()
        } else if (response.data[0] == "Colaborador") {
          this.ventanas('Graficas');
          this.consultarEADColaborador()
        } else {
          //Admin
        }
      }).catch(error => {
        console.log('Error en  axios tipoUser ' + error);
      }).finally(() => {
        this.loading = false;
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
      this.selector_area = '';
      this.ventana = ventana
      this.consultarUsuarios()
    },

    /*/////////////////////////////////////////////////////////////////////////////////CONSULTA COLABORADORS*/
    consultarColaboradores() {
      axios.post('consulta_Colaboradores.php', {
        buscar_colaborador: this.buscar_colaborador
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
      axios.put('insertar_actualizar_eliminar_usuario.php', {
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

    insertarArea(id_actual){ //para las ponderaciones anteriores que no se les insertaba automaticamente el area
      console.log('mi id es:', id_actual, this.selector_area)

      if(!confirm("¿Está seguro de que esta ponderación le corresponde?. Una vez que la seleccione, solo usted podrá ver esta ponderación.")){
        this.selector_area = '';
        return
      } 
      axios.put('ponderacionesController.php',{
        accion: "insertarArea",
        area: this.selector_area,
        id: id_actual
      }).then(response => {
        if(response.data == true){
          this.consultarPonderaciones();
          this.selector_area = '';
        }else{
          alert("No se logró insertar el area");
        }
      })
      //console.log('El area es:',this.selector_area)
    },


    /*      if (!confirm("¿Esta seguro que desea eliminar el usuario?")) return

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
      })*/

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
      this.verMenu = "Si"
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
        console.log(response.data)
        if (response.data == true) {
          this.myModal.hide()
          this.consultarUsuarios();
        } else {
          alert("No se actualizó correctamente :-(")
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
        console.log("Respuesta la eliminar", response.data)
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
    consultarPreguntas() {
      axios.get('preguntasController.php', {


      }).then((response) => {
        console.log("Preguntas", response.data)
      }).catch(error => {
        console.log("Error en axios :-(" + error);
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
    /*/////////////////////////////////////////////////////////////////////////////////CREACIÓN DE EQUIPOS DE ALTO DESEMPEÑO */
    consultarEAD() {
      axios.post("crud_ead.php", {
        accion: 'consultar'
      }).then(response => {
        //console.log("Consulta EAD",response.data)
        if (response.data[0][0] == true) {
          //this.consultaEAD =response.data[1]
          var numeros = Object.keys(response.data[1]).map(Number); //tomando los indices del objeto
          const comparar = (a, b) => b - a;// b es mayo que a positivo contrario negativo y si son iguales el resultado es 0
          const ordenando = numeros.sort(comparar) //metodo que me pemite hacer la comparacion de dos variables sort
          //console.log('Ordenando', ordenando); // [1, 2, 3, 4, 5]
          const nuevoOrden = ordenando.map(num => response.data[1][num.toString()]);
          //console.log('Nuevo Orden', nuevoOrden); // [1, 2, 3, 4, 5]
          this.consultaEAD = nuevoOrden;
          this.consultaEADparaFiltrar = nuevoOrden;
          if (response.data[0][1] == true) {
            this.integrantesEAD = response.data[3]
            //console.log("Integrantes EAD",this.integrantesEAD)
          } else {
            console.log("no se logro consultar los Integrantes EAD")
          }
        }
      }).catch(error => {
        console.log("Error en la consulta :-( " + error)
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
    seleccionadosIntegrantes() {
      this.ids = []
      this.idsIntegrantes = []
      this.nombresIntegrantes = []
      var nombres = [];
      var ids = [];
      if (this.checkIntegrantes !== null && this.checkIntegrantes.length > 0) {
        for (var i = 0; i < this.checkIntegrantes.length; i++) {
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
      if (!this.nombre_ead) { return alert("Favor de agregar Nombre de EAD") }
      if (!this.select_planta) { return alert("Seleccione Planta") }
      if (!this.select_area) { return alert("Seleccione Área") }
      if (!this.select_proceso) { return alert("Seleccione Proceso") }
      if (!this.select_coordinador) { return alert("Seleccione Coordinador") }
      if (!this.select_jefe_area) { return alert("Seleccione Jefe de Área") }
      if (!this.select_ing_proceso) { return alert("Seleccione Ing. de Proceso") }
      if (!this.select_ing_calidad) { return alert("Seleccione Ing. de Cálidad") }
      if (!this.select_supervisor) { return alert("Seleccione Supervisor") }
      if (this.checkIntegrantes.length < 7) { return alert("Minimo 7 Integrantes") }
      if (!this.select_lider_equipo) { return alert("Seleccione Líder de Equipo") }
      console.log('ID EQUIPO', this.idEquipo)
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
        ids_integrantes: this.ids,
        idEquipo: this.idEquipo,
        lider_anterior: this.lider_anterior
      }).then(response => {
        console.log('Guardar/ActualizarEAD:', response.data)
        if (response.data[0][0] !== true) { alert("los datos no se guardaron correctamente"); console.log(response.data); return; }
        if (accion == "actualizar") {
          if (response.data[0][1] !== true || response.data[0][2] !== true) { alert("los datos no se guardaron correctamente"); return; }
        }
        alert("Se guardo con Éxito")
        this.var_actualizarEAD = false;
        this.nombre_ead = ''
        this.select_planta = ''
        this.select_area = ''
        this.select_proceso = ''
        this.select_lider_equipo = ''
        this.select_coordinador = ''
        this.select_jefe_area = ''
        this.select_ing_proceso = ''
        this.select_ing_calidad = ''
        this.select_supervisor = ''
        this.idsIntegrantes = []
        this.nombresIntegrantes = []
        this.ids = []
        this.checkIntegrantes = []
        this.consultarEAD();

      }).catch(error => {
        alert("Axios CrearEAD :-(" + error)
      })
    },
    modalAsignarTabla(id_equipo) {
      this.verMenu = "No";
      this.myModal = new bootstrap.Modal(document.getElementById("modal_asignar_tabla"));
      this.myModal.show();
      this.equipoAsignarTabla = this.integrantesEAD[id_equipo];
      this.id_equipo_tabla = id_equipo;//asigno
      console.log(this.id_equipo_tabla)
      this.equipoAsignarTabla.map((elemento, index) => {
        if (elemento.id_grafica_acceso === null || elemento.id_grafica_acceso === "") {
          this.seleccionarAcceso[index] = "";
        } else {
          this.seleccionarAcceso[index] = elemento.id_grafica_acceso;
        }
      })
      this.consultarCriteriosParaAsignarColaborador(id_equipo);
    },
    datosParaEditarEAD(id_equipo, index) {

      var estrellas = document.querySelectorAll('[id^=estrella]');
      for (var i = 0; i < estrellas.length; i++) {
        estrellas[i].style.display = "none";
      }

      this.idEquipo = id_equipo
      this.idsIntegrantes = []
      this.nombresIntegrantes = []
      this.ids = []
      this.checkIntegrantes = []
      this.var_actualizarEAD = true;
      this.nombre_ead = this.consultaEAD[index][0].nombre_ead
      this.select_planta = this.consultaEAD[index][0].planta
      this.select_area = this.consultaEAD[index][0].area
      this.select_proceso = this.consultaEAD[index][0].proceso
      this.select_lider_equipo = this.consultaEAD[index][0].lider_equipo
      this.lider_anterior = this.consultaEAD[index][0].lider_equipo
      this.select_coordinador = this.consultaEAD[index][0].coordinador
      this.select_jefe_area = this.consultaEAD[index][0].jefe_area
      this.select_ing_proceso = this.consultaEAD[index][0].ing_procesos
      this.select_ing_calidad = this.consultaEAD[index][0].ing_calidad
      this.select_supervisor = this.consultaEAD[index][0].supervisor
      var arregloColaboradores = [];

      this.integrantesEAD[id_equipo].forEach(function (element) {
        //console.log(element.id+'<->'+element.colaborador)
        arregloColaboradores.push(element.id + '<->' + element.colaborador);
      });
      this.checkIntegrantes = arregloColaboradores; //actualizo el check con los integrantes del equipo
      this.seleccionadosIntegrantes() //lo llamo para recuperar ids y nombres
    },
    cancelarActualizar() {
      this.var_actualizarEAD = false;
      this.nombre_ead = ''
      this.select_planta = ''
      this.select_area = ''
      this.select_proceso = ''
      this.select_lider_equipo = ''
      this.select_coordinador = ''
      this.select_jefe_area = ''
      this.select_ing_proceso = ''
      this.select_ing_calidad = ''
      this.select_supervisor = ''
      this.idsIntegrantes = []
      this.nombresIntegrantes = []
      this.ids = []
      this.checkIntegrantes = []
    },
    eliminarEquipo(id_equipo, nombre) {
      console.log(id_equipo)
      if (!confirm("Desea Eliminar el EAD con nombre: " + nombre)) { return }
      axios.post("crud_ead.php", {
        id_equipo: id_equipo,
        accion: 'eliminar'
      }).then(response => {
        console.log(response.data);
        if (response.data[0][0] != true || response.data[0][1] != true) { return "No se elimino correctamente el equipo" }
        alert("Se elimino correctamente");
        this.consultarEAD();
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },
    mostrar(index) {
      if (this.select_lider_equipo == '') {
        document.getElementById('estrella' + index).style = "display:block;";
      }
    },
    ocultar(index) {
      if (this.select_lider_equipo == '') {
        document.getElementById('estrella' + index).style = "display:none";
      }

    },
    asignarLiderEquipo(index) {
      var estrellas = document.querySelectorAll('[id^=estrella]');
      for (var i = 0; i < estrellas.length; i++) {
        estrellas[i].style.display = "none";
      }

      document.getElementById('estrella' + index).style = "display:block;color:#e28a18";
      this.select_lider_equipo = this.checkIntegrantes[index]
    },
    asignarAccesoGrafica(id_integrante, index) {
      let id_criterio = this.seleccionarAcceso[index]
      axios.put("colaboradorController.php", {
        accion: "Asignar Acceso",
        id_ead: this.id_equipo_tabla,
        id_criterio: id_criterio,
        id_integrante: id_integrante
      }).then(response => {
        if (response.data == true) {
          this.consultarEAD()
        } else {
          console.log(response.data)
          alert("No se pudo asignar el acceso")
        }
      }).catch(error => {
        console.log("Error en axios :-(" + error)
      })
    },
    colaboradorDesmarcado(event, id_integrante) {
      if (this.var_actualizarEAD == true) {
        if (!event.target.checked) {
          axios.put("colaboradorController.php", {
            accion: "Desmarcar Acceso",
            id_ead: this.idEquipo,
            id_integrante: id_integrante
          }).then(response => {
            if (response.data == true) {
              this.consultarEAD()
            } else {
              alert("No se logro desvincular del acceso")
              console.log(response.data)
            }
          }).catch(error => {
            console.log("Error en axios :-(" + error)
          })
        }
      }
    },
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////GESTION DE SESIONES////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    uniqueAreas() {
      // Usamos Set para eliminar los duplicados
      const areasYPlantas = [...new Set(this.consultaEADparaFiltrar.flatMap(equipo => equipo[0].area))];
      // Devolver las áreas y plantas únicas
      return areasYPlantas;
    },
    filtrandoEADsGestion() {
      this.select_session_equipo = "";
      let areaSeleccionadaEAD = this.seleccion_eds_areas;
      // Filtra los equipos que coinciden con el área seleccionada
      if(areaSeleccionadaEAD==''){
        this.consultarEAD();
      }else{
        let resultado = this.consultaEADparaFiltrar.filter(equipo => equipo[0].area === areaSeleccionadaEAD);
        // Para ver los resultados en la consola
      console.log("Resultados filtrados", resultado);
      // Si necesitas actualizar una lista en el data con los resultados filtrados, puedes hacerlo aquí:
      this.consultaEAD = resultado;
      }
     
    
    },
    modalDocumentoGestionSession() {
      this.myModal = new bootstrap.Modal(document.getElementById("modal"));
      this.myModal.show();
    },
    buscarDocumentos() {
      var id = this.select_session_equipo.split('<->')[0];
      axios.post("buscar_documentos.php", {
        id_equipo: id
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
          if (response.data.length > 0) {
            this.documento_session = response.data;
            if (this.documento_session.length > 0) {
              document.getElementById("input_file_seguimiento").value = ""
              this.existeImagenSeleccionada = false;
              this.random = Math.random()
            }
          } else {
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
    eliminarDocumento(ruta) {

      var ruta = ruta;
      var partes = ruta.split("/");
      var nombreArchivo = partes[partes.length - 1];

      Swal.fire({
        //title: "Desea eliminar el registro?",
        html: "<label>Esta seguro de eliminar el archivo! <b>" + nombreArchivo + "</b></label>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post("eliminar_documento.php", {
            ruta_eliminar: ruta
          }).then(reponse => {
            console.log(reponse)
            if (reponse.data == "Archivo Eliminado") {
              alert("Archivo/Documento Eliminado con Éxito")
              this.buscarDocumentos()
            } else if (reponse.data == "No Eliminado") {
              alert("Algo no salio bien no se logro Eliminar.")
            } else {
              alert("Error al eliminar el Documento.")
            }
          }).catch(error => {
            console.log("Error :-(" + error)
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
    consultarCantidadFaseXEtapas() {
      axios.get("avanceFaseController.php", {
        params: {
          accion: "consultarFases",
        }
      }).then(response => {
        if (!response.data[0] == true) {
          return "No se logro contar la cantidad de fase por etapa" + console.log(response.data[0]);
        }
        console.log('TotalFasesXetapa', response.data)
        this.cantidadFasesP = response.data[1][0].cantidad
        this.cantidadFasesD = response.data[1][1].cantidad
        this.cantidadFasesC = response.data[1][2].cantidad
        this.cantidadFasesA = response.data[1][3].cantidad
      }).catch(error => {
        console.log("Error en axios :-(" + error);
      }).finally({

      })
    },
    circulosPDCA() {
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
    porcetajeTotal() {
      var porcentaje = ((this.llevaP + this.llevaD + this.llevaC + this.llevaA) / 4).toFixed(2)
      this.seguimiento_completado = porcentaje;
      return porcentaje > 0 ? porcentaje + '%' : '0%';
    },
    tomarDiaActual() {
      var fechaActual = new Date();
      var dia = fechaActual.getDate().toString().padStart(2, '0');
      var mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0'); // Se suma 1 porque los meses van de 0 a 11
      var año = fechaActual.getFullYear();
      var fechaFormateada = año + '-' + mes + '-' + dia;
      this.fecha_session = fechaFormateada;

      if (this.select_session_equipo != '') {
        this.buscarDocumentos()
      }

      setTimeout(() => {
        this.circulosPDCA()
      }, 300)

    },
    modalAltaColaborador() {
      this.myModal = new bootstrap.Modal(document.getElementById("modal_alta_colaborador"));
      this.myModal.show();
    },
    guardarNuevoColaborador() {
      if (this.nombre_colaborador == '' || this.nomina_colaborador == '' || this.planta_colaborador == '') { return alert("Todos los campos son requeridos") }
      axios.post('colaboradorController.php', {
        nombre: this.nombre_colaborador,
        nomina: this.nomina_colaborador,
        planta: this.planta_colaborador,
      }).then(response => {
        if (response.data == true) {
          this.nombre_colaborador = ''
          this.nomina_colaborador = ''
          this.planta_colaborador = ''
          this.myModal.hide();
          this.consultarColaboradores()
        } else {
          console.log(response.data)
        }

      }).catch(error => {
        console.log("Erro en axios" + error)
      })
    },
    todasMayusculas() {
      var texto = document.getElementById("nombre_colaborador").value;
      this.nombre_colaborador = texto.toUpperCase();
    },
    consultarEADXID() {
      var id = this.select_session_equipo.split('<->')[0];
      this.planta_ead = this.select_session_equipo.split('<->')[2];
      this.area_ead = this.select_session_equipo.split('<->')[3];
      axios.post('crud_ead.php', {
        accion: 'consutarEAD',
        id_ead: id
      }).then(response => {
        if (response.data[0][0] != true && response.data[0][1] != true) {
          return console.log(response.data)
        } else {
          this.EADIntegrantes = response.data[3];
          this.IDsIntegrantes = response.data[3].map(integrante => integrante.id);
          this.asistieron = response.data[3].map(integrante => integrante.id);
          this.tomarDiaActual()
          this.consultarSeguimientoKPI()
          this.consultarJuntasArranque()
        }
      }).catch(error => {
        console.log("Erro en axios" + error)
      })
    },
    consultarAvanceEtapas() {
      axios.get('avanceEtapasController.php', {
        params: {
          accion: 'Consultar'
        }
      }).then(response => {
        console.log('Etapas', response.data)
        if (response.data[0] == true) {
          this.etapas = response.data[1];
        } else {
          console.log("Error en la consulta");
        }
      }).catch({

      })
    },
    consultarFaseXetapaSeleccionada() {
      this.fases_seleccionadas = [];
      var id = this.select_etapa.split('<->')[0];
      axios.get("avanceFaseController.php", {
        params: {
          accion: "ConsultarXIDEtapa",
          id_etapa: id
        }
      }).then(response => {
        if (response.data[0] != true) { return console.log(response.data); }
        this.fases_etapa = response.data[1];
        this.select_fase = ""

      }).catch(error => {
        console.log("Error en axios :-(" + error);
      }).finally({

      })
    },
    fasesUtilizadas() {
      //buscado todas las fases ya usadas de esa etapa
      var tamanio = this.seguimiento_session.length
      var arregloSeguimiento = this.seguimiento_session
      var fasesUsadas = [];

      var id = this.select_etapa.split('<->')[0];
      for (let i = 0; i < tamanio; i++) {
        if (JSON.parse(arregloSeguimiento[i].etapa)[0] === id) {
          fasesUsadas = fasesUsadas.concat(JSON.parse(arregloSeguimiento[i].fase));
        }
      }
      this.fases_usadas = fasesUsadas
      //this.fases_seleccionadas = fasesUsadas;
    },
    faseUsada(fase) {
      if (this.actualizar_session) {
        return this.faseUsadaEnOtroSeguimiento.includes(fase);
      } else {
        return this.fases_usadas.includes(fase);
      }
    },
    consultarSeguimientoSession() {
      var id_equipo = this.select_session_equipo.split('<->')[0];
      axios.get("gestionSesionesController.php", {
        params: {
          accion: "ConsultarSeguimiento",
          id_equipo: id_equipo
        }
      }).then(response => {
        //console.log("Tomando las Etapas",response.data[1].map(datos=>datos.etapa))
        if (response.data[0] == true) {
          this.seguimiento_session = response.data[1];
          console.log("Seguimiento", response.data[1])
          var seguimiento = response.data[1]
          var suma1 = 0; var suma2 = 0; var suma3 = 0; var suma4 = 0;
          for (let i = 0; i < seguimiento.length; i++) {
            if (parseInt(JSON.parse(seguimiento[i].etapa)[0]) === 1) {//P Que se llevan
              suma1 += JSON.parse(seguimiento[i].fase).length
            }
            if (parseInt(JSON.parse(seguimiento[i].etapa)[0]) === 2) {//D Que se llevan
              suma2 += JSON.parse(seguimiento[i].fase).length
            }
            if (parseInt(JSON.parse(seguimiento[i].etapa)[0]) === 3) {//C Que se llevan
              suma3 += JSON.parse(seguimiento[i].fase).length
            }
            if (parseInt(JSON.parse(seguimiento[i].etapa)[0]) === 4) {//A Que se llevan
              suma4 += JSON.parse(seguimiento[i].fase).length
            }
            //console.log("PARSEANDO"+i,parseInt(JSON.parse(seguimiento[i].etapa)[0]))
          }

          this.sumaFasesP = suma1
          this.sumaFasesD = suma2
          this.sumaFasesC = suma3
          this.sumaFasesA = suma4

          var valorMaximo = 100
          this.llevaP = parseFloat((100 / this.cantidadFasesP * this.sumaFasesP).toFixed(2));
          this.llevaD = parseFloat((100 / this.cantidadFasesD * this.sumaFasesD).toFixed(2));
          this.llevaC = parseFloat((100 / this.cantidadFasesC * this.sumaFasesC).toFixed(2));
          this.llevaA = parseFloat((100 / this.cantidadFasesA * this.sumaFasesA).toFixed(2));


          this.faltaP = valorMaximo - this.llevaP
          this.faltaD = valorMaximo - this.llevaD
          this.faltaC = valorMaximo - this.llevaC
          this.faltaA = valorMaximo - this.llevaA

          this.circulosPDCA()
          this.fasesUtilizadas()
        } else {
          console.log("Error en la consulta" + response.data[0])
        }

      }).catch(error => {
        console.log("Error en axios :-( " + error);
      })
    },
    convertirArregloFase(stringFases) {
      var arreglo = JSON.parse(stringFases);
      for (var i = 0; i < arreglo.length; i++) {
        arreglo[i] = arreglo[i].trim();
      }
      return arreglo;
    },

    guardarActualizarSession(accion) {
      if (this.select_session_equipo == "") {
        return Swal.fire({
          //title: "Guardado",
          text: "Favor de seleccionar un Equipo",
          icon: "question"
        });
      }
      if (this.select_etapa == "") {
        return Swal.fire({
          //title: "Guardado",
          text: "Seleccione una Etapa",
          icon: "question"
        });
      }
      if (this.fases_seleccionadas.length <= 0) {
        return Swal.fire({
          //title: "Guardado",
          text: "Seleccione minimo una Fase",
          icon: "question"
        });
      }
      if (this.fecha_session == "") { return alert("Seleccione Fecha") }

      var id_equipo = this.select_session_equipo.split('<->')[0];
      var porcentaje = (this.asistieron.length / this.IDsIntegrantes.length) * 100;
      porcentaje = porcentaje.toFixed(2);

      var arregloEtapa = [];
      arregloEtapa[0] = this.select_etapa.split('<->')[0]
      arregloEtapa[1] = this.select_etapa.split('<->')[1]
      axios.post('gestionSesionesController.php', {
        accion: accion,
        id_gestion_session: this.id_gestion_session,
        id_equipo: id_equipo,
        fecha: this.fecha_session,
        etapa: arregloEtapa,
        fases: this.fases_seleccionadas,
        ids_integrantes: this.IDsIntegrantes,
        asistieron: this.asistieron,
        porcentaje: porcentaje,
      }).then(response => {
        if (response.data == true) {
          if (accion == "Guardar") {
            Swal.fire({
              title: "Guardado",
              text: "Registro guardado con éxito",
              icon: "success"
            });
          } else if (accion == "Actualizar") {
            Swal.fire({
              title: "Actualizado",
              text: "Registro Actualizado con éxito",
              icon: "success"
            });
          }
          this.reseteandoDatos()
          this.consultarSeguimientoSession()
        } else {
          alert("Problemas al guardar el Seguimiento");
          console.log("FALLO", response.data)
        }
      }).catch({

      })
    },

    tomandoEtapa(arregloIdEtapa) {
      var arreglo = JSON.parse(arregloIdEtapa)//tomando unicamente etapa
      return arreglo[1];
    },
    actualizarSession(index, id_seguimiento) {
      this.id_gestion_session = id_seguimiento;
      this.actualizar_session = true
      this.index_session_actualizar = index;
      console.log(this.seguimiento_session[index])
      this.asistieron = JSON.parse(this.seguimiento_session[index].asistencia)
      var IdEtapa = [];
      IdEtapa = JSON.parse(this.seguimiento_session[index].etapa)
      var id_etapa = IdEtapa[0]
      var etapa = IdEtapa[1]
      this.select_etapa = id_etapa + "<->" + etapa;
      console.log(this.asistieron)
      this.consultarFaseXetapaSeleccionada()
      this.fases_seleccionadas = JSON.parse(this.seguimiento_session[index].fase)

      var tamanio = this.seguimiento_session.length
      var arregloSeguimiento = this.seguimiento_session
      var fasesUsadas = [];

      var id = this.select_etapa.split('<->')[0];
      for (let i = 0; i < tamanio; i++) {
        if (JSON.parse(arregloSeguimiento[i].etapa)[0] === id) {
          fasesUsadas = fasesUsadas.concat(JSON.parse(arregloSeguimiento[i].fase));
        }
      }
      var usadas = fasesUsadas
      var seleccionadas = this.fases_seleccionadas
      // Filtrar this.fases_seleccionadas eliminando los elementos que están presentes en this.fases_usadas

      const fases_seleccionadas_sin_coincidencias = usadas.filter(fase => !seleccionadas.includes(fase));
      this.faseUsadaEnOtroSeguimiento = fases_seleccionadas_sin_coincidencias
    },
    reseteandoDatos() {
      this.actualizar_session = false
      this.index_session_actualizar = ''
      this.select_etapa = ''
      this.fases_seleccionadas = [];
      this.fases_etapa = [];
      this.tomarDiaActual()
      this.asistieron = this.EADIntegrantes.map(integrante => integrante.id)
    },
    consultarCompromisos() {
      this.compromiso = ''
      this.fecha_compromiso = ''
      this.actualizar_compromiso = false;
      this.agregar_compromiso = false

      var id_equipo = this.select_session_equipo.split('<->')[0];
      axios.get('compromisosController.php', {
        params: {
          accion: 'Consultar',
          id_equipo: id_equipo
        }
      }).then(response => {
        console.log('Compromisos', response.data)
        if (response.data[0] == true && response.data[2] == true) {
          this.compromisos = response.data[1];
        } else {
          console.log("Error en la consulta" + response.data);
        }
      }).catch({

      })
    },
    agregarCompromiso() {
      this.agregar_compromiso = true;
      this.compromiso = ''
      this.fecha_compromiso = ''
      this.responsable_compromiso = ''
      this.input_actualizar = '',
        this.actualizar_compromiso = false
    },
    cancelarCompromiso() {
      this.compromiso = ''
      this.fecha_compromiso = ''
      this.responsable_compromiso = ''
      this.agregar_compromiso = false
    },

    guardarCompromiso() {
      if (this.compromiso == '' || this.responsable_compromiso == '' || this.fecha_compromiso == '') { return alert("Todos los campos de compromiso son requeridos.") }
      var id_equipo = this.select_session_equipo.split('<->')[0];
      axios.post("compromisosController.php", {
        id_equipo: id_equipo,
        compromiso: this.compromiso,
        responsable: this.responsable_compromiso,
        fecha: this.fecha_compromiso
      }).then(response => {
        if (response.data == true) {
          alert("Compromiso Guardado con Éxito.");
          this.compromiso = ''
          this.fecha_compromiso = ''
          this.consultarCompromisos();
        } else {
          console.log(response.data);
        }
      }).catch(error => {
        console.log("Error en axios:" + error);
      })
    },
    actualizandoCompromiso(id_compromiso) {
      if (this.compromiso == '' || this.responsable_compromiso == '' || this.fecha_compromiso == '') { return alert("Todos los campos de compromiso son requeridos.") }
      axios.put("compromisosController.php", {
        accion: 'Actualizar Compromiso',
        id_compromiso: id_compromiso,
        compromiso: this.compromiso,
        responsable: this.responsable_compromiso,
        fecha: this.fecha_compromiso
      }).then(response => {
        console.log('Compromisos', response.data)
        if (response.data == true) {
          alert("Compromiso Actualizado con Éxito.");
          this.compromiso = ''
          this.fecha_compromiso = ''
          this.actualizar_compromiso = false;
          this.consultarCompromisos();
        } else {
          console.log(response.data);
        }
      }).catch(error => {
        console.log("Error en axios:" + error);
      })
    },
    actualizarPorcentajeCompromiso(compromiso_id) {
      var porcentaje = document.getElementById("selectPorcentaje" + compromiso_id).value;
      axios.put("compromisosController.php", {
        accion: 'Actualizar Porcentaje',
        compromiso_id: compromiso_id,
        porcentaje: porcentaje
      }).then(response => {
        //console.log(response.data)
        if (response.data == true) {
          alert("Porcentaje actualizado con Éxito.");
          this.compromiso = ''
          this.fecha_compromiso = ''
          this.actualizar_compromiso = false;
          this.consultarCompromisos();
        } else {
          console.log(response.data);
        }
      }).catch(error => {
        console.log("Error en axios:" + error);
      })

    },
    actualizarCompromiso(index) {
      this.actualizar_compromiso = true;
      this.agregar_compromiso = false
      this.input_actualizar = index
      this.compromiso = this.compromisos[index - 1].compromiso;
      this.responsable_compromiso = this.compromisos[index - 1].id_responsable;
      this.fecha_compromiso = this.compromisos[index - 1].fecha;
    },
    cancelarActualizarCompromiso() {
      this.compromiso = ''
      this.fecha_compromiso = ''
      this.actualizar_compromiso = false;
    },
    cambiarformato(fecha) {
      var apart = fecha.split('-');
      return apart[2] + "/" + apart[1] + "/" + apart[0]
    },
    eliminarCompromiso(id_compromiso) {
      Swal.fire({
        //title: "Desea eliminar el registro?",
        html: "<label>Esta seguro de eliminar este compromiso</label>",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete("compromisosController.php", {
            params: {
              id_compromiso: id_compromiso
            }
          }).then(response => {
            if (response.data == true) {
              Swal.fire({
                title: "Eliminado",
                text: "Se elimino con éxito",
                icon: "success"
              });
              this.consultarCompromisos();
            } else {
              console.log("No se logro eliminar" + response.data)
              Swal.fire({
                title: "Mensaje",
                text: "No se logro eliminar",
                icon: "warning"
              });
            }
          }).catch(err => {
            console.log("Error en axios: " + err)
          })
        }
      });
    },

    eliminarGestionSession(id_session) {
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
          axios.delete("gestionSesionesController.php", {
            params: {
              id_session: id_session
            }
          }).then(response => {
            if (response.data == true) {
              Swal.fire({
                //title: "Eliminado!",
                text: "Registro Eliminado.",
                icon: "success"
              });
              this.consultarSeguimientoSession()
            } else {
              alert("Problemas al Eliminar");
              console.log("Problema al eliminar", response.data);
            }
          }).catch(error => {
            console.log("Error en axios" + error)
          })
        }
      });
    },

    abriModalKPI() {
      this.actualizar_kpi = '';
      this.myModal = new bootstrap.Modal(document.getElementById("modalKPI"));
      this.myModal.show();
    },
    abriModalGraficaFullKPI() {
      this.myModal = new bootstrap.Modal(document.getElementById("modalGraficaKPI"));
      this.myModal.show();
      this.graficaKPI('canvaKPIFull')
    },
    tomarAnioActual() {
      var time = new Date();
      var year = time.getFullYear();
      this.anio_kpi = year
    },
    semanasAnio() {
      const date = new Date(this.anio_kpi, 0, 1);
      const day = date.getDay();
      const daysInYear = 365 + (this.anio_kpi % 4 === 0 ? 1 : 0) + (this.anio_kpi % 100 === 0 ? 0 : 1) + (this.anio_kpi % 400 === 0 ? 1 : 0);
      this.semanas_anio = Math.ceil((daysInYear - day + 4) / 7);
    },
    convertirDecimal(variable) {
      console.log("llego: ", variable);
      var valor = this[variable];
      if (typeof valor === 'string') {
        valor = valor.replace(/[^0-9.]/g, '');
      } else {
        valor = valor.toString();
      }
      console.log("remplazo: ", valor);
      valor = this.formatoNumero(valor)
      console.log("despues del formato: ", valor);
      this[variable] = valor;
    },
    formatoNumero(value) {// ejemplo de formato 1,300.00
      const options2 = { style: 'decimal', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 4 };//si no existe nada despues del decinal .00 y si existe maximo 4 ejemplo .1753
      const numberFormat2 = new Intl.NumberFormat('en-US', options2);
      // Obtener el valor actual del campo y eliminar caracteres no deseados
      const formattedValue = numberFormat2.format(value);
      return formattedValue;
    },
    alertaSweet(titulo, texto, icono) {
      Swal.fire({
        title: titulo,
        text: texto,
        icon: icono
      });//success,warning,danger
    },
    graficaKPI(idCanva) {
      console.log("grafica KPI");
      const canvas = document.getElementById(idCanva);
      const context = canvas.getContext('2d');

      if (!canvas) {
        console.error("No se pudo obtener la referencia al elemento canvas.");
        return;
      }

      // Destruye el gráfico existente si ya existe
      let existingChart = Chart.getChart(canvas);
      if (existingChart) {
        existingChart.destroy();
      }
      var datosGraficaLength = this.datosGrafica.length; //tamanio
      var datosGraficaElementos = this.datosGrafica; //arreglo de datos

      new Chart(canvas, {
        type: 'bar',
        data: {
          labels: this.leyedasGafica,
          datasets: [{
            label: '',
            data: this.datosGrafica,
            backgroundColor: this.datosGrafica.map((valor, index) => {
              if (index == 0) {
                return 'red';//Línea Base
              }
              if (index == 1) {
                return '#d8aa0a';//Entitlement
              }
              if (index == 2) {
                return '#6bb92e';//Meta Calculada
              }
              if (index == 3) {
                return 'green';//Meta Retadora
              }
              if (index >= 4) {
                let color = 'black';

                if (this.tGrafica == "Incremento") {
                  if (valor >= this.datosGrafica[3]) {
                    color = 'green';//Meta Retadora
                  } else if (valor >= this.datosGrafica[2]) {
                    color = '#6bb92e';//Meta Calculada
                  } else if (valor >= this.datosGrafica[2] && valor < this.datosGrafica[3]) {
                    color = '#6bb92e';//Meta Calculada
                  } else if (valor >= this.datosGrafica[1] && valor < this.datosGrafica[3]) {
                    color = '#d8aa0a';//Entitlement
                  } else if (valor < this.datosGrafica[3]) {
                    color = 'red';
                  }
                } else {
                  if (valor <= this.datosGrafica[3]) {
                    color = 'green';
                  } else if (valor >= this.datosGrafica[0] || valor > this.datosGrafica[1] && valor > this.datosGrafica[2] && valor > this.datosGrafica[3]) {
                    color = 'red';
                    console.log("condicion 1")
                  }/*else if(valor>=this.datosGrafica[2] && valor<this.datosGrafica[0]){
                            color = '#6bb92e';
                            console.log("condicion 1")
                          }*/else if (valor > this.datosGrafica[3] && valor <= this.datosGrafica[2]) {
                    color = '#6bb92e';
                    console.log("condicion 3")
                  } else if (valor <= this.datosGrafica[1] && valor > this.datosGrafica[3]) {
                    color = '#d8aa0a';
                    console.log("condicion 2")
                  }/*else if(valor>=this.datosGrafica[1] && valor<this.datosGrafica[0]){
                            color = '#d8aa0a';
                            console.log("condicion 3")
                          }*/else if (valor > this.datosGrafica[2] && valor <= this.datosGrafica[2]) {
                    color = '#6bb92e';
                    console.log("condicion 4")
                  }/*else if(valor>this.datosGrafica[2] && this.datosGrafica[2]<valor){
                            color = '#6bb92e';
                            console.log("condicion 7")
                          }*/
                }
                return color;
              }
            }),
            borderWidth: 1,
          }]
        },
        options: {
          plugins: {
            legend:{ //legend es para eliminar el boton que oculta y aparece las barras
              display: false
            },
            title: {
              display: true,
              text: this.nombre_indicador,
              font: {
                size: 20
              },
              padding: {
                //top: 20,   
                bottom: 50
              }
            },
          },
          tooltips: {
            enabled: true,
          },
          scales: {
            x2: {
              display: false,
              //position: ,
              labels: this.datosGrafica.map(value => this.formatoNumero(value) + " " + this.tipo_unidad + ""),
              ticks: {
                font: {
                  size: 20
                },
                display: true,
                beginAtZero: true,
                color: this.datosGrafica.map((label, index) => {
                  switch (index) {
                    case 0:
                      return 'red';
                    case 1:
                      return '#d8aa0a';
                    case 2:
                      return '#6bb92e';
                    case 3:
                      return 'green';
                    default:
                      return 'black';
                  }
                })
              },
              grid: {
                display: false
              }
            },
            x: {
              display: true,
              position: 'bottom', //inferior
              ticks: {
                display: true,
                beginAtZero: true,
                font: {
                  size: 20
                },
              }
            },
          },
          animation: {

            duration: 0,

          },

        },
        plugins: [{
          afterDatasetsDraw: (chart) => {
            datosGraficaElementos.forEach((data, index) => {
              chart.ctx.fillStyle = 'black';
              chart.ctx.font = '20px Arial';
              chart.ctx.textAlign = 'center';
              chart.ctx.textBaseline = 'top';
              chart.ctx.fillText(this.formatoNumero(data), chart.getDatasetMeta(0).data[index].x, chart.getDatasetMeta(0).data[index].y - 40);
              chart.ctx.fillText(this.tipo_unidad, chart.getDatasetMeta(0).data[index].x, chart.getDatasetMeta(0).data[index].y - 20);
            });
          }

        }]

      });

    },
    consultarSeguimientoKPI() {
      axios.get("seguimientoKpiController.php", {
        params: {
          id_equipo: this.select_session_equipo.split('<->')[0]
        }
      }).then(response => {
        if (response.data[0] == true) {
          this.seguimientoKPIs = response.data[1];
          if (this.seguimientoKPIs.length > 0) {
            //datos para la grafica
            this.nombre_indicador = this.seguimientoKPIs[0].nombre_indicador
            this.tGrafica = this.seguimientoKPIs[0].tipo
            this.tipo_unidad = this.seguimientoKPIs[0].unidad
            this.datoGrafica_LineaBase = this.seguimientoKPIs[0].linea_base;
            this.datoGrafica_Entitlement = this.seguimientoKPIs[0].entitlement;
            this.datoGrafica_MetaCalculada = this.seguimientoKPIs[0].meta_calculada;
            this.datoGrafica_MetaRetadora = this.seguimientoKPIs[0].meta_retadora;
            this.datoGrafica_semana = this.seguimientoKPIs[0].semana;
            //this.datoGrafica_dato= this.seguimientoKPIs[0].dato_semanal
            //datos para el formulario
            this.linea_base = this.formatoNumero(this.seguimientoKPIs[0].linea_base);
            this.entitlement = this.formatoNumero(this.seguimientoKPIs[0].entitlement);
            this.meta_calculada = this.formatoNumero(this.seguimientoKPIs[0].meta_calculada);
            this.meta_retadora = this.formatoNumero(this.seguimientoKPIs[0].meta_retadora);
            var meses_semanas = [];
            var datos_meses_semanas = [];
            var datosKPIS = this.seguimientoKPIs

            for (let i = 0; i < datosKPIS.length; i++) {
              if (datosKPIS[i].mes_cierre !== '') {
                if (i === datosKPIS.length - 1 || datosKPIS[i].mes_cierre !== datosKPIS[i + 1].mes_cierre) {
                  meses_semanas.push('Mes ' + datosKPIS[i].mes_cierre);
                  datos_meses_semanas.push(datosKPIS[i].dato_semanal);
                }
              } else {
                meses_semanas.push('Semana ' + datosKPIS[i].semana);

                datos_meses_semanas.push(datosKPIS[i].dato_semanal);
              }
            }

            console.log(meses_semanas)
            console.log(datos_meses_semanas)
            this.leyedasGafica = ['Línea Base', 'Entitlement', 'Meta Calculada', 'Meta Retadora'].concat(meses_semanas);//concatenando leyendass
            this.datosGrafica = [this.datoGrafica_LineaBase, this.datoGrafica_Entitlement, this.datoGrafica_MetaCalculada, this.datoGrafica_MetaRetadora].concat(datos_meses_semanas)
            this.graficaKPI('canvaKPI')
          } else {
            this.nombre_indicador = ''
            this.tGrafica = ''
            this.tipo_unidad = ''
            this.linea_base = ''
            this.entitlement = ''
            this.meta_calculada = ''
            this.meta_retadora = ''
            this.datoGrafica_LineaBase = 0
            this.datoGrafica_Entitlement = 0
            this.datoGrafica_MetaCalculada = 0
            this.datoGrafica_MetaRetadora = 0
            this.datoGrafica_dato = 0
            this.leyedasGafica = []
            this.datosGrafica = []
            this.graficaKPI('canvaKPI')
          }

        } else {
          console.log('Error en consulta', response.data)
        }
      }).catch(error => {
        console.log(error)
      })

    },
    guardarSeguimientoKPI() {
      if (this.nombre_indicador == '' || this.unidad == '') { return this.alertaSweet('Nombre y Tipo unidad', 'Debe de colocar nombre del indicador o tipo de unidad', 'warning') }
      if (this.semana_kpi == '') { return this.alertaSweet('Seleccione Semana', 'Seleccione la semana', 'warning') }
      if (this.checkMes == true && this.mes_cierre == '') { return this.alertaSweet('Seleccione Mes', 'Seleccione el mes de cierre', 'warning') }
      console.log("Semana Dato", this.dato_semanal)
      axios.post("seguimientoKpiController.php", {
        id_equipo: this.select_session_equipo.split('<->')[0],
        nombre_indicador: this.nombre_indicador,
        tGrafica: this.tGrafica,
        unidad: this.tipo_unidad,
        linea_base: this.linea_base,
        entitlement: this.entitlement,
        meta_calculada: this.meta_calculada,
        meta_retadora: this.meta_retadora,
        anio_kpi: this.anio_kpi,
        semana_kpi: this.semana_kpi,
        dato_semanal: this.dato_semanal,
        mes_cierre: this.mes_cierre
      }).then(response => {
        if (response.data == true) {
          this.linea_base = ''
          this.entitlement = ''
          this.meta_calculada = ''
          this.meta_retadora = ''
          this.dato_semanal = ''
          this.mes_cierre = ''
          //this.myModal.hide();
          this.consultarSeguimientoKPI()
          this.checkMes = false
        } else {
          console.log("Problema al guardar", response.data);
        }
      }).catch(error => {
        console.log("Error en axios" + error)
      })
    },
    updateBanderaKpi(input) {
      this.actualizar_kpi = input
    },
    cancelarKpi() {//reasiganción de datos a los input correspondiente
      if (this.actualizar_kpi == 'nombre_indicador') { this.nombre_indicador = this.seguimientoKPIs[0].nombre_indicador }
      if (this.actualizar_kpi == 'unidad') { this.tipo_unidad = this.seguimientoKPIs[0].unidad }
      if (this.actualizar_kpi == 'linea_base') { this.linea_base = this.seguimientoKPIs[0].linea_base }
      if (this.actualizar_kpi == 'entitlement') { this.entitlement = this.seguimientoKPIs[0].entitlement }
      if (this.actualizar_kpi == 'meta_calculada') { this.meta_calculada = this.seguimientoKPIs[0].meta_calculada }
      if (this.actualizar_kpi == 'meta_retadora') { this.meta_retadora = this.seguimientoKPIs[0].meta_retadora }
      this.actualizar_kpi = false
    },
    asignarDatosKPI(index) {
      this.actualizar_datoKPI = true
      var arregloKPI = this.seguimientoKPIs.slice().reverse()
      this.idUpdateDatoKPI = arregloKPI[index].id
      this.anio_kpi = arregloKPI[index].anio
      this.mes_cierre = arregloKPI[index].mes_cierre
      this.mes_cierre_anterior = arregloKPI[index].mes_cierre
      this.dato_semanal = arregloKPI[index].dato_semanal
      this.semana_kpi = arregloKPI[index].semana
      console.log(this.idUpdateDatoKPI);
    },
    cancelarDatosKPI() {
      this.idUpdateDatoKPI = ''
      this.actualizar_datoKPI = false;
      this.mes_cierre = ''
      this.semana_kpi = ''
      this.dato_semanal = ''
      this.tomarAnioActual()
    },
    updateKpi() {
      var new_valor = ''
      if (this.actualizar_kpi == 'nombre_indicador') { if (this.nombre_indicador == '') { return "Coloque el nombre del indicador" } else { new_valor = this.nombre_indicador } }
      if (this.actualizar_kpi == 'tipo') { if (this.tGrafica == '') { return "Coloque el nombre del indicador" } else { new_valor = this.tGrafica } }
      if (this.actualizar_kpi == 'unidad') { if (this.tipo_unidad == '') { return "Coloque una unidad" } else { new_valor = this.tipo_unidad } }
      if (this.actualizar_kpi == 'linea_base') { if (this.linea_base == '') { return "Coloque un valor en línea base" } else { new_valor = this.linea_base } }
      if (this.actualizar_kpi == 'entitlement') { if (this.entitlement == '') { return "Coloque un valor en entitlement" } else { new_valor = this.entitlement } }
      if (this.actualizar_kpi == 'meta_calculada') { if (this.meta_calculada == '') { return "Coloque un valor en meta calculada" } else { new_valor = this.meta_calculada } }
      if (this.actualizar_kpi == 'meta_retadora') { if (this.meta_retadora == '') { return "Coloque un valor en meta retadora" } else { new_valor = this.meta_retadora } }
      axios.put("seguimientoKpiController.php", {
        accion: 'Bases',
        id_equipo: this.select_session_equipo.split('<->')[0],
        actualizar: this.actualizar_kpi,
        nuevo_valor: new_valor
      }).then(response => {
        if (response.data == true) {
          this.actualizar_kpi = ''
          //this.myModal.hide();
          this.consultarSeguimientoKPI()
        } else {
          console.log("algo salio mal");
        }
      }).catch(error => {
        console.log("Error en axios ", error)
      })
    },
    guardarActualizacionDatoKPI() {
      axios.put("seguimientoKpiController.php", {
        accion: 'Datos',
        id_equipo: this.select_session_equipo.split('<->')[0],
        id_registro: this.idUpdateDatoKPI,
        anio: this.anio_kpi,
        mes_cierre_anterior: this.mes_cierre_anterior,
        mes_cierre: this.mes_cierre,
        semana: this.semana_kpi,
        dato_semanal: this.dato_semanal
      }).then(response => {
        console.log(response.data)
        this.consultarSeguimientoKPI()
        this.cancelarDatosKPI()//reseteo variables
      }).catch(error => {
        console.log("Error en axios ", error)
      })
    },
    eliminarDatoKPI(id, semana, dato) {
      if (!confirm("¿Desea eliminar el registro semana " + semana + " con dato " + dato + "?")) { return true }
      axios.delete("seguimientoKpiController.php", {
        params: {
          id_dato: id
        }
      }).then(response => {
        console.log(response.data)
        if (response.data == true) {
          this.consultarSeguimientoKPI()
          this.cancelarDatosKPI()//reseteo variables
        } else {
          alert("Algo salio mal al eliminar el registro");
        }
      }).catch(error => {
        console.log("Error en axios", error)
      })

    },
    consultarJuntasArranque() {
      axios.get("juntasArranqueController.php", {
        params: {
          id_equipo: this.select_session_equipo.split('<->')[0]
        }
      }).then(response => {
        if (response.data[0]) {
          this.justasArranque = response.data[1];
        }
      }).catch(error => {
        console.log("Error en axios " + error);
      })
    },
    cerrarProyecto() {
      Swal.fire({
        title: "Limpiar y guardar datos?",
        html: "<label>¡Se limpiarán y guardarán los datos, de esta manera podrá iniciar a registrar datos de un nuevo proyecto! <br> - Cargue la presenteción (Puede tardar hasta 7 minutos en subirse por el peso)</label>",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, guardar y limpiar!"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.put("gestionSesionesController.php", {
            accion: 'cerrarProyecto',
            id_equipo: this.select_session_equipo.split('<->')[0],
          }).then(response => {
            console.log("Respuesta Cerrar Proyecto", response);
            if (response.data[0] == true && response.data[1] == true && response.data[2] == true && response.data[3] == true) {
              this.consultarEADXID()
              this.consultarSeguimientoSession()
              this.consultarCompromisos()
            } else {
              Swal.fire("Algo salio mal al guardar y limpiar!");
            }
          })
          Swal.fire({
            title: "Se limpio correctamente!",
            text: "Ya puede iniciar a registrar los datos del nuevo proyecto",
            icon: "success"
          });
        }
      });
    },
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////CREAR COMPETENCIAS/////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    consultarForos() {// se activa cuando selecciono una area
      //console.log(this.select_planta_foro+" "+this.select_area_foro)
      axios.get("competenciasController.php", {
        params: {
          accion: 'Consultar'
        }
      }).then(response => {
        console.log(response.data);
        if (response.data[0] == true) {
          this.foros = response.data[1];
        } else {
          console.log("error en la consulta de foros")
        }
        //this.EADFiltrado = response.data[0];
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },
    consultarPlantasEADs() {//Se activa al seleccionar la opcion de crear competencias
      axios.post("crud_ead.php", {
        accion: 'consultarPlantasEADs',
      }).then(response => {
        console.log(response.data);
        this.plantasEADs = response.data[4].plantas;
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },
    cosultarEADxArea() { //se activa cuando selecciono una Planta
      this.EADFiltrado = [];
      this.select_area_foro = "";
      axios.post("crud_ead.php", {
        accion: 'consultarAreasEADs',
        planta: this.select_planta_foro,
      }).then(response => {
        console.log(response.data);
        this.areasEADs = response.data[4].areas;
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },
    cosultarEADxPlantaxArea() {// se activa cuando selecciono una area
      //console.log(this.select_planta_foro+" "+this.select_area_foro)
      if (this.select_planta_foro != "" && this.select_area_foro != "") {
        axios.get("competenciasController.php", {
          params: {
            accion: 'Filtrar',
            planta: this.select_planta_foro,
            area: this.select_area_foro
          }
        }).then(response => {
          //console.log(response.data);
          this.EADFiltrado = response.data[0];
        }).catch(error => {
          console.log("Error en axios: " + error)
        })
      }
    },
    consultarEADxPlanta() {
      console.log("foroGlobal", this.foroGlobal);
      console.log("planta", this.select_planta_foro)
      if (this.foroGlobal === "true") {
        axios.get("competenciasController.php", {
          params: {
            accion: 'EADSxPlanta',
            planta: this.select_planta_foro
          }
        }).then(response => {
          if (response.data[1] === true) {
            this.EADFiltrado = response.data[0];
            this.ckeckEADForo = [];
          } else {
            console.log("Algo salio mal al consultar")
          }
        }).catch(error => {
          console.log("Error en axios: " + error)
        })
      }
    },
    resetearVariablesForo() {
      this.select_planta_foro = ''
      this.select_area_foro = ''
      this.areasEADs = ''
      this.fecha_foro = ''
      this.EADFiltrado = []
      this.ckeckEADForo = []
      this.ckeckEvaluadores = []
    },
    modalEvaluadores(accion) {
      this.accion_evaluador = accion
      if (accion == 'Crear') {
        //limpio el formulario
        this.nombre_evaluador = ''
        this.nomina_evaluador = ''
        this.contrasena_evaluador = ''
        this.correo_evaluador = ''
        this.myModal = new bootstrap.Modal(document.getElementById('modal_evaluadores'));
        this.myModal.show();
      }

      if (accion == 'Actualizar') {
        console.log(this.ckeckEvaluadores)
        if (this.ckeckEvaluadores.length == 1) {
          this.myModal = new bootstrap.Modal(document.getElementById('modal_evaluadores'));
          this.myModal.show();
          var id_evaluador = this.ckeckEvaluadores[0]
          var objetoEncontrado = this.evaluadores.find(function (objeto) {//busco el id en el objeto para asigar los datos
            return objeto.id === id_evaluador;
          });
          if (objetoEncontrado) {
            console.log("SE ENCONTRO", objetoEncontrado);
            this.nombre_evaluador = objetoEncontrado.nombre
            this.nomina_evaluador = objetoEncontrado.nomina
            this.contrasena_evaluador = objetoEncontrado.contrasena
            this.correo_evaluador = objetoEncontrado.correo
          } else {
            alert("Problemas para actulizar al Evaluador")
          }
        } else if (this.ckeckEvaluadores.length > 1) {
          alert("Solo se puedo actulizar 1 evaluador, no varios a la vez.")
        } else {
          alert("Selecciona un evaluador para actulizarlo.")
        }
      }
    },
    consultarEvaludores() {
      axios.post("insertar_actualizar_eliminar_evaluador.php", {
        accion: 'consultar'
      }).then(response => {
        console.log(response.data)
        this.evaluadores = response.data;
      }).catch(error => {
        console.log("Algo salio mal en Axios: " + error);
      })
    },
    guardarEvaluador(accion) {// insertar y guardar
      var id_evaluador;
      console.log("accion", accion)
      if (accion == "actualizar") {
        id_evaluador = parseInt(this.ckeckEvaluadores[0]);
      }
      if (this.nombre_evaluador == '' || this.nomina_evaluador == '' || this.contrasena_evaluador == '' || this.correo_evaluador == '') { return alert("No deje campos vacios") }
      axios.post("insertar_actualizar_eliminar_evaluador.php", {
        nombre: this.nombre_evaluador,
        nomina: this.nomina_evaluador,
        contrasena: this.contrasena_evaluador,
        correo: this.correo_evaluador,
        accion: accion,
        id_evaluador: id_evaluador

      }).then(response => {
        if (response.data == true) {
          alert("Operación realizada con éxito");
          this.consultarEvaludores()
          this.nombre_evaluador = ''
          this.nomina_evaluador = ''
          this.contrasena_evaluador = ''
          this.correo_evaluador = ''
          this.myModal.hide();
        } else {
          alert("Algo salio mal")
        }
      }).catch(error => {
        console.log("error en axios: " + error)
      })
    },
    eliminarEvaluador() {// insertar y guardar
      if (this.ckeckEvaluadores.length == 1) {
        if (!confirm("Seguro que desea eliminar este evaluador?")) { return }
        axios.post("insertar_actualizar_eliminar_evaluador.php", {
          accion: 'eliminar',
          id_evaluador: this.ckeckEvaluadores[0]
        }).then(response => {
          if (response.data == true) {
            alert("Se elimino con éxito");
            this.ckeckEvaluadores = []
            this.consultarEvaludores()
          } else {
            alert("No se puede eliminar, cuenta con evaluaciones realizadas.")
          }
        }).catch(error => {
          console.log("error en axios: " + error)
        })
      } else if (this.ckeckEvaluadores.length <= 0) {
        alert("Seleccion un Evaluador para eliminar")
      } else if (this.ckeckEvaluadores.length > 1) {
        alert("Solo se puedo eliminar 1 evaluador, no varios a la vez.")
      }
    },
    crearForo() {
      let planta = "";
      let area = "";

      if (this.foroGlobal != 'true') {//si no es 'true'
        if (!this.nombre_foro) { return alert("Agregue el nombre al foro") }
        if (!this.select_planta_foro) { return alert("Seleccione Planta") }
        if (!this.select_area_foro) { return alert("Seleccione Área") }
        if (!this.fecha_foro) { return alert("Seleccione una Fecha") }
        if (this.ckeckEADForo.length <= 0) { return alert("Seleccione los EAD's") }
        if (this.ckeckEvaluadores.length <= 0) { return alert("Seleccione Evaluadores") }
        planta = this.select_planta_foro
        area = this.select_area_foro
      } else {
        if (!this.nombre_foro) { return alert("Agregue el nombre al foro") }
        if (this.ckeckEADForo.length <= 0) { return alert("Seleccione los EAD's") }
        if (this.ckeckEvaluadores.length <= 0) { return alert("Seleccione Evaluadores") }
        if (!this.fecha_foro) { return alert("Seleccione una Fecha") }
        if (this.select_planta_foro == "") { planta = "Multiplanta" }
        planta = this.select_planta_foro
        area = "Multiárea"
      }
      axios.post("competenciasController.php", {
        accion: "CrearForo",
        nombre_foro: this.nombre_foro,
        planta: planta,
        area: area,
        fecha: this.fecha_foro,
        ids_ead: this.ckeckEADForo,
        evaluadores: this.ckeckEvaluadores
      }).then(response => {
        console.log("Crear Foro", response.data)
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
          this.foroGlobal = 'false'
          alert("Foro guardado correctamente.");
          this.consultarForos()
        }

      }).catch(error => {
        console.log("error en axios: CrearForo(): " + error);
      });
    },
    modalForosDetalles(nombre) {
      this.myModal = new bootstrap.Modal(document.getElementById('modal_foros_detalles'));
      this.myModal.show();
      this.tituloModal = nombre;
      console.log("Datos, Modal", this.myModal)
      this.verMenu = 'No'

    },
    consultarDetallesForo(id) {
      this.id_foro = id;
      axios.get("competenciasController.php", {
        params: {
          accion: "DetallesForo",
          id: id
        }
      }).then(response => {
        if (response.data) {
          console.log('Consulta Foro', response.data);
          if (response.data[0] == true) {
            this.eadsForo = response.data[1];
            if (response.data[2] == true) {
              this.evaluadoresForo = response.data[3];
              if (response.data[4] == true) {
                this.calificacionEvaluadorForo = response.data[5];
                const valoresSuma = this.eadsForo.map(objeto => parseFloat((objeto.suma / this.evaluadoresForo.length).toFixed(2)));
                var suma = 0;
                for (let i = 0; i < valoresSuma.length; i++) {
                  const element = valoresSuma[i];
                  suma += element;
                }
                //console.log(suma)
                this.promedioCalificaciones = parseFloat((suma.toFixed(3)) / this.eadsForo.length).toFixed(3);
                this.editar_nombre_proyecto = ''; //la reseteo despues de la consulta para que el nombre se refleje sin un pequeño salto, si la borras no perjudica en el funcionanmiento
              } else {
                console.log("error en la consulta de calificacion por evaluador" + response.data[4]);
              }
            } else {
              console.log("error en la consulta de evaluadores por foro" + response.data[3]);
            }
          } else {
            console.log("Error en la consulta Detalle Foro. Error: ", response.data[0]);
          }
        }
      }).catch(error => {
        console.log("Error en axios " + error)
      })
    },
    estatusForo(id_foro, nombre_foro, estatus) {
      var nuevoEstatus;
      if (estatus == "Abierto") {
        nuevoEstatus = "Cerrado";
      }
      if (estatus == "Cerrado") {
        nuevoEstatus = "Abierto";
      }
      //if(!confirm("El "+"'"+nombre_foro+"'"+" cambiará al estado: "+nuevoEstatus)){return}   
      axios.put("foroController.php", {
        id_foro: id_foro,
        nuevoEstatus: nuevoEstatus
      }).then(response => {
        if (response.data != true) { return alert("Algo salio mal") } else {
          this.consultarForos();
        }
      }).catch(error => {
        console.log(error)
      })
    },
    editarNombreProyecto(index) {
      console.log(index)
      this.editar_nombre_proyecto = index
    },
    guardarNombreProyecto(id_ead_foro, index) {
      var nuevo_nombre = document.getElementById("input" + index).value;
      axios.put("competenciasController.php", {
        accion: '',
        id_ead_foro: id_ead_foro,
        nombre_proyecto: nuevo_nombre
      }).then(response => {
        console.log(response.data)
        if (response.data == true) {
          this.consultarDetallesForo(this.id_foro)

        } else {
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
    consultarCompetenciaIDevaluador() {
      axios.get("evaluarController.php", {
        params: {
          accion: 'IDEvaluador'
        }
      }).then(response => {
        console.log(response.data)
        if (response.data[0] == true) {
          this.equiposEvaluador = response.data[1];
        } else {
          console.log("Error en la consulta IDEvaluador " + response.data[0])
        }
      }).catch(error => {
        console.log("Error en axios: " + error)
      });
    },
    modalPreguntas(nombre_equipo) {
      this.mensaje = ''
      this.myModal = new bootstrap.Modal(document.getElementById('modalEvaluacion'));
      this.myModal.show();
      this.tituloModal = nombre_equipo;
      // Agrega la modal al historial de navegacion
      // Create a new state object when the modal is opened
      window.history.pushState({ modalAbierta: true }, '', '');
      console.log("Estado", window.history.state.modalAbierta); // Log the state object
    },
    IDCalifiacion(id_calificacion, id_ead_foro, comentario) {//variable que utilizare para insertar la calificacion en tabla calificacion con el ID 
      this.id_calificacion = id_calificacion;
      this.id_ead_foro = id_ead_foro;
      this.comentario = comentario
    },
    consultarPreguntasEvaluador(id_ead_foro) {
      axios.get("evaluacionPreguntasController.php", {
        params: {
          accion: 'preguntasEvaluador',
          id_ead_foro: id_ead_foro
        }
      }).then(response => {
        console.log('Preguntas', response.data);
        if (response.data[0] == true) {
          this.preguntas_evaluar = response.data[1];
          this.datosEvaluar = response.data[2];
          this.examenFinalizado = response.data[4];
          this.contestado = response.data[5];

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
          this.sumaPonderacion = sumaPonderacion;

          calificacion = (((sumaPuntosReales / sumaPuntosMaximos) * sumaPonderacion / 100) * 100).toFixed(2)
          this.calificacionEAD = calificacion;
          //this.etapas_preguntas = response.data = response.data[2];
        } else {
          console.log("Algo no salio bien en la consulta");
        }
      }).catch(error => {
        console.log('Error axios' + error)
      })
    },
    guardarValor(id_pregunta, id_ead_foro, valor) {

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

        axios.post("evaluacionPreguntasController.php", {
          id_pregunta: id_pregunta,
          id_ead_foro: id_ead_foro,
          valor: valor
        }).then(response => {
          //console.log("GUARDAR PREGUNTA",response.data)
          if (response.data[0] == true) {
            //console.log("Se guardo: "+id_pregunta)
            this.consultarPreguntasEvaluador(id_ead_foro)// para actualizar la calificacion tiempo real pero es pesado.
          } else {
            console.log("Algo no salio al guardar");
          }
        }).catch(error => {
          console.log('Error axios' + error)
        })
    },
    enviarCalificacion() {
      console.log("IDCalificaicon", this.id_calificacion);
      console.log("Calificacion", this.calificacionEAD);
      axios.put("evaluacionPreguntasController.php", {
        id_calificacion: this.id_calificacion,
        calificacionEAD: this.calificacionEAD,
        comentario: this.comentario
      }).then(response => {
        //console.log('ENVIANDO CALIFICACION',response.data)
        if (response.data[0] == true) {
          Swal.fire({
            title: "Calificado!",
            text: "La calificación se guardo correctamente!",
            icon: "success"
          });
          this.myModal.hide();
          this.consultarCompetenciaIDevaluador();
        } else {
          console.log("Algo no salio al guardar");
        }
      }).catch(error => {
        console.log('Error axios' + error)
      })
    },
    contestarEvaluacion() {
      let data = this.contestado

      Object.keys(data).forEach(key => {
        data[key].forEach((answer, index) => {
          if (answer === "No") {
            data[key][index] = "Sin Contestar";
          }
        });
      });

      this.contestado = data
      console.log(this.contestado)
      Swal.fire({
        title: "Evaluación incompleta!",
        text: "Faltan puntos por evaluador!",
        icon: "warning"
      });
    },
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////GRAFICAS/////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    consultarCriterios() {
      this.idCriterioGrafica = ''
      if (this.equipo_grafica) {
        axios.get("criteriosController.php", {
          params: {
            accion: 'consultarCriterios',
            id_equipo: this.equipo_grafica.split('<->')[0]
          }
        }).then(response => {
          if (response.data[0] == true) {
            this.criterioGrafica = response.data[1];
          } else {
            console.log("Error al consultar" + response.data)
          }
          console.log("criterios grafica", response.data)
        }).catch(error => {
          console.log("Error en axios.php" + error)
        })
      }
    },
    consultarCriteriosParaAsignarColaborador(id_equipo) {
      this.idCriterioGrafica = ''
      axios.get("criteriosController.php", {
        params: {
          accion: 'consultarCriterios',
          id_equipo: id_equipo
        }
      }).then(response => {
        if (response.data[0] == true) {
          this.criterioAsignar = response.data[1];
        } else {
          console.log("Error al consultar" + response.data)
        }
      }).catch(error => {
        console.log("Error en axios.php" + error)
      })
    },

    diasDelMesAnio() {
      var anio
      var mes
     // console.log(this.anio_grafica + '' + this.mes_grafica)
      if (this.anio_grafica != '' && this.mes_grafica != '') {
        if (this.mes_grafica == 'Enero') { mes = 1 }
        if (this.mes_grafica == 'Febrero') { mes = 2 }
        if (this.mes_grafica == 'Marzo') { mes = 3 }
        if (this.mes_grafica == 'Abril') { mes = 4 }
        if (this.mes_grafica == 'Mayo') { mes = 5 }
        if (this.mes_grafica == 'Junio') { mes = 6 }
        if (this.mes_grafica == 'Julio') { mes = 7 }
        if (this.mes_grafica == 'Agosto') { mes = 8 }
        if (this.mes_grafica == 'Septiembre') { mes = 9 }
        if (this.mes_grafica == 'Octubre') { mes = 10 }
        if (this.mes_grafica == 'Noviembre') { mes = 11 }
        if (this.mes_grafica == 'Diciembre') { mes = 12 }

        anio = this.anio_grafica;
        var ultimoDiaMes = new Date(anio, mes, 0);
        return ultimoDiaMes.getDate()


      }
    },

    tablaGraficas() {
      setTimeout(() => {

        const selectedItem = this.criterioGrafica.find(item => item.id === this.idCriterioGrafica);
        let nombreCriterio = ""
        let tipoOPeracion = ""
        if (selectedItem) {
          nombreCriterio = selectedItem.nombre;//Nombre criterio
          tipoOPeracion = selectedItem.operacion;//Operacion a realizar del criterio
          this.nombreDelCriterio = nombreCriterio
          if (tipoOPeracion == "Promedio") {
            suma = this.datosGrafica.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0);
            let elementos = this.datosGrafica.filter((element) => {//elimino los datos nulos, para tomar el valor de los datos no vacios
              return element !== '' && element !== null && element !== undefined;
            });
            this.sumaTabla = (suma / elementos.length).toFixed(2);
          }
        }

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
              label: nombreCriterio,
              data: this.datosGrafica,
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
      }, 200)
    },

    consultadoValoresGrafica() {
      if (this.idCriterioGrafica != '' && this.equipo_grafica != '' && this.anio_grafica != '' && this.mes_grafica != '') {

        var mes;
        if (this.mes_grafica == 'Enero') { mes = 1 }
        if (this.mes_grafica == 'Febrero') { mes = 2 }
        if (this.mes_grafica == 'Marzo') { mes = 3 }
        if (this.mes_grafica == 'Abril') { mes = 4 }
        if (this.mes_grafica == 'Mayo') { mes = 5 }
        if (this.mes_grafica == 'Junio') { mes = 6 }
        if (this.mes_grafica == 'Julio') { mes = 7 }
        if (this.mes_grafica == 'Agosto') { mes = 8 }
        if (this.mes_grafica == 'Septiembre') { mes = 9 }
        if (this.mes_grafica == 'Octubre') { mes = 10 }
        if (this.mes_grafica == 'Noviembre') { mes = 11 }
        if (this.mes_grafica == 'Diciembre') { mes = 12 }

        var id_equipo = this.equipo_grafica.split('<->')[0];
        axios.get("graficasController.php", {
          params: {
            accion: "Graficas",
            grafica: this.idCriterioGrafica,
            id_equipo: id_equipo,
            anio: this.anio_grafica,
            mes: mes
          }
        }).then(response => {
          console.log("consulta grafica", response.data)
          if (response.data[0] == true) {
            const nuevoArreglo = [];
            response.data[1].forEach(valores => {
              nuevoArreglo[(valores.dia - 1)] = valores.valor;//la resto ya que el arreglo empieza en 0
            });
            this.datosGrafica = nuevoArreglo
            this.sumaTabla = this.datosGrafica.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);

          //  console.log('el tamaño del arreglo es:',this.datosGrafica.length);
          //  console.log('el id del criterio:',this.idCriterioGrafica);

          if(this.idCriterioGrafica == 2){
            let suma_vacio = 0;
            let suma_valores = 0;
            let cant_pos_llenas = 0;
            this.tamArregloMermaYDesp = this.datosGrafica.length 
    
            for(let i = 0; i < this.datosGrafica.length; i++){
             if(this.datosGrafica[i] == null || this.datosGrafica[i] == undefined || isNaN(this.datosGrafica[i])){
                suma_vacio ++;
              
              }else{
                suma_valores = this.datosGrafica[i] + suma_valores;
                cant_pos_llenas ++;
              }
            }
    
            if(suma_vacio == this.datosGrafica.length || isNaN((suma_valores/cant_pos_llenas).toFixed(2))){
              this.promMermayDesperdicio = 0;
              
            }else{
              this.promMermayDesperdicio = (suma_valores/cant_pos_llenas).toFixed(2)
              
            }
            //console.log('mi suma es:',suma_vacio);
            //console.log('mi total es:',this.promMermayDesperdicio);
          } 
          
        //}

            /* if (this.idCriterioGrafica == 'Rechazos') {
               this.datosGraficaRechazo = nuevoArreglo
               this.sumaTablaRechazo = this.datosGraficaRechazo.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
             } else if (this.idCriterioGrafica == 'Merma') {
               this.datosGraficaMerma = nuevoArreglo
               this.sumaTablaMerma = this.datosGraficaMerma.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
             } else if (this.idCriterioGrafica == 'Eficiencia') {
               this.datosGraficaEficiencia = nuevoArreglo
               this.sumaTablaEficiencia = this.datosGraficaEficiencia.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
             } else if (this.idCriterioGrafica == 'Accidentes') {
               this.datosGraficaAccidentes = nuevoArreglo
               this.sumaTablaAccidentes = this.datosGraficaAccidentes.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
             } else if (this.idCriterioGrafica == 'Actos Inseguros') {
               this.datosGraficaActosInseguros = nuevoArreglo
               this.sumaTablaActosInseguros = this.datosGraficaActosInseguros.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
             } else if (this.idCriterioGrafica == 'Ausentismo') {
               this.datosGraficaAusentismo = nuevoArreglo
               this.sumaTablaActosAusentismo = this.datosGraficaAusentismo.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
             }/*else if(this.idCriterioGrafica=='Cumplimiento del proyecto'){
                 this.datosGraficaCumplimientoProyecto = nuevoArreglo
                 this.sumaTabla = this.datosGraficaRechazo.reduce((total, valor) =>{ if (isNaN(valor) || valor === null) {return total + 0;} else {return total + valor;} }, 0).toFixed(2);
               }*/

            //PENDIENTE AL LLAMANDO  
            this.tablaGraficas()
            this.consultarCausas()

          } else {
            console.log("Algo salio mal al consultar los datos de la grafica")
          }
        }).catch(error => {
          console.log("Error en axios :-(" + error)
        })
      }
    },

    insertandoValores(index) {
      let valor = 0;

      valor = parseFloat(document.getElementById('grafica' + index).value);
      this.datosGrafica[index] = valor;
      this.sumaTabla = this.datosGrafica.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);

      if(this.idCriterioGrafica == 2){
        let suma_vacio = 0;
        let suma_valores = 0;
        let cant_pos_llenas = 0;
        this.tamArregloMermaYDesp = this.datosGrafica.length 

        for(let i = 0; i < this.datosGrafica.length; i++){
         if(this.datosGrafica[i] == null || this.datosGrafica[i] == undefined || isNaN(this.datosGrafica[i])){
            suma_vacio ++;
          
          }else{
            suma_valores = this.datosGrafica[i] + suma_valores;
            cant_pos_llenas ++;
          }
        }

        if(suma_vacio == this.datosGrafica.length || isNaN((suma_valores/cant_pos_llenas).toFixed(2))){
          this.promMermayDesperdicio = 0;
          
        }else{
          this.promMermayDesperdicio = (suma_valores/cant_pos_llenas).toFixed(2)
          
        }
       console.log('mi suma es:',suma_vacio);
       console.log('mi total es:',this.promMermayDesperdicio);
      } 



      /* console.log(this.datosGraficaRechazo);
       if (this.idCriterioGrafica == 'Rechazos') {
         valor = parseFloat(document.getElementById('graficaRechazo' + index).value);
         this.datosGraficaRechazo[index] = valor;
         this.sumaTablaRechazo = this.datosGraficaRechazo.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
       } else if (this.idCriterioGrafica == 'Merma') {
         valor = parseFloat(document.getElementById('graficaMerma' + index).value);
         this.datosGraficaMerma[index] = valor;
         this.sumaTablaMerma = this.datosGraficaMerma.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
       } else if (this.idCriterioGrafica == 'Eficiencia') {
         valor = parseFloat(document.getElementById('graficaEficiencia' + index).value);
         this.datosGraficaEficiencia[index] = valor;
         this.sumaTablaEficiencia = this.datosGraficaEficiencia.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
       } else if (this.idCriterioGrafica == 'Accidentes') {
         valor = parseFloat(document.getElementById('graficaAccidentes' + index).value);
         this.datosGraficaAccidentes[index] = valor;
         this.sumaTablaAccidentes = this.datosGraficaAccidentes.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
       } else if (this.idCriterioGrafica == 'Actos Inseguros') {
         valor = parseFloat(document.getElementById('graficaActosInseguros' + index).value);
         this.datosGraficaActosInseguros[index] = valor;
         this.sumaTablaActosInseguros = this.datosGraficaActosInseguros.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
       } else if (this.idCriterioGrafica == 'Ausentismo') {
         valor = parseFloat(document.getElementById('graficaAusentismo' + index).value);
         this.datosGraficaAusentismo[index] = valor;
         this.sumaTablaActosAusentismo = this.datosGraficaAusentismo.reduce((total, valor) => { if (isNaN(valor) || valor === null) { return total + 0; } else { return total + valor; } }, 0).toFixed(2);
       }else if(this.idCriterioGrafica=='Cumplimiento del proyecto'){
         valor = parseFloat(document.getElementById('graficaCumplimiento' + index).value);
         this.datosGraficaCumplimientoProyecto[index] = valor;
         this.sumaTabla = this.datosGraficaCumplimientoProyecto.reduce((total, valor) =>{ if (isNaN(valor) || valor === null) {return total + 0;} else {return total + valor;} }, 0).toFixed(2);
       }*/
      if (valor === null || valor === undefined || isNaN(valor)) {
        valor = null;
      }
      console.log("Despues de procesar", valor)
      var dia = (index + 1)
      this.saveDateDay(dia, valor)
    },
    saveDateDay(dia, valor) {
      var mes;
      if (this.mes_grafica == 'Enero') { mes = 1 }
      if (this.mes_grafica == 'Febrero') { mes = 2 }
      if (this.mes_grafica == 'Marzo') { mes = 3 }
      if (this.mes_grafica == 'Abril') { mes = 4 }
      if (this.mes_grafica == 'Mayo') { mes = 5 }
      if (this.mes_grafica == 'Junio') { mes = 6 }
      if (this.mes_grafica == 'Julio') { mes = 7 }
      if (this.mes_grafica == 'Agosto') { mes = 8 }
      if (this.mes_grafica == 'Septiembre') { mes = 9 }
      if (this.mes_grafica == 'Octubre') { mes = 10 }
      if (this.mes_grafica == 'Noviembre') { mes = 11 }
      if (this.mes_grafica == 'Diciembre') { mes = 12 }

      var id_equipo = this.equipo_grafica.split('<->')[0];
      var nombre_ead = this.equipo_grafica.split('<->')[1];
      var planta = this.equipo_grafica.split('<->')[2];
      var area = this.equipo_grafica.split('<->')[3];

      //console.log('Verificando variables','Planta: '+planta,'Area: '+area,'ID equipo: '+id_equipo,'Nombre EAD: '+nombre_ead,'tipoTabla: '+this.idCriterioGrafica,'Anio Grafica: '+this.anio_grafica,'Mes:'+mes,'Dia:'+dia,+'Valor:'+valor)
      axios.post("graficasController.php", {
        accion: 'Guadar dato',
        planta: planta,
        area: area,
        id_equipo: id_equipo,
        nombre_ead: nombre_ead,
        grafica: this.idCriterioGrafica,
        anio: this.anio_grafica,
        mes: mes,
        dia: dia,
        valor: valor
      }).then(response => {
        if (response.data == true) {
          Swal.fire({
            title: "Guardado",
            text: "Se guardo con éxito",
            icon: "success"
          });
        } else {
          console.log("No se guardo " + response.data)
        }
        this.tablaGraficas()
      }).catch(error => {
        console.log(error)
      }).finally(() => {

      })
    },
    consultarCausas() {

      var mes;
      if (this.mes_grafica == 'Enero') { mes = 1 }
      if (this.mes_grafica == 'Febrero') { mes = 2 }
      if (this.mes_grafica == 'Marzo') { mes = 3 }
      if (this.mes_grafica == 'Abril') { mes = 4 }
      if (this.mes_grafica == 'Mayo') { mes = 5 }
      if (this.mes_grafica == 'Junio') { mes = 6 }
      if (this.mes_grafica == 'Julio') { mes = 7 }
      if (this.mes_grafica == 'Agosto') { mes = 8 }
      if (this.mes_grafica == 'Septiembre') { mes = 9 }
      if (this.mes_grafica == 'Octubre') { mes = 10 }
      if (this.mes_grafica == 'Noviembre') { mes = 11 }
      if (this.mes_grafica == 'Diciembre') { mes = 12 }



      axios.get("causasController.php", {
        params: {
          grafica: this.idCriterioGrafica,
          id_equipo: this.equipo_grafica.split('<->')[0],
          anio: this.anio_grafica,
          mes: mes,
        }
      }).then(response => {
        if (response.data[0] == true) {
          this.causas = response.data[1]
        } else {
          console.log('No se realizó la consulta causas correctamente', response.data)
        }
      }).catch(error => {
        console.log(console.log("Error en axios" + error))
      }).finally({

      })
    },
    guardarCausa() {
      if (this.idCriterioGrafica == '') {
        return Swal.fire({
          text: "No a seleccionado tipo de tabla/grafica",
          icon: "warning"
        });
      } else if (this.equipo_grafica == '') {
        return Swal.fire({
          text: "Selecciones equipo EAD",
          icon: "warning"
        });
      } else if (this.responsable_causa == '') {
        return Swal.fire({
          text: "Coloque al responsable",
          icon: "warning"
        });
      } else if (this.causa == '') {
        return Swal.fire({
          text: "Coloque una causa",
          icon: "warning"
        });
      } else if (this.anio_grafica == '') {
        return Swal.fire({
          text: "Seleccione un año",
          icon: "warning"
        });
      } else if (this.mes_grafica == '') {
        return Swal.fire({
          text: "Seleccione un mes",
          icon: "warning"
        });
      } else if (this.dia_grafica == '') {
        return Swal.fire({
          text: "Seleccione Fecha de causa",
          icon: "warning"
        });
      }

      var mes;
      if (this.mes_grafica == 'Enero') { mes = 1 }
      if (this.mes_grafica == 'Febrero') { mes = 2 }
      if (this.mes_grafica == 'Marzo') { mes = 3 }
      if (this.mes_grafica == 'Abril') { mes = 4 }
      if (this.mes_grafica == 'Mayo') { mes = 5 }
      if (this.mes_grafica == 'Junio') { mes = 6 }
      if (this.mes_grafica == 'Julio') { mes = 7 }
      if (this.mes_grafica == 'Agosto') { mes = 8 }
      if (this.mes_grafica == 'Septiembre') { mes = 9 }
      if (this.mes_grafica == 'Octubre') { mes = 10 }
      if (this.mes_grafica == 'Noviembre') { mes = 11 }
      if (this.mes_grafica == 'Diciembre') { mes = 12 }

      axios.post("causasController.php", {
        tabla: this.idCriterioGrafica,
        id_equipo: this.equipo_grafica.split('<->')[0],
        equipo: this.equipo_grafica.split('<->')[1],
        responsable: this.responsable_causa,
        causa: this.causa,
        anio: this.anio_grafica,
        mes: mes,
        dia: this.dia_grafica
      }).then(response => {
        if (response.data == true) {
          this.nueva_causa = false
          this.consultarCausas()
          Swal.fire({
            title: "Guardado",
            text: "Causa guarda con éxito",
            icon: "success"
          });
        } else {
          console.log("No se guardo la causa " + response.data)
        }
      }).catch(error => {
        console.log(error)
      }).finally(() => {

      })


    },
    editarCausa(index) {
      this.actualizar_causa = index + 1
      this.responsable_causa = this.causas[index].responsable
      this.causa = this.causas[index].causa
      this.dia_grafica = this.causas[index].dia
    },
    actualizarCausa(id) {
      axios.put('causasController.php', {
        id: id,
        responsable: this.responsable_causa,
        causa: this.causa,
        tabla: this.idCriterioGrafica,
        dia: this.dia_grafica,
      }).then(response => {
        if (response.data == true) {
          Swal.fire({
            title: "Actualización",
            text: "Se guardo con éxito",
            icon: "success"
          });
          this.actualizar_causa = ''
          this.consultarCausas()
        } else {
          alert("no se guardo correctamente")
          console.log(response.data)
        }
      }).catch(error => {
        console.log("Error en axios causas" + error)
      }).finally({

      })
    },
    eliminarCausa(id) {
      Swal.fire({
        title: "Eliminar?",
        text: "Esta seguro de eliminar el compromiso!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete('causasController.php', {
            params: {
              id: id
            }
          }).then(response => {
            if (response.data == true) {
              Swal.fire({
                title: "Eliminado",
                text: "Causa eliminada con éxito",
                icon: "success"
              });
              this.consultarCausas()
            } else {
              console.log(response.data)
            }
          }).catch(error => {
            console.log("Error en axios causas" + error)
          })
        }
      });
    },
    consultarSeguimientoAsistencia() {
      if (this.equipo_score != '' && this.anio_score != '' && this.mes_score != '') {
        var id_equipo = this.equipo_score.split('<->')[0];
        var mes = this.mes_score;
        mes_numero = this.mesesNumeros(mes)
        console.log(mes_numero)
        axios.get("gestionSesionesController.php", {
          params: {
            accion: "ConsultarSeguimientoAsistencia",
            anio: this.anio_score,
            mes: mes_numero,
            id_equipo: id_equipo
          }
        }).then(response => {
          if (response.data[0] == true) {
            let historialAsistencia = [];
            //console.log("Respuesta de asistencia: ",response.data)
            historialAsistencia = response.data[1].map(objetos => objetos.porcentaje_asistencia)//tomo todo el historial de asistencias
            let tamanio = historialAsistencia.length //verifico en tamanio
            let sum = 0;
            historialAsistencia.forEach(elementos => sum += elementos); // sumo cada porcentaje del historial
            console.log(historialAsistencia)
            if (tamanio > 0 || sum > 0) {
              this.asistenciaSC = (sum / tamanio).toFixed(2); //la suma la divido entra la cantidad de asistencias
            } else {
              this.asistenciaSC = 0
            }
          } else {
            console.log("Error en la consulta Asitencia", response.data)
          }
        }).catch(error => {
          console.log("Error en axios :-( " + error);
        })
      }
    },

    mesesNumeros(stringMes) {
      if (stringMes == 'Enero') { return '01' }
      if (stringMes == 'Febrero') { return '02' }
      if (stringMes == 'Marzo') { return '03' }
      if (stringMes == 'Abril') { return '04' }
      if (stringMes == 'Mayo') { return '05' }
      if (stringMes == 'Junio') { return '06' }
      if (stringMes == 'Julio') { return '07' }
      if (stringMes == 'Agosto') { return '08' }
      if (stringMes == 'Septiembre') { return '09' }
      if (stringMes == 'Octubre') { return '10' }
      if (stringMes == 'Noviembre') { return '11' }
      if (stringMes == 'Diciembre') { return '12' }
    },
    consultarNombrePonderaciones() {
      axios.get("ponderacionesController.php", {
        params: {
          accion: "nombrePonderaciones"
        }
      }).then(response => {
        if (response.data[0] == true) {
          this.listaPonderaciones = response.data[1];
        }
      }).catch(error => {
        console.log("Error en axios :-( ", error);
      })
    },
    consultarScoreCard() {
      if (this.equipo_score != '' && this.anio_score != '' && this.mes_score != '') {
        let id_equipo = this.equipo_score.split('<->')[0]
        let id_ponderacion = this.equipo_score.split("<->")[4]
        let anio = this.anio_score
        let mes = this.mes_score;
        let mes_numero = this.mesesNumeros(mes)

        axios.get("scoreCardController.php", {
          params: {
            id_equipo: id_equipo,
            id_ponderacion: id_ponderacion,
            anio: anio,
            mes: mes_numero
          }
        }).then(response => {
          if (response.data[0] === true) {
            //Para cambiar el css 
            this.inputPonderacionSC = ''
            //Valor Actual sumas y input dinamicos
            this.sumasDinamicasSC = []
            this.inputValorActual = []
            //Puntos Obtenidos Reseteando Columna 
            this.puntosObtenidos = []
            //Ponderacion Reseteando Inputs 
            this.inputColumnaPonderacion = []
            //puntosEvaluacion Reseteando columna 
            this.puntosEvaluacion = []
            //Reseteando dato TOTAL
            this.totalSC = ""
            console.log("")
            //Tomo los datos existentes guardados
            response.data[1].forEach(elemento => {
              this.inputValorActual[elemento.id_criterio] = elemento.input_valor_actual
              this.inputColumnaPonderacion[elemento.id_criterio] = elemento.input_ponderacion
            })
            this.consultarGraficasParaScoreCard()
          } else {
            console.log("sin éxito consulta ScoreCard,response.data")
          }
        }).catch(error => {
          console.log("Error en el axios", error)
        });

      }
    },

    guardarDatoScoreCard(id_criterio) {
      this.guardoNuevoDato = true;// lo utilizo para ejecutar el metodo guardarTotalScoreCard(), despues de ejecutar todos los metodos desencadenados por this.consultarScoreCard()
      
      /*let arregloPuntos = this.puntosEvaluacion
      let total = arregloPuntos.reduce((acumulador, valorActual) => { return acumulador + valorActual; }, 0); 
      console.log("RESULTADOS A SUMAR",arregloPuntos)
      console.log("TOTAL PARA GUARDAR:",total);*/
      let total = 0;
      let id_equipo = this.equipo_score.split('<->')[0]
      let id_ponderacion = this.equipo_score.split("<->")[4]
      let input_valor_actual = this.inputValorActual[id_criterio] ?? "";//si es null o undefined, se asigna una cadena vacía "".
      let puntos_obtenidos = this.puntosObtenidos[id_criterio] ?? "";
      let input_ponderacion = this.inputColumnaPonderacion[id_criterio] ?? "";
      let anio = this.anio_score;
      let mes = this.mes_score;
      let mes_numero = this.mesesNumeros(mes)

      axios.post("scoreCardController.php", {
        id_equipo: id_equipo,
        id_ponderacion: id_ponderacion,
        id_criterio: id_criterio,
        input_valor_actual: input_valor_actual,
        puntos_obtenidos: puntos_obtenidos,
        input_ponderacion: input_ponderacion,
        anio: anio,
        mes: mes_numero,
        total: total,
        accion: 'guardarGeneral'
      }).then(response => {
        console.log("guardado ScoreCard", response.data)
        this.consultarScoreCard()
      }).catch(error => {
        console.log("Error en el axios", error)
      })
    },


    guardarTotalScoreCard(){
      //console.log("TOTAL:",this.totalSC)
      let mes_numero = this.mesesNumeros(this.mes_score)
        if(this.guardoNuevoDato===true){
            axios.post("cumplimiento_scorecard_Controller.php", {
              accion: 'guardarTotalScoreCard',
                idEquipo: this.equipo_score.split('<->')[0],
                anio:this.anio_score,
                mes:mes_numero,
                total: this.totalSC,
            }).then(response => {
              console.log("Respuesta GuardarTotal",response.data);
                if (response.data[0] == true) {
                console.log("Calificación guardada con éxito")
                } else {
                  alert("Algo no salio bien al guardar la Calificación")
                  console.log("Error en la consulta de Cumplimiento scorecard", response.data)
                }
            }).catch(error => {
              console.log("Error en el axios", error)
            })
        }
    },

    consultarGraficasParaScoreCard() {
      if (this.equipo_score != '' && this.anio_score != '' && this.mes_score != '') {
        let id_equipo = this.equipo_score.split('<->')[0];
        let mes = this.mes_score;
        mes_numero = this.mesesNumeros(mes)
        axios.get("graficasController.php", {
          params: {
            accion: "ScoreCard",
            id_equipo: id_equipo,
            anio: this.anio_score,
            mes: mes_numero,
          }
        }).then(response => {
          if (response.data[0] == true) {
            console.log("Datos Graficas ScoreCard", response.data[1]);

            // Inicializa el contador de registros fuera de la función reduce
            let indexCant = 1; // Cambié a 0 porque ahora queremos contar los elementos antes de hacer la división
            this.sumasDinamicasSC = response.data[1].reduce((nuevo, origen) => {
              let id_criterio = origen.id_criterios;

              // Buscar si ya existe un item con el mismo id_criterios
              let existingItem = nuevo.find(item => item.id_criterios === id_criterio);

              // Si existe el item, actualizar su suma
              if (existingItem) {
                if (origen.valor !== null) {
                  // Aumentamos el contador solo cuando el valor no es null

                  if (existingItem.operacion === "Promedio") {
                    indexCant++;
                    //console.log("Sumando", indexCant);
                    // Acumulamos la suma sin dividir todavía
                    existingItem.suma = (parseFloat(existingItem.suma) + parseFloat(origen.valor)).toFixed(2);
                    existingItem.registros = indexCant; // Actualizamos el contador de registros
                  } else {
                    // En caso que no sea Promedio, solo sumamos el valor
                    existingItem.suma = (parseFloat(existingItem.suma) + parseFloat(origen.valor)).toFixed(2);
                    existingItem.registros = 1; // Para operaciones no promedio, siempre será 1
                  }
                }
              } else {
                // Si no existe el item, agregarlo y asegurarse de calcular el promedio correctamente
                if (origen.valor !== null) {
                  nuevo.push({
                    id_criterios: id_criterio,
                    suma: parseFloat(origen.valor).toFixed(2),  // Solo formateo a 2 decimales
                    operacion: origen.operacion,
                    registros: 1 // Si es el primer registro para este criterio, inicializamos el contador a 1
                  });
                   indexCant = 1; // Iniciamos el contador con 1 para el primer valor válido
                }
              }

              return nuevo;
              
            }, []);

            // Al final, después de haber sumado todos los valores, calculamos el promedio si es necesario
            this.sumasDinamicasSC.forEach(item => {
              if (item.operacion === "Promedio" && item.registros > 0) {
                //console.log("Suma: ", parseFloat(item.suma), "Registros: ", item.registros)
                item.suma = (parseFloat(item.suma) / item.registros).toFixed(2);  // Calculamos el promedio final
              }
            });

            console.log("Sumas ScoreCard", this.sumasDinamicasSC);


            /*let cantidad_dias = response.data[1].filter(elemento=>elemento.id_criterios===3 && elemento.valor!==null).length//taminio de elementos con id 3 que es "Eficiencia"
            // Encontrar id_criterio 3 que es "Eficiencia"
            const sumaEficiencia =  this.sumasDinamicasSC.find(item => item.id_criterios === 3);
            //tomo el index
            let index = this.sumasDinamicasSC.findIndex(item => item.id_criterios === 3);
            // Calcular el resultado de suma / cantidad_dias
            let resultado = cantidad_dias > 0 ? sumaEficiencia.suma / cantidad_dias : 0; // Evitar división por cero
            if (index!=-1) {
              this.sumasDinamicasSC[index].suma = resultado.toFixed(2);
            }*/

            this.consultarDatosPonderacionID()
          } else {
            console.log("Error en la consulta ScoreCard", response.data)
          }
        }).catch(error => {
          console.log("Error en axios :-( ", error);
        });
      }
    },

  

    consultarCumplimientoScorecard(){
      
     
      if(this.select_area && this.anio_bateo){
        if(this.anio_bateo!==''){
          mes_numero = parseInt(this.mesesNumeros(this.mes_bateo))
        }
       

       // console.log("area:",this.select_area,"anio:",this.anio_bateo,"mes:",mes_numero);
        axios.get("cumplimiento_scorecard_Controller.php", {
          params:{
            area: this.select_area,
            mes: mes_numero,
            anio: this.anio_bateo,
            accion: 'consultarCumplimientoScorecard'
          }
        }).then(response => {
          //console.log("Respuesta Bateo", response.data)
            if (response.data[0] == true) {
              this.cumplimiento_scorecard = response.data[1];
              console.log("Bateo Cumplimiento", this.cumplimiento_scorecard)

              // Ordenar los datos por mes
            for (const equipo in this.cumplimiento_scorecard) {
              this.cumplimiento_scorecard[equipo].sort((a, b) => a.mes - b.mes);
            }

              let datos = response.data[1]; // Asignas el objeto de datos
              // Objetos para almacenar los resultados
              const equiposPorMes = {}; // Cantidad de equipos por mes
              const equiposConMasDe850 = {}; // Cantidad de equipos con más de 850 puntos por mes
              const porcentajeArribaDe850 = {}; // Porcentaje de equipos con más de 850 puntos por mes
              
              //buscar mes con mes por equipo.
              for (const equipo in datos) {
                datos[equipo].forEach((registro) => { 
                  const mes = registro.mes;
                  const puntos = registro.puntos;
              
                  // Contar equipos por mes
                  if (!equiposPorMes[mes]) {
                    equiposPorMes[mes] = 0;
                  }
                  equiposPorMes[mes]++;
              
                  // Contar equipos con más de 850 puntos por mes
                  if (puntos > 850) {
                    if (!equiposConMasDe850[mes]) {
                      equiposConMasDe850[mes] = 0;
                    }
                    equiposConMasDe850[mes]++;
                  }
                });
              }
              
             // Calcular el porcentaje de equipos con más de 850 puntos por mes
          for (const mes in equiposPorMes) {
            const totalEquipos = equiposPorMes[mes]; // Total de equipos en el mes
            const equiposArribaDe850 = equiposConMasDe850[mes] || 0; // Equipos con más de 850 puntos (si no hay, es 0)
            const porcentaje = (equiposArribaDe850 / totalEquipos) * 100; // Fórmula del porcentaje

            porcentajeArribaDe850[mes] = porcentaje.toFixed(2); // Redondear a 2 decimales
          }
          this.equiposPorMes = equiposPorMes
          this.equiposConMasDe850 = equiposConMasDe850
          this.porcentajeArribaDe850 = porcentajeArribaDe850
            // Mostrar resultados
            console.log("Cantidad de equipos por mes:",this.equiposPorMes );
            console.log("Cantidad de equipos con más de 850 puntos por mes:",  this.equiposConMasDe850);
            console.log("Porcentaje de equipos con más de 850 puntos por mes:",this.porcentajeArribaDe850);

            } else {
              console.log("Error en la consulta de Cumplimiento scorecard", response.data)
            }
        }).catch(error => {
          console.log("Error en el axios", error)
        })
      }
    },
    getPuntosPorMes(cumplimiento, mes) {
      const mesData = cumplimiento.find(item => item.mes === mes);
      return mesData ? mesData.puntos : '';
    },

    consultarNombresEquipos(){
      
    },

    consultarDatosPonderacionID() {
      
      let id_ponderacion = this.equipo_score.split("<->")[4];
      if (id_ponderacion == '') {
        return Swal.fire({
          title: "Equipo sin ponderacion",
          text: "El equipo no cuenta no una ponderacion asignada",
          icon: "warning"
        });
      }
      axios.get("ponderacionesController.php", {
        params: {
          accion: "datosPonderacionXID",
          id_ponderacion: id_ponderacion
        }
      }).then(response => {
        if (response.data[0] == true) {
          this.datosIDPonderacion = response.data[1]
          console.log("Ponderacion Equipo", this.datosIDPonderacion)
          this.nombrePonderacionAsignada = this.datosIDPonderacion[0] && this.datosIDPonderacion[0].nombre_ponderacion ? this.datosIDPonderacion[0].nombre_ponderacion : "";
          this.criteriosDinamicasSC = Object.values(this.datosIDPonderacion.reduce((acc, item) => {
            if (!acc[item.nombre]) {
              acc[item.nombre] = {
                nombre: item.nombre,
                id_criterios: item.id_criterios,
                tipo: item.tipo
              };
            }
            return acc;
          }, {}));

          console.log("Criterios Dinamicos", this.criteriosDinamicasSC)


          //Puntos Obtenidos grafica
          let puntos = [];
          let puntosFiltrados = [];
          this.sumasDinamicasSC.forEach(element => {
            puntosFiltrados = this.datosIDPonderacion.filter(items => items.id_criterios == element.id_criterios && items.hasta != null && items.desde != null && items.puntos != null && items.hasta >= element.suma && items.desde <= element.suma);
            let punto = puntosFiltrados.map(item => item.puntos)[0];
            puntos.push({
              id_criterios: element.id_criterios,
              puntos: punto
            });
          });

          //Puntos Obtenidos Input
          let puntosInput = []
          let inputDinamicos = this.criteriosDinamicasSC.filter(item => item.tipo == 'Input').map(datos => datos.id_criterios)
          inputDinamicos.forEach(id_criterio => {
            if (this.inputValorActual[id_criterio] !== null) {
              let valor = this.inputValorActual[id_criterio]
              puntosInput.push({
                id_criterios: id_criterio,
                puntos: this.datosIDPonderacion.filter(items => items.id_criterios == id_criterio && items.hasta != null && items.desde != null && items.puntos != null && items.hasta >= valor && items.desde <= valor).map(items => items.puntos)[0]
              })
              //console.log("aaaresultado",this.datosIDPonderacion.filter(items => items.id_criterios == id_criterio && items.hasta != null && items.desde != null && items.puntos != null && items.hasta >= valor && items.desde <= valor).map(items => items.puntos)[0])
            } else {
              this.puntosObtenidos[id_criterio] = null;
            }
          })
          this.puntosObtenidos = puntosInput
          this.puntosCriterios = puntos
          this.guardarptsOBT = puntos
          console.log('puntos criterios:',this.guardarptsOBT)

          //Multiplicando Puntos Obtenidos Graficas * Ponderacion  
          puntos.forEach((element) => {
            if (element.puntos !== null && element.puntos !== undefined && this.inputColumnaPonderacion[element.id_criterios] !== null && this.inputColumnaPonderacion[element.id_criterios] !== undefined) {
              this.puntosEvaluacion[element.id_criterios] = element.puntos * this.inputColumnaPonderacion[element.id_criterios];
            }
          });

          //Multiplicando Input Dinamicos Puntos Obtenidos * Ponderacion
          this.puntosObtenidos.forEach(elementos => {
            if (elementos.puntos != undefined && elementos.puntos != null && this.inputColumnaPonderacion[elementos.id_criterios] != null && this.inputColumnaPonderacion[elementos.id_criterios] != undefined) {
              console.log(elementos.puntos, "A*A", this.inputColumnaPonderacion[elementos.id_criterios])
              this.puntosEvaluacion[elementos.id_criterios] = elementos.puntos * this.inputColumnaPonderacion[elementos.id_criterios]
            }
          })
          //Puntos de asistencia Cumplimiento de Proyecto
          let cumplimiento_proyecto = this.asistenciaSC
          let obteniendoPuntos = this.datosIDPonderacion.filter(items => items.id_criterios == 10 && items.hasta != null && items.desde != null && items.puntos != null && items.hasta >= cumplimiento_proyecto && items.desde <= cumplimiento_proyecto); // 10 es id de cumplimiento de proyecto
          let puntosCumplimiento = obteniendoPuntos.map(item => item.puntos)[0];
          this.asistenciaPuntosCumplimiento = puntosCumplimiento

          //Multiplicando Cumplimiento de Proyecto
          if (this.asistenciaPuntosCumplimiento && this.inputColumnaPonderacion[10] != undefined) {
            this.puntosEvaluacion[10] = this.asistenciaPuntosCumplimiento * this.inputColumnaPonderacion[10];
          }

          this.totalSC = this.puntosEvaluacion.reduce((a, b) => a + (b ?? 0), 0);
          this.totalGuardar = this.totalSC;
          this.guardarTotalScoreCard();
        } else {
          console.log("Error en la consulta ScoreCard", response.data)
        }
      }).catch(error => {
        console.log("Erro en axios", error)
      })
    },
  
    saveInputDinamico(id_criterios, index) {
      let valor = this.inputValorActual[id_criterios]
      //obtengo el puntaje desde ponderacion
      if (!this.puntosObtenidos[id_criterios]) {
        this.puntosObtenidos[id_criterios] = []
      }
      //si el input es vacio colocar null de lo contrario multiplicar si cumple con la condicion filter
      if (valor == '') {
        this.puntosObtenidos[id_criterios] = null
      } else {
        this.puntosObtenidos[id_criterios] = this.datosIDPonderacion.filter(items => items.id_criterios == id_criterios && items.hasta != null && items.desde != null && items.puntos != null && items.hasta >= valor && items.desde <= valor).map(items => items.puntos)[0]
        //console.log("valor: ", valor, "puntosInput:", this.puntosObtenidos)
      }

      this.saveInputSC(id_criterios, index)//para que se ejecute la multiplicacion en la fila
    },
    saveInputSC(id_criterios, index) {
      this.inputPonderacionSC = ''
      if (id_criterios === 10) {//cumplimiento del proyecto
        console.log("10")
        if (this.inputColumnaPonderacion[id_criterios] && !isNaN(this.asistenciaPuntosCumplimiento)) {//si numero en numero multiplicar 
          console.log("A")
          this.puntosEvaluacion[index] = this.inputColumnaPonderacion[id_criterios] * this.asistenciaPuntosCumplimiento
        } else {//de lo contrario colocarlo null
          this.puntosEvaluacion[index] = null
        }
      } else if (this.puntosObtenidos[id_criterios] != '') {//si existe input dinamico un valor multiplicar si no continuar 
        console.log("B")
        if (this.inputValorActual[id_criterios] != '' && this.puntosObtenidos[id_criterios] >= 0 && this.inputColumnaPonderacion[id_criterios] >= 0 && this.inputColumnaPonderacion[id_criterios] != "") {
          this.puntosEvaluacion[index] = this.inputColumnaPonderacion[id_criterios] * this.puntosObtenidos[id_criterios];
          console.log("Multipleque")
        } else {
          this.puntosEvaluacion[index] = null
        }
      } else {//si existe input dinamico un valor multiplicar si no continuar 
        //HAY QUE VALIDAR PRIMERO SI NO EXISTEN PUNTOS OBTENIDOS
        if (this.inputColumnaPonderacion[id_criterios] && this.inputColumnaPonderacion[id_criterios] != "" && !isNaN(this.puntosCriterios.filter(items => items.id_criterios == id_criterios).map(items => items.puntos) && !isNaN(this.puntosCriterios.filter(items => items.id_criterios == id_criterios).map(items => items.puntos).length > 0))) {
          if (typeof (this.puntosCriterios.filter(items => items.id_criterios == id_criterios && items.puntos != '').map(items => items.puntos)[0]) === 'number') {//si esta indefinado el puntaje no multiplicara
            console.log("C");
            this.puntosEvaluacion[index] = this.inputColumnaPonderacion[id_criterios] * this.puntosCriterios.filter(items => items.id_criterios == id_criterios && items.puntos != '').map(items => items.puntos)
          } else {
            if (this.inputValorActual[id_criterios] != '' && this.puntosObtenidos[id_criterios] >= 0 && this.inputColumnaPonderacion[id_criterios] && this.inputColumnaPonderacion[id_criterios] != "") {
              console.log("D");
              this.puntosEvaluacion[index] = this.puntosObtenidos[id_criterios] * this.inputColumnaPonderacion[id_criterios];
            } else {
              this.puntosEvaluacion[index] = null
            }
          }
        } else {
          this.puntosEvaluacion[index] = null
        }
      }
      this.totalSC = this.puntosEvaluacion.reduce((a, b) => a + (b ?? 0), 0);

      let existevacio = this.puntosEvaluacion.some(element => element == null);//Si existe un null en todo el arreglo devolvera true
      console.log(existevacio)

      this.scoreCardCompletado = !this.puntosEvaluacion.some(element => element == null)
      //No inputs dinamicos 
      //let suma =arreglo.reduce((a,b)=>a+b, 0);
    },
    //inputActivar
    activarInput(index) {
      this.inputPonderacionSC = index;
    },
    //al salir del input
    banderaInputSC() {
      this.inputPonderacionSC = ''
    },

    consultarEADColaborador() {
      axios.post("crud_ead.php", {
        accion: 'consultarEADColaborador'
      }).then(response => {
        console.log(response.data);
        if (response.data[0] == true) {
          this.consultaEAD[0] = response.data[1];
          this.equipo_grafica = response.data[1][0].id + '<->' + response.data[1][0].nombre_ead + '<->' + response.data[1][0].planta + '<->' + response.data[1][0].area//asignando valor por defaul al select de equipo seleccionado
          this.consultarCriterioColaborador()
        } else {

          console.log("No se consulto correctamente el equipo del colaborador")
        }
      }).catch(error => {
        console.log("Error en la consulta :-( " + error)
      }).finally(() => {

      })
    },
    consultarCriterioColaborador() {
      this.idCriterioGrafica = ''
      if (this.equipo_grafica) {
        axios.get("criteriosController.php", {
          params: {
            accion: 'consultarCriterioColaborador',
            id_equipo: this.equipo_grafica.split('<->')[0]
          }
        }).then(response => {
          if (response.data[0] == true) {
            this.criterioGrafica = response.data[1];
            this.idCriterioGrafica = response.data[1][0].id
            this.consultarCausas()
          } else {
            console.log("Error al consultar" + response.data)
          }
          console.log("criterios grafica", response.data)
        }).catch(error => {
          console.log("Error en axios.php" + error)
        })
      }
    },



    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////PONDERACION/////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    consultarCriterio() {
      axios.get("criteriosController.php", {
        params: {
          accion: 'Consultar',
        }
      }).then(response => {
        if (response.data[0] == true) {
          //this.criterios =response.data[1];//criterios con id
          this.filasSC = response.data[1];//criterios solo nombres sin id
          console.log("CRITERIOS", response.data[1])
        } else {
          console.log("Error en la consulta Criterios", response.data)
        }
      }).catch(error => {
        console.log("Error en axios", error)
      })
    },
    consultarPonderaciones() {
      axios.get("ponderacionesController.php", {
        params: {
          accion: "consultarPonderaciones"
        }
      }).then(response => {
        if (response.data[0] == true) {
          this.ponderaciones = response.data[1];//todos los datos de las ponderaciones
          //Obtenga titulo ponderaciones unicas
          this.tablasPonderaciones = Object.values(
            this.ponderaciones.reduce((acc, objeto) => {
              acc[objeto.id_ponderacion] = { ponderacion: objeto.ponderacion, id_ponderacion: objeto.id_ponderacion, area: objeto.area};
              return acc;
            }, {})
          ).reverse();


          console.log("Ponderaciones", this.ponderaciones)
          console.log("tablasPonderaciones", this.tablasPonderaciones);

          ///////////////////// 
          let nueva = {};
          this.ponderaciones.forEach((ponderacion) => {
            const id = ponderacion.id;
            const idPonderacion = ponderacion.id_ponderacion;
            const idCriterio = ponderacion.id_criterios;
            const criterio = ponderacion.criterio;
            const desde = ponderacion.desde;
            const hasta = ponderacion.hasta;
            const puntos = ponderacion.puntos;

            if (!nueva[idPonderacion]) {
              nueva[idPonderacion] = {}
            }
            if (!nueva[idPonderacion][criterio]) {
              nueva[idPonderacion][criterio] = []
            }
            nueva[idPonderacion][criterio].push({ id, desde, hasta, puntos });
          });
          console.log("Datos Tablas Ponderacion", nueva)

          this.datosTablaPonderacion = nueva
          ///////////

          /*nuevoObjeto = {};
          this.tablasPonderaciones.reverse().forEach(ponderaciones => {
            nuevoObjeto[ponderaciones.id_ponderacion] = this.ponderaciones.filter(items => items.id_ponderacion === ponderaciones.id_ponderacion).map(item => ({
              id: item.id,
              desde: item.desde,
              hasta: item.hasta,
              puntos: item.puntos
            }));
          });
    
          this.valoresPon = nuevoObjeto;
          console.log("valoresTablas", this.valoresPon);*/
        } else {
          console.log("No se realizó la consulta correctamente: ", response.data)
        }

      }).catch(error => {
        console.log("Error en axios " + error)
      })
    },

    consultarAreas(){
      this.areas = "";
      axios.post("crud_ead.php", {
        accion: 'consultarAreasEADs',
        planta: this.select_planta_foro,
      }).then(response => {
        console.log(response.data);
        this.areasEADs = response.data[4].areas;
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },

    quitarCriterioNuevaPonderacion(posicion) {
      this.filasSC.splice(posicion, 1);//(posicion,cantidad)
    },
    refrescarNuevaPonderaciones() {
      this.nueva_ponderacion = true
      this.consultarCriterio()
      //this.consultarPonderaciones()
      //this.consultarEAD()
    },
    modalNuevoCriterio() {
      this.myModal = new bootstrap.Modal(document.getElementById("modalNuevoCriterio"))
      this.myModal.show()
      this.verMenu = "No";
    },
    cerrarModalNuevoCriterio() {
      this.verMenu = 'Si'
    },
    guardarNuevoCriterio() {
      console.log(this.nombre_nuevo_criterio)
      console.log(this.tipo_criterio)
      if (this.nombre_nuevo_criterio != '') {
        axios.post("criteriosController.php", {
          nuevo_criterio: this.nombre_nuevo_criterio,
          tipo_criterio: this.tipo_criterio
        }).then(response => {
          console.log(response.data)
          if (response.data == true) {
            alert("Se inserto el nuevo criterio correctamente")
            this.consultarCriterio()
            this.myModal.hide()
            this.verMenu = 'No'
            this.nombre_nuevo_criterio = ''
          } else {
            alert("Algo salio mal")
          }
        }).catch(error => {
          console.log("Error en axios " + error)
        })
      } else {
        alert("Coloque el nombre del criterio")
      }
    },
    guardarPonderacion() {
      if (this.nombre_ponderacion == '') {
        return Swal.fire({
          title: "Digite un Nombre",
          text: "Favor de colocar un nombre a la nueva ponderacion",
          icon: "question"
        });
      }
      let nuevaPonderacion = {}; // Inicializo el Objeto
      for (let i = 0; i < this.filasSC.length; i++) {//FILAS
        let elemento = this.filasSC[i].id;
        if (!nuevaPonderacion[elemento]) {
          nuevaPonderacion[elemento] = {
            'Meta Retadora': [],
            'Entitlement': [],
            'Meta Calculada': [],
            'Línea Base': [],
            'Reprobatoria': []
          };
        }
        for (let j = 0; j <= 4; j++) {//COLUMNAS
          if (j === 0) {
            nuevaPonderacion[elemento]['Meta Retadora'].push(
              document.getElementById('DeFila' + i + 'Columna' + j).value,
              document.getElementById('HastaFila' + i + 'Columna' + j).value,
              document.getElementById('PuntosFila' + i + 'Columna' + j).value
            );
          }
          if (j === 1) {
            nuevaPonderacion[elemento]['Entitlement'].push(
              document.getElementById('DeFila' + i + 'Columna' + j).value,
              document.getElementById('HastaFila' + i + 'Columna' + j).value,
              document.getElementById('PuntosFila' + i + 'Columna' + j).value
            );
          }
          if (j === 2) {
            nuevaPonderacion[elemento]['Meta Calculada'].push(
              document.getElementById('DeFila' + i + 'Columna' + j).value,
              document.getElementById('HastaFila' + i + 'Columna' + j).value,
              document.getElementById('PuntosFila' + i + 'Columna' + j).value
            );
          }
          if (j === 3) {
            nuevaPonderacion[elemento]['Línea Base'].push(
              document.getElementById('DeFila' + i + 'Columna' + j).value,
              document.getElementById('HastaFila' + i + 'Columna' + j).value,
              document.getElementById('PuntosFila' + i + 'Columna' + j).value
            );
          }
          if (j === 4) {
            nuevaPonderacion[elemento]['Reprobatoria'].push(
              document.getElementById('DeFila' + i + 'Columna' + j).value,
              document.getElementById('HastaFila' + i + 'Columna' + j).value,
              document.getElementById('PuntosFila' + i + 'Columna' + j).value
            );
          }
        }
      }
      console.log("NUEVA PONDERACION", nuevaPonderacion)
      //console.log("Nueva Ponderacion", nuevaPonderacion)
      axios.post("ponderacionesController.php", {
        nombre_ponderacion: this.nombre_ponderacion,
        nuevaPonderacion: nuevaPonderacion
      }).then(response => {
        if (response.data[0] === true) {
          console.log("Respuesta al guardar", response.data);
          this.nueva_ponderacion = false
          Swal.fire({
            title: "Se guardo con éxito",
            text: "Los datos se guardaron con éxito",
            icon: "success"
          });
          this.consultarPonderaciones()
        } else {
          Swal.fire({
            title: "Error",
            text: "No se guardo la ponderacion",
            icon: "error"
          });
          console.log(response.data)
        }
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },
    
    cancelarPonderacion() {
      this.nueva_ponderacion = false
    },
    inputNuevoNombre(nombre) {
      if (this.inputNewName == nombre) {
        this.inputNewName = ''
      } else {
        this.inputNewName = nombre
      }
    },
    asignarDesignarPonderacion(id_ead, id_ponderacion, event) {
      this.equipo_score = ''
      if (event.target.checked != true) { id_ponderacion = null; }
      axios.put("ponderacionesController.php", {
        accion: "AsignarPonderacion",
        id_ead: id_ead,
        id_ponderacion: id_ponderacion,
      }).then(response => {
        if (response.data == true) {
          this.consultarEAD()
          //this.consultarPonderaciones()
        } else {
          console.log(response.data)
        }
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },
    inputEditar(activar) {
      console.log("activar" + activar)
      if (this.inputDesactivado == activar) {
        this.inputDesactivado = ''
      } else {
        this.inputDesactivado = activar
      }
    },
    saveDate(id_registro, id_input, columna) {
      let nuevo_valor = document.getElementById(id_input).value;
      if (nuevo_valor == '') {
        nuevo_valor = null
      } else {
        nuevo_valor = parseFloat(nuevo_valor).toFixed(2)
      }
      axios.put("ponderacionesController.php", {
        id: id_registro,
        valor: nuevo_valor,
        columna: columna
      }).then(response => {
        if (response.data == true) {
          this.inputDesactivado = '';
          this.consultarPonderaciones()
        } else {
          console.log("Algo salio mal al guardar " + response.data)
        }
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },
    actualizarNombrePonderacion(index, id_ponderacion) {
      let nuevo_nombre = document.getElementById('inputNombre' + index).value;
      axios.put("ponderacionesController.php", {
        nuevo: nuevo_nombre,
        id_ponderacion: id_ponderacion
      }).then(response => {
        if (response.data == true) {
          this.inputNewName = ''
          this.consultarPonderaciones()
        } else {
          console.log("Algo salio mal en cambiar el nombre" + response.data)
        }
      }).catch(error => {
        console.log("Error en axios: " + error)
      })
    },
    eliminarPonderacion(id_ponderacion, nombre_ponderacion) {
      Swal.fire({
        title: "Eliminar Ponderacion?",
        html: `<label>Esta seguro de eliminar la <b>${nombre_ponderacion}</b>!</label>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete("ponderacionesController.php", {
            params: {
              id: id_ponderacion
            }
          }).then(response => {
            if (response.data == true) {
              Swal.fire({
                title: "Eliminada!",
                html: `<label>"La ponderacion <b>${nombre_ponderacion}</b> se elimino"</label>`,
                icon: "success"
              });
              this.consultarPonderaciones()
            } else {
              console.log("Algo salio mal ", response.data)
            }
          }).catch(error => {
            console.log("Error en axios: ", error)
          });
        }
      });
    }
  }
};


const App = Vue.createApp(app);
App.mount("#app");


