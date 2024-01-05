
<?php session_start(); 
if(isset($_SESSION['nombre'])){
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
                
                <div id="app"  class="col-12" style="min-height: 80vh;">
                        <div class="cintilla row d-flex justify-content-center align-items-center p-1 text-center my-2">
                                <div class="col-12 col-sm-3  col-lg-2 col-xl-2 col-xxl-2 ">
                                    <button class="btn_menu" @click="ventanas('usuarios')"><b>Usuarios</b></button>
                                </div>
                                <div class="col-12 col-sm-3   col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu" @click="ventanas('departamentos')"><b>departamentos</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('score'), consultarScoreCard(),consultarObjetivos()" ><b>Scorecard</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('crearEAD'), consultarColaboradores()" ><b>CREAR EAD</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('equiposEAD')" ><b>EQUIPOS EAD</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('Graficas')" ><b>GRAFICAS</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2 mt-sm-0 mt-lg-2">
                                    <button class="btn_menu"  @click="ventanas('CompetenciaArea')" ><b>Competencia de area</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2 mt-sm-0 mt-lg-2">
                                    <button class="btn_menu"  @click="ventanas('CompetenciaPlanta')" ><b>Competencia de Planta</b></button>
                                </div>
                        </div>     
                                <div  v-if="ventana=='usuarios'" class="row"> <!--bloque USUARIO-->  
                                       
                                                                                <div class="seccion1 col-12  col-lg-4">    
                                                                                    
                                                                                    <div  class="formulario col-12 mx-auto col-sm-112 col-lg-10  col-xl-8 col-xxl-6  pt-4 ps-2 pe-2 ps-lg-3  pe-lg-3  rounded shadow-sm">
                                                                                            <h6 class="text-center label-session "><b>{{titulo_formulario_usuarios}}</b></h6>
                                                                                            <form @submit.prevent="nuevoActualizarUsuario" action="procesar_login.php" method="POST">
                                                                                                <div class="mb-1">
                                                                                                    <label  class=" label-session">Nombre</label>
                                                                                                    <input type="text" class="form-control"  v-model="nombre" required>
                                                                                                </div>

                                                                                                <div class="mb-1">
                                                                                                    <label  class=" label-session ">Nómina (Usuario)</label>
                                                                                                    <input type="text" class="form-control"  v-model="nomina" required>
                                                                                                </div>
                                                                                                <div class="mb-1">
                                                                                                    <label  class=" label-session ">Contraseña:</label>
                                                                                                    <input type="text" class="form-control"  v-model="contrasena" required>
                                                                                                </div>
                                                                                                <div class="mb-1">
                                                                                                    <label  class="label-session">Planta</label>
                                                                                                    <select v-model="selector_planta" class="form-control select">
                                                                                                        <option disabled default selected value="">Seleccione Planta..</option>
                                                                                                        <option v-for = "planta in plantas" :value="planta.nombre" >{{planta.nombre}}</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="mb-1">
                                                                                                    <label  class="label-session ">Área</label>
                                                                                                    <select v-model="selector_area" class="form-control select">
                                                                                                        <option disabled default selected value="">Seleccione Área..</option>
                                                                                                        <option v-for = "area in areas" :value="area.nombre" >{{area.nombre}}</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="mb-1">
                                                                                                    <label  class=" label-session ">Procesos</label>
                                                                                                    <select v-model="selector_subarea" class="form-control select">
                                                                                                        <option disabled default selected value="">Seleccione Proceso.</option>
                                                                                                        <option v-for = "subarea in subareas" :value="subarea.nombre" >{{subarea.nombre}}</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="mb-1">
                                                                                                    <label  class=" label-session ">Tipo Usuario</label>
                                                                                                    <select v-model="selector_tipo_usuario" class="form-control select">
                                                                                                        <option disabled default selected value="">Seleccione Tipo..</option>
                                                                                                        <option v-for = "tipo in tipos" :value="tipo" >{{tipo}}</option>
                                                                                                        <option class="text-success" @click="datosModalTipoUsuario()">Nuevo / Eliminar</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="mb-1">
                                                                                                    <label  class=" label-session ">Accesos</label>
                                                                                                    <select v-model="selector_tipo_acceso" class="form-control select">
                                                                                                        <option disabled default selected value="">Seleccione Acceso..</option>
                                                                                                        <option v-for = "acceso in tipo_accesos" :value="acceso" >{{acceso}}</option>
                                                                                                    </select>
                                                                                                </div>

                                                                                                <div class="text-center mt-3 mb-3 d-flex justify-content-evenly">
                                                                                                    <button class="btn" :class="bandera_alta_o_actualizar== 1 ? 'btn-danger':'btn-warning'" type="submit">{{texto_btn_submit}}</button>
                                                                                                    <button v-if="bandera_alta_o_actualizar== 2" class="btn btn-secondary" type="button" @click ="actualizarUsuario('insertar')">Cancelar</button>
                                                                                                </div>
                                                                                               
                                                                                            </form>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="seccion2 col-12   col-lg-8 ">    
                                                                                    <div class="scroll col-12">
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
                                                                                                        <tr  v-for="(usuario, index) in usuarios">
                                                                                                            <th scope="row">{{index+1}}</th>
                                                                                                            <td>{{usuario.nombre}}</td>
                                                                                                            <td class="text-center">{{usuario.nomina}}</td>
                                                                                                            <td class="text-center">{{usuario.contrasena}}</td>
                                                                                                            <td class="text-center">{{usuario.planta}}</td>
                                                                                                            <td>{{usuario.area}}</td>
                                                                                                            <td >{{usuario.subarea}}</td>
                                                                                                            <td class="text-center">{{usuario.tipo_usuario}}</td>
                                                                                                            <td class="text-center">{{usuario.tipo_acceso}}</td>
                                                                                                            <td class="text-center"><button v-if="bandera_alta_o_actualizar == 1" class="btn btn-warning btn-actualizar px-2 py-0" @click ="actualizarUsuario('actualizar',usuario.id)">Actualizar</button></td>
                                                                                                            <td class="text-center"><button v-if="usuario.tipo_acceso=='Usuario' && bandera_alta_o_actualizar == 1"  class="btn btn-danger btn-eliminar px-2 py-0" @click="eliminarUsuario(usuario.id)">Eliminar</button></td>
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
                                                                        <div class="p-2" >
                                                                                    <table class="table">
                                                                                        <thead>
                                                                                            <tr>
                                                                                            <th scope="col">Tipo Usuarios</th>
                                                                                            <!--<th scope="col">Actualizar</th>-->
                                                                                            <th scope="col">Eliminar</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr v-for = "(tipo, index) in tipos" :key="index">
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
                            <div v-if="ventana=='departamentos'" class="row"> <!--bloque DEPARTAMENTO--> 
                                   
                                            <div class="col-12 col-lg-4 flex-colum  align-items-center text-center">
                                                        <div class="cinta-tablas px-2 rounded-top ">
                                                            <button class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2"  @click="datosModal('Planta','Nueva')">Crear Planta</button>
                                                        </div> 
                                                        <div class="scroll w-100 ">
                                                                            <table class="table  table-bordered border-dark ">
                                                                                <thead class=" border-dark">
                                                                                    <tr >
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
                                                                                        <td><button  class="btn btn-warning btn-actualizar px-2 py-0" @click ="datosModal('Planta','Actualizar',planta.id,planta.nombre)">Actualizar</button></td>
                                                                                        <td><button  class="btn btn-danger btn-eliminar px-2 py-0 " @click="eliminarDepartamento('Planta',planta.id)">Eliminar</button></td>
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
                                                                                    <td><button class="btn btn-warning btn-actualizar px-2 py-0" @click ="datosModal('Área','Actualizar',area.id,area.nombre)">Actualizar</button></td>
                                                                                    <td><button   class="btn btn-danger btn-eliminar px-2 py-0" @click="eliminarDepartamento('Área',area.id)">Eliminar</button></td>
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
                                                                                    <td><button class="btn btn-warning btn-actualizar px-2 py-0" @click ="datosModal('Subárea','Actualizar',subarea.id,subarea.nombre)">Actualizar</button></td>
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
                                                                        <span class="mx-2">Supervisor:</span>
                                                                        <select>
                                                                            <option disabled default selected value="">Seleccione...</option>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                            <table style="max-width:800px" class=" mt-3 table table-bordered mx-2 mb-5 table  table-bordered border-dark text-center">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="bg-dark"> </th>
                                                                        <th  scope="row" class="bg-dark" v-for="columnas in columnasSC">{{columnas}}</th>
                                                                    </tr>
                                                                <tbody>
                                                                    <tr v-for="filas in filasSC">
                                                                        <th scope="col">{{filas}}</th>
                                                                        <td v-for="columnas in columnasSC"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="border border-end-0 border-top-0 border-white" colspan="4"></td>

                                                                        <td  class="border border-1 border-dark border-start-1">
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
                                                                            <button type="button" class="badge rounded-pill bg-secondary border border-0" @click="cerrarModal()" >X</button>
                                                                        </div>
                                                                            <div class="row modal-body  text-start text-sm-center d-flex justify-content-around">
                                                                                <div class=" mb-5 mb-sm-0  col-12 col-sm-4">
                                                                                    <label class="mx-2 my-auto">UGB: </label>
                                                                                    <input  type="text" v-model="ugb"></input>
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
                                                                                            <option v-for="anio in anios" :value="anio" >{{anio}}</option>
                                                                                    </select> 
                                                                                </div>
                                                                                <div class=" mb-5 mb-sm-0  col-12 col-sm-3">
                                                                                    <label class="mx-2 my-auto">Plantilla:</label>
                                                                                    <select v-model="select_plantillas">
                                                                                            <option v-for="plantilla in plantillas" :value="plantilla" >{{plantilla}}</option>
                                                                                    </select> 
                                                                                </div>
                                                                            </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary py-1" @click="cerrarModal()">Salir</button>
                                                                            <!--<button v-if="accion_departamento=='Actualizar'" type="button" class="btn btn-warning py-1" @click="actualizarDepartamento()">Actualizar</button>-->
                                                                            <button  type="button" class="btn btn-primary py-1" @click="crearScoreCard()">Guardar</button>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                </div>
                                                <!--FinModalDeDepartamento-->
                            </div> <!--FIN SCORECARD-->
                            <div v-if="ventana=='crearEAD'" class="row" > <!--bloque CREAR EAD--> 
                                    <div class="col-12 col-lg-6  col-xl-5 contenido d-flex justify-content-center align-items-center" >
                                            <div class="row contenido-form  border border-5 shadow-lg text-center">
                                                <div><!--agrupando todos los campos-->
                                                    <div class="col-12 mt-3"> <!--nombre del equipo-->
                                                        <div>
                                                            <span>Nombre del equipo</span>
                                                        </div>
                                                        <div>
                                                          <input v-model="select_nombre" type="text" class="input-nombreEAD w-75"></input>
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
                                                            <select v-model="select_area"  class="form-control select" aria-label="With textarea">
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
                                                    <div class="col-12 text-center mt-4 mb-2">
                                                        <button class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="crearEAD()">Crear EAD</button>
                                                    </div>
                                                </div>


                                            </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-7"><!--Colaboradores-->
                                    <span class=" badge text-light bg-secondary mb-2">Selecciona los colaboradores</span>
                                            <div class="scroll w-100">
                                                <div class="form-check" v-for="colaborador in colaboradores" style="font-size:0.7em;">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{colaborador.colaborador}}
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                            <div v-if="ventana=='equiposEAD'" class="row" > <!--bloque CREAR EAD--> 
                             <!--///////////////////////////////////////--> 
                             
                             <table  class="mx-2 mb-5 table table-hover border-dark text-center">
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
                            <div class=" row d-flex justify-content-center align-items-center p-1 text-center my-2">
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
                            </div>

                            <!--/////////////////////////////////////////////////////////////////INICIA RECHAZOS -->
                            <div v-if="grafica == 'Rechazos'">
                               
                                <!--/////////////////////////////////////////////////////////////// INICIO TABLA PARA INGRESAR DATOS  -->
                                <div class="col-12 d-flex   ">
                                <div class="scroll" style=" max-height: 500px;">
                                        <table class="  text-center ms-3 me-5">
                                            <thead class="sticky-top">
                                                <tr>
                                                    <th class="border border-dark" style="font-size: 13px;">
                                                        Dia
                                                    </th>
                                                    <th class="border border-dark" style="font-size: 13spx;">
                                                        Rechazos
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr  v-for="i in 31">
                                                    <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                                        {{i}}
                                                    </td>
                                                    <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; " >
                                                        <input class="text-center" type="number" style=" height: 20px; width: 60px; font-size: 13px; background-color: #B7DEE8; ">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border border-dark" style="font-size: 13px; height: 20px; width: 60px;">
                                                        
                                                    </td>
                                                    <td class="border border-dark" style="background-color: #FFFF00; font-size: 13px; height: 20px; width: 60px;">
                                                        SUMA
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--////////////////////////////////////////////////////////////////// INICIA TABLA PARA GRAFICA -->
                                    <table >
                                        <thead>
                                       
                                        </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white;">Grafica de rechazos</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8;">Meta: # de rechazos en el mes</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4;">NOMBRE DE EQUIPO EAD</th>
                                                </tr>
                                                <tr class="text-center" v-for="numero1 in numerosTablas">
                                                    <th class="border border-dark" style=" width: 55px;">
                                                        {{ numero1 }}
                                                    </th>
                                                    <td class="border border-dark"  v-for="numero2 in 31"  style=" width: 40px;">
                                                        <span v-if="numero1 === 'DIA'">
                                                            {{ numero2 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class=" col-12 mt-2" >
                                        <div class="col-2 offset-2 text-center border " style="background-color: #002060; color: white; width: 1007px; font-size: 18px;">
                                            rechazos
                                        </div>
                                        <div class="d-flex ">
                                            <div class="col-2 offset-2 d-flex border"style="background-color: #002060; color: white; width: 503px; font-size: 18px;">
                                                <a>Mes:</a>
                                                <select>
                                                    <option v-for="mes in meses">
                                                        {{mes}}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="border" style="background-color: #002060; color: white; width: 504px; font-size: 18px;">
                                                Responsable:
                                            </div>
                                        </div>
                                        <div class="col-2 offset-2 d-flex">
                                            <table class=" text-center table table-bordered " v-for="n in numerosTablas2">
                                                <thead>
                                                    
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th style="background-color: #002060; color: white;">Rechazo</th>
                                                        <th style="background-color: #002060; color: white;">Fecha</th>
                                                        <th style="background-color: #002060; color: white;">Operador</th>
                                                    </tr>
                                                    <tr>
                                                        <td><input style="max-width:200px"></input></td>
                                                        <td><input type="date"></input></td>
                                                        <td><input style="max-width:200px"></input></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input style="max-width:200px"></input></td>
                                                        <td><input type="date"></input></td>
                                                        <td><input style="max-width:200px"></input></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input style="max-width:200px"></input></td>
                                                        <td><input type="date"></input></td>
                                                        <td><input style="max-width:200px"></input></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input style="max-width:200px"></input></td>
                                                        <td><input type="date"></input></td>
                                                        <td><input style="max-width:200px"></input></td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <!--/////////////////////////////////////////////////VENTANA DE MERMA////////////////////////////////////////////////////////////////////-->
                            <div v-if="grafica == 'Merma'" class="row">
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
                                            <tr  v-for="i in 31">
                                                <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                                    {{i}}
                                                </td>
                                                <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; " >
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
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white;">Grafica de merma</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8;">Meta: #kg promedio diario</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4;">NOMBRE DE EQUIPO EAD</th>
                                                </tr>
                                                <tr class="text-center" v-for="numero1 in numerosTablas3">
                                                    <th class="border border-dark" style="width: 60px; ">
                                                        {{ numero1 }}
                                                    </th>
                                                    <td class="border border-dark" style="width: 40px; " v-for="numero2 in 31">
                                                        <span v-if="numero1 === 'DIA'">
                                                            {{ numero2 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex col-4 offset-4 mt-2" >
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
                                                        </select></th>
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
                            <div v-if="grafica == 'Eficiencia'">
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
                                                <tr  v-for="i in 31">
                                                    <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                                        {{i}}
                                                    </td>
                                                    <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; " >
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
                                    <table >
                                        <thead>
                                       
                                        </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white;">Grafica de eficiencia</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8;">Meta: #% promedio de eficiencia</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4;">NOMBRE DE EQUIPO EAD</th>
                                                </tr>
                                                <tr class="text-center" v-for="numero1 in nuneroTablasEficiencia">
                                                    <th class="border border-dark" style=" width: 55px;">
                                                        {{ numero1 }}
                                                    </th>
                                                    <td class="border border-dark"  v-for="numero2 in 31"  style=" width: 40px;">
                                                        <span v-if="numero1 === 'DIA'">
                                                            {{ numero2 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class=" col-12" >
                                        <div class="d-flex col-4 offset-4 mt-2 " >
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
                                                        </select></th>
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
                            <div v-if="grafica == 'Accidentes'">
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
                                                <tr  v-for="i in 31">
                                                    <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                                        {{i}}
                                                    </td>
                                                    <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; " >
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
                                    <table >
                                        <thead>
                                       
                                        </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white;">Grafica de accidentess</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8;">Meta: # accidentes en el mes</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4;">NOMBRE DE EQUIPO EAD</th>
                                                </tr>
                                                <tr class="text-center" v-for="numero1 in numeroTablasAccidentes">
                                                    <th class="border border-dark" style=" width: 60px;">
                                                        {{ numero1 }}
                                                    </th>
                                                    <td class="border border-dark"  v-for="numero2 in 31" style=" width: 60px;" >
                                                        <span v-if="numero1 === 'DIA'">
                                                            {{ numero2 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class=" col-12" >
                                        <div class="d-flex col-4 offset-4 mt-2 " >
                                        <table class=" text-center table table-bordered ">
                                            <thead>

                                            </thead>
                                            <tbody>
                                                 <tr>
                                                    <th colspan="2" style="background-color: #002060; color: white;"><label>Responsable:</label>
                                                        <input class="input-container ms-2" type="text"  style="width: 300px;"></input>
                                                    </th>
                                                    <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                                        <select class="ms-2">
                                                            <option v-for="mes in meses">
                                                                {{mes}}
                                                            </option>
                                                        </select></th>
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
                             <div v-if="grafica == 'Actos inseguros'">
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
                                                <tr  v-for="i in 31">
                                                    <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                                        {{i}}
                                                    </td>
                                                    <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; " >
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
                                    <table >
                                        <thead>
                                       
                                        </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white;">Grafica de actos inseguros</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8;">Meta: # actos inseguros en el mes</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4;">NOMBRE DE EQUIPO EAD</th>
                                                </tr>
                                                <tr class="text-center" v-for="numero1 in numeroTablasActosInseguros">
                                                    <th class="border border-dark" style=" width: 60px;">
                                                        {{ numero1 }}
                                                    </th>
                                                    <td class="border border-dark"  v-for="numero2 in 31" style=" width: 60px;" >
                                                        <span v-if="numero1 === 'DIA'">
                                                            {{ numero2 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class=" col-12" >
                                        <div class="d-flex col-4 offset-4 mt-2 " >
                                        <table class=" text-center table table-bordered ">
                                            <thead>

                                            </thead>
                                            <tbody>
                                                 <tr>
                                                    <th colspan="2" style="background-color: #002060; color: white;"><label>Responsable:</label>
                                                        <input class="input-container ms-2" type="text"  style="width: 300px;"></input>
                                                    </th>
                                                    <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                                        <select class="ms-2">
                                                            <option v-for="mes in meses">
                                                                {{mes}}
                                                            </option>
                                                        </select></th>
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
                             <div v-if="grafica == 'Ausentismo'">
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
                                                <tr  v-for="i in 31">
                                                    <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                                        {{i}}
                                                    </td>
                                                    <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; " >
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
                                    <table >
                                        <thead>
                                       
                                        </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white;">Grafica de ausentismos</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8;">Meta: # ausentismos en el mes</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4;">NOMBRE DE EQUIPO EAD</th>
                                                </tr>
                                                <tr class="text-center" v-for="numero1 in numeroTablasActosInseguros">
                                                    <th class="border border-dark" style=" width: 60px;">
                                                        {{ numero1 }}
                                                    </th>
                                                    <td class="border border-dark"  v-for="numero2 in 31" style=" width: 60px;" >
                                                        <span v-if="numero1 === 'DIA'">
                                                            {{ numero2 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class=" col-12" >
                                        <div class="d-flex col-4 offset-4 mt-2 " >
                                        <table class=" text-center table table-bordered ">
                                            <thead>

                                            </thead>
                                            <tbody>
                                                 <tr>
                                                    <th style="background-color: #002060; color: white;"><label>Responsable:</label>
                                                        <input class="input-container ms-2" type="text"  style="width: 300px;"></input>
                                                    </th>
                                                    <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                                        <select class="ms-2">
                                                            <option v-for="mes in meses">
                                                                {{mes}}
                                                            </option>
                                                        </select></th>
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
                             <div v-if="grafica == 'Cumplimiento del proyecto'">
                             <div class="col-12 d-flex   ">
                                <div  style=" max-height: 500px;">
                                        <table class="  text-center ms-3 me-5">
                                            <thead >
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
                                                <tr  v-for="i in 4">
                                                    <td class="border border-dark" style="  height: 20px; width: 40px; font-size: 13px;">
                                                        {{i}}
                                                    </td>
                                                    <td class="border border-dark" style="background-color: #B7DEE8; height: 20px; width: 40px; " >
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
                                    <table >
                                        <thead>
                                       
                                        </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #002060; color: white;">Grafica de cumplimiento de proyectos</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #B7DEE8;">Meta: # fallas a las reuniones EAD's</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="32" class=" text-center encabezadoGraficas border border-dark" style="background-color: #DDD9C4;">NOMBRE DE EQUIPO EAD</th>
                                                </tr>
                                                <tr class="text-center" v-for="numero1 in numeroTablasProyectos">
                                                    <th class="border border-dark" style=" width: 40px;">
                                                        {{ numero1 }}
                                                    </th>
                                                    <td class="border border-dark"  v-for="numero2 in 31" style=" width: 40px;" >
                                                        <span v-if="numero1 === 'DIA'">
                                                            {{ numero2 }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class=" col-12" >
                                        <div class="d-flex col-4 offset-4 mt-2 " >
                                        <table class=" text-center table table-bordered ">
                                            <thead>

                                            </thead>
                                            <tbody>
                                                 <tr>
                                                    <th style="background-color: #002060; color: white;"><label>Responsable:</label>
                                                        <input class="input-container ms-2" type="text"  style="width: 300px;"></input>
                                                    </th>
                                                    <th style="background-color: #002060; color: white;"><label>Mes:</label>
                                                        <select class="ms-2">
                                                            <option v-for="mes in meses">
                                                                {{mes}}
                                                            </option>
                                                        </select></th>
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
                    <div class="container mt-5">
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


                </div>
                   <!--/////////////////////////////////COMPETENCIA DE PLANTA////////////////////////////////////////////////////////////////////////////////////////-->
                <div v-if="ventana == 'CompetenciaPlanta'">
                    <table class="text-center table table.bordered border-dark">
                        <thead>
                            <tr>
                                <th  v-for="filas in filasCP">
                                    {{filas}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- FIN DE COMPETENCIA PLANTA -->
         </div>           
        <script src="js/header.js"></script>
        <script src="js/panel.js"></script>
     
</body>
</html>

<?php
}else{
header("Location:index.php");
}?>
