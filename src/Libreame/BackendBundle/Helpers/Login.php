<?php

namespace Libreame\BackendBundle\Helpers;

class Login 
{   
    /*
     * Esta funcion ejecuta la aacion necesaria para crear/Cerrar una sesión de un usuario en la plataforma::: 
     * Login del usuario, Logout del usuario
     * 
     * Retorna: ***JSONData(IDSESION)*** = 1. Opción Solicitada=C02  -  2. Usuario=Usuario digitado  -  
     * 3.Sesión=NULL  -  4.IP=Del dispositivo  -  5.Dispositivo=Id del dispositivo: MAC  -  
     * 6.Marca=Marca del dispositivo  -  7.Modelo=Modelo del dispositivo  -  
     * 8. SO=Sistema operativo del dispositivo         
     * ***     JSONData (IDRESPUESTA)  ***  =  
     * 1.Respuesta: (0: si el usuario o la clave son inválidos; 
     *              Retorna -1: Si no se pudo loguear por disponibilidad de la plataforma; 
     *              Retorna 1 : si se logró el login. El id de la sesión se persiste en la base de datos.  
     *              Retorna -2 Si el usuario tiene una sesión activa   
     *              Retorna -3 si la sesion es sospechosa de ser ataque, 
     *              Retorna -4 Si el usuario no está activo o esta en espera de confirmación de registro)  
     * 2. IdSesion La sesión de arriba no se utiliza, la sesión creada se envía en este campo, si se generó alguna
     * 
     * Estados del usuario: 0: Esperando confirmación 1: Activo 2: Cuarentena 3: Inactivo
     * Valida:
     *  1. Usuario existe y está activo (Solo puede estar en estado 2)
     *  2. DESPUES:::Dispositivo registrado??:::Se valida si el dispositivo es aquel que el usuario acostumbra a utilizar
     *  3. 
     * 
     */
    public function loginUsuario($datos, $sesion)
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
                $objRegistro = $this->get('registro_service');
                $respuesta = $objRegistro::registroUsuario($sesion);
            } 
                
        }
        //echo "<script>alert('ejecuta Accion: ".$respuesta."')</script>";
        return $respuesta;
    }
    
    
    
    
    
    public function registroUsuario($pSesion)
    {   
        $objAcceso = $this->get('acceso_service');
        try {
            //echo "<script>alert('Ingresa Registro')</script>";
            $em = $this->getDoctrine()->getManager();
            $usuario = new LbUsuarios();
            $device = new LbDispusuarios();
            $membresia = new LbMembresias();
            $sesion = new LbSesiones();
            $actsesion = new LbActsesion();


            //Lugar por default (Es el de ID = 1)
            $Lugar = $em->getRepository('LibreameBackendBundle:LbLugares')->find(1);
            //Grupo por default (Es el de ID = 1)
            $Grupo = $em->getRepository('LibreameBackendBundle:LbGrupos')->find(1);
            //Valida que el usuario no existe
            if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->findOneBy(array('txusuemail' => $pSesion->getEmail()))){
                try {
                    //Guarda el usuario
                    echo "<script>alert('Usuario NO existe')</script>";
                    $usuario->setTxusuemail($pSesion->getEmail());  
    
    
    
}
