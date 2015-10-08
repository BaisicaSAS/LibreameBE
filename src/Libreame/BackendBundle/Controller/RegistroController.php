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

    private $clave;
    private $usuario;
    const pos1mail = 2;
    const pos2mail = 4;
    const pos3mail = 6;

    const pos1pat = 3;
    const pos2pat = 5;
    const pos3pat = 7;

    public function confirmarRegistroAction($id)
    {   
        
        $this->descomponerDatosEntrada($id);
        /*1. Separar usuario, e ID
        2. Validar que sean coherentes y que el usuario ya no se encuentre activo
        3. Marcar el usuario como activo
        4. Cambiar en la BD el ID. 
        5. Crear los registros en movimientos y bitacoras.
        6. Finalizar y mostrar web de confirmación.*/
        
        
        
        
        return $this->render('LibreameBackendBundle:Registro:confirmarRegistro.html.twig', array('id' => $this->clave, 'usr' => $this->usuario));
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
     * descomponerDatosEntrada: 
     * Obtiene los datos separados de usuario y clave
     */
    private function descomponerDatosEntrada($datos)
    {   
        
        $this->clave='';
        $this->usuario='';
        //Caracteres 8 * 5 * 10  Dan el patron de descubrimiento de la clave. Juan (Patron es datos 1,2,3) CAracteres de corrimiento
        //Caracteres 14 * 9 * 12  Indican la cantidad de datos del correo
        $longdatos = strlen($datos); 
        
        //Obtener el patron de ocurrencia de datos
        $patron = array(substr($datos,$this::pos1pat,1),substr($datos,$this::pos2pat,1),substr($datos,$this::pos3pat,1));
        //Obtener la cantidad de caracteres del correo
        $caracteres = (integer) (substr($datos,$this::pos1mail,1).substr($datos,$this::pos2mail,1).substr($datos,$this::pos3mail,1));
        $pat = 0;
        for ($n=8;$n<$longdatos;$n++) {
            if ($n==8) {
                $posClave[] = $patron[$pat];
            } else {
                $posClave[] = $posClave[$n]+$patron[$pat];
            }
            if ($pat==2) { $pat = 0; } else { $pat++; }
        }
        
        //Recupera el mail del usuario
        for ($i==8;$i<$caracteres;$i++) {
            $this->usuario.=substr($datos,$patron[$i],1);
        }
        
        //Recupera la clave
        for ($i=0;$i<$longdatos;$i++) {
            if (($i < 2) or ($i > 7)) {
                if (!in_array($i,$posClave)) $this->clave.=substr($datos,$i,1);
            }
        }
        
    }
    
}
