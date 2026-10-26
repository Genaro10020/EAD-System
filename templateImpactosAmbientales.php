<div class="ia-container">
    <div id="tablaImpactosAmbientales">
    <div class="ia-body" >
        <!-- TÍTULO Y ENCABEZADO -->
        <div class="ia-header">
            <div class="ia-header-top">
                <div class="ia-title-group">
                    <label class="ia-title">Impactos Ambientales</label>
                    <small class="ia-subtitle">Registro de emisiones y aspectos ambientales</small>
                </div>
                
                <?php if (isset($origenOPEX) && $origenOPEX === true): ?>
                    <div class="ia-ead-container">
                        <button type="button" class="ia-btn ia-btn-outline-primary" @click="mostrarListaEAD = !mostrarListaEAD">
                            <i class="bi bi-cloud-download-fill"></i> Proyectos EAD's
                        </button>

                        <button type="button" class="ia-btn ia-btn-outline-secondary gap-2" @click="limpiarProyectoEAD()" title="Limpiar datos cargados">
                            <i class="bi bi-eraser-fill"></i>
                        </button>

                        <div v-show="mostrarListaEAD" class="ia-ead-dropdown shadow">
                            <div class="ia-ead-search">
                                <input type="text" v-model="filtroEAD" placeholder="Buscar proyecto EAD..." class="ia-input ia-input-small w-100">
                            </div>

                            <ul class="ia-ead-list">
                                <li v-for="proyecto in proyectosFiltradosEAD" :key="proyecto.id_equipo" 
                                    @click="!proyecto.cargado ? seleccionarProyectoEAD(proyecto) : null" 
                                    class="ia-ead-item d-flex justify-content-between align-items-center"
                                    :class="{'text-muted bg-light': proyecto.cargado}"
                                    :style="proyecto.cargado ? 'cursor: not-allowed; opacity: 0.6;' : ''">
                                    
                                    <span>
                                        {{ proyecto.nombre_indicador }}
                                        <span v-if="proyecto.nombre_equipo" class="badge bg-info text-dark ms-2" style="font-size: 0.75rem;">
                                            {{ proyecto.nombre_equipo }}
                                        </span>
                                    </span>

                                    <span v-if="proyecto.cargado" class="badge bg-secondary">Ya cargado</span>
                                </li>
                                <li v-if="proyectosFiltradosEAD.length === 0" class="ia-ead-empty">
                                    No se encontraron proyectos.
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                
                <span class="ia-badge">Ambiental</span>
            </div>
        
            <!-- INFORMACIÓN / ALERTAS -->
            <div class="ia-info-bar">
                <span v-if="nombre_indicador" class="ia-indicator-name">
                    {{ nombre_indicador }}
                </span>
                <span v-else class="ia-alert-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Primero debes colocarle un nombre al indicador antes de añadir impactos.
                </span>
            </div>
        </div>
    </div>

    <div class="ia-body">
        <div class="ia-table-responsive">
            <table class="ia-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Diagrama de<br>Proceso Ambiental</th>
                        <th>Tipo</th>
                        <th>Concepto</th>
                        <th>Alcance</th>
                        <th>Cant.</th>
                        <th>UM</th>
                        <th>t CO₂/Año<br>evitadas</th>
                        <th>Referencia</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                
                <!-- REGISTROS -->
                <tbody>
                    <tr v-for="(impacto, index) in emisiones_aspectos_ambientales_proyecto_ead" :key="index">
                        <td class="ia-index-col">
                            <span class="fw-bold text-muted">{{ index + 1 }}</span>
                        </td>

                        <!-- DIAGRAMA -->
                        <td>
                            <input type="text" class="ia-input" v-model="impacto.diagrama" list="catalogo-diagramas">
                            <small class="form-text text-muted d-block mt-1 opacity-50">E-DF-IP-RJ-A</small>
                            <datalist id="catalogo-diagramas">
                                <option v-for="valor in obtenerOpcionesCatalogo('diagrama')" :key="valor" :value="valor"></option>
                            </datalist>
                        </td>

                        <!-- TIPO -->
                        <td>
                            <input type="text" class="ia-input" v-model="impacto.tipo" list="catalogo-tipos">
                            <small class="form-text text-muted d-block mt-1 opacity-50">Energía</small>
                            <datalist id="catalogo-tipos">
                                <option v-for="valor in obtenerOpcionesCatalogo('tipo')" :key="valor" :value="valor"></option>
                            </datalist>
                        </td>

                        <!-- TIPO -->
                        <td>
                            <input type="text" class="ia-input" v-model="impacto.tipo" list="catalogo-tipos" placeholder="Ej.: Energía">
                            <datalist id="catalogo-tipos">
                                <option v-for="valor in obtenerOpcionesCatalogo('tipo')" :key="valor" :value="valor"></option>
                            </datalist>
                        </td>

                        <!-- ALCANCE (Tooltip corregido) -->
                        <td class="ia-col-alcance">
                            <div class="ia-scope-container mt-1">
                                <select class="ia-select" v-model="impacto.alcance" :class="{'ia-text-muted': impacto.alcance === ''}">
                                    <option disabled value="">Alcance...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>

                                <div class="ia-help-buttons">
                                    <button type="button" class="ia-btn-help" @mouseenter="mostrarAyuda(1, index)" @mouseleave="ocultarAyuda">?</button>
                                    <button type="button" class="ia-btn-help" @mouseenter="mostrarAyuda(2, index)" @mouseleave="ocultarAyuda">?</button>
                                    <button type="button" class="ia-btn-help" @mouseenter="mostrarAyuda(3, index)" @mouseleave="ocultarAyuda">?</button>
                                </div>

                                <!-- Tooltip anclado a la celda activa -->
                                <div v-if="filaAyudaActiva === index" class="ia-tooltip-mejorado">
                                    {{ textoAyudaAlcance }}
                                </div>
                            </div>
                        </td>

                        <!-- CANTIDAD -->
                        <td style="min-width: 86px;">
                            <div v-if="['Gasolina', 'Diésel', 'Gas Natural', 'Electricidad'].includes((impacto.concepto || '').trim())">
                                <input type="number" step="0.000001" class="ia-input ia-input-number" v-model="impacto.cantidad">
                                <small class="form-text text-muted d-block mt-1 opacity-50">12.535</small>
                            </div>

                            <div v-else>
                                <small class="span-alert alert-dark text-white form-text text-muted d-block mb-3">
                                    No Aplica
                                </small>
                            </div>
                        </td>

                        <!-- UM -->
                        <td>
                            <input type="text" class="ia-input ia-input-small" v-model="impacto.um" list="catalogo-um" :disabled="!!umConceptoFe[impacto.concepto] || !!umConceptoImpactoAmbiental[impacto.concepto]">
                            <small class="form-text text-muted d-block mt-1 opacity-50">kWh/Año</small>
                            <datalist id="catalogo-um">
                                <option v-for="valor in obtenerOpcionesUM()" :key="valor" :value="valor"></option>
                            </datalist>
                        </td>

                        <!-- CO2 -->
                        <td>
                            <div v-if="['Gasolina', 'Diésel', 'Gas Natural', 'Electricidad'].includes((impacto.concepto || '').trim())">
                                <input type="number" step="0.000001" class="ia-input-calc" v-model="impacto.co2" placeholder="0.00" :disabled="!!umConceptoFe[impacto.concepto]">
                                <small class="form-text text-muted d-block mt-1 opacity-50">Calculo automatico</small>
                            </div>

                            <div v-else>
                                <small class="span-alert alert-dark text-white form-text text-muted d-block mb-3">
                                    No Aplica
                                </small>
                            </div>
                        </td>
                        <!-- REFERENCIA -->
                        <td>
                            <textarea class="ia-textarea" v-model="impacto.referencia" rows="2" :disabled="!!umConceptoFe[impacto.concepto]"></textarea>
                            <small class="form-text text-muted d-block mt-1 opacity-50">Referencia documental</small>
                        </td>

                        <!-- ACCIONES -->
                        <td>
                            <button type="button" class="ia-btn-icon ia-btn-danger" @click="eliminarImpacto(index)" :disabled="emisiones_aspectos_ambientales_proyecto_ead.length === 1" title="Eliminar impacto">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>

                <!-- TOTALES -->
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="ia-footer-actions">
                                <button type="button" class="ia-btn ia-btn-outline-success" @click="nuevaFilaEmision()">
                                    <i class="bi bi-plus-circle-fill"></i> Agregar fila
                                </button>
                                <span class="ia-total-label">Total emisiones evitadas:</span>
                            </div>
                        </td>
                        <td class="ia-total-value">...</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
    <!-- PIE DE TARJETA -->
    <div class="ia-footer ia-footer-delgado">
        <div class="ia-status">
            <span v-if="banderaImpactoGuardado" class="ia-badge-success py-1">
                <i class="bi bi-check-circle-fill"></i> Impacto(s) guardado(s) correctamente
            </span>
        </div>
        <div class="ia-actions">
            <button type="button" class="ia-btn ia-btn-outline-primary py-1" @click="descargarImagenTabla()">
                <i class="bi bi-image"></i> Descargar
            </button>
            <button type="button" class="ia-btn ia-btn-success py-1" @click="guardarImpactoDeProyecto()">
                <i class="bi bi-floppy-fill"></i> Guardar impacto(s)
            </button>
        </div>
    </div>
</div>