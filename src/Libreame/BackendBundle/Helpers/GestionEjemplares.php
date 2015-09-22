<?php


namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Libreame\BackendBundle\Repository\ManejoDataRepository;


use Libreame\BackendBundle\Entity\LbLibros;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbEjemplares;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;
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
    
    public function recuperarFeedEjemplares($psolicitud)
    {   
        $fecha = new \DateTime;
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
    
    public function publicarEjemplar($psolicitud)
    {   
        $fecha = new \DateTime;
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $ejemplares = new LbEjemplares();
        $libro = new LbLibros();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' recuperarFeedEjemplares :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Si el ID del libro esta seteado en la solicitud se recupera de la BD, de lo contrario se crea
                $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
                if($psolicitud->getIdlibro() != '') {
                    $libro = ManejoDataRepository::getLibroById($psolicitud->getIdlibro());
                } else {
                    $libro = ManejoDataRepository::crearLibro($psolicitud, AccesoController::txEjemplarPub);
                    //Crear la asociación del libro con genero, si no existe el libro
                    ManejoDataRepository::asociarGeneroBasicoLibro($libro);
                }

                //Crea elejemplar
                $ejemplar = ManejoDataRepository::crearEjemplar($psolicitud,$libro,$usuario);
                
                //Genera la oferta para el ejemplar
                $actoferta = ManejoDataRepository::generarOfertaEjemplar($psolicitud, $ejemplar, $usuario);
                
                //Busca y recupera el objeto de la sesion:: 
                $sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                //Guarda la actividad de la sesion:: 
                ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,$libro->getTxlibtitulo()." publicado con éxito por ".$psolicitud->getEmail(),$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                $respuesta->setRespuesta($respSesionVali);
                $respuesta->setIdEjemplar($ejemplar->getInejemplar());
                $respuesta->setTitulo($libro->getTxlibtitulo());
                $respuesta->setEstado(1);
                $respuesta->setIdOferta($actoferta->getInactoferta());
                $respuesta->setIdMensaje($actoferta->getInactividadoferta());
                $respuesta->setFecha($actoferta->getFeactfechahora());
                $respuesta->setPadre($actoferta->getInactpadreact());
                $respuesta->setDescripcion($actoferta->getTxactdescripcion());
                
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
    
}
/*http://localhost/Ex4ReadBE/web/app_dev.php/ingreso

    
in    
{    "idsesion": {
        "idaccion": "4",
        "idtrx": "rvk4aat3k8x30mgvwxli2-xwcig3ha",
        "ipaddr": "200.000.000.000",
        "iddevice": "A4MACADDRESS",
        "marca": "LG",
        "modelo": "G2 Mini",
        "so": "KITKAT"
    },
    "idsolicitud": {
        "email": "A4alexviatela@gmail.com",
        "clave": "clave12345",
        "ultejemplar": "2"
    }
}    

out
{
    "idsesion": {
        "idaccion": "4",
        "idtrx": "",
        "ipaddr": "200.000.000.000",
        "iddevice": "A4MACADDRESS",
        "marca": "LG",
        "modelo": "G2 Mini",
        "so": "KITKAT"
    },
    "idrespuesta": {
        "respuesta": 1,
        "ejemplares": [
            [],
            {
                "idejemplar": 3,
                "idgenero": 1,
                "inejecantidad": 1,
                "dbavaluo": 0,
                "indueno": 810,
                "inlibro": 2,
                "txgenero": "Genero Prueba",
                "txlibro": "Libro Prueba 2",
                "txdueno": "A4alexviatela@gmail.com"
            },
            {
                "idejemplar": 4,
                "idgenero": 1,
                "inejecantidad": 3,
                "dbavaluo": 0,
                "indueno": 810,
                "inlibro": 1,
                "txgenero": "Genero Prueba",
                "txlibro": "Libro Prueba 1",
                "txdueno": "A4alexviatela@gmail.com"
            }
        ]
    }
}*/