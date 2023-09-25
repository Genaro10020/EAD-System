
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
                                <div class="col-12 col-sm-4  col-lg-3 col-xl-3 col-xxl-2 ">
                                    <button class="btn_menu" @click="ventanas('usuarios'), accion='insertar'"><b>USUARIOS</b></button>
                                </div>
                                <div class="col-12 col-sm-4   col-lg-4  col-xl-3 col-xxl-3">
                                    <button class="btn_menu" @click="ventanas('departamentos')"><b>DEPARTAMENTOS</b></button>
                                </div>
                                <div class="col-12 col-sm-4 col-lg-3  col-xl-3 col-xxl-2">
                                    <button class="btn_menu"><b>OTROS</b></button>
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
                                                                                                    <label  class=" label-session ">Subárea</label>
                                                                                                    <select v-model="selector_subarea" class="form-control select">
                                                                                                        <option disabled default selected value="">Seleccione SubÁrea..</option>
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
                                                                                                        <th scope="col">Subárea</th>
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
                            <div v-if="ventana=='departamentos'" class="row"> <!--bloque USUARIO--> 
                                   
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
                                                            <button class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="datosModal('Área','Nueva')">Área</button>
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
                                                            <button class="botones-crear  rounded-pill border-0 my-1 px-2 mb-2" @click="datosModal('Subárea','Nueva')">Subárea</button>
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
                                                                            <h5 class="modal-title">{{accion}} {{departamento}}</h5>
                                                                            <button type="button" class="btn-close" @click="cerrarModal()" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center d-flex justify-content-center">
                                                                            <label class="me-1 my-auto">Nombre: </label><input class="form-control w-50" type="text" v-model="nuevo_departamento"></input>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary py-1" @click="cerrarModal()">Salir</button>
                                                                            <button v-if="accion=='Actualizar'" type="button" class="btn btn-warning py-1" @click="actualizarDepartamento()">Actualizar</button>
                                                                            <button v-else type="button" class="btn btn-primary py-1" @click="nuevoDepartamento()">Guardar</button>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <!--FinModalDeDepartamento-->
                            </div><!--FIN BLOQUE USUARIOS-->        
         </div>           
        <script src="js/header.js"></script>
        <script src="js/panel.js"></script>
     
</body>
</html>

<?php
}else{
header("Location:index.php");
}?>
