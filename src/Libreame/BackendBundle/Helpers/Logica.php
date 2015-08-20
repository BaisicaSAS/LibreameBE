<?php

namespace Libreame\BackendBundle\Helpers;

class Logica 
{   
    //Constantes globales
    const inFallido =  0; //Proceso fallido por calidad de datos
    const inDescone = -1; //Proceso fallido por conexión de plataforma
    const inExitoso =  1; //Proceso existoso
    const inDatoCer =  0; //Valor cero: Sirve para los datos Inactivo, Cerrado etc del modelo
    const inDatoUno =  1; //Valor Uno: Sirve para los datos Activo, Abierto, etc del modelo
    const inGenSinE =  2; //Genero del usuario: Sin especificar
    const inGenFeme =  1; //Genero del usuario: Femenino
    const inGenMasc =  0; //Genero del usuario: Masculino
    const inTamVali =  40; //Tamaño del ID para confirmacion del Registro
    const inTamSesi =  30; //Tamaño del id de sesion generado
    const txMensaje =  'Solicitud de registro de usuario en Libreame'; //Mensaje estandar para el registro de usuario
    
    //Acciones de la plataforma
    const txAccRegistro =  'C01'; //Registro en el sistema
    const txAccIngresos =  'C02'; //Login  (Ingreso)
    const txAccRecParam =  'C03'; //Recuperar datos y parámetros de usuario: incluye calificaciones
    const txAccRecFeeds =  'C04'; //Recuperar Feed (Todas las publicaciones de solicitudes y publicaciones de usuarios)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccRecOpera =  'C05'; //Recuperar mi operación (Todas mis solicitudes publicaciones y mensajes)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccConfRegi =  'C06'; //Confirmacion Registro en el sistema        
    const txAccRecEjemp =  'C07'; //Recuperar Ejemplar        
    const txAccRecSolic =  'C08'; //Recuperar solicitud
    const txAccRecUsuar =  'C09'; //Ver/Recuperar usuario: Incluye su calificacion
    
    const txAccCerraSes =  'E01'; //Logout / Cerrar sesion
    const txAccBajaSist =  'E02'; //Dar de baja
    const txAccActParam =  'E03'; //Actualizar parámetros sistema y datos usuario
    const txAccPubliEje =  'E04'; //Publicar un ejemplar
    const txAccModifEje =  'E05'; //Modificar un ejemplar
    const txAccElimiEje =  'E06'; //Eliminar un ejemplar
    const txAccPubliSol =  'E07'; //Publicar una solicitud
    const txAccModifSol =  'E08'; //Modificar una solicitud
    const txAccElimiSol =  'E09'; //Eliminar una solicitud
    const txAccPubMensa =  'E10'; //Enviar un mensaje a una solicitud especifica / Publicar o Responder
    const txAccConcNego =  'E11'; //Concretar una negociación: Aceptar un usuario y descartar a los demás
    const txAccDesiNego =  'E12'; //Desistir de una negociación ya realizada
    const txAccCaliTrat =  'E13'; //Calificar un trato
    const txAccModCalTr =  'E14'; //Modificar calificación trato
    const txAccEnviaPQR =  'E15'; //Enviar una PQR
    const txAccModifPQR =  'E16'; //Modificar una PQR
    const txAccElimiPQR =  'E17'; //Eliminar una PQR

    public $datosAcceso; //Tipo Clase AccesoController
            
    /*
     * Esta funcion configurada como servicio se encarga de recibir la información del cliente
     * luego de que ha sido validada por el controlador AccesoController. Luego de recibirla
     * Evalua la accion solicitada, ejecuta lo solicitado y retorna la respuesta al controlador.
     */
    public function ejecutaAccion($datos, $sesion)
    {
        $respuesta = self::inFallido;
        //echo "<script>alert('".$accion."-".$this->txAccRegistro."')</script>";
        
        switch ($sesion->getAccion()){
            case self::txAccRegistro: {
                //echo "<script>alert('Antes de entrar a Registro')</script>";
                $objRegistro = $this->get('registro_service');
                $respuesta = $objRegistro::registroUsuario($sesion);
            }    
        }
        //echo "<script>alert('ejecuta Accion: ".$respuesta."')</script>";
        return $respuesta;
    }
    
    
    /*
     * generaRand: 
     * Funcion que genera un ID aleatorio de la cantidad solicitada en el parámetro
     */
    public function generaRand($tamano){

        $patron = "1234567890abcdefghijklmnopqrstuvwxyz+~*-"; 
        $key = "";
        
        for($i = 0; $i < $tamano; $i++) { 
            $key .= $patron{rand(0, 39)}; 
        } 
        //echo "<script>alert('Generó clave de ".$tamano.": ".$key."')</script>";
        return $key;         
    }
    
}
