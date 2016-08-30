<?php

namespace Libreame\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use EntityR;
use DateTime;
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
use Libreame\BackendBundle\Entity\LbGeneroslibros;
use Libreame\BackendBundle\Entity\LbEditorialeslibros;
use Libreame\BackendBundle\Entity\LbAutoreslibros;
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbCalificausuarios;
use Libreame\BackendBundle\Entity\LbOfertas;
use Libreame\BackendBundle\Entity\LbIndicepalabra;
use Libreame\BackendBundle\Entity\LbMensajes;
use Libreame\BackendBundle\Entity\LbIdiomas;
use Libreame\BackendBundle\Helpers\Solicitud;
use Libreame\BackendBundle\Helpers\Respuesta;
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
                ->leftJoin('LibreameBackendBundle:LbGeneroslibros', 'gl', \Doctrine\ORM\Query\Expr\Join::WITH, 'gl.ingligenero = g.ingenero and gl.inglilibro = :plibro')
                ->setParameter('plibro', $inlibro);
            return $q->getQuery()->getResult();
        } catch (Exception $ex) {
                return new LbGeneros();
        } 
    }
    
    //Obtiene varios objetos Genero según el ID del libro 
    public function getEditorialesLibro($inlibro)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQueryBuilder()
                ->select('e')
                ->from('LibreameBackendBundle:LbEditoriales', 'e')
                ->leftJoin('LibreameBackendBundle:LbEditorialeslibros', 'el', \Doctrine\ORM\Query\Expr\Join::WITH, 'el.inedilibroeditorial = e.inideditorial and el.inediliblibro = :plibro')
                ->setParameter('plibro', $inlibro);
            return $q->getQuery()->getResult();
        } catch (Exception $ex) {
                return new LbEditoriales();
        } 
    }
    
    //Obtiene varios objetos Genero según el ID del libro 
    public function getAutoresLibro($inlibro)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $q = $em->createQueryBuilder()
                ->select('a')
                ->from('LibreameBackendBundle:LbAutores', 'a')
                ->leftJoin('LibreameBackendBundle:LbAutoreslibros', 'al', \Doctrine\ORM\Query\Expr\Join::WITH, 'al.inautlidautor = a.inidautor and al.inautlidlibro = :plibro')
                ->setParameter('plibro', $inlibro);
            return $q->getQuery()->getResult();
        } catch (Exception $ex) {
                return new LbGeneroslibros();
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
    public function getGruposUsuario(LbUsuarios $usuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            $sql = "SELECT g.ingrunombre FROM LibreameBackendBundle:LbGrupos g JOIN LibreameBackendBundle:LbMembresias m"
                    ." WHERE m.inmemusuario = :usuario AND m.inmemgrupo = g.ingrupo";
            $query = $em->createQuery($sql)->setParameter('usuario', $usuario);
            return $query->getResult();
        } catch (Exception $ex) {
                return new LbGrupos();
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
                
    //Obtiene todos los Ejemplares, con ID mayor al solicitado, que se encuentren OFRECIDOS, o SOLICITADOS
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
                ->setMaxResults(10)
                ->orderBy(' h.fehisejeregistro ', 'DESC');

            return $q->getQuery()->getResult();
            //return $q->getArrayResult();
        } catch (Exception $ex) {
                //echo "retorna error";
                return new LbEjemplares();
        } 
    }
                
    //Obtiene todas las Ofertas, sobre un ejemplar específico
    public function getOfertaById($idoferta)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            $em = $this->getDoctrine()->getManager();
            
           
            $ofertas = $em->getRepository('LibreameBackendBundle:LbOfertas')->
                    findOneBy(array('inoferta' => $idoferta));

            return $ofertas;
        } catch (Exception $ex) {
                return new LbOfertas();
        } 
    }
                
    //Obtiene todas las Ofertas, sobre un ejemplar específico
    public function getOfertasByEjemplar(LbEjemplares $ejemplar)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            $em = $this->getDoctrine()->getManager();
            
            $ofrecido = $em->getRepository('LibreameBackendBundle:LbOfrecidos')->
                    findOneBy(array('inofrejemplar' => $ejemplar->getInejemplar()));
            
            
            $ofertas = $em->getRepository('LibreameBackendBundle:LbOfertas')->
                    findOneBy(array('inoferta' => $ofrecido->getInofroferta()->getInoferta()));

            return $ofertas;
        } catch (Exception $ex) {
                return new LbOfertas();
        } 
    }
                
    //Obtiene id de ofrecido por ejemplar y oferta
    public function getOfrecidoByOfrEjemplar($idejemplar, $idoferta)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            $em = $this->getDoctrine()->getManager();
            
            $ofrecido = $em->getRepository('LibreameBackendBundle:LbOfrecidos')->
                    findOneBy(array('inofroferta' => $idoferta, 'inofrejemplar' => $idejemplar));

            return $ofrecido;
        } catch (Exception $ex) {
                return new LbOfrecidos();
        } 
    }
                
    public function getSolicitadoByOfrEjemplar($idlibro, $idoferta)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            $em = $this->getDoctrine()->getManager();
            
            $solicitado = $em->getRepository('LibreameBackendBundle:LbSolicitados')->
                    findOneBy(array('insoloferta' => $idoferta, 'insollibro' => $idlibro));

            return $solicitado;
        } catch (Exception $ex) {
                return new LbSolicitados();
        } 
    }
                
    public function getEjemplar($idlibro, $idoferta)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            $em = $this->getDoctrine()->getManager();
            
            $ofrecido = $em->getRepository('LibreameBackendBundle:LbOfrecidos')->
                    findOneBy(array('inofroferta' => $idoferta));
            
            //echo "El ejemplar a buscar : Libro : ".$idlibro."  -  La oferta es:".$idoferta;
            
            $ejemplar = $em->getRepository('LibreameBackendBundle:LbEjemplares')->
                    findOneBy(array('inejemplar' => $ofrecido->getInofrejemplar() ));

            return $ejemplar;
        } catch (Exception $ex) {
                return new LbSolicitados();
        } 
    }
                
    //Obtiene todos los Ejemplares SOLICITADOS, de una oferta
    public function getSolicitadosByOferta(LbOfertas $oferta)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            $em = $this->getDoctrine()->getManager();

            return  $em->getRepository('LibreameBackendBundle:LbSolicitados')->
                    findBy(array('insoloferta' => $oferta));

        } catch (Exception $ex) {
                return new LbSolicitados();
        } 
    }
                
    //Obtiene todos los Ejemplares OFRECIDOS, de una oferta
    public function getOfrecidosByOferta(LbOfertas $oferta)
    {   
        try{
            //Recupera cada uno de los ejemplares con ID > al del parametro
            $em = $this->getDoctrine()->getManager();

            return  $em->getRepository('LibreameBackendBundle:LbOfrecidos')->
                    findOneBy(array('inofroferta' => $oferta));

         } catch (Exception $ex) {
                return new LbOfrecidos();
        } 
    }
                
    //Obtiene todos los Ejemplares, que coincidan con el texto OFRECIDOS, o SOLICITADOS
    public function getBuscarEjemplares(Array $grupos, $texto)
    {   
        $vtexto = explode(" ", $texto);
        $arLibros =[];
        
        try{
            foreach ($vtexto as $palabra)
            {   
                //Recupera cada uno de los ejemplares con ID > al del parametro
                $em = $this->getDoctrine()->getManager();
                $sql = "SELECT e FROM LibreameBackendBundle:LbIndicepalabra e"
                        . " WHERE e.lbindpalpalabra LIKE :palabra";
                $query = $em->createQuery($sql)->setParameter('palabra', "%".strtolower($palabra)."%");
                //$libro = new LbLibros();
                $palabrasindice = $query->getResult();
                foreach ($palabrasindice as $indice) {
                    $arLibros[] = $indice->getLbindpallibro();
                    //$libro = $indice->getLbindpallibro();
                    //echo "LIBRO :".$libro->getTxlibtitulo()."\n";
                }
            }
            
            $sql1 = "SELECT e FROM LibreameBackendBundle:LbEjemplares e, "
                    . " LibreameBackendBundle:LbMembresias m, "
                    . " LibreameBackendBundle:LbUsuarios u, "
                    . " LibreameBackendBundle:LbOfrecidos o "
                    . "WHERE e.inejeusudueno = m.inmemusuario "
                    . " and e.inejelibro in (:libros) "
                    . " and o.inofrejemplar = e.inejemplar "
                    . " and m.inmemgrupo in (:grupos) ";
            $query1 = $em->createQuery($sql1)->setParameters(array('libros' => $arLibros,'grupos' => $grupos));

            return $query1->getResult();
        } catch (Exception $ex) {
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
    
    /*
     * Genera una oferta para un ejemplar especifico
     * NOTA:: Por ahora todas las ofertas se generan sobre el grupo General, aun no se implementa GRUPOS FULL
     */
    public function generarOfertaEjemplar(Solicitud $psolicitud)
    {
        $oferta = new LbOfertas();
        $respuesta = new Respuesta();
        $ofrecido = new LbOfrecidos(); 
        $actoferta = new LbActividadofertas();
        $ejemplar = new LbEjemplares();
        $generolibro = new LbGeneroslibros();
        $generolibro1 = new LbGeneroslibros();
        $generolibro2 = new LbGeneroslibros();
        try {
            setlocale (LC_TIME, "es_CO");
            $fecha = new \DateTime;
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();

            //Si el ID del libro esta seteado en la solicitud se recupera de la BD, de lo contrario se crea
            $regSol = 0; //Variable para identificar si se debe registrar un ejemplar Solicitado: inicia en false
            $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
            if($psolicitud->getIdlibro() != '') {
                $libro = ManejoDataRepository::getLibroById($psolicitud->getIdlibro());
                //echo "<script>alert('By Id ')</script>"; 
                $regSol = 1;
            } else {
                if ($libro=ManejoDataRepository::buscarLibroByTitulo($psolicitud->getTitulo(),$em)){
                    //echo "<script>alert('By Titulo')</script>"; 
                    $regSol = 1;
                } else {
                    $libro = ManejoDataRepository::crearLibro($psolicitud, AccesoController::txEjemplarPub);
                    //Crear la asociación del libro con genero, si no existe el libro
                    //echo "<script>alert('Crea libro')</script>"; 
                    $generolibro = ManejoDataRepository::asociarGeneroBasicoLibro($libro, $em);
                    $regSol = 2;
                }
            }

            //Crea elejemplar
            if ($psolicitud->getIdOferta() == "") {
                $ejemplar = ManejoDataRepository::crearEjemplar($psolicitud,$libro,$usuario);
            } else {
                $ejemplar = ManejoDataRepository::getEjemplar($libro->getInlibro(),$psolicitud->getIdOferta());
            }

            //Si hay solicitud de libros en cambio se registran como Libro1 y Libro2
            $regSol1 = 0; //Variable para identificar si se debe registrar un ejemplar Solicitado: inicia en false
            $libro1 = new LbLibros();
            if($psolicitud->getIdlibroSol1() != '') {
                $libro1 = ManejoDataRepository::getLibroById($psolicitud->getIdlibroSol1());
                //echo "<script>alert('By Id')</script>"; 
                $regSol1 = 1;
            } else {
                if ($psolicitud->getTitulosol1() != ''){ 
                    if ($libro1=ManejoDataRepository::buscarLibroByTitulo($psolicitud->getTituloSol1(),$em)){
                        //echo "<script>alert('By Titulo')</script>"; 
                        $regSol1 = 1;
                    } else {
                        $libro1 = ManejoDataRepository::crearLibro($psolicitud, AccesoController::txEjemplarSol1);
                        //echo "<script>alert('Crea')</script>"; 
                        //Crear la asociación del libro con genero, si no existe el libro
                        $generolibro1 = ManejoDataRepository::asociarGeneroBasicoLibro($libro1, $em);
                        $regSol1 = 2;
                    }
                }    
            }

            $regSol2 = 0; //Variable para identificar si se debe registrar un ejemplar Solicitado: inicia en false
            $libro2 = new LbLibros();
            if($psolicitud->getIdlibroSol2() != '') {
                $libro2 = ManejoDataRepository::getLibroById($psolicitud->getIdlibroSol2());
                $regSol2 = 1;
            } else {
                if ($psolicitud->getTituloSol2() != ''){ 
                    if ($libro2=ManejoDataRepository::buscarLibroByTitulo($psolicitud->getTituloSol2(),$em)){
                        $regSol2 = 1;
                    } else {
                        $libro2 = ManejoDataRepository::crearLibro($psolicitud, AccesoController::txEjemplarSol2);
                        //Crear la asociación del libro con genero, si no existe el libro
                        $generolibro2 = ManejoDataRepository::asociarGeneroBasicoLibro($libro2, $em);
                        $regSol2 = 2;
                    }
                }    
            }
            
            //Obtiene el objeto Membresia a grupo general para el usuario
            $grupo = $em->getRepository('LibreameBackendBundle:LbGrupos')->
                    findOneBy(array('ingrupo' => AccesoController::inIdGeneral));
            $membresia = $em->getRepository('LibreameBackendBundle:LbMembresias')->
                    findOneBy(array('inmemgrupo' => $grupo, 'inmemusuario' => $usuario));
            
            //Registro de oferta
            //Variable para guardar o actualizar los datos según sea el caso....
            $nuevoReg = 0;
            if ($psolicitud->getIdOferta() == "") {
                $nuevoReg = 1;
                $oferta->setFeofefecha($fecha);
                $oferta->setInofemembresia($membresia);
                //Por ahora no se utilizará este dato, hay que revisar periodicamente 
                //si la oferta lleva mas de x días para informar al usuario
                $oferta->setInofevigencia(0); 
                $oferta->setInofeabierta(AccesoController::inIdGeneral); //Se utiliza esta constante porque su valor es 1 
                $oferta->setInofeactiva(AccesoController::inIdGeneral); //Se utiliza esta constante porque su valor es 1
                
                //Registro de ofrecidos
                $ofrecido->setInofrejemplar($ejemplar);
                $ofrecido->setInofrtransac(2);
                $ofrecido->setInofroferta($oferta);
                $ofrecido->setTxofrobservacion($psolicitud->getObservaSol());
                $ofrecido->setDbofrvaladic($psolicitud->getAvaluo());
                $ofrecido->setDbofrvaloferta($psolicitud->getValVenta());

                //Registra los libros solicitado
                if ($regSol1 > 0){
                    $solicitado1 = new LbSolicitados();
                    $solicitado1->setInsoltransac(2);
                    $solicitado1->setTxsolobservacion($psolicitud->getObservaSol());
                    $solicitado1->setDbsolvaloferta($psolicitud->getValAdicSol1());
                    $solicitado1->setDbsolvaladic($psolicitud->getValAdicSol1());
                    $solicitado1->setInsollibro($libro1);
                    $solicitado1->setInsoloferta($oferta);
                }

                if ($regSol2 > 0){
                    $solicitado2 = new LbSolicitados();
                    $solicitado2->setInsoltransac(2);
                    $solicitado2->setTxsolobservacion($psolicitud->getObservaSol());
                    $solicitado2->setDbsolvaloferta($psolicitud->getValAdicSol2());
                    $solicitado2->setDbsolvaladic($psolicitud->getValAdicSol2());
                    $solicitado2->setInsollibro($libro2);
                    $solicitado2->setInsoloferta($oferta);
                }
            } else {
                $nuevoReg = 0;
                $oferta = ManejoDataRepository::getOfertaById($psolicitud->getIdOferta());
                
                if($psolicitud->getTituloSol1() != '') {
                    $solicitado1 = ManejoDataRepository::getSolicitadoByOfrEjemplar($libro1->getInlibro(), $psolicitud->getIdOferta());
                    $solicitado1->setTxsolobservacion($psolicitud->getObservaSol());
                    $solicitado1->setDbsolvaloferta($psolicitud->getValAdicSol1());
                    $solicitado1->setDbsolvaladic($psolicitud->getValAdicSol1());
                    $solicitado1->setInsollibro($libro1);
                }
                if($psolicitud->getTituloSol2() != '') {
                    $solicitado2 = ManejoDataRepository::getSolicitadoByOfrEjemplar($libro2->getInlibro(), $psolicitud->getIdOferta());
                    $solicitado2->setTxsolobservacion($psolicitud->getObservaSol());
                    $solicitado2->setDbsolvaloferta($psolicitud->getValAdicSol2());
                    $solicitado2->setDbsolvaladic($psolicitud->getValAdicSol2());
                    $solicitado2->setInsollibro($libro2);
                }
                
                $ofrecido = ManejoDataRepository::getOfrecidoByOfrEjemplar($ejemplar->getInejemplar(), $psolicitud->getIdOferta());
                $ofrecido->setTxofrobservacion($psolicitud->getObservaSol());
                $ofrecido->setDbofrvaladic($psolicitud->getAvaluo());
                $ofrecido->setDbofrvaloferta($psolicitud->getValVenta());
                //echo "El ejemplar = ".$ejemplar->getInejemplar();
            }
            //echo "La oferta = ".$oferta->getInoferta()." - Parametro = ".$psolicitud->getIdOferta();
                    
            //Actividad ofertas
            $actoferta->setFeactfechahora($fecha);
            $actoferta->setTxactdescripcion($psolicitud->getObservasol());
            $actoferta->setInactoferta($oferta);
            $actoferta->setInactusuario($usuario);
           

            //echo "<script>alert('-".$regSol."-".$regSol1."-".$regSol2.")</script>"; 
            $em->persist($libro);
            ManejoDataRepository::indexar($libro, $libro->getTxediciondescripcion()." ".$libro->getTxlibedicionpais()." ".$libro->getTxlibautores()." ".$libro->getTxlibeditorial()." ".$libro->getTxlibresumen()." ".$libro->getTxlibtitulo(),$em);
            if($regSol == 2)  { 
                $em->persist($generolibro);
            }

            if($regSol1 == 2) { 
                $em->persist($libro1);
                ManejoDataRepository::indexar($libro1, $libro1->getTxediciondescripcion()." ".$libro1->getTxlibedicionpais()." ".$libro1->getTxlibautores()." ".$libro1->getTxlibeditorial()." ".$libro1->getTxlibresumen()." ".$libro1->getTxlibtitulo(),$em);
                $em->persist($generolibro1);
                
            }
            
            if($regSol2 == 2) { 
                $em->persist($libro2);
                ManejoDataRepository::indexar($libro2, $libro2->getTxediciondescripcion()." ".$libro2->getTxlibedicionpais()." ".$libro2->getTxlibautores()." ".$libro2->getTxlibeditorial()." ".$libro2->getTxlibresumen()." ".$libro2->getTxlibtitulo(),$em);
                $em->persist($generolibro2);
            }
            
            //Si los registros no exístían se persisten
            if ($nuevoReg == 1) {
                $em->persist($ejemplar);

                $em->persist($oferta);

                $em->persist($ofrecido);
            }


            if ($regSol1 > 0){
                $em->persist($solicitado1);
            }
            
            if ($regSol2 > 0){
                $em->persist($solicitado2);
            }
            
            $em->persist($actoferta);

            $em->flush();
            $em->getConnection()->commit();

            $fecha = $actoferta->getFeactfechahora();
            $textofecha = $fecha->format('Y/m/d H:i:s');
            $respuesta->setIdOferta($oferta->getInoferta());
            $respuesta->setTitulo($libro->getTxlibtitulo());
            $respuesta->setIdlibro($libro->getInlibro());
            $respuesta->setIdEjemplar($ejemplar->getInejemplar());
            $respuesta->setIdioma($libro->getTxlibidioma());
            $respuesta->setAvaluo($ejemplar->getDbejeavaluo());
            $respuesta->setValVenta($ofrecido->getDbofrvaloferta());
            if ($libro1 != null) {
                $respuesta->setTituloSol1($libro1->getTxlibtitulo());
                $respuesta->setIdLibroSol1($libro1->getInlibro());
                if ($regSol1 > 0) {
                    $respuesta->setValAdicSol1($solicitado1->getDbsolvaladic());
                } else {
                    $respuesta->setValAdicSol1("");
                }
            } else {
                $respuesta->setTituloSol1("");
                $respuesta->setIdLibroSol1("");
                $respuesta->setValAdicSol1("");
            }
            if ($libro2 != null) {
                $respuesta->setTituloSol2($libro2->getTxlibtitulo());
                $respuesta->setIdLibroSol2($libro2->getInlibro());
                if ($regSol2 > 0) {
                    $respuesta->setValAdicSol2($solicitado2->getDbsolvaladic());
                } else {
                    $respuesta->setValAdicSol2("");
                }
            } else {
                $respuesta->setTituloSol2("");
                $respuesta->setIdLibroSol2("");
                $respuesta->setValAdicSol2("");
            }
            
            $respuesta->setObservaSol($ofrecido->getTxofrobservacion());
            $respuesta->setIdMensaje($oferta->getInoferta());
            $respuesta->setTxMensaje($actoferta->getTxactdescripcion());
            $respuesta->setFeMensaje($textofecha);
            $respuesta->setIdPadre($actoferta->getInactpadreact());

            //Busca y recupera el objeto de la sesion:: 
            $sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud,NULL);
            //Guarda la actividad de la sesion:: 
            ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,$libro->getTxlibtitulo()." publicado con éxito por ".$psolicitud->getEmail(),$psolicitud->getAccion(),$fecha,$fecha,$em);
            //echo "<script>alert('Generó actividad de sesion ')</script>";
            //::: GENERA MENSAJE :::
            
            
            
            //ManejoDataRepository::publicaMensajes();
            /*
             * Setea la respuesta
             */            
            
            return $respuesta;
        } catch (Exception $ex)  {    
            $em->getConnection()->rollback();
            return $respuesta;
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
                'si', 'lo', 'identificar', 'no', 'al', 'que'); 
            if ($em == NULL) { $flEm = TRUE; } else  { $flEm = FALSE; }
            
            if ($flEm) {$em = $this->getDoctrine()->getManager();}

            $palabras = explode(" ", $texto);
            $repetidos = [];
            
            foreach ($palabras as $palabra)
            {   
                //echo "... ".$palabra."\n";
                if(!in_array(strtolower($palabra), $arPalDescartar) and 
                        !in_array(strtolower($palabra), $repetidos) )
                {
                    if (!$em->getRepository('LibreameBackendBundle:LbIndicepalabra')->
                        findOneBy(array('lbindpalpalabra' => $palabra, 'lbindpallibro' => $libro)))
                    {    
                        //echo "   SI   \n";
                        $indice = new LbIndicepalabra();
                        $indice->setLbindpallibro($libro);
                        $indice->setLbindpalidioma($libro->getTxlibidioma());
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
    

}