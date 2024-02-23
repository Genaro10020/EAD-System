<?php session_start();
if (isset($_SESSION['nombre'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include('head.php'); ?>
    </head>

    <body class="container-fluid">

        <header>
            <div id="header-app"></div>
        </header>

        <div id="app" class="col-12" style="min-height: 80vh;">
            <div class="  d-flex text-center">
                <div class="col-1 dropdown" style="width:150px;  ">
                    <p class="dropbtn text-white" style="max-height:10px;">
                        <i class="bi bi-list">Menú</i>
                    </p>
                    <div class="dropdown-content">
                        <a><i class="bi bi-gear-fill">Configuracion</i></a>
                        <a><button class="btn_menu" @click="ventanas('Usuarios')"><b>Usuarios</b></button></a>
                        <a><button class="btn_menu" @click="ventanas('Departamentos')"><b>Departamentos</b></button></a>
                        <a><i class="bi bi-diagram-3-fill"> Equipos alto desempeño</i></a>
                        <a> <button class="btn_menu" @click="ventanas('Crear EAD'), consultarColaboradores(),consultarEAD()"><b>Crear EAD</b></button></a>
                        <a><button class="btn_menu" @click="ventanas('equiposEAD')"><b>Equipos EAD</b></button></a>
                        <a><i class="bi bi-trophy-fill"> Competencias</i></a>
                        <a><button class="btn_menu" @click="ventanas('CrearCompetenciaArea')"><b>Crear Competencia</b></button></a>
                        <!--<a><button class="btn_menu" @click="ventanas('CrearCompetenciaPlanta')"><b>Crear comp. planta </b></button></a>-->
                        <a><button class="btn_menu" @click="ventanas('CompetenciaArea')"><b>Competencia</b></button></a>
                        <!--<a><button class="btn_menu" @click="ventanas('CompetenciaPlanta')"><b>Competencia de planta</b></button></a>-->
                        <a><button class="btn_menu" @click="ventanas('CompetenciaPlanta')"><b>Evaluar</b></button></a>
                        <a><i class="bi bi-bar-chart-line-fill"> Graficos</i></a>
                        <a><button class="btn_menu" @click="ventanas('score'), consultarScoreCard(),consultarObjetivos()"><b>Scorecard</b></button></a>
                        <a><button class="btn_menu" @click="ventanas('Graficas')"><b>Graficas</b></button></a>
                    </div>
                </div>
                <div class="row  divLineaMenu w-100 d-flex text-center align-items-end text-light" style="font-size:14px">
                       <label class="text-center"> {{ventana}}</label>
                </div>
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
                                    <button class="btn_menu"  @click="ventanas('CompetenciaArea')" ><b>Competencia de area</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2 mt-sm-0 mt-lg-2">
                                    <button class="btn_menu"  @click="ventanas('CompetenciaPlanta')" ><b>Competencia de planta</b></button>
                                </div> -->
            </div>
            <div v-if="ventana=='Usuarios'" class="row"> <!--bloque USUARIO-->

                <div class="seccion1 col-12  col-lg-4 mt-2">

                    <div class="formulario col-12 mx-auto col-sm-112 col-lg-10  col-xl-8 col-xxl-6  pt-4 ps-2 pe-2 ps-lg-3  pe-lg-3  rounded shadow-sm">
                        <h6 class="text-center label-session "><b>{{titulo_formulario_usuarios}}</b></h6>
                        <form @submit.prevent="nuevoActualizarUsuario"  method="POST">
                            <div class="mb-1">
                                <label class=" label-session">Nombre</label>
                                <input type="text" class="form-control" v-model="nombre" required>
                            </div>

                            <div class="mb-1">
                                <label class=" label-session ">Nómina (Usuario)</label>
                                <input type="text" class="form-control" v-model="nomina" required>
                            </div>
                            <div class="mb-1">
                                <label class=" label-session ">Contraseña:</label>
                                <input type="text" class="form-control" v-model="contrasena" required>
                            </div>
                            <div class="mb-1">
                                <label class="label-session">Planta</label>
                                <select v-model="selector_planta" class="form-control select">
                                    <option disabled default selected value="">Seleccione Planta..</option>
                                    <option v-for="planta in plantas" :value="planta.nombre">{{planta.nombre}}</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label class="label-session ">Área</label>
                                <select v-model="selector_area" class="form-control select">
                                    <option disabled default selected value="">Seleccione Área..</option>
                                    <option v-for="area in areas" :value="area.nombre">{{area.nombre}}</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label class=" label-session ">Procesos</label>
                                <select v-model="selector_subarea" class="form-control select">
                                    <option disabled default selected value="">Seleccione Proceso.</option>
                                    <option v-for="subarea in subareas" :value="subarea.nombre">{{subarea.nombre}}</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label class=" label-session ">Tipo Usuario</label>
                                <select v-model="selector_tipo_usuario" class="form-control select">
                                    <option disabled default selected value="">Seleccione Tipo..</option>
                                    <option v-for="tipo in tipos" :value="tipo">{{tipo}}</option>
                                    <option class="text-success" @click="datosModalTipoUsuario()">Nuevo / Eliminar</option>
                                </select>
                            </div>
                            <div class="mb-1">
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
                <div class="seccion2 col-12   col-lg-8 mt-2">
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
                                    <td class="text-center">{{usuario.tipo_usuario}}</td>
                                    <td class="text-center">{{usuario.tipo_acceso}}</td>
                                    <td class="text-center"><button v-if="bandera_alta_o_actualizar == 1" class="btn btn-warning btn-actualizar px-2 py-0" @click="actualizarUsuario('actualizar',usuario.id)">Actualizar</button></td>
                                    <td class="text-center"><button v-if="usuario.tipo_acceso=='Usuario' && bandera_alta_o_actualizar == 1" class="btn btn-danger btn-eliminar px-2 py-0" @click="eliminarUsuario(usuario.id)">Eliminar</button></td>
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
                                            <!--<td><button class="btn btn-warning btn-actualizar px-2 py-0">Actualizar</button></td>-->
                                            <td><button class="btn btn-danger btn-eliminar px-2 py-0" @click="tipoUsuariosCRUD('eliminar',tipo)">Eliminar</button></td>
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
                            <tbody class=" border-dark">
                                <tr v-for="(planta, index) in plantas">
                                    <th scope="row">{{index+1}}</th>
                                    <td>{{planta.nombre}}</td>
                                    <td><button class="btn btn-warning btn-actualizar px-2 py-0" @click="datosModal('Planta','Actualizar',planta.id,planta.nombre)">Actualizar</button></td>
                                    <td><button class="btn btn-danger btn-eliminar px-2 py-0 " @click="eliminarDepartamento('Planta',planta.id)">Eliminar</button></td>
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
                            <tbody class=" border-dark">
                                <tr v-for="(area, index) in areas">
                                    <th scope="row">{{index+1}}</th>
                                    <td>{{area.nombre}}</td>
                                    <td><button class="btn btn-warning btn-actualizar px-2 py-0" @click="datosModal('Área','Actualizar',area.id,area.nombre)">Actualizar</button></td>
                                    <td><button class="btn btn-danger btn-eliminar px-2 py-0" @click="eliminarDepartamento('Área',area.id)">Eliminar</button></td>
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
                            <tbody class=" border-dark">
                                <tr v-for="(subarea, index) in subareas">
                                    <th scope="row">{{index+1}}</th>
                                    <td>{{subarea.nombre}}</td>
                                    <td><button class="btn btn-warning btn-actualizar px-2 py-0" @click="datosModal('Subárea','Actualizar',subarea.id,subarea.nombre)">Actualizar</button></td>
                                    <td><button class="btn btn-danger btn-eliminar px-2 py-0" @click="eliminarDepartamento('Subárea',subarea.id)">Eliminar</button></td>
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
            <div v-if="ventana=='score'" class="row"> <!--bloque SCORECARD-->
                <!--Selector de tipo de plantilla para visualizar-->

                <div class="col-12 text-center"> <button class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="modalScorecard(),cicloAnios()">Crear Score</button></div>
                <div class="col-12 text-dark fw-bold">
                    <div class="col-4 ms-2">
                        <select v-model="ver_plantillas" @change="consultarScoreCard()">
                            <option value="">Todos los ScoreCard</option>
                            <option v-for="plantilla in tipoPlantillas" :value="plantilla">{{plantilla}}</option>
                        </select>

                    </div>
                </div>
                <div class="scroll w-100">
                    <div class="mb-5">
                        <!-- <label class="d-flex justify-content-center mt-3 mb-3">{{ scoreArray[0].titulo }} ({{scoreArray[0].mes_anio}})</label>
                                                            <table class="mx-2 mb-5 table table-hover table-bordered border-dark text-center">
                                                                <thead class="encabezado-tabla-scorecard">
                                                                <tr>
                                                                    <th>V. Real</th>
                                                                    <th v-for="(objetivo,index) in objetivos" :key="index"> 
                                                                        <span v-for="(score, inde) in [scoreArray[scoreArray.length-scoreArray.length]]" key:="inde">
                                                                            <label v-if="score['objetivo' + (index + 1)]==objetivo.id">{{objetivo.objetivo}}</label>
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                        <tr v-for="(score, index) in scoreArray" :class="{'verde': index >= 1 && index <= 3, 'amarillo':index >= 4 && index <=7,'rojo': index >=9 && index <=11 }">
                                                                            <td v-if="index>=1" >{{score.valor_real}}</td>
                                                                            <td v-if="index>=1" >{{score.objetivo1}}</td>
                                                                            <td v-if="index>=1" >{{score.objetivo2}}</td>
                                                                            <td v-if="index>=1" >{{score.objetivo3}}</td>
                                                                            <td v-if="index>=1" >{{score.objetivo4}}</td>
                                                                            <td v-if="index>=1">{{score.objetivo5}}</td>
                                                                            <td v-if="index>=1">{{score.objetivo6}}</td>
                                                                            <td v-if="index>=1">{{score.objetivo7}}</td>
                                                                            <td v-if="index>=1">{{score.objetivo8}}</td>
                                                                            <td v-if="index>=1" >{{score.objetivo9}}</td>
                                                                            <td v-if="index>=1" >{{score.objetivo10}}</td>
                                                                        </tr>
                                                                </tbody>
                                                            </table> -->
                        <div class=" col-12 row d-flex justify-content-center">
                            <div class=" row col-12 text-center d-flex justify-content-center ">
                                <div class="col-4">
                                    <span class="mx-2">Equipos EAD: </span>
                                    <select>
                                        <option disabled default selected value="">Seleccione...</option>
                                    </select>
                                </div>
                            </div>
                            <table style="max-width:1200px" class=" mt-3 table table-bordered mx-2 mb-5 table  table-bordered border-dark text-center">
                                <thead>
                                    <tr>
                                        <th class="bg-dark"></th>
                                        <th class="bg-dark"></th>
                                        <th scope="row" class="bg-dark text-light" v-for="columnas in columnasSC">{{columnas}}</th>
                                    </tr>
                                <tbody>
                                    <tr v-for="(filas,index1) in filasSC">
                                        <td v-show="index1===0" rowspan="3" class="text-center align-middle" style="background:#e9ecef; font-size:0.8em; max-width:45px;"> <label class="rotando" style="min-width:200px;height:10px">Valor y Sustentable</label></td>
                                        <td v-show="index1==3" rowspan="4" class="text-center align-middle" style=" background:#e9ecef;font-size:0.8em; max-width:45px;"> <label class="rotando " style="min-width:200px;height:10px"> Social</label></td>
                                        <td v-show="index1==7" rowspan="3" class="text-center align-middle" style="background:#e9ecef;font-size:0.8em; max-width:45px;"><label class="rotando" style="min-width:200px; height:10px">Mejora Continua</label></td>
                                        <th scope="col" class="text-start">{{filas}}</th>
                                        <td v-for="(columnas, index2) in columnasSC">
                                            <label v-show="index1==0 && index2==0">#</label>
                                            <label v-show="index1==1 && index2==0">Kg.</label>
                                            <label v-show="index1==2 && index2==0">%</label>
                                            <label v-show="index1==3 && index2==0">#</label>
                                            <label v-show="index1==4 && index2==0">#</label>
                                            <label v-show="index1==5 && index2==0">#</label>
                                            <label v-show="index1==6 && index2==0">#</label>
                                            <label v-show="index1==7 && index2==0">%</label>
                                            <label v-show="index1==8 && index2==0">#</label>
                                            <label v-show="index1==9 && index2==0">%</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-end-0 border-top-0 border-white" colspan="6"></td>

                                        <td class="border border-1 border-dark border-start-1">
                                            TOTAL
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--ModalScorecard-->
                <div id="modal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="mx-auto">Nuevo ScoreCard</h5>
                                <button type="button" class="badge rounded-pill bg-secondary border border-0" @click="cerrarModal()">X</button>
                            </div>
                            <div class="row modal-body  text-start text-sm-center d-flex justify-content-around">
                                <div class=" mb-5 mb-sm-0  col-12 col-sm-4">
                                    <label class="mx-2 my-auto">UGB: </label>
                                    <input type="text" v-model="ugb"></input>
                                </div>
                                <div class=" mb-5 mb-sm-0  col-12 col-sm-2">
                                    <label class="mx-2 my-auto">Mes:</label>
                                    <select v-model="mes_seleccionado">
                                        <option v-for="mes in meses" :value="mes">{{mes}}</option>
                                    </select>
                                </div>
                                <div class=" mb-5 mb-sm-0  col-12 col-sm-2">
                                    <label class="mx-2 my-auto">Año:</label>
                                    <select v-model="anio_seleccionado">
                                        <option v-for="anio in anios" :value="anio">{{anio}}</option>
                                    </select>
                                </div>
                                <div class=" mb-5 mb-sm-0  col-12 col-sm-3">
                                    <label class="mx-2 my-auto">Plantilla:</label>
                                    <select v-model="select_plantillas">
                                        <option v-for="plantilla in plantillas" :value="plantilla">{{plantilla}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary py-1" @click="cerrarModal()">Salir</button>
                                <!--<button v-if="accion_departamento=='Actualizar'" type="button" class="btn btn-warning py-1" @click="actualizarDepartamento()">Actualizar</button>-->
                                <button type="button" class="btn btn-primary py-1" @click="crearScoreCard()">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FinModalDeDepartamento-->
            </div> <!--FIN SCORECARD-->
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
                                <div class="input-group mt-3">
                                    <span class="text-ezquierdo-form input-group-text">Líder del Equipo</span>
                                    <select v-model="select_lider_equipo" class="form-control select" aria-label="With textarea">
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option v-for="usuario in filtraLiderEquipo()">
                                            {{usuario.nombre}}
                                        </option>
                                    </select>
                                </div>
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
                            <div :show="nombresIntegrantes.lenght>0" class="col-12 text-center " style="font-size:10px">
                           <label class="mt-2"> Integrantes:</label>
                                    <ul class="text-start">
                                        <li v-for="(nombre,index) in nombresIntegrantes">{{index+1}}.- {{nombre}}</li>
                                    </ul>
                            </div>
                            <div class="col-12 text-center mt-4 mb-2">
                                <button  v-if="var_actualizarEAD" class="botones-actualizar rounded-pill border-0 my-1 px-2 mb-2" @click="actualizarEAD()">Actualizar EAD</button>
                                <button  v-if="!var_actualizarEAD" class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="crearEAD()">Crear EAD</button>
                                <button  v-if="var_actualizarEAD" class="botones-cancelar rounded-pill border-0 my-1 px-2 mb-2 ms-2" @click="cancelarActualizar()">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-xl-2"><!--Colaboradores-->
                    <span class=" badge text-light bg-secondary mb-2">Selecciona los colaboradores</span>
                    <div class="scroll w-100">
                        <div class="form-check" v-for="colaborador in colaboradores" style="font-size:0.7em;">
                            <input class="form-check-input" type="checkbox" :value="colaborador.id+'<->'+colaborador.colaborador"  v-model="checkIntegrantes" @change="seleccionadosIntegrantes()" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{colaborador.colaborador}} ({{colaborador.numero_nomina}})
                            </label>
                        </div>
                    </div>
                </div>
                <div class=" col-xl-5 scroll5">
                        <div class="row">
                        <div class="col-6 d-flex justify-content-center" v-for="(equipos, index) in consultaEAD" :key="index">
                            <div class="tarjeta my-2">
                                <div class="container text-center">
                                    <label class="letrasCard text-center mb-2"> 
                                        {{ equipos[0].nombre_ead }}
                                        <button class="btn btn-warning btn-actualizar px-2 py-0 ms-3" @click="datosParaEditarEAD(equipos[0].id)">
                                            <i class="bi bi-pencil"></i> Actualizar
                                        </button>
                                    </label>
                                    <br>
                                    <b class="letrasCard">Planta:</b> {{ equipos[0].planta }}
                                    <b class="letrasCard">Area:</b> {{ equipos[0].area }}<br>
                                    <ul class="text-start">
                                        <li v-for="(integrante, posicion) in integrantesEAD[equipos[0].id]" style="margin-bottom: 2px; font-size: 12px;">
                                            {{ posicion+1 }}.- {{ integrante.colaborador }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </div>

                </div>
            </div>
            <div v-if="ventana=='equiposEAD'" class="row"> <!--bloque CREAR EAD-->
                <!--///////////////////////////////////////-->

                <table class="mx-2 mb-5 table table-hover border-dark text-center">
                    <thead>
                        <tr>
                            <th>Nombre del equipo</th>
                            <th>Planta</th>
                            <th>Area</th>
                            <th>Proceso</th>
                            <th>Lider del equipo</th>
                            <th>Cordinador</th>
                            <th>Jefe de area</th>
                            <th>Ing. Procesos</th>
                            <th>Ing. Calidad</th>
                            <th>Supervisor</th>
                            <th>Integrantes del equipo</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        <tr style="vertical-align: middle">
                            <td>Nombre del equipo</td>
                            <td>Planta</td>
                            <td>Area</td>
                            <td>Proceso</td>
                            <td>Lider del equipo</td>
                            <td>Cordinador</td>
                            <td>Jefe de area</td>
                            <td>Ing. Procesos</td>
                            <td>Ing. Calidad</td>
                            <td>Supervisor</td>
                            <td>Integrantes del equipo<br>Integrantes del equipo<br>Integrantes del equipo<br>Integrantes del equipo<br>Integrantes del equipo<br>Integrantes del equipo<br>Integrantes del equipo<br>Integrantes del equipo<br></td>
                        </tr>


                    </tbody>
                </table>

                <!--///////////////////////////////////////-->
            </div>
            <!--///////////////////////////////////////-->
            <div v-if="ventana == 'Graficas'">

                <!-- <div class=" row d-flex justify-content-center align-items-center p-1 text-center my-2">
                                    <div class="col-12 col-sm-3  col-lg-2 col-xl-2 col-xxl-2 ">
                                        <button class="btn_menu2" @click="graficas('Rechazos')"><b>Rechazos</b></button>
                                    </div>
                                    <div class="col-12 col-sm-3   col-lg-2  col-xl-2 col-xxl-2">
                                        <button class="btn_menu2" @click="graficas('Merma')"><b>Merma</b></button>
                                    </div>
                                    <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                        <button class="btn_menu2"  @click="graficas('Eficiencia')" ><b>Eficiencia</b></button>
                                    </div>
                                    <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                        <button class="btn_menu2"  @click="graficas('Accidentes')" ><b>Accidentes</b></button>
                                    </div>
                                    <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                        <button class="btn_menu2"  @click="graficas('Actos inseguros')" ><b>Actos inseguros</b></button>
                                    </div>
                                    <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                        <button class="btn_menu2"  @click="graficas('Ausentismo')" ><b>Ausentismo</b></button>
                                    </div>
                                    <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                        <button class="btn_menu2"  @click="graficas('Cumplimiento del proyecto')" ><b>Cumplimiento del proyecto</b></button>
                                    </div>
                            </div> -->
                <div class="input-group my-3">
                    <span class="input-group-text">Seleccione tabla</span>
                    <select v-model="tipoTablas" @change="graficasEAD()">
                        <option value="">Seleccione...</option>
                        <option v-for="tabla in tipoTabla" :value="tabla">{{ tabla }}</option>
                    </select>

                </div>

                <!--/////////////////////////////////////////////////////////////////INICIA RECHAZOS -->
                <div v-if="tipoTablas == 'Rechazos'">
                    <div class="d-flex">
                        <div class="scroll" style=" max-height: 400px;">
                            <table class="text-center ms-3 me-5">
                                <thead>
                                    <tr>
                                        <th class="border border-dark" style="font-size: 13px;">
                                            Dia
                                        </th>
                                        <th class="border border-dark" style="font-size: 13spx;">
                                            Merma
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(i,index) in 31">
                                        <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                            {{i}}
                                        </td>
                                        <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; ">
                                            <input :id="'graficaRechazo'+index" value="datosGraficaRechazo" @change="insertandoValores(index)" class="text-center" type="number" style=" height: 20px; width: 60px; font-size: 13px; background-color: #B7DEE8; ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark" style="font-size: 13px; height: 20px; width: 60px;">

                                        </td>
                                        <td class=" border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                            {{sumaTabla}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <table>
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white; font-size: 14px;">Grafica de rechazos</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8; font-size: 12px;">Meta: #kg promedio diario</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4; font-size: 12px;">NOMBRE DE EQUIPO EAD</th>
                                </tr>
                                <td class="border border-dark">
                                    <div class="d-flex justify-content-center" id="divCanvas" style="min-width: 80vw; max-height:40vh;">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex col-4 offset-4 mt-2">
                        <table class=" text-center table table-bordered ">
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th style="background-color: #002060; color: white;"><label>Responsable:</label>
                                        <input class="input-container ms-2" type="text"></input>
                                    </th>
                                    <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                        <select class="ms-2">
                                            <option v-for="mes in meses">
                                                {{mes}}
                                            </option>
                                        </select>
                                    </th>
                                </tr>
                                <tr style="background-color: #002060; color: white;">
                                    <th>CAUSAS</th>
                                    <th>FECHA</th>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width: 350px;"></input></td>
                                    <td><input type="date"></input></td>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width: 350px;"></td>
                                    <td><input type="date"></input></td>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width: 350px;"></td>
                                    <td><input type="date"></input></td>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width: 350px;"></td>
                                    <td><input type="date"></input></td>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/////////////////////////////////////////////////VENTANA DE MERMA////////////////////////////////////////////////////////////////////-->
                <div v-if="tipoTablas == 'Merma'" class="row">
                    <div class="col-12 d-flex">
                        <div class="scroll" style=" max-height: 500px;">
                            <table class="  text-center ms-3 me-5">
                                <thead class="sticky-top">
                                    <tr>
                                        <th class="border border-dark" style="font-size: 13px;">
                                            Dia
                                        </th>
                                        <th class="border border-dark" style="font-size: 13spx;">
                                            Merma
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="i in 31">
                                        <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                            {{i}}
                                        </td>
                                        <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; ">
                                            <input class="text-center" type="number" style=" height: 20px; width: 60px; font-size: 13px; background-color: #B7DEE8; ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark" style="font-size: 13px; height: 20px; width: 60px;">

                                        </td>
                                        <td class=" border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                            SUMA
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <table>
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white; font-size: 14px;">Grafica de merma</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8; font-size: 12px;">Meta: #kg promedio diario</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4; font-size: 12px;">NOMBRE DE EQUIPO EAD</th>
                                </tr>
                                <td class="border border-dark" style="width: 40px; ">
                                    <div id="divCanvas" style="min-height: 30hv; min-width: 80vw; ">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex col-4 offset-4 mt-2">
                        <table class=" text-center table table-bordered ">
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th style="background-color: #002060; color: white;"><label>Responsable:</label>
                                        <input class="input-container ms-2" type="text"></input>
                                    </th>
                                    <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                        <select class="ms-2">
                                            <option v-for="mes in meses">
                                                {{mes}}
                                            </option>
                                        </select>
                                    </th>
                                </tr>
                                <tr style="background-color: #002060; color: white;">
                                    <th>CAUSAS</th>
                                    <th>FECHA</th>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width: 350px;"></input></td>
                                    <td><input type="date"></input></td>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width: 350px;"></td>
                                    <td><input type="date"></input></td>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width: 350px;"></td>
                                    <td><input type="date"></input></td>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width: 350px;"></td>
                                    <td><input type="date"></input></td>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--/////////////////////////////////////////////////VENTANA DE EFICIENCIA////////////////////////////////////////////////////////////////////-->
                <div v-if="tipoTablas == 'Eficiencia'">
                    <div class="col-12 d-flex   ">
                        <div class="scroll" style=" max-height: 500px;">
                            <table class="  text-center ms-3 me-5">
                                <thead class="sticky-top">
                                    <tr>
                                        <th class="border border-dark" style="font-size: 13px;">
                                            Dia
                                        </th>
                                        <th class="border border-dark" style="font-size: 13spx;">
                                            Eficiencia
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="i in 31">
                                        <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                            {{i}}
                                        </td>
                                        <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; ">
                                            <input class="text-center" type="number" style=" height: 20px; width: 60px; font-size: 13px; background-color: #B7DEE8; ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark" style="font-size: 13px; height: 20px; width: 60px;">

                                        </td>
                                        <td class=" border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                            SUMA
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--////////////////////////////////////////////////////////////////// INICIA TABLA PARA GRAFICA -->
                        <table>
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white; font-size: 14px;">Grafica de rechazos</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8; font-size: 12px;">Meta: #kg promedio diario</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4; font-size: 12px;">NOMBRE DE EQUIPO EAD</th>
                                </tr>
                                <td class="border border-dark" style="width: 40px; ">
                                    <div id="divCanvas" style="min-height: 30hv; min-width: 80vw; ">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" col-12">
                        <div class="d-flex col-4 offset-4 mt-2 ">
                            <table class=" text-center table table-bordered ">
                                <thead>

                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="background-color: #002060; color: white;"><label>Responsable:</label>
                                            <input class="input-container ms-2" type="text"></input>
                                        </th>
                                        <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                            <select class="ms-2">
                                                <option v-for="mes in meses">
                                                    {{mes}}
                                                </option>
                                            </select>
                                        </th>
                                    </tr>
                                    <tr style="background-color: #002060; color: white;">
                                        <th>CAUSAS</th>
                                        <th>FECHA</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="date"></input></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/////////////////////////////////////////////////VENTANA DE Accidentes ////////////////////////////////////////////////////////////////////-->
                <div v-if="tipoTablas == 'Accidentes'">
                    <div class="col-12 d-flex   ">
                        <div class="scroll" style=" max-height: 500px;">
                            <table class="  text-center ms-3 me-5">
                                <thead class="sticky-top">
                                    <tr>
                                        <th class="border border-dark" style="font-size: 13px;">
                                            Dia
                                        </th>
                                        <th class="border border-dark" style="font-size: 13spx;">
                                            Accidentes
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="i in 31">
                                        <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                            {{i}}
                                        </td>
                                        <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; ">
                                            <input class="text-center" type="number" style=" height: 20px; width: 60px; font-size: 13px; background-color: #B7DEE8; ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark" style="font-size: 13px; height: 20px; width: 60px;">

                                        </td>
                                        <td class=" border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                            SUMA
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--////////////////////////////////////////////////////////////////// INICIA TABLA PARA GRAFICA -->
                        <table>
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white; font-size: 14px;">Grafica de rechazos</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8; font-size: 12px;">Meta: #kg promedio diario</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4; font-size: 12px;">NOMBRE DE EQUIPO EAD</th>
                                </tr>
                                <td class="border border-dark" style="width: 40px; ">
                                    <div id="divCanvas" style="min-height: 30hv; min-width: 80vw; ">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" col-12">
                        <div class="d-flex col-4 offset-4 mt-2 ">
                            <table class=" text-center table table-bordered ">
                                <thead>

                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="2" style="background-color: #002060; color: white;"><label>Responsable:</label>
                                            <input class="input-container ms-2" type="text" style="width: 300px;"></input>
                                        </th>
                                        <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                            <select class="ms-2">
                                                <option v-for="mes in meses">
                                                    {{mes}}
                                                </option>
                                            </select>
                                        </th>
                                    </tr>
                                    <tr style="background-color: #002060; color: white;">
                                        <th>Accidente</th>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/////////////////////////////////////////////////VENTANA DE ACTOS INSEGUROS ////////////////////////////////////////////////////////////////////-->
                <div v-if="tipoTablas == 'Actos inseguros'">
                    <div class="col-12 d-flex   ">
                        <div class="scroll" style=" max-height: 500px;">
                            <table class="  text-center ms-3 me-5">
                                <thead class="sticky-top">
                                    <tr>
                                        <th class="border border-dark" style="font-size: 13px;">
                                            Dia
                                        </th>
                                        <th class="border border-dark" style="font-size: 13spx;">
                                            Accidentes
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="i in 31">
                                        <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                            {{i}}
                                        </td>
                                        <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; ">
                                            <input class="text-center" type="number" style=" height: 20px; width: 60px; font-size: 13px; background-color: #B7DEE8; ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark" style="font-size: 13px; height: 20px; width: 60px;">

                                        </td>
                                        <td class=" border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                            SUMA
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--////////////////////////////////////////////////////////////////// INICIA TABLA PARA GRAFICA -->
                        <table>
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white; font-size: 14px;">Grafica de rechazos</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8; font-size: 12px;">Meta: #kg promedio diario</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4; font-size: 12px;">NOMBRE DE EQUIPO EAD</th>
                                </tr>
                                <td class="border border-dark" style="width: 40px; ">
                                    <div id="divCanvas" style="min-height: 30hv; min-width: 80vw; ">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" col-12">
                        <div class="d-flex col-4 offset-4 mt-2 ">
                            <table class=" text-center table table-bordered ">
                                <thead>

                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="2" style="background-color: #002060; color: white;"><label>Responsable:</label>
                                            <input class="input-container ms-2" type="text" style="width: 300px;"></input>
                                        </th>
                                        <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                            <select class="ms-2">
                                                <option v-for="mes in meses">
                                                    {{mes}}
                                                </option>
                                            </select>
                                        </th>
                                    </tr>
                                    <tr style="background-color: #002060; color: white;">
                                        <th>Acto inseguro</th>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></td>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/////////////////////////////////////////////////VENTANA DE AUSENTISMO ////////////////////////////////////////////////////////////////////-->
                <div v-if="tipoTablas == 'Ausentismo'">
                    <div class="col-12 d-flex   ">
                        <div class="scroll" style=" max-height: 500px;">
                            <table class="  text-center ms-3 me-5">
                                <thead class="sticky-top">
                                    <tr>
                                        <th class="border border-dark" style="font-size: 13px;">
                                            Dia
                                        </th>
                                        <th class="border border-dark" style="font-size: 13spx;">
                                            Ausentismo
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="i in 31">
                                        <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                            {{i}}
                                        </td>
                                        <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; ">
                                            <input class="text-center" type="number" style=" height: 20px; width: 60px; font-size: 13px; background-color: #B7DEE8; ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark" style="font-size: 13px; height: 20px; width: 60px;">

                                        </td>
                                        <td class=" border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                            SUMA
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--////////////////////////////////////////////////////////////////// INICIA TABLA PARA GRAFICA -->
                        <table>
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white; font-size: 14px;">Grafica de rechazos</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8; font-size: 12px;">Meta: #kg promedio diario</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4; font-size: 12px;">NOMBRE DE EQUIPO EAD</th>
                                </tr>
                                <td class="border border-dark" style="width: 40px; ">
                                    <div id="divCanvas" style="min-height: 30hv; min-width: 80vw; ">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" col-12">
                        <div class="d-flex col-4 offset-4 mt-2 ">
                            <table class=" text-center table table-bordered ">
                                <thead>

                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="background-color: #002060; color: white;"><label>Responsable:</label>
                                            <input class="input-container ms-2" type="text" style="width: 300px;"></input>
                                        </th>
                                        <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                            <select class="ms-2">
                                                <option v-for="mes in meses">
                                                    {{mes}}
                                                </option>
                                            </select>
                                        </th>
                                    </tr>
                                    <tr style="background-color: #002060; color: white;">
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 250px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/////////////////////////////////////////////////VENTANA DE CUMPLIMIENTO DE PROYECTO ////////////////////////////////////////////////////////////////////-->
                <div v-if="tipoTablas == 'Cumplimiento del proyecto'">
                    <div class="col-12 d-flex   ">
                        <div style=" max-height: 500px;">
                            <table class="  text-center ms-3 me-5">
                                <thead>
                                    <tr>
                                        <th class="border border-dark" style="font-size: 13px;">
                                            Dia
                                        </th>
                                        <th class="border border-dark" style="font-size: 13spx;">
                                            Faltas
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="i in 4">
                                        <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                            {{i}}
                                        </td>
                                        <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; ">
                                            <input class="text-center" type="number" style=" height: 20px; width: 60px; font-size: 13px; background-color: #B7DEE8; ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border border-dark" style="font-size: 13px; height: 20px; width: 60px;">

                                        </td>
                                        <td class=" border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                            SUMA
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--////////////////////////////////////////////////////////////////// INICIA TABLA PARA GRAFICA -->
                        <table>
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white; font-size: 14px;">Grafica de rechazos</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8; font-size: 12px;">Meta: #kg promedio diario</th>
                                </tr>
                                <tr>
                                    <th class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4; font-size: 12px;">NOMBRE DE EQUIPO EAD</th>
                                </tr>
                                <td class="border border-dark" style="width: 40px; ">
                                    <div id="divCanvas" style="min-height: 30hv; min-width: 80vw; ">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" col-12">
                        <div class="d-flex col-4 offset-4 mt-2 ">
                            <table class=" text-center table table-bordered ">
                                <thead>

                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="background-color: #002060; color: white;"><label>Responsable:</label>
                                            <input class="input-container ms-2" type="text" style="width: 300px;"></input>
                                        </th>
                                        <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                            <select class="ms-2">
                                                <option v-for="mes in meses">
                                                    {{mes}}
                                                </option>
                                            </select>
                                        </th>
                                    </tr>
                                    <tr style="background-color: #002060; color: white;">
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 250px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" style="width: 350px;"></input></td>
                                        <td><input type="date"></input></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/////////////////////////////////////////////////COMPETENCIA AREA ////////////////////////////////////////////////////////////////////-->
            <div v-if="ventana=='CompetenciaArea'">
                            <div class=" row col-12 text-center d-flex justify-content-center mt-2 ">
                                <div class="col-4">
                                    <span class="mx-2">Seleccione Foro: </span>
                                    <select>
                                        <option disabled default selected value="">Seleccione...</option>
                                        <option >Foro1</option>
                                        <option >Foro2</option>
                                        <option >Foro3</option>
                                    </select>
                                </div>
                            </div>
                <div class="col-12 mt-3">
                    <div class="col-4 offset-4">
                        <div class="imagenEngrane"></div>
                        <div class="border text-center">Ganador: </div>
                        <div class="border border-top-0 text-center">The Winner</div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="d-flex offset-3">
                        <div class="col-4 me-3">
                            <div class="imagenEngrane"></div>
                            <div class="border  text-center">Equipo 1 </div>
                            <div class=" border border-top-0 text-center">Nombre del Equipo</div>
                        </div>
                        <div class="col-4">
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
            <div v-if="ventana == 'CompetenciaPlanta'">
                <div class="col-12 d-flex justify-content-center">
                        <table class="table table-bordered table-striped mt-5">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>EADs</th>
                                                        <th>Área</th>
                                                        <th>Planta</th>
                                                        <th>Nombre EAD</th>
                                                        <th>Proyecto</th>
                                                        <th>Evaluador 1</th>
                                                        <th>Evaluador 2</th>
                                                        <th>Evaluador 3</th>
                                                        <th>Evaluador 4</th>
                                                        <th>Calificacion Final</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th><b>1</b></th>
                                                        <td><b>EAD 1</b></td>
                                                        <td>Formación</td>
                                                        <td>Enerya</td>
                                                        <td>Los Rinos</td>
                                                        <td>Proyecto A</td>
                                                        <td><b>Evaluador A</b></td>
                                                        <td><b>Evaluador B</b></td>
                                                        <td><b>Evaluador C</b></td>
                                                        <td><b>Evaluador D</b></td>
                                                        <td>Pendiente</td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>2</b></th>
                                                        <td><b>EAD 2</b></td>
                                                        <td>Etiquetado</td>
                                                        <td>Riasa</td>
                                                        <td>Las Maquinas</td>
                                                        <td>Proyecto A</td>
                                                        <td><b>Evaluador A</b></td>
                                                        <td><b>Evaluador B</b></td>
                                                        <td><b>Evaluador C</b></td>
                                                        <td><b>Evaluador D</b></td>
                                                        <td>Pendiente</td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>3</b></th>
                                                        <td><b>EAD 3</b></td>
                                                        <td>Riasa - Enerya</td>
                                                        <td>Planta A</td>
                                                        <td>Los Pajaros Azules</td>
                                                        <td>Proyecto A</td>
                                                        <td><b>Evaluador A</b></td>
                                                        <td><b>Evaluador B</b></td>
                                                        <td><b>Evaluador C</b></td>
                                                        <td><b>Evaluador D</b></td>
                                                        <td>Pendiente</td>
                                                    </tr>
                                                    <!-- Repite las filas para EAD 2 al 14 según sea necesario  -->
                                                </tbody>
                                            </table>        
                    </div>       
            </div>
            <!-- FIN DE COMPETENCIA PLANTA -->


            <!--/////////////////////////////////CONFIGURACION DE COMPETENCIA AREA ////////////////////////////////////////////////////////////////////////////////////////-->
            <div v-if="ventana == 'CrearCompetenciaArea'">
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
                                <span class="input-group-text " style="border-radius: 10px 0px 0px 10px; border-color: rgb(184, 14, 14);">Area: </span>
                                <select class="form-control select" style="border-radius: 0px 10px 10px 0px; border-color: rgb(184, 14, 14);">
                                    <option v-for="i in 3">Área {{i}}
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
                                            <button class="btn btn-warning btn-actualizar">
                                                Actualizar
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-eliminar">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--/////////////////////////////////////////////// MODAL VSUALIZAR FORO //////////////////// -->
                            <div class="modal modal-xl" id="exampleModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Visualizacion de competencias en </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>EADs</th>
                                                        <th>Área</th>
                                                        <th>Planta</th>
                                                        <th>Nombre EAD</th>
                                                        <th>Proyecto</th>
                                                        <th>Evaluador 1</th>
                                                        <th>Evaluador 2</th>
                                                        <th>Evaluador 3</th>
                                                        <th>Evaluador 4</th>
                                                        <th>Calificacion Final</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th><b>1</b></th>
                                                        <td><b>EAD 1</b></td>
                                                        <td>Formación</td>
                                                        <td>Enerya</td>
                                                        <td>Los Rinos</td>
                                                        <td>Proyecto A</td>
                                                        <td><b>Evaluador A</b></td>
                                                        <td><b>Evaluador B</b></td>
                                                        <td><b>Evaluador C</b></td>
                                                        <td><b>Evaluador D</b></td>
                                                        <td>Pendiente</td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>2</b></th>
                                                        <td><b>EAD 2</b></td>
                                                        <td>Etiquetado</td>
                                                        <td>Riasa</td>
                                                        <td>Las Maquinas</td>
                                                        <td>Proyecto A</td>
                                                        <td><b>Evaluador A</b></td>
                                                        <td><b>Evaluador B</b></td>
                                                        <td><b>Evaluador C</b></td>
                                                        <td><b>Evaluador D</b></td>
                                                        <td>Pendiente</td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>3</b></th>
                                                        <td><b>EAD 3</b></td>
                                                        <td>Riasa - Enerya</td>
                                                        <td>Planta A</td>
                                                        <td>Los Pajaros Azules</td>
                                                        <td>Proyecto A</td>
                                                        <td><b>Evaluador A</b></td>
                                                        <td><b>Evaluador B</b></td>
                                                        <td><b>Evaluador C</b></td>
                                                        <td><b>Evaluador D</b></td>
                                                        <td>Pendiente</td>
                                                    </tr>
                                                    <!-- Repite las filas para EAD 2 al 14 según sea necesario  -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- ////////////////////////////////////////////////////////////////CREAR COMPETENCIA DE PLANTA ///////////////////////////////////////////// -->
            <div v-if="ventana == 'CrearCompetenciaPlanta'">
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
                                            <button class="btn btn-warning btn-actualizar">
                                                Actualizar
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-eliminar">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--/////////////////////////////////////////////// MODAL VSUALIZAR FORO //////////////////// -->
                        <div class="modal modal-xl" id="exampleModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Visualizacion de competencias en </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>EADs</th>
                                                    <th>Área</th>
                                                    <th>Planta</th>
                                                    <th>Nombre EAD</th>
                                                    <th>Proyecto</th>
                                                    <th>Evaluador 1</th>
                                                    <th>Evaluador 2</th>
                                                    <th>Evaluador 3</th>
                                                    <th>Evaluador 4</th>
                                                    <th>Calificacion Final</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th><b>1</b></th>
                                                    <td><b>EAD 1</b></td>
                                                    <td>Formación</td>
                                                    <td>Enerya</td>
                                                    <td>Los Rinos</td>
                                                    <td>Proyecto A</td>
                                                    <td><b>Evaluador A</b></td>
                                                    <td><b>Evaluador B</b></td>
                                                    <td><b>Evaluador C</b></td>
                                                    <td><b>Evaluador D</b></td>
                                                    <td>Pendiente</td>
                                                </tr>
                                                <tr>
                                                    <th><b>2</b></th>
                                                    <td><b>EAD 2</b></td>
                                                    <td>Etiquetado</td>
                                                    <td>Riasa</td>
                                                    <td>Las Maquinas</td>
                                                    <td>Proyecto A</td>
                                                    <td><b>Evaluador A</b></td>
                                                    <td><b>Evaluador B</b></td>
                                                    <td><b>Evaluador C</b></td>
                                                    <td><b>Evaluador D</b></td>
                                                    <td>Pendiente</td>
                                                </tr>
                                                <tr>
                                                    <th><b>3</b></th>
                                                    <td><b>EAD 3</b></td>
                                                    <td>Riasa - Enerya</td>
                                                    <td>Planta A</td>
                                                    <td>Los Pajaros Azules</td>
                                                    <td>Proyecto A</td>
                                                    <td><b>Evaluador A</b></td>
                                                    <td><b>Evaluador B</b></td>
                                                    <td><b>Evaluador C</b></td>
                                                    <td><b>Evaluador D</b></td>
                                                    <td>Pendiente</td>
                                                </tr>
                                                <!-- Repite las filas para EAD 2 al 14 según sea necesario  -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    header("Location:index.php");
} ?>