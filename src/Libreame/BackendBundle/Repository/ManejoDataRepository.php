<?php

namespace Libreame\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;
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
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbCalificausuarios;
use Libreame\BackendBundle\Entity\LbOfertas;
use Libreame\BackendBundle\Entity\LbSolicitados;
use Libreame\BackendBundle\Entity\LbOfrecidos;
use Libreame\BackendBundle\Entity\LbActividadofertas;
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
     *Indica si un usuario tiene una sesion activa
     * 
     */
    public function usuarioSesionActiva($psolicitud, $device)
    {   
        try {
            $em = $this->getDoctrine()->getManager();
            //Identifica el dispositivo // a este es al que se asocia la sesion

            //echo "<script>alert('Dispositivo MAC ".$psolicitud->getDeviceMAC()."')</script>";
            $id = $device->getIndispusuario();
            //echo "<script>alert('Dispositivo ID ".$id." - MAC: ".$psolicitud->getDeviceMAC()."')</script>";
            //echo "<script>alert('EXISTE Sesion activa ".$device->getIndispusuario()."')</script>";

            $sesion = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                'insesdispusuario' => $id,
                'insesactiva' => AccesoController::inSesActi));

            //if ($sesion != NULL) {echo "<script>alert('EXISTE Sesion activa ".$device->getIndispusuario()."')</script>";}

            //Flush al entity manager
            $em->flush(); 

            return ($sesion != NULL);
        } catch (Exception $ex) {
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
    public function generaSesion($pEstado,$pFecIni,$pFecFin,$pDevice,$pIpAdd)
    {
        //Guarda la sesion inactiva
        //echo "<script>alert('Ingresa a generar sesion".$pFecFin."-".$pFecIni."')</script>";
        try{
            $objLogica = $this->get('logica_service');
            $em = $this->getDoctrine()->getManager();
            $sesion = new LbSesiones();
            $sesion->setInsesactiva($pEstado);
            $sesion->setTxsesnumero($objLogica::generaRand(AccesoController::inTamSesi));
            $sesion->setFesesfechaini($pFecIni);
            $sesion->setFesesfechafin($pFecFin);
            $sesion->setInsesdispusuario($pDevice);
            $sesion->setTxipaddr($pIpAdd);
            $em->persist($sesion);
            //echo "<script>alert('Guardo sesion')</script>";
            $em->flush();
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
    public function generaActSesion($pSesion,$pFinalizada,$pMensaje,$pAccion,$pFecIni,$pFecFin)
    {
        //Guarda la sesion inactiva
        //echo "<script>alert('Ingresa a generar actividad de sesion".$pFecFin."-".$pFecIni."')</script>";
        try{
            $em = $this->getDoctrine()->getManager();
            
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
            $em->flush();
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
     * Credenciales está compuesto por: 1.usr,2.pass,3-device,4.session,5-opcion a despachar,
     * parametros para la url a despachar, cantidad de caracteres de cada uno 
     * de los anteriores cada uno con 4 digitos.
     * 
     */
    public function recuperaSesionUsuario($pusuario, $psolicitud)
    {   
        try{
            //Verifica que el usuario exista, que esté activo, que la clave coincida
            //que corresponda al dispositivo, y que la sesion esté activa

            //echo "<script>alert('Ingresa validar sesion :: ".$psolicitud->getEmail()." ::')</script>";
            $respuesta = AccesoController::inUsSeIna; //Inicializa como sesion logueada
            $em = $this->getDoctrine()->getManager();
            
            if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->
                        findOneBy(array('txusuemail' => $psolicitud->getEmail()))){
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
                       //echo "<script>alert('Sesion no existe para dispositivo ')</script>";
                        $respuesta = AccesoController::inUsSeIna; //Si la sesion no existe para el dispositivo
                } else {
                    $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                        'txdisid' => $psolicitud->getDeviceMAC(), 
                        'indisusuario' => $usuario));
                   //echo "<script>alert('encontro el dispositivo usuario ')</script>";
                    //Si el usuario está INACTIVO
                    if ($estado != AccesoController::inUsuActi)
                    {
                       //echo "<script>alert('Usuario inactiva ')</script>";
                        $respuesta = AccesoController::inUsuConf; //Usuario Inactiva
                    } else {
                        //Si la clave enviada es inválida
                        if ($usuario->getTxusuclave() != $psolicitud->getClave()){
                           //echo "<script>alert('Clave invalida ')</script>";
                            $respuesta = AccesoController::inUsClInv; //Usuario o clave inválidos
                        } else {
                            //Valida si la sesion está activa
                           //echo "<script>alert('Va a retornar la sesion ')</script>";
                            $respuesta = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                                'txsesnumero' =>  $psolicitud->getSession(),
                                'insesdispusuario' => $device,
                                'insesactiva' => AccesoController::inSesActi));
                        }   
                    }
                }
            }       
            //Flush al entity manager
            $em->flush(); 

            return ($respuesta);
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }

    //Obtiene el objeto Lugar según su ID 
    public function getLugar($inlugar)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbLugares')->
                findOneBy(array('inlugar' => $inlugar));
            $em->flush();
        } catch (Exception $ex) {
                return new LbLugares();
        } 
    }
    
    //Obtiene varios objetos Genero según el ID del libro 
    public function getGeneroLibro($inlibro)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbGenerosLibros')->
                findBy(array('inglilibro' => $inlibro));
            $em->flush();
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
            $em->flush();
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
            $em->flush();
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
            $em->flush();
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
                findOneBy(array('inusuario' => $inusuario));
            $em->flush();
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
            $em->flush();
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
            $em->flush();
        } catch (Exception $ex) {
                return new LbUsuarios();
        } 
    }
    
    //Obtiene el Dispositivo del usuario 
    public function getDispositivoUsuario($iddispositivo, LbUsuarios $usuario)
    {   
        try{
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                        'txdisid' => $iddispositivo, 
                        'indisusuario' => $usuario));
            $em->flush();
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
                    findBy(array('inmemusuario' => $usuario));;
            $em->flush();
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
            $em = $this->getDoctrine()->getManager();
            $sql = "SELECT e FROM LibreameBackendBundle:LbEjemplares e,"
                    . " LibreameBackendBundle:LbMembresias m,"
                    . " LibreameBackendBundle:LbUsuarios u,"
                    . " LibreameBackendBundle:LbOfrecidos o WHERE e.inejemplar > ".$inultejemplar
                    . " and e.inejeusudueno = m.inmemusuario"
                    . " and o.inofrejemplar = e.inejemplar"
                    . " and m.inmemgrupo in (:grupos) ";

            $query = $em->createQuery($sql)->setParameter('grupos', $grupos);
            return $query->getResult();
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
                    findBy(array('incalusucalificado' => $usuario));;
            $em->flush();
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
                    findBy(array('incalusucalifica' => $usuario));;
            $em->flush();    

        } catch (Exception $ex) {
                return new LbCalificausuarios();
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
                    findBy(array('inlibro' => $idlibro));
            $em->flush();    

        } catch (Exception $ex) {
                return new LbLibros();
        } 
    }
    
    /*
     * Crea registro en generolibro, para el genero por defecto y lo rtorna
     */
    public function asociarGeneroBasicoLibro(LbLibros $libro){
        $generolibro = new LbGeneroslibros();
        try{
            $em = $this->getDoctrine()->getManager();
            $genero = $em->getRepository('LibreameBackendBundle:LbGeneros')->
                    findById(AccesoController::inIdGeneral);
            
            $generolibro->setIngligenero($genero);
            $generolibro->setInglilibro($libro);
            
            $em->persist($generolibro);
            $em->flush();    

        } catch (Exception $ex) {
                return new LbLibros();
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
            $em = $this->getDoctrine()->getManager();
            $libro->setTxlibtipopublica($psolicitud->getTipopublica());  
            if ($cual == AccesoController::txEjemplarPub) {
                $libro->setTxlibtitulo($psolicitud->getTitulo());  
                $libro->setTxlibidioma($psolicitud->getIdioma());  
            } else {
                $libro->setTxlibtitulo($psolicitud->getTituloSol());  
                $libro->setTxlibidioma($psolicitud->getIdioma());  
            }
            $libro->setTxlibautores(AccesoController::txMenNoId);  
            $libro->setTxlibeditorial(AccesoController::txMenNoId);  
            $libro->setTxlibedicionanio(AccesoController::txMenNoId);  
            $libro->setTxlibedicionnum(AccesoController::txMenNoId);  
            $libro->setTxlibedicionpais(AccesoController::txMenNoId); 
            $libro->setTxlibediciondescripcion(AccesoController::txMenNoId);  
            $libro->setTxlibcodigoofic(AccesoController::txMenNoId);  
            $libro->setTxlibcodigoofic13(AccesoController::txMenNoId);  
            $libro->setTxlibresumen(AccesoController::txMenNoId);  
            $libro->setTxlibtomo(AccesoController::txMenNoId);  
            $libro->setTxlibvolumen(AccesoController::txMenNoId);  
            $libro->setTxpaginas(AccesoController::txMenNoId);  
            $em->persist($libro);
            $em->flush();    

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
        $ejemplar = new LbEjemplares();
        try {
            $em = $this->getDoctrine()->getManager();
            $ejemplar->setInejecantidad(AccesoController::inIdGeneral);//Se utiliza esta constante porque representa el # 1  
            $ejemplar->setDbejeavaluo($psolicitud->getAvaluo());  
            $ejemplar->setInejelibro($libro);  
            $ejemplar->setInejeusudueno($usuario);  
     
            $em->persist($ejemplar);
            $em->flush();    
            
            return $ejemplar;
        } catch (Exception $ex)  {    
            return $ejemplar;
        }
    }
    
    /*
     * Genera una oferta para un ejemplar especifico
     * NOTA:: Por ahora todas las ofertas se generan sobre el grupo General, aun no se implementa GRUPOS FULL
     */
    public function generarOfertaEjemplar(Solicitud $psolicitud, LbEjemplares $ejemplar, LbUsuarios $usuario)
    {
        $oferta = new LbOfertas();
        $ofrecido = new LbOfrecidos(); 
        $solicitado = new LbSolicitados(); 
        $actoferta = new LbActividadofertas();
        try {
            $fecha = new \DateTime;
            $em = $this->getDoctrine()->getManager();
            //Obtiene el objeto Membresia a grupo general para el usuario
            $grupo = $em->getRepository('LibreameBackendBundle:LbGrupos')->
                    findById(AccesoController::inIdGeneral);
            $membresia = $em->getRepository('LibreameBackendBundle:LbMembresias')->
                    findOneBy(array('inmemgrupo' => $grupo, 'inmemusuario' => $usuario));
            
            //Registro de oferta
            $oferta->setFeofefecha($fecha);
            $oferta->setInofemembresia($membresia);
            //Por ahora no se utilizará este dato, hay que revisar periodicamente 
            //si la oferta lleva mas de x días para informar al usuario
            $oferta->setInofevigencia(0); 
            $oferta->setInofeabierta(AccesoController::inIdGeneral); //Se utiliza esta constante porque su valor es 1 
            $oferta->setInofeactiva(AccesoController::inIdGeneral); //Se utiliza esta constante porque su valor es 1
            
            $em->persist($oferta);
            $em->flush();    
            
            //Registro de ofrecidos
            $ofrecido->setInofrejemplar($ejemplar);
            $ofrecido->setInofroferta($oferta);
            $ofrecido->setInofrtransac($psolicitud->gettr);
            $ofrecido->setTxofrobservacion($psolicitud->ge);
            $ofrecido->setDbofrvaladic($dbofrvaladic);
            $ofrecido->setDbofrvaloferta($dbofrvaloferta);
            
            $em->persist($ofrecido);
            $em->flush();    

            //Si hay solicitud de libros en cambio se registra
            $regSol = 0; //Variable para identificar si se debe registrar un ejemplar Solicitado: inicia en false
            if($psolicitud->getIdlibroSol() != '') {
                $libro = ManejoDataRepository::getLibroById($psolicitud->getIdlibroSol());
                $regSol = 1;
            } else {
                if ($psolicitud->getTxSol() != ''){ 
                    $libro = ManejoDataRepository::crearLibro($psolicitud, AccesoController::txEjemplarSol);
                    //Crear la asociación del libro con genero, si no existe el libro
                    ManejoDataRepository::asociarGeneroBasicoLibro($libro);
                    $regSol = 1;
                }    
            }
            
            /* ojo aqui voy pero debo revisar el modelo para los solicitados...no es por ejemplar sino por libro
            //Registra el libro solicitado
            if ($regSol == 1){
                $solicitado->setInsolejemplar($insolejemplar)
                protected $idsolicitado;
                protected $insoltransac;
                protected $txsolobservacion;
                protected $dbsolvaloferta;
                protected $dbsolvaladic;
                protected $insolejemplar;

                protected $insollibro;
                protected $insoloferta;
            }
            */
            
            //Actividad ofertas
            $actoferta->setFeactfechahora($fecha);
            $actoferta->setTxactdescripcion($psolicitud->getObservasol());
            $actoferta->setInactoferta($oferta);
            $actoferta->setInactusuario($usuario);
            
            $em->persist($actoferta);
            $em->flush();
           
            return $ofrecido;
        } catch (Exception $ex)  {    
            return $ofrecido;
        }
        
    }
    
}
