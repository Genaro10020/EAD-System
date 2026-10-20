<div class="ia-container">
    <!-- TÍTULO Y ENCABEZADO -->
    <div class="ia-header">
        <div class="ia-header-top">
            <div class="ia-title-group">
                <label class="ia-title">Impactos Ambientales</label>
                <small class="ia-subtitle">Registro de emisiones y aspectos ambientales</small>
            </div>
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

    <div class="ia-body">
        <div class="ia-table-responsive">
            <table id="tablaImpactosAmbientales" class="ia-table">
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
                            <input type="text" class="ia-input" v-model="impacto.diagrama" list="catalogo-diagramas" placeholder="Ejem.: E-DF-IP-RJ-A">
                            <datalist id="catalogo-diagramas">
                                <option v-for="valor in obtenerOpcionesCatalogo('diagrama')" :key="valor" :value="valor"></option>
                            </datalist>
                        </td>

                        <!-- TIPO -->
                        <td>
                            <input type="text" class="ia-input" v-model="impacto.tipo" list="catalogo-tipos" placeholder="Ej.: Energía">
                            <datalist id="catalogo-tipos">
                                <option v-for="valor in obtenerOpcionesCatalogo('tipo')" :key="valor" :value="valor"></option>
                            </datalist>
                        </td>

                        <!-- CONCEPTO -->
                        <td>
                            <input type="text" class="ia-input" v-model="impacto.concepto" list="catalogo-conceptos" placeholder="Ej.: Electricidad">
                            <datalist id="catalogo-conceptos">
                                <option v-for="valor in obtenerOpcionesConceptos()" :key="valor" :value="valor"></option>
                            </datalist>
                        </td>

                        <!-- ALCANCE (Tooltip corregido) -->
                        <td class="ia-col-alcance">
                            <div class="ia-scope-container">
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
                        <td>
                            <input type="number" step="0.000001" class="ia-input ia-input-number" v-model="impacto.cantidad" placeholder="0">
                        </td>

                        <!-- UM -->
                        <td>
                            <input type="text" class="ia-input ia-input-small" v-model="impacto.um" list="catalogo-um" placeholder="Ej.: kWh/Año" :disabled="!!umConceptoFe[impacto.concepto] || !!umConceptoImpactoAmbiental[impacto.concepto]">
                            <datalist id="catalogo-um">
                                <option v-for="valor in obtenerOpcionesUM()" :key="valor" :value="valor"></option>
                            </datalist>
                        </td>

                        <!-- CO2 -->
                        <td>
                            <template v-if="['Gasolina', 'Diésel', 'Gas Natural', 'Electricidad'].includes((impacto.concepto || '').trim())">
                                <input type="number" step="0.000001" class="ia-input ia-input-calc" v-model="impacto.co2" placeholder="0.00" :disabled="!!umConceptoFe[impacto.concepto]">
                                <small class="ia-hint">Automático</small>
                            </template>
                        </td>

                        <!-- REFERENCIA -->
                        <td>
                            <textarea class="ia-textarea" v-model="impacto.referencia" placeholder="Referencia" rows="1" :disabled="!!umConceptoFe[impacto.concepto]"></textarea>
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