<?php


namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Libreame\BackendBundle\Repository\ManejoDataRepository;


use Libreame\BackendBundle\Entity\LbLibros;
use Libreame\BackendBundle\Entity\LbIdiomas;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbEjemplares;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;
use Libreame\BackendBundle\Entity\LbOfertas;
use Libreame\BackendBundle\Entity\LbGeneroslibros;
/**
 * Description of Feeds
 *
 * @author mramirez
 */
class GestionEjemplares {
    
    /*
     * feeds 
     * Retorna la lista de todos los ejemplares nuevos cargados en la plataforma. 
     * Solo a partir del ID que envía el cliente (Android), en adelante.
     * Por ahora solo tendrá Ejemplares, luego se evaluará si tambien se cargan TRATOS Cerrados / Ofertas realizadas
     */
    
    public function recuperarFeedEjemplares(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        $ejemplares = new LbEjemplares();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' recuperarFeedEjemplares :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //echo "<script>alert(' recuperarFeedEjemplares :: FindAll ')</script>";
                //Busca el usuario 
                $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
                
                //$membresia= ManejoDataRepository::getMembresiasUsuario($usuario);
                
                //echo "<script>alert('MEM ".count($membresia)." regs ')</script>";
                
                $grupo= ManejoDataRepository::getObjetoGruposUsuario($usuario);

                $arrGru = array();
                foreach ($grupo as $gru){
                    $arrGru[] = $gru->getIngrupo();
                }


                $ejemplares = ManejoDataRepository::getEjemplaresDisponibles($arrGru, $psolicitud->getUltEjemplar());
                $respuesta->setRespuesta(AccesoController::inExitoso);

                //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                //Busca y recupera el objeto de la sesion:: 
                //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                //echo "<script>alert('La sesion es ".$sesion->getTxsesnumero()." ')</script>";
                //Guarda la actividad de la sesion:: 
                //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Recupera Feed de Ejemplares".$psolicitud->getEmail()." recuperados con éxito ",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $ejemplares);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                $ejemplares = array();
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $ejemplares);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            $ejemplares = array();
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $ejemplares);
        }
       
    }
    
    public function publicarEjemplar(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' recuperarFeedEjemplares :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Genera la oferta para el ejemplar
                $respuesta = ManejoDataRepository::generarOfertaEjemplar($psolicitud);
                $respuesta->setRespuesta($respSesionVali);
                
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
        }
       
    }

    
    public function buscarEjemplares(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        $ejemplares = new LbEjemplares();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' buscarEjemplares :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //echo "<script>alert(' buscaEjemplares :: FindAll ')</script>";
                //Busca el usuario 
                $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
                
                //$membresia= ManejoDataRepository::getMembresiasUsuario($usuario);
                
                //echo "<script>alert('MEM ".count($membresia)." regs ')</script>";
                
                $grupo= ManejoDataRepository::getObjetoGruposUsuario($usuario);

                $arrGru = array();
                foreach ($grupo as $gru){
                    $arrGru[] = $gru->getIngrupo();
                }

                $ejemplares = ManejoDataRepository::getBuscarEjemplares($arrGru, $psolicitud->getTextoBuscar());
                $respuesta->setRespuesta(AccesoController::inExitoso);

                //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                //Busca y recupera el objeto de la sesion:: 
                //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                //echo "<script>alert('La sesion es ".$sesion->getTxsesnumero()." ')</script>";
                //Guarda la actividad de la sesion:: 
                //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Recupera Feed de Ejemplares".$psolicitud->getEmail()." recuperados con éxito ",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $ejemplares);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                $ejemplares = array();
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $ejemplares);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            $ejemplares = array();
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $ejemplares);
        }
       
    }

    public function recuperarOferta(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        $oferta = new LbOfertas();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' buscarEjemplares :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //echo "<script>alert(' recuperarFeedEjemplares :: FindAll ')</script>";
                //Busca el usuario 
                $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
                
                //$membresia= ManejoDataRepository::getMembresiasUsuario($usuario);
                
                //echo "<script>alert('MEM ".count($membresia)." regs ')</script>";

                $oferta = ManejoDataRepository::getOfertaById($psolicitud->getIdOferta());
                //echo "<script>alert('Oferta ".$psolicitud->getIdOferta()." ')</script>";
                
                if ($oferta != NULL){
                    if ($oferta->getInofeactiva() == AccesoController::inExitoso){
                        $respuesta->setRespuesta(AccesoController::inExitoso);
                    } else {
                        $respuesta->setRespuesta(AccesoController::inMenNoAc);
                    }    
                } else {
                    $respuesta->setRespuesta(AccesoController::inMenNoEx);
                }
                

                //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                //Busca y recupera el objeto de la sesion:: 
                //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                //echo "<script>alert('La sesion es ".$sesion->getTxsesnumero()." ')</script>";
                //Guarda la actividad de la sesion:: 
                //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Recupera Feed de Ejemplares".$psolicitud->getEmail()." recuperados con éxito ",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $oferta);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                $oferta = array();
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $oferta);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            $oferta = array();
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $oferta);
        }
       
    }
    
    
    public function listarIdiomas(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();   
        $objLogica = $this->get('logica_service');
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' buscarEjemplares :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    

                //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                //Busca y recupera el objeto de la sesion:: 
                //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                //echo "<script>alert('La sesion es ".$sesion->getTxsesnumero()." ')</script>";
                //Guarda la actividad de la sesion:: 
                //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Recupera Feed de Ejemplares".$psolicitud->getEmail()." recuperados con éxito ",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                $respuesta->setRespuesta(AccesoController::inExitoso);
                
                $idiomas = ManejoDataRepository::getListaIdiomas();  
                $idioma = new LbIdiomas();
                $arIdiomas = array();
                
                $contador = 0;
                foreach ($idiomas as $idioma) {
                    $arIdiomas[] = array("ididioma"=>$idioma->getInididioma(),"nomidioma"=>$idioma->getTxidinombre());
                    //$contador++;
                }
                //echo $contador." - lugares hallados";
                //$arIdiomas = array("Español","Inglés","Frances","Alemán","Ruso","Portugues",
                //    "Catalán","Árabe","Bosnio","Croata","Serbio","Italiano","Griego","Turco","Húngaro","Hindi");
            
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $arIdiomas);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                $arIdiomas = array();
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $arIdiomas);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            $arIdiomas = array();
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $arIdiomas);
        }
       
    }
    
    
}
