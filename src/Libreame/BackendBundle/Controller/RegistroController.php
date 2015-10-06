<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/*
 * Controlador que contiene las funciones que permiten que un usuario valide su 
 * registro en el sistema, incluye el despliegue de la url, la captura de la clave,
 * la activacion del usuario y el envio del correo que indica que se activó o no, 
 * con todas las validaciones que implique
 *  
 */
class RegistroController extends Controller
{    

    //var $objSolicitud;

    public function confirmarRegistroAction($id)
    {   
        /*1. Separar usuario, e ID
        2. Validar que sean coherentes y que el usuario ya no se encuentre activo
        3. Marcar el usuario como activo
        4. Cambiar en la BD el ID. 
        5. Crear los registros en movimientos y bitacoras.
        6. Finalizar y mostrar web de confirmación.*/
        
        return $this->render('LibreameBackendBundle:Registro:confirmarRegistro.html.twig', array('id' => $id));
        /*$request = $this->getRequest();
        $content = $request->getContent();
        $datos = json_decode($content, true);
        $em = $this->getDoctrine()->getManager();
        
        $respuesta = 0;
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;
        $texto = $fecha->format('YmdHis');*/
        //Aquí iniciaría el código en producción, el bloque anterior solo funciona para TEST
        //Se evalúa si se logró obtener la información de sesion desde el JSON
        /*$jsonValido = $this->descomponerJson($datos);
        try {
            //echo "<script>alert('Validación retornó: ".$jsonValido."')</script>"; 
            if ($jsonValido != self::inJsonInv) {
                //echo "<script>alert('Ejecuta accion ')</script>"; 
                //$objLogica = $this->get('logica_service')->container->setParameter("@doctrine.orm.default_entity_manager", $em);
                //$objLogica = new Logica($em);
                $objLogica = $this->get('logica_service');
                //$objLogica = new Logica($em);
                //$objLogica = $this->get('logica_service')->container->setParameter("@doctrine.orm.default_entity_manager", $em);
                $respuesta = $objLogica::ejecutaAccion($this->objSolicitud);
            } else { //JSON INVALIDO RESPUESTA GENERAL : -10
                //echo "<script>alert('.......ELSE..........')</script>";
                $objLogica = $this->get('logica_service');
                $jrespuesta = new Respuesta();
                $jrespuesta->setRespuesta($jsonValido);    
                $respuesta = json_encode($objLogica::respuestaGenerica($jrespuesta, $this->objSolicitud));
               //echo "<script>alert('Encontramos un problema con tu registro: ".$this->$objSolicitud->getSession()."-".$jsonValido."')</script>"; 
                //@TODO: Debemos revisar que hacer cuando se detecta actividad sospechosa: Cierro sesion?. Bloqueo usuario e informo?
            }
            //echo "<script>alert('RESPUESTA ingresarSistemaAction: ".$respuesta."')</script>"; 

            return new RESPONSE($respuesta);
            //return new RESPONSE("Normal ".$datos);
                    
        } catch (Exception $ex) {
            return new RESPONSE($jsonValido);
        } */   
             
    }
    
    /*
     * Descomponer: 
     * Funcion que extrae la informacion del JSON de ingresar
     * 1. Opción Solicitada
     * 2. Usuario
     * 3. Sesión
     * 4. IP
     * 5. Id del dispositivo: MAC
     * 6. Marca del dispositivo
     * 7. Modelo del dispositivo
     * 8. Sistema operativo del dispositivo 
     * {"idsesion":{["idaccion": "accion", "usuario": "usuario", "idtrx": "sesion", "ipaddr": "IP Address", 
     *              "iddevice": "MAC Dispositivo", "marca": "Marca Dispositivo", "modelo": "Modelo Dispositivo", 
     *              "so": "Sistema operativo Dispositivo"]},
     * 
     *  "idsolicitud":{[]}
     * }
     */
    private function descomponerJson($datos)
    {   
        try {
            //$json_datos = json_decode($datos, true);
            $json_datos = $datos;
            //echo "<script>alert('Inicia a decodificar-----".$json_datos['idsesion']['idtrx']."')</script>"; 
            $this->objSolicitud = new Solicitud();
            //echo "<script>alert('VALIDARA')</script>";
            $estrValida = $this->estructuraCorrecta($datos);
            //echo "<script>alert('VALIDADO COMO: ".$estrValida ? 'true' : 'false'."')</script>";

            if ($estrValida)
            {    
                //echo "<script>alert(':::TRANS: ".$json_datos['idsesion']['idtrx']."')</script>"; 
                //echo "<script>alert(':::TRANS: ')</script>"; 
                $resp = self::inExitoso;
                $this->objSolicitud->setAccion($json_datos['idsesion']['idaccion']);
                $this->objSolicitud->setSession($json_datos['idsesion']['idtrx']);
                $this->objSolicitud->setIPaddr($json_datos['idsesion']['ipaddr']);
                $this->objSolicitud->setDeviceMAC($json_datos['idsesion']['iddevice']);
                $this->objSolicitud->setDeviceMarca($json_datos['idsesion']['marca']);
                $this->objSolicitud->setDeviceModelo($json_datos['idsesion']['modelo']);
                $this->objSolicitud->setDeviceSO($json_datos['idsesion']['so']);
                //Según la solicitud descompone el JSON
                $tmpSesion = $this->objSolicitud->getAccion();
                //echo "<script>alert('ult ejemplar ".$json_datos['idsolicitud']['ultejemplar']."')</script>";
                //echo "<script>alert('sesion ".$tmpSesion."')</script>";
                switch ($tmpSesion){
                    case self::txAccRegistro: { //Dato:1: Registro en el sistema
                        //echo "<script>alert('ENTRA POR REGISTRO')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setTelefono($json_datos['idsolicitud']['telefono']);
                        break;
                    }
                    case self::txAccIngresos : { //Dato:2: Login
                        //echo "<script>alert('ENTRA POR LOGIN')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        break;
                    }
                    case self::txAccRecParam: { //Dato:3 : Recuperar datos de Usuario (Propios)
                        //echo "<script>alert('ENTRA POR OBT PARAM')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        break;
                    }
                    case self::txAccRecFeeds: { //Dato:4 : Recuperar Feed de ejemplares
                        //echo "<script>alert('ENTRA POR FEED')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setUltEjemplar($json_datos['idsolicitud']['ultejemplar']);
                        break;
                    }
                    case self::txAccCerraSes: { //Dato:10 : Cerrar sesion
                        //echo "<script>alert('ENTRA POR CERRAR SESION')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        break;
                    }
                    case self::txAccPubliEje: { //Dato:13 : Publicar un ejemplar
                        //echo "<script>alert('ENTRA POR PUBLICAR')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setIdOferta($json_datos['idsolicitud']['idoferta']);
                        $this->objSolicitud->setTitulo($json_datos['idsolicitud']['titulo']);
                        $this->objSolicitud->setIdLibro($json_datos['idsolicitud']['idlibro']);
                        $this->objSolicitud->setIdioma($json_datos['idsolicitud']['idioma']);
                        $this->objSolicitud->setAvaluo($json_datos['idsolicitud']['avaluo']);
                        $this->objSolicitud->setValventa($json_datos['idsolicitud']['valventa']);

                        $this->objSolicitud->setTituloSol1($json_datos['idsolicitud']['titulosol1']);
                        $this->objSolicitud->setIdLibroSol1($json_datos['idsolicitud']['idlibrosol1']);
                        $this->objSolicitud->setValAdicSol1($json_datos['idsolicitud']['valadicsol1']);
                        $this->objSolicitud->setTituloSol2($json_datos['idsolicitud']['titulosol2']);
                        $this->objSolicitud->setIdLibroSol2($json_datos['idsolicitud']['idlibrosol2']);
                        $this->objSolicitud->setValAdicSol2($json_datos['idsolicitud']['valadicsol2']);
                        $this->objSolicitud->setObservaSol($json_datos['idsolicitud']['observasol']);

                        break;
                    }

                }
                //echo "<script>alert('SESION: ".$this->objSolicitud->getSession().": Finalizó')</script>"; 
                $resp = self::inExitoso;
            } else {
                $resp = self::inJsonInv;
            }   
                
            //echo "<script>alert('Decodificó e instació el objeto')</script>"; 
            return $resp;
        } catch (Exception $ex) {
            return self::inJsonInv;
        }    
    }
    
    private function estructuraCorrecta($datos) 
    {   
        $resp = TRUE;
        //Recupera el ID de la accion
        if (!isset($datos['idsesion']['idaccion'])) {
            //echo "<script>alert('FALTA IDACCION')</script>";
            $resp = FALSE;
        } else {
            //Evalúa todos los datos del ENCABEZADO
            $accion = $datos['idsesion']['idaccion'];
            //echo "<script>alert('ACCION: ".$accion."')</script>"; 
            if (!isset($datos['idsesion']['idtrx'])){ 
                //echo "<script>alert('FALTA IDTRANSACCION: Sesion')</script>";
                $resp = FALSE;
            } elseif (!isset($datos['idsesion']['ipaddr'])) {
                //echo "<script>alert('FALTA IPADDRES')</script>";
                $resp = FALSE;
            } elseif (!isset($datos['idsesion']['iddevice'])) {
                //echo "<script>alert('FALTA DEVICE')</script>";
                $resp = FALSE;
            } elseif (!isset($datos['idsesion']['marca'])) {
                //echo "<script>alert('FALTA MARCA')</script>";
                $resp = FALSE;
            } elseif (!isset($datos['idsesion']['modelo'])) {
                //echo "<script>alert('FALTA MODELO')</script>";
                $resp = FALSE;
            } elseif (!isset($datos['idsesion']['so'])) {
                //echo "<script>alert('FALTA SO')</script>";
                $resp = FALSE;
            } else {
                //Si todos los datos del encabezado están seteados, evalúa según la acción
                switch ($accion){
                    case self::txAccRegistro: { //Dato:1 :  Registro en el sistema
                        //echo "<script>alert('VAL ENTRA POR REGISTRO')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']) 
                                and isset($datos['idsolicitud']['telefono']));
                        break;
                    }
                    case self::txAccIngresos : { //Dato:2 : Login
                        //echo "<script>alert('VAL ENTRA POR LOGIN')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }
                    case self::txAccRecParam: { //Dato:3 : Recuperar datos de Usuario (Propios)
                        //echo "<script>alert('VAL ENTRA POR OBT PARAM')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }
                    case self::txAccRecFeeds: { //Dato:4 : Recuperar Feed de ejemplares
                        //echo "<script>alert('VAL ENTRA POR FEED')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']) 
                                and isset($datos['idsolicitud']['ultejemplar']));
                        break;
                    }
                    case self::txAccCerraSes: { //Dato:10 : Cerrar Sesion
                        //echo "<script>alert('VAL ENTRA POR CERRAR SESION')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }
                    case self::txAccPubliEje: { //Dato:13 : Publicar un Ejemplar
                        //echo "<script>alert('VAL ENTRA POR PUBLICAR')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }
                }
            }
        }
        //echo "<script>alert('VALIDADO COMO: ".$resp ? 'true' : 'false'."')</script>";
        return $resp;
    }

}
