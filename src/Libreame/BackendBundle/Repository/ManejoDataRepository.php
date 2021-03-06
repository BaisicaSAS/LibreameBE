<?php

namespace Libreame\BackendBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query;
use Libreame\BackendBundle\Controller\AccesoController;
use Libreame\BackendBundle\Entity\LbLugares;
use Libreame\BackendBundle\Entity\LbEjemplares;
use Libreame\BackendBundle\Entity\LbGeneros;
use Libreame\BackendBundle\Entity\LbLibros;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Entity\LbGrupos;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;
use Libreame\BackendBundle\Entity\LbEditoriales;
use Libreame\BackendBundle\Entity\LbAutores;
use Libreame\BackendBundle\Entity\LbGeneroslibros;
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbCalificausuarios;
use Libreame\BackendBundle\Entity\LbIndicepalabra;
use Libreame\BackendBundle\Entity\LbMensajes;
use Libreame\BackendBundle\Entity\LbIdiomas;
use Libreame\BackendBundle\Entity\LbBusquedasusuarios;
use Libreame\BackendBundle\Entity\LbMegusta;
use Libreame\BackendBundle\Entity\LbComentarios;
use Libreame\BackendBundle\Entity\LbNegociacion;
use Libreame\BackendBundle\Entity\LbHistejemplar;
use Libreame\BackendBundle\Entity\LbPlanes;
use Libreame\BackendBundle\Entity\LbPlanesusuarios;
use Libreame\BackendBundle\Entity\LbEditorialeslibros;
use Libreame\BackendBundle\Entity\LbAutoreslibros;
use Libreame\BackendBundle\Entity\LbTareas;
use Libreame\BackendBundle\Helpers\Solicitud;

/**
 * Description of ManejoDataRepository
 *
 * @author mramirez
 */
class ManejoDataRepository extends EntityRepository {

    var $inImagenValida;
    
    
    /*
     * validaSesionUsuario 
     * Valida los datos de la sesion verificando que sea veridica
     * Credenciales está compuesto por: 1.usr,2.pass,3-device,4.session,5-opcion a despachar,
     * parametros para la url a despachar, cantidad de caracteres de cada uno 
     * de los anteriores cada uno con 4 digitos.
     * 
     */

    public function validaSesionUsuario($psolicitud)
    {   
        //$respuesta = AccesoController::inPlatCai;
        try{
            //Verifica que el usuario exista, que esté activo, que la clave coincida
            //que corresponda al dispositivo, y que la sesion esté activa

            //echo "<script>alert('Ingresa validar sesion :: ".$psolicitud->getEmail()." ::')</script>";
            $respuesta = AccesoController::inUsSeIna; //Inicializa como sesion logueada
            $em = $this->getDoctrine()->getManager();
            //echo "<script>alert('validaSesionUsuario :: ingreso')</script>";
            if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->
                        findOneBy(array('txusuemail' => $psolicitud->getEmail()))){
                //echo " <script>alert('validaSesionUsuario :: No existe el USUARIO')</script>";
                $respuesta = AccesoController::inUsClInv; //Usuario o clave inválidos
            } else {    
                $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                        findOneBy(array('txusuemail' => $psolicitud->getEmail()));

                $estado = $usuario->getInusuestado();
                //echo "<script>alert('encontro el usuario: estado : ".$estado." ')</script>";

                //Busca el dispositivo si no esta asociado al usuario envia mensaje de sesion no existe
                if (!$em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                        'txdisid' => $psolicitud->getDeviceMAC(), 
                        'indisusuario' => $usuario))){
                        //echo "<script>alert('validaSesionUsuario :: Sesion inactiva')</script>";
                        //echo "<script>alert(' usuario ".$usuario->getTxusuemail()."')</script>";
                        $respuesta = AccesoController::inUsSeIna; //Si la sesion no existe para el dispositivo
                } else {
                    //Si el usuario está INACTIVO
                    if ($estado != AccesoController::inUsuActi)
                    {
                        //echo "<script>alert('validaSesionUsuario :: Usuario inactivo')</script>";
                        $respuesta = AccesoController::inUsuConf; //Usuario Inactiva
                    } else {
                        //Si la clave enviada es inválida
                        if ($usuario->getTxusuclave() != $psolicitud->getClave()){
                            //echo "<script>alert('validaSesionUsuario :: Clave invalida')</script>";
                            $respuesta = AccesoController::inUsClInv; //Usuario o clave inválidos
                        } else {
                            //Valida si la sesion está activa
                            $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                                'txdisid' => $psolicitud->getDeviceMAC(), 
                                'indisusuario' => $usuario));
                            if (!$em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                                'txsesnumero' =>  $psolicitud->getSession(),
                                'insesdispusuario' => $device,
                                'insesactiva' => AccesoController::inSesActi))){
                                //echo "<script>alert('validaSesionUsuario :: Sesion inactiva')</script>";
                                $respuesta = AccesoController::inUsSeIna; //Usuario o clave inválidos

                            } else {
                                $respuesta = AccesoController::inULogged; //Usuario o clave inválidos
                                //echo "<script>alert('La sesion es VALIDA')</script>";
                            }
                        }   
                    }
                }
            }

            //Flush al entity manager
            $em->flush();

            return ($respuesta);
        } catch (Exception $ex) {
            return ($respuesta);
        }    
    }

    /*
     * usuarioSesionActiva 
     *Indica si una sesion para un usuario esta activa
     * 
     */
    public function usuarioSesionActiva($psolicitud, $device, $idsesion)
    {   
        try {
            $em = $this->getDoctrine()->getManager();
            //Identifica el dispositivo // a este es al que se asocia la sesion

            //echo "<script>alert('usuarioSesionActiva - Dispositivo MAC ".$psolicitud->getDeviceMAC()."')</script>";
            $id = $device->getIndispusuario();
            //echo "<script>alert('Dispositivo ID ".$id." - MAC: ".$psolicitud->getDeviceMAC()."')</script>";
            //echo "<script>alert('EXISTE Sesion activa ".$device->getIndispusuario()."')</script>";
            
            if ($idsesion == NULL)
            {
                $sesion = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                'insesdispusuario' => $id,
                'insesactiva' => AccesoController::inSesActi));
            } else {
                $sesion = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                'insesdispusuario' => $id,
                'txsesnumero' => $idsesion,
                'insesactiva' => AccesoController::inSesActi));
            }
            
            
            //if ($sesion != NULL) {echo "<script>alert('EXISTE Sesion activa ".$device->getIndispusuario()."')</script>";}

            //Flush al entity manager
            $em->flush(); 
            
            if ($sesion == NULL) {/*echo "retorna FALSE";*/return FALSE;  } else {/*echo "retorna TRUE";*/return TRUE;}
            
        } catch (Exception $ex) {
            //echo $ex->getMessage();
            return (FALSE);
        }    
            
    }
    
    /*
     * GeneraSesion 
     * Guarda en BD y Devuelve el ID de la sesion
     * Recibe una cadena con los datos del usuario
     * Usuario/Password{cifrado}/FechaHora{Esta se guarda en el dispositivo para que sirva como clave}
     * Id/nombre dispositivo
     *  
     */
    public function generaSesion($pEstado,$pFecIni,$pFecFin,$pDevice,$pIpAdd,$em)
    {
        //Guarda la sesion inactiva
        //echo "<script>alert('Ingresa a generar sesion".$pFecFin."-".$pFecIni."')</script>";
        try{
            $objLogica = $this->get('logica_service');
            if ($em == NULL) { $flEm = TRUE; } else  { $flEm = FALSE; }
            
            if ($flEm) {$em = $this->getDoctrine()->getManager();}
            $sesion = new LbSesiones();
            $sesion->setInsesactiva($pEstado);
            $sesion->setTxsesnumero($objLogica::generaRand(AccesoController::inTamSesi));
            $sesion->setFesesfechaini($pFecIni);
            $sesion->setFesesfechafin($pFecFin);
            $sesion->setInsesdispusuario($pDevice);
            $sesion->setTxipaddr($pIpAdd);
            $em->persist($sesion);
            //echo "<script>alert('Guardo sesion')</script>";
            if ($flEm) {$em->flush();}
            //echo "<script>alert('Retorna".$sesion->getTxsesnumero()."')</script>";
            return $sesion;
            
        } catch (Exception $ex) {
               //echo "<script>alert('Error guardar sesion')</script>";
                return AccesoController::inPlatCai;
        } 
    }
    /*
     * GeneraActSesion 
     */
    public function generaActSesion($pSesion,$pFinalizada,$pMensaje,$pAccion,$pFecIni,$pFecFin,$em)
    {
        //echo "<script>alert('Ingresa a generar actividad de sesion".$pFecFin."-".$pFecIni."')</script>";
        try{
            if ($em == NULL) { $flEm = TRUE; } else  { $flEm = FALSE; }
            if ($flEm) {$em = $this->getDoctrine()->getManager();}
            
            //echo "<script>alert('::::Actividad Sesion".$pFecFin."-".$pFecIni."')</script>";
            //echo "<script>alert('::::Actividad accion ".$pAccion."')</script>";
            $actsesion = new LbActsesion();
            //$actsesion->setInactsesiondisus($pSesion->getInsesdispusuario());
            $actsesion->setInactsesiondisus($pSesion);
            $actsesion->setInactaccion($pAccion);
            $actsesion->setFeactfecha($pSesion->getFesesfechaini());
            $actsesion->setInactfinalizada($pFinalizada);
            $actsesion->setTxactmensaje($pMensaje);
            //echo "<script>alert('::::Antes de persist act sesion')</script>";
            $em->persist($actsesion);
            //echo "<script>alert('::::antes de flush act sesion')</script>";
            if ($flEm) {$em->flush();}
            //echo "<script>alert('::::despues de flush act sesion')</script>";
 
            return $actsesion;
            
        } catch (\Doctrine\DBAL\DBALException  $ex) {
                //echo "<script>alert('::::".$ex->getMessage()."')</script>";
                return AccesoController::inPlatCai;
        } 
    }

    
    
    /*
     * recuperaSesionUsuario 
     * Valida los datos de la sesion verificando que sea veridica
     * 
     */
    public function recuperaSesionUsuario($pusuario, $psolicitud, $em)
    {   
        try{
            //echo "<script>alert('Ingresa validar sesion :: ".$psolicitud->getEmail()." ::')</script>";
            if ($em == NULL) { $flEm = TRUE; } else  { $flEm = FALSE; }
            if ($flEm) {$em = $this->getDoctrine()->getManager();}

            //Busca el dispositivo si no esta asociado al usuario envia mensaje de sesion no existe
            $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                        'txdisid' => $psolicitud->getDeviceMAC(), 
                        'indisusuario' => $pusuario));
            //echo "<script>alert('Ingresa validar sesion :: ".$psolicitud->getSession()." ::')</script>";
            $respuesta = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                            'txsesnumero' =>  $psolicitud->getSession(),
                            'insesdispusuario' => $device,
                            'insesactiva' => AccesoController::inSesActi));
            if ($respuesta == NULL) {
                $respuesta = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                                'insesdispusuario' => $device,
                                'insesactiva' => AccesoController::inSesActi));            
            }
            //Flush al entity manager
            if ($flEm) {$em->flush();}

            return ($respuesta);//Retorna objeto tipo Sesion
        } catch (Exception $ex) {
                return new LbSesiones();
        } 
    }

    //Obtiene el objeto Lugar según su ID 
    public function getLugar($inlugar)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbLugares')->
                findOneBy(array('inlugar' => $inlugar));
        } catch (Exception $ex) {
                return new LbLugares();
        } 
    }
    
    //Obtiene todos los objetos lugar
    public function getLugares()
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            $sql = "SELECT i FROM LibreameBackendBundle:LbLugares i WHERE i.inlugelegible = 1 ORDER BY i.txlugnombre";
            $query = $em->createQuery($sql);
            foreach ($query->getResult() as $reglugar){
                 $lugares[] = $reglugar->getTxlugnombre();
                //echo $lugares;
            }            
            //echo $query->getResult(); 
            //echo "Acabo"; 
            return $query->getResult();

        } catch (Exception $ex) {
                return new LbIdiomas();
        } 

        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbLugares')->
                findBy(array('inlugelegible' => "1"), array('txlugnombre' => 'ASC'));
        } catch (Exception $ex) {
                return new LbLugares();
        } 
    }
    
    //Obtiene varios objetos Genero según el ID del libro 
    public function getGenerosLibro($inlibro)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQueryBuilder()
                ->select('g')
                ->from('LibreameBackendBundle:LbGeneros', 'g')
                ->leftJoin('LibreameBackendBundle:LbGeneroslibros', 'gl', \Doctrine\ORM\Query\Expr\Join::WITH, 'gl.ingligenero = g.ingenero')
                ->Where(' gl.inglilibro = :plibro ')
                ->setParameter('plibro', $inlibro);
            return $q->getQuery()->getResult();
        } catch (Exception $ex) {
                return new LbGeneros();
        } 
    }
    
    //Obtiene varios objetos Editorial según el ID del libro 
    public function getEditorialesLibro($inlibro)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQueryBuilder()
                ->select('e')
                ->from('LibreameBackendBundle:LbEditoriales', 'e')
                ->leftJoin('LibreameBackendBundle:LbEditorialeslibros', 'el', \Doctrine\ORM\Query\Expr\Join::WITH, 'e.inideditorial = el.inedilibroeditorial ')
                ->Where(' el.inediliblibro = :plibro ')
                ->setParameter('plibro', $inlibro);
            return $q->getQuery()->getResult();
        } catch (Exception $ex) {
                return new LbEditoriales();
        } 
    }
    
    //Obtiene un autor por el nombre
    public function getAutorByNombre($autnombre)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbAutores')->
                findOneBy(array('txautnombre' => $autnombre));
        } catch (Exception $ex) {
                return new LbAutores();
        } 
    }
    
    //Obtiene una editorial por el nombre
    public function getEditorialByNombre($edinombre)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbAutores')->
                findOneBy(array('txedinombre' => $edinombre));
        } catch (Exception $ex) {
                return new LbEditoriales();
        } 
    }
    
    //Obtiene varios objetos Autor según el ID del libro 
    public function getAutoresLibro($inlibro)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQueryBuilder()
                ->select('a')
                ->from('LibreameBackendBundle:LbAutores', 'a')
                ->leftJoin('LibreameBackendBundle:LbAutoreslibros', 'al', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.inidautor = al.inautlidautor ')
                ->Where(' al.inautlidlibro = :plibro ')
                ->setParameter('plibro', $inlibro);
            return $q->getQuery()->getResult();
        } catch (Exception $ex) {
                return new LbAutores();
        } 
    }
    
    //Obtiene el máximo ID en ejemplares 
    public function getMaxEjemplar()
    {  
        try{
            $em = $this->getDoctrine()->getManager();
            $qmx = $em->createQueryBuilder()
                ->select('MAX(e.inejemplar)')
                ->from('LibreameBackendBundle:LbEjemplares', 'e');
            
            $max = (int)$qmx->getQuery()->getSingleScalarResult();//Si hay registro devuelve lo que hay
            
            return $max;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }

    //Obtiene el registro de Megusta del ejemplar
    public function getRegMegustaEjemplar(LbEjemplares $pEjemplar, LbUsuarios $pUsuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbMegusta')->
                findOneBy(array('inmegejemplar' => $pEjemplar, 'inmegusuario' => $pUsuario));
        } catch (Exception $ex) { 
                return new LbMegusta();
        } 
    }

    
    //Obtiene la cantidad de Megusta del ejemplar : Condicion megusta - nomegusta 
    public function getMegustaEjemplar(LbEjemplares $pEjemplar, LbUsuarios $pUsuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $qmg = $em->createQueryBuilder()
                ->select('COALESCE(a.inmegmegusta, 0)')
                ->from('LibreameBackendBundle:LbMegusta', 'a')
                ->Where('a.inmegejemplar = :pejemplar')
                ->setParameter('pejemplar', $pEjemplar)
                ->andWhere('a.inmegusuario = :pusuario')
                ->setParameter('pusuario', $pUsuario)
                ->setMaxResults(1)
                ->orderBy('a.femegmegusta', 'DESC');
            
            $meg = AccesoController::inDatoCer;
            if($qmg->getQuery()->getOneOrNullResult() == NULL){
                $meg = AccesoController::inDatoCer; //Si ho hay registro devuelve no me gusta (0)
            } else {
                $meg = (int)$qmg->getQuery()->getSingleScalarResult();//Si hay registro devuelve lo que hay
            }    
            
            //echo "megusta ".$meg;
            return $meg;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }

    //Obtiene la suma de puntos de usuario
    public function getPuntosUsuario(LbUsuarios $pUsuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $qpu = $em->createQueryBuilder()
                ->select('COALESCE(SUM(a.inpuuscantpuntos), 0) AS inpuuscantpuntos')
                ->from('LibreameBackendBundle:LbPuntosusuario', 'a')
                ->Where('a.inpuususuario = :pusuario')
                ->setParameter('pusuario', $pUsuario)
                ->setMaxResults(1);
            
            $puntos = AccesoController::inDatoCer;
            if($qpu->getQuery()->getOneOrNullResult() == NULL){
                $puntos = AccesoController::inDatoCer; //Si ho hay registros devuelve Puntos = 0
            } else {
                $puntos = (int)$qpu->getQuery()->getSingleScalarResult();//Si hay registros devuelve lo que hay
            }    
            
            return $puntos;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }

    //Obtiene la descripcion de la condicion actual del ejemplar
    // 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 
    // 3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega
    // 5 - Entregado, 6 - Recibido
    public function getDescCondicionActualEjemplar($condactual)
    {   
        try{
            $desCondactual = "Ejemplar no está en negociación";
            switch($condactual){
                case (AccesoController::inConEjeNoNe): $desCondactual = AccesoController::txConEjeNoNe; break;
                case (AccesoController::inConEjeSoli): $desCondactual = AccesoController::txConEjeSoli; break;
                case (AccesoController::inConEjePrAp): $desCondactual = AccesoController::txConEjePrAp; break;
                case (AccesoController::inConEjeApNe): $desCondactual = AccesoController::txConEjeApNe; break;
                case (AccesoController::inConEjePrEn): $desCondactual = AccesoController::txConEjePrEn; break;
                case (AccesoController::inConEjeEntr): $desCondactual = AccesoController::txConEjeEntr; break;
                case (AccesoController::inConEjeReci): $desCondactual = AccesoController::txConEjeReci; break;
            }

            return utf8_encode($desCondactual);
        } catch (Exception $ex) {
            return utf8_encode($desCondactual);
        } 
    }
    
    public function getUsrMegustaEjemplar(Solicitud $psolicitud)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $Megusta = $em->getRepository('LibreameBackendBundle:LbMegusta')->findBy(array('inmegejemplar' => $psolicitud->getIdEjemplar())/*, 
                    array('femegmegusta', 'ASC')*/);
            $arUsuar = [];
            $usr = new LbUsuarios();
            foreach($Megusta as $mg){
               $usr = ManejoDataRepository::getUsuarioById($mg->getInMegUsuario()->getInUsuario());
               if  ($mg->getInmegmegusta() == AccesoController::inDatoUno){
                 $arUsuar[] = array("inusuario" => $usr->getInUsuario(), "txusunommostrar" => utf8_encode($usr->getTxusunommostrar()), 
                     "txusuimagen" => utf8_encode($usr->getTxusuimagen()), );
               } else {   
                    if (in_array(strtolower($mg->getInMegUsuario()->getInUsuario()), $arUsuar)){
                        unset($arUsuar[$mg->getInMegUsuario()->getInUsuario()]);
                    }
               }
            }
            
            return $arUsuar;
        } catch (Exception $ex) {
                return $arUsuar;
        } 
    }
    
    
    public function getNegociacionEjemplarBiblioteca(LbEjemplares $pejemplar, LbUsuarios $pusuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $qneg = $em->createQueryBuilder()
                ->select('DISTINCT a.txnegidconversacion')
                ->from('LibreameBackendBundle:LbNegociacion', 'a')
                ->Where('a.innegejemplar = :pejemplar')
                ->setParameter('pejemplar', $pejemplar)
                ->andWhere('a.innegusuduenho = :pusuario')
                ->setParameter('pusuario', $pusuario);
            
            $arrNegociacion = array();
            $idneg = $qneg->getQuery()->getResult();
            foreach($idneg as $idconversacion){
                //echo "conversa ".$idconversacion;
                
                $negociacion = $em->getRepository('LibreameBackendBundle:LbNegociacion')->
                        findBy(array('txnegidconversacion' => $idconversacion,
                                    'innegmenseliminado' => AccesoController::inDatoCer), 
                                    array('fenegfechamens' => 'asc'));
                $negoc = new LbNegociacion();
                $arrConversacion = array();
                foreach ($negociacion as $negoc) {
                    $usuaNeg = ManejoDataRepository::getUsuarioById($negoc->getInnegusuduenho()->getInusuario());
                    $usuaEsc = ManejoDataRepository::getUsuarioById($negoc->getInnegusuescribe()->getInusuario());
                    $usuaSol = ManejoDataRepository::getUsuarioById($negoc->getInnegususolicita()->getInusuario());
                    $promcalUsNeg = ManejoDataRepository::getPromedioCalifica($usuaNeg->getInusuario());
                    $promcalUsEsc = ManejoDataRepository::getPromedioCalifica($usuaEsc->getInusuario());
                    $promcalUsSol = ManejoDataRepository::getPromedioCalifica($usuaSol->getInusuario());
                    if($pusuario == $negoc->getInnegusuduenho()){
                        $leido = $negoc->getInnegmensleidodue();
                    } else {
                        $leido = $negoc->getInnegmensleidosol();
                    }
                    
                    $arrConversacion[] = array('inidnegociacion' => $negoc->getInidnegociacion(),
                        'innegmensleido' => $leido,
                        'fenegfechamens' => $negoc->getFenegfechamens()->format("Y-m-d H:i:s"),
                        'txnegmensaje' => utf8_encode($negoc->getTxnegmensaje()),
                        'usrescribe' =>  $usuaEsc->getInusuario(),
                        'tratoacep' => $negoc->getInnegtratoacep(),
                    );
                }
                $arrNegociacion[] = array('txnegidconversacion' => $idconversacion, 'usrsolicita' =>  array('inusuario' => $usuaSol->getInusuario(),
                                'txusunommostrar' => utf8_encode($usuaSol->getTxusunommostrar()),
                                'txusuimagen' => utf8_encode($usuaSol->getTxusuimagen()),'calificacion' => $promcalUsSol),
                                'usrdueno' => array('inusuario' => $usuaNeg->getInusuario(),
                                'txusunommostrar' => utf8_encode($usuaNeg->getTxusunommostrar()),
                                'txusuimagen' => utf8_encode($usuaNeg->getTxusuimagen()),'calificacion' => $promcalUsNeg), 
                                "conversacion" => array($arrConversacion));
                unset($arrConversacion);
                
            }
            
            return $arrNegociacion;
        } catch (Exception $ex) {
                return new LbNegociacion();
        } 
    }

    public function getHistoriaEjemplarBiblioteca(LbEjemplares $pejemplar){   
        try{
            $em = $this->getDoctrine()->getManager();
            //Primero busca todos los que tengan hijos
            $histEjemplar = $em->createQueryBuilder()
                ->select('a')
                ->from('LibreameBackendBundle:LbHistejemplar', 'a')
                ->Where('a.inhisejeejemplar = :pejemplar')
                ->setParameter('pejemplar', $pejemplar)
                //->andWhere('a.inhisejeusuario = :pusuario')
                //->setParameter('pusuario', $pusuario)
                //->andWhere('a.inhisejepadre  IS NOT NULL')
                ->orderBy('a.fehisejeregistro', 'ASC')->getQuery()->getResult();
            $arrHistEjemplar = array();

            $hisEje = new LbHistejemplar();
            foreach ($histEjemplar as $hisEje) {
                //Para cada uno busca sus hijos
                $hijo = $hisEje->getInhistejemplar();
                $padre = null;
                if($hisEje->getInhisejepadre() != NULL)
                    $padre = $hisEje->getInhisejepadre()->getInhistejemplar();
                //$punteros[]['padre'] = $padre;
                //$punteros[]['hijo'] = $hijo;
                //echo "P:".$padre." -> H:".$hijo." \n";
                
                $histHijo = new LbHistejemplar();
                //$rpadre = $registro['padre'];
                $histHijo = $em->createQueryBuilder()
                    ->select('a')
                    ->from('LibreameBackendBundle:LbHistejemplar', 'a')
                    ->Where('a.inhisejeejemplar = :pejemplar')
                    ->setParameter('pejemplar', $pejemplar)
                    //->andWhere('a.inhisejeusuario = :pusuario')
                    //->setParameter('pusuario', $pusuario)
                    ->andWhere('a.inhistejemplar = :idhijo')
                    ->setParameter('idhijo', $hijo)
                    ->orWhere('a.inhistejemplar = :idpadre')
                    ->setParameter('idpadre', $padre)
                    ->orderBy('a.fehisejeregistro', 'ASC')->getQuery()->getResult();
                
                foreach ($histHijo as $hisEjePH) {
                    $idusuario = $hisEjePH->getInhisejeusuario()->getInusuario();
                    $usuaHist = ManejoDataRepository::getUsuarioById($idusuario);
                    $promcalUsHist = ManejoDataRepository::getPromedioCalifica($idusuario);
                    $descMovimiento = "";
                    switch ($hisEjePH->getInhisejemovimiento()){
                        case AccesoController::inMovPubEjem: $descMovimiento = AccesoController::txMovPubEjem; break;
                        case AccesoController::inMovBlqEjSi: $descMovimiento = AccesoController::txMovBlqEjSi; break;
                        case AccesoController::inMovSoliEje: $descMovimiento = AccesoController::txMovSoliEje; break;
                        case AccesoController::inMovEntrEje: $descMovimiento = AccesoController::txMovEntrEje; break;
                        case AccesoController::inMovReciEje: $descMovimiento = AccesoController::txMovReciEje; break;
                        case AccesoController::inMovActiEje: $descMovimiento = AccesoController::txMovActiEje; break;
                        case AccesoController::inMovInacEje: $descMovimiento = AccesoController::txMovInacEje; break;
                        case AccesoController::inMovComeEje: $descMovimiento = AccesoController::txMovComeEje; break;
                        case AccesoController::inMovMeguEje: $descMovimiento = AccesoController::txMovMeguEje; break;
                        case AccesoController::inMovNMegEje: $descMovimiento = AccesoController::txMovNMegEje; break;
                        case AccesoController::inMovCamEEje: $descMovimiento = AccesoController::txMovCamEEje; break;
                        case AccesoController::inMovContEje: $descMovimiento = AccesoController::txMovContEje; break;
                        case AccesoController::inMovBajaEje: $descMovimiento = AccesoController::txMovBajaEje; break;
                        case AccesoController::inMovConsEje: $descMovimiento = AccesoController::txMovConsEje; break;
                        case AccesoController::inMovVendEje: $descMovimiento = AccesoController::txMovVendEje; break;
                        case AccesoController::inMovCompEje: $descMovimiento = AccesoController::txMovCompEje; break;
                        case AccesoController::inMovAcepEje: $descMovimiento = AccesoController::txMovAcepEje; break;
                        case AccesoController::inMovRechEje: $descMovimiento = AccesoController::txMovRechEje; break;
                        case AccesoController::inMovEjeDevu: $descMovimiento = AccesoController::txMovEjeDevu; break;
                        case AccesoController::inMovUsPCali: $descMovimiento = AccesoController::txMovUsPCali; break;
                        case AccesoController::inMovUsSCali: $descMovimiento = AccesoController::txMovUsSCali; break;
                    }
                    $arrHistEjemplar[] = array('fehisejeregistro' => $hisEjePH->getFehisejeregistro()->format("Y-m-d H:i:s"),
                        'inhisejemodoentrega' => $hisEjePH->getInhisejemodoentrega(), /*0: En el domicilio, 1: Encontrandose, 3. Courrier local, 4: Courrier Nacional, 5: Courrier internacional*/
                        'inhisejemovimiento' => $hisEjePH->getInhisejemovimiento(),
                        'txhisejedescmovimiento' => utf8_encode($descMovimiento),
                        'inhisejeejemplar' => $hisEjePH->getInhisejeejemplar(),
                        'inhisejepadre' => $hisEjePH->getInhisejepadre(),
                        'usrtrx' => array('inusuario' => $usuaHist->getInusuario(),
                                'txusunommostrar' => utf8_encode($usuaHist->getTxusunommostrar()),
                                'txusuimagen' => utf8_encode($usuaHist->getTxusuimagen()),
                                'calificacion' => $promcalUsHist)
                    );
                }    
            }    
            return $arrHistEjemplar;
        
        } catch (Exception $ex) {
                return LbHistejemplar();
        } 
    }

    public function getComentariosEjemplar(Solicitud $psolicitud)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $comentarios = $em->getRepository('LibreameBackendBundle:LbComentarios')->
                    findBy(array('incomejemplar' => $psolicitud->getIdEjemplar(), 'incomactivo' => '1'), 
                           array('fecomfeccomentario' => 'desc'));
            $com = new LbComentarios();
            $arComme = [];
            $usr = new LbUsuarios();
            foreach($comentarios as $com){
               $usr = ManejoDataRepository::getUsuarioById($com->getIncomusuario()->getInusuario());
                $arUsuar = [];
               $arUsuar[] = array("inusuario" => $usr->getInUsuario(), "txusunommostrar" => utf8_encode($usr->getTxusunommostrar()), 
                   "txusuimagen" => utf8_encode($usr->getTxusuimagen()), );
               if($com->getIncomcompadre()!=NULL){ //Si el cometario PADRE está inactivo, el hijo tambien
                    if($com->getIncomcompadre()->getIncomactivo()==AccesoController::inDatoUno){ //Si el cometario PADRE está inactivo, el hijo tambien
                         $arComme[] = array("inidcomentario" => $com->getInidcomentario(), "fecomfeccomentario" => $com->getFecomfeccomentario()->format("Y-m-d H:i:s"),
                             "incompadre" => $com->getIncomcompadre()->getInidcomentario(), "txcomentario" => utf8_encode($com->getTxcomcomentario()),
                             "usuario" => $arUsuar);
                    }
               } else {
                         $arComme[] = array("inidcomentario" => $com->getInidcomentario(), "fecomfeccomentario" => $com->getFecomfeccomentario()->format("Y-m-d H:i:s"),
                             "incompadre" => "", "txcomentario" => utf8_encode($com->getTxcomcomentario()),"usuario" => $arUsuar);
               }
            }
            
            return $arComme;
        } catch (Exception $ex) {
                return $arComme;
        } 
    }
    
    
    //Obtiene la cantidad de Megusta del ejemplar : Condicion megusta - nomegusta 
    public function getCantMegusta($inejemplar)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $qmg = $em->createQueryBuilder()
                ->select('count(a)')
                ->from('LibreameBackendBundle:LbMegusta', 'a')
                ->Where('a.inmegejemplar = :pejemplar')
                ->setParameter('pejemplar', $inejemplar)
                ->andWhere('a.inmegmegusta = :pmeg')
                ->setParameter('pmeg', 1);
                
            /*$qnmg = $em->createQueryBuilder()
                ->select('count(a)')
                ->from('LibreameBackendBundle:LbMegusta', 'a')
                ->Where('a.inmegejemplar = :pejemplar')
                ->setParameter('pejemplar', $inejemplar)
                ->andWhere('a.inmegmegusta = :pnomeg')
                ->setParameter('pnomeg', 0);
            */
            $meg = $qmg->getQuery()->getSingleScalarResult();
            //$nomeg = $qnmg->getQuery()->getSingleScalarResult();
            
            //echo "megusta ".$meg." - nomegusta ".$nomeg;
            //return $meg - $nomeg;
            return $meg;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
    
    //Obtiene la cantidad de Comentarios del ejemplar : Condicion : Comentarios activos
    public function getCantComment($inejemplar)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQueryBuilder()
                ->select('count(a)')
                ->from('LibreameBackendBundle:LbComentarios', 'a')
                ->Where('a.incomejemplar = :pejemplar')
                ->setParameter('pejemplar', $inejemplar);
            $comm = $q->getQuery()->getSingleScalarResult() * 1;
            return $comm;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
    
    //Obtiene la cantidad de Comentarios del ejemplar : Condicion : Comentarios activos
    public function getPromedioCalifica($inusuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $qs = $em->createQueryBuilder()
                ->select('sum(a.incalcalificacion)')
                ->from('LibreameBackendBundle:LbCalificausuarios', 'a')
                ->Where('a.incalusucalificado = :pusuario')
                ->setParameter('pusuario', $inusuario);
            $suma = $qs->getQuery()->getSingleScalarResult();
            
            $qc = $em->createQueryBuilder()
                ->select('count(a)')
                ->from('LibreameBackendBundle:LbCalificausuarios', 'a')
                ->Where('a.incalusucalificado = :pusuario')
                ->setParameter('pusuario', $inusuario);
            $cant = $qc->getQuery()->getSingleScalarResult();
            if($cant == 0)
                $promedio = 0;
            else    
                $promedio = $suma / $cant;
            //echo "\n promedio:".$promedio;
            return $promedio;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
    
    //Obtiene el indicador de si el usuario ha aceptado 1, rechazado 0, o no ha indicado el trato -1
    public function getUsAceptTrato($usrescribe, $idconversa)
    {
        try{
            $indicador = -1;
            $em = $this->getDoctrine()->getManager();
            $qs = $em->createQueryBuilder()
                ->select('count(n)')
                ->from('LibreameBackendBundle:LbNegociacion', 'n')
                ->Where('n.txnegidconversacion = :idconv')
                ->andWhere('n.innegusuescribe = :idusr')
                ->andWhere('n.innegtratoacep = :acep')
                ->setParameter('idconv', $idconversa)
                ->setParameter('idusr', $usrescribe)
                ->setParameter('acep', 0); //Busca rechazo
            $indrechazo = $qs->getQuery()->getSingleScalarResult();
            if ($indrechazo > 0) {
                $indicador = $indrechazo;
            } else {
                $qt = $em->createQueryBuilder()
                    ->select('count(n)')
                    ->from('LibreameBackendBundle:LbNegociacion', 'n')
                    ->Where('n.txnegidconversacion = :idconv')
                    ->andWhere('n.innegusuescribe = :idusr')
                    ->andWhere('n.innegtratoacep = :acep')
                    ->setParameter('idconv', $idconversa)
                    ->setParameter('idusr', $usrescribe)
                    ->setParameter('acep', 1); //Busca aceptacion
                $indacepta = $qt->getQuery()->getSingleScalarResult();
                if ($indacepta > 0) {
                    $indicador = $indacepta;
                }
            }
            
            return $indicador;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
    
    
    //Obtiene todo el chat por su id 
    public function getChatNegociacionById($idconversa)
    {   
        try{
            //echo "busca conversación ".$idconversa;
            $em = $this->getDoctrine()->getManager();
            $qs = $em->createQueryBuilder()
                ->select('n')
                ->from('LibreameBackendBundle:LbNegociacion', 'n')
                ->Where('n.txnegidconversacion = :idconv')
                ->setParameter('idconv', $idconversa)
                ->orderBy('n.fenegfechamens', 'ASC');
            $conversacion = $qs->getQuery()->getResult();
            
            return $conversacion;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
    
    //Obtiene un Registro histórico por su ID
    public function getRegHisById($idregistro)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $registro = $em->getRepository('LibreameBackendBundle:LbHistejemplar')->
                findOneBy(array('inhistejemplar' => $idregistro));

            return $registro;
        } catch (Exception $ex) {
                return new LbHistejemplar();
        } 
    }
    
    //Obtiene el dato del genero según el Objeto
    public function getGenero($genero)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbGeneros')->
                findOneBy(array('ingenero' => $genero));
        } catch (Exception $ex) {
                return new LbGeneros();
        }   
    }
    
    //Obtiene el objeto Libro según su ID 
    public function getLibro($inlibro)
    {   
        try{
            //echo "El libro solicitado: -[".$inlibro."]- \n";
            $em = $this->getDoctrine()->getManager();
            //$libro = new LbLibros();
            $libro = $em->getRepository('LibreameBackendBundle:LbLibros')->
                //findOneBy(array("inlibro"=>$inlibro));
                findOneByInlibro($inlibro);
  
            //echo "Recuperó el libro ".$libro->getInlibro()."-".$libro->getTxlibtitulo()."\n";
            return $libro;
        } catch (Exception $ex) {
                return new LbLibros();
        } 
    }
    
    //Obtiene el objeto Libro según su nombre 
    public function getLibroByTitulo($titulo)
    {   
        try{
            //echo "El libro solicitado: -[".$inlibro."]- \n";
            $em = $this->getDoctrine()->getManager();
            //$libro = new LbLibros();
            $libro = $em->getRepository('LibreameBackendBundle:LbLibros')->
                //findOneBy(array("inlibro"=>$inlibro));
                findOneBy(array("txlibtitulo" => $titulo));
  
            //echo "Recuperó el libro ".$libro->getInlibro()."-".$libro->getTxlibtitulo()."\n";
            return $libro;
        } catch (Exception $ex) {
                return new LbLibros();
        } 
    }
    
    //Obtiene el objeto Libro según su ID 
    public function getGrupo($ingrupo)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbGrupos')->
                findOneBy(array('ingrupo' => $ingrupo));
        } catch (Exception $ex) {
                return new LbGrupos();
        } 
    }
    
    //Obtiene el objeto Usuario según su ID 
    public function getUsuarioById($inusuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                findOneBy(array('inusuario' => $inusuario, 'inusuestado' => AccesoController::inExitoso));
        } catch (Exception $ex) {
                return new LbUsuarios();
        } 
    }
    
    //Obtiene el objeto Usuario según su EMAIL
    public function getUsuarioByEmail($txemail)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                findOneBy(array('txusuemail' => $txemail));
        } catch (Exception $ex) {
                return new LbUsuarios();
        } 
    }
    
    //Obtiene el objeto Usuario según su TELEFONO 
    public function getUsuarioByTelefono($txtelefono)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                findOneBy(array('txusutelefono' => $txtelefono));
        } catch (Exception $ex) {
                return new LbUsuarios();
        } 
    }
    
    //Obtiene el Dispositivo del usuario 
    public function getDispositivoUsuario($iddispositivo, LbUsuarios $usuario, $em)
    {   
        try{
            if ($em == NULL) { $flEm = TRUE; } else  { $flEm = FALSE; }
            
            if ($flEm) {$em = $this->getDoctrine()->getManager();}
            if($iddispositivo == AccesoController::txAnyData) {
                return $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(
                        array('indisusuario' => $usuario));
            } else {
                return $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                        'txdisid' => $iddispositivo, 
                        'indisusuario' => $usuario));
            }
            if ($flEm) {$em->flush();}
        } catch (Exception $ex) {
                return new LbDispusuarios();
        } 
    }
    
    //Obtiene todos los Ids de las membresias del usuario
    public function getMembresiasUsuario(LbUsuarios $usuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbMembresias')->
                    findBy(array('inmemusuario' => $usuario));
        } catch (Exception $ex) {
                return new LbMembresias();
        } 
    }
        
    //Obtiene todos los grupos a los que pertenece el usuario
    public function getEjemplarById($ejemplar)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbEjemplares')->
                    findOneBy(array('inejemplar' => $ejemplar));
        } catch (Exception $ex) {
                return new LbEjemplares();
        } 
    }
                
    //Obtiene los datos de un autor por su ID
    public function getAutorById($idautor)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbAutores')->
                    findOneBy(array('inidautor' => $idautor));
        } catch (Exception $ex) {
                return new LbAutores();
        } 
    }
                
    //Obtiene una editorial por su ID
    public function getEditorialById($ideditorial)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbEditoriales')->
                    findOneBy(array('inideditorial' => $ideditorial));
        } catch (Exception $ex) {
                return new LbEditoriales();
        } 
    }
                
    //Obtiene todos los libros de un autor
    public function getLibrosByAutor($autor)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbAutoreslibros')->
                    findBy(array('inautlidautor' => $autor));
        } catch (Exception $ex) {
                return new LbAutoreslibros();
        } 
    }
                
    //Obtiene todos los libros de una editorial
    public function getLibrosByEditorial($editorial)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbEditorialeslibros')->
                    findBy(array('inedilibroeditorial' => $editorial));
        } catch (Exception $ex) {
                return new LbEditorialeslibros();
        } 
    }
                
    //Obtiene todos los grupos a los que pertenece el usuario
    public function getObjetoGruposUsuario(LbUsuarios $usuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $sql = "SELECT g FROM LibreameBackendBundle:LbGrupos g JOIN LibreameBackendBundle:LbMembresias m"
                    ." WHERE m.inmemusuario = :usuario AND g.ingrupo = m.inmemgrupo";
            $query = $em->createQuery($sql)->setParameter('usuario', $usuario);
            return $query->getResult();
        } catch (Exception $ex) {
                return new LbGrupos();
        } 
    }
                
    //Obtiene todos los grupos a los que pertenece el usuario
    public function getPlanUsuario(LbUsuarios $usuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            $planus = new LbPlanesusuarios();
            $planus = $em->getRepository('LibreameBackendBundle:LbPlanesusuarios')->
                    findOneBy(array('inusuplan' => $usuario));
            //echo "****** usuario ".$usuario->getInusuario(). " *************";
            //echo "****** plan ".$planus->getInplusplanes()->getInplan(). " *************";
            
            $plan = new LbPlanes();
            $plan = $planus->getInplusplanes();
            
            
            $q = $em->createQueryBuilder()
                ->select('p')
                ->from('LibreameBackendBundle:LbPlanes', 'p')
                ->leftJoin('LibreameBackendBundle:LbPreciosplanes', 'pp', \Doctrine\ORM\Query\Expr\Join::WITH, 'pp.inidprepidplan = p.inplan')
                ->Where(' p.inplan = :plan ')
                ->setParameter('plan', $plan);
            return $q->getQuery()->getOneOrNullResult();

        } catch (Exception $ex) {
                //ECHO "ERROR PLANES";
                return new LbPlanes();
        } 
    }
                
    //Obtiene el resumen de ejemplares del usuario
    public function getResumenUsuario(LbUsuarios $usuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            //Arreglo para almacenar el resumen
            $arrResumen = array();
            //Cantidad de ejemplares de un usuario
            
            $qej = $em->createQueryBuilder()
                ->select('COALESCE(count(e), 0)')
                ->from('LibreameBackendBundle:LbEjemplares', 'e')
                ->Where(' e.inejeusudueno = :usuario ')
                ->setParameter('usuario', $usuario)
                ->setMaxResults(1);
            $ejemplares = (Int)$qej->getQuery()->getSingleScalarResult();
            
            $qen = $em->createQueryBuilder()
                ->select('COALESCE(count(e), 0)')
                ->from('LibreameBackendBundle:LbHistejemplar', 'e')
                ->Where(' e.inhisejeusuario = :usuario ')
                ->setParameter('usuario', $usuario)
                //Movimiento = Entregado
                ->andWhere(' e.inhisejemovimiento = :entregado ')
                ->setParameter('entregado', AccesoController::inMovEntrEje)
                ->setMaxResults(1);
            $entregados = (Int)$qen->getQuery()->getSingleScalarResult();
            
            $qre = $em->createQueryBuilder()
                ->select('COALESCE(count(e), 0)')
                ->from('LibreameBackendBundle:LbHistejemplar', 'e')
                ->Where(' e.inhisejeusuario = :usuario ')
                ->setParameter('usuario', $usuario)
                //Movimiento = Recibido = 5
                ->andWhere(' e.inhisejemovimiento = :recibido ')
                ->setParameter('recibido', AccesoController::inMovReciEje)
                ->setMaxResults(1);
            $recibidos = (Int)$qre->getQuery()->getSingleScalarResult();
            
            
            $donados = 0;
            /*AUN NO SE ACTIVA ESTA OPCION :: POR AHORA ES CERO
             * $qdo = $em->createQueryBuilder()
                ->select('count(e)')
                ->from('LibreameBackendBundle:LbEjemplares', 'e')
                ->Where(' e.inejeusudueno = :usuario ')
                ->setParameter('usuario', $usuario);
            $donados = $qre->getQuery()->getOneOrNullResult();
             */
            
            $arrResumen[] = array('ejemplares' => $ejemplares, 'entregados' => $entregados, 
                'recibidos' => $recibidos, 'donados' => $donados);

        return $arrResumen;
        } catch (Exception $ex) {
                //ECHO "ERROR PLANES";
                return array();
        } 
    }
                
    //Obtiene las preferencias del usuario
    public function getPreferenciasUsuario(LbUsuarios $usuario, $numpref)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            //Arreglo para almacenar el resumen
            $arrPreferencias = array();
            //Cantidad de ejemplares de un usuario
            
            //$ejeusu = new LbEjemplares();
            $ejeusu = $em->getRepository('LibreameBackendBundle:LbEjemplares')->
                    findBy(array('inejeusudueno' => $usuario));
            
            $libusu = $em->getRepository('LibreameBackendBundle:LbLibros')->
                    findBy(array('inlibro' => $ejeusu));
            
            //generos
            $qg = $em->createQueryBuilder()
                ->select('g.ingenero, g.txgennombre, count(g.ingenero) as num')
                ->from('LibreameBackendBundle:LbGeneros', 'g')
                ->leftJoin('LibreameBackendBundle:LbGeneroslibros', 'gl', \Doctrine\ORM\Query\Expr\Join::WITH, 'gl.ingligenero = g.ingenero')
                ->Where(' gl.inglilibro in (:libro) ')
                ->setParameter('libro', $libusu)
                ->groupBy('g.ingenero')
                //->having(' count(g.ingenero) > 1')
                ->orderBy(' num ', 'DESC')
                ->setMaxResults($numpref);
            
            $generos = $qg->getQuery()->getResult();
            //echo "generos-[".count($generos)."]  \n";
            
            //autores
            $qa = $em->createQueryBuilder()
                ->select('a.inidautor, a.txautnombre, count(a.inidautor) as num')
                ->from('LibreameBackendBundle:LbAutores', 'a')
                ->leftJoin('LibreameBackendBundle:LbAutoreslibros', 'al', \Doctrine\ORM\Query\Expr\Join::WITH, 'al.inautlidautor = a.inidautor')
                ->Where(' al.inautlidlibro in (:libro) ')
                ->setParameter('libro', $libusu)
                ->groupBy('a.inidautor')
                //->having(' count(a.inidautor) > 1')
                ->orderBy(' num ', 'DESC')
                ->setMaxResults($numpref);
            $autores = $qa->getQuery()->getResult();
            //echo "autores-[".count($autores)."]  \n";
            
            //editoriales
            $qe = $em->createQueryBuilder()
                ->select('e.inideditorial, e.txedinombre, count(e.inideditorial) as num')
                ->from('LibreameBackendBundle:LbEditoriales', 'e')
                ->leftJoin('LibreameBackendBundle:LbEditorialeslibros', 'el', \Doctrine\ORM\Query\Expr\Join::WITH, 'el.inedilibroeditorial = e.inideditorial')
                ->Where(' el.inediliblibro in (:libro) ')
                ->setParameter('libro', $libusu)
                ->groupBy('e.inideditorial')
                //->having(' count(e.inideditorial) > 2')
                ->orderBy(' num ', 'DESC')
                ->setMaxResults($numpref);
            $editoriales = $qe->getQuery()->getResult();
            //echo "editoriales-[".count($editoriales)."]  \n";

            $arrGeneros = array();
            foreach ($generos as $gen){
                if (!in_array($gen, $arrGeneros)) {
                    $arrGeneros[] = array("idgenero" => $gen['ingenero'],"nomgenero" => utf8_encode($gen['txgennombre']));
                }
            }
            //echo "Cargó arreglo generos \n";
            
            $arrAutores = array();
            foreach ($autores as $aut){
                if (!in_array($aut, $arrAutores)) {
                    $arrAutores[] = array("idautor" => $aut['inidautor'],"nomautor" => utf8_encode($aut['txautnombre']));
                }
            }
            //echo "Cargó arreglo autores \n";
            
            $arrEditoriales = array();
            foreach ($editoriales as $edi){
                if (!in_array($edi, $arrEditoriales)) {
                    $arrEditoriales[] = array("ideditorial" => $edi['inideditorial'],"nomeditorial" => utf8_encode($edi['txedinombre']));
                }
            }
            //echo "Cargó arreglo editoriales  \n";
            
            $arrPreferencias[] = array('generos' => $arrGeneros, 'autores' => $arrAutores, 
                'editoriales' => $arrEditoriales);

        return $arrPreferencias;
        } catch (Exception $ex) {
                //ECHO "ERROR PREFERENCIAS ".$ex;
                return array();
        } 
    }
                
    //Obtiene la fecha en que el usuario publicó el ejemplar
    public function getFechaPublicacion($pejemplar, $pusuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $sql = "SELECT max(h.fehisejeregistro) AS fecha FROM LibreameBackendBundle:LbHistejemplar h"
                    ." WHERE h.inhisejeejemplar = :ejemplar AND h.inhisejeusuario = :usuario";
            $query = $em->createQuery($sql)->setParameters(array('ejemplar'=>$pejemplar, 'usuario'=> $pusuario));
            
            $fecha = $query->getOneOrNullResult();
            //echo "fecha : ".$fecha['fecha'];
            return $fecha['fecha'];
        } catch (Exception $ex) {
                return $fecha;
        } 
    }
                
    //Obtiene todos los Ejemplares, con ID mayor al parámetro
    public function getEjemplaresDisponibles(Array $grupos, $inultejemplar)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            //Los ejemplares cuya membresías coincidan con las del usuario que solicita
            //El usuario debe estar activo
            
            //Si el ultimo ejemplar es 0, la lista es de los 30 más recientes, 
            //si es positivo la lista los 30 superiores al numero y si es negativo
            //lista los 30 anteriores
            if ($inultejemplar == 0){ //Si es cero, trae los 30 más recientes
                $limiteSup = ManejoDataRepository::getMaxEjemplar();
                $limiteInf = $limiteSup - 30;
            } else if($inultejemplar > 0) { //Si es Positivo trae los 30 siguientes al numero
                $limiteInf = $inultejemplar + 1;
                $limiteSup = $limiteInf + 30;
            } else if ($inultejemplar < 0) { //Si es negativo trae los 30 anteriores 
                $limiteSup = ($inultejemplar*-1) - 1;
                $limiteInf =  $limiteSup -30;
            }
            
            $nulo = "NULL";
            $blanco = "";
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQueryBuilder()
                ->select('e')
                ->from('LibreameBackendBundle:LbEjemplares', 'e')
                ->leftJoin('LibreameBackendBundle:LbUsuarios', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.inusuario = e.inejeusudueno')
                ->leftJoin('LibreameBackendBundle:LbMembresias', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.inmemusuario = e.inejeusudueno')
                ->leftJoin('LibreameBackendBundle:LbHistejemplar', 'h', \Doctrine\ORM\Query\Expr\Join::WITH, 'h.inhisejeejemplar = e.inejemplar and h.inhisejeusuario = e.inejeusudueno')
                ->where(' (e.txejeimagen IS NOT NULL) AND (e.txejeimagen <> :nulo) AND (e.txejeimagen <> :blanco)')
                ->setParameter('nulo', $nulo)
                ->setParameter('blanco', $blanco)
                ->andWhere(' e.inejemplar BETWEEN :pejemplar AND :pFejemplar')
                ->setParameter('pejemplar', $limiteInf)
                ->setParameter('pFejemplar', $limiteSup)
                ->andWhere(' u.inusuestado = :estado')//Solo los usuarios con estado 1
                ->setParameter('estado', 1)//Solo los usuarios con estado 1
                ->andWhere(' e.inejepublicado <= :ppublicado')//Debe cambiar a solo los ejemplares publicados = 1
                ->setParameter('ppublicado', 1)//Debe cambiar a solo los ejemplares publicados = 1                    
                ->andWhere(' h.inhisejemovimiento = :pmovimiento')
                ->setParameter('pmovimiento', 1)//Todos los ejemplares con registro de movimiento en historia ejemplar: publicados 
                ->andWhere(' m.inmemgrupo in (:grupos) ')//Para los grupos del usuario
                ->setParameter('grupos', $grupos)
                    
                ->setMaxResults(30)
                //->orderBy(' h.fehisejeregistro ', 'DESC');
                ->orderBy(' e.inejemplar ', 'DESC');

            return $q->getQuery()->getResult();
            //return $q->getArrayResult();
        } catch (Exception $ex) {
                //echo "retorna error";
                return new LbEjemplares();
        } 
    }
                
   //Obtiene todos los Ejemplares, que coincidan con el texto OFRECIDOS, o SOLICITADOS
    public function getBuscarEjemplares(LbUsuarios $usuario, Array $grupos, $texto)
    {   
        //14 DICIEMBRE DE 2016: CAMBIADO METODO DE BUSCAR POR FULLTEXT
        //Recuperar ejemplares por búsqueda full text a las tablas Libro y Autores
        try{
            //Si la palabra de búsqueda viene en cero, el resultset es los 30 ejemplares más recientes
            if ($texto == "") {
                $resejemplares = ManejoDataRepository::getEjemplaresDisponibles($grupos, AccesoController::inDatoCer);
                return $resejemplares;
            } else {
                $em = $this->getDoctrine()->getManager();
                setlocale (LC_TIME, "es_CO");
                $fecha = new \DateTime;
                $objBusqueda = new LbBusquedasusuarios();
                $objBusqueda->setFebusfecha($fecha);
                $objBusqueda->setInbususuario($usuario);
                $objBusqueda->setTxbuspalabra(utf8_encode($texto));
                $em->persist($objBusqueda);
                $em->flush();
                $arLibros =[];

                $em = $this->getDoctrine()->getManager();
                $rsm   = new ResultSetMapping();
                $rsm->addEntityResult('LibreameBackendBundle:LbLibros', 'l');
                $rsm->addFieldResult('l', 'inlibro', 'inlibro');
                $rsm->addFieldResult('l', 'txlibtipopublica', 'txlibtipopublica');
                $rsm->addFieldResult('l', 'txlibtitulo', 'txlibtitulo');
                $rsm->addFieldResult('l', 'txlibedicionanio', 'txlibedicionanio');
                $rsm->addFieldResult('l', 'txlibedicionnum', 'txlibedicionnum');
                $rsm->addFieldResult('l', 'txlibedicionpais', 'txlibedicionpais');
                $rsm->addFieldResult('l', 'txediciondescripcion', 'txediciondescripcion');
                $rsm->addFieldResult('l', 'txlibcodigoofic', 'txlibcodigoofic');
                $rsm->addFieldResult('l', 'txlibcodigoofic13', 'txlibcodigoofic13');
                $rsm->addFieldResult('l', 'txlibresumen', 'txlibresumen');
                $rsm->addFieldResult('l', 'txlibtomo', 'txlibtomo');
                $rsm->addFieldResult('l', 'txlibvolumen', 'txlibvolumen');
                //$rsm->addFieldResult('l', 'inlibidioma', 'inlibidioma');
                $rsm->addFieldResult('l', 'txlibpaginas', 'txlibpaginas');
                //$rsm->addFieldResult('l', 'inlibtittitulo', 'inlibtittitulo');
                $rsm->addEntityResult('LibreameBackendBundle:LbAutores', 'a');
                $rsm->addFieldResult('a', 'inidautor', 'inidautor');
                $rsm->addFieldResult('a', 'txautnombre', 'txautnombre');
                $rsm->addFieldResult('a', 'txautpais', 'txautpais');
                $rsm->addEntityResult('LibreameBackendBundle:LbEditoriales', 'e');
                $rsm->addFieldResult('e', 'inideditorial', 'inideditorial');
                $rsm->addFieldResult('e', 'txedinombre', 'txedinombre');
                $rsm->addFieldResult('e', 'txedipais', 'txedipais');
                //Consulta libros por indice en tabla libro
                $txsql = "SELECT inlibro, txlibtipopublica, txlibtitulo,txlibedicionanio, txlibedicionnum, "
                        . "txlibedicionpais, txediciondescripcion, txlibcodigoofic, txlibcodigoofic13, "
                        . "txlibresumen, txlibtomo, txlibvolumen, txlibpaginas FROM lb_libros "
                         ." WHERE MATCH(txlibtitulo,txlibedicionpais, " 
                         ." txediciondescripcion,txlibcodigoofic,txlibcodigoofic13," 
                         ." txlibresumen,txlibvolumen) AGAINST ('".$texto."*' IN BOOLEAN MODE)";
                $query = $em->createNativeQuery( $txsql, $rsm ); 
                $libros = $query->getResult();
                foreach ($libros as $libro) {
                    //echo "ENTRO:"."\n";
                    $arLibros[] = $libro->getInlibro();
                    $libroID = $libro->getInlibro();
                    //echo "**BUSCAR LIBRO :".$libroID."-".$libro->getTxlibtitulo()."\n";
                }

                //Consulta libros por indice en tabla autores
                $txsql = "SELECT inidautor, txautnombre, txautpais FROM lb_autores "
                         ." WHERE MATCH(txautnombre,txautpais) AGAINST ('".$texto."*' IN BOOLEAN MODE)";
                $query = $em->createNativeQuery( $txsql, $rsm ); 
                $autores = $query->getResult();
                foreach ($autores as $autor) {
                    $aut_libros = ManejoDataRepository::getLibrosByAutor($autor->getInidautor());
                    foreach ($aut_libros as $autlibro) {
                        //echo "ENTRO:"."\n";
                        $arLibros[] = $autlibro->getInautlidlibro();
                        $libroID = $autlibro->getInautlidlibro();
                        //echo "**BUSCAR LIBRO :".$libroID."-".$libro->getTxlibtitulo()."\n";
                    }
                }

                //Consulta libros por indice en tabla editoriales
                $txsql = "SELECT inideditorial, txedinombre, txedipais FROM lb_editoriales "
                         ." WHERE MATCH(txedinombre,txedipais) AGAINST ('".$texto."*' IN BOOLEAN MODE)";
                $query = $em->createNativeQuery( $txsql, $rsm ); 
                $editoriales = $query->getResult();
                foreach ($editoriales as $editorial) {
                    $edi_libros = ManejoDataRepository::getLibrosByEditorial($editorial->getInideditorial());
                    foreach ($edi_libros as $edilibro) {
                        //echo "ENTRO:"."\n";
                        $arLibros[] = $edilibro->getInediliblibro();
                        $libroID = $edilibro->getInediliblibro();
                        //echo "**BUSCAR LIBRO :".$libroID."-".$libro->getTxlibtitulo()."\n";
                    }
                }
                $q = $em->createQueryBuilder()
                    ->select('e')
                    ->from('LibreameBackendBundle:LbEjemplares', 'e')
                    ->leftJoin('LibreameBackendBundle:LbUsuarios', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.inusuario = e.inejeusudueno')
                    ->leftJoin('LibreameBackendBundle:LbMembresias', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.inmemusuario = e.inejeusudueno')
                    ->leftJoin('LibreameBackendBundle:LbHistejemplar', 'h', \Doctrine\ORM\Query\Expr\Join::WITH, 'h.inhisejeejemplar = e.inejemplar and h.inhisejeusuario = e.inejeusudueno')
                    ->where(' e.inejelibro in (:plibros)')  
                    ->setParameter('plibros', $arLibros)
                    ->andWhere(' u.inusuestado = :estado')//Solo los usuarios con estado 1
                    ->setParameter('estado', 1)//Solo los usuarios con estado 1
                    ->andWhere(' e.inejepublicado <= :ppublicado')//Debe cambiar a solo los ejemplares publicados = 1
                    ->setParameter('ppublicado', 1)//Debe cambiar a solo los ejemplares publicados = 1                    
                    ->andWhere(' h.inhisejemovimiento = :pmovimiento')
                    ->setParameter('pmovimiento', 1)//Todos los ejemplares con registro de movimiento en historia ejemplar: publicados 
                    ->andWhere(' m.inmemgrupo in (:grupos) ')//Para los grupos del usuario
                    ->setParameter('grupos', $grupos)
                    ->setMaxResults(30)
                    ->orderBy(' h.fehisejeregistro ', 'DESC');

                //echo "ACABO: "."\n";
                $resejemplares = $q->getQuery()->getResult();  
                $em->flush();

                return $resejemplares;
            }
            
        } catch (Exception $ex) {
                return new LbEjemplares();
        } 
    }
                
    //Obtiene todos los Ejemplares, de un usuario
    //1: Todos, 2: En negociación, 3: Publicados, 4: No publicados, 5: Bloqueados
    public function getVisualizarBiblioteca(LbUsuarios $usuario, Array $grupos, $filtro)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            //Los ejemplares cuya membresías coincidan con las del usuario que solicita
            //El usuario debe estar activo
            //Estado de la negocuación actual : 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 
            //3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega 5 - Entregado, 6 - Recibido
            $em = $this->getDoctrine()->getManager();
            switch($filtro){
                case AccesoController::inDatoUno : //Todos
                    $q = $em->createQueryBuilder()
                        ->select('e')
                        ->from('LibreameBackendBundle:LbEjemplares', 'e')
                        ->leftJoin('LibreameBackendBundle:LbUsuarios', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.inusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbMembresias', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.inmemusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbHistejemplar', 'h', \Doctrine\ORM\Query\Expr\Join::WITH, 'h.inhisejeejemplar = e.inejemplar and h.inhisejeusuario = e.inejeusudueno')
                        ->where(' u.inusuario = :pusuario')
                        ->setParameter('pusuario', $usuario)
                        ->andWhere(' m.inmemgrupo in (:grupos) ')//Para los grupos del usuario
                        ->setParameter('grupos', $grupos)
                        //->setMaxResults(10000)
                        ->orderBy(' h.fehisejeregistro ', 'DESC');
                        break;
                case AccesoController::inDatoDos :  //En negociación
                    $q = $em->createQueryBuilder()
                        ->select('e')
                        ->from('LibreameBackendBundle:LbEjemplares', 'e')
                        ->leftJoin('LibreameBackendBundle:LbUsuarios', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.inusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbMembresias', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.inmemusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbHistejemplar', 'h', \Doctrine\ORM\Query\Expr\Join::WITH, 'h.inhisejeejemplar = e.inejemplar and h.inhisejeusuario = e.inejeusudueno')
                        ->where(' u.inusuario = :pusuario')
                        ->setParameter('pusuario', $usuario)
                        ->andWhere(' m.inmemgrupo in (:grupos) ')//Para los grupos del usuario
                        ->setParameter('grupos', $grupos)
                        ->andWhere(' e.inejeestadonegocio IN (1, 2, 3, 4) ')//En negociación (Si está entregado o recibido, ya no es del usuario)
                        //->setMaxResults(10000)
                        ->orderBy(' h.fehisejeregistro ', 'DESC');
                        break;
                case AccesoController::inDatoTre :  //Publicados
                    $q = $em->createQueryBuilder()
                        ->select('e')
                        ->from('LibreameBackendBundle:LbEjemplares', 'e')
                        ->leftJoin('LibreameBackendBundle:LbUsuarios', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.inusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbMembresias', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.inmemusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbHistejemplar', 'h', \Doctrine\ORM\Query\Expr\Join::WITH, 'h.inhisejeejemplar = e.inejemplar and h.inhisejeusuario = e.inejeusudueno')
                        ->where(' u.inusuario = :pusuario')
                        ->setParameter('pusuario', $usuario)
                        ->andWhere(' m.inmemgrupo in (:grupos) ')//Para los grupos del usuario
                        ->setParameter('grupos', $grupos)
                        ->andWhere(' e.inejepublicado = 1 ')//Publicados
                        //->setMaxResults(10000)
                        ->orderBy(' h.fehisejeregistro ', 'DESC');
                        break;
                case AccesoController::inDatoCua :  //No Publicados
                    $q = $em->createQueryBuilder()
                        ->select('e')
                        ->from('LibreameBackendBundle:LbEjemplares', 'e')
                        ->leftJoin('LibreameBackendBundle:LbUsuarios', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.inusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbMembresias', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.inmemusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbHistejemplar', 'h', \Doctrine\ORM\Query\Expr\Join::WITH, 'h.inhisejeejemplar = e.inejemplar and h.inhisejeusuario = e.inejeusudueno')
                        ->where(' u.inusuario = :pusuario')
                        ->setParameter('pusuario', $usuario)
                        ->andWhere(' m.inmemgrupo in (:grupos) ')//Para los grupos del usuario
                        ->setParameter('grupos', $grupos)
                        ->andWhere(' e.inejepublicado = 0 ')//No publicados
                        //->setMaxResults(10000)
                        ->orderBy(' h.fehisejeregistro ', 'DESC');
                        break;
                case AccesoController::inDatoCin:  //Bloqueados
                    $q = $em->createQueryBuilder()
                        ->select('e')
                        ->from('LibreameBackendBundle:LbEjemplares', 'e')
                        ->leftJoin('LibreameBackendBundle:LbUsuarios', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.inusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbMembresias', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.inmemusuario = e.inejeusudueno')
                        ->leftJoin('LibreameBackendBundle:LbHistejemplar', 'h', \Doctrine\ORM\Query\Expr\Join::WITH, 'h.inhisejeejemplar = e.inejemplar and h.inhisejeusuario = e.inejeusudueno')
                        ->where(' u.inusuario = :pusuario')
                        ->setParameter('pusuario', $usuario)
                        ->andWhere(' m.inmemgrupo in (:grupos) ')//Para los grupos del usuario
                        ->setParameter('grupos', $grupos)
                        ->andWhere(' e.inejebloqueado = 1 ')//Bloqueados
                        //->setMaxResults(10000)
                        ->orderBy(' h.fehisejeregistro ', 'DESC');
                        break;
                    
            }    

            return $q->getQuery()->getResult();
            //return $q->getArrayResult();
        } catch (Exception $ex) {
                //echo "retorna error";
                return new LbEjemplares();
        } 
    }
                
    //Obtiene las calificaciones RECIBIDAS por un usuario
    public function getCalificaUsuarioRecibidas(LbUsuarios $usuario)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbCalificausuarios')->
                    findBy(array('incalusucalificado' => $usuario));
        } catch (Exception $ex) {
                //echo "error";
                return new LbCalificausuarios();
        } 
    }
    
    //Obtiene las calificaciones REALIZADAS por un usuario
    public function getCalificaUsuarioRealizadas(LbUsuarios $usuario)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbCalificausuarios')->
                    findBy(array('incalusucalifica' => $usuario));

        } catch (Exception $ex) {
                return new LbCalificausuarios();
        } 
    }

    //Publica un mensaje
    public function publicaMensajes(LbMensajes $mensaje)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            //Verifica el tipo de mensaje para determinar si tiene que enviar a más 
            //destinatarios tambien envía correos.
            $tipomensaje = $mensaje->getInmenorigen();
            switch ($tipomensaje) {
                case AccesoController::inMsPubEjem:
                    
                
            }
            
            return $query->getResult();

        } catch (Exception $ex) {
                return new LbMensajes();
        } 
    }
    

    //Obtiene los mensajes asociados a un usuario
    public function getMensajesUsuario(LbUsuarios $usuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            //echo "[id: ".$usuario->getInusuario()."]\n";
            //echo "[USUARIO: ".$usuario->getTxusuemail()."]\n";
            
            $sql = "SELECT e FROM LibreameBackendBundle:LbMensajes e "
                    . " WHERE e.inmenusuario = :usr"
                    . " OR e.inmenusuarioorigen = :usr";

            $query = $em->createQuery($sql)->setParameter('usr', $usuario);
            //echo $sql;ge
            return $query->getResult();

        } catch (Exception $ex) {
                return new LbMensajes();
        } 
    }
    
    //Marca un mensaje como Leído / No leído
    public function setMarcaMensaje($psolicitud)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            $negociacion = new LbNegociacion();
            $negociacion = $em->getRepository('LibreameBackendBundle:LbNegociacion')->
                    findOneBy(array('inidnegociacion' => $psolicitud->getIdmensaje()));
            
            if ($negociacion != NULL) {
                if($negociacion->getInnegusuduenho()==$usuario) {
                    $negociacion->setInnegmensleidodue($psolicitud->getMarcacomo());
                } else {
                    $negociacion->setInnegmensleidosol($psolicitud->getMarcacomo());
                }
                $em->persist($negociacion);
                $em->flush();
                $resp = AccesoController::inExitoso;
            } else {
                $resp = AccesoController::inMenNoEx;
            }
            
            return $resp;
        } catch (Exception $ex) {
                return new LbMensajes();
        } 
    }
    
    //Actualiza datos de usuario
    public function setActualizaUsuario(Solicitud $psolicitud)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            $lugar = ManejoDataRepository::getLugar($psolicitud->getUsuLugar());
            
            if ($psolicitud->getUsuFecNac() != ""){
                $d = new DateTime($psolicitud->getUsuFecNac());
            }
            
            if ($psolicitud->getTelefono() == "")
                $usuario->setTxusutelefono($psolicitud->getEmail());
            else
                $usuario->setTxusutelefono($psolicitud->getTelefono());
            
            $usuario->setInusulugar($lugar);
            $usuario->setInusugenero($psolicitud->getUsuGenero());
            //Cargar imágen usuario
            $usuario->setTxusuimagen(AccesoController::txMeNoIdS);
            //$usuario->setTxusuimagen($psolicitud->getUsuImagen());
            $usuario->setTxusunombre($psolicitud->getNomUsuario());
            $usuario->setTxusunommostrar($psolicitud->getNomMostUsuario());
            if ($psolicitud->getUsuFecNac() != ""){
                $usuario->setFeusunacimiento($d);
            }
           
            $em->persist($usuario);
            $em->flush();
            //Cargar imágen usuario
            if ($psolicitud->getUsuImagen() != "") {
                //echo "setActualizaUsuario: Calcula imágen  \n" ;
                $usuario->setTxusuimagen(ManejoDataRepository::getImportarImagenB64($psolicitud->getUsuImagen(), $usuario->getInusuario(), AccesoController::txIndCarpImgUsua));
                $this->inImagenValida = AccesoController::inDatoUno;
            } else {
                //echo "setActualizaUsuario: La imágen viene vacia \n" ;
                $this->inImagenValida = AccesoController::inDatoUno;
            }
            
            if ($this->inImagenValida == AccesoController::inDatoUno){
                $em->persist($usuario);
                $em->flush();
                $resp = AccesoController::inExitoso;
                //echo "setActualizaUsuario: La imágen es válida [".$resp."]\n" ;
            } else {
                $resp = AccesoController::inErrImag;
                //echo "setActualizaUsuario: La imágen NO es válida [".$resp."] \n" ;
            }
            
            return $resp;
        } catch (Exception $ex) {
                return new LbUsuarios();
        } 
    }
    
    //Actualiza clave de usuario
    public function setCambiarClave(Solicitud $psolicitud)
    {   
        try{
            $resp = AccesoController::inFallido;
            //echo 'usuario FALLIDO '.$resp;
            $em = $this->getDoctrine()->getManager();
            
            $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            //echo 'usuario FALLIDO '.$resp;
            //if ($psolicitud->getUsuFecNac() != ""){
            //    $d = new DateTime($psolicitud->getUsuFecNac());
            //}
            
            $usuario->setTxusuclave($psolicitud->getClaveNueva());
           
            $em->persist($usuario);
            $em->flush();
            $resp = AccesoController::inExitoso;
            
            return $resp;
        } catch (Exception $ex) {
                return  AccesoController::inFallido;
        } 
    }
                
    //Guarda CUALQUIER ENTIDAD del parametro
    public function persistEntidad($entidad)
    {   
        try{
            //echo "<script>alert('1Persiste usuario')</script>";
            $em = $this->getDoctrine()->getManager();
            $em->persist($entidad);
            $em->flush();
            //echo "<script>alert('2Persiste usuario')</script>";
        } catch (Exception $ex) {
                return null;
        } 
    }
    
   
    /*
     * Recupera un comentario, con su Id numerico
     */
    public function getComentarioById($idcomentario){
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbComentarios')->
                    findOneBy(array('inidcomentario' => $idcomentario));

        } catch (Exception $ex) {
                return new LbComentarios();
        } 
    }
    
    /*
     * Crea registro en generolibro, para el genero por defecto y lo rtorna
     */
    public function asociarGeneroBasicoLibro(LbLibros $libro, $em){
        $generolibro = new LbGeneroslibros();
        try{
            //$em = $this->getDoctrine()->getManager();
            $genero = $em->getRepository('LibreameBackendBundle:LbGeneros')->
                    findOneBy(array('ingenero'=>AccesoController::inIdGeneral));
            
            $generolibro->setIngligenero($genero);
            $generolibro->setInglilibro($libro);
            
            //$em->persist($generolibro);
            //$em->flush();    
            return $generolibro;
        } catch (Exception $ex) {
            return $generolibro;
        } 
    }

    /*
     * Metodo para crear un libro desde una solicitud, en $cual: la P indica que es el 
     * PUBLICADO, la S, que es SOLICITADO
     */
    public function crearLibro(Solicitud $psolicitud, $cual)
    {
        $libro = new LbLibros(); 
        try {
            //$em = $this->getDoctrine()->getManager();
            //$libro->setTxlibtipopublica($psolicitud->getTipopublica());  
            if ($cual == AccesoController::txEjemplarPub) {
                $libro->setTxlibtitulo($psolicitud->getTitulo());  
                $libro->setTxlibidioma($psolicitud->getIdioma());  
            } elseif ($cual == AccesoController::txEjemplarSol1) {
                $libro->setTxlibtitulo($psolicitud->getTituloSol1());  
                $libro->setTxlibidioma($psolicitud->getIdioma());  
            } elseif ($cual == AccesoController::txEjemplarSol2) {
                $libro->setTxlibtitulo($psolicitud->getTituloSol2());  
                $libro->setTxlibidioma($psolicitud->getIdioma());  
            }
            $libro->setTxlibautores(AccesoController::txMenNoId);  
            $libro->setTxlibeditorial(AccesoController::txMenNoId);  
            $libro->setTxlibedicionanio(AccesoController::txMeNoIdS);  
            $libro->setTxlibedicionnum(AccesoController::txMeNoIdS);  
            $libro->setTxlibedicionpais(AccesoController::txMenNoId); 
            $libro->setTxediciondescripcion(AccesoController::txMenNoId);  
            $libro->setTxlibcodigoofic(AccesoController::txMenNoId);  
            $libro->setTxlibcodigoofic13(AccesoController::txMenNoId);  
            $libro->setTxlibresumen(AccesoController::txMenNoId);  
            $libro->setTxlibtomo(AccesoController::txMenNoId);  
            $libro->setTxlibvolumen(AccesoController::txMenNoId);  
            $libro->setTxpaginas(AccesoController::txMenNoId);  
            //$em->persist($libro);
            //$em->flush();   

            return $libro;
        } catch (Exception $ex)  {    
            return $libro;
        }
    }
    
    /*
     * Crea un ejemplar a partir de una solicitud y el libro que representa
     */
    public function crearEjemplar(Solicitud $psolicitud, LbLibros $libro, LbUsuarios $usuario)
    {
        $imagen = base64_encode($psolicitud->getImageneje());
        $ejemplar = new LbEjemplares();
        try {
            //$em = $this->getDoctrine()->getManager();
            $ejemplar->setInejecantidad(AccesoController::inIdGeneral);//Se utiliza esta constante porque representa el # 1  
            $ejemplar->setDbejeavaluo($psolicitud->getAvaluo());  
            $ejemplar->setInejelibro($libro);  
            $ejemplar->setInejeusudueno($usuario);  
            $ejemplar->setTxejeimagen($imagen);  
     
            //$em->persist($ejemplar);
            //$em->flush();    
            
            return $ejemplar;
        } catch (Exception $ex)  {    
            return $ejemplar;
        }
    }
    
    //Cierra la sesion de un usuario 
    public function cerrarSesionUsuario(LbSesiones $sesion)
    {   
        try{
            setlocale (LC_TIME, "es_CO");
            $fecha = new \DateTime;
            $em = $this->getDoctrine()->getManager();
            
            $sesion->setFesesfechafin($fecha);
            $sesion->setInsesactiva(AccesoController::inDatoCer);
            
            $em->persist($sesion);
            
            $em->flush();
            
            return $sesion;
        } catch (Exception $ex) {
             return new LbSesiones();
        } 
    }

    //Busca un Libro por su titulo
    public function buscarLibroByTitulo($titulo, $em)
    {
        try{
            $libro = new LbLibros();
            $sql = "SELECT l FROM LibreameBackendBundle:LbLibros l"
                    ." WHERE lower(l.txlibtitulo) LIKE lower(:titulo)";
            $query = $em->createQuery($sql)->setParameter('titulo', '%'.$titulo.'%');
            $libro = $query->getOneOrNullResult();
            return $libro;

            /*return $em->getRepository('LibreameBackendBundle:LbLibros')->
                    findOneBy(array('lower(txlibtitulo)' => '%'.$titulo.'%'));*/

        } catch (Exception $ex) {
            return new LbLibros();
        } 
    }
    

    //Función que retorna la cantidad de mensajes que un usuario tiene sin leer en la plataforma
    public function cantMsgUsr($usuario)
    {
        try{
            /*$em = $this->getDoctrine()->getManager();
            $sql = "SELECT COUNT(m) FROM LibreameBackendBundle:LbMensajes m"
                    ." WHERE m.inmenusuario = :usuario";
            $query = $em->createQuery($sql)->setParameter('usuario', $usuario);
            $cantmensajes = $query->getSingleScalarResult();
            $em->flush();*/
        
            $cantmensajes = 5;
            return $cantmensajes;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
    
    //Adiciona todo el texto de un libro, al indice 
    public function indexar(LbLibros $libro, $texto, $em)
    {
        try{
            //echo "FULL: ".$texto."\n";
            $arPalDescartar = array('a', 'ante', 'bajo', 'con', 'contra', 'de', 'desde', 
                'en', 'entre', 'hacia', 'hasta', 'para', 'por', 'segun', 'sin', 'so', 
                'sobre', 'tras', 'yo', 'tu', 'usted', 'el', 'nosotros', 'vosotros', 
                'ellos', 'ellas', 'ella', 'la', 'los', 'la', 'un', 'una', 'unos', 
                'unas', 'es', 'del', 'de', 'mi', 'mis', 'su', 'sus', 'lo', 'le', 'se', 
                'si', 'lo', 'identificar', 'no', 'al', 'que', '1', '2', '3', '4', '5', 
                '6', '7', '8', '9', '0', '(', ',', '.', ')', '"', '&', '/', '-', '=', 
                'y', 'o', '¡', '¿', '?', ':'); 
            if ($em == NULL) { $flEm = TRUE; } else  { $flEm = FALSE; }
            
            if ($flEm) {$em = $this->getDoctrine()->getManager();}
            //echo $texto."\n ----------------------"; 
            $texto = str_replace('(', '', $texto); 
            $texto = str_replace('¡', '', $texto);
            $texto = str_replace('?', '', $texto);
            $texto = str_replace('-', '', $texto);
            $texto = str_replace('/', '', $texto);
            $texto = str_replace('=', '', $texto);
            $texto = str_replace('&', '', $texto);
            $texto = str_replace(',', '', $texto);
            $texto = str_replace('.', '', $texto);
            $texto = str_replace(')', '', $texto);
            $texto = str_replace('"', '', $texto);
            $texto = str_replace(':', '', $texto);
            //echo $texto."\n ----------------------"; 

            $palabras = explode(" ", $texto);
            $repetidos = [];
            
            foreach ($palabras as $palabra)
            {   
                //echo "... ".$palabra."\n";
                if(!in_array(strtolower($palabra), $arPalDescartar) and 
                        !in_array(strtolower($palabra), $repetidos) and $palabra != "")
                {
                    if (!$em->getRepository('LibreameBackendBundle:LbIndicepalabra')->
                        findOneBy(array('lbindpalpalabra' => $palabra, 'lbindpallibro' => $libro)))
                    {    
                        //echo "   SI   \n";
                        $indice = new LbIndicepalabra();
                        $indice->setLbindpallibro($libro);
                        $dioma = $libro->getInlibidioma();
                        if ($dioma == NULL)
                            $indice->setLbindpalidioma("Sin especificar");
                        else
                            $indice->setLbindpalidioma(utf8_encode($idioma()->getTxidinombre()));
                        $indice->setLbindpalpalabra(strtolower($palabra));
                        $em->persist($indice);
                        $repetidos[] = $palabra; 
                    }
                }
            }
            
            if ($flEm) {$em->flush();}
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }    
    
    //Obtiene la lista de idiomas
    public function getListaIdiomas()
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            $sql = "SELECT i FROM LibreameBackendBundle:LbIdiomas i ";
            $query = $em->createQuery($sql);
            foreach ($query->getResult() as $regidioma){
                $idiomas[] = $regidioma->getTxidinombre();
                //echo $idiomas;
                //echo $regidioma->getInididioma().' '.$regidioma->getTxidinombre();
            }            
            //echo $query->getResult(); 
            //echo "Acabo"; 
            return $query->getResult();
            //return $idiomas;

        } catch (Exception $ex) {
                return new LbIdiomas();
        } 
    }
    
    //Obtiene la lista de editoriales
    public function getListaEditoriales()
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            $sql = "SELECT e FROM LibreameBackendBundle:LbEditoriales e ";
            $query = $em->createQuery($sql);
            
            return $query->getResult();

        } catch (Exception $ex) {
                return new LbEditoriales();
        } 
    }
    
    //Obtiene la lista de autores
    public function getListaAutores()
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            $sql = "SELECT a FROM LibreameBackendBundle:LbAutores a ";
            $query = $em->createQuery($sql);
            
            return $query->getResult();
            //return $idiomas;

        } catch (Exception $ex) {
                return new LbAutores();
        } 
    }
    
   //Marca un Megusta en un ejemplar
    public function setMegustaEjemplar($ejemplar, $megusta, $usuario)
    {   
        try{
            setlocale (LC_TIME, "es_CO");
            $fecha = new \DateTime;
            $em = $this->getDoctrine()->getManager();
            $ObjEjemplar = ManejoDataRepository::getEjemplarById($ejemplar);
            $ObjUsuario = ManejoDataRepository::getUsuarioByEmail($usuario);
            
            $megustaEjemplar = ManejoDataRepository::getRegMegustaEjemplar($ObjEjemplar, $ObjUsuario);
            
            if ($megustaEjemplar == NULL) {
                $megustaEjemplar = new LbMegusta();
                $megustaEjemplar->setInmegejemplar($ObjEjemplar);
                $megustaEjemplar->setInmegusuario($ObjUsuario);
                $megustaEjemplar->setInmegmegusta($megusta);
                $megustaEjemplar->setFemegmegusta($fecha);
            } else {
                $megustaEjemplar->setInmegmegusta($megusta);
                $megustaEjemplar->setFemegmegusta($fecha);
            }
            $em->persist($megustaEjemplar);

            $em->flush();
            return AccesoController::inDatoUno;

        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
    
   //Envia un comentario a un ejemplar
    public function setComentarioEjemplar(Solicitud $psolicitud)
    {   
        try{
            setlocale (LC_TIME, "es_CO");
            $fecha = new \DateTime;
            $em = $this->getDoctrine()->getManager();
            $ObjEjemplar = ManejoDataRepository::getEjemplarById($psolicitud->getIdEjemplar());
            $ObjUsuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            if($psolicitud->getIdComentario() == ""){//Si no viene el Id del cometario, es porque es nuevo
                $comentarioEjemplar = new LbComentarios();
                $comentarioEjemplar->setFecomfeccomentario($fecha);
                $comentarioEjemplar->setIncomactivo(AccesoController::inDatoUno);
                if($psolicitud->getIdComPadre() != ""){ 
                    $compadre = ManejoDataRepository::getComentarioById($psolicitud->getIdComPadre());
                    $comentarioEjemplar->setIncomcompadre($compadre);
                }
                $comentarioEjemplar->setIncomejemplar($ObjEjemplar);
                $comentarioEjemplar->setIncomusuario($ObjUsuario);
                $comentarioEjemplar->setTxcomcomentario(utf8_encode($psolicitud->getComentario()));
            } else { //Si no viene, puede ser Edicion o borrado
                $comentarioEjemplar = new LbComentarios();
                $comentarioEjemplar = ManejoDataRepository::getComentarioById($psolicitud->getIdComentario());
                if($psolicitud->getAccionComm()=="0"){ //Si es 0: borrado
                    $comentarioEjemplar->setIncomactivo(AccesoController::inDatoCer);
                } else if($psolicitud->getAccionComm()=="1")  { //Si es 1: edicion, modifica la fecha y el texto
                    $comentarioEjemplar->setFecomfeccomentario($fecha);
                    $comentarioEjemplar->setTxcomcomentario(utf8_encode($psolicitud->getComentario()));
                }
            }

            $em->persist($comentarioEjemplar);

            $em->flush();
            return AccesoController::inDatoUno;

        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
 
   //Envia un mensaje en el chat de negociacion por un ejemplar
    public function setMensajeChat(Solicitud $psolicitud)
    {   
        try{
            //Si el mensaje viene en blanco, no se genera nada
            $respuesta = NULL;
            setlocale (LC_TIME, "es_CO");
            $fecha = new \DateTime;
            $em = $this->getDoctrine()->getManager();
            $objEjemplar = ManejoDataRepository::getEjemplarById($psolicitud->getIdEjemplar());
            $usrEscribe = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            $usrDestino = ManejoDataRepository::getUsuarioById($psolicitud->getIdusuariodes());
            $usrPropiet = $objEjemplar->getInejeusudueno();
            if ($usrEscribe == $usrPropiet) { //Si el usuario que escribe es el propietario, solicitante = destinatario; si son diferentes, solicitante = escribe
                $usrSolicit = $usrDestino;
            } else {
                $usrSolicit = $usrEscribe;
            } 
            $mensaje = $psolicitud->getComentario();
            $negIdConver = "D".$usrPropiet->getInusuario()."S".$usrSolicit->getInusuario()."E".$objEjemplar->getInejemplar();
            //echo "tratoacep : ".$psolicitud->getTratoAcep();
            // Si el registro es de 1 Aceptacion o 0: Rechazo, el mensaje es personalizado con una constante
            
            switch ($psolicitud->getTratoAcep()) {
                case AccesoController::inAccMsgNormal: //si es = -1
                    //echo "entro a tratoacep : -1";
                    $mensaje = $psolicitud->getComentario();
                    break;
                case AccesoController::inAccMsgCancel: //si es = 0
                    //echo "entro a tratoacep : 0";
                    $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgRechazoTr);
                    break;
                case AccesoController::inAccMsgAcepta: //si es = 1
                    //echo "entro a tratoacep : 1";
                    $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgAceptaTr);
                    break;
                case AccesoController::inAccMsgOferta: //si es = 2
                    //echo "entro a tratoacep : 2";
                    $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgHaceOferta);
                    break;
                case AccesoController::inAccMsgContra: //si es = 3
                    //echo "entro a tratoacep : 3";
                    $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgContraoferta);
                    break;
                case AccesoController::inAccMsgEntreg: //si es = 4
                    //echo "entro a tratoacep : 4";
                    $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgEntregaEjem);
                    break;
                case AccesoController::inAccMsgRecibe: //si es = 5
                    //echo "entro a tratoacep : 5";
                    $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgRecibeEjem);
                    break;
                case AccesoController::inAccMsgSCalif: //si es = 6
                    //echo "entro a tratoacep : 6";
                    $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgCalificacion);
                    break;
                case AccesoController::inAccMsgDCalif: //si es = 7
                    //echo "entro a tratoacep : 7";
                    $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgCalificacion);
                    break;
                case AccesoController::inAccMsgFinali: //si es = 10
                    //echo "entro a tratoacep : 10";
                    $mensaje = AccesoController::txMsgFinalizacion;
                    break;
            }
            if ($mensaje != "")
            {
                $chatNegociacion = new LbNegociacion();
                $chatNegociacion->setFenegfechamens($fecha);
                $chatNegociacion->setInnegmensleidodue(AccesoController::inDatoCer);
                $chatNegociacion->setInnegmensleidosol(AccesoController::inDatoCer);
                $chatNegociacion->setInnegmenseliminado(AccesoController::inDatoCer);
                $chatNegociacion->setInnegejemplar($objEjemplar);
                $chatNegociacion->setInnegusuduenho($usrPropiet);
                $chatNegociacion->setInnegusuescribe($usrEscribe);
                $chatNegociacion->setInnegususolicita($usrSolicit);
                $chatNegociacion->setTxnegmensaje(utf8_encode($mensaje));
                $chatNegociacion->setTxnegidconversacion($negIdConver);
                $chatNegociacion->setInnegtratoacep($psolicitud->getTratoAcep());

                $em->persist($chatNegociacion);

                $em->flush();
            }
            $respuesta = $negIdConver;
            
            //echo "Conversacion : ".$negIdConver;
                
            return $respuesta;

        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
 
    
   //Envia un registro de calificacion a un usuario y un registro historico del ejemplar:: Cierra el ciclo de negociacion
    public function setCalificaUsuarioTrato(Solicitud $psolicitud)
    {   
        try{
            $respuesta = NULL;
            setlocale (LC_TIME, "es_CO");
            $fecha = new \DateTime;
            $em = $this->getDoctrine()->getManager();
            //Obtiene : Ejemplar, usuario que califica y usuario calificado + Registro HistEjemplar de entrega o recibo. Hasta que no s
            $objEjemplar = ManejoDataRepository::getEjemplarById($psolicitud->getIdEjemplar());
            $usrCalifica = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            $usrCalificado = ManejoDataRepository::getUsuarioById($psolicitud->getIdusuariodes());
            //Registro historico de entrega o recibo
            $regHisRecEntr = ManejoDataRepository::getRegHisById($psolicitud->getInRegHisPublicacion());
            
            //Crea el registro histórico
            $regHisCalifica = new LbHistejemplar();
            $regHisCalifica->setFehisejeregistro($fecha);
            $regHisCalifica->setInhisejeejemplar($objEjemplar);
            $regHisCalifica->setInhisejeestado($fecha);
            $regHisCalifica->setInhisejemodoentrega($regHisRecEntr->getInhisejemodoentrega());
            $regHisCalifica->setInhisejepadre($regHisRecEntr);
            $regHisCalifica->setInhisejeusuario($usrCalifica);
            //Determinar cual es el usuario que califica AccesoController::txMovUsPCali
            //Si el registro padre es de Recibo = txMovReciEje, quien califica es el Solicitante  inMovUsSCali
            //Si el registro padre es de Entrega = txMovEntrEje, quien califica es el Dueño inMovUsPCali
            $fallido = AccesoController::inFallido;
            if ($regHisRecEntr->getInhisejemovimiento() == AccesoController::inMovEntrEje){
                $regHisCalifica->setInhisejemovimiento(AccesoController::inMovUsPCali);
                $fallido  = AccesoController::inExitoso; 
            } elseif ($regHisRecEntr->getInhisejemovimiento() == AccesoController::inMovReciEje) {
                $regHisCalifica->setInhisejemovimiento(AccesoController::inMovUsSCali);
                $fallido = AccesoController::inExitoso; 
            }
            
            if ($fallido  == AccesoController::inExitoso){
                //Crea el registro de calificaicon
                $regCalifica = new LbCalificausuarios();
                $regCalifica->setFecalfecha($fecha);
                $regCalifica->setIncalcalificacion($psolicitud->getInCalificacion());
                $regCalifica->setIncalhisejemplar($objEjemplar);
                $regCalifica->setIncalusucalifica($usrCalifica);
                $regCalifica->setIncalusucalificado($usrCalificado);
                $regCalifica->setTxcalcomentario($psolicitud->getComentario());

                $em->persist($regHisCalifica);
                $em->persist($regCalifica);
                $em->flush();
            }
            
            $respuesta = $fallido;

            return $respuesta;

        } catch (Exception $ex) {
                return AccesoController::inFallido;
        } 
    }
    
    //Valida datos de registro de    un usuario
    public function datosUsuarioValidos($usuario, $clave)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            
           //echo "manejodarepo:usr ".$usuario;
            //echo "manejodarepo:clave ".$clave;
            $vUsuario = new LbUsuarios();
            $vUsuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $usuario, 
                        'txusuvalidacion' => $clave, 
                        'inusuestado' => AccesoController::inDatoCer));
            
            //echo "mail ".$vUsuario->getTxusuemail();
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
            setlocale (LC_TIME, "es_CO");
            $fecha = new \DateTime;
            
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();


            $usuario->setInusuestado(AccesoController::inDatoUno);
            $usuario->setTxusuvalidacion($usuario->getTxusuvalidacion().'OK');

            $dispUsuario = ManejoDataRepository::getDispositivoUsuario(AccesoController::txAnyData,$usuario,$em);
            //Genera la sesion:: $pEstado,$pFecIni,$pFecFin,$pDevice,$pIpAdd
            $sesion = ManejoDataRepository::generaSesion(AccesoController::inSesInac, $fecha, $fecha, $dispUsuario, AccesoController::txMeNoIdS, $em);
            //Guarda la actividad de la sesion:: 
            ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,'Registro confirmado para usuario '.$usuario->getTxusuemail(), AccesoController::txAccConfRegi, $fecha, $fecha, $em);
            
            $em->persist($usuario);
            
            $em->flush();
            $em->getConnection()->commit();
            $respuesta=  AccesoController::inExitoso; 
            
            return $respuesta;

        } catch (Exception $ex) {
                return  AccesoController::inFallido;
        } 
    }    
    
     //Genera la carga y publicación de un ejemplar a la plataforma
    public function generarPublicacionEjemplar(Solicitud $psolicitud){
        
        //Para publicar un ejemplar
        //1. Validar en front end el Libro y autocompletar si es necesario,  
        //   @TODO:  está funcion debe realizarse como servicio
        //Cuando llega a este punto ya ha validado todas las condiciones del usuario, 
        //planes, restricciones, penalizaciones, etc...DEFINIR BIEN
        try{
            //echo "Inicia a generar la publicacion !!!";
            /*echo utf8_encode($psolicitud->getTitulo())."\n";
            //echo $psolicitud->getTitulo()."\n";
            //echo utf8_decode($psolicitud->getTitulo())."\n";*/
            
            $respuesta=  AccesoController::inFallido; 
            $fecha = new \DateTime;
            
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            
            //Recupera todas las variables de la solicitud
            $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            $libro = new LbLibros();
            $autor = new LbAutores();
            $editorial = new LbEditoriales();
            $imgbase64 = $psolicitud->getImageneje();
            $libroExiste = AccesoController::inFallido;
            //Si existe el libro, en la base de datos, se recupera por el ID
            if ($psolicitud->getIdLibro() != ""){
                //echo "Libro ID no es vacio: Entra a recuperarlo \n";
                $libroExiste = AccesoController::inExitoso;
                $libro = ManejoDataRepository::getLibro($psolicitud->getIdLibro());
                $asocAutor = AccesoController::inFallido;
                if ($psolicitud->getAutor() != "") {
                    $autor = ManejoDataRepository::getAutorByNombre($psolicitud->getAutor());
                    $asocAutor = AccesoController::inExitoso;
                }
                $asocEditorial = AccesoController::inFallido;
                if ($psolicitud->getEditorial() != "") {
                    $editorial = ManejoDataRepository::getEditorialByNombre($psolicitud->getEditorial());
                    $asocEditorial = AccesoController::inExitoso;
                }
            } else {
                //echo "Libro ID es vacio: Entra a crearlo ".$psolicitud->getAutor()." - ".$psolicitud->getEditorial()."\n";
                $libro = ManejoDataRepository::getLibroByTitulo($psolicitud->getTitulo());
                if ($libro == NULL) {
                    $libro = new LbLibros();
                    $libro->setTxlibtitulo($psolicitud->getTitulo());
                    $libro->setTxlibtipopublica(AccesoController::inTPLibro);
                    $libro->setTxediciondescripcion($psolicitud->getEdicion());
                    $em->persist($libro);
                    $em->flush();
                }
                //echo "Libro ID [".$libro->getInlibro()."] \n";
                
                $asocAutor = AccesoController::inFallido;
                if ($psolicitud->getAutor() != "") {
                    $autor = ManejoDataRepository::getAutorByNombre($psolicitud->getAutor());
                    if ($autor == NULL) {
                        //echo "Asigna el autor al objeto ".$psolicitud->getAutor()."\n";
                        $autor = new LbAutores();
                        $autor->setTxautnombre($psolicitud->getAutor());
                        $em->persist($autor);
                        $em->flush();
                        $asocAutor = AccesoController::inExitoso;
                    } else {
                        $asocAutor = AccesoController::inExitoso;
                    }
                }    
                
                $asocEditorial = AccesoController::inFallido;
                if ($psolicitud->getEditorial() != "") {
                    $editorial = ManejoDataRepository::getEditorialByNombre($psolicitud->getEditorial());
                    if ($editorial == NULL) {
                        //echo "Asigna la editorial al objeto ".$psolicitud->getEditorial()."\n";
                        $editorial = new LbEditoriales();
                        $editorial->setTxedinombre($psolicitud->getEditorial());
                        $em->persist($editorial);
                        $em->flush();
                        $asocEditorial = AccesoController::inExitoso;
                    } else {
                        $asocEditorial = AccesoController::inExitoso;
                    }
                }    
                
            }
            
            //Asocia Autor
            if ($asocAutor == AccesoController::inExitoso) {
                $autorlibro = new LbAutoreslibros();
                $autorlibro->setInautlidautor($autor);
                $autorlibro->setInautlidlibro($libro);
                $em->persist($autorlibro);
            }
                    
            //Asocia Editorial
            if ($asocEditorial == AccesoController::inExitoso) {
                $editoriallibro = new LbEditorialeslibros();
                $editoriallibro->setInedilibroeditorial($editorial);
                $editoriallibro->setInediliblibro($libro);
                $em->persist($editoriallibro);
            }
                    
            $avaluo = (Double)$psolicitud->getAvaluo();
            $puntos = (Integer)$avaluo/ AccesoController::inValPunto;
            $ejemplar = new LbEjemplares();
            $ejemplar->setInejelibro($libro);
            $ejemplar->setInejeusudueno($usuario);
            $ejemplar->setDbejeavaluo($avaluo);
            $ejemplar->setTxejeimagen(AccesoController::txMeNoIdS);
            $ejemplar->setInejepuntos($puntos);
            $ejemplar->setInejeestado($psolicitud->getEstado());
            $em->persist($ejemplar);
            $em->flush();
            //Cargar imágen ejemplar 
            //echo "Ejemplar ID [".$ejemplar->getInejemplar()."] \n";
            $ejemplar->setTxejeimagen(ManejoDataRepository::getImportarImagenB64($psolicitud->getImageneje(), $ejemplar->getInejemplar(), AccesoController::txIndCarpImgEjem));
            $em->persist($ejemplar);
            
            //Genera histótrico de registro
            $hisReg = new LbHistejemplar();
            $hisReg->setFehisejeregistro($fecha);
            $hisReg->setInhisejeejemplar($ejemplar);
            $hisReg->setInhisejemovimiento(AccesoController::inMovPubEjem);//Movimiento de publicación
            $hisReg->setInhisejemodoentrega(AccesoController::inModEntDomi);
            $hisReg->setInhisejeestado(AccesoController::inExitoso); //Estado Activo = 1
            $hisReg->setInhisejeusuario($usuario);
            $em->persist($hisReg);
            //$em->flush();
            
            ///PROXIMO PASO : CREAR LA TAREA PARA LOS USUARIOS QUE DARÁN VISTO BUENO AL PRECIO DEL LIBRO
            //Se buscan 10 usuarios de manera aleatoria para generarle una tarea
            $cont = 0;
            $arrUsers = [];
            $cantUsuarios = ManejoDataRepository::getCantidadUsuarios();
            while ($cont < 10) {
               $idRand = rand(1, $cantUsuarios);
               $usuConsulta = ManejoDataRepository::getUsuarioById($idRand);
               if ($usuConsulta != NULL){
                    if (($usuConsulta->getInusuestado() == AccesoController::inUsuActi) && (!in_array($idRand, $arrUsers))){
                       $arrUsers[] = $idRand;
                       $cont++;
                    }
               }
            }
            
            for ($i=0;$i<10;$i++){
               $usuConsulta = ManejoDataRepository::getUsuarioById($arrUsers[$i]);
               $tarea = new LbTareas();
               $tarea->setFefechatarea($fecha);
               $tarea->setInusuariotareaasi($usuConsulta);
               $tarea->setInusuariotareades($usuario);
               $tarea->setDbvalorejesugerido($avaluo);
               $tarea->setInejemplartareades($ejemplar);
               $tarea->setInaprobadovaloreje(AccesoController::inDatoCer);
               $tarea->setIntipotarea(AccesoController::inTipTarApru);
               $tarea->setInestadotarea(AccesoController::inEstTarPend);
               
               $em->persist($tarea);
            }
            
            
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = AccesoController::inExitoso; 
            return $respuesta;

        } catch (Exception $ex) {
                $em->getConnection()->rollback();
                return  AccesoController::inFallido;
        } 
        //2. Revisa si el libro existe, si no existe lo crea, de Igual manra la 
        //   editorial y el / los autores y el género
        //   De igual manera debe crearse el TITULO, el IDIOMA, el Pais de la 
        //   editorial como del Autor
        //3. Elige 10 usuarios activos para que califiquen el precio del libro, 
        //   el libro queda pendiente por publicacion, 
        //   envía correos y se crean tareas para los usuarios
        //7. En este momento los puntos del usuario no le aparecen, hasta que 
        //   no haya sido validado
        //8. Se crea un registro de historialejemplar, hay que revisar con que 
        //   tipo de Movimiento, porque debe adicionarse
        
    }

    public function getCantidadUsuarios() {
        try{
            $em = $this->getDoctrine()->getManager();
            $qs = $em->createQueryBuilder()
                ->select('count(u.inusuario)')
                ->from('LibreameBackendBundle:LbUsuarios', 'u');
            $cuenta = $qs->getQuery()->getSingleScalarResult();
            
            return $cuenta;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
        
    }
    

    //El parámetro $idElemento indica el ID del objeto, bien sea Usuario o Ejemplar
    //El parámetro $blEjemUsuario, indica "E", si es un ejemplar o "U" si es un usuario
    public function getImportarImagenB64($txImagenB64, $idElemento, $blEjemUsuario) {
        
        //set_error_handler("myFunctionErrorHandler", E_NOTICE);    
        $elem = (String)$idElemento;
        //echo "La cadena ".$ejem." \n";
        
        $chars = preg_split('//', $elem, -1, PREG_SPLIT_NO_EMPTY);
        //WIN \  LINUX /
        //Pregunta si es imagen de ejemplar, o de usuario
        if ($blEjemUsuario == AccesoController::txIndCarpImgEjem) {
            $carpeta = AccesoController::txCarpetaImgEjem;
            $carpetaWEB = AccesoController::txCarpWEMImgEjem;
        } else {
            $carpeta = AccesoController::txCarpetaImgUsua;
            $carpetaWEB = AccesoController::txCarpWEMImgUsua;
        }
        //Para el pruebas
        //$carpeta = "C:/xampp/htdocs/Ex4readBE/web/img/p/";
        //echo "Carpeta [".$carpeta."] \n";
        foreach ($chars as $digito) {
            $carpeta = $carpeta.$digito."/";
            $carpetaWEB = $carpetaWEB.$digito."/";
            //echo "Buscará si existe [".$carpeta."] \n";
            if (!file_exists($carpeta)) { 
                //echo "No existe directory [".$carpeta."], se creará ahora \n";
                mkdir($carpeta, 0755, true);
            } else {
                //echo "Si existe directory [".$carpeta."] \n";
            }
        }
        $base_to_php = explode(',', $txImagenB64);
        // El segundo item del array base_to_php contiene la información que necesitamos (base64 plano)
        // y usar base64_decode para obtener la información binaria de la imagen
        $data = base64_decode($base_to_php[1]);// BBBFBfj42Pj4....
        //echo "DATA DECODE ".$data;
        //echo "DATA : ".$data;
        
        $archivoOri = $carpeta.$elem."FULL.jpg"; // or image.jpg
        //echo $archivoOri." \n";
        $archivoOpt = $carpeta.$elem.".jpg"; // or image.jpg
        //echo $archivoOpt." \n";
        $archivoWEB = $carpetaWEB.$elem.".jpg"; // or image.jpg
        //echo $archivoWEB." \n";
        //echo "getImportarImagenB64: Borra archivos anteriores\n" ;
        if (file_exists($archivoOri)) {
            //echo "getImportarImagenB64: Existe ". $archivoOri ."\n" ;
            unlink($archivoOri);
        }
        if (file_exists($archivoOpt)) {
            //echo "getImportarImagenB64: Existe ". $archivoOpt ."\n" ;
            unlink($archivoOpt);
        }
        
        //echo "getImportarImagenB64: El archivo se poblará con datos". $archivoOri ."\n" ;
        file_put_contents($archivoOri, $data);  
        //set_error_handler(call_user_func(array($this,'myFunctionErrorHandler')), E_WARNING);
        set_error_handler(array($this,'myFunctionErrorHandler'), E_WARNING);
        
        try{
            $inTipoImg = exif_imagetype($archivoOri); 
            switch ($inTipoImg) {
                case IMAGETYPE_JPEG: {
                    //echo "getImportarImagenB64: JPEG \n" ;
                    $imagen = imagecreatefromjpeg($archivoOri);
                    break;
                }
                case IMAGETYPE_PNG: {
                    //echo "getImportarImagenB64: PNG \n" ;
                    $imagen = imagecreatefrompng($archivoOri);
                    break;
                }
                default: {
                    //echo "getImportarImagenB64: PNG \n" ;
                    $imagen = NULL;
                    break;
                }
            }
            
            if ($imagen != NULL) {
                //echo "getImportarImagenB64: Imágen valida \n" ;
                $this->inImagenValida = AccesoController::inDatoUno;
                //echo "Dato uno";
            } else {
                //echo "getImportarImagenB64: Imágen NO valida \n" ;
                $this->inImagenValida = AccesoController::inErrImag;
                unlink($archivoOri);
                //echo "Dato Cero";
            }
        } catch (Exception $e) {
            //imagejpeg($imagen, $archivo, 50);        
        }
        
        if ($this->inImagenValida == AccesoController::inDatoUno)
        {
            //echo "getImportarImagenB64: Si es válida : Almacena imagen \n" ;
            switch ($inTipoImg) {
                case IMAGETYPE_JPEG: imagejpeg($imagen, $archivoOpt);
                case IMAGETYPE_PNG: imagepng($imagen, $archivoOpt);;
            }
               
            unlink($archivoOri);
            //echo "Se creo el archivo: ".$archivoOri." [".$archivoWEB."] \n";
            return $archivoWEB;
        } else {
            //echo "--NO Se creo el archivo: ".$archivoOri." [".$archivoWEB."] \n";
            return AccesoController::txMeNoIdS;
        }
        
        restore_error_handler();
            
        //echo "El arhivo a crear : ".$archivo." \n";
        // Finalmente guarda la imágen en el directorio especificado y con la informacion dada
        //echo "Se creo el archivo: ".$archivo." [".$archivoWEB."], con los datos [".$txImagenB64."] \n";
        //echo "Se creo el archivo: ".$archivoOri." [".$archivoWEB."] \n";
        //   return "PENDIENTE;";
    }
    
    //Buscar los botones a mostrar dependiendo del usuario que está escribiendo
    //del estado de la negociacion y de la última acion realizada por el usuario
    public function getBotonesMostrar($conversa, $usuarioDueno, $ultAccion)
    {
        try {
            
            //Identifica si el usuario que esta escribiendo es el dueño o el solicitante
            if ($usuarioDueno == AccesoController::inDatoUno) //Es el dueño
            {
                //AQUI SE DEBE REVISAR NO SOLO LA ULTIMA ACCION, SINO EL ESTADO DE LA NEGOCIACION REVISAR BIEN EL TEMA
                switch ($ultAccion) {
                   case AccesoController::inAccMsgNormal: //si es = -1
                       //echo "entro a tratoacep : -1";
                       $mensaje = $psolicitud->getComentario();
                       break;
                   case AccesoController::inAccMsgCancel: //si es = 0
                       //echo "entro a tratoacep : 0";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgRechazoTr);
                       break;
                   case AccesoController::inAccMsgAcepta: //si es = 1
                       //echo "entro a tratoacep : 1";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgAceptaTr);
                       break;
                   case AccesoController::inAccMsgContra: //si es = 3
                       //echo "entro a tratoacep : 3";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgContraoferta);
                       break;
                   case AccesoController::inAccMsgEntreg: //si es = 4
                       //echo "entro a tratoacep : 4";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgEntregaEjem);
                       break;
                   case AccesoController::inAccMsgDCalif: //si es = 7
                       //echo "entro a tratoacep : 7";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgCalificacion);
                       break;
                   case AccesoController::inAccMsgFinali: //si es = 10
                       //echo "entro a tratoacep : 10";
                       $mensaje = AccesoController::txMsgFinalizacion;
                       break;
               }               

            } else {  // No es el dueño, es el solicitante
                switch ($ultAccion) {
                   case AccesoController::inAccMsgNormal: //si es = -1
                       //echo "entro a tratoacep : -1";
                       $mensaje = $psolicitud->getComentario();
                       break;
                   case AccesoController::inAccMsgCancel: //si es = 0
                       //echo "entro a tratoacep : 0";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgRechazoTr);
                       break;
                   case AccesoController::inAccMsgAcepta: //si es = 1
                       //echo "entro a tratoacep : 1";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgAceptaTr);
                       break;
                   case AccesoController::inAccMsgOferta: //si es = 2
                       //echo "entro a tratoacep : 2";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgHaceOferta);
                       break;
                   case AccesoController::inAccMsgRecibe: //si es = 5
                       //echo "entro a tratoacep : 5";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgRecibeEjem);
                       break;
                   case AccesoController::inAccMsgSCalif: //si es = 6
                       //echo "entro a tratoacep : 6";
                       $mensaje = str_replace("%usuario", $usrEscribe->getTxusunommostrar(), AccesoController::txMsgCalificacion);
                       break;
                   case AccesoController::inAccMsgFinali: //si es = 10
                       //echo "entro a tratoacep : 10";
                       $mensaje = AccesoController::txMsgFinalizacion;
                       break;
               }               
                
            }   
            $botones = "-1,0,1";
            return $botones;
 
            } catch (\Doctrine\DBAL\DBALException  $ex) {
                //echo "<script>alert('::::".$ex->getMessage()."')</script>";
                return AccesoController::inPlatCai;
        } 
    }

 
    
}