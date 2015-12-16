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
    const inTamVali =  128; //Tamaño del ID para confirmacion del Registro
    const inTamSesi =  30; //Tamaño del id de sesion generado
    const inJsonInv = -10; //Datos inconsistentes
    const txMensaje =  'Solicitud de registro de usuario en Ex4Read'; //Mensaje estandar para el registro de usuario
    const txMenNoId =  'Sin identificar'; //Mensaje estandar para datos sin identificar
    const txMeNoIdS =  'Pendiente'; //Mensaje estandar para pendiente/Sin identificar, con campo Longitud menor a 10
    //Estados del usuario
    const inUsuConf =  0; //Usuario en proceso de confirmacion de registro
    const inUsuActi =  1; //Usuario Activo
    const inUsuCuar =  2; //Usuario en cuarentena
    const inInactiv =  3; //Usuario inactivo
    //Estados de sesion
    const inSesActi =  1; //Usuario en proceso de confiormacion de registro
    const inSesInac =  0; //Usuario Activo
    const txAnyData =  'ANY'; //String para indicar cualquier usuario
   

    
    //Acciones de la plataforma
    const txAccRegistro =  '1'; //Registro en el sistema
    const txAccIngresos =  '2'; //Login  (Ingreso)
    const txAccRecParam =  '3'; //Recuperar datos y parámetros de usuario: incluye calificaciones
    const txAccRecFeeds =  '4'; //Recuperar Feed (Todas las publicaciones de solicitudes y publicaciones de usuarios)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccRecOpera =  '5'; //Recuperar mis mensajes ...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccConfRegi =  '6'; //Confirmacion Registro en el sistema        
    const txAccBusEjemp =  '7'; //Buscar Ejemplares        
    const txAccRecOfert =  '8'; //Recuperar oferta
    const txAccRecUsuar =  '9'; //Ver/Recuperar usuario: Incluye su calificacion
    
    const txAccCerraSes =  '10'; //Logout / Cerrar sesion
    const txAccBajaSist =  '11'; //Dar de baja
    const txAccActParam =  '12'; //Actualizar parámetros sistema y datos usuario
    const txAccPubliEje =  '13'; //Publicar un ejemplar
    //DEPRECADO: const txAccModifEje =  '14'; //Modificar un ejemplar
    const txAccElimiPub =  '15'; //Eliminar una publicacion
    const txAccVisuaBib =  '16'; //Visualizar Biblioteca
    const txAccModifOfe =  '17'; //Modificar una oferta
    const txAccElimiOfe =  '18'; //Eliminar una oferta
    const txAccPubMensa =  '19'; //Interactuar con oferta::Enviar un mensaje a una solicitud especifica / Publicar o Responder
    //DEPRECADO: const txAccConcNego =  '20'; //Concretar una negociación: Aceptar un usuario y descartar a los demás
    //DEPRECADO: const txAccDesiNego =  '21'; //Desistir de una negociación ya realizada
    const txAccCaliTrat =  '22'; //Calificar un trato
    //DEPRECADO: const txAccModCalTr =  '23'; //Modificar calificación trato
    const txAccEnviaPQR =  '24'; //Enviar una PQR
    const txAccModifPQR =  '25'; //Modificar una PQR
    const txAccElimiPQR =  '26'; //Eliminar una PQR
    
    const txAccSCISBNdb =  '27'; //Servicio de carga de libros desde ISBNdb
    const txAccRecLista =  '28'; //recuperar listas del sistema
    const txAccRecClave =  '29'; //Recuperar clave perdida
    const txAccSolLibro =  '30'; //Solicitar Libro:: Automático
    const txAccModifPub =  '31'; //modificar Publicacion
    const txAccReaOfert =  '32'; //Realizar oferta
    const txAccRecPubli =  '33'; //Recuperar publicacion
    const txAccRecTrato =  '34'; //Recuperar informacion Trato
    const txAccVerCalif =  '35'; //Ver comentarios-calificaciones
    const txAccMarcMens =  '36'; //Marcar mensaje como No leido / Leido
    const txAccListaIdi =  '37'; //Listar idiomas
    const txAccListaLug =  '38'; //Listar lugares

    const txEjemplarPub =  'P'; //Indica que es el ejemplar a publicar de la solicitud
    const txEjemplarSol1 =  'S1'; //Indica que es el ejemplar a Solicitar de la solicitud
    const txEjemplarSol2 =  'S2'; //Indica que es el ejemplar a Solicitar de la solicitud

    //Constantes de la funcion Login
    const inUsClInv =  0;  //Usuario o clave inválidos
    const inULogged =  1;  //Usuario logeado exitosamente
    const inPlatCai = -1; //Proceso fallido por conexión de plataforma
    const inUSeActi = -2; //Usuario tiene sesion activa
    const inSosAtaq = -3; //Sesion sospechosa de ser ataque ::: AUN NO SE IMPLEMENTA
    const inUsInact = -4; //Usuario inactivo
    const inUsSeIna = -5; //Sesión inactiva
    //Constante funcion marcar mensaje
    const inMenNoEx = -6; //Mensaje no existe
    const inMenNoAc = -7; //Mensaje no activo - inactivo

    const inIdGeneral = 1; //Id General para datos basicos :: Genero, Lugar, Grupo
    //
    //Constantes para origen de mensajes:::
    const inMsPubEjem = 0;//Mensaje de publicación de ejemplar
    const inMsRealOfe = 1;//Mensaje de Realización de oferta por ejemplar
    const inMsVerOfAc = 2;//Mensaje de oferta aceptada
    const inMsVerOfRe = 3;//Mensaje de oferta recibida
    const inMsVerComR = 4;//Mensaje de comentario recibido
    const inMsVerCReP = 5;//Mensaje de comentario para responder pregunta
    const inMsVerOfRz = 6;//Mensaje de oferta realizada

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
        error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED );
        $request = $this->getRequest();
        $content = $request->getContent();
        $datos = json_decode($content, true);
        $em = $this->getDoctrine()->getManager();
        
        $respuesta = 0;
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;
        $texto = $fecha->format('YmdHis');*/
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
                //$respuesta = $objLogica::ejecutaAccion($this->objSolicitud);
                $respuesta = Logica::ejecutaAccion($this->objSolicitud);
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
                    case self::txAccRecOpera: { //Dato:5 : RECUPERAR MENSAJES(NOTIFICACIONES)
                        //echo "<script>alert('ENTRA POR RECUPERAR MENSAJES')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        break;
                    }
                    case self::txAccBusEjemp: { //Dato:7 : Buscar Ejemplar
                        //echo "<script>alert('ENTRA POR BUSCAR EJEMPLAR')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setTextoBuscar($json_datos['idsolicitud']['buscar']);
                        break;
                    }
                    case self::txAccRecOfert: { //Dato:8 : Recuperar Oferta
                        //echo "<script>alert('ENTRA POR RECUPERAR OFERTA')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setIdOferta($json_datos['idsolicitud']['idoferta']);
                        break;
                    }
                    case self::txAccRecUsuar: { //Dato:9 : Recuperar Usuario Otro
                        //echo "<script>alert('ENTRA POR RECUPERAR USUARIO OTRO')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setIdUsuarioVer($json_datos['idsolicitud']['idusuariover']);
                        break;
                    }
                    case self::txAccCerraSes: { //Dato:10 : Cerrar sesion
                        //echo "<script>alert('ENTRA POR CERRAR SESION')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        break;
                    }
                    
                    case self::txAccActParam: { //Dato:12 : Actualizar datos parametros usuario
                        //echo "<script>alert('ENTRA POR ACTUALIZAR DATOS USUARIO')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setTelefono($json_datos['idsolicitud']['telefono']);
                        $this->objSolicitud->setNomUsuario($json_datos['idsolicitud']['nomusuario']);
                        $this->objSolicitud->setNomMostUsuario($json_datos['idsolicitud']['nommostusuario']);
                        $this->objSolicitud->setUsuGenero($json_datos['idsolicitud']['usugenero']);
                        $this->objSolicitud->setUsuImagen($json_datos['idsolicitud']['usuimagen']);
                        $this->objSolicitud->setUsuFecNac($json_datos['idsolicitud']['usufecnac']);
                        $this->objSolicitud->setUsuLugar($json_datos['idsolicitud']['usulugar']);
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
                        $this->objSolicitud->setImageneje($json_datos['idsolicitud']['foto']);

                        break;
                    }
                    case self::txAccMarcMens: { //Dato:36 : Marcar mensaje / Leído - No leído
                        //echo "<script>alert('ENTRA POR MARCAR MENSAJES')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        $this->objSolicitud->setIdmensaje($json_datos['idsolicitud']['idmensaje']);
                        $this->objSolicitud->setMarcarcomo($json_datos['idsolicitud']['marcacomo']);
                        break;
                    }
                    case self::txAccListaIdi: { //Dato:37 : Listar Idiomas
                        //echo "<script>alert('ENTRA POR LISTAR DE IDIOMAS')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                        break;
                    }

                    case self::txAccListaLug: { //Dato:38 : Listar Lugares
                        //echo "<script>alert('ENTRA POR LISTAR DE LUGARES')</script>";
                        $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                        $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
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
                    case self::txAccRecOpera: { //Dato:5 : RECUPERAR MENSAJES(NOTIFICACIONES)
                        //echo "<script>alert('ENTRA POR RECUPERAR MENSAJES')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }
                    case self::txAccBusEjemp: { //Dato:7 : Buscar ejemplares
                        //echo "<script>alert('VAL ENTRA POR BUSCAR')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']) 
                                and isset($datos['idsolicitud']['buscar']));
                        break;
                    }
                    case self::txAccRecOfert: { //Dato:8 : Recuperar Oferta
                        //echo "<script>alert('ENTRA POR RECUPERAR OFERTA')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave'])
                                 and isset($datos['idsolicitud']['idoferta']));
                        break;
                    }
                    case self::txAccRecUsuar: { //Dato:9 : Recuperar Usuario Otro
                        //echo "<script>alert('VAL ENTRA POR RECUPERAR USUARIO OTRO')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave'])
                                 and isset($datos['idsolicitud']['idusuariover']));
                        break;
                    }
                    case self::txAccCerraSes: { //Dato:10 : Cerrar Sesion
                        //echo "<script>alert('VAL ENTRA POR CERRAR SESION')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }
                    case self::txAccActParam: { //Dato:12 : Actualizar datos parametros usuario
                        //echo "<script>alert('ENTRA POR ACTUALIZAR DATOS USUARIO')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']) and 
                                isset($datos['idsolicitud']['telefono']) and 
                                isset($datos['idsolicitud']['nomusuario']) and  isset($datos['idsolicitud']['nommostusuario']) and 
                                isset($datos['idsolicitud']['usugenero']) and  isset($datos['idsolicitud']['usuimagen']) and 
                                isset($datos['idsolicitud']['usufecnac']) and  isset($datos['idsolicitud']['usulugar']));
                        break;
                    }
                    case self::txAccPubliEje: { //Dato:13 : Publicar un Ejemplar
                        //echo "<script>alert('VAL ENTRA POR PUBLICAR')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']) and 
                                  isset($datos['idsolicitud']['idoferta']) and  isset($datos['idsolicitud']['titulo']) and 
                                 isset($datos['idsolicitud']['idlibro']) and  isset($datos['idsolicitud']['idioma']) and 
                                 isset($datos['idsolicitud']['avaluo']) and  isset($datos['idsolicitud']['valventa']) and 
                                 isset($datos['idsolicitud']['titulosol1']) and  isset($datos['idsolicitud']['idlibrosol1']) and 
                                 isset($datos['idsolicitud']['valadicsol1']) and  isset($datos['idsolicitud']['titulosol2']) and 
                                 isset($datos['idsolicitud']['idlibrosol2']) and  isset($datos['idsolicitud']['valadicsol2']) and 
                                 isset($datos['idsolicitud']['observasol']) and isset($datos['idsolicitud']['foto']));
                        break;
                    }
                    case self::txAccMarcMens: { //Dato:36 : Marcar mensaje / Leído - No leído
                        //echo "<script>alert('VAL ENTRA POR MARCAR MENSAJES')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']) and
                                isset($datos['idsolicitud']['idmensaje']) and isset($datos['idsolicitud']['marcacomo']));
                        break;
                    }
                    case self::txAccListaIdi: { //Dato:37 : LISTAR IDIOMAS
                        //echo "<script>alert('ENTRA POR LISTAR IDIOMAS')</script>";
                        $resp = (isset($datos['idsolicitud']['email']) and isset($datos['idsolicitud']['clave']));
                        break;
                    }

                    case self::txAccListaLug: { //Dato:38 : LISTAR LUGARES
                        //echo "<script>alert('ENTRA POR LISTAR LUGARES')</script>";
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