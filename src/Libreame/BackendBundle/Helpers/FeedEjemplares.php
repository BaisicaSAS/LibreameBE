<?php


namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;

use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbEjemplares;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;
/**
 * Description of Feeds
 *
 * @author mramirez
 */
class FeedEjemplares {
    
    /*
     * feeds 
     * Retorna la lista de todos los ejemplares nuevos cargados en la plataforma. 
     * Solo a partir del ID que envía el cliente (Android), en adelante.
     * Por ahora solo tendrá Ejemplares, luego se evaluará si tambien se cargan TRATOS Cerrados / Ofertas realizadas
     */
    public $ArrEjemplares; //Arreglo de Ejemplares
    private $puntEjemplares; //Puntero para los Ejemplares

    public function setArrFeedEjemplar(LbEjemplares $ejemplar)
    {
        $this->ArrEjemplares[] = $ejemplar;
    }   

    //Bloque otras funciones para arreglos
    public function actualEjemplares ()
    {
        if (! $this->validoEjemplar()) { return false; }
        if (empty($this->ArrEjemplares[$this->puntEjemplares])) { return array(); }
        return $this->ArrEjemplares[$this->puntEjemplares];
    }
    
    public function keyEjemplares()
    {
        return $this->puntEjemplares;
    }
    
    public function siguienteEjemplares()
    {
        return ++ $this->puntEjemplares;
    }
    
    public function redimensionarEjemplares()
    {
        $this->puntEjemplares = 0;
    }
    
    public function validoEjemplares()
    {
	return $this->puntEjemplares !== false;
    }
    
    
    public function cantidadEjemplares()
    {
        return count($this->ArrEjemplares);
    }

    
    public function recuperarFeedEjemplares($psolicitud)
    {   
        $fecha = new \DateTime;
        $respuesta = new Respuesta();
        $objAcceso = $this->get('acceso_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=$objAcceso::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' recuperarFeedEjemplares :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==$objAcceso::inULogged) 
            {    
                //echo "<script>alert(' recuperarFeedEjemplares :: FindAll ')</script>";
                $em = $this->getDoctrine()->getEntityManager();
                //Busca el usuario 
                $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $psolicitud->getEmail()));
                
                //Busca y recupera el objeto de la sesion:: 
                $sesion = $objAcceso::recuperaSesionUsuario($usuario,$psolicitud);
               //echo "<script>alert('La sesion es ".$sesion->getTxsesnumero()." ')</script>";
                //Guarda la actividad de la sesion:: 
                $objAcceso::generaActSesion($sesion,AccesoController::inDatoUno,"Recupera Feed de Ejemplares".$psolicitud->getEmail()." recuperados con éxito ",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                $respuesta->setRespuesta(AccesoController::inExitoso);
                
                //Recupera cada uno de los ejemplares con ID > al del parametro
                $sql = "SELECT e FROM LibreameBackendBundle:LbEjemplares e WHERE e.inejemplar > ".$psolicitud->getUltEjemplar();
                //echo "<script>alert('".$sql."')</script>";
                
                $query = $em->createQuery($sql);
                //$query = $em->createQuery('SELECT e FROM LibreameBackendBundle:LbEjemplares e WHERE e.inejemplar > 1');
                $ejemplares = $query->getResult();
                
            } else {
                $respuesta->setRespuesta($respSesionVali);
                $ejemplares = array();
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inDescone);
            $ejemplares = array();
        } 
        
        //return Logica::generaRespuesta($respuesta, $psolicitud, $this->ArrEjemplares);
        return Logica::generaRespuesta($respuesta, $psolicitud, $ejemplares);
            
       
    }
}
