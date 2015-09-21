<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Libreame\BackendBundle\Helpers\Logica;
use Libreame\BackendBundle\Helpers\Solicitud;
use Libreame\BackendBundle\Helpers\Respuesta;
use Libreame\BackendBundle\Entity\LbEjemplares;
use Libreame\BackendBundle\Entity\LbLibros;
use Libreame\BackendBundle\Entity\LbGeneros;
/*
 * Controlador que contiene las funciones que validan, controlan y despachan 
 * el acceso a todas las url. Esto implica la generacion y validacion de Tokens
 * Las funciones involucradas:
 * GenerarSesion / EliminarSesion / VerificarAcceso / DespacharOpcion / Cifrar-Descifrar comunicaciones
 * Alta y Baja de usuarios / Recuperacion y cambio de clave
 * 
 * La información que recibe en formato JSON es la siguiente:
 * 
 * 
 *  
 */
class AccesoController extends Controller
{   
    //Constantes globales
    const inFallido =  0; //Proceso fallido
    const inDescone = -1; //Proceso fallido por conexión de plataforma
    const inExitoso =  1; //Proceso existoso
    const inDatoCer =  0; //Valor cero: Sirve para los datos Inactivo, Cerrado etc del modelo
    const inDatoUno =  1; //Valor Uno: Sirve para los datos Activo, Abierto, etc del modelo
    const inGenSinE =  2; //Genero del usuario: Sin especificar
    const inGenFeme =  1; //Genero del usuario: Femenino
    const inGenMasc =  0; //Genero del usuario: Masculino
    const inTamVali =  40; //Tamaño del ID para confirmacion del Registro
    const inTamSesi =  30; //Tamaño del id de sesion generado
    const inJsonInv = -10; //Datos inconsistentes
    const txMensaje =  'Solicitud de registro de usuario en Ex4Read'; //Mensaje estandar para el registro de usuario
    const txMenNoId =  'Sin identificar'; //Mensaje estandar para datos sin identificar
    //Estados del usuario
    const inUsuConf =  0; //Usuario en proceso de confiormacion de registro
    const inUsuActi =  1; //Usuario Activo
    const inUsuCuar =  2; //Usuario en cuarentena
    const inInactiv =  3; //Usuario inactivo
    //Estados de sesion
    const inSesActi =  1; //Usuario en proceso de confiormacion de registro
    const inSesInac =  0; //Usuario Activo
    

    
    //Acciones de la plataforma
    const txAccRegistro =  '1'; //Registro en el sistema
    const txAccIngresos =  '2'; //Login  (Ingreso)
    const txAccRecParam =  '3'; //Recuperar datos y parámetros de usuario: incluye calificaciones
    const txAccRecFeeds =  '4'; //Recuperar Feed (Todas las publicaciones de solicitudes y publicaciones de usuarios)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccRecOpera =  '5'; //Recuperar mi operación (Todas mis solicitudes publicaciones y mensajes)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccConfRegi =  '6'; //Confirmacion Registro en el sistema        
    const txAccRecEjemp =  '7'; //Recuperar Ejemplar        
    const txAccRecSolic =  '8'; //Recuperar solicitud
    const txAccRecUsuar =  '9'; //Ver/Recuperar usuario: Incluye su calificacion
    
    const txAccCerraSes =  '10'; //Logout / Cerrar sesion
    const txAccBajaSist =  '11'; //Dar de baja
    const txAccActParam =  '12'; //Actualizar parámetros sistema y datos usuario
    const txAccPubliEje =  '13'; //Publicar un ejemplar
    const txAccModifEje =  '14'; //Modificar un ejemplar
    const txAccElimiEje =  '15'; //Eliminar un ejemplar
    const txAccPubliSol =  '16'; //Publicar una solicitud
    const txAccModifSol =  '17'; //Modificar una solicitud
    const txAccElimiSol =  '18'; //Eliminar una solicitud
    const txAccPubMensa =  '19'; //Enviar un mensaje a una solicitud especifica / Publicar o Responder
    const txAccConcNego =  '20'; //Concretar una negociación: Aceptar un usuario y descartar a los demás
    const txAccDesiNego =  '21'; //Desistir de una negociación ya realizada
    const txAccCaliTrat =  '22'; //Calificar un trato
    const txAccModCalTr =  '23'; //Modificar calificación trato
    const txAccEnviaPQR =  '24'; //Enviar una PQR
    const txAccModifPQR =  '25'; //Modificar una PQR
    const txAccElimiPQR =  '26'; //Eliminar una PQR

    const txEjemplarPub =  'P'; //Indica que es el ejemplar a publicar de la solicitud
    const txEjemplarSol =  'S'; //Indica que es el ejemplar a Solicitar de la solicitud

    //Constantes de la funcion Login
    const inUsClInv =  0;  //Usuario o clave inválidos
    const inULogged =  1;  //Usuario logeado exitosamente
    const inPlatCai = -1; //Proceso fallido por conexión de plataforma
    const inUSeActi = -2; //Usuario tiene sesion activa
    const inSosAtaq = -3; //Sesion sospechosa de ser ataque ::: AUN NO SE IMPLEMENTA
    const inUsInact = -4; //Usuario inactivo
    const inUsSeIna = -5; //Sesión inactiva

    const inIdGeneral = 1; //Id General para datos basicos :: Genero, Lugar, Grupo 

    var $objSolicitud;
    /*
     * IngresarSistema es la UNICA funcion que recibe la información desde el cliente, para revisar y despachar
     * Recibe un JSON, con la estructura definida como default mas los datos especificos de cada opcion.
     * 
     * @TODO: Es la mas importante para la integración con otros sistemas:: 
     * Cualquier aplicación -por lo pronto las nuestras- solo acceden por esta funcion, el resto de 
     * funciones del sistema son privadas

     * La funcion recibe los datos de la interacción con el cliente.
     * Su funcion es obtener la información de Usuario, Session y Opciones, validar que sean correctos o que 
     * no estén repetidos. Registra el intento de acceso, valida los datos adicionales con respecto
     * a la accion solicitada y en caso de estar todo en orden enviar la información a la Clase Logica para 
     * que realice los solicitado y emita las respuestas al cliente
     * Tambien es la responsable de generar todas las bitacoras de la aplicación
     */
    public function ingresarSistemaAction()
    {   
        $request = $this->getRequest();
        $content = $request->getContent();
        $datos = json_decode($content, true);
        $em = $this->getDoctrine()->getManager();
        
        $respuesta = 0;
        $fecha = new \DateTime;
        $texto = $fecha->format('YmdHis');
        //Aquí iniciaría el código en producción, el bloque anterior solo funciona para TEST
        //Se evalúa si se logró obtener la información de sesion desde el JSON
        $jsonValido = $this->descomponerJson($datos);
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
            } else {
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
        }    
             
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
                    case self::txAccRegistro: { //Dato:1
                        //echo "<script>alert('ENTRA POR REGISTRO')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setTelefono($json_datos['idsolicitud']['telefono']);
                        break;
                    }
                    case self::txAccIngresos : { //Dato:2
                        //echo "<script>alert('ENTRA POR LOGIN')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        break;
                    }
                    case self::txAccRecParam: { //Dato:3
                        //echo "<script>alert('ENTRA POR OBT PARAM')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        break;
                    }
                    case self::txAccRecFeeds: { //Dato:4
                        //echo "<script>alert('ENTRA POR FEED')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setUltEjemplar($json_datos['idsolicitud']['ultejemplar']);
                        break;
                    }
                    case self::txAccPubliEje: { //Dato:13
                        //echo "<script>alert('ENTRA POR PUBLICAR')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setTitulo($json_datos['idsolicitud']['titulo']);
                        $this->objSolicitud->setIdLibro($json_datos['idsolicitud']['idlibro']);
                        $this->objSolicitud->setTipopublica($json_datos['idsolicitud']['tipopublica']);
                        $this->objSolicitud->setIdioma($json_datos['idsolicitud']['idioma']);
                        $this->objSolicitud->setAvaluo($json_datos['idsolicitud']['avaluo']);

                        $this->objSolicitud->setTituloSol($json_datos['idsolicitud']['titulosol']);
                        $this->objSolicitud->setIdLibroSol($json_datos['idsolicitud']['idlibrosol']);
                        $this->objSolicitud->setValAdicSol($json_datos['idsolicitud']['valadicsol']);
                        $this->objSolicitud->setValOferSol($json_datos['idsolicitud']['valofersol']);
                        $this->objSolicitud->setTransacSol($json_datos['idsolicitud']['transacsol']);
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
                    case self::txAccRegistro: { //Dato:1
                        //echo "<script>alert('VAL ENTRA POR REGISTRO')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']) 
                                and isset($datos['idsolicitud']['telefono']));
                        break;
                    }
                    case self::txAccIngresos : { //Dato:2
                        //echo "<script>alert('VAL ENTRA POR LOGIN')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }
                    case self::txAccRecParam: { //Dato:3
                        //echo "<script>alert('VAL ENTRA POR OBT PARAM')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }
                    case self::txAccRecFeeds: { //Dato:4
                        //echo "<script>alert('VAL ENTRA POR FEED')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']) 
                                and isset($datos['idsolicitud']['ultejemplar']));
                        break;
                    }
                    case self::txAccPubliEje: { //Dato:13
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
