
                                <!-- TÍTULO -->
                                <div class="card-header bg-success text-white py-1">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <label class="mb-0 fw-bold text-sm">
                                                Impactos Ambientales
                                            </label><br>
                                            <small class="opacity-75">
                                                <!--Registro de emisiones y aspectos ambientales-->
                                            </small>
                                        </div>
                                        <span class="badge bg-light text-success">
                                            Ambiental
                                        </span>
                                    </div>
                                    <!-- INFORMACIÓN -->
                                    <div class="d-flex align-items-center gap-3 py-2 px-3">
                                        <!-- <span>
                                            {{ select_session_equipo?.split('<->')[1] }} <b>-></b>
                                        </span> -->
                                        <span v-if="nombre_indicador">
                                            {{ nombre_indicador }}
                                        </span>
                                        <span
                                            v-else
                                            class="text-warning rounded rounded-2 bg-black my-1 px-2 py-1"
                                            style="font-size: 0.8em;">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                            Primero debes colocarle un nombre al indicador antes de añadir impactos.
                                        </span>
                                    </div>
                                </div>
                                <!-- CUERPO -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="tablaImpactosAmbientales" class="table table-bordered table-hover align-middle mb-0" style="min-width: 1000px;">
                                            <!-- ENCABEZADO -->
                                            <thead class="table-success">
                                                <tr class="text-center">

                                                    <th scope="col">
                                                        #
                                                    </th>
                                                    <th scope="col">
                                                        Diagrama de<br>
                                                        Proceso Ambiental
                                                    </th>
                                                    <th scope="col">
                                                        Tipo
                                                    </th>
                                                    <th scope="col">
                                                        Concepto
                                                    </th>
                                                    <th scope="col">
                                                        Alcance
                                                    </th>
                                                    <th scope="col">
                                                        Cant.
                                                    </th>
                                                    <th scope="col">
                                                        UM
                                                    </th>
                                                    <th scope="col">
                                                        t CO₂/Año<br>
                                                        evitadas
                                                    </th>
                                                    <th scope="col">
                                                        Referencia
                                                    </th>
                                                    <th scope="col">
                                                        Acción
                                                    </th>
                                                </tr>
                                            </thead>
                                            <!-- REGISTROS -->
                                            <tbody>
                                                <tr
                                                    v-for="(impacto, index) in emisiones_aspectos_ambientales_proyecto_ead"
                                                    :key="index"
                                                    class="text-center">
                                                    <!-- # -->
                                                    <td>
                                                        <span class="fw-bold text-muted">
                                                            {{ index + 1 }}
                                                        </span>
                                                    </td>

                                                    <!-- DIAGRAMA -->
                                                    <td>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-sm text-center text-primary"
                                                            v-model="impacto.diagrama"
                                                            list="catalogo-diagramas"
                                                            style="font-size: 1em;"
                                                            aria-label="Diagrama">
                                                        <small class="text-muted d-block mt-1 text-start">
                                                            Ejem.: E-DF-IP-RJ-A
                                                        </small>
                                                        <datalist id="catalogo-diagramas">
                                                            <option
                                                                v-for="valor in obtenerOpcionesCatalogo('diagrama')"
                                                                :key="valor"
                                                                :value="valor">
                                                            </option>
                                                        </datalist>
                                                    </td>
                                                    <!-- TIPO -->
                                                    <td>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-sm text-center text-primary"
                                                            v-model="impacto.tipo"
                                                            list="catalogo-tipos"
                                                            aria-label="Tipo"
                                                            style="font-size: 1em;">
                                                        <small class="text-muted d-block mt-1 text-start">
                                                            Ej.: Energía
                                                        </small>
                                                        <datalist id="catalogo-tipos">
                                                            <option
                                                                v-for="valor in obtenerOpcionesCatalogo('tipo')"
                                                                :key="valor"
                                                                :value="valor"></option>
                                                        </datalist>
                                                    </td>
                                                    <!-- CONCEPTO -->
                                                    <td>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-sm text-center text-primary"
                                                            v-model="impacto.concepto"
                                                            style="font-size: 1em;"
                                                            list="catalogo-conceptos">
                                                        <small class="text-muted d-block mt-1 text-start">
                                                            Ej.: Electricidad
                                                        </small>
                                                        <datalist id="catalogo-conceptos">
                                                            <option
                                                                v-for="valor in obtenerOpcionesConceptos()"
                                                                :key="valor"
                                                                :value="valor"></option>
                                                        </datalist>
                                                    </td>
                                                    <!-- ALCANCE -->
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column align-items-center position-relative">

                                                            <!-- Selector -->
                                                            <select
                                                                class="form-select form-select-sm text-center w-full my-1"
                                                                :class="impacto.alcance === ''
                                                        ? 'text-secondary'
                                                        : 'text-primary'"
                                                                style="font-size: 1em;"
                                                                v-model="impacto.alcance">

                                                                <option disabled value="">Alcance...</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                            </select>

                                                            <!-- Alcances y botones de ayuda -->
                                                            <div class="d-flex justify-content-between gap-2 ">

                                                                <!-- Alcance 1 -->
                                                                <div class="d-flex flex-column align-items-center">

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-outline-secondary btn-sm rounded-circle p-0"
                                                                        style="width: 20px; height: 20px;"
                                                                        @mouseenter="mostrarAyuda(1)"
                                                                        @mouseleave="ocultarAyuda">

                                                                        <span class="small">?</span>
                                                                    </button>
                                                                </div>

                                                                <!-- Alcance 2 -->
                                                                <div class="d-flex flex-column align-items-center">

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-outline-secondary btn-sm rounded-circle p-0"
                                                                        style="width: 20px; height: 20px;"
                                                                        @mouseenter="mostrarAyuda(2)"
                                                                        @mouseleave="ocultarAyuda">

                                                                        <span class="small">?</span>
                                                                    </button>
                                                                </div>

                                                                <!-- Alcance 3 -->
                                                                <div class="d-flex flex-column align-items-center">

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-outline-secondary btn-sm rounded-circle p-0"
                                                                        style="width: 20px; height: 20px;"
                                                                        @mouseenter="mostrarAyuda(3)"
                                                                        @mouseleave="ocultarAyuda">
                                                                        <span class="small">?</span>
                                                                    </button>
                                                                </div>

                                                            </div>
                                                            <!-- Tooltip flotante -->
                                                            <div
                                                                v-if="alcanceAyudaVisible"
                                                                class="position-absolute start-50 translate-middle-x
                                                    bg-dark text-white rounded shadow p-2 small"
                                                                role="tooltip"
                                                                style="
                                                    z-index: 9999;
                                                    width: 230px;
                                                    top: 50px;
                                                    transform: translate(-50%, -100%) !important;
                                                    pointer-events: none;">
                                                                {{ textoAyudaAlcance }}
                                                            </div>

                                                        </div>
                                                    </td>
                                                    <!-- CANTIDAD -->
                                                    <td>
                                                        <input
                                                            type="number"
                                                            step="0.000001"
                                                            class="form-control form-control-sm text-center text-primary bg-white w-100"
                                                            v-model="impacto.cantidad"
                                                            placeholder="0"
                                                            style="width: 100px; font-size: 1em;">
                                                        <small class="text-muted d-block mt-1 text-start font-white">
                                                            <br>
                                                        </small>
                                                    </td>
                                                    <!-- UM -->
                                                    <td>

                                                        <input
                                                            type="text"
                                                            class="form-control form-control-sm text-center text-primary bg-white w-100"
                                                            v-model="impacto.um"
                                                            list="catalogo-um"
                                                            style="width: 100px; font-size: 1em;"
                                                            :disabled="!!umConceptoFe[impacto.concepto] || !!umConceptoImpactoAmbiental[impacto.concepto]">
                                                        <small class="text-muted d-block mt-1 text-start">
                                                            Ej.: kWh/Año
                                                        </small>

                                                        <datalist id="catalogo-um">
                                                            <option
                                                                v-for="valor in obtenerOpcionesUM()"
                                                                :key="valor"
                                                                :value="valor"></option>
                                                        </datalist>
                                                    </td>
                                                    <!-- CO2 -->
                                                    <td>
                                                         <template v-if="['Gasolina', 'Diésel', 'Gas Natural', 'Electricidad'].includes((impacto.concepto || '').trim())">
                                                            <input type="number" step="0.000001" class="form-control form-control-sm text-center fw-semibold w-100" :style="{ backgroundColor: !!umConceptoFe[impacto.concepto] ? '#E9ECEF' : 'rgba(144, 206, 177, 0.35)' }" v-model="impacto.co2" style="min-width: 100px;" placeholder="0.00" :disabled="!!umConceptoFe[impacto.concepto]">
                                                            <small class="text-muted d-block mt-1 text-start">Nota.: Cálculo automático.</small>
                                                        </template>
                                                    </td>
                                                    <!-- REFERENCIA -->
                                                    <td>
                                                        <textarea
                                                            class="form-control form-control-sm text-center text-primary bg-red mt-1.5"
                                                            v-model="impacto.referencia"
                                                            placeholder="Referencia"
                                                            rows="2"
                                                            style="font-size: 1em;"
                                                            :disabled="!!umConceptoFe[impacto.concepto]">
                                            </textarea>
                                                        <small class="text-muted d-block mt-1 text-start">
                                                            <br>
                                                        </small>
                                                    </td>
                                                    <!-- ACCIONES -->
                                                    <td>
                                                        <button
                                                            type="button"
                                                            class="btn btn-outline-danger btn-sm"
                                                            @click="eliminarImpacto(index)"
                                                            :disabled="emisiones_aspectos_ambientales_proyecto_ead.length === 1"
                                                            title="Eliminar impacto">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <!-- TOTALES -->
                                            <tfoot>
                                                <tr class="table-light">
                                                    <td colspan="7" class="fw-bold">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <button
                                                                type="button"
                                                                class="btn btn-outline-success rounded-pill px-3 py-1 shadow-sm"
                                                                style="font-size: 0.9em;"
                                                                @click="nuevaFilaEmision()">
                                                                <i class="bi bi-plus-circle-fill me-1"></i>
                                                                Agregar fila
                                                            </button>
                                                            <span>
                                                                Total emisiones evitadas:
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-success fw-bold fs-6 px-3">
                                                            {{ totalCo2Sumar.toFixed(6) }} t CO₂
                                                        </span>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- PIE -->
                                <div class="card-footer bg-light border-0">
                                    <div class="d-flex align-items-center justify-content-between gap-2">
                                        <div>
                                            <span
                                                v-if="banderaImpactoGuardado"
                                                class="badge bg-success p-2">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                Impacto(s) guardado(s) correctamente
                                            </span>

                                        </div>
                                        <div class="d-flex gap-2 mt-1">
                                            <button
                                                type="button"
                                                class="btn btn-outline-primary btn-sm"
                                                @click="descargarImagenTabla()">
                                                <i class="bi bi-image me-1"></i> Descargar
                                            </button>
                                            <!-- GUARDAR -->
                                            <button
                                                type="button"
                                                class="btn btn-success btn-sm"
                                                @click="guardarImpactoDeProyecto()">
                                                <i class="bi bi-floppy-fill me-1"></i>
                                                Guardar impacto(s)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            