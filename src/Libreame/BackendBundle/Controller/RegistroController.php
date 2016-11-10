<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Libreame\BackendBundle\Repository\ManejoDataRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Libreame\BackendBundle\Helpers\Logica;
use Libreame\BackendBundle\Entity\LbUsuarios;

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
        try {
            //$objMDR = $this->get('manejodatos_repo_service');
            //$objLogica = new Logica();
            $this->descomponerDatosEntrada($id);

            $respuesta = $this->validarRegistroUsuario($this->usuario, $this->clave);
            if ($respuesta == AccesoController::inExitoso) {
                return $this->render('LibreameBackendBundle:Registro:confirmarRegistro.html.twig', array('id' => $this->clave, 'usr' => $this->usuario));
            } else {
                return $this->render('LibreameBackendBundle:Registro:failConfirmarRegistro.html.twig', array('usr' => $this->usuario));
            }
        }            
        catch (Exception $ex) {
            return new RESPONSE(-1500);
        }
             
    }
    
    
    /* validarRegistroUsuario: 
     * Funcion que genera realiza la validación del registro de usuario en el sistema, desde el email enviado por ex4read
     */
    public function validarRegistroUsuario($usuario, $clave)
    {
        try {
            $vUsuario = new LbUsuarios();
            $vUsuario = $this->datosUsuarioValidos($usuario, $clave);
            $respuesta = AccesoController::inExitoso;
            if ($vUsuario == NULL) { $respuesta = AccesoController::inFallido; }
            
            if ($respuesta==AccesoController::inExitoso) {
                $respuesta = $this->activarUsuarioRegistro($vUsuario);
            }
            return $respuesta;
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }

    //Valida datos de registro de un usuario
    public function datosUsuarioValidos($usuario, $clave)
    {
        try{
            $em = $this->getDoctrine()->getManager();

            $vUsuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $usuario, 
                        'txusuvalidacion' => $clave, 
                        'inusuestado' => AccesoController::inDatoCer));
            
            $em->flush();
            
            return $vUsuario;

        } catch (Exception $ex) {
                return NULL;
        } 
    }
    
    //Activa un usuario en accion de Validacion de Registro
    public function activarUsuarioRegistro(LbUsuarios $usuario)
    {
        try{
            /*  3. Marcar el usuario como activo
                4. Cambiar en la BD el ID. 
                5. Crear los registros en movimientos y bitacoras.
                6. Finalizar y mostrar web de confirmación.*/
            $respuesta=  AccesoController::inFallido; 
            $fecha = new \DateTime;
            
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();


            $usuario->setInusuestado(AccesoController::inDatoUno);
            $usuario->setTxusuvalidacion($usuario->getTxusuvalidacion().'OK');

            ManejoDataRepository::finalizarRegistroUsuario($usuario, $fecha, $em);    
            
            $em->persist($usuario);
            
            $em->flush();
            $em->getConnection()->commit();
            $respuesta=  AccesoController::inExitoso; 
            
            return $respuesta;

        } catch (Exception $ex) {
                return  AccesoController::inFallido;
        } 
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
        #echo "\n Long Cadena: ".$longdatos.'  ';
        #echo "\n Cadena: ".$datos.'  ';
        //Obtener el patron de ocurrencia de datos
        $patron = array(substr($datos,self::pos1pat,1),substr($datos,self::pos2pat,1),substr($datos,self::pos3pat,1));
        //Obtener la cantidad de caracteres del correo
        $caracteres = (integer) (substr($datos,self::pos1mail,1).substr($datos,self::pos2mail,1).substr($datos,self::pos3mail,1));
        #echo "\nLong Mail: ".$caracteres.'  ';
        $pat = 0;
        #echo "\nPosiciones: ";
        for ($i=0;$i<$caracteres;$i++) {
            if ($i==0) {
                $posClave[$i] = 8 + $patron[$pat];
            } else {
                $posClave[$i] = $posClave[$i-1] + $patron[$pat];
            }
            #echo $i.' : '.$posClave[$i].' - ';
            if ($pat==2) { $pat = 0; } else { $pat++; }
        }
        
        //Recupera el mail del usuario
        for ($i=0;$i<$caracteres;$i++) {
            #echo substr($datos,$posClave[$i],1);;
            $this->usuario.=substr($datos,$posClave[$i],1);
        }

        //echo "\nUSUARIO: [ ".$this->usuario.' ]';
    
        //Recupera la clave
        for ($i=0;$i<$longdatos;$i++) {
            if (!in_array($i,$posClave) and (($i<2) or ($i>7)) ) {
                //echo substr($datos,$i,1);
                $this->clave.=substr($datos,$i,1);
            } //else { echo "\nNo hace parte: ".$i.' - '. substr($datos,$i,1).' ||| ';}
        }
        //echo "  \nCLAVE: [ ".$this->clave.' ]';
    }
    
}
