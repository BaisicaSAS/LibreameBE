<?php

namespace Libreame\BackendBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
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
use Libreame\BackendBundle\Helpers\Solicitud;


/**
 * Description of ManejoDataRepository
 *
 * @author mramirez
 */
class ManejoDataRepository extends EntityRepository {

    
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
               //echo "<script>alert('validaSesionUsuario :: No existe el USUARIO')</script>";
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
    
    //Obtiene la cantidad de Megusta del ejemplar : Condicion megusta - nomegusta 
    public function getMegustaEjemplar(LbEjemplares $pEjemplar, LbUsuarios $pUsuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $qmg = $em->createQueryBuilder()
                ->select('a.inmegmegusta')
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
                $meg = $qmg->getQuery()->getOneOrNullResult();//Si hay registro devuelve lo que hay
            }    
            
            //echo "megusta ".$meg;
            return $meg;
        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
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
            foreach($qneg->getQuery()->getResult() as $idconversacion){
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
                    $arrConversacion[] = array('inidnegociacion' => $negoc->getInidnegociacion(),
                        'innegmensleido' => $negoc->getInnegmensleido(),
                        'fenegfechamens' => $negoc->getFenegfechamens()->format("Y-m-d H:i:s"),
                        'txnegmensaje' => utf8_encode($negoc->getTxnegmensaje()),
                        'usrescribe' =>  $usuaEsc->getInusuario(),
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

    public function getHistoriaEjemplarBiblioteca(LbEjemplares $pejemplar, LbUsuarios $pusuario){   
        try{
            $em = $this->getDoctrine()->getManager();
            //Primero busca todos los que tengan hijos
            $histEjemplar = $em->createQueryBuilder()
                ->select('a')
                ->from('LibreameBackendBundle:LbHistejemplar', 'a')
                ->Where('a.inhisejeejemplar = :pejemplar')
                ->setParameter('pejemplar', $pejemplar)
                ->andWhere('a.inhisejeusuario = :pusuario')
                ->setParameter('pusuario', $pusuario)
                ->andWhere('a.inhisejepadre  IS NOT NULL')
                ->orderBy('a.fehisejeregistro', 'ASC')->getQuery()->getResult();
            $arrHistEjemplar = array();
            $punteros = array();
            $hisEje = new LbHistejemplar();
            foreach ($histEjemplar as $hisEje) {
                //Para cada uno busca sus hijos
                $hijo = $hisEje->getInhistejemplar();
                $padre = $hisEje->getInhisejepadre()->getInhistejemplar();
                $punteros[]['padre'] = $padre;
                $punteros[]['hijo'] = $hijo;
                //echo "P:".$padre." -> H:".$hijo." \n";
            }
            
            foreach ($punteros as $registro){
                
                $histHijo = new LbHistejemplar();
                $rpadre = $registro['padre'];
                $histHijo = $em->createQueryBuilder()
                    ->select('a')
                    ->from('LibreameBackendBundle:LbHistejemplar', 'a')
                    ->Where('a.inhisejeejemplar = :pejemplar')
                    ->setParameter('pejemplar', $pejemplar)
                    ->andWhere('a.inhisejeusuario = :pusuario')
                    ->setParameter('pusuario', $pusuario)
                    ->andWhere('a.inhistejemplar = :id')
                    ->setParameter('id', $rpadre)
                    ->orderBy('a.fehisejeregistro', 'ASC')->getQuery()->getResult();
                
                $idusuario = $histHijo->getInhisejeusuario()->getInusuario();
                $usuaHist = ManejoDataRepository::getUsuarioById($idusuario);
                $promcalUsHist = ManejoDataRepository::getPromedioCalifica($usuaHist->getInusuario());
                $descMovimiento = "";
                switch ($histHijo->getInhisejemovimiento()){
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
                if (in_array_field($registro['padre'], "hijo", $punteros)){
                }
            }    


                //$arrHistEjemplar[] = array('fehisejeregistro' => $hisEje->getFehisejeregistro()->format("Y-m-d H:i:s"),
                //    'inhisejemodoentrega' => $hisEje->getInhisejemodoentrega(), /*0: En el domicilio, 1: Encontrandose, 3. Courrier local, 4: Courrier Nacional, 5: Courrier internacional*/
                //    'inhisejemovimiento' => $hisEje->getInhisejemovimiento(),
                //    'txhisejedescmovimiento' => utf8_encode($descMovimiento),
                  //  'inhisejeejemplar' => $hisEje->getInhisejeejemplar()->getInejemplar(),
                    //'inhisejepadre' => $hisEje->getInhisejepadre(),
                    //'usrtrx' => array('inusuario' => $usuaHist->getInusuario(),
                    //        'txusunommostrar' => utf8_encode($usuaHist->getTxusunommostrar()),
                    //        'txusuimagen' => utf8_encode($usuaHist->getTxusuimagen()),
                    //        'calificacion' => $promcalUsHist)
                    //);
            //}
            
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
                
            $qnmg = $em->createQueryBuilder()
                ->select('count(a)')
                ->from('LibreameBackendBundle:LbMegusta', 'a')
                ->Where('a.inmegejemplar = :pejemplar')
                ->setParameter('pejemplar', $inejemplar)
                ->andWhere('a.inmegmegusta = :pnomeg')
                ->setParameter('pnomeg', 0);
            
            $meg = $qmg->getQuery()->getSingleScalarResult();
            $nomeg = $qnmg->getQuery()->getSingleScalarResult();
            
            //echo "megusta ".$meg." - nomegusta ".$nomeg;
            return $meg - $nomeg;
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
            $cant = $qs->getQuery()->getSingleScalarResult();
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
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbLibros')->
                findOneBy(array('inlibro' => $inlibro));
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
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQueryBuilder()
                ->select('e')
                ->from('LibreameBackendBundle:LbEjemplares', 'e')
                ->leftJoin('LibreameBackendBundle:LbUsuarios', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.inusuario = e.inejeusudueno')
                ->leftJoin('LibreameBackendBundle:LbMembresias', 'm', \Doctrine\ORM\Query\Expr\Join::WITH, 'm.inmemusuario = e.inejeusudueno')
                ->leftJoin('LibreameBackendBundle:LbHistejemplar', 'h', \Doctrine\ORM\Query\Expr\Join::WITH, 'h.inhisejeejemplar = e.inejemplar and h.inhisejeusuario = e.inejeusudueno')
                ->where(' e.inejemplar > :pejemplar')
                ->setParameter('pejemplar', $inultejemplar)
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
        //echo "getBuscarEjemplares\n";
        $arPalDescartar = array('a', 'ante', 'bajo', 'con', 'contra', 'de', 'desde', 
                'en', 'entre', 'hacia', 'hasta', 'para', 'por', 'segun', 'sin', 'so', 
                'sobre', 'tras', 'yo', 'tu', 'usted', 'el', 'nosotros', 'vosotros', 
                'ellos', 'ellas', 'ella', 'la', 'los', 'la', 'un', 'una', 'unos', 
                'unas', 'es', 'del', 'de', 'mi', 'mis', 'su', 'sus', 'lo', 'le', 'se', 
                'si', 'lo', 'identificar', 'no', 'al', 'que', '1', '2', '3', '4', '5', 
                '6', '7', '8', '9', '0', '(', ',', '.', ')', '"', '&', '/', '-', '=', 
                'y', 'o', '¡', '¿', '?', ':'); 
        $vtexto = explode(" ", utf8_encode($texto));
        $arLibros =[];
        $em = $this->getDoctrine()->getManager();
        //Almacenar la búsqueda del usuario
        setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;
        $objBusqueda = new LbBusquedasusuarios();
        $objBusqueda->setFebusfecha($fecha);
        $objBusqueda->setInbususuario($usuario);
        $objBusqueda->setTxbuspalabra(utf8_encode($texto));
        $em->persist($objBusqueda);
        $em->flush();
        try{
            foreach ($vtexto as $palabra)
            {   
                if(!in_array(strtolower($palabra), $arPalDescartar)){
                    //Recupera cada uno de los ejemplares con ID > al del parametro
                    $sql = "SELECT e FROM LibreameBackendBundle:LbIndicepalabra e"
                            . " WHERE e.lbindpalpalabra LIKE :palabra";
                    $query = $em->createQuery($sql)->setParameter('palabra', "%".strtolower($palabra)."%");
                    //$libro = new LbLibros();
                    $palabrasindice = $query->getResult();
                    foreach ($palabrasindice as $indice) {
                        $arLibros[] = $indice->getLbindpallibro();
                        $libro = $indice->getLbindpallibro();
                        //echo "LIBRO :".$libro->getTxlibtitulo()."\n";
                    }
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
                ->setMaxResults(100)
                ->orderBy(' h.fehisejeregistro ', 'DESC');
            
           return $q->getQuery()->getResult();
            
        } catch (Exception $ex) {
                return new LbEjemplares();
        } 
    }
                
    //Obtiene todos los Ejemplares, de un usuario
    public function getVisualizarBiblioteca(LbUsuarios $usuario, Array $grupos)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            //Los ejemplares cuya membresías coincidan con las del usuario que solicita
            //El usuario debe estar activo
            $em = $this->getDoctrine()->getManager();
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
            
            $mensaje = $em->getRepository('LibreameBackendBundle:LbMensajes')->
                    findOneBy(array('inmensaje' => $psolicitud->getIdmensaje(), 'inmenusuario' => $usuario));
            
            if ($mensaje != NULL) {
                $mensaje->setInmenleido($psolicitud->getMarcacomo());
                $em->persist($mensaje);
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
            
            $usuario->setTxusutelefono($psolicitud->getTelefono());
            $usuario->setInusulugar($lugar);
            $usuario->setInusugenero($psolicitud->getUsuGenero());
            $usuario->setTxusuimagen($psolicitud->getUsuImagen());
            $usuario->setTxusunombre($psolicitud->getNomUsuario());
            $usuario->setTxusunommostrar($psolicitud->getNomMostUsuario());
            if ($psolicitud->getUsuFecNac() != ""){
                $usuario->setFeusunacimiento($d);
            }
           
            $em->persist($usuario);
            $em->flush();
            $resp = AccesoController::inExitoso;
            
            return $resp;
        } catch (Exception $ex) {
                return new LbUsuarios();
        } 
    }
    
    //Actualiza datos de usuario
    public function setCambiarClave(Solicitud $psolicitud)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            
            $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            $lugar = ManejoDataRepository::getLugar($psolicitud->getUsuLugar());
            
            if ($psolicitud->getUsuFecNac() != ""){
                $d = new DateTime($psolicitud->getUsuFecNac());
            }
            
            $usuario->setTxusutelefono($psolicitud->getTelefono());
            $usuario->setInusulugar($lugar);
            $usuario->setInusugenero($psolicitud->getUsuGenero());
            $usuario->setTxusuimagen($psolicitud->getUsuImagen());
            $usuario->setTxusunombre($psolicitud->getNomUsuario());
            $usuario->setTxusunommostrar($psolicitud->getNomMostUsuario());
            if ($psolicitud->getUsuFecNac() != ""){
                $usuario->setFeusunacimiento($d);
            }
           
            $em->persist($usuario);
            $em->flush();
            $resp = AccesoController::inExitoso;
            
            return $resp;
        } catch (Exception $ex) {
                return new LbUsuarios();
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
     * Recupera un libro, con su Id numerico
     */
    public function getLibroById($idlibro){
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbLibros')->
                    findOneBy(array('inlibro' => $idlibro));

        } catch (Exception $ex) {
                return new LbLibros();
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
    
   //Marca un Megusta en un ejemplar
    public function setMegustaEjemplar($ejemplar, $megusta, $usuario)
    {   
        try{
            setlocale (LC_TIME, "es_CO");
            $fecha = new \DateTime;
            $em = $this->getDoctrine()->getManager();
            $ObjEjemplar = ManejoDataRepository::getEjemplarById($ejemplar);
            $ObjUsuario = ManejoDataRepository::getUsuarioByEmail($usuario);
            $megustaEjemplar = new LbMegusta();
            $megustaEjemplar->setInmegejemplar($ObjEjemplar);
            $megustaEjemplar->setInmegusuario($ObjUsuario);
            $megustaEjemplar->setInmegmegusta($megusta);
            $megustaEjemplar->setFemegmegusta($fecha);

            $em->persist($megustaEjemplar);

            $em->flush();
            return AccesoController::inDatoUno;

        } catch (Exception $ex) {
                return AccesoController::inDatoCer;
        } 
    }
    
   //Marca un Megusta en un ejemplar
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
 
}