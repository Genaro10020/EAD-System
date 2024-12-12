<?php session_start();
if ($_SESSION['nombre'] && $_SESSION['tipo_acceso']) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include('head.php'); ?>
    </head>

    <body class="container-fluid" >

        <header>
            <div id="header-app"></div>
        </header>
        <div id="app" class="col-12" style="min-height: 80vh;" v-cloak>
            <img v-if="loading==true" src="img/loading.gif">
            <div class="row d-flex text-center">
                <?php
                if (isset($_SESSION['tipo_acceso']) && $_SESSION['tipo_acceso'] != 'Evaluador') {
                ?>
                    <div v-show="verMenu=='Si'" class="col-1 dropdown" style="width:180px;  z-index: 2000; ">
                        <p class="dropbtn text-white" style="max-height:10px;">
                            <i class="bi bi-list me-5">Menú</i>
                        </p>
                        <div class="dropdown-content">
                            <?php
                            if (isset($_SESSION['tipo_acceso']) && $_SESSION['tipo_acceso'] == 'Admin') {
                                if ($_SESSION['tipo_usuario'] == 'Admin' || $_SESSION['tipo_usuario'] == 'Coordinador') {
                            ?>
                                <a><i class="bi bi-gear-fill">Configuracion</i></a>
                                <a><button class="btn_menu" @click="ventanas('Departamentos')"><b>Departamentos</b></button></a>
                                <a><button class="btn_menu" @click="ventanas('Usuarios')"><b>Usuarios</b></button></a>
                                <?php } ?>
                                <a><i class="bi bi-diagram-3-fill"> Equipos alto desempeño</i></a>
                                <a> <button class="btn_menu" @click="ventanas('Crear EAD'), consultarColaboradores(),consultarEAD()"><b>Crear EAD</b></button></a>
                                <a><i class="bi bi-people-fill"></i>Gestión</a>
                                <a> <button class="btn_menu" @click="ventanas('Gestion Sesiones'),consultarEAD(),consultarAvanceEtapas(),tomarDiaActual(),consultarCantidadFaseXEtapas(),tomarAnioActual(),semanasAnio()"><b> Gestion de Sesiones</b></button></a>
                                <?php
                                if ($_SESSION['tipo_usuario'] == 'Admin') {
                                ?>
                                    <a><i class="bi bi-question-circle-fill">Preguntas</i></a>
                                    <a><button class="btn_menu" @click="ventanas('Preguntas'),consultarPreguntas()"><b> Preguntas</b></button></a>
                                    <a><i class="bi bi-trophy-fill"> Competencias</i></a>
                                    <a><button class="btn_menu" @click="ventanas('Crear Competencia'),cosultarEADxPlantaxArea(),consultarPlantasEADs(),consultarEvaludores(),consultarForos()"><b>Foros</b></button></a>
                                    <!--<a><button class="btn_menu" @click="ventanas('CrearCompetenciaPlanta')"><b>Crear comp. planta </b></button></a>-->
                                    <!--<a><button class="btn_menu" @click="ventanas('Competencias')"><b>Competencia</b></button></a>-->
                                    <!--<a><button class="btn_menu" @click="ventanas('CompetenciaPlanta')"><b>Competencia de planta</b></button></a>-->
                                    <!--<a><button class="btn_menu" @click="ventanas('Evaluar')"><b>Evaluar</b></button></a>-->
                                    <a><i class="bi bi-bar-chart-line-fill"> Graficos</i></a>
                                <?php }
                                if ($_SESSION['tipo_usuario'] == 'Admin' || $_SESSION['tipo_usuario'] == 'Coordinador') {
                                ?>
                                    <a><button class="btn_menu" @click="ventanas('Ponderación'),consultarCriterio(),consultarPonderaciones(),consultarEAD()"><b>Ponderación</b></button></a>
                                    <a><button class="btn_menu" @click="ventanas('Graficas'),consultarEAD(),consultarCriterios()"><b>Graficas</b></button></a>
                                <?php } ?>
                                <a><button class="btn_menu" @click="ventanas('ScoreCard'),consultarEAD(),consultarSeguimientoAsistencia(),consultarScoreCard()"><b>Scorecard</b></button></a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="row container-fluid divLineaMenu d-flex text-center align-items-center text-light" style="font-size:14px; min-height:30px ">
                    <div class="offset-2 col-4 offset-lg-2 col-lg-2 d-flex justify-content-center align-items-center">
                        <label class="text-center" style="font-size: 0.7em"> Ventana: {{ventana}} </label>
                    </div>
                    <div class="col-6 col-lg-8">
                        <div class="row">
                            <div class="col-6">
                                <label style="font-size: 0.7em"> <?php echo $_SESSION['nombre']; ?> (<?php echo $_SESSION['tipo_acceso']; ?>) </label>
                            </div>
                            <div class="col-6">
                                <a href="index.php"><button class="btn btn-danger btn-salir  rounded-pill border-0 mt-0 py-0"><i class="bi bi-door-closed"></i> Salir</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!---->
                <!-- <div class="col-12 col-sm-3  col-lg-2 col-xl-2 col-xxl-2 ">
                                    <button class="btn_menu" @click="ventanas('usuarios')"><b>Usuarios</b></button>
                                </div>
                                <div class="col-12 col-sm-3   col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu" @click="ventanas('Departamentos')"><b>Departamentos</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('score'), consultarScoreCard(),consultarObjetivos()" ><b>Scorecard</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('crearEAD'), consultarColaboradores()" ><b>Crear EAD</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('equiposEAD')" ><b>Equipos EAD</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('Graficas')" ><b>Graficas</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2 mt-sm-0 mt-lg-2">
                                    <button class="btn_menu"  @click="ventanas('Competencias')" ><b>Competencia de area</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2 mt-sm-0 mt-lg-2">
                                    <button class="btn_menu"  @click="ventanas('CompetenciaPlanta')" ><b>Competencia de planta</b></button>
                                </div> -->
            </div>
            <div v-if="ventana=='Usuarios'" class="row" > <!--bloque USUARIO-->

                <div class="seccion1 col-12  col-lg-4 mt-2">

                    <div class="formulario col-12 mx-auto col-sm-112 col-lg-10  col-xl-8 col-xxl-6  pt-4 ps-2 pe-2 ps-lg-3  pe-lg-3  rounded shadow-sm">
                        <h6 class="text-center label-session "><b>{{titulo_formulario_usuarios}}</b></h6>
                        <form @submit.prevent="nuevoActualizarUsuario" method="POST">
                            <div class="mb-2">
                                <label class=" label-session">Nombre</label>
                                <input type="text" class="form-control" v-model="nombre" required>
                            </div>

                            <div class="mb-2">
                                <label class=" label-session ">Nómina (Usuario)</label>
                                <input type="text" class="form-control" v-model="nomina" required>
                            </div>
                            <div class="mb-2">
                                <label class=" label-session ">Contraseña:</label>
                                <input type="text" class="form-control" v-model="contrasena" required>
                            </div>
                            <div class="mb-2">
                                <label class="label-session">Planta</label>
                                <select v-model="selector_planta" class="form-control select">
                                    <option disabled default selected value="">Seleccione Planta..</option>
                                    <option v-for="planta in plantas" :value="planta.nombre">{{planta.nombre}}</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="label-session ">Área</label>
                                <select v-model="selector_area" class="form-control select">
                                    <option disabled default selected value="">Seleccione Área..</option>
                                    <option v-for="area in areas" :value="area.nombre">{{area.nombre}}</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class=" label-session ">Procesos</label>
                                <select v-model="selector_subarea" class="form-control select">
                                    <option disabled default selected value="">Seleccione Proceso.</option>
                                    <option v-for="subarea in subareas" :value="subarea.nombre">{{subarea.nombre}}</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class=" label-session ">Tipo usuario</label> <label @click="datosModalTipoUsuario()"><i class="icono-mas bi bi-plus-circle p-1"></i></label>
                                <select v-model="selector_tipo_usuario" class="form-control select">
                                    <option disabled default selected value="">Seleccione Tipo..</option>
                                    <option v-for="tipo in tipos" :value="tipo">{{tipo}}</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class=" label-session ">Accesos</label>
                                <select v-model="selector_tipo_acceso" class="form-control select">
                                    <option disabled default selected value="">Seleccione Acceso..</option>
                                    <option v-for="acceso in tipo_accesos" :value="acceso">{{acceso}}</option>
                                </select>
                            </div>

                            <div class="text-center mt-3 mb-3 d-flex justify-content-evenly">
                                <button class="btn" :class="bandera_alta_o_actualizar== 1 ? 'btn-danger':'btn-warning'" type="submit">{{texto_btn_submit}}</button>
                                <button v-if="bandera_alta_o_actualizar== 2" class="btn btn-secondary" type="button" @click="actualizarUsuario('insertar')">Cancelar</button>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="seccion2 col-12 col-lg-8 mt-2">
                    <div class="scroll">
                        <table class="table table-striped table-bordered border-dark ">
                            <thead class=" border-dark">
                                <tr class="text-center ">
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Nómina</th>
                                    <th scope="col">Contraseña</th>
                                    <th scope="col">Planta</th>
                                    <th scope="col">Área</th>
                                    <th scope="col">Proceso</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Accesos</th>
                                    <th scope="col">Actualizar</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(usuario, index) in usuarios">
                                    <th scope="row">{{index+1}}</th>
                                    <td>{{usuario.nombre}}</td>
                                    <td class="text-center">{{usuario.nomina}}</td>
                                    <td class="text-center">{{usuario.contrasena}}</td>
                                    <td class="text-center">{{usuario.planta}}</td>
                                    <td>{{usuario.area}}</td>
                                    <td>{{usuario.subarea}}</td>
                                    <td>{{usuario.tipo_usuario}}</td>
                                    <td>{{usuario.tipo_acceso}}</td>
                                    <td class="text-center"><button v-if="bandera_alta_o_actualizar == 1" class="btn btn-warning btn-boton px-2 py-0" @click="actualizarUsuario('actualizar',usuario.id)">Actualizar</button></td>
                                    <td class="text-center"><button v-if="usuario.tipo_acceso=='Usuario' && bandera_alta_o_actualizar == 1" class="btn btn-danger btn-boton px-2 py-0" @click="eliminarUsuario(usuario.id)">Eliminar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--ModalUsuarios-->
                <div id="modalUsuarios" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tipo de Usuario</h5>
                                <button type="button" class="btn-close" @click="cerrarModal()" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center d-flex justify-content-center">
                                <label class="me-1 my-auto">Nuevo: </label><input class="form-control w-50" type="text" v-model="nuevo_tipo_usuario"></input>
                                <button class="btn btn-success btn-guardar ms-3 px-2 py-0 my-1" @click="tipoUsuariosCRUD('insertar')">Agregar</button>

                            </div>
                            <div class="p-2">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tipo Usuarios</th>
                                            <!--<th scope="col">Actualizar</th>-->
                                            <th scope="col">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(tipo, index) in tipos" :key="index">
                                            <td>{{tipo}}</td>
                                            <!--<td><button class="btn btn-warning btn-boton px-2 py-0">Actualizar</button></td>-->
                                            <td><button class="btn btn-danger btn-boton px-2 py-0" @click="tipoUsuariosCRUD('eliminar',tipo)">Eliminar</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary py-1" @click="cerrarModal()">Salir</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FinModalDeDepartamento-->
            </div><!--FIN BLOQUE USUARIOS-->
            <div v-if="ventana=='Departamentos'" class="row"> <!--bloque DEPARTAMENTO-->

                <div class="col-12 col-lg-4 flex-colum  align-items-center text-center">
                    <div class="cinta-tablas px-2 rounded-top ">
                        <button class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="datosModal('Planta','Nueva')">Crear Planta</button>
                    </div>
                    <div class="scroll w-100 ">
                        <table class="table  table-bordered border-dark ">
                            <thead class=" border-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Planta</th>
                                    <th scope="col">Actualizar</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody class=" border-dark text-start">
                                <tr v-for="(planta, index) in plantas">
                                    <th scope="row">{{index+1}}</th>
                                    <td>{{planta.nombre}}</td>
                                    <td><button class="btn btn-warning btn-boton px-2 py-0" @click="datosModal('Planta','Actualizar',planta.id,planta.nombre)">Actualizar</button></td>
                                    <td><button class="btn btn-danger btn-boton px-2 py-0 " @click="eliminarDepartamento('Planta',planta.id)">Eliminar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-4 flex-colum  align-items-center text-center">
                    <div class="cinta-tablas  px-2 rounded-top">
                        <button class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="datosModal('Área','Nueva')">Crear Área</button>
                    </div>
                    <div class="scroll w-100">
                        <table class="table table-bordered border-dark  ">
                            <thead class=" border-dark rounded-top">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Área</th>
                                    <th scope="col">Actualizar</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody class=" border-dark text-start">
                                <tr v-for="(area, index) in areas">
                                    <th scope="row">{{index+1}}</th>
                                    <td>{{area.nombre}}</td>
                                    <td><button class="btn btn-warning btn-boton px-2 py-0" @click="datosModal('Área','Actualizar',area.id,area.nombre)">Actualizar</button></td>
                                    <td><button class="btn btn-danger btn-boton px-2 py-0" @click="eliminarDepartamento('Area',area.id)">Eliminar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-4 flex-colum  align-items-center text-center">
                    <div class="cinta-tablas  px-2 rounded-top">
                        <button class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="datosModal('Subárea','Nueva')">Crear Proceso</button>
                    </div>
                    <div class="scroll w-100">
                        <table class=" table table-bordered border-dark  ">
                            <thead class="border-dark ">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Subárea</th>
                                    <th scope="col">Actualizar</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody class=" border-dark text-start">
                                <tr v-for="(subarea, index) in subareas">
                                    <th scope="row">{{index+1}}</th>
                                    <td>{{subarea.nombre}}</td>
                                    <td><button class="btn btn-warning btn-boton px-2 py-0" @click="datosModal('Subárea','Actualizar',subarea.id,subarea.nombre)">Actualizar</button></td>
                                    <td><button class="btn btn-danger btn-boton px-2 py-0" @click="eliminarDepartamento('Subarea',subarea.id)">Eliminar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--ModalDepartamento-->
                <div id="modal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{accion_departamento}} {{departamento}}</h5>
                                <button type="button" class="btn-close" @click="cerrarModal()" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center d-flex justify-content-center">
                                <label class="me-1 my-auto">Nombre: </label><input class="form-control w-50" type="text" v-model="nuevo_departamento"></input>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary py-1" @click="cerrarModal()">Salir</button>
                                <button v-if="accion_departamento=='Actualizar'" type="button" class="btn btn-warning py-1" @click="actualizarDepartamento()">Actualizar</button>
                                <button v-else type="button" class="btn btn-primary py-1" @click="nuevoDepartamento()">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FinModalDeDepartamento-->
            </div><!--FIN BLOQUE USUARIOS-->


            <div v-if="ventana=='Crear EAD'" class="row"> <!--bloque CREAR EAD-->
                <div class="col-12 col-lg-6  col-xl-5 contenido d-flex justify-content-center align-items-center">
                    <div class="row contenido-form  border border-5 shadow-lg text-center">
                        <div><!--agrupando todos los campos-->
                            <div class="col-12 mt-3"> <!--nombre del equipo-->
                                <div>
                                    <span>Nombre del equipo</span>
                                </div>
                                <div>
                                    <input v-model="nombre_ead" type="text" class="input-nombreEAD w-75 text-center"></input>
                                </div>
                            </div>
                            <div class="col-12"><!--Planta-->
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text ">Planta</span>
                                    <select v-model="select_planta" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="planta in plantas">
                                            {{planta.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12"><!--Area-->
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text">Area</span>
                                    <select v-model="select_area" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="area in areas">
                                            {{area.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12"><!--Proceso-->
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text">Proceso</span>
                                    <select v-model="select_proceso" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="subarea in subareas">
                                            {{subarea.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12"><!--Lider del Equipo-->

                            </div>
                            <div class="col-12"><!---->
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text">Coordinador</span>
                                    <select v-model="select_coordinador" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="usuario in filtraCordinador()">
                                            {{usuario.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text">Jefe de Área</span>
                                    <select v-model="select_jefe_area" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="usuario in filtraJefeArea()">
                                            {{usuario.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text">Ing. de Proceso</span>
                                    <select v-model="select_ing_proceso" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="usuario in filtraIngenieroProceso()">
                                            {{usuario.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text">Ing. de Cálidad</span>
                                    <select v-model="select_ing_calidad" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="usuario in filtraIngenieroCalidad()">
                                            {{usuario.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text">Supervisor</span>
                                    <select v-model="select_supervisor" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="usuario in filtraSupervisor()">
                                            {{usuario.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="checkIntegrantes.length>0" class="col-12 text-center " style="font-size:10px">
                                <label class="mt-2"> Integrantes:</label>
                                <ul class="text-start">
                                    <li class="listaIntegrantes d-flex d-block" v-for="(integrantes,index) in checkIntegrantes" @mouseover="mostrar(index)" @mouseleave="ocultar(index)" @click="asignarLiderEquipo(index)"> {{index+1}}.- {{integrantes.split("<->")[1]}} <i style="display:none" :id="'estrella'+index" class="estrella bi-star-fill"></i></li>
                                </ul>
                                <label v-if="select_lider_equipo==''" class="alert alert-warning p-2">De los integrantes seleccionados, de click para identificar el Líder</label>
                                <label v-if="select_lider_equipo!=''">Líder el Equipo:</label><b>{{select_lider_equipo.split("<->")[1]}}</b>
                            </div>
                            <div class="col-12 text-center mt-4 mb-2">
                                <button v-if="var_actualizarEAD" class="botones-actualizar rounded-pill border-0 my-1 px-2 mb-2" @click="crearEAD('actualizar')">Actualizar EAD</button>
                                <button v-if="!var_actualizarEAD" class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="crearEAD('insertar')">Crear EAD</button>
                                <button v-if="var_actualizarEAD" class="botones-cancelar rounded-pill border-0 my-1 px-2 mb-2 ms-2" @click="cancelarActualizar()">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-xl-2"><!--Colaboradores-->
                    <div class="d-flex justify-content-around mt-2 mb-1">
                        <button class="btn btn-success btn-boton px-2 py-0 me-2" @click="modalAltaColaborador()"><i class="bi bi-person-plus-fill"></i> Dar de alta colaborador</button>
                        <button class="btn btn-danger btn-boton px-2 py-0 ms-2"><i class="bi bi-person-x-fill"></i> Dar de baja colaborador</button>
                    </div>
                    <span class=" badge text-light bg-secondary mb-2 w-100">Selecciona los colaboradores</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar por nombre o nómina" v-model="buscar_colaborador" @keyup="consultarColaboradores()" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="scroll w-100">
                        <div class="form-check" v-for="colaborador in colaboradores" style="font-size:0.7em;">
                            <input class="form-check-input" type="checkbox" :value="colaborador.id+'<->'+colaborador.colaborador" v-model="checkIntegrantes" @change="seleccionadosIntegrantes(), colaboradorDesmarcado($event,colaborador.id)" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{colaborador.colaborador}} ({{colaborador.numero_nomina}})
                            </label>
                        </div>
                    </div>
                </div>
                <div class=" col-xl-5 scroll6">
                    <div class="row">
                        <div class="col-6 d-flex justify-content-center" v-for="(equipos, index) in consultaEAD" :key="index">
                            <div class="tarjeta my-2">
                                <div class="container text-center">
                                    <label class="letrasCard text-center mb-2">
                                        {{ equipos[0].nombre_ead }}
                                    </label>
                                    <br>
                                    <b class="letrasCard">Planta:</b> {{ equipos[0].planta }}
                                    <b class="letrasCard">Area:</b> {{ equipos[0].area }}<br>
                                    <span class="badge bg-dark" style="font-size: 0.7em">Lider: {{equipos[0].lider_equipo.split('<->')[1]}} <i class="bi-star-fill text-warning"></i></span>
                                    <ul class="text-start">
                                        <li v-for="(integrante, posicion) in integrantesEAD[equipos[0].id]" style="margin-bottom: 2px; font-size: 12px;">
                                            {{ posicion+1 }}.- {{ integrante.colaborador }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div>
                                        <button class="btn btn-primary btn-boton px-2 py-0 ms-3" @click="modalAsignarTabla(equipos[0].id)">
                                            <i class="bi bi-table"></i> Asignar Acceso
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn btn-warning btn-boton px-2 py-0 ms-3" @click="datosParaEditarEAD(equipos[0].id,index)">
                                            <i class="bi bi-pencil"></i> Actualizar
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn btn-danger btn-boton px-2 py-0 ms-3" @click="eliminarEquipo(equipos[0].id,equipos[0].nombre_ead)">
                                            <i class="bi bi-pencil"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               <!--Asignar Tabla a colaborador-->
                <div id="modal_asignar_tabla" class="modal" data-bs-keyboard="false" data-bs-backdrop="static"  tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="mx-auto">Asignar Tabla</h6>
                                <button type="button" class="badge rounded-pill bg-secondary border border-0" @click="cerrarModal()">X</button>
                            </div>
                            <div class="row modal-body  text-start text-sm-center d-flex justify-content-around">
                                        <div class="tarjeta2 my-2" v-if="equipoAsignarTabla.length>0">
                                            <div class="container text-center">
                                                <ul class="text-start">
                                                        <li v-for="(integrante, posicion) in equipoAsignarTabla" style="margin-bottom: 50px; font-size: 12px;">
                                                            <div class="col-12 d-flex">
                                                                <div class="col-6">
                                                                    {{ posicion+1 }}.- {{ integrante.colaborador }} 
                                                                </div>
                                                                <div class="col-6" v-if="criterioAsignar.length>0"> 
                                                                    <select class="form-select me-5" style="font-size:0.9em"  v-model="seleccionarAcceso[posicion]" @change="asignarAccesoGrafica(integrante.id,posicion)">
                                                                        <option value="">Sin Acceso</option>
                                                                        <option v-for="criterio in criterioAsignar" :value="criterio.id" >{{criterio.nombre}}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6" v-else>
                                                                        <span class="badge bg-warning text-dark" >Asigne una ponderación al equipo. </span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                </ul>
                                            </div>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary py-1" @click="cerrarModal()">Salir</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin Modal Alta-->

                <!--Modal Alta-->
                <div id="modal_alta_colaborador" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="mx-auto">Alta de Colaborador</h6>
                                <button type="button" class="badge rounded-pill bg-secondary border border-0" @click="cerrarModal()">X</button>
                            </div>
                            <div class="row modal-body  text-start text-sm-center d-flex justify-content-around">
                                <div class="input-group mb-3 w-75">
                                    <span class="input-group-text">Nombre</span>
                                    <input type="text" id="nombre_colaborador" v-model="nombre_colaborador" class="form-control" @keyup="todasMayusculas()" placeholder="Nombre Completo">
                                </div>
                                <div class="input-group mb-3 w-75">
                                    <span class="input-group-text">Número</span>
                                    <input type="text" v-model="nomina_colaborador" class="form-control" placeholder="Coloque nómina">
                                </div>
                                <div class="input-group mb-3 w-75">
                                    <span class="input-group-text">Planta</span>
                                    <select class="form-select" v-model="planta_colaborador">
                                        <option value="" disabled>Seleccione planta</option>
                                        <option value="ENERYA">Enerya</option>
                                        <option value="RIASA">Riasa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary py-1" @click="cerrarModal()">Salir</button>
                                <button type="button" class="btn btn-primary py-1" @click="guardarNuevoColaborador()">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin Modal Alta-->
            </div>
            <div class="container-fluid" v-if="ventana == 'Gestion Sesiones'">
                <div class="row barra-gris">
                   
                              
                    
                    <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
                        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'Admin') {
                            ?>
                                <div class="col-3 me-5">
                                    <select class="form-select" v-model="seleccion_eds_areas" @change="filtrandoEADsGestion()" style="font-size:0.8em">
                                        <option value="" selected>Todos los equipos</option>
                                        <option v-for="area in uniqueAreas()" :value="area">{{area}}</option>
                                    </select>
                                </div>
                            <?php
                            }   
                        ?>
                        <button class="py-1 me-2" style="font-size:12px" :class="{'btn btn-success': documento_session.length > 0, 'btn btn-primary': documento_session.length <= 0}" @click="modalDocumentoGestionSession()" :disabled="!select_session_equipo.length">
                            <i class="bi bi-folder-plus"></i>
                            Documento ({{documento_session.length}})
                        </button>
                        <div class="input-group mt-1 mb-1" style="width:300px">
                            <label class="input-group-text" id="basic-addon1" style="font-size:0.7em">Fecha</label>
                            <input v-model="fecha_session" type="date" class="form-control" style="font-size:0.7em" @change="buscarDocumentos()">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 ">
                        <div class="d-flex justify-content-center">
                            <div class="col-3 col-sm-3 d-flex justify-content-center">
                                <div class="text-center" style="border-radius:50%; background:white; position: relative; top: 25px; left: 55px; min-height: 30px; min-width: 30px; max-height: 30px; max-width: 30px; z-index:1"><label class="mt-1">P</label></div>
                                <canvas style="min-height:80px; min-width:80px; max-height:80px; max-width:80px; z-index:30" id="pdcaP"></canvas><br>
                                <label style="margin-top:30px;font-size:0.7em">{{llevaP}}%</label>
                            </div>
                            <div class="col-3 col-sm-3 d-flex justify-content-center">
                                <div class="text-center" style="border-radius:50%; background:white; position: relative; top: 25px; left: 55px; min-height: 30px; min-width: 30px; max-height: 30px; max-width: 30px; z-index:1"><label class="mt-1">D</label></div>
                                <canvas style="min-height:80px; min-width:80px; max-height:80px; max-width:80px; z-index:30" id="pdcaD"></canvas>
                                <label style="margin-top:30px;font-size:0.7em">{{llevaD}}%</label>
                            </div>
                            <div class="col-3 col-sm-3 d-flex justify-content-center">
                                <div class="text-center" style="border-radius:50%; background:white; position: relative; top: 25px; left: 55px; min-height: 30px; min-width: 30px; max-height: 30px; max-width: 30px; z-index:1"><label class="mt-1">C</label></div>
                                <canvas style="min-height:80px; min-width:80px; max-height:80px; max-width:80px; z-index:30" id="pdcaC"></canvas>
                                <label style="margin-top:30px;font-size:0.7em">{{llevaC}}%</label>
                            </div>
                            <div class="col-3 col-sm-3 d-flex justify-content-center">
                                <div class="text-center" style="border-radius:50%; background:white; position: relative; top: 25px; left: 55px; min-height: 30px; min-width: 30px; max-height: 30px; max-width: 30px; z-index:1"><label class="mt-1">A</label></div>
                                <canvas style="min-height:80px; min-width:80px; max-height:80px; max-width:80px; z-index:30" id="pdcaA"></canvas>
                                <label style="margin-top:30px;font-size:0.7em">{{llevaA}}%</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Tarjeta Integrantes-->
                <div class="row">
                    <div class="col-12 col-xl-3 d-flex justify-content-center">
                        <div class="tarjeta my-2" :class="{'color-actualizar':actualizar_session,'color-completado':seguimiento_completado>=100}">
                            <h6 class="text-center pasos">1. Asistencia</h6>
                            <div class="input-group" style="min-width:270px">
                                <label class="input-group-text" style="font-size:0.8em">Equipo </label>
                                <select class="form-select" v-model="select_session_equipo" @change="consultarEADXID(),consultarSeguimientoSession(),consultarCompromisos()" style="font-size:0.8em">
                                    <option value="" selected>Seleccione..</option>
                                    <option v-for="equipos in consultaEAD" :value="equipos[0].id+'<->'+equipos[0].nombre_ead+'<->'+equipos[0].planta+'<->'+equipos[0].area">{{equipos[0].nombre_ead}}</option>
                                </select>
                            </div>
                            <div v-if="EADIntegrantes.length>0" class="container text-center">
                                <label class="letrasCard text-center mb-2">
                                </label>
                                <br>
                                <b class="letrasCard">Planta:</b> {{planta_ead}}
                                <b class="letrasCard">Area:</b> {{area_ead}}<br>
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="text-start">
                                            <li v-for="(integrantes,index) in EADIntegrantes" style="margin-bottom: 2px; font-size: 12px;">
                                                <input class="me-2" v-model="asistieron" :value="integrantes.id" type="checkbox" />
                                                {{index+1}}.- {{integrantes.colaborador}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center d-flex justify-content-center align-items-center h-50">
                                "Seleccione EAD para visualizar integrantes."
                            </div>
                        </div>
                    </div>
                    <!--Tarjeta Fases-->
                    <div class="col-12 col-xl-3 d-flex justify-content-center">
                        <div class="tarjeta my-2" :class="{'color-actualizar':actualizar_session,'color-completado':seguimiento_completado>=100}">
                            <h6 class="text-center pasos">2. Etapa y fases</h6>
                            <div class="input-group" style="min-width:270px">
                                <label class="input-group-text" style="font-size:0.8em">Etapa </label>
                                <select class="form-select" v-model="select_etapa" @change="consultarFaseXetapaSeleccionada(),fasesUtilizadas()" style="font-size:0.8em">
                                    <option value="" selected>Seleccione..</option>
                                    <option v-for="etapa in etapas" :value="etapa.id+'<->'+etapa.etapa">{{etapa.etapa}}</option>
                                </select>
                            </div>
                            <div v-if="fases_etapa.length>0" class="container text-center">
                                <label class="letrasCard text-center mb-2">
                                </label>
                                <br>
                                <b class="letrasCard">Fases</b>
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="text-start">
                                            <li v-for="fase in fases_etapa" style="margin-bottom: 2px; font-size: 12px;">
                                                <input v-model="fases_seleccionadas" :value="fase.fase" type="checkbox" :disabled="faseUsada(fase.fase)" />.-{{fase.fase}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center d-flex justify-content-center align-items-center h-50">
                                <label>"Seleccione Etapa para visualizar las Fases."</label>
                            </div>
                        </div>
                    </div>
                    <!--tabla seguimiento session-->
                    <div class="col-12 col-xl-6">
                        <h6 class="text-center pasos mt-2"> Historial asistencia, etapas y fases.</h6>
                        <div class="progress " style="height: 20px;"><!--Porcentaje Total-->
                            <div class="text-bg-secondary rounded-start ps-2 d-flex align-items-center" style="font-size:0.7em; width: 100px;"><span>Avance Proyecto:</span></div>
                            <div class="progress-bar" role="progressbar" :style="'width:'+porcetajeTotal()+'!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" v-cloak><label style="font-size:10px">{{porcetajeTotal()}}</label></div>
                        </div>
                        <div class="scroll5">
                            <table class="table table-bordered mt-2" :class="{'table-success': seguimiento_completado>=100}" style="font-size:0.7em">
                                <thead class="table-active">
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Etapa</th>
                                        <th scope="col">Fase</th>
                                        <th scope="col">% Asistencia</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-middle" v-for="(seguimiento,index) in seguimiento_session" :key="index" :class="{'table-warning': index_session_actualizar==index && actualizar_session}">
                                        <th scope="row" class="text-center" >{{index+1}}</th>
                                        <td>{{cambiarformato(seguimiento.fecha)}}</td>
                                        <td>{{tomandoEtapa(seguimiento.etapa)}}</td>
                                        <td>
                                            <ul>
                                                <li v-for="(fase, faseIndex) in convertirArregloFase(seguimiento.fase)">
                                                    {{fase}}
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-center">{{seguimiento.porcentaje_asistencia}} %</td>
                                        <td class="text-center">
                                            <div v-if="!actualizar_compromiso && !actualizar_session">
                                                <button class="btn btn-warning btn-boton px-2 py-0 ms-2 text-white" style="font-size: 0.9em; min-width:80px;" @click="actualizarSession(index,seguimiento.id)"> <i class="bi bi-arrow-clockwise"><br></i> Actualizar</button><br>
                                                <button class="btn btn-danger btn-boton px-2 py-0 ms-2 mt-2" style="font-size: 0.9em; min-width:80px;" @click="eliminarGestionSession(seguimiento.id)"> <i class="bi bi-trash-fill"><br></i> Eliminar</button>
                                            </div>
                                            <div v-if="!actualizar_compromiso && actualizar_session">
                                                <button v-if="index_session_actualizar===index" class="btn btn-danger btn-boton px-2 py-0 ms-2" style="font-size: 0.9em; min-width:80px;" @click="reseteandoDatos()"> <i class="bi bi-x-lg"><br></i> Cancelar</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="seguimiento_session.length<=0">
                                        <th colspan="6" class="text-center">Sin seguimiento</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div v-if="!agregar_compromiso && !actualizar_compromiso" class="text-center">
                    <span v-if="seguimiento_completado>=100 && !actualizar_session" class="badge bg-warning text-dark" style="font-size: 0.6em">Listo para cerrarse, no olvide cargar la presentación.</span><br>
                    <button v-if="seguimiento_completado>=100 && !actualizar_session" class="botones-finalizar rounded-pill border-0 my-1 px-2 mb-2 mt-3" @click="cerrarProyecto()"><i class="bi bi-floppy me-2"></i></i>Cerrar proyecto</button>
                    <button v-else-if="actualizar_session" class="botones-actualizar rounded-pill border-0 my-1 px-2 mb-2 mt-3" @click="guardarActualizarSession('Actualizar')"><i class="bi bi-floppy"></i></i> Actualizar</button>
                    <button v-else class="botones-crear rounded-pill border-0 my-1 px-2 mb-2 mt-3" @click="guardarActualizarSession('Guardar')"><i class="bi bi-floppy-fill"></i> Guardar</button>
                </div>
                <div class="row" v-if="select_session_equipo.length>0"><!--contenido compromiso, solo se mostrar cuando exista un equipo seleccionado--->

                    <div class="col-12 col-lg-6"><!--Inicio Scroll-->
                        <div class="row barra-gris d-flex align-content-center " style="height:80px;">
                            <h6 class="text-center pasos mt-2"> Compromisos <label v-show="select_session_equipo.split('<->')[1]">({{select_session_equipo.split('<->')[1]}})</label></h6>
                        </div>
                        <div class="col-12">
                            <div class="scroll5 col-12" style="font-size:0.8em">
                                <table class="table mt-2">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th scope="col"># <button class="btn btn-success btn-boton px-2 py-0 ms-2" @click="agregarCompromiso()" style="font-size:0.9em"><i class="bi bi-plus-circle"></i> Nuevo Compromiso</button></th>
                                            <th scope="col" class="text-center">Compromiso</th>
                                            <th scope="col" class="text-center">Responsable</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Estatus</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="agregar_compromiso" class="table-success"><!--Nueva Competencia-->
                                            <td class="text-center" style="width: 200px;">
                                                <button class="btn btn-danger btn-boton px-2 py-0 ms-2" style="font-size: 0.9em;" @click="cancelarCompromiso()"> <i class="bi bi-x-lg"></i> Cancelar</button>
                                                <button class="btn btn-success btn-boton px-2 py-0 ms-2" style="font-size: 0.9em;" @click="guardarCompromiso()"> <i class="bi bi-floppy-fill"></i> Guardar</button>
                                            </td>
                                            <td>
                                                <input v-model="compromiso" type="text" class="form-control" />
                                            </td>
                                            <td>
                                                <select v-model="responsable_compromiso">
                                                    <option value="" selected disabled>Seleccione responsable</option>
                                                    <option v-for="integrante in EADIntegrantes" :value="integrante.id">{{integrante.colaborador}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input v-model="fecha_compromiso" type="date" class="form-control" />
                                            </td>
                                            <td>
                                                <label>0%</label>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr v-if="compromisos.length>0" v-for="(commitment,index) in compromisos" :key="index" :class="{'table-warning':actualizar_compromiso && input_actualizar==(index+1)}">
                                            <th scope="row" style="width: 200px;">{{index+1}}
                                                <button v-if="!actualizar_compromiso" class="btn btn-warning btn-boton px-2 py-0 ms-2 text-white" style="font-size: 0.9em;" @click="actualizarCompromiso(index+1)"> <i class="bi bi-arrow-clockwise"></i> Actualizar</button>
                                                <button v-if="actualizar_compromiso===true && input_actualizar==(index+1)" class="btn btn-danger btn-boton px-2 py-0 ms-2" style="font-size: 0.9em;" @click="cancelarActualizarCompromiso()"> <i class="bi bi-x-lg"></i> Cancelar</button>
                                                <button v-if="actualizar_compromiso===true && input_actualizar==(index+1)" class="btn btn-success btn-boton px-2 py-0 ms-2" style="font-size: 0.9em;" @click="actualizandoCompromiso(commitment.id)"> <i class="bi bi-floppy-fill"></i> Guardar</button>
                                            </th>
                                            <td>
                                                <input v-if="actualizar_compromiso && input_actualizar==(index+1)" v-model="compromiso" type="text" class="form-control" />
                                                <label v-else> {{commitment.compromiso}}</label>
                                            </td>
                                            <td>
                                                <select v-model="responsable_compromiso" v-if="actualizar_compromiso && input_actualizar==(index+1)">
                                                    <option value="" selected disabled>Seleccione responsable</option>
                                                    <option v-for="integrante in EADIntegrantes" :value="integrante.id">{{integrante.colaborador}}</option>
                                                </select>
                                                <label v-else>{{commitment.nombre_responsable}}</label>
                                            </td>
                                            <td style="width:200px">
                                                <input v-if="actualizar_compromiso && input_actualizar==(index+1)" v-model="fecha_compromiso" type="date" class="form-control" />
                                                <label v-else>{{cambiarformato(commitment.fecha)}}</label>
                                            </td>
                                            <td>
                                                <label v-if="actualizar_compromiso && input_actualizar==(index+1)">{{commitment.estatus}} %</label>
                                                <select :id="'selectPorcentaje'+commitment.id" @change="actualizarPorcentajeCompromiso(commitment.id)" :key="commitment.id" v-else>
                                                    <option value="0" selected disabled>0 %</option>
                                                    <option v-for="valor in porcentaje" :value="valor" :selected="valor == commitment.estatus">{{valor}} %</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button v-if="!actualizar_compromiso" class="btn btn-danger btn-boton px-2 py-0 ms-2" style="font-size: 0.9em;" @click="eliminarCompromiso(commitment.id)"> <i class="bi bi-trash-fill"></i> Eliminar</button>
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td colspan="6" class="text-center" style="background:#FBF7C7">
                                                Equipo <b>{{select_session_equipo.split('<->')[1]}}</b> no cuenta con compromisos
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!--Fin scroll-->
                    <div class="col-12 col-lg-6">
                        <div class="row barra-gris d-flex align-content-center" style="height:80px;">
                            <h6 class="text-center pasos mt-2">Juntas de Arranque <label v-show="select_session_equipo.split('<->')[1]">({{select_session_equipo.split('<->')[1]}})</label></h6>
                        </div>
                        <div class="col-12"><!--Inicio Scroll-->
                            <div class="scroll5 col-12" style="font-size:0.8em">
                                <table class="table mt-2">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">Asistencia</th>
                                            <th scope="col" class="text-center">Hora Inicial</th>
                                            <th scope="col" class="text-center">Hora Final</th>
                                            <th scope="col" class="text-center">Tiempo</th>
                                            <th scope="col" class="text-center">Fotografía</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="justasArranque.length>0" v-for="(juntas,index) in justasArranque" class="table-success">
                                            <td class="text-center" style="width: 200px;">
                                                {{index+1}}
                                            </td>
                                            <td class="text-center">
                                                {{juntas.asistencia}}
                                            </td>
                                            <td class="text-center">
                                                {{juntas.hora_inicial}}
                                            </td>
                                            <td class="text-center">
                                                {{juntas.hora_final}}
                                            </td>
                                            <td class="text-center">
                                                {{juntas.total_tiempo}}
                                            </td>
                                            <td class="text-center">
                                                {{juntas.fotografia}}
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td colspan="6" class="text-center" style="background:#FBF7C7">
                                                Equipo <b>{{select_session_equipo.split('<->')[1]}}</b> no cuenta con juntas de arranque
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!--Fin scroll-->
                        </div>
                    </div>
                </div>
                <!--KPI Inicio-->
                <div class="col-12 text-center" v-if="select_session_equipo.length>0">
                    <div class="row barra-gris d-flex align-content-center" style="height:80px;">
                        <h6 class="text-center pasos mt-2"> Gráfica KPI <label v-show="select_session_equipo.split('<->')[1]">({{select_session_equipo.split('<->')[1]}})</label></h6>
                    </div>
                    <div class="offset-4 col-4">
                        <button class="btn btn-success btn-boton px-2 py-0" @click="abriModalKPI()" style="font-size:0.7em"><i class="bi bi-plus-circle"></i>Agregar/Actualizar Datos KPI</button><br>
                        <span class="badge bg-dark" style="font-size:0.5">{{this.tGrafica}}</span>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary" @click="abriModalGraficaFullKPI()" title="Grafica en toda la pantalla"><i class="bi bi-arrows-angle-expand"></i></button> 
                    </div>
                    <canvas style="width:100%" id="canvaKPI"></canvas>
                </div>
                <!--KPI Final-->
                <!--MODAL DOCUMENTO--->
                <!-- Modal Eliminar/Actualizar Documento del Proyecto-->
                <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Documento/s <b>{{select_session_equipo.split('<->')[1]}}</b></h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <form @submit.prevent="uploadFile()">
                                        Subir Documento
                                        <div class="col-12">
                                            <div class="custom-file mt-2 mb-3">
                                                <input type="file" id="input_file_seguimiento" @change="varificandoSelecionSeguimiento()" ref="ref_imagen" multiple accept="*.jpg/*.png/*.pdf/*.doc/*.docx/*.ppt/*.pptx/*.xls/*.xlsx" class="btn btn-secondary  ms-2 p-0" required />
                                            </div>
                                        </div>
                                        <div class="col-12" v-if="existeImagenSeleccionada && login!=true">
                                            <button type="submit" name="upload" class="btn btn-primary">Subir Archivos </button>
                                        </div>
                                        <div v-if="login==true" class="d-flex justify-content-center">
                                            <div>
                                                <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                            </div>
                                        </div>

                                        <!-- Mostrando los archivos cargados SEGUIMIENTO-->
                                        <div v-if="documento_session.length>0">
                                            <hr>
                                            <div class="col-12" v-for="(archivos,index) in documento_session">
                                                <div class="row">
                                                    <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                    <div class="mt-1">
                                                        <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;">Eliminar</button>
                                                    </div>
                                                </div>
                                                <!--Mostar los JPG y PNG-->
                                                <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                    <img :src="documento_session[index]" style="width:50%" class="mb-5"></img>
                                                </div>
                                                <!--Mostrar PDF-->
                                                <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'" class="col-12 text-center">
                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                    <iframe :src="documento_session[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
                                                </div>
                                                <!--Mostrar Word-->
                                                <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                    <a :href="archivos" :download="nombre_de_descarga">
                                                        <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                    </a>
                                                </div>
                                                <!--Mostrar Excel-->
                                                <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                    <a :href="archivos" :download="nombre_de_descarga">
                                                        <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                    </a>
                                                </div>
                                                <!--Mostrar Power Point -->
                                                <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1).toLowerCase()=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1).toLowerCase()=='pptx'"  class="col-12 text-center">
                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                    <a :href="archivos" :download="nombre_de_descarga">
                                                        <img src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
                                                    </a>
                                                </div>
                                                <!--Mostrar .RAR-->
                                                <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='rar'" class="col-12 text-center">
                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                    <a :href="archivos" :download="nombre_de_descarga">
                                                        <img src="img/rar.png" style="width:200px" class="mb-5"></img>
                                                    </a>
                                                </div>
                                                <!--Mostrar .RAR-->
                                                <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='zip'" class="col-12 text-center">
                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                    <a :href="archivos" :download="nombre_de_descarga">
                                                        <img src="img/zip.png" style="width:200px" class="mb-5"></img>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin Modal subir seguimiento-->
                <!-- Inicio Modal KPIS-->
                <div class="modal fade" id="modalKPI" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Seguimiento KPI's</b></h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div v-if="select_session_equipo.length>0">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="tarjeta_kpis my-2 text-center">
                                                <div class="input-group mb-3" style="min-width:270px;">
                                                    <label class="input-group-text w-25" style="font-size:0.8em">Nom. Indicador</label>
                                                    <input type="text" class="form-control" v-model="nombre_indicador" style="font-size:0.8em" :disabled="seguimientoKPIs.length>0  && actualizar_kpi!='nombre_indicador'" />
                                                    <div>
                                                        <button class="btn-up" title="Actualizar" v-if="seguimientoKPIs.length>0 && actualizar_kpi==false" @click="updateBanderaKpi('nombre_indicador')"><i class="bi bi-arrow-up-circle"></i></button>
                                                        <button class="btn-save" v-if="actualizar_kpi=='nombre_indicador'" @click="updateKpi()"><i class="bi bi-floppy"></i></button>
                                                        <button class="btn-cancelar" v-if="actualizar_kpi=='nombre_indicador'" @click="cancelarKpi()"><i class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3" style="min-width:270px">
                                                    
                                                        <label class="input-group-text w-25" style="font-size:0.8em">Tipo Gráfica</label>
                                                        <select class="form-select" v-model="tGrafica" style="font-size:0.8em" :disabled="seguimientoKPIs.length>0  && actualizar_kpi!='tipo'">
                                                            <option value="" selected disabled>Seleccione..</option>
                                                            <option value="Decremento">Decremento (Por debajo de la Meta Retadora)</option>
                                                            <option value="Incremento">Incremento (Por encima de la Meta Retadora)</option>
                                                        </select>
                                                    <div>
                                                        <button class="btn-up" title="Actualizar" v-if="seguimientoKPIs.length>0 && actualizar_kpi==false" @click="updateBanderaKpi('tipo')"><i class="bi bi-arrow-up-circle"></i></button>
                                                        <button class="btn-save" v-if="actualizar_kpi=='tipo'" @click="updateKpi()"><i class="bi bi-floppy"></i></button>
                                                        <button class="btn-cancelar" v-if="actualizar_kpi=='tipo'" @click="cancelarKpi()"><i class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3" style="min-width:270px">
                                                    <label class="input-group-text w-25" style="font-size:0.8em">Tipo Unidad</label>
                                                    <input type="text" class="form-control" v-model="tipo_unidad" style="font-size:0.8em" :disabled="seguimientoKPIs.length>0 && actualizar_kpi!='unidad'" />
                                                    <div>
                                                        <button class="btn-up" title="Actualizar" v-if="seguimientoKPIs.length>0 && actualizar_kpi==false" @click="updateBanderaKpi('unidad')"><i class="bi bi-arrow-up-circle"></i></button>
                                                        <button class="btn-save" v-if="actualizar_kpi=='unidad'" @click="updateKpi()"><i class="bi bi-floppy"></i></button>
                                                        <button class="btn-cancelar" v-if="actualizar_kpi=='unidad'" @click="cancelarKpi()"><i class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3" style="min-width:270px">
                                                    <label class="input-group-text w-25" style="font-size:0.8em">Línea B.</label>
                                                    <input type="text" class="form-control" v-model="linea_base" @blur="convertirDecimal('linea_base')" style="font-size:0.8em" :disabled="seguimientoKPIs.length>0 && actualizar_kpi!='linea_base'" />
                                                    <div>
                                                        <button class="btn-up" title="Actualizar" v-if="seguimientoKPIs.length>0 && actualizar_kpi==false" @click="updateBanderaKpi('linea_base')"><i class="bi bi-arrow-up-circle"></i></button>
                                                        <button class="btn-save" v-if="actualizar_kpi=='linea_base'" @click="updateKpi()"><i class="bi bi-floppy"></i></button>
                                                        <button class="btn-cancelar" v-if="actualizar_kpi=='linea_base'" @click="cancelarKpi()"><i class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3" style="min-width:270px">
                                                    <label class="input-group-text w-25" style="font-size:0.8em">Entitlement </label>
                                                    <input type="text" class="form-control" v-model="entitlement" @blur="convertirDecimal('entitlement')" style="font-size:0.8em" :disabled="seguimientoKPIs.length>0 && actualizar_kpi!='entitlement'" />
                                                    <div>
                                                        <button class="btn-up" title="Actualizar" v-if="seguimientoKPIs.length>0 && actualizar_kpi==false" @click="updateBanderaKpi('entitlement')"><i class="bi bi-arrow-up-circle"></i></button>
                                                        <button class="btn-save" v-if="actualizar_kpi=='entitlement'" @click="updateKpi()"><i class="bi bi-floppy"></i></button>
                                                        <button class="btn-cancelar" v-if="actualizar_kpi=='entitlement'" @click="cancelarKpi()"><i class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3" style="min-width:270px">
                                                    <label class="input-group-text w-25" style="font-size:0.8em">Mta. Calc.</label>
                                                    <input type="text" class="form-control" v-model="meta_calculada" @blur="convertirDecimal('meta_calculada')" style="font-size:0.8em" :disabled="seguimientoKPIs.length>0 && actualizar_kpi!='meta_calculada'" />
                                                    <div>
                                                        <button class="btn-up" title="Actualizar" v-if="seguimientoKPIs.length>0 && actualizar_kpi==false" @click="updateBanderaKpi('meta_calculada')"><i class="bi bi-arrow-up-circle"></i></button>
                                                        <button class="btn-save" v-if="actualizar_kpi=='meta_calculada'" @click="updateKpi()"><i class="bi bi-floppy"></i></button>
                                                        <button class="btn-cancelar" v-if="actualizar_kpi=='meta_calculada'" @click="cancelarKpi()"><i class="bi bi-x-circle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3" style="min-width:270px">
                                                    <label class="input-group-text w-25" style="font-size:0.8em">Mta. Ret.</label>
                                                    <input type="text" class="form-control" v-model="meta_retadora" @blur="convertirDecimal('meta_retadora')" style="font-size:0.8em" :disabled="seguimientoKPIs.length>0 && actualizar_kpi!='meta_retadora'" />
                                                    <button class="btn-up" title="Actualizar" v-if="seguimientoKPIs.length>0 && actualizar_kpi==false" @click="updateBanderaKpi('meta_retadora')"><i class="bi bi-arrow-up-circle"></i></button>
                                                    <button class="btn-save" v-if="actualizar_kpi=='meta_retadora'" @click="updateKpi()"><i class="bi bi-floppy"></i></button>
                                                    <button class="btn-cancelar" v-if="actualizar_kpi=='meta_retadora'" @click="cancelarKpi()"><i class="bi bi-x-circle"></i></button>
                                                </div>
                                                <div :class="{ 'seccion_actulizar': !actualizar_kpi && actualizar_datoKPI}">
                                                    <div class="input-group mb-3" style="min-width:270px">
                                                        <label class="input-group-text w-25" style="font-size:0.8em">Año</label>
                                                        <select class="form-select" v-model="anio_kpi" style="font-size:0.8em" @change="semanasAnio()" :disabled="actualizar_kpi!=false">
                                                            <option v-for="anio in anios" :value="anio">{{anio}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-3" style="min-width:270px">
                                                        <label class="input-group-text w-25" style="font-size:0.8em">Cerrar Mes</label>
                                                        <input type="checkbox" class="mx-2" v-model="checkMes" :disabled="actualizar_kpi!=false" />
                                                        <select class="form-select w-50" style="font-size:0.8em" v-model="mes_cierre" :disabled="!checkMes">
                                                            <option value="" selected disabled>Seleccione mes</option>
                                                            <option v-show="actualizar_datoKPI" value="">Deshacer Cierre</option>
                                                            <option v-for="mes in meses" :value="mes">{{mes}}</option>
                                                        </select>
                                                        <!--<label class="input-group-text w-15" style="font-size:0.8em">Dato Cierre</label>
                                                                            <input type="text" class="form-control" style="font-size:0.8em" :disabled="!checkMes"/>-->
                                                    </div>
                                                    <div class="input-group mb-3" style="min-width:270px">
                                                        <label class="input-group-text w-25" style="font-size:0.8em">Semana</label>
                                                        <select class="form-select" v-model="semana_kpi" style="font-size:0.8em" :disabled="actualizar_kpi!=false">
                                                            <option value="" selected>Seleccione la semana</option>
                                                            <option v-for="semana in semanas_anio" :value="semana">{{semana}} Semana</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-3" style="min-width:270px">
                                                        <label class="input-group-text w-25" style="font-size:0.8em">Dato</label>
                                                        <input type="text" class="form-control" v-model="dato_semanal" @blur="convertirDecimal('dato_semanal')" style="font-size:0.8em" :disabled="actualizar_kpi!=false" />
                                                    </div>
                                                </div>
                                                <button v-if="actualizar_kpi==false && actualizar_datoKPI==false" class="btn btn-success btn-boton py-0" style="font-size: 0.9em;" @click="guardarSeguimientoKPI()"><i class="bi bi-floppy-fill"></i> Guardar</button>
                                                <button v-if="actualizar_kpi==false && actualizar_datoKPI==true" class="btn btn-warning btn-boton py-0 mt-3" style="font-size: 0.9em;" @click="guardarActualizacionDatoKPI()"><i class="bi bi-floppy-fill"></i> Actualizar</button>
                                                <button v-if="actualizar_kpi==false && actualizar_datoKPI==true" class="btn btn-danger btn-boton py-0 ms-2 mt-3" style="font-size: 0.9em;" @click="cancelarDatosKPI()"><i class="bi bi-x-circle-fill"></i> Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Tabla registro KPIs-->
                                    <div class="scroll2">
                                        <table class="table table-bordered mt-2" style="font-size:0.7em">
                                            <thead class="table-active">
                                                <tr class="text-center">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Año</th>
                                                    <th scope="col">Mes Cierre</th>
                                                    <th scope="col">Semana</th>
                                                    <th scope="col">Dato</th>
                                                    <th scope="col">Actualizar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="align-middle" v-for="(seguimientokpi,index) in seguimientoKPIs.slice().reverse()">
                                                    <th scope="row" class="text-center">{{index+1}}</th>
                                                    <td class="text-center">{{seguimientokpi.anio}}</td>
                                                    <td class="text-center">{{seguimientokpi.mes_cierre}}</td>
                                                    <td class="text-center">{{seguimientokpi.semana}}</td>
                                                    <td>{{formatoNumero(seguimientokpi.dato_semanal)}}</td>
                                                    <td class="text-center">
                                                        <button v-if="actualizar_datoKPI==false && actualizar_kpi==false" class="btn btn-warning botones-actualizar me-5" v-if="actualizar_kpi==false" @click="asignarDatosKPI(index)">Actualizar</button>
                                                        <button v-if="actualizar_datoKPI==false && actualizar_kpi==false" class="btn btn-danger botones-eliminar me-5" v-if="actualizar_kpi==false" @click="eliminarDatoKPI(seguimientokpi.id,seguimientokpi.semana,parseFloat(seguimientokpi.dato_semanal).toFixed(2))">Eliminar</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--Tabla registro KPIs-->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin Modal KPIS-->
                <!-- Inicio Modal GRAFICA KPIS VISTA FULL-->
                <div class="modal fade" id="modalGraficaKPI" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen p-5">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLabel">Seguimiento KPI's</b></h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="offset-1 col-10">
                                    <canvas id="canvaKPIFull"></canvas>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin Modal GRAFICA KPIS VISTA FULL-->
            </div>
            <div v-if="ventana=='Preguntas'"> <!--bloque PREGUNTAS-->
                <!--///////////////////////////////////////-->
                <div class="row text-center">
                    <div class="col-12 col-lg-4">
                        <span class="badge text-bg-secondary">Etapas</span>
                        <table class="table m-2">
                            <thead class="table-light">
                                <th>#</th>
                                <th>Etapa</th>
                                <th>Peso</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-lg-8">
                        <span class="badge text-bg-secondary">Cuestionario</span>
                        <table class="table m-2">
                            <thead>
                                <th width="max-width:100px">
                                    Etapa
                                </th>
                                <th width="max-width:100px">
                                    Peso
                                </th>
                                <th>
                                    Pregunta
                                </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--///////////////////////////////////////-->
            </div>
            <div v-if="ventana == 'Ponderación'">
                <div class="row d-flex barra-gris justify-content-center align-items-center" style="font-size: 0.9em; height:80px;">
                    <h6 class="text-center pasos mt-2"> Ponderaciones</label></h6>
                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-success btn-boton px-2 py-0 me-2 " @click="refrescarNuevaPonderaciones()"><i class="bi bi-plus-circle-fill"></i>Nueva Ponderación</button>
                </div>
                <div v-if="nueva_ponderacion==true" class="row"><!--scroll Nueva Ponderacion-->
                    <div class="col-12 p-1 mt-2 scroll-w shadow" style="background-color: #f0f8e5;">
                        <div class="text-center mb-3 mt-2" style="min-width: 1500px;">
                            <input type="text" class="border border-1 rounded-1 p-1 text-center" v-model="nombre_ponderacion" style="width:300px" />
                        </div>
                        <table class="table table-striped mx-auto w-75 mt-2" style="font-size:0.8em; min-width: 1500px;">
                            <thead>
                                <tr class="table-active text-center">
                                    <th style="min-width:200px;">
                                        <button class="ms-1 btn px-1 py-0" style="background: #35832D;color:white;" title="Agregar nuevo criterio" @click="modalNuevoCriterio()"><i class="bi bi-plus"></i></button>
                                        <button class="ms-1 btn px-1 py-0" style="background: #35832D;color:white;" @click="consultarCriterio()" title="Mostrar todos los criterios">
                                        <i class="bi bi-arrow-clockwise"></i>
                                        </button>  Criterios</th>
                                        <th>Meta Retadora</th>
                                        <th>Entitlement</th>
                                        <th>Meta Calculada</th>
                                        <th>Línea Base</th>
                                        <th>Reprobatoria</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="middle-center" v-for="(elemento,index) in filasSC">
                                    <td class="border">
                                        <button class="ms-1 btn px-1 py-0" style="background: rgb(176, 70, 47);" @click="quitarCriterioNuevaPonderacion(index)" title="Quitar este criterio de mi nueva ponderación"><i class="bi bi-trash3-fill text-light"></i></button>  {{elemento.nombre}}
                                    </td>
                                    <td class="border text-center" style="background: #35832D;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size:0.8em">De:</span>
                                            <input :id="'DeFila'+index+'Columna0'" type="text" class="form-control p-1 w-15 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Hasta:</span>
                                            <input :id="'HastaFila'+index+'Columna0'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Pts:</span>
                                            <input :id="'PuntosFila'+index+'Columna0'" type="text" class="form-control p-1 fw-semibold text-primary">
                                        </div>
                                    </td>
                                    <td class="border text-center" style="background: #5EC271;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size:0.8em">De:</span>
                                            <input :id="'DeFila'+index+'Columna1'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Hasta:</span>
                                            <input :id="'HastaFila'+index+'Columna1'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Pts:</span>
                                            <input :id="'PuntosFila'+index+'Columna1'" type="text" class="form-control p-1 fw-semibold text-primary">
                                        </div>
                                    </td>
                                    <td class="border text-center " style="background: #66FF33;">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size:0.8em">De:</span>
                                            <input :id="'DeFila'+index+'Columna2'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Hasta:</span>
                                            <input :id="'HastaFila'+index+'Columna2'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Pts:</span>
                                            <input :id="'PuntosFila'+index+'Columna2'" type="text" class="form-control p-1 fw-semibold text-primary">
                                        </div>
                                    </td>
                                    <td class="border text-center bg-warning">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size:0.8em">De:</span>
                                            <input :id="'DeFila'+index+'Columna3'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Hasta:</span>
                                            <input :id="'HastaFila'+index+'Columna3'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Pts:</span>
                                            <input :id="'PuntosFila'+index+'Columna3'" type="text" class="form-control p-1 fw-semibold text-primary">
                                        </div>
                                    </td>
                                    <td class="border text-center bg-danger">
                                        <div class="input-group">
                                            <span class="input-group-text" style="font-size:0.8em">De:</span>
                                            <input :id="'DeFila'+index+'Columna4'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Hasta:</span>
                                            <input :id="'HastaFila'+index+'Columna4'" type="text" class="form-control p-1 fw-semibold">
                                            <span class="input-group-text" style="font-size:0.8em">Pts:</span>
                                            <input :id="'PuntosFila'+index+'Columna4'" type="text" class="form-control p-1 fw-semibold text-primary">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center mx-auto mb-3" style="min-width: 1500px;">
                            <button class="botones-crear rounded-pill mt-2 border-0 me-2" @click="guardarPonderacion()">Guardar</button>
                            <button class="botones-cancelar rounded-pill mt-2 border-0 ms-2" @click="cancelarPonderacion()">Cancelar</button>
                        </div>
                    </div>
                </div> <!--Fin scroll Fin Nueva Ponderacion-->



                <div v-if="ponderaciones.length>0" class="row scroll"><!--scroll Consulta Ponderaciones-->

                    <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                    <div :class="nueva_ponderacion ? 'opacity-25' : 'opacity-100'" class="col-12 p-1 mt-2" v-for="(tablaPonderacion,indexTablaPonderacion) in tablasPonderaciones">
                        <div class="d-flex justify-content-center mb-3" style="font-size:0.8em; min-width: 1500px;">
                            <div class="card border-dark shadow">
                                <div class="card-header" style="background-color: #7fb3d5">

                                    <div class="d-flex flex-row justify-content-start align-items-center">
                                        <div><button v-if="inputNewName==tablaPonderacion.id_ponderacion" class="me-1 mt-1 btn btn-secondary px-1 py-0" @click="inputNuevoNombre(tablaPonderacion.id_ponderacion)"><i class="bi bi-x-square"></i></button></div>
                                        <div><input :id="'inputNombre'+indexTablaPonderacion" v-if="inputNewName==tablaPonderacion.id_ponderacion" class="form-control" type="text" :value="tablaPonderacion.ponderacion" @keyup.enter="actualizarNombrePonderacion(indexTablaPonderacion,tablaPonderacion.id_ponderacion)" /></div>
                                        <div><span v-if="inputNewName!==tablaPonderacion.id_ponderacion" class="badge bg-light text-dark ms-2" @click="inputNuevoNombre(tablaPonderacion.id_ponderacion)">{{tablaPonderacion.ponderacion}} </span></div>
                                        <div><button v-if="inputNewName!==tablaPonderacion.id_ponderacion" class="ms-1 btn px-1 py-0" style="background: #b0462f" @click="eliminarPonderacion(tablaPonderacion.id_ponderacion,tablaPonderacion.ponderacion)"><i class="bi bi-trash3-fill text-light"></i></button></div>
                                    </div>

                                </div>
                                <div class="card-body text-dark">
                                    <div class="col-12 d-flex justify-content-center flex-wrap offset-col-12">
                                        <template v-for="equipo in consultaEAD">
                                            <div class="col-2 border-secondary mb-3 mx-2">
                                                <div class="card-header">
                                                    <input type="checkbox" name="equipo" @click="asignarDesignarPonderacion(equipo[0].id,tablaPonderacion.id_ponderacion,$event)" :checked="equipo[0].id_ponderacion==tablaPonderacion.id_ponderacion" />
                                                    <label class="ms-1 me-2">{{equipo[0].nombre_ead}}</label>
                                                </div>
                                            </div>
                                        </template>
                                        </div>
                                    <table class="table table-striped mt-2 mx-auto" style="font-size:0.9em; max-width: 1500px;">
                                        <thead>
                                            <tr class="table-active text-center">
                                                <th style="min-width:200px;">Criterios</th>
                                                <th style="background: #35832D;" class="text-white shadow">Meta Retadora</th>
                                                <th style="background: #5EC271;">Entitlement</th>
                                                <th style="background: #66FF33;" class="shadow">Meta Calculada</th>
                                                <th class="bg-warning">Línea Base</th>
                                                <th class="bg-danger text-white shadow">Reprobatoria</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr class="middle-center" v-for="(valoresPon,criterio,index) in datosTablaPonderacion[tablaPonderacion.id_ponderacion]">
                                                <td class="border">{{criterio}}</td>
                                                <td class="border text-center table-active">
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'de'+(index * 5 + 0))">De:</span>
                                                        <input :id="indexTablaPonderacion+'DeFila'+index+'Columna0'" :value="valoresPon[0].desde" type="text" class="form-control p-1 w-15 fw-semibold" @keyup.enter="saveDate(valoresPon[0].id,indexTablaPonderacion+'DeFila'+index+'Columna0','desde')" :disabled="inputDesactivado!==indexTablaPonderacion+'de'+(index * 5 + 0)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'hasta'+(index * 5 + 0))">Hasta:</span>
                                                        <input :id="indexTablaPonderacion+'HastaFila'+index+'Columna0'" :value="valoresPon[0].hasta" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[0].id,indexTablaPonderacion+'HastaFila'+index+'Columna0','hasta')" :disabled="inputDesactivado!==indexTablaPonderacion+'hasta'+(index * 5 + 0)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'puntos'+(index * 5 + 0))">Pts:</span>
                                                        <input :id="indexTablaPonderacion+'PuntosFila'+index+'Columna0'" :value="valoresPon[0].puntos" type="text" class="form-control p-1 fw-semibold text-primary" @keyup.enter="saveDate(valoresPon[0].id,indexTablaPonderacion+'PuntosFila'+index+'Columna0','puntos')" :disabled="inputDesactivado!==indexTablaPonderacion+'puntos'+(index * 5 + 0)">
                                                    </div>
                                                </td>
                                                <td class="border text-center">
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'de'+(index * 5 + 1))">De:</span>
                                                        <input :id="indexTablaPonderacion+'DeFila'+index+'Columna1'" :value="valoresPon[1].desde" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[1].id,indexTablaPonderacion+'DeFila'+index+'Columna1','desde')" :disabled="inputDesactivado!==indexTablaPonderacion+'de'+(index * 5 + 1)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'hasta'+(index * 5 + 1))">Hasta:</span>
                                                        <input :id="indexTablaPonderacion+'HastaFila'+index+'Columna1'" :value="valoresPon[1].hasta" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[1].id,indexTablaPonderacion+'HastaFila'+index+'Columna1','hasta')" :disabled="inputDesactivado!==indexTablaPonderacion+'hasta'+(index * 5 + 1)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'puntos'+(index * 5 + 1))">Pts:</span>
                                                        <input :id="indexTablaPonderacion+'PuntosFila'+index+'Columna1'" :value="valoresPon[1].puntos" type="text" class="form-control p-1 fw-semibold text-primary" @keyup.enter="saveDate(valoresPon[1].id,indexTablaPonderacion+'PuntosFila'+index+'Columna1','puntos')" :disabled="inputDesactivado!==indexTablaPonderacion+'puntos'+(index * 5 + 1)">
                                                    </div>
                                                </td>
                                                <td class="border text-center table-active ">
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'de'+(index * 5 + 2))">De:</span>
                                                        <input :id="indexTablaPonderacion+'DeFila'+index+'Columna2'" :value="valoresPon[2].desde" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[2].id,indexTablaPonderacion+'DeFila'+index+'Columna2','desde')" :disabled="inputDesactivado!==indexTablaPonderacion+'de'+(index * 5 + 2)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'hasta'+(index * 5 + 2))">Hasta:</span>
                                                        <input :id="indexTablaPonderacion+'HastaFila'+index+'Columna2'" :value="valoresPon[2].hasta" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[2].id,indexTablaPonderacion+'HastaFila'+index+'Columna2','hasta')" :disabled="inputDesactivado!==indexTablaPonderacion+'hasta'+(index * 5 + 2)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'puntos'+(index * 5 + 2))">Pts:</span>
                                                        <input :id="indexTablaPonderacion+'PuntosFila'+index+'Columna2'" :value="valoresPon[2].puntos" type="text" class="form-control p-1 fw-semibold text-primary" @keyup.enter="saveDate(valoresPon[2].id,indexTablaPonderacion+'PuntosFila'+index+'Columna2','puntos')" :disabled="inputDesactivado!==indexTablaPonderacion+'puntos'+(index * 5 + 2)">
                                                    </div>
                                                </td>
                                                <td class="border text-center">
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'de'+(index * 5 + 3))">De:</span>
                                                        <input :id="indexTablaPonderacion+'DeFila'+index+'Columna3'" :value="valoresPon[3].desde" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[3].id,indexTablaPonderacion+'DeFila'+index+'Columna3','desde')" :disabled="inputDesactivado!==indexTablaPonderacion+'de'+(index * 5 + 3)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'hasta'+(index * 5 + 3))">Hasta:</span>
                                                        <input :id="indexTablaPonderacion+'HastaFila'+index+'Columna3'" :value="valoresPon[3].hasta" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[3].id,indexTablaPonderacion+'HastaFila'+index+'Columna3','hasta')" :disabled="inputDesactivado!==indexTablaPonderacion+'hasta'+(index * 5 + 3)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'puntos'+(index * 5 + 3))">Pts:</span>
                                                        <input :id="indexTablaPonderacion+'PuntosFila'+index+'Columna3'" :value="valoresPon[3].puntos" type="text" class="form-control p-1 fw-semibold text-primary" @keyup.enter="saveDate(valoresPon[3].id,indexTablaPonderacion+'PuntosFila'+index+'Columna3','puntos')" :disabled="inputDesactivado!==indexTablaPonderacion+'puntos'+(index * 5 + 3)">
                                                    </div>
                                                </td>
                                                <td class="border text-center table-active">
                                                    <div class="input-group">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'de'+(index * 5 + 4))">De:</span>
                                                        <input :id="indexTablaPonderacion+'DeFila'+index+'Columna4'" :value="valoresPon[4].desde" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[4].id,indexTablaPonderacion+'DeFila'+index+'Columna4','desde')" :disabled="inputDesactivado!==indexTablaPonderacion+'de'+(index * 5 + 4)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'hasta'+(index * 5 + 4))">Hasta:</span>
                                                        <input :id="indexTablaPonderacion+'HastaFila'+index+'Columna4'" :value="valoresPon[4].hasta" type="text" class="form-control p-1 fw-semibold" @keyup.enter="saveDate(valoresPon[4].id,indexTablaPonderacion+'HastaFila'+index+'Columna4','hasta')" :disabled="inputDesactivado!==indexTablaPonderacion+'hasta'+(index * 5 + 4)">
                                                        <span class="input-group-text" style="font-size:0.8em; cursor:pointer" @click="inputEditar(indexTablaPonderacion+'puntos'+(index * 5 + 4))">Pts:</span>
                                                        <input :id="indexTablaPonderacion+'PuntosFila'+index+'Columna4'" :value="valoresPon[4].puntos" type="text" class="form-control p-1 fw-semibold text-primary" @keyup.enter="saveDate(valoresPon[4].id,indexTablaPonderacion+'PuntosFila'+index+'Columna4','puntos')" :disabled="inputDesactivado!==indexTablaPonderacion+'puntos'+(index * 5 + 4)">
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                </div> <!--Fin scroll Fin Consulta Ponderaciones-->
                <div v-show="ponderaciones.length<=0" class="col-12 text-center">
                    <span class="badge bg-secondary text-bg-primary">No existen pondeciones creadas</span>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalNuevoCriterio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fs-5" id="staticBackdropLabel">Nuevo Criterio</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cerrarModalNuevoCriterio()"></button>
                            </div>
                            <div class="modal-body" >
                                        <div class="input-group mb-3 w-75">
                                            <span class="input-group-text w-25" style="font-size:0.8em">Nombre</span>
                                            <input type="text" v-model="nombre_nuevo_criterio" class="form-control" placeholder="Eficiencia">
                                        </div>
                                        <div class="input-group mb-3 w-75">
                                            <span class="input-group-text  w-25" style="font-size:0.8em">Tipo de criterio</span>
                                            <select class="form-select" v-model="tipo_criterio" style="font-size: 0.7em;">
                                                <option value="" disabled>Seleccione tipo criterio..</option>
                                                <option value="Gráfica">Gráfica (Ejemplo: "Rechazos","Merma").</option>
                                                <option value="Input">Input (Ejemplo: "Plomo en Sangre","Sugerencias").</option>
                                            </select>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="cerrarModalNuevoCriterio()">Cancelar</button>
                                <button type="button" class="btn btn-primary" @click="guardarNuevoCriterio()">Guardar</button>
                            </div>
                            </div>
                        </div>
                </div>
                <!--FIN MODAL-->
                
            </div>
            <!--///////////////////////////////////////-->
            <div v-if="ventana == 'Graficas'">
                <div class="row d-flex barra-gris justify-content-center" style="font-size: 0.9em;">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="input-group my-3">
                            <span class="input-group-text w-25" style="font-size: 0.9em;" style="width:100px">Equipo</span>
                            <select class="w-50" v-model="equipo_grafica" @change="consultarCriterios(),consultadoValoresGrafica()">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="equipos in consultaEAD" :value="equipos[0].id+'<->'+equipos[0].nombre_ead+'<->'+equipos[0].planta+'<->'+equipos[0].area">{{equipos[0].nombre_ead}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="input-group my-3 ">
                            <span class="input-group-text w-25" style="font-size: 0.9em;" style="width:100px">Tabla</span>
                            <select v-if="equipo_grafica=='' || criterioGrafica.length>0" class="w-50" v-model="idCriterioGrafica" @change="consultadoValoresGrafica()">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="grafica in criterioGrafica" :value="grafica.id">{{ grafica.nombre }}</option>
                            </select>
                            <span v-if="criterioGrafica.length<=0 && equipo_grafica!=''" class="w-50 badge bg-danger my-auto pt-1 pb-1" style="white-space: normal;">Sin ponderación asignada, seleccione ponderación en Menú Ponderación</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="input-group my-3">
                            <span class="input-group-text w-25" style="font-size: 0.9em;" style="width:100px">Año</span>
                            <select class="w-50" v-model="anio_grafica" @change="consultadoValoresGrafica()">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="anio in anios" :value="anio">{{anio}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="input-group my-3">
                            <span class="input-group-text w-25" style="font-size: 0.9em;" style="width:100px">Mes</span>
                            <select class="w-50" v-model="mes_grafica" @change="consultadoValoresGrafica()">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="mes in meses" :value="mes">{{mes}}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!--/////////////////////////////////////////////////////////////////GRAFICA -->
                <div class="row d-flex" v-if="idCriterioGrafica!='' && equipo_grafica!='' && anio_grafica!='' && mes_grafica!='' && criterioGrafica.length>0">
                    <div class="col-12">
                        <div class="scroll-w col-12"><!--dias-->
                            <table class="text-center mx-auto my-2">
                                <thead class="sticky-top">
                                    <tr>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="border border-dark text-white bg-secondary" style="font-size: 13px;">
                                            Día
                                        </th>
                                        <td v-for="(i,index) in diasDelMesAnio()" class="border border-dark" style="height: 20px; width: 40px; font-size: 13px;">
                                            {{i}}
                                        </td>
                                        <td class="border border-dark text-white bg-secondary" style="font-size: 13px;">
                                            Suma
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark text-white bg-secondary" style="font-size: 13px;">
                                            {{nombreDelCriterio}}
                                        </th>
                                        <td v-for="(i,index) in diasDelMesAnio()" class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px;">
                                            <input :id="'grafica'+index" :value="datosGrafica[index]" @change="insertandoValores(index)" @keyup.enter="insertandoValores(index)" class="inpus-number-graficas text-center" type="number"> <!--@blur="insertandoValores(index)"-->
                                        </td>
                                        <td class=" border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                            {{sumaTabla}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="d-flex col-12 col-lg-10 col-xl-8 mx-auto bg-warning text-center" style="height:55vh">
                            <table class="text-center table table-bordered">
                                <thead>

                                </thead>
                                <tbody>
                                    <tr class="tabla-encabezado">
                                        <th class=" text-center  border border-dark" style="background-color: #002060; color: white; font-size: 14px;">Gráfica </th>
                                    </tr>
                                    <tr>
                                        <th class=" text-center  border border-dark" style="background-color: #B7DEE8; font-size: 12px;">Meta</th>
                                    </tr>
                                    <tr>
                                        <th class=" text-center  border border-dark" style="background-color: #DDD9C4; font-size: 12px;">NOMBRE DE EQUIPO EAD</th>
                                    </tr>
                                    <td class="border border-dark">
                                        <div id="divCanvas" class="d-flex col-12 col-lg-10 col-xl-8 mx-auto">
                                            <canvas id="myChart" class="w-100"></canvas>
                                        </div>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="scroll2 col-12 col-lg-10 col-xl-8  mx-auto">
                            <!--Tabla compromisos-->
                            <?php include("tabla_compromisos.php") ?>
                            <!---->
                        </div>
                    </div>
                </div>
            </div>

            <!--////////////////////////////////////////////////////////////////-->
            <div v-if="ventana=='ScoreCard'" class="row" style="font-size:0.9em"> <!--bloque SCORECARD-->
                <div class="d-flex justify-content-center pt-3 text-center">
                    <div>
                        <span class="mx-2">Equipo: </span>
                        <select v-model="equipo_score" @change="consultarSeguimientoAsistencia(), consultarScoreCard()">
                            <option value="" disabled>Seleccione...</option>
                            <option v-for="equipos in consultaEAD" :value="equipos[0].id+'<->'+equipos[0].nombre_ead+'<->'+equipos[0].planta+'<->'+equipos[0].area+'<->'+equipos[0].id_ponderacion">{{equipos[0].nombre_ead}}</option>
                        </select>
                    </div>
                    <div>
                        <span class="mx-2">Año: </span>
                        <select v-model="anio_score" @change="consultarSeguimientoAsistencia(), consultarScoreCard()">
                            <option disabled default selected value="">Seleccione...</option>
                            <option v-for="anio in anios" :value="anio">{{anio}}</option>
                        </select>
                    </div>
                    <div>
                        <span class="mx-2">Mes: </span>
                        <select v-model="mes_score" @change="consultarSeguimientoAsistencia(), consultarScoreCard()">
                            <option disabled default selected value="">Seleccione...</option>
                            <option v-for="mes in meses" :value="mes">{{mes}}</option>
                        </select>
                    </div>
                    <!--<div>
                        <span class="mx-2">Ponderacion: </span>
                        <select v-model="ponderacion_score" @change="consultarSeguimientoAsistencia(), consultarScoreCard()">
                            <option disabled default selected value="">Seleccione...</option>
                            <option v-for="ponderacion in listaPonderaciones" :value="ponderacion.id">{{ponderacion.ponderacion}}</option>
                        </select>
                    </div>-->
                </div>
                <div class="col-12  d-flex justify-content-center mt-2">
                    <span v-show="equipo_score.split('<->')[4]==''" class="badge rounded-pill bg-warning text-dark">Equipo sin ponderacion asignada</span>
                </div>
                <div class="col-12 d-flex justify-content-center mx-auto">
                    <div class="scroll-w">
                        <div v-if="equipo_score != '' && anio_score != '' && mes_score != ''" class="col-12 d-flex justify-content-center" style="min-width:1200px">
                            <label v-if="nombrePonderacionAsignada!=''" style="font-size:0.8em"> Ponderacion: <span class="badge bg-success"> {{ nombrePonderacionAsignada }}</span></label>
                            <span v-else class="badge bg-danger">Sin Ponderacion Asignada</span>
                        </div>
                        <table style="max-width:1400px; min-width:1200px" class="mt-2 table table-bordered  mb-5 table  table-bordered border-dark text-center">
                            <thead>
                                <tr>
                                    <!--<th class="bg-dark"></th>-->
                                    <th class="columna-color-criterios"></th>
                                    <!--<th scope="row" class="bg-dark text-light">Unidades</th>-->
                                    <th scope="row" class="columna-color-criterios">Valor actual</th>
                                    <th scope="row" class="columna-color-criterios">Puntos obtenidos</th>
                                    <th scope="row" class="columna-color-criterios">Ponderación</th>
                                    <th scope="row" class="columna-color-criterios">Puntos evaluados</th>
                                </tr>
                            <tbody v-cloak>
                                <tr v-for="(criterio,fila) in criteriosDinamicasSC" v-show="equipo_score">
                                    <!--<td v-show="fila===0" rowspan="3" class="text-center align-middle" style="background:#e9ecef; font-size:0.8em; max-width:45px;"> <label class="rotando" style="min-width:200px;height:10px">Valor y Sustentable</label></td>
                                    <td v-show="fila==3" rowspan="4" class="text-center align-middle" style=" background:#e9ecef;font-size:0.8em; max-width:45px;"> <label class="rotando " style="min-width:200px;height:10px"> Social</label></td>
                                    <td v-show="fila==7" rowspan="3" class="text-center align-middle" style="background:#e9ecef;font-size:0.8em; max-width:45px;"><label class="rotando" style="min-width:200px; height:10px">Mejora Continua</label></td>-->
                                    <td scope="col" class="text-start ps-2" :class="puntosEvaluacion[criterio.id_criterios] ||  puntosEvaluacion[criterio.id_criterios]===0 ? 'columna-color-criterios':''">{{criterio.nombre}}</td>
                                    <!--<td>
                                       <label v-show="fila==0">#</label>
                                        <label v-show="fila==1">Kg.</label>
                                        <label v-show="fila==2">%</label>
                                        <label v-show="fila==3">#</label>
                                        <label v-show="fila==4">#</label>
                                        <label v-show="fila==5">#</label>
                                        <label v-show="fila==6">#</label>
                                        <label v-show="fila==7">%</label>
                                        <label v-show="fila==8">#</label>
                                        <label v-show="fila==9">%</label>
                                    </td>-->
                                    <!--Columna Valor Actual-->
                                    <td class="middle-center" :class="puntosEvaluacion[criterio.id_criterios] || puntosEvaluacion[criterio.id_criterios]===0 ? 'columna-color-una':''">
                                        <label v-if="criterio.tipo!='Input' && sumasDinamicasSC.some(elemento=>elemento.id_criterios==criterio.id_criterios && elemento.suma!='NaN')">
                                            {{sumasDinamicasSC.filter(elemento=>elemento.id_criterios==criterio.id_criterios).map(elemento=>elemento.suma)[0]}}
                                        </label>
                                        <label v-else-if="criterio.tipo!='Input' && criterio.id_criterios!=10 ">
                                            <span class="badge bg-danger text-white">Sin valores en gráfica</span>
                                        </label>
                                        <input class="text-center" v-show="criterio.tipo=='Input'" v-model="inputValorActual[criterio.id_criterios]" @keyup.enter="guardarDatoScoreCard(criterio.id_criterios)"></input>
                                        <label v-if="criterio.id_criterios==10">{{asistenciaSC}}</label><!--10 es el id cumplimiento de proyecto en la tabla de la BD-->
                                    </td>
                                    <!--Columna Puntos Obtenidos-->
                                    <td :class="puntosEvaluacion[criterio.id_criterios] ||  puntosEvaluacion[criterio.id_criterios]===0 ? 'columna-color-una':''">
                                        <label v-if="puntosCriterios.some(elemento=>elemento.id_criterios==criterio.id_criterios)">
                                            <label v-if="puntosCriterios.some(elemento=>elemento.id_criterios==criterio.id_criterios && elemento.puntos !== null && elemento.puntos !== undefined)">
                                                {{puntosCriterios.filter(elemento=>elemento.id_criterios==criterio.id_criterios).map(elemento=>elemento.puntos)[0]}}
                                            </label>
                                            <label v-else>
                                                <span class="badge bg-warning text-dark">Sin rango en ponderacion</span>
                                            </label>
                                        </label>
                                        <label v-if="criterio.tipo=='Input' && inputValorActual[criterio.id_criterios]!=null && puntosObtenidos.some(elemento => elemento.id_criterios == criterio.id_criterios)">
                                            <label>
                                                {{puntosObtenidos.filter(elementos=>elementos.id_criterios==criterio.id_criterios).map(puntos=>puntos.puntos)[0]}}
                                            </label>
                                        </label>
                                        <label v-if="criterio.tipo=='Input' && inputValorActual[criterio.id_criterios]!=null && puntosObtenidos.filter(elementos=>elementos.id_criterios==criterio.id_criterios)">
                                            <label v-cloak v-if="!puntosObtenidos.filter(elementos=>elementos.id_criterios==criterio.id_criterios).map(puntos=>puntos.puntos)[0] && puntosObtenidos.filter(elementos=>elementos.id_criterios==criterio.id_criterios).map(puntos=>puntos.puntos)[0]!=0">
                                                <span class="badge bg-warning text-dark">Sin rango en ponderacion</span>
                                            </label>
                                        </label>
                                        <label v-if=" criterio.tipo=='Input' && inputValorActual[criterio.id_criterios]==null">
                                            <span class="badge bg-dark">Coloque valor actual</span>
                                        </label>

                                        <div v-if="criterio.id_criterios==10">{{asistenciaPuntosCumplimiento}}</div>
                                        <div v-if="criterio.id_criterios==10 && asistenciaPuntosCumplimiento===undefined">
                                            <span class="badge bg-warning text-bg-warning">Sin rango en ponderación</span>
                                        </div>
                                    </td>
                                    <!--Columna Ponderacion-->
                                    <td :class="puntosEvaluacion[criterio.id_criterios] || puntosEvaluacion[criterio.id_criterios]===0 ? 'columna-color-una':''">
                                        <label v-show="fila==(criteriosDinamicasSC.length-1)-((criteriosDinamicasSC.length-1)-fila)" class="text-primary">
                                            <button v-show="inputPonderacionSC!==(criteriosDinamicasSC.length-1)-((criteriosDinamicasSC.length-1)-fila)" @click="activarInput(fila)" class="btn-input">{{inputColumnaPonderacion[criterio.id_criterios]}}</button>
                                            <input v-show="inputPonderacionSC===(criteriosDinamicasSC.length-1)-((criteriosDinamicasSC.length-1)-fila)" @keyup.enter="guardarDatoScoreCard(criterio.id_criterios)" v-model="inputColumnaPonderacion[criterio.id_criterios]" class="form-control text-center" type="text" />
                                        </label>
                                    </td>
                                    <td :class="puntosEvaluacion[criterio.id_criterios]>=0 ? 'columna-color-cuatro':''"><!--Puntos Evaluados-->
                                        {{puntosEvaluacion[criterio.id_criterios]}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-end-0 border-top-0 border-white" colspan="4"></td>
                                    <td :class="{ 'fw-bold columna-color-criterios': puntosEvaluacion.length>0}">
                                        {{isNaN(totalSC) || totalSC==0  ? "TOTAL" : totalSC}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!--FIN SCORECARD-->
            <!--////////////////////////////////////////////////////////////////-->

            <!--/////////////////////////////////////////////////COMPETENCIA AREA ////////////////////////////////////////////////////////////////////-->
            <div v-if="ventana=='Competencias'">
                <div class=" row col-12 text-center d-flex justify-content-center mt-2 ">
                    <div class="col-4">
                        <span class="mx-2">Seleccione Foro: </span>
                        <select>
                            <option disabled default selected value="">Seleccione...</option>
                            <option>Foro1</option>
                            <option>Foro2</option>
                            <option>Foro3</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="col-4 offset-4">
                        <div class="imagenEngrane"></div>
                        <div class="border text-center">Ganador: </div>
                        <div class="border border-top-0 text-center">The Winner</div>
                    </div>
                    <div class="d-flex offset-4">
                        <div class="col-2 me-3">
                            <div class="imagenEngrane"></div>
                            <div class="border  text-center">Equipo 1 </div>
                            <div class=" border border-top-0 text-center">Nombre del Equipo</div>
                        </div>
                        <div class="col-2">
                            <div class="imagenEngrane"></div>
                            <div class="border text-center">Equipo 2 </div>
                            <div class="border border-top-0 text-center">Nombre del Equipo</div>
                        </div>
                        <div class="col-2">
                            <div class="imagenEngrane"></div>
                            <div class="border text-center">Equipo 2 </div>
                            <div class="border border-top-0 text-center">Nombre del Equipo</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="d-flex ">
                        <div v-for="i in 11" class="col-1 me-2">
                            <div class="imagenEngrane"></div>
                            <div class="border  text-center">Equipo</div>
                            <div class=" border border-top-0 text-center">Nombre {{i}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/////////////////////////////////COMPETENCIA DE PLANTA////////////////////////////////////////////////////////////////////////////////////////-->
            <div v-if="ventana == 'Evaluar'">
                <div class="scroll">
                    <div class="col-12 d-flex justify-content-center">
                        <table class="table table-bordered table-striped mt-5">
                            <thead class="thead-dark bg-secondary">
                                <tr class="table-active text-center">
                                    <th>Orden</th>
                                    <th>Planta</th>
                                    <th>Área</th>
                                    <th>Nombre EAD</th>
                                    <th>Proyecto</th>
                                    <th>Mi comentario</th>
                                    <th>Evaluar</th>
                                    <th>Calificación Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="(equipoEvaluador, index) in equiposEvaluador">
                                    <th><b>{{index+1}}</b></th>
                                    <td>{{equipoEvaluador.planta}}</td>
                                    <td>{{equipoEvaluador.area}}</td>
                                    <td>{{equipoEvaluador.nombre_ead}}</td>
                                    <td class="text-start">{{equipoEvaluador.proyecto}}</td>
                                    <td class="text-start"> {{equipoEvaluador.comentario}}</td>
                                    <td>
                                        <button v-if="!isNaN(parseInt(equipoEvaluador.calificacion)) && parseInt(equipoEvaluador.calificacion) > 0" class="botones-actualizar  rounded-pill border-0 my-1 px-2 mb-2" @click="modalPreguntas(equipoEvaluador.nombre_ead),consultarPreguntasEvaluador(equipoEvaluador.id_ead_foro),IDCalifiacion(equipoEvaluador.id_calificacion,equipoEvaluador.id_ead_foro,equipoEvaluador.comentario)">Reevaluar</button>

                                        <button v-else class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="modalPreguntas(equipoEvaluador.nombre_ead),consultarPreguntasEvaluador(equipoEvaluador.id_ead_foro),IDCalifiacion(equipoEvaluador.id_calificacion,equipoEvaluador.id_ead_foro)">Evaluar</button>
                                    </td>
                                    <td> {{equipoEvaluador.calificacion}}</td>
                                </tr>
                                <!-- Repite las filas para EAD 2 al 14 según sea necesario  -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FIN DE COMPETENCIA PLANTA -->
                <!--Modal Preguntas Evaluacion-->
                <div id="modalEvaluacion" class="modal" tabindex="-1" style="font-size: 0.9em;" data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-xl-down modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <label class="modal-title">Evaluación: {{tituloModal}} <span class="text-primary ms-2"><b>{{mensaje}}</b></span></label>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cerrarModalHistorial()"></button>
                            </div>
                            <div class="modal-body">
                                <div v-for="(preguntas,etapas,bloques) in preguntas_evaluar"><!--No estoy necesitando la variable preguntas solo etapas y bloques es index un simple numero--->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="bg-dark text-light" colspan="2" scope="col">{{bloques+1}} - {{etapas}}</th>
                                                <th scope="col">
                                                        <label class="w-25" style="display: inline-block">{{preguntas_evaluar[etapas][0].peso}}%</label>
                                                        <label class="w-75" style="font-size:0.8em; display: inline-block" v-show="!contestado[etapas].includes('No') && !contestado[etapas].includes('Sin Contestar')"><span class="badge bg-primary mx-auto"><b>Completada</b></span></label>
                                                        <label class="w-75" style="font-size:0.8em; display: inline-block" v-show="contestado[etapas].includes('Sin Contestar')"><span class="badge bg-danger mx-auto"><b>Sin completar</b></span></label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(pregunta,index) in preguntas_evaluar[etapas]"><!--Aqui tomo las preguntas-->
                                                <th tyle="width: 5%;" scope="row">{{bloques+1}}.{{index+1}}</th>
                                                <td tyle="width: 60%">{{pregunta.pregunta}}</td>
                                                <td style="width: 30%;" class="text-center" :style="{ background: contestado[etapas][index] === 'Si' ? '' : contestado[etapas][index] === 'Sin Contestar'  ? '#ffeeed' : ''}">
                                                    <input type="radio" class="opcion-radio" :value="0" v-model="pregunta.valor" :name="'contact'+pregunta.id" :checked="parseInt(pregunta.valor) === 0" @click="guardarValor(pregunta.id,pregunta.id_ead_foro,0)">
                                                    <label class="label-radios ms-1">0</label>
                                                    <input type="radio" class="opcion-radio" :value="1" v-model="pregunta.valor" :name="'contact'+pregunta.id" :checked="parseInt(pregunta.valor) === 1" @click="guardarValor(pregunta.id,pregunta.id_ead_foro,1)">
                                                    <label class="label-radios ms-1">1</label>
                                                    <input type="radio" class="opcion-radio" :value="2" v-model="pregunta.valor" :name="'contact'+pregunta.id" :checked="parseInt(pregunta.valor) === 2" @click="guardarValor(pregunta.id,pregunta.id_ead_foro,2)">
                                                    <label class="label-radios ms-1">2</label>
                                                    <input type="radio" class="opcion-radio" :value="3" v-model="pregunta.valor" :name="'contact'+pregunta.id" :checked="parseInt(pregunta.valor) === 3" @click="guardarValor(pregunta.id,pregunta.id_ead_foro,3)">
                                                    <label class="label-radios ms-1">3</label>
                                                    <input type="radio" class="opcion-radio" :value="4" v-model="pregunta.valor" :name="'contact'+pregunta.id" :checked="parseInt(pregunta.valor) === 4" @click="guardarValor(pregunta.id,pregunta.id_ead_foro,4)">
                                                    <label class="label-radios ms-1">4</label>
                                                    <input type="radio" class="opcion-radio" :value="5" v-model="pregunta.valor" :name="'contact'+pregunta.id" :checked="parseInt(pregunta.valor) === 5" @click="guardarValor(pregunta.id,pregunta.id_ead_foro,5)">
                                                    <label class="label-radios ms-1">5</label>
                                                </td>
                                                <td style="width: 5%;">
                                                    <i v-if="pregunta.valor!=null" class="text-success bi bi-check2"></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-5">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="bg-dark text-light">#</th>
                                                <th scope="col" class="bg-dark text-light">Etapas</th>
                                                <th scope="col" class="bg-dark text-light">Puntos Maximos</th>
                                                <th scope="col" class="bg-dark text-light">Puntos Reales</th>
                                                <th scope="col" class="bg-dark text-light">Ponderación</th>
                                                <th scope="col" class="bg-dark text-light">Calificación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(preguntas,etapas,bloques) in preguntas_evaluar">
                                                <tr><!--Aqui tomo las preguntas-->
                                                    <th scope="row">{{bloques+1}}.</th>
                                                    <td>{{etapas}}</td>
                                                    <td>{{datosEvaluar[etapas].puntos_maximos}}</td>
                                                    <td>{{datosEvaluar[etapas].puntos_reales}}</td>
                                                    <td>{{datosEvaluar[etapas].ponderacion}}%</td>
                                                    <td>{{(((datosEvaluar[etapas].puntos_reales / datosEvaluar[etapas].puntos_maximos) * (datosEvaluar[etapas].ponderacion / 100)) * 100).toFixed(2)}}</td>
                                                </tr>
                                            </template>
                                            <tr>
                                                <td></td>
                                                <td>Total</td>
                                                <td>{{sumaPuntosMaximos}}</td>
                                                <td>{{sumaPuntosReales}}</td>
                                                <td>{{sumaPonderacion}}</td>
                                                <td>{{calificacionEAD}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-evelyn align-items-center">
                                <div class="d-flex col-12 justify-content-center">
                                    <div class="d-flex col-8 col-lg-7 text-end">
                                        <div class="w-50 my-auto">
                                            <input type="text" class="form-control border border-info ms-lg-5" v-model="comentario" placeholder="Comentario (Opcional)" />
                                        </div>
                                        <div class="w-50">
                                            <button v-if="examenFinalizado=='Finalizado'" type="button" class="btn btn-primary" @click="enviarCalificacion()"><i class="bi bi-send-fill me-1"></i>Enviar Calificación</button>
                                            <button v-else type="button" class="btn btn-secondary" @click="contestarEvaluacion()"><i class="bi bi-send-fill me-1"></i>Enviar Calificación</button>
                                        </div>
                                    </div>
                                    <div class="d-flex col-2 col-lg-5 justify-content-end">
                                        <button type="button" class="btn btn-secondary p-1" data-bs-dismiss="modal" style="font-size: 1em;" @click="cerrarModalHistorial()">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Fin modal-->
            </div>

            <!--/////////////////////////////////FOROS////////////////////////////////////////////////////////////////////////////////////////-->
            <div v-if="ventana == 'Crear Competencia'">
                <div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2  offset-xl-2 col-xl-8  col-xxl-6 offset-xxl-3 px-4 shadow-lg mt-3 border border-white rounded-3 mx-auto" style="max-width: 700px;">
                    <div class="col-12">
                        <div class=" text-center  mx-auto" style="background-color: rgb(184, 14, 14);border-radius: 10px; margin-top: 20px; color: white; height: 41px;">
                            <div class=" d-flex" style="padding:2px 2px;">
                                <span class="input-group-text" style="border-radius: 10px 0px 0px 10px; border-color: #b80e0e; font-size: 0.8em">Nombre del foro: </span>
                                <input class="form-control select" v-model="nombre_foro" style="border-radius: 0px 10px 10px 0px; border-color: #b80e0e;">
                                </input>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                    <div class="text-center" style="background-color: rgb(184, 14, 14); border-radius: 10px; margin-top: 20px; color: white; height: 41px;">
                            <div class="input-group" style="padding:2px 2px;">
                                <span class="input-group-text " style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);font-size: 0.8em">Foro Global: </span>
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" v-model="foroGlobal" autocomplete="off" value="true"  style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);" @change="resetearVariablesForo(),consultarEADxPlanta()"/>
                                    <label class="btn btn-light border border-1 border-danger" for="btnradio1" style="font-size: 0.8em">Si</label>
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" v-model="foroGlobal" value="false" autocomplete="off"  style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);" @change="resetearVariablesForo()"/>
                                    <label class="btn btn-light me-2 border border-1 border-danger rounded-end" for="btnradio2" style="font-size: 0.8em">No</label>
                                    <span v-if="foroGlobal=='true'" class="input-group-text " style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);font-size: 0.8em">Planta: </span>
                                    <select v-if="foroGlobal=='true'" class="form-control select me-2" v-model="select_planta_foro" style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);" @change="consultarEADxPlanta()">
                                        <option value="" selected>Multiplanta</option>
                                        <option v-for="planta in plantasEADs">{{planta}}
                                    </select>
                                    <span v-if="foroGlobal=='true'" class="input-group-text" style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);font-size: 0.8em">Fecha: </span>
                                    <input v-if="foroGlobal=='true'" type="date" class="form-control select" v-model="fecha_foro" style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);"/>
                            </div>
                        </div>
                        <div  v-if="foroGlobal=='false'" class="text-center" style="background-color: rgb(184, 14, 14); border-radius: 10px; margin-top: 20px; color: white; height: 41px;">
                            <div class="input-group" style="padding:2px 2px;">
                                <span class="input-group-text " style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);font-size: 0.8em">Planta: </span>
                                <select class="form-control select me-2" v-model="select_planta_foro" style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);" @change="cosultarEADxArea()">
                                    <option value="" selected disabled>Seleccione..</option>
                                    <option v-for="planta in plantasEADs">{{planta}}

                                </select>
                                <span class="input-group-text" style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);font-size: 0.8em">Área: </span>
                                <select class="form-control select  me-2" v-model="select_area_foro" style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);" @change="cosultarEADxPlantaxArea()">
                                    <option value="" selected disabled>Seleccione..</option>
                                    <option v-for="area in areasEADs">{{area}}</option>
                                </select>
                                <span class="input-group-text" style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);font-size: 0.8em">Fecha: </span>
                                <input type="date" class="form-control select" v-model="fecha_foro" style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);">
                                </input>
                            </div>
                        </div>
                        <div class=" text-center mt-3 ">
                            <div class="d-flex">
                                <div class="col-6">
                                    <div class="text-center" style="border-radius: 10px; color: white; background-color: #b80e0e; font-size:0.8em;">
                                        Elija los EAD
                                    </div>
                                    <div class="scroll2">
                                        <div class="input-group mb-1" v-for="equipo in EADFiltrado">
                                            <div class="input-group-text" style="border-radius: 0px; ">
                                                <input class="form-check-input" type="checkbox" v-model="ckeckEADForo" :value="equipo.id" value="" aria-label="Checkbox for following text input">
                                            </div>
                                            <label class="form-control text-start" aria-label="Text input with checkbox" style="border-radius: 0px; font-size:0.8em">{{equipo.nombre_ead}}</label>
                                        </div>
                                        <div v-show="EADFiltrado.length<=0">
                                            <label class="form-control text-start text-secondary" aria-label="Text input with checkbox" style="border-radius: 0px; font-size:0.8em">No existen EAD's con planta y área seleccionada.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 ms-2">
                                    <div class="text-center" style="border-radius: 10px; color: white; background-color: #b80e0e; font-size:0.8em; display: flex; justify-content: space-between; align-items: center;  justify-content: center;">
                                        <div class="container text-center">
                                            <div class="row">
                                                <div class="col-5">
                                                    Evaluadores
                                                </div>
                                                <div class="col-7">
                                                    <button class="btn-circle-agregar rounded-pill px-2 border-0" @click="modalEvaluadores('Crear')"><i class="bi bi-plus-circle"></i></button>
                                                    <button class="btn-circle-actualizar rounded-pill px-2 border-0 ms-1" @click="modalEvaluadores('Actualizar')"><i class="bi bi-arrow-up-circle"></i></button>
                                                    <button class="btn-circle-eliminar rounded-pill px-2 border-0 ms-1" @click="eliminarEvaluador()"><i class="bi bi-x-circle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll3">
                                        <div class="input-group mb-1" v-for="(evaluador,index) in evaluadores">
                                            <div class="input-group-text" style="border-radius: 0px;">
                                                <input class="form-check-input" type="checkbox" v-model="ckeckEvaluadores" :value="evaluador.id" aria-label="Checkbox for following text input">
                                            </div>
                                            <label class="form-control text-start" aria-label="Text input with checkbox" style="border-radius: 0px; font-size:0.8em">{{evaluador.nombre}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="botones-crear rounded-pill mt-2 border-0" @click="crearForo()">Crear foro</button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="text-center " style="border-radius: 10px; margin-top: 20px; color: white; background-color: #b80e0e;font-size:0.8em;">
                            Foros creados
                        </div>
                        <div class="scroll4">
                            <table class=" table table-bordered text-center ">
                                <thead class="sticky-top">
                                    <tr class="table-active" style="font-size:0.8em !important">
                                        <th>
                                            Nombre
                                        </th>
                                        <th>
                                            Planta
                                        </th>
                                        <th>
                                            Área
                                        </th>
                                        <th>
                                            Detalles
                                        </th>
                                        <th>
                                            Estatus
                                        </th>
                                        <th>
                                            Actualizar
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="middle-center" v-for="foro in foros" style="font-size:0.8em">
                                        <td>
                                            {{foro.nombre_foro}}
                                        </td>
                                        <td>
                                            {{foro.planta}}
                                        </td>
                                        <td>
                                            {{foro.area}}
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-boton" @click="modalForosDetalles(foro.nombre_foro),consultarDetallesForo(foro.id)">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button v-if="foro.estatus=='Cerrado'" class="btn btn-danger btn-cerrar-foro " @click="estatusForo(foro.id,foro.nombre_foro,foro.estatus)"><i class="bi bi-door-open-fill"></i> Cerrado</button>
                                            <button v-if="foro.estatus=='Abierto'" class="btn btn-success btn-cerrar-foro" @click="estatusForo(foro.id,foro.nombre_foro,foro.estatus)"><i class="bi bi-door-closed-fill"></i> Abierto</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-boton">Actualizar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--ModalUsuarios-->
                            <div id="modal_evaluadores" class="modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label style="font-size:1em" class="modal-title">{{accion_evaluador}} evaluador</label>
                                            <button type="button" class="btn-close" @click="cerrarModal()" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center d-flex justify-content-center">
                                            <div class="row" v-if="accion_evaluador=='Crear'">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25" style="font-size: 0.8em;">Nombre</span>
                                                    <input type="text" class="w-75" v-model="nombre_evaluador">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25" style="font-size: 0.8em;">Usuario</span>
                                                    <input type="text" class="w-75" v-model="nomina_evaluador">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25" style="font-size: 0.8em;">Password</span>
                                                    <input type="text" class="w-75" v-model="contrasena_evaluador">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25" style="font-size: 0.8em;">Correo</span>
                                                    <input type="text" class="w-75" v-model="correo_evaluador">
                                                </div>
                                            </div>
                                            <div class="row" v-if="accion_evaluador=='Actualizar'">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25" style="font-size: 0.8em;">Nombre</span>
                                                    <input type="text" class="w-75" v-model="nombre_evaluador">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25" style="font-size: 0.8em;">Usuario</span>
                                                    <input type="text" class="w-75" v-model="nomina_evaluador">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25" style="font-size: 0.8em;">Password</span>
                                                    <input type="text" class="w-75" v-model="contrasena_evaluador">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25" style="font-size: 0.8em;">Correo</span>
                                                    <input type="text" class="w-75" v-model="correo_evaluador">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button v-if="accion_evaluador=='Crear'" type="button" class="btn btn-primary py-1" @click="guardarEvaluador('insertar')">Guardar</button>
                                            <button v-if="accion_evaluador=='Actualizar'" type="button" class="btn btn-warning py-1" @click="guardarEvaluador('actualizar')">Actualizar</button>
                                            <button type="button" class="btn btn-secondary py-1" @click="cerrarModal()">Salir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--FinModalDeDepartamento-->

                            <!--/////////////////////////////////////////////// MODAL VISUALIZAR FORO //////////////////// -->
                            <div id="modal_foros_detalles" class="modal" id="exampleModal" tabindex="-1" data-bs-keyboard="false">
                                <div  class="modal-dialog modal-dialog-centered modal-fullscreen  p-5">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label class="modal-title" id="exampleModalLabel" style="font-size:0.9em">Detalles {{tituloModal}}</label>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="verMenu = 'Si'"></button>
                                        </div>
                                        <div class="modal-body" style="font-size: 1em;">
                                            <div class="scroll6">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="thead-dark bg-secondary">
                                                        <tr class="table-active text-center">
                                                            <th>#</th>
                                                            <th>EAD's</th>
                                                            <th>Proyecto</th>
                                                            <th>Planta</th>
                                                            <th>Área</th>
                                                            <th v-for="(evaluador,index) in evaluadoresForo">
                                                                <label style="font-size:1em">{{evaluador.nombre}}</label><br>
                                                                <span class="badge text-bg-primary">Evaluador {{index+1}}</span>
                                                            </th>
                                                            <th>Calificación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="align-middle" v-for="(foroEAD, index) in eadsForo">
                                                            <th><b>{{index+1}}</b></th>
                                                            <td>{{foroEAD.nombre_ead}}</td>
                                                            <td width="300px">
                                                                <div class="row">
                                                                    <div class="div col-10 d-flex align-content-center my-auto">
                                                                        <input :id="'input'+index" v-if="editar_nombre_proyecto===index" type="text" class="form-control" :value="foroEAD.proyecto" />
                                                                        <label v-else class="text-start">{{foroEAD.proyecto}}</label>
                                                                    </div>
                                                                    <div class="div col-1  d-flex align-content-center  my-auto">
                                                                        <button type="button" v-if="editar_nombre_proyecto===index" @click="guardarNombreProyecto(foroEAD.ead_foro_id,index)"><i class="bi bi-floppy-fill"></i></button> <!--GUARDAR-->
                                                                        <button type="button" v-else @click="editarNombreProyecto(index)"><i class="bi bi-pencil-fill"></i></button> <!--EDITAR-->
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{foroEAD.planta}}</td>
                                                            <td>{{foroEAD.area}}</td>
                                                            <td v-for="evaluador in evaluadoresForo">
                                                                <label v-if="calificacionEvaluadorForo[foroEAD.ead_foro_id]">
                                                                    {{calificacionEvaluadorForo[foroEAD.ead_foro_id][evaluador.id].calificacion}}
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <label>
                                                                    <b>{{(foroEAD.suma/(evaluadoresForo.length)).toFixed(3)}}</b>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class=""></td>
                                                            <td class=""></td>
                                                            <td class=""></td>
                                                            <td class=""></td>
                                                            <td class=""></td>
                                                            <td :colspan="evaluadoresForo.length"></td>
                                                            <td class="text-primary fw-bold">
                                                                {{promedioCalificaciones}}
                                                            </td>
                                                        </tr>
                                                        <!-- Repite las filas para EAD 2 al 14 según sea necesario  -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="verMenu = 'Si'">Salir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>




            <!-- ////////////////////////////////////////////////////////////////CREAR COMPETENCIA ÁREA ///////////////////////////////////////////// -->
            <!--<div v-if="ventana == 'CrearCompetenciaPlanta'">
                <div class="col-12 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xxl-4 offset-xxl-4 px-4 shadow-lg mt-3 border border-white rounded-3">
                    <div class="col-12">
                        <div class=" text-center" style="background-color: rgb(184, 14, 14);border-radius: 10px; margin-top: 20px; color: white; height: 41px;">
                            <div class=" d-flex" style="padding:2px 2px;">
                                <span class="input-group-text" style="border-radius: 10px 0px 0px 10px; border-color: #b80e0e;">Nombre del foro: </span>
                                <input class="form-control select" style="border-radius: 0px 10px 10px 0px; border-color: #b80e0e;">
                                </input>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="  text-center" style="background-color: rgb(184, 14, 14); border-radius: 10px; margin-top: 20px; color: white; height: 41px;">
                            <div class="input-group" style="padding:2px 2px;">
                                <span class="input-group-text " style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);">Planta: </span>
                                <select class="form-control select" style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);">
                                    <option v-for="i in 3">Planta {{i}}
                                    <option>
                                </select>
                                <span class="input-group-text" style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);">Fecha: </span>
                                <input type="date" class="form-control select" style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);">
                                </input>
                            </div>
                        </div>
                        <div class=" text-center mt-3 ">
                            <div class="d-flex">
                                <div class="col-6">
                                    <div class="text-center" style="border-radius: 10px; color: white; background-color: #b80e0e;font-size:14px;">
                                        Equipos EAD
                                    </div>
                                    <div class="scroll2">
                                        <div class="input-group mb-1" v-for="i in 10">
                                            <div class="input-group-text" style="border-radius: 0px;">
                                                <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox for following text input">
                                            </div>
                                            <label class="form-control" aria-label="Text input with checkbox" style="border-radius: 0px;">Equipo nombre</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 ms-2">
                                    <div class="text-center" style="border-radius: 10px; color: white; background-color: #b80e0e; font-size:14px;">
                                        Evaluadores
                                    </div>
                                    <div class="scroll3">
                                        <div class="input-group mb-1" v-for="i in 10">
                                            <div class="input-group-text" style="border-radius: 0px;">
                                                <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox for following text input">
                                            </div>
                                            <label class="form-control" aria-label="Text input with checkbox" style="border-radius: 0px;">Evaluador</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="botones-crear rounded-pill mt-2 border-0">Crear foro</button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="text-center " style="border-radius: 10px; margin-top: 20px; color: white; background-color: #b80e0e;font-size:14px;">
                            Foros creados
                        </div>
                        <div class="scroll4">
                            <table class=" table table-bordered text-center  mt-3">
                                <thead class="sticky-top">
                                    <tr>
                                        <th>
                                            Nombre de equipo
                                        </th>
                                        <th>
                                            Visualizar
                                        </th>
                                        <th>
                                            Actualizar
                                        </th>
                                        <th>
                                            Eliminar
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="i in 10">
                                        <td>
                                            nombre1
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-boton">
                                                Actualizar
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-boton">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
            <!--/////////////////////////////////////////////// MODAL VSUALIZAR FORO //////////////////// -->
        </div>
        </div>
        </div>
        </div>
        <script src="js/panel.js?<? echo time(); ?>"></script>
        <script src="js/header.js?<? echo time(); ?>"></script>
    </body>

    </html>

<?php
} else {
    session_destroy();
    header("Location:index.php");
} ?>