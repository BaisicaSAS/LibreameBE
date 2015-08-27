<?php

namespace Libreame\BackendBundle\Helpers;

class Logica 
{   
    //Constantes globales
    const inFallido =  0; //Proceso fallido por calidad de datos
    const inDescone = -1; //Proceso fallido por conexión de plataforma
    const inExitoso =  1; //Proceso existoso
    const inSesActi = -2; //Indica que el usuario ya tiene una sesion activa
    const inSospech = -3; //Indica que la transacción se rechaza por ser detectada como intento de ataque 
    const inUsuInac = -4; //Indica que la transacción se rechaza por ser detectada como intento de ataque 
    const inDatoCer =  0; //Valor cero: Sirve para los datos Inactivo, Cerrado etc del modelo
    const inDatoUno =  1; //Valor Uno: Sirve para los datos Activo, Abierto, etc del modelo
    const inGenSinE =  2; //Genero del usuario: Sin especificar
    const inGenFeme =  1; //Genero del usuario: Femenino
    const inGenMasc =  0; //Genero del usuario: Masculino
    const inTamVali =  40; //Tamaño del ID para confirmacion del Registro
    const inTamSesi =  30; //Tamaño del id de sesion generado
    const txMensaje =  'Solicitud de registro de usuario en Libreame'; //Mensaje estandar para el registro de usuario
    
    //Acciones de la plataforma
    const txAccRegistro =  '1'; //Registro en el sistema
    const txAccIngresos =  '2'; //Login  (Ingreso)
    const txAccRecParam =  '3'; //Recuperar datos y parámetros de usuario: incluye calificaciones
    const txAccRecFeeds =  '4'; //Recuperar Feed (Todas las publicaciones de solicitudes y publicaciones de usuarios)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccRecOpera =  '5'; //Recuperar mi operación (Todas mis solicitudes publicaciones y mensajes)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccConfRegi =  '6'; //Confirmacion Registro en el sistema        
    const txAccRecEjemp =  '7'; //Recuperar Ejemplar        
    const txAccRecSolic =  '8'; //Recuperar solicitud
    const txAccRecUsuar =  '9'; //Ver/Recuperar usuario: Incluye su calificacion
    
    const txAccCerraSes =  '10'; //Logout / Cerrar sesion
    const txAccBajaSist =  '11'; //Dar de baja
    const txAccActParam =  '12'; //Actualizar parámetros sistema y datos usuario
    const txAccPubliEje =  '13'; //Publicar un ejemplar
    const txAccModifEje =  '14'; //Modificar un ejemplar
    const txAccElimiEje =  '15'; //Eliminar un ejemplar
    const txAccPubliSol =  '16'; //Publicar una solicitud
    const txAccModifSol =  '17'; //Modificar una solicitud
    const txAccElimiSol =  '18'; //Eliminar una solicitud
    const txAccPubMensa =  '19'; //Enviar un mensaje a una solicitud especifica / Publicar o Responder
    const txAccConcNego =  '20'; //Concretar una negociación: Aceptar un usuario y descartar a los demás
    const txAccDesiNego =  '21'; //Desistir de una negociación ya realizada
    const txAccCaliTrat =  '22'; //Calificar un trato
    const txAccModCalTr =  '23'; //Modificar calificación trato
    const txAccEnviaPQR =  '24'; //Enviar una PQR
    const txAccModifPQR =  '25'; //Modificar una PQR
    const txAccElimiPQR =  '26'; //Eliminar una PQR

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
        $tmpSesion = $sesion->getAccion();
        switch ($tmpSesion){
            //accion de registro en el sistema
            case self::txAccRegistro: {
                //echo "<script>alert('Antes de entrar a Registro-".$tmpSesion."')</script>";
                $objRegistro = $this->get('registro_service');
                $respuesta = $objRegistro::registroUsuario($sesion);
            }    
            //accion de login en el sistema
            case self::txAccIngresos: {
                //echo "<script>alert('Antes de entrar a Registro-".$tmpSesion."')</script>";
                $objLogin = $this->get('login_service');
                $respuesta = $objLogin::loginUsuario($sesion);
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
