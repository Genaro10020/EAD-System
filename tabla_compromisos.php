<div class="d-flex col-12">
        <table class="text-center table table-bordered" style="font-size: 0.9em;">
            <thead>
            </thead>
            <tbody>
                <tr class="align-middle">
                    <th style="background-color: #002060; color: white;">
                    <button class="btn btn-success btn-boton ms-1 rounded rounded-circle" @click="nueva_causa=true" style="font-size: 0.8em;">+ </button>
                    </th>
                    <th style="background-color: #002060; color: white; font-size: 0.9em;" >
                    Responsable
                    </th>
                    <th style="background-color: #002060; color: white; font-size: 0.9em;">
                    Causa
                    </th>
                    <th style="background-color: #002060; color: white; font-size: 0.9em;">Fecha
                        <label> DD/MM/AA</label>
                    </th>
                </tr>
                <tr v-if="nueva_causa==true" class="align-middle"><!--Nuevo causas-->
                    <td>
                        <button class="btn btn-success btn-boton px-2 py-0 ms-3 my-1" @click="guardarCausa()" style="font-size: 0.8em;">
                            <i class="bi bi-floppy-fill"></i> Guardar 
                        </button>
                        <button class="btn btn-danger btn-boton px-2 py-0 ms-3 my-1" @click="nueva_causa=false" style="font-size: 0.8em;">
                            <i class="bi bi-sign-stop-fill"></i> Cancelar 
                        </button>
                    </td>
                    <td>
                        <input v-model="responsable_causa" type="text" class="w-100"/>
                    </td>
                    <td>
                        <input v-model="causa" type="text"  class="w-100"/>
                    </td>
                    <td>
                        <select v-model="dia_grafica">
                            <option v-for="dia in diasDelMesAnio()" :value="dia">{{dia}}/{{mes_grafica}}/{{anio_grafica}}</option>
                        </select>
                    </td>
                </tr><!--Fin Nuevo causas-->
                <tr v-if="nueva_causa==false" class="align-middle" v-for="(cause,index) in causas" :class="{'table-warning': actualizar_causa==(index+1)}" ><!--Lista de causas-->
                    <td>
                        <button v-if="actualizar_causa==''" class="btn btn-warning btn-boton px-2 py-0 ms-3 my-1" @click="editarCausa(index)" style="font-size: 0.8em;">
                            <i class="bi bi-pencil"></i> Actualizar  
                        </button>
                        <button v-if="actualizar_causa==(index+1)" class="btn btn-warning btn-boton px-2 py-0 ms-3 my-1" @click="actualizarCausa(cause.id)" style="color:black; font-size: 0.8em;">
                        <i class="bi bi-floppy-fill"></i> Guardar
                        </button>
                        <button v-if="actualizar_causa==''" class="btn btn-danger btn-boton px-2 py-0 ms-3 my-1" @click="eliminarCausa(cause.id)" style="font-size: 0.8em;">
                            <i class="bi bi-trash2-fill"></i> Eliminar 
                        </button>
                        <button v-if="actualizar_causa!='' && actualizar_causa==(index+1)" class="btn btn-danger btn-boton px-2 py-0 ms-3 my-1" @click="actualizar_causa=''" style="font-size: 0.8em;">
                            <i class="bi bi-sign-stop-fill"></i> Cancelar 
                        </button>
                    </td>
                    <td class="text-start">
                        <input v-if="actualizar_causa==(index+1)" v-model="responsable_causa" type="text" class="w-100"/>
                        <label v-else class="text-start" style="font-size: 0.8em;">{{cause.responsable}}</label>
                    </td>
                    <td class="text-start">
                        <input v-if="actualizar_causa==(index+1)" v-model="causa" type="text" class="w-100"/>
                        <label v-else class="text-start" style="font-size: 0.8em;">{{cause.causa}}</label>
                    </td>
                    <td>
                        <select v-if="actualizar_causa==(index+1)" v-model="dia_grafica">
                            <option v-for="dia in diasDelMesAnio()" :value="dia">{{dia}}/{{mes_grafica}}/{{anio_grafica}}</option>
                        </select>
                        <label v-else style="font-size: 0.8em;">{{cause.dia}}/{{cause.mes}}/{{cause.anio}}</label>
                    </td>
                </tr><!--Fin lista de causas-->
            </tbody>
        </table>
    </div>