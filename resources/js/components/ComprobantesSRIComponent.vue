<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div v-show="!ocultarDropZone">
                                    <h6>Haga click en el recuadro, o arrastre el archivo .txt</h6>
                                    <hr>
                                    <vue-dropzone ref="dropzone" id="dropzone"
                                        :options="dropzoneOptions"
                                        @vdropzone-success="archivoProcesado"
                                        @vdropzone-processing="inicioEnvio"
                                        @vdropzone-complete="cargaCompleta">
                                    </vue-dropzone>
                                </div>
                                <div class="alert alert-success" v-show="!ocultarCarga">
                                    <span class="h4">Procesando archivo, espere </span>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                </div>
                                <div v-show="!ocultarTabla">
                                    <h4 class="mb-4">
                                        Lista de Comprobantes
                                        <div class="btn-group btn-group-sm float-right">
                                            <button :disabled="disabledGuardar" class="btn btn-success" title="Guardar Comprobantes"><i class="fa fa-save fa-2x" aria-hidden="true"></i></button>
                                            <button @click="reiniciar()" class="btn btn-primary" title="Regresar"><i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i></button>
                                        </div>
                                    </h4>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#factura">Facturas <span v-text="contFacturas" class="badge badge-primary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#nota_credito">Notas de Crédito <span v-text="contNotaCredito" class="badge badge-success"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#nota_debito">Notas de Débito <span v-text="contNotaDebito" class="badge badge-info"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#retenciones">Comprobantes de Retención <span v-text="contRetenciones" class="badge badge-warning"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#liquidaciones">Liquidaciones <span v-text="contLiquidaciones" class="badge badge-secondary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#errores">Errores <span v-text="contErrores" class="badge badge-danger"></span></a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane container active px-0 pt-2" id="factura">
                                            <div class="table-responsive">
                                                <table class="table  table-striped table-condensed table-bordered table-sm table-hover" style="width:100%;">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>SubTotal</th>
                                                        <th>Descuento</th>
                                                        <th>Tarifa Dif. Cero</th>
                                                        <th>Tarifa Cero</th>
                                                        <th>Iva</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <paginate name="facturas" :list="facturas" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('facturas') " :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.subTotal }}</td>
                                                            <td>{{ item.descuento }}</td>
                                                            <td>{{ item.tarifaDifCero }}</td>
                                                            <td>{{ item.tarifaCero }}</td>
                                                            <td>{{ item.iva }}</td>
                                                            <td>{{ item.importeTotal }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="facturas" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="nota_credito">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>Tarifa Dif. Cero</th>
                                                        <th>Tarifa Cero</th>
                                                        <th>Iva</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <paginate name="notas_credito" :list="notas_credito" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('notas_credito')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.tarifaDifCero }}</td>
                                                            <td>{{ item.tarifaCero }}</td>
                                                            <td>{{ item.iva }}</td>
                                                            <td>{{ item.importeTotal }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="notas_credito" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="nota_debito">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>Tarifa Dif. Cero</th>
                                                        <th>Tarifa Cero</th>
                                                        <th>Iva</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <paginate name="notas_debito" :list="notas_debito" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('notas_debito')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.tarifaDifCero }}</td>
                                                            <td>{{ item.tarifaCero }}</td>
                                                            <td>{{ item.iva }}</td>
                                                            <td>{{ item.importeTotal }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="notas_debito" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="retenciones">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>T. Impuesto</th>
                                                        <th>% Retenido</th>
                                                        <th>Base Imponible</th>
                                                        <th>Valor Ret.</th>
                                                    </thead>
                                                    <paginate name="retenciones" :list="retenciones" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('retenciones')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.tipoImp }}</td>
                                                            <td>{{ item.porcRet }}</td>
                                                            <td>{{ item.baseImponible }}</td>
                                                            <td>{{ item.valorRet }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="retenciones" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="liquidaciones">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>T. Comprobante</th>
                                                        <th>SubTotal</th>
                                                        <th>Descuento</th>
                                                        <th>Tarifa Dif. Cero</th>
                                                        <th>Tarifa Cero</th>
                                                        <th>Iva</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <paginate name="liquidaciones" :list="liquidaciones" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('liquidaciones')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ item.fechaEmision }}</td>
                                                            <td>{{ item.tipoComprobante }}</td>
                                                            <td>{{ item.subTotal }}</td>
                                                            <td>{{ item.descuento }}</td>
                                                            <td>{{ item.tarifaDifCero }}</td>
                                                            <td>{{ item.tarifaCero }}</td>
                                                            <td>{{ item.iva }}</td>
                                                            <td>{{ item.importeTotal }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="liquidaciones" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                        <div class="tab-pane container fade px-0 pt-2" id="errores">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-condensed table-bordered table-sm table-hover">
                                                    <thead>
                                                        <th>N°</th>
                                                        <th>Clave Acceso</th>
                                                        <th>Mensaje</th>
                                                    </thead>
                                                    <paginate name="errores" :list="errores" :per="numPagination" tag="tbody">
                                                        <tr v-for="(item,index) in paginated('errores')" :key="item.key">
                                                            <td>{{ index + 1 }}</td>
                                                            <td class="text-left">{{ item.ClaveAcceso }}</td>
                                                            <td>{{ item.mensaje }}</td>
                                                        </tr>
                                                    </paginate>
                                                </table>
                                                <paginate-links for="errores" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"></paginate-links>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';

    export default {
        data(){
            return {
                dropzoneOptions: {
                    url: '/admin/procesarComprobanteSRI',
                    thumbnailWidth: 150,
                    maxFilesize: 1,
                    maxFiles: 1,
                    parallelUploads: 1,
                    dictDefaultMessage: 'Solo se permite archivo .txt',
                    dictRemoveFile: 'Quitar',
                    dictMaxFilesExceeded: 'Solo 1 archivo',
                    dictFileTooBig: 'Archivo excede el tamaño permitido',
                    uploadMultiple: false,
                    acceptedFiles: "text/plain",
                    autoProcessQueue: true,
                    addRemoveLinks: true,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                },
                facturas: [],
                notas_credito: [],
                notas_debito: [],
                retenciones: [],
                liquidaciones: [],
                errores: [],
                ocultarDropZone: false,
                ocultarCarga: true,
                ocultarTabla: true,
                contFacturas: 0,
                contNotaCredito: 0,
                contNotaDebito: 0,
                contRetenciones: 0,
                contLiquidaciones: 0,
                contErrores: 0,
                disabledGuardar: true,
                paginate: ['facturas','notas_credito','notas_debito','retenciones','liquidaciones','errores'],
                numPagination: 10,
            }
        },
        components: {
            vueDropzone: vue2Dropzone,
        },
        mounted() {

        },
        methods: {
            archivoProcesado: async function (response) {
                let resp = JSON.parse(response.xhr.response);
                if(resp != 0){
                    this.facturas = resp.facturas;
                    this.contFacturas = resp.facturas.length;

                    this.notas_credito = resp.notas_credito;
                    this.contNotaCredito = resp.notas_credito.length;

                    this.notas_debito = resp.notas_debito;
                    this.contNotaDebito = resp.notas_debito.length;

                    this.retenciones = resp.retenciones;
                    this.contRetenciones = resp.retenciones.length;

                    this.liquidaciones = resp.liquidaciones;
                    this.contLiquidaciones = resp.liquidaciones.length;

                    this.errores = resp.errores;
                    this.contErrores = resp.errores.length;

                    this.ocultarDropZone = true;
                    this.ocultarCarga = true;
                    this.ocultarTabla = false;
                    if(this.contFacturas > 0 || this.contNotaCredito > 0 || this.contNotaDebito > 0 || this.contRetenciones > 0 || this.contLiquidaciones > 0){
                        this.disabledGuardar = false;
                    }
                }else{
                    Toast.fire({icon: 'error',text: 'Se ha producido un error, vuelva a intentar'});
                    this.ocultarDropZone = false;
                    this.ocultarCarga = true;
                    this.ocultarTabla = true;
                    this.disabledGuardar = true;
                }
            },
            inicioEnvio: function(){
                this.ocultarDropZone = true;
                this.ocultarCarga = false;
            },
            resetDropZone: function(file){
                this.$refs.dropzone.removeFile(file);
                this.ocultarDropZone = true;
                this.ocultarCarga = true;
                this.ocultarTabla = false;
            },
            cargaCompleta(file){
                this.$refs.dropzone.removeFile(file);
            },
            async exportarExcel(){
              this.postForm( '/comprobante_electronicos/exportarExcel', {
                                                                            facturas: JSON.stringify(this.facturas),
                                                                            notasCredito: JSON.stringify(this.notas_credito),
                                                                            notasDebito: JSON.stringify(this.notas_debito),
                                                                            retenciones: JSON.stringify(this.retenciones),
                                                                            liquidaciones: JSON.stringify(this.liquidaciones),
                                                                        });
            },
            postForm: function(path, params, method){
                method = method || 'post';
                var form = document.createElement('form');
                form.setAttribute('method', method);
                form.setAttribute('action', path);
                var token = document.createElement('input');
                token.setAttribute('type', 'hidden');
                token.setAttribute('name', '_token');
                token.setAttribute('value', document.head.querySelector("[name=csrf-token]").content);
                form.appendChild(token);

                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        var hiddenField = document.createElement('input');
                        hiddenField.setAttribute('type', 'hidden');
                        hiddenField.setAttribute('name', key);
                        hiddenField.setAttribute('value', params[key]);
                        form.appendChild(hiddenField);
                    }
                }
                document.body.appendChild(form); form.submit();
            },
            reiniciar(){
                //Object.assign(this.$data, this.$options.data());
                window.location.href="/admin/ingreso_facturas/sri";
            },

        },
        computed: {
            facturasOrderBy: function () {
                return _.orderBy(this.facturas, 'fechaEmision', 'asc');
            },
            notasCredOrderBy: function () {
                return _.orderBy(this.notas_credito, 'fechaEmision', 'asc');
            },
            notasDebOrderBy: function () {
                return _.orderBy(this.notas_debito, 'fechaEmision', 'asc');
            },
            retenOrderBy: function () {
                return _.orderBy(this.retenciones, 'fechaEmision', 'asc');
            },
            liquidacionesOrderBy: function () {
                return _.orderBy(this.liquidaciones, 'fechaEmision', 'asc');
            }
        }
    }
</script>

<style>
.page-item {
    cursor: pointer;
}
</style>
