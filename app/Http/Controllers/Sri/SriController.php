<?php

namespace App\Http\Controllers\Sri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class SriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function procesarComprobanteSRI(Request $request)
    {
        //$this->comprobarComprobanteSRI("2005202104179125123700120050140015919940159199419");
        //exit;
        $archivo =  file_get_contents($request->file);
        $array = explode("\t", $archivo);

        try {
            $arrayErrores = [];
            $arrayFacturas = [];
            $arrayNotasCredito = [];
            $arrayNotasDebito = [];
            $arrayRetenciones = [];
            $arrayLiquidaciones = [];
            $key = 0;
            foreach($array as $item){
                if(strlen($item) == 49 && is_numeric($item)){
                    $respOk = false;
                    $respuestaSRI = $this->autorizarComprobanteSRI($item);
                    if(!is_array($respuestaSRI)){
                        $respOk = true;
                    }else{
                        $respuestaSRI = $this->autorizarComprobanteSRI($item);
                        if(!is_array($respuestaSRI)){
                            $respOk = true;
                        }else{
                            $error = [
                                'ClaveAcceso'   =>  $item,
                                'mensaje'       =>  'Sin Respuesta'
                            ];
                            array_push($arrayErrores,$error);
                        }
                    }

                    if($respOk){
                        if($respuestaSRI->RespuestaAutorizacionComprobante->numeroComprobantes != 0){
                            $xmlRespuesta = $respuestaSRI->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
                            $xml = new \SimpleXMLElement($xmlRespuesta);
                            $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

                            if($tipoComprobante == 'FACTURA'){
                                $factura = $this->procesarFacturas($xml,$key);
                                array_push($arrayFacturas,$factura);
                                $key++;
                            }elseif($tipoComprobante == 'NOTA DE CRÉDITO'){
                                $nota_credito = $this->procesarNotaCredito($xml,$key);
                                array_push($arrayNotasCredito,$nota_credito);
                                $key++;
                            }elseif($tipoComprobante == 'NOTA DE DÉBITO'){
                                $nota_debito = $this->procesarNotaDebito($xml,$key);
                                array_push($arrayNotasDebito,$nota_debito);
                                $key++;
                            }elseif($tipoComprobante == 'LIQUIDACION DE COMPRA DE BIENES Y PRESTACIÓN DE SERVICIOS'){
                                $liquidacion = $this->procesarLiquidacion($xml,$key);
                                array_push($arrayLiquidaciones,$liquidacion);
                                $key++;
                            }elseif($tipoComprobante == 'COMPROBANTE DE RETENCIÓN'){
                                $retenciones = $this->procesarRetencion($xml,$key);
                                foreach($retenciones as $ret){
                                    array_push($arrayRetenciones,$ret);
                                    $key++;
                                }
                            }
                        }else{
                            $error = [
                                'claveAcceso'   =>  $item,
                                'mensaje'       =>  'El archivo no tiene autorizaciones relacionadas'
                            ];
                            array_push($arrayErrores,$error);
                        }
                    }
                }
            }
            $respuestas = [
                'facturas'      =>  $arrayFacturas,
                'notas_credito' =>  $arrayNotasCredito,
                'notas_debito'  =>  $arrayNotasDebito,
                'retenciones'   =>  $arrayRetenciones,
                'liquidaciones' =>  $arrayLiquidaciones,
                'errores'       =>  $arrayErrores
            ];
            return $respuestas;

        }catch(Exception $e){
            return $e;
        }
    }

    public function procesarFacturas($xml,$key)
    {
        $tarifaDifCero = 0;
        $iva = 0;
        $tarifaCero = 0;
        $totalConImpuestos = $xml->infoFactura->totalConImpuestos->totalImpuesto;

        foreach($totalConImpuestos as $item){
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 2){
                $tarifaDifCero += (string)$item->baseImponible;
                $iva += (string)$item->valor;
            }
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 0){
                $tarifaCero += (string)$item->baseImponible;
            }
        }

        $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

        $factura = [
            'key'               =>  $key,
            'nroComprobante'    =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
            'ruc'               =>  (string) $xml->infoTributaria->ruc,
            'razonSocial'       =>  (string) $xml->infoTributaria->razonSocial,
            'tipoComprobante'   =>  $tipoComprobante,
            'fechaEmision'      =>  (string) $xml->infoFactura->fechaEmision,
            'claveAcceso'       =>  (string) $xml->infoTributaria->claveAcceso,
            'subTotal'          =>  (string) $xml->infoFactura->totalSinImpuestos,
            'descuento'         =>  (string) $xml->infoFactura->totalDescuento,
            'tarifaDifCero'     =>  $tarifaDifCero,
            'tarifaCero'        =>  $tarifaCero,
            'iva'               =>  $iva,
            'importeTotal'      =>  (string) $xml->infoFactura->importeTotal,
        ];

        return $factura;
    }

    public function procesarNotaCredito($xml,$key)
    {
        $tarifaDifCero = 0;
        $iva = 0;
        $tarifaCero = 0;
        $totalConImpuestos = $xml->infoNotaCredito->totalConImpuestos->totalImpuesto;

        foreach($totalConImpuestos as $item){
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 2){
                $tarifaDifCero += (string)$item->baseImponible;
                $iva += (string)$item->valor;
            }
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 0){
                $tarifaCero += (string)$item->baseImponible;
            }
        }

        $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

        $notaCredito = [
            'key'               =>  $key,
            'nroComprobante'    =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
            'ruc'               =>  (string) $xml->infoTributaria->ruc,
            'razonSocial'       =>  (string) $xml->infoTributaria->razonSocial,
            'tipoComprobante'   =>  $tipoComprobante,
            'fechaEmision'      =>  (string) $xml->infoNotaCredito->fechaEmision,
            'claveAcceso'       =>  (string) $xml->infoTributaria->claveAcceso,
            'subTotal'          =>  (string) $xml->infoNotaCredito->totalSinImpuestos,
            'tarifaDifCero'     =>  $tarifaDifCero,
            'tarifaCero'        =>  $tarifaCero,
            'iva'               =>  $iva,
            'importeTotal'      =>  (string) $xml->infoNotaCredito->valorModificacion,
        ];

        return $notaCredito;
    }

    public function procesarNotaDebito($xml,$key)
    {
        $tarifaDifCero = 0;
        $iva = 0;
        $tarifaCero = 0;
        $totalConImpuestos = $xml->infoNotaDebito->totalConImpuestos->totalImpuesto;

        foreach($totalConImpuestos as $item){
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 2){
                $tarifaDifCero += (string)$item->baseImponible;
                $iva += (string)$item->valor;
            }
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 0){
                $tarifaCero += (string)$item->baseImponible;
            }
        }

        $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

        $notaDebito = [
            'key'               =>  $key,
            'nroComprobante'    =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
            'ruc'               =>  (string) $xml->infoTributaria->ruc,
            'razonSocial'       =>  (string) $xml->infoTributaria->razonSocial,
            'tipoComprobante'   =>  $tipoComprobante,
            'fechaEmision'      =>  (string) $xml->infoNotaDebito->fechaEmision,
            'claveAcceso'       =>  (string) $xml->infoTributaria->claveAcceso,
            'subTotal'          =>  (string) $xml->infoNotaDebito->totalSinImpuestos,
            'tarifaDifCero'     =>  $tarifaDifCero,
            'tarifaCero'        =>  $tarifaCero,
            'iva'               =>  $iva,
            'importeTotal'      =>  (string) $xml->infoNotaDebito->valorModificacion,
        ];

        return $notaDebito;
    }

    public function procesarRetencion($xml,$key)
    {
        $compRetencion = [];
        $impuestos = $xml->impuestos->impuesto;

        foreach($impuestos as $item){
            $tipoImp = 'RENTA';
            if($item->porcentajeRetener == '30.00' || $item->porcentajeRetener == '70.00' || $item->porcentajeRetener == '100.00'){
                $tipoImp = 'IVA';
            }
            $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);
            $retencion = [
                'key'               =>  $key,
                'nroComprobante'    =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
                'ruc'               =>  (string) $xml->infoTributaria->ruc,
                'razonSocial'       =>  (string) $xml->infoTributaria->razonSocial,
                'tipoComprobante'   =>  (string) $tipoComprobante,
                'fechaEmision'      =>  (string) $xml->infoCompRetencion->fechaEmision,
                'claveAcceso'       =>  (string) $xml->infoTributaria->claveAcceso,
                'periodoFiscal'     =>  (string) $xml->infoCompRetencion->periodoFiscal,
                'codigo'            =>  (string) $item->codigo,
                'codigoRet'         =>  (string) $item->codigoRetencion,
                'tipoImp'           =>  (string) $tipoImp,
                'porcRet'           =>  (string) $item->porcentajeRetener,
                'baseImponible'     =>  (string) $item->baseImponible,
                'valorRet'          =>  (string) $item->valorRetenido,
            ];
            array_push($compRetencion,$retencion);
            $key++;
        }

        return $compRetencion;
    }

    public function procesarLiquidacion($xml,$key)
    {
        $tarifaDifCero = 0;
        $iva = 0;
        $tarifaCero = 0;
        $totalConImpuestos = $xml->infoLiquidacionCompra->totalConImpuestos->totalImpuesto;

        foreach($totalConImpuestos as $item){
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 2){
                $tarifaDifCero += (string)$item->baseImponible;
                $iva += (string)$item->valor;
            }
            if((string)$item->codigo == 2 && (string)$item->codigoPorcentaje == 0){
                $tarifaCero += (string)$item->baseImponible;
            }
        }

        $tipoComprobante = $this->devolverTipoComprobante((string) $xml->infoTributaria->codDoc);

        $factura = [
            'key'                           =>  $key,
            'nroComprobante'                =>  (string) $xml->infoTributaria->estab .'-'. $xml->infoTributaria->ptoEmi .'-'. $xml->infoTributaria->secuencial,
            'ruc'                           =>  (string) $xml->infoTributaria->ruc,
            'razonSocial'                   =>  (string) $xml->infoTributaria->razonSocial,
            'tipoComprobante'               =>  $tipoComprobante,
            'fechaEmision'                  =>  (string) $xml->infoLiquidacionCompra->fechaEmision,
            'claveAcceso'                   =>  (string) $xml->infoTributaria->claveAcceso,
            'subTotal'                      =>  (string) $xml->infoLiquidacionCompra->totalSinImpuestos,
            'descuento'                     =>  (string) $xml->infoLiquidacionCompra->totalDescuento,
            'tarifaDifCero'                 =>  $tarifaDifCero,
            'tarifaCero'                    =>  $tarifaCero,
            'iva'                           =>  $iva,
            'importeTotal'                  =>  (string) $xml->infoLiquidacionCompra->importeTotal,
            'totalComprobanteReembolso'     =>  (string) $xml->infoLiquidacionCompra->totalComprobantesReembolso,
            'totalBaseImponibleReembolso'   =>  (string) $xml->infoLiquidacionCompra->totalBaseImponibleReembolso,
            'totalImpuestoReembolso'        =>  (string) $xml->infoLiquidacionCompra->totalImpuestoReembolso,
        ];

        return $factura;
    }

    public function autorizarComprobanteSRI($clave)
    {
        $webAutoriza = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
        $parametrosAutoriza = array("claveAccesoComprobante" => $clave);

        try{
            $webServiceAutorizacion = new \SoapClient($webAutoriza);
            $result = $webServiceAutorizacion->autorizacionComprobante($parametrosAutoriza);
        }catch(\SoapFault $e){
            //$result =  $e->getMessage();
            $result =  [];

        }
        return $result;
    }

    public function devolverTipoComprobante($codDoc)
    {
        $respuesta = '';
        switch ($codDoc) {
            case '01':
                $respuesta = 'FACTURA';
                break;
            case '03':
                $respuesta = 'LIQUIDACION DE COMPRA DE BIENES Y PRESTACIÓN DE SERVICIOS';
                break;
            case '04':
                $respuesta = 'NOTA DE CRÉDITO';
                break;
            case '05':
                $respuesta = 'NOTA DE DÉBITO';
                break;
            case '06':
                $respuesta = 'GUIA DE REMISIÓN';
                break;
            case '07':
                $respuesta = 'COMPROBANTE DE RETENCIÓN';
                break;
        }
        return $respuesta;
    }

    public function comprobarComprobanteSRI($claveAcceso)
    {
        $servicio = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"; //url del servicio
        $parametros = array(); //parametros de la llamada
        $parametros['claveAccesoComprobante'] = $claveAcceso;

        $client = new \nusoap_client($servicio);
        $error = $client->getError();
        $client->soap_defencoding = 'utf-8';
        $result = $client->call("autorizacionComprobante", $parametros, "http://ec.gob.sri.ws.autorizacion");
        $response = array();

        return $result;
    }
}
