
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
                                    <button class="btn_menu" @click="ventanas('usuarios')"><b>USUARIOS</b></button>
                                </div>
                                <div class="col-12 col-sm-3   col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu" @click="ventanas('departamentos')"><b>DEPARTAMENTOS</b></button>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-2  col-xl-2 col-xxl-2">
                                    <button class="btn_menu"  @click="ventanas('score'), consultarScoreCard(),consultarObjetivos()" ><b>SCORECARD</b></button>
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
                                                    <div class="mb-5" v-for="(scoreArray, fechaArreglo) in scorecard" :key="fechaArreglo">

                                                            <label class="d-flex justify-content-center mt-3 mb-3">{{ scoreArray[0].titulo }} ({{scoreArray[0].mes_anio}})</label>
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
                                                            </table>
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
                            <div v-if="ventana=='Graficas'" class="row" > <!--bloque CREAR EAD--> 
                             <!--///////////////////////////////////////--> 
                                <div class="w-25">
                                 <button type="button" class="btn btn-light">Reclamos +</button>
                                </div>
                                <div class="w-25">
                                 <button type="button" class="btn btn-light">Merma +</button>
                                </div>
                                <div class="w-25">
                                 <button type="button" class="btn btn-light">Accidentes -</button>
                                </div>
                                <div class="w-25"   >
                                 <button type="button" class="btn btn-light">Actos inseguros +</button>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-center">
                                        <h1>Accidentes</h1>
                                    </div>
                                <table class="table table-bordered">
                                    <thead>
                                       
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="row">15</th>
                                        <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        
                                        </tr>
                                        <tr>
                                        <th scope="row">14</th>
                                        <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        
                                        </tr>
                                        <tr>
                                        <th scope="row">13</th>
                                        <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                       
                                        </tr>
                                        <tr>
                                            <th scope="row">12</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">11</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">10</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">9</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">8</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">7</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">6</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </<tr>
                                        <tr class="table-primary">
                                            <th scope="row">DIA</th>
                                            <td >1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>9</td>
                                            <td>10</td>
                                            <td>11</td>
                                            <td>12</td>
                                            <td>13</td>
                                            <td>14</td>
                                            <td>15</td>
                                        </<tr>

                                    </tbody>
                                    </table>
                                </div>


                             

                             <!--///////////////////////////////////////--> 
                            </div>
         </div>           
        <script src="js/header.js"></script>
        <script src="js/panel.js"></script>
     
</body>
</html>

<?php
}else{
header("Location:index.php");
}?>
