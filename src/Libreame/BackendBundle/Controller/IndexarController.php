<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Libreame\BackendBundle\Repository\ManejoDataRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbLibros;



/*
 * Controlador que permite ejecutar funciones para pruebas:
 *  Resetear información  
 */
class IndexarController extends Controller
{   

     public function indexarPruebaAction($dummy)
    {   
        try {
            echo "Inicia indexacion \n";

            $em = $this->getDoctrine()->getManager();
            //echo "<script>alert('validaSesionUsuario :: ingreso')</script>";
            $libros = $em->getRepository('LibreameBackendBundle:LbLibros')->findAll();
            
            foreach ($libros as $libro){
                //echo "Un libro más \n ";
                $texto = "";
                $texgen = "";
                $texaut = "";
                $texedi = "";
                
                $generoslibros = $em->getRepository('LibreameBackendBundle:LbGeneroslibros')->findBy(array('inglilibro' => $libro));
                foreach ($generoslibros as $gl){
                    $generos = $em->getRepository('LibreameBackendBundle:LbGeneros')->findOneBy(array('ingenero' => $gl->getIngligenero()));
                    //if ($generos->getTxgennombre() != NULL)
                    $texgen = $texgen." ".$generos->getTxgennombre();
                }    
                
                $autoreslibros = $em->getRepository('LibreameBackendBundle:LbAutoreslibros')->findBy(array('inautlidlibro' => $libro));
                foreach ($autoreslibros as $al){
                    $autores = $em->getRepository('LibreameBackendBundle:LbAutores')->findOneBy(array('inidautor' => $al->getInautlidautor()));
                    //if ($autores->getTxautnombre()!=NULL){
                    $texaut = $texaut." ".$autores->getTxautnombre();
                    $nom = $autores->getTxautnombre();
                    if ($nom=='gabriel') echo "AUTOR ".$nom." \n";
                    //}
                }    
                
                $editorialeslibros = $em->getRepository('LibreameBackendBundle:LbEditorialeslibros')->findBy(array('inediliblibro' => $libro));
                foreach ($editorialeslibros as $el){
                    $editoriales = $em->getRepository('LibreameBackendBundle:LbEditoriales')->findOneBy(array('inideditorial' => $el->getInedilibroeditorial()));
                    //if ($editoriales->getTxedinombre()!=NULL)
                    $texedi = $texedi." ".$editoriales->getTxedinombre();
                }    
                $texto = $libro->getTxediciondescripcion()." ".$libro->getTxlibedicionpais()." ".$libro->getTxlibresumen()." ".$libro->getTxlibtitulo();
                
                //echo "\n EDITORIAL ".$texedi;
                //echo "\n GENERO ".$texgen;
                //echo $texto." \n";
                $this->indexarDuplicado($libro, $texto." ".$texaut." ".$texedi." ".$texgen, $em);
            }
            
            $em->flush();
            
            return new RESPONSE("Finalizada indexación");
            
        }            
        catch (Exception $ex) {
            return new RESPONSE(-1500);
        }
             
    }
   
    public function indexarDuplicado(LbLibros $libro, $texto, $em)
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
    }    }