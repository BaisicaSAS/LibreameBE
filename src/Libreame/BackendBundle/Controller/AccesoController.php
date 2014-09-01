<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonDecoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

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
    private $pSession;
    private $pFechaHora;
    private $pDevice;
    private $pIPaddr;
    private $pAccion;
    private $pURLAccion;
    private $pUsuario;
    private $pClave;
    /*
     * Index
     */
    public function indexAction($name)
    {
        return $this->render('LibreameBackendBundle:Default:index.html.twig', array('name' => $name));
    }
    /*
     * Ingresar es la funcion que recibe la información desde el cliente, para revisar y despachar
     * Recibe un JSON, con la estructura definida como default mas los datos especificos de cada opcion.
     * 
     * @TODO: Es la mas importante para la integración con otros sistemas::
     */
    public function ingresarAction($datos)
    {
        //Se evalúa si se logró obtener la información de sesion desde el JSON
        if (descomponerJsonAction($datos) != false) {
            return $this->render($pURLAccion);
        } else {
            return false;
        }
    }
    /*
     * Descomponer: 
     * Funcion que extrae la informacion del JSON de ingresar
     * {"idsesion":{["idtrx": "ses", "fecha": "fechahora", "device": "Dispositivo", "ipaddr": "IP Address", 
     *               "idaccion": "accion", "usuario": "usuario", "idusuario": "clave"]},
     * 
     *  "data":{[]}
     * }
     */
    public function descomponerJsonAction($datos)
    {
        try {
            $json_datos = JsonDecode($datos);

            $this->pSession = $json_datos['idsesion']['idtrx'];
            $this->pFechaHora = $json_datos['idsesion']['fecha'];
            $this->pDevice = $json_datos['idsesion']['device'];
            $this->pIPaddr = $json_datos['idsesion']['ipaddr'];
            $this->pAccion = $json_datos['idsesion']['idaccion'];
            $this->pURLAccion = getURLAccion($this->pAccion);
            $this->pUsuario = $json_datos['idsesion']['usuario'];
            $this->pClave = $json_datos['idsesion']['clave'];

            return $this;
        } catch (Exception $ex) {
            return false;
        }     
    }
    /*
     * Obtiene la URL que se está tratando de ejecutar.
     */
    public function getURLAccion($accion)
    {
        switch ($accion){
            case 1: return '/registro/{data}';          //Permite hacer una solicitud de registro en el sistema
            case 2: return '/login/{data}';             //solicitud de ingreso al sistema y generación de sesión.
            case 3: return '/editpref/{data}';          //editar preferencias del usuario.
            case 4: return '/realizarsolicitud/{data}'; //realiza una solicitud de Libros.
            case 5: return '/ofrecerejemplar/{data}';   //ofrece un ejemplar de un libro que posee
            case 6: return '/registraactividad/{data}'; //Registra actividad de comentarios dentro de un hilo: Preguntas: respuestas: Negociación
            case 6: return '/editaactividad/{data}';    //Edita o elimina actividad de comentarios dentro de un hilo: Preguntas: respuestas: Negociación
            case 6: return '/aceptanegocio/{data}';     //Acepta la oferta generada por un usuario
            case 6: return '/rechazanegocio/{data}';    //Rechaza la oferta generada por un usuario
            case 6: return '/recibenotificacion/{data}';//Registra actividad de comentarios dentro de un hilo: Preguntas: respuestas: Negociación
                
        }
            
    }
    /*
     * validaSesion 
     * Valida los datos de la sesion verificando que sea veridica
     * Credenciales está compuesto por: 1.usr,2.pass,3-device,4.session,5-opcion a despachar,
     * parametros para la url a despachar, cantidad de caracteres de cada uno 
     * de los anteriores cada uno con 4 digitos.
     * 
     */
    public function validaSesionAction($credenciales)
    {   
        $tamanos = substr($credenciales, strlen($credenciales)-21);
        
        echo $tamanos;
        
    }
    /*
     * GeneraSesion 
     * Guarda en BD y Devuelve el ID de la sesion
     * Recibe una cadena con los datos del usuario
     * Usuario/Password{cifrado}/FechaHora{Esta se guarda en el dispositivo para que sirva como clave}
     * Id/nombre dispositivo
     *  
     */
    public function generaSesionAction($credenciales)
    {
        return $this->render('LibreameBackendBundle:Default:index.html.twig', array('name' => $credenciales));
    }
    /*
     * eliminaSesion 
     *  Elimina una sesion 
     */
    public function eliminaSesionAction($credenciales)
    {
        return $this->render('LibreameBackendBundle:Default:index.html.twig', array('name' => $credenciales));
    }
    /*
     * registraBitacora 
     *  registra cada una de las acciones realizadas por un usuario
     */
    public function registraBitacora()
    {
        return $this->render('LibreameBackendBundle:Default:index.html.twig', array('name' => $credenciales));
    }
}
