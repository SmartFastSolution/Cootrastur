<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <button @click="modalNuevoRegistro = true,resetForm()" class="btn btn-primary btn-sm mb-2">Nuevo Registro</button>
                <div class="row justify-content-center">
                    <div class="form-group col-6 col-md-3">
                        <label>Fecha: </label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm inputDateRange">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-info resetDateFilter" type="button">
                                    <i class="fa fa-retweet"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="tblTransacciones" class="table table-striped table-bordered table-sm" style="width:100%;">
                    <thead style="font-size:9.0pt;">
                        <tr>
                            <th class="text-center" style="width:100px;">Fecha</th>
                            <th style="width:150px;">Tipo Transacción</th>
                            <th>Detalle</th>
                            <th class="text-center" style="width:60px;">Iva</th>
                            <th class="text-center" style="width:60px;">Importe</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in transacciones" :key="item.id">
                            <td class="text-center">{{ item.fecha }}</td>
                            <td>{{ item.tipo }}</td>
                            <td>{{ item.detalle }}</td>
                            <td class="text-right pr-4">{{ item.iva }}</td>
                            <td class="text-right pr-4">{{ item.importe }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Nuevo Registro -->
        <div class="modal" :class="{mostrar:modalNuevoRegistro}">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Registrar Comprobante</h4>
                        <button @click="cerrarModal()" type="button" class="close" >&times;</button>
                    </div>
                    <!-- Modal body -->
                    <form @submit.prevent="guardar" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group row mb-2">
                            <label for="fecha" class="col-4 col-form-label">Fecha</label>
                            <div class="col-8">
                                <input v-model="comprobante.fecha" type="date" class="form-control form-control-sm" id="fecha">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tipo" class="col-4 col-form-label">Tipo de Transacción</label>
                            <div class="col-8">
                                <select v-model="comprobante.tipo_transaccion" class="form-control form-control-sm" id="tipo">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in tipoTransaccion" :key="item.id" :value="item.id" v-text="item.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="cuenta" class="col-4 col-form-label">Cuenta</label>
                            <div class="col-8">
                                <select v-model="comprobante.cuenta" class="form-control form-control-sm" id="cuenta">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in cuentas" :key="item.id" :value="item.id" v-text="item.cuenta"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tarifacero" class="col-4 col-form-label">Tarifa 0%</label>
                            <div class="col-8">
                                 <money v-model="comprobante.tarifacero" class="form-control form-control-sm text-right" id="tarifacero"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tarifadifcero" class="col-4 col-form-label">Tarifa Dif. de 0%</label>
                            <div class="col-8">
                                 <money v-model="comprobante.tarifadifcero" class="form-control form-control-sm text-right" id="tarifadifcero"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="iva" class="col-4 col-form-label">Iva</label>
                            <div class="col-8">
                                 <money v-model="comprobante.iva" class="form-control form-control-sm text-right" id="iva"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="importe" class="col-4 col-form-label">Importe</label>
                            <div class="col-8">
                                 <money v-model="comprobante.importe" class="form-control form-control-sm text-right" id="importe"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="detalle" class="col-4 col-form-label">Detalle</label>
                            <div class="col-8">
                                <input v-model="comprobante.detalle" type="text" class="form-control form-control-sm" id="detalle">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-2">
                            <label for="nota" class="col-4 col-form-label">Nota</label>
                            <div class="col-8 text-right">
                                <a href="#" @click="abrirInputFile">
                                    <i class="fa fa-camera fa-2x" aria-hidden="true"></i>
                                </a>
                                <input type="file" @change="obtenerImagen" class="form-control form-control-sm d-none" id="inputFile" accept="image/*">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 text-center">
                                <figure v-if="imgFactura != ''">
                                    <img width="220" height="240" alt="Imagen" :src="imagen" class="img img-thumbnail">
                                </figure>
                                <div v-show="procesando">
                                    <span>Procesando...</span>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">GuardarRegistro</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import datatable from 'datatables.net-bs4';
import datatableres from 'datatables.net-responsive';
import datatableresbs4 from 'datatables.net-responsive-bs4';
import moment from "moment";
import {Money} from 'v-money'
import Tesseract from 'tesseract.js';

export default {
    data() {
        return {
            modalNuevoRegistro: false,
            procesando: false,
            imagenMiniatura: '',
            imgFactura: '',
            comprobante: {
                fecha: moment().format('YYYY-MM-DD'),
                tipo_transaccion: '',
                cuenta: '',
                tarifacero: 0,
                tarifadifcero: 0,
                iva: 0,
                importe: 0,
                detalle: '',
            },
            tipoTransaccion: [],
            transacciones:[
                {
                    id: 1,
                    fecha: '10/08/2021',
                    tipo: 'Gasto',
                    detalle: 'Desayuno',
                    iva: 0.60,
                    importe: 5.00
                },
                {
                    id: 2,
                    fecha: '10/08/2021',
                    tipo: 'Gasto',
                    detalle: 'Almuerzo',
                    iva: 0.60,
                    importe: 5.00
                },
                {
                    id: 3,
                    fecha: '10/08/2021',
                    tipo: 'Gasto',
                    detalle: 'Merienda',
                    iva: 0.60,
                    importe: 5.00
                },
                {
                    id: 4,
                    fecha: '10/08/2021',
                    tipo: 'Ingreso',
                    detalle: 'Retencion',
                    iva: 0.00,
                    importe: 4.00
                }
            ],
            cuentas: [
                {
                    id: 1,
                    cuenta: 'Gastos de Alimentación'
                }
            ]
        }
    },
    created() {
        this.listarTipoTransaccion();
        //this.$tablaGlobal("#tblTransacciones");
        this.generarDataTable();
    },
    methods: {
        generarDataTable(){
            this.$nextTick(()=>{
                var minDateFilter = '';
                var maxDateFilter = '';

                $("#tblTransacciones").DataTable().destroy();
                var tabla = $("#tblTransacciones").DataTable({
                    "retrieve": true,
                    "bDeferRender": true,
                    "autoWidth": false,
                    "order": [[ 0, "desc" ]],
                    "search": {
                        "regex": true,
                        "caseInsensitive": false,
                    },
                    "destroy": true,
                    "sPaginationType": "full_numbers",
                    "language":{
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "<i class='fa fa-fast-backward' aria-hidden='true'></i>",
                            "sLast":     "<i class='fa fa-fast-forward' aria-hidden='true'></i>",
                            "sNext":     "<i class='fa fa-step-forward' aria-hidden='true'></i>",
                            "sPrevious": "<i class='fa fa-step-backward' aria-hidden='true'></i>"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    "responsive": true,
                    //dom: 'Bfrtip',
                });

                $('.inputDateRange').daterangepicker({
                    startDate: moment(),
                    endDate: moment(),
                    locale: {
                        format: 'YYYY/MM/DD',
                        "separator": " - ",
                        "applyLabel": "Aplicar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "DE",
                        "toLabel": "HASTA",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Dom",
                            "Lun",
                            "Mar",
                            "Mie",
                            "Jue",
                            "Vie",
                            "Sáb"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1,
                        "opens": "center",
                    }
                }, function(start, end, label) {
                    //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                    maxDateFilter = end;
                    minDateFilter = start;
                    tabla.draw();
                });

                $('.resetDateFilter').click(function(){
                    maxDateFilter = '';
                    minDateFilter = '';
                    tabla.draw();
                });

                $.fn.dataTableExt.afnFiltering.push(
                    function(oSettings, aData, iDataIndex){
                        if(typeof aData._date == 'undefined'){
                            aData._date = new Date(aData[0]).getTime();
                        }

                        if(minDateFilter && !isNaN(minDateFilter)){
                            if(aData._date < minDateFilter){
                                return false;
                            }
                        }

                        if(maxDateFilter && !isNaN(maxDateFilter)){
                            if(aData._date > maxDateFilter){
                                return false;
                            }
                        }
                        return true;
                    }
                );

            });
        },
        cerrarModal(){
            this.modalNuevoRegistro = false;
        },
        abrirInputFile(){
            $('#inputFile').click();
        },
        async obtenerImagen(e){
            var file = e.target.files[0];
            this.procesando = true;
            if(this.comprobante.importe == 0){
                var cero = 0;
                var difcero = 0;
                var importe = 0;
                var iva = 0;
                await Tesseract.recognize(file,'spa')
                    .progress(function(data){
                        //console.log(data.status)
                    })
                    .then(function(data){
                        data.lines.forEach((item,index,array) => {
                            console.log(item.text);
                            if(item.text.match(/Tarifa 0.*/)){
                                var regex = /(\d.+)/g;
                                var valor = item.text.substr(-8);
                                cero = parseFloat(valor.match(regex));
                            }
                            if(item.text.match(/Tarifa 12.*/)){
                                var regex = /(\d.+)/g;
                                var valor = item.text.substr(-8);
                                difcero = parseFloat(valor.match(regex));
                            }
                            if(item.text.match(/IVA.*/)){
                                var regex = /(\d.+)/g;
                                var valor = item.text.substr(-8);
                                iva = parseFloat(valor.match(regex));
                            }
                            if(item.text.match(/TOTAL.*/)){
                                var regex = /(\d.+)/g;
                                var valor = item.text.substr(-8);
                                importe = parseFloat(valor.match(regex));
                            }
                        });
                    });
                this.comprobante.tarifacero = cero;
                this.comprobante.tarifadifcero = difcero;
                this.comprobante.importe = importe;
                this.comprobante.iva = iva;
            }

            this.procesando = false;
            this.imgFactura = file;
            this.cargarImagen(file);
        },
        cargarImagen(file){
            let reader = new FileReader();
            reader.onload = (e) => {
                this.imagenMiniatura = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        async listarTipoTransaccion(){
            const respuesta = await axios.get('/admin/ingreso_facturas/listar_tipo_transaccion');
            this.tipoTransaccion = respuesta.data;
        },
        resetForm(){
            this.comprobante.fecha = moment().format('YYYY-MM-DD');
            this.comprobante.tipo_transaccion = '';
            this.comprobante.cuenta = '';
            this.comprobante.tarifacero = 0;
            this.comprobante.tarifadifcero = 0;
            this.comprobante.iva = 0;
            this.comprobante.importe = 0;
            this.imgFactura = '';
            this.imagenMiniatura = '';
            this.comprobante.detalle = '';
        }
    },
    computed: {
        imagen(){
            return this.imagenMiniatura;
        }
    },
}
</script>
<style scoped>
.mostrar {
    display: list-item;
    opacity: 1;
    background-color: rgba(14, 21, 66, 0.445);
    overflow: auto;
}
.form-control-sm {
    height: calc(1.5em + .5rem + 2px) !important;
    padding: .25rem .5rem !important;
    font-size: .875rem !important;
    line-height: 1.5 !important;
    border-radius: .2rem !important;
}
</style>
