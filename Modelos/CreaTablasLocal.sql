SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `mydb` ;
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`lb_lugares`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_lugares` (
  `inLugar` INT NOT NULL AUTO_INCREMENT ,
  `txLugCodigo` VARCHAR(45) NOT NULL ,
  `txLugNombre` VARCHAR(100) NOT NULL ,
  `inLugPadre` INT NOT NULL ,
  PRIMARY KEY (`inLugar`) ,
  INDEX `fk_lb_lugares_lb_lugares1_idx` (`inLugPadre` ASC) ,
  CONSTRAINT `fk_lb_lugares_lb_lugares1`
    FOREIGN KEY (`inLugPadre` )
    REFERENCES `mydb`.`lb_lugares` (`inLugar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Se refiere a ciudades paises, departamentos, pueblos, etc';


-- -----------------------------------------------------
-- Table `mydb`.`lb_usuarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_usuarios` (
  `inUsuario` INT NOT NULL AUTO_INCREMENT ,
  `txUsuEmail` VARCHAR(100) NOT NULL ,
  `txUsuTelefono` VARCHAR(45) NOT NULL DEFAULT 0 ,
  `txUsuNombre` VARCHAR(100) NOT NULL ,
  `inUsuGenero` INT NOT NULL DEFAULT 2 COMMENT '\'0: Masculino 1: Femenino 2: Sin especificar\'' ,
  `txUsuImagen` VARCHAR(50) NOT NULL COMMENT 'Cuando no se especifica el sistema pone una por defecto.' ,
  `inUsuLugar` INT NOT NULL ,
  `txUsuNomMostrar` VARCHAR(20) NULL COMMENT 'Si no se digita nada, se muestra el txUsuNombre\n' ,
  `feUsuNacimiento` DATETIME NULL ,
  PRIMARY KEY (`inUsuario`) ,
  INDEX `fk_lb_usuarios_lb_lugares1_idx` (`inUsuLugar` ASC) ,
  UNIQUE INDEX `txUsuEmail_UNIQUE` (`txUsuEmail` ASC) ,
  UNIQUE INDEX `txUsuTelefono_UNIQUE` (`txUsuTelefono` ASC) ,
  CONSTRAINT `fk_lb_usuarios_lb_lugares1`
    FOREIGN KEY (`inUsuLugar` )
    REFERENCES `mydb`.`lb_lugares` (`inLugar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_generos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_generos` (
  `inGenero` INT NOT NULL AUTO_INCREMENT ,
  `txGenNombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`inGenero`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_libros`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_libros` (
  `inLibro` INT NOT NULL AUTO_INCREMENT ,
  `inLibGenero` INT NOT NULL ,
  `txLibTipoPublica` INT NOT NULL DEFAULT 0 COMMENT '0:Libro\n1:Revista.....' ,
  `txLibTitulo` VARCHAR(200) NOT NULL ,
  `txLibAutores` VARCHAR(200) NULL ,
  `txLibIdioma` VARCHAR(45) NOT NULL COMMENT 'Una tabla de idiomas o de parametros' ,
  `txLibEditorial` VARCHAR(100) NULL ,
  `txLibEdicionAnio` VARCHAR(10) NULL ,
  `txLibEdicionNum` VARCHAR(10) NULL ,
  `txLibEdicionPais` VARCHAR(100) NULL ,
  `txLibCodigoOfic` VARCHAR(45) NULL COMMENT 'ISBN - ISSN' ,
  `txLibResumen` VARCHAR(300) NULL ,
  `txLibTomo` VARCHAR(45) NULL ,
  `txLibVolumen` VARCHAR(45) NULL ,
  `txPaginas` VARCHAR(45) NULL ,
  PRIMARY KEY (`inLibro`) ,
  INDEX `fk_lb_libros_lb_generos1_idx` (`inLibGenero` ASC) ,
  CONSTRAINT `fk_lb_libros_lb_generos1`
    FOREIGN KEY (`inLibGenero` )
    REFERENCES `mydb`.`lb_generos` (`inGenero` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_ejemplares`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_ejemplares` (
  `inEjemplar` INT NOT NULL AUTO_INCREMENT ,
  `inEjeUsuDueno` INT NOT NULL ,
  `inEjeLibro` INT NOT NULL ,
  `inEjeCantidad` INT NOT NULL DEFAULT 1 COMMENT 'En algun momento se va a ctivar la posibilidad de que un usuario pueda publicar varios ejemplares de un mismo libro' ,
  `dbEjeAvaluo` DOUBLE NOT NULL DEFAULT 0 COMMENT 'Valor en el que el usuario avalua su libro' ,
  `inEjeGenero` INT NOT NULL ,
  PRIMARY KEY (`inEjemplar`) ,
  INDEX `fk_lb_ejemplares_lb_usuarios1_idx` (`inEjeUsuDueno` ASC) ,
  INDEX `fk_lb_ejemplares_lb_libros1_idx` (`inEjeLibro` ASC) ,
  INDEX `fk_lb_ejemplares_lb_generos1_idx` (`inEjeGenero` ASC) ,
  CONSTRAINT `fk_lb_ejemplares_lb_usuarios1`
    FOREIGN KEY (`inEjeUsuDueno` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ejemplares_lb_libros1`
    FOREIGN KEY (`inEjeLibro` )
    REFERENCES `mydb`.`lb_libros` (`inLibro` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ejemplares_lb_generos1`
    FOREIGN KEY (`inEjeGenero` )
    REFERENCES `mydb`.`lb_generos` (`inGenero` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Permite clasificar los libros. Evaluar posibilidad de dejar un genero: SIN IDENTIFICAR para que sea el default de los ejemplares';


-- -----------------------------------------------------
-- Table `mydb`.`lb_grupos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_grupos` (
  `inGrupo` INT NOT NULL AUTO_INCREMENT ,
  `inGruNombre` VARCHAR(100) NOT NULL ,
  `feGruFecha` DATETIME NOT NULL ,
  `inGruCantMiem` INT NOT NULL DEFAULT 0 COMMENT 'si cantiad de miembros es cero, significa que es ilimitado.' ,
  PRIMARY KEY (`inGrupo`) )
ENGINE = InnoDB
COMMENT = 'contiene todos los grupos de usuarios que existen en el sistema. Cada usuario debe pertenecer a un grupo. Cuando un usuario se registra queda inscrito en un grupo por defecto: Creado de manera General este será el grupo 1...con código fijo.Al inicio de operacion no va a existir la posibilidad de GRUPOS';


-- -----------------------------------------------------
-- Table `mydb`.`lb_membresias`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_membresias` (
  `inMembresia` INT NOT NULL AUTO_INCREMENT ,
  `inMemUsuario` INT NOT NULL ,
  `inMemGrupo` INT NOT NULL ,
  `inMemCreador` INT NOT NULL DEFAULT 0 COMMENT '0: No - 1: Si' ,
  `inMemActiva` INT NOT NULL DEFAULT 1 COMMENT '0: Inactiva - 1:Activa' ,
  PRIMARY KEY (`inMembresia`) ,
  INDEX `fk_lb_membresias_lb_usuarios_idx` (`inMemUsuario` ASC) ,
  INDEX `fk_lb_membresias_lb_grupos1_idx` (`inMemGrupo` ASC) ,
  CONSTRAINT `fk_lb_membresias_lb_usuarios`
    FOREIGN KEY (`inMemUsuario` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_membresias_lb_grupos1`
    FOREIGN KEY (`inMemGrupo` )
    REFERENCES `mydb`.`lb_grupos` (`inGrupo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_historiaejemplar`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_historiaejemplar` (
  `inHistEjemplar` INT NOT NULL AUTO_INCREMENT ,
  `inHEjEjemplar` INT NOT NULL COMMENT 'El ejemplar que registra historia' ,
  `inHEjUsuario` INT NOT NULL COMMENT 'Usuario que posee el ejemplar en algun momento' ,
  `inHEjFechaHora` DATETIME NOT NULL COMMENT 'Desde cuando el usuario tiene este ejemplar...para lo que lo registran en el sistema aparece la fecha de ese momento, nada' ,
  `inHEjModo` INT NOT NULL DEFAULT 0 COMMENT 'Indica:\n0: si es el usuario original\n1: si lo cambió\n2: si lo compró' ,
  PRIMARY KEY (`inHistEjemplar`) ,
  INDEX `fk_lb_historiaejemplar_lb_ejemplares1_idx` (`inHEjEjemplar` ASC) ,
  INDEX `fk_lb_historiaejemplar_lb_usuarios1_idx` (`inHEjUsuario` ASC) ,
  CONSTRAINT `fk_lb_historiaejemplar_lb_ejemplares1`
    FOREIGN KEY (`inHEjEjemplar` )
    REFERENCES `mydb`.`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_historiaejemplar_lb_usuarios1`
    FOREIGN KEY (`inHEjUsuario` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Permite registrar todos los propietarios que ha tenido cada ejemplar\n';


-- -----------------------------------------------------
-- Table `mydb`.`lb_ofertas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_ofertas` (
  `inOferta` INT NOT NULL AUTO_INCREMENT ,
  `inOfeMembresia` INT NOT NULL ,
  `feOfeFecha` DATETIME NOT NULL ,
  `inOfeVigencia` INT NOT NULL DEFAULT 1 COMMENT 'Días de vigencia de la oferta' ,
  `inOfeActiva` INT NULL DEFAULT 1 COMMENT '0:Inactiva - 1:Activa' ,
  `inOfeAbierta` INT NULL DEFAULT 0 COMMENT 'Cerrada significa que solo se publicará y se tendrá acceso para los usuarios de los grupos a los que pertenezco. Abierta significa que es a nivel general. Por ahora se va a tener cerrada ya que todo el mundo pertenece a un solo grupo.\n0: Cerrada - 1:Abierta' ,
  INDEX `fk_lb_ofertas_lb_membresias1_idx` (`inOfeMembresia` ASC) ,
  PRIMARY KEY (`inOferta`) ,
  CONSTRAINT `fk_lb_ofertas_lb_membresias1`
    FOREIGN KEY (`inOfeMembresia` )
    REFERENCES `mydb`.`lb_membresias` (`inMembresia` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_ofrecidos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_ofrecidos` (
  `inOfrecido` INT NOT NULL AUTO_INCREMENT ,
  `inOfrEjemplar` INT NOT NULL ,
  `inOfrOferta` INT NOT NULL ,
  `inOfrTransac` INT NOT NULL DEFAULT 1 COMMENT 'La transacción que se desea con el ejemplar\n0:Venta 1:Cambio 2:Ambos' ,
  `txOfrObservacion` VARCHAR(100) NULL ,
  `dbOfrValOferta` DOUBLE NOT NULL DEFAULT 0 ,
  `dbOfrValAdic` DOUBLE NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`inOfrecido`) ,
  INDEX `fk_lb_ofrecidos_lb_ejemplares1_idx` (`inOfrEjemplar` ASC) ,
  INDEX `fk_lb_ofrecidos_lb_ofertas1_idx` (`inOfrOferta` ASC) ,
  CONSTRAINT `fk_lb_ofrecidos_lb_ejemplares1`
    FOREIGN KEY (`inOfrEjemplar` )
    REFERENCES `mydb`.`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ofrecidos_lb_ofertas1`
    FOREIGN KEY (`inOfrOferta` )
    REFERENCES `mydb`.`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_generosofrecidos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_generosofrecidos` (
  `inGeneroOfrecido` INT NOT NULL AUTO_INCREMENT ,
  `inGOfGenero` INT NOT NULL ,
  `inGOfOfrecido` INT NOT NULL ,
  PRIMARY KEY (`inGeneroOfrecido`) ,
  INDEX `fk_lb_generosofrecidos_lb_generos1_idx` (`inGOfGenero` ASC) ,
  INDEX `fk_lb_generosofrecidos_lb_ofrecidos1_idx` (`inGOfOfrecido` ASC) ,
  CONSTRAINT `fk_lb_generosofrecidos_lb_generos1`
    FOREIGN KEY (`inGOfGenero` )
    REFERENCES `mydb`.`lb_generos` (`inGenero` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_generosofrecidos_lb_ofrecidos1`
    FOREIGN KEY (`inGOfOfrecido` )
    REFERENCES `mydb`.`lb_ofrecidos` (`inOfrecido` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_solicitados`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_solicitados` (
  `inSolicitado` INT NOT NULL AUTO_INCREMENT ,
  `inSolEjemplar` INT NOT NULL ,
  `inSolOferta` INT NOT NULL ,
  `inSolTransac` INT NOT NULL DEFAULT 1 COMMENT 'La transacción que se desea con el ejemplar\n0:Venta 1:Cambio 2:Ambos' ,
  `txSolObservacion` VARCHAR(100) NULL ,
  `dbSolValOferta` DOUBLE NOT NULL DEFAULT 0 ,
  `dbSolValAdic` DOUBLE NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`inSolicitado`) ,
  INDEX `fk_lb_solicitados_lb_ejemplares1_idx` (`inSolEjemplar` ASC) ,
  INDEX `fk_lb_solicitados_lb_ofertas1_idx` (`inSolOferta` ASC) ,
  CONSTRAINT `fk_lb_solicitados_lb_ejemplares1`
    FOREIGN KEY (`inSolEjemplar` )
    REFERENCES `mydb`.`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_solicitados_lb_ofertas1`
    FOREIGN KEY (`inSolOferta` )
    REFERENCES `mydb`.`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_generossolicitados`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_generossolicitados` (
  `inGeneroSolicitado` INT NOT NULL AUTO_INCREMENT ,
  `inSolGenero` INT NOT NULL ,
  `inSolSolicitado` INT NOT NULL ,
  INDEX `fk_lb_generossolicitados_lb_generos1_idx` (`inSolGenero` ASC) ,
  PRIMARY KEY (`inGeneroSolicitado`) ,
  INDEX `fk_lb_generossolicitados_lb_solicitados1_idx` (`inSolSolicitado` ASC) ,
  CONSTRAINT `fk_lb_generossolicitados_lb_generos1`
    FOREIGN KEY (`inSolGenero` )
    REFERENCES `mydb`.`lb_generos` (`inGenero` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_generossolicitados_lb_solicitados1`
    FOREIGN KEY (`inSolSolicitado` )
    REFERENCES `mydb`.`lb_solicitados` (`inSolicitado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_ofertasfavoritas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_ofertasfavoritas` (
  `inOfertaFavorita` INT NOT NULL AUTO_INCREMENT ,
  `inFavUsuario` INT NOT NULL ,
  `inFavOferta` INT NOT NULL ,
  `feFavFecha` DATETIME NOT NULL ,
  PRIMARY KEY (`inOfertaFavorita`) ,
  INDEX `fk_lb_ofertasfavoritas_lb_usuarios1_idx` (`inFavUsuario` ASC) ,
  INDEX `fk_lb_ofertasfavoritas_lb_ofertas1_idx` (`inFavOferta` ASC) ,
  CONSTRAINT `fk_lb_ofertasfavoritas_lb_usuarios1`
    FOREIGN KEY (`inFavUsuario` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ofertasfavoritas_lb_ofertas1`
    FOREIGN KEY (`inFavOferta` )
    REFERENCES `mydb`.`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_actividadofertas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_actividadofertas` (
  `inActividadOferta` INT NOT NULL AUTO_INCREMENT ,
  `inActOferta` INT NOT NULL ,
  `inActUsuario` INT NULL COMMENT 'Puede ser nulo, si el que genera el comentario o respuesta es el dueño de la oferta. De lo contrario el usuario que se registra es uno que esta interesado en la oferta.' ,
  `feActFechaHora` DATETIME NOT NULL ,
  `inActPadreAct` INT NULL ,
  PRIMARY KEY (`inActividadOferta`) ,
  INDEX `fk_lb_ActividadOfertas_lb_usuarios1_idx` (`inActUsuario` ASC) ,
  INDEX `fk_lb_ActividadOfertas_lb_ofertas1_idx` (`inActOferta` ASC) ,
  INDEX `fk_lb_ActividadOfertas_lb_ActividadOfertas1_idx` (`inActPadreAct` ASC) ,
  CONSTRAINT `fk_lb_ActividadOfertas_lb_usuarios1`
    FOREIGN KEY (`inActUsuario` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ActividadOfertas_lb_ofertas1`
    FOREIGN KEY (`inActOferta` )
    REFERENCES `mydb`.`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ActividadOfertas_lb_ActividadOfertas1`
    FOREIGN KEY (`inActPadreAct` )
    REFERENCES `mydb`.`lb_actividadofertas` (`inActividadOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_tratos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_tratos` (
  `inTrato` INT NOT NULL AUTO_INCREMENT ,
  `inTraOferta` INT NOT NULL ,
  `inTraUsuOfrecio` INT NOT NULL ,
  `inTraUsuAcepto` INT NOT NULL ,
  `inTraFecha` DATETIME NOT NULL ,
  `inTraEstado` INT NOT NULL DEFAULT 0 COMMENT '0: Cerrado (Acabo de cerrar el trato)\n1: Cumplido por ambas partes\n2: Incumplido por Oferente\n3: Inclumplido por Acepto \n4. En proceso (Cerrado pero no realizado fisicamente aun)\n5. Incumplido por ambos (Cuando ninguno de los dos marcó el hecho de su realización)' ,
  `txTraAcuEntrega` VARCHAR(300) NOT NULL COMMENT 'Permite indicar lugares, acuerdos y condiciones particulares de la entrega' ,
  `feTraFecEntrega` DATETIME NOT NULL COMMENT 'Fecha y hora acordada para la entrega.' ,
  PRIMARY KEY (`inTrato`) ,
  INDEX `fk_lb_tratos_lb_ofertas1_idx` (`inTraOferta` ASC) ,
  INDEX `fk_lb_tratos_lb_usuarios1_idx` (`inTraUsuOfrecio` ASC) ,
  INDEX `fk_lb_tratos_lb_usuarios2_idx` (`inTraUsuAcepto` ASC) ,
  CONSTRAINT `fk_lb_tratos_lb_ofertas1`
    FOREIGN KEY (`inTraOferta` )
    REFERENCES `mydb`.`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_tratos_lb_usuarios1`
    FOREIGN KEY (`inTraUsuOfrecio` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_tratos_lb_usuarios2`
    FOREIGN KEY (`inTraUsuAcepto` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_calificausuarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_calificausuarios` (
  `inCalificacion` INT NOT NULL AUTO_INCREMENT ,
  `inCalUsuCalifica` INT NOT NULL ,
  `inCalUsuCalificado` INT NOT NULL ,
  `inCalCalificacion` INT NOT NULL ,
  `txCalObservacion` VARCHAR(100) NULL ,
  `inCalReporteAbuso` INT NOT NULL DEFAULT 0 COMMENT '0: No es reporte de abuso\n1: Si es reporte de abuso' ,
  PRIMARY KEY (`inCalificacion`) ,
  INDEX `fk_lb_calificausuarios_lb_usuarios1_idx` (`inCalUsuCalifica` ASC) ,
  INDEX `fk_lb_calificausuarios_lb_usuarios2_idx` (`inCalUsuCalificado` ASC) ,
  CONSTRAINT `fk_lb_calificausuarios_lb_usuarios1`
    FOREIGN KEY (`inCalUsuCalifica` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_calificausuarios_lb_usuarios2`
    FOREIGN KEY (`inCalUsuCalificado` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_detallestratos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_detallestratos` (
  `inDetalleTrato` INT NOT NULL AUTO_INCREMENT ,
  `inDetTrato` INT NOT NULL ,
  `inDetEjemplarUsr` INT NULL COMMENT 'El ejemplar que yo involucro en el trato' ,
  `inDetUsuarioOtro` INT NOT NULL ,
  `inDetUsuario` INT NOT NULL ,
  `inDetEjemplarOtro` INT NULL COMMENT 'El ejemplar de la otra persona' ,
  `inDetValorUsr` DOUBLE NOT NULL DEFAULT 0 COMMENT 'El valor que yo voy a pagar' ,
  `inDetValorOtro` DOUBLE NOT NULL DEFAULT 0 COMMENT 'El valor que el otro me ofrecio' ,
  INDEX `fk_lb_detallestratos_lb_tratos1_idx` (`inDetTrato` ASC) ,
  PRIMARY KEY (`inDetalleTrato`) ,
  INDEX `fk_lb_detallestratos_lb_ejemplares1_idx` (`inDetEjemplarUsr` ASC) ,
  INDEX `fk_lb_detallestratos_lb_usuarios1_idx` (`inDetUsuario` ASC) ,
  INDEX `fk_lb_detallestratos_lb_ejemplares2_idx` (`inDetEjemplarOtro` ASC) ,
  INDEX `fk_lb_detallestratos_lb_usuarios2_idx` (`inDetUsuarioOtro` ASC) ,
  CONSTRAINT `fk_lb_detallestratos_lb_tratos1`
    FOREIGN KEY (`inDetTrato` )
    REFERENCES `mydb`.`lb_tratos` (`inTrato` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_detallestratos_lb_ejemplares1`
    FOREIGN KEY (`inDetEjemplarUsr` )
    REFERENCES `mydb`.`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_detallestratos_lb_usuarios1`
    FOREIGN KEY (`inDetUsuario` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_detallestratos_lb_ejemplares2`
    FOREIGN KEY (`inDetEjemplarOtro` )
    REFERENCES `mydb`.`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_detallestratos_lb_usuarios2`
    FOREIGN KEY (`inDetUsuarioOtro` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_dispusuarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_dispusuarios` (
  `inDispUsuario` INT NOT NULL AUTO_INCREMENT ,
  `inDisUsuario` INT NOT NULL ,
  `txDisID` VARCHAR(45) NOT NULL ,
  `txDisNombre` VARCHAR(45) NULL ,
  `txDisMarca` VARCHAR(45) NULL ,
  `txDisModelo` VARCHAR(45) NULL ,
  `txDisSO` VARCHAR(45) NULL ,
  PRIMARY KEY (`inDispUsuario`) ,
  INDEX `fk_lb_dispusuarios_lb_usuarios1_idx` (`inDisUsuario` ASC) ,
  CONSTRAINT `fk_lb_dispusuarios_lb_usuarios1`
    FOREIGN KEY (`inDisUsuario` )
    REFERENCES `mydb`.`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_sesiones`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_sesiones` (
  `inSesion` INT NOT NULL AUTO_INCREMENT ,
  `inSesDispUsuario` INT NOT NULL ,
  `txSesNumero` VARCHAR(45) NOT NULL ,
  `inSesActiva` INT NOT NULL DEFAULT 1 COMMENT '0: Inactiva 1: Activa' ,
  `feSesFechaIni` DATETIME NOT NULL ,
  `feSesFechaFin` DATETIME NULL ,
  PRIMARY KEY (`inSesion`) ,
  INDEX `fk_lb_sesiones_lb_dispusuarios1_idx` (`inSesDispUsuario` ASC) ,
  CONSTRAINT `fk_lb_sesiones_lb_dispusuarios1`
    FOREIGN KEY (`inSesDispUsuario` )
    REFERENCES `mydb`.`lb_dispusuarios` (`inDispUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`lb_actsesion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`lb_actsesion` (
  `inActSesion` INT NOT NULL AUTO_INCREMENT ,
  `inActSesionDisUs` INT NOT NULL ,
  `inActAccion` INT NOT NULL DEFAULT 0 COMMENT 'Todas las acciones que existan en el sistema enumeradas y quemadas en una tabla o arreglo' ,
  `txActMensaje` VARCHAR(50) NOT NULL ,
  `feActFecha` DATETIME NOT NULL ,
  `inActFinalizada` INT NOT NULL DEFAULT 0 COMMENT '0: no 1:si' ,
  PRIMARY KEY (`inActSesion`) ,
  INDEX `fk_lb_ActSesion_lb_sesiones1_idx` (`inActSesionDisUs` ASC) ,
  CONSTRAINT `fk_lb_ActSesion_lb_sesiones1`
    FOREIGN KEY (`inActSesionDisUs` )
    REFERENCES `mydb`.`lb_sesiones` (`inSesion` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mydb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
