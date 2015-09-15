SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `ex4read` ;
CREATE SCHEMA IF NOT EXISTS `ex4read` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ex4read` ;

-- -----------------------------------------------------
-- Table `ex4read` .`lb_lugares`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_lugares` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_lugares` (
  `inLugar` INT NOT NULL AUTO_INCREMENT COMMENT 'Id Automático' ,
  `txLugCodigo` VARCHAR(45) NOT NULL COMMENT 'Código del lugar: Ejemplo en Colombia DIVIPOLA' ,
  `txLugNombre` VARCHAR(100) NOT NULL COMMENT 'Nombre del lugar, Ciudad, Depto, etc.' ,
  `inLugPadre` INT NULL COMMENT 'Padre o entidad de orden superior que contiene este lugar' ,
  PRIMARY KEY (`inLugar`) ,
  INDEX `fk_lb_lugares_lb_lugares1_idx` (`inLugPadre` ASC) ,
  CONSTRAINT `fk_lb_lugares_lb_lugares1`
    FOREIGN KEY (`inLugPadre` )
    REFERENCES `ex4read` .`lb_lugares` (`inLugar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Se refiere a ciudades paises, departamentos, pueblos, etc';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_usuarios` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_usuarios` (
  `inUsuario` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `txUsuEmail` VARCHAR(100) NOT NULL COMMENT 'Mail del usuario' ,
  `txUsuTelefono` VARCHAR(45) NOT NULL DEFAULT 0 COMMENT 'Numero de telefono' ,
  `txUsuNombre` VARCHAR(100) NOT NULL COMMENT 'Nombre de usuario, por defecto es el email en el registro' ,
  `inUsuGenero` INT NOT NULL DEFAULT 2 COMMENT '\'0: Masculino 1: Femenino 2: Sin especificar\'' ,
  `txUsuImagen` VARCHAR(500) NOT NULL COMMENT 'Cuando no se especifica el sistema pone una por defecto.' ,
  `inUsuLugar` INT NOT NULL COMMENT 'Id de la tabla lugares' ,
  `txUsuNomMostrar` VARCHAR(100) NULL COMMENT 'Si no se digita nada, se muestra el txUsuNombre\n' ,
  `feUsuNacimiento` DATETIME NULL COMMENT 'Fecha de nacimiento' ,
  `txUsuValidacion` VARCHAR(200) NULL COMMENT 'Cuando se registra el usuario el sistema genera un código que se envía en el email de confirmación.  Este campo se utiliza tambien en los cambios de clave.' ,
  `inUsuEstado` INT NOT NULL DEFAULT 0 COMMENT '0: Esperando confirmación 1: Activo 2: Cuarentena 3: Inactivo' ,
  `txUsuClave` VARCHAR(256) NOT NULL ,
  PRIMARY KEY (`inUsuario`) ,
  INDEX `fk_lb_usuarios_lb_lugares1_idx` (`inUsuLugar` ASC) ,
  UNIQUE INDEX `txUsuEmail_UNIQUE` (`txUsuEmail` ASC) ,
  UNIQUE INDEX `txUsuTelefono_UNIQUE` (`txUsuTelefono` ASC) ,
  CONSTRAINT `fk_lb_usuarios_lb_lugares1`
    FOREIGN KEY (`inUsuLugar` )
    REFERENCES `ex4read` .`lb_lugares` (`inLugar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Mantiene la base de datos de usuarios de Libreame';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_generos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_generos` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_generos` (
  `inGenero` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `txGenNombre` VARCHAR(100) NOT NULL COMMENT 'Nombre del genero: NOVELAS.....' ,
  PRIMARY KEY (`inGenero`) )
ENGINE = InnoDB
COMMENT = 'Listado de Generos en los que se encuentran clasificados los libros en Libreame';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_libros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_libros` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_libros` (
  `inLibro` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inLibGenero` INT NOT NULL COMMENT 'Id del genero en el que se clasifica el libro' ,
  `txLibTipoPublica` INT NOT NULL DEFAULT 0 COMMENT 'Tipo publicacion\n0:Libro\n1:Revista.....' ,
  `txLibTitulo` VARCHAR(200) NOT NULL COMMENT 'Titulo del libro' ,
  `txLibAutores` VARCHAR(200) NULL COMMENT 'Autores del libro separados por coma' ,
  `txLibIdioma` VARCHAR(45) NOT NULL COMMENT 'Una tabla de idiomas o de parametros' ,
  `txLibEditorial` VARCHAR(100) NULL COMMENT 'Editorial que imprimió el libro' ,
  `txLibEdicionAnio` VARCHAR(10) NULL COMMENT 'Año de la edición' ,
  `txLibEdicionNum` VARCHAR(10) NULL COMMENT 'Número de la edicion' ,
  `txLibEdicionPais` VARCHAR(100) NULL COMMENT 'País donde fue editado' ,
  `txLibCodigoOfic` VARCHAR(45) NULL COMMENT 'ISBN - ISSN' ,
  `txLibResumen` VARCHAR(300) NULL COMMENT 'Muy pequeño Resumen del libro' ,
  `txLibTomo` VARCHAR(45) NULL COMMENT 'Tomo o numero del libro' ,
  `txLibVolumen` VARCHAR(45) NULL COMMENT 'Volumen del libro' ,
  `txPaginas` VARCHAR(45) NULL COMMENT 'Numero de páginas del libro' ,
  PRIMARY KEY (`inLibro`) ,
  INDEX `fk_lb_libros_lb_generos1_idx` (`inLibGenero` ASC) ,
  CONSTRAINT `fk_lb_libros_lb_generos1`
    FOREIGN KEY (`inLibGenero` )
    REFERENCES `ex4read` .`lb_generos` (`inGenero` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Consigna la base de datos completa de libros y revisatas con codigos ISBN e ISSN, esta base de datos cuenta con una base de libros, pero se puede alimentar por los usuarios.';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_ejemplares`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_ejemplares` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_ejemplares` (
  `inEjemplar` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inEjeUsuDueno` INT NOT NULL COMMENT 'Id Usuario dueño del ejemplar' ,
  `inEjeLibro` INT NOT NULL COMMENT 'Id del Libro (Generico)' ,
  `inEjeCantidad` INT NOT NULL DEFAULT 1 COMMENT 'En algun momento se va a ctivar la posibilidad de que un usuario pueda publicar varios ejemplares de un mismo libro' ,
  `dbEjeAvaluo` DOUBLE NOT NULL DEFAULT 0 COMMENT 'Valor en el que el usuario avalua su libro' ,
  PRIMARY KEY (`inEjemplar`) ,
  INDEX `fk_lb_ejemplares_lb_usuarios1_idx` (`inEjeUsuDueno` ASC) ,
  INDEX `fk_lb_ejemplares_lb_libros1_idx` (`inEjeLibro` ASC) ,
  CONSTRAINT `fk_lb_ejemplares_lb_usuarios1`
    FOREIGN KEY (`inEjeUsuDueno` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ejemplares_lb_libros1`
    FOREIGN KEY (`inEjeLibro` )
    REFERENCES `ex4read` .`lb_libros` (`inLibro` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Un ejemplar es una instancia especifica de un Libro, que en teoría posee un usuario';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_grupos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_grupos` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_grupos` (
  `inGrupo` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inGruNombre` VARCHAR(200) NOT NULL COMMENT 'Nombre del grupo' ,
  `feGruFecha` DATETIME NOT NULL COMMENT 'Fecha de creación del grupo' ,
  `inGruCantMiem` INT NOT NULL DEFAULT 0 COMMENT 'si cantiad de miembros es cero, significa que es ilimitado.' ,
  PRIMARY KEY (`inGrupo`) )
ENGINE = InnoDB
COMMENT = 'contiene todos los grupos de usuarios que existen en el sistema. Cada usuario debe pertenecer a un grupo. Cuando un usuario se registra queda inscrito en un grupo por defecto: Creado de manera General este será el grupo 1...con código fijo.Al inicio de operacion no va a existir la posibilidad de GRUPOS';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_membresias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_membresias` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_membresias` (
  `inMembresia` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inMemUsuario` INT NOT NULL COMMENT 'Usuario miembro' ,
  `inMemGrupo` INT NOT NULL COMMENT 'Grupo al que el usuario es miembro' ,
  `inMemCreador` INT NOT NULL DEFAULT 0 COMMENT 'Indica si el usuario es creador del grupo \n0: No - 1: Si' ,
  `inMemActiva` INT NOT NULL DEFAULT 1 COMMENT 'Indica si el usuario sigue siendo miembro del grupo, en principio no se tendrá en cuenta este campo\n0: Inactiva - 1:Activa' ,
  PRIMARY KEY (`inMembresia`) ,
  INDEX `fk_lb_membresias_lb_usuarios_idx` (`inMemUsuario` ASC) ,
  INDEX `fk_lb_membresias_lb_grupos1_idx` (`inMemGrupo` ASC) ,
  CONSTRAINT `fk_lb_membresias_lb_usuarios`
    FOREIGN KEY (`inMemUsuario` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_membresias_lb_grupos1`
    FOREIGN KEY (`inMemGrupo` )
    REFERENCES `ex4read` .`lb_grupos` (`inGrupo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'REgistra cada una de las membresías a grupos de cada usuario. Este módulo está inhabilitado en el lanzamiento. solo va a existir un grupo y por ende un reporte de membresía por cada usuario. hasta que se decida la implementación.';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_historiaejemplar`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_historiaejemplar` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_historiaejemplar` (
  `inHistEjemplar` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inHEjEjemplar` INT NOT NULL COMMENT 'El ejemplar que registra historia' ,
  `inHEjUsuario` INT NOT NULL COMMENT 'Usuario que posee el ejemplar en algun momento' ,
  `inHEjFechaHora` DATETIME NOT NULL COMMENT 'Desde cuando el usuario tiene este ejemplar...para lo que lo registran en el sistema aparece la fecha de ese momento' ,
  `inHEjModo` INT NOT NULL DEFAULT 0 COMMENT 'Indica:\n0: si es el usuario original (en Libreame)\n1: si lo cambió\n2: si lo compró' ,
  PRIMARY KEY (`inHistEjemplar`) ,
  INDEX `fk_lb_historiaejemplar_lb_ejemplares1_idx` (`inHEjEjemplar` ASC) ,
  INDEX `fk_lb_historiaejemplar_lb_usuarios1_idx` (`inHEjUsuario` ASC) ,
  CONSTRAINT `fk_lb_historiaejemplar_lb_ejemplares1`
    FOREIGN KEY (`inHEjEjemplar` )
    REFERENCES `ex4read` .`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_historiaejemplar_lb_usuarios1`
    FOREIGN KEY (`inHEjUsuario` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Permite registrar todos los propietarios que ha tenido cada ejemplar\n';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_ofertas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_ofertas` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_ofertas` (
  `inOferta` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inOfeMembresia` INT NOT NULL COMMENT 'Identifica el usuario dentro de un grupo' ,
  `feOfeFecha` DATETIME NOT NULL COMMENT 'Fecha de la oferta' ,
  `inOfeVigencia` INT NOT NULL DEFAULT 1 COMMENT 'Días de vigencia de la oferta' ,
  `inOfeActiva` INT NULL DEFAULT 1 COMMENT '0:Inactiva - 1:Activa' ,
  `inOfeAbierta` INT NULL DEFAULT 0 COMMENT 'Cerrada significa que solo se publicará y se tendrá acceso para los usuarios de los grupos a los que pertenezco. Abierta significa que es a nivel general. Por ahora se va a tener cerrada ya que todo el mundo pertenece a un solo grupo.\n0: Cerrada - 1:Abierta' ,
  INDEX `fk_lb_ofertas_lb_membresias1_idx` (`inOfeMembresia` ASC) ,
  PRIMARY KEY (`inOferta`) ,
  CONSTRAINT `fk_lb_ofertas_lb_membresias1`
    FOREIGN KEY (`inOfeMembresia` )
    REFERENCES `ex4read` .`lb_membresias` (`inMembresia` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Registra las ofertas que realizan los usuarios en la plataforma. A nivel de tabla maestra. La informacion detallada de lo que un usuario ofrece se encuentra en las tablas de detalle lbsolicitados/lbofrecidos';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_ofrecidos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_ofrecidos` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_ofrecidos` (
  `inOfrecido` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inOfrEjemplar` INT NOT NULL COMMENT 'Id del ejemplar' ,
  `inOfrOferta` INT NOT NULL COMMENT 'Id de la oferta' ,
  `inOfrTransac` INT NOT NULL DEFAULT 1 COMMENT 'La transacción que se desea con el ejemplar\n0:Venta 1:Cambio 2:Cualquiera 3: Alquiler(?)' ,
  `txOfrObservacion` VARCHAR(100) NULL COMMENT 'Observaciones acerca del ejemplar' ,
  `dbOfrValOferta` DOUBLE NOT NULL DEFAULT 0 COMMENT 'Valor que pido por el ejemplar' ,
  `dbOfrValAdic` DOUBLE NOT NULL DEFAULT 0 COMMENT 'Valor que pido por el ejemplar adicionando el libro que solicito.' ,
  PRIMARY KEY (`inOfrecido`) ,
  INDEX `fk_lb_ofrecidos_lb_ejemplares1_idx` (`inOfrEjemplar` ASC) ,
  INDEX `fk_lb_ofrecidos_lb_ofertas1_idx` (`inOfrOferta` ASC) ,
  CONSTRAINT `fk_lb_ofrecidos_lb_ejemplares1`
    FOREIGN KEY (`inOfrEjemplar` )
    REFERENCES `ex4read` .`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ofrecidos_lb_ofertas1`
    FOREIGN KEY (`inOfrOferta` )
    REFERENCES `ex4read` .`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Detalle de la oferta en el que consigno los EJEMPLARES que estoy ofreciendo';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_generosofrecidos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_generosofrecidos` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_generosofrecidos` (
  `inGeneroOfrecido` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inGOfGenero` INT NOT NULL COMMENT 'Id del Genero ofrecido' ,
  `inGOfOfrecido` INT NOT NULL COMMENT 'Id del registro de detalle de Ofrecido asociado a una oferta.' ,
  PRIMARY KEY (`inGeneroOfrecido`) ,
  INDEX `fk_lb_generosofrecidos_lb_generos1_idx` (`inGOfGenero` ASC) ,
  INDEX `fk_lb_generosofrecidos_lb_ofrecidos1_idx` (`inGOfOfrecido` ASC) ,
  CONSTRAINT `fk_lb_generosofrecidos_lb_generos1`
    FOREIGN KEY (`inGOfGenero` )
    REFERENCES `ex4read` .`lb_generos` (`inGenero` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_generosofrecidos_lb_ofrecidos1`
    FOREIGN KEY (`inGOfOfrecido` )
    REFERENCES `ex4read` .`lb_ofrecidos` (`inOfrecido` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Cuando la solicitud que hago por un libro o ejemplar involucra que yo estoy dispuesto a dar un libro de algún genero sin especificarlo en particular.';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_solicitados`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_solicitados` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_solicitados` (
  `IdSolicitado` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inSolEjemplar` INT NULL COMMENT 'Cuando encuentro un ejemplar puedo pedirlo' ,
  `inSolLibro` INT NULL COMMENT 'Si no hay un ejemplar lo pido del catálogo' ,
  `inSolOferta` INT NOT NULL COMMENT 'Id de la oferta' ,
  `inSolTransac` INT NOT NULL DEFAULT 1 COMMENT 'La transacción que se desea con el ejemplar\n0:Compra 1:Cambio 2: Cualquiera 3: Alquiler(?)' ,
  `txSolObservacion` VARCHAR(300) NULL COMMENT 'Observaciones especificas de la solicitud: No importa el estado, que no este rallado, el de pasta dura...etc.' ,
  `dbSolValOferta` DOUBLE NOT NULL DEFAULT 0 COMMENT 'Valor que estoy dispuesto a pagar' ,
  `dbSolValAdic` DOUBLE NOT NULL DEFAULT 0 COMMENT 'Valor que estoy dispuesto a pagar adicional al libro que ofrezco' ,
  PRIMARY KEY (`IdSolicitado`) ,
  INDEX `fk_lb_solicitados_lb_ejemplares1_idx` (`inSolEjemplar` ASC) ,
  INDEX `fk_lb_solicitados_lb_ofertas1_idx` (`inSolOferta` ASC) ,
  INDEX `fk_lb_solicitados_lb_libros1_idx` (`inSolLibro` ASC) ,
  CONSTRAINT `fk_lb_solicitados_lb_ejemplares1`
    FOREIGN KEY (`inSolEjemplar` )
    REFERENCES `ex4read` .`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_solicitados_lb_ofertas1`
    FOREIGN KEY (`inSolOferta` )
    REFERENCES `ex4read` .`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_solicitados_lb_libros1`
    FOREIGN KEY (`inSolLibro` )
    REFERENCES `ex4read` .`lb_libros` (`inLibro` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Mantiene el registro de los libros que los usuarios solicitan al generar OFERTA';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_generossolicitados`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_generossolicitados` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_generossolicitados` (
  `inGeneroSolicitado` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inSolGenero` INT NOT NULL COMMENT 'Id del genero solicitado' ,
  `inSolSolicitado` INT NOT NULL COMMENT 'Id del registro de detalle de Solicitado asociado a una oferta.' ,
  INDEX `fk_lb_generossolicitados_lb_generos1_idx` (`inSolGenero` ASC) ,
  PRIMARY KEY (`inGeneroSolicitado`) ,
  INDEX `fk_lb_generossolicitados_lb_solicitados1_idx` (`inSolSolicitado` ASC) ,
  CONSTRAINT `fk_lb_generossolicitados_lb_generos1`
    FOREIGN KEY (`inSolGenero` )
    REFERENCES `ex4read` .`lb_generos` (`inGenero` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_generossolicitados_lb_solicitados1`
    FOREIGN KEY (`inSolSolicitado` )
    REFERENCES `ex4read` .`lb_solicitados` (`IdSolicitado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Cuando la solicitud que hago por un libro o ejemplar involucra que yo estoy dispuesto a recibir un libro de algún genero sin especificarlo en particular.';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_ofertasfavoritas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_ofertasfavoritas` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_ofertasfavoritas` (
  `inOfertaFavorita` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inFavUsuario` INT NOT NULL COMMENT 'Id Usuario' ,
  `inFavOferta` INT NOT NULL COMMENT 'Id Oferta' ,
  `feFavFecha` DATETIME NOT NULL COMMENT 'Fecha en la que la marque como favorita' ,
  PRIMARY KEY (`inOfertaFavorita`) ,
  INDEX `fk_lb_ofertasfavoritas_lb_usuarios1_idx` (`inFavUsuario` ASC) ,
  INDEX `fk_lb_ofertasfavoritas_lb_ofertas1_idx` (`inFavOferta` ASC) ,
  CONSTRAINT `fk_lb_ofertasfavoritas_lb_usuarios1`
    FOREIGN KEY (`inFavUsuario` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ofertasfavoritas_lb_ofertas1`
    FOREIGN KEY (`inFavOferta` )
    REFERENCES `ex4read` .`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Cada usuario puede mantener una lista de ofertas favoritas. Esta lista se mantiene siempre y cuando no se hayan realizado ya los tratos.';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_actividadofertas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_actividadofertas` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_actividadofertas` (
  `inActividadOferta` INT NOT NULL AUTO_INCREMENT ,
  `inActOferta` INT NOT NULL ,
  `inActUsuario` INT NOT NULL COMMENT 'El usuario que hace la pregunta o responde en el hilo, puede ser incluso el dueño de la oferta' ,
  `feActFechaHora` DATETIME NOT NULL COMMENT 'Fecha del movimiento en el hilo' ,
  `inActPadreAct` INT NULL COMMENT 'Actividad padre dentro del hilo...es decir a cual le estoy respondiendo' ,
  `txActDescripcion` VARCHAR(300) NULL COMMENT 'Permite consignar preguntas, contraofertas, responderlas etc.' ,
  `inActEstado` INT NULL DEFAULT 0 COMMENT '0: No leido\n1: Leido\n2: Ofensivo/Oculto\n3: Privado\n4: Eliminado del hilo (No se eliminan pero estos no deben aparecer nunca.)\n' ,
  PRIMARY KEY (`inActividadOferta`) ,
  INDEX `fk_lb_ActividadOfertas_lb_usuarios1_idx` (`inActUsuario` ASC) ,
  INDEX `fk_lb_ActividadOfertas_lb_ofertas1_idx` (`inActOferta` ASC) ,
  INDEX `fk_lb_ActividadOfertas_lb_ActividadOfertas1_idx` (`inActPadreAct` ASC) ,
  CONSTRAINT `fk_lb_ActividadOfertas_lb_usuarios1`
    FOREIGN KEY (`inActUsuario` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ActividadOfertas_lb_ofertas1`
    FOREIGN KEY (`inActOferta` )
    REFERENCES `ex4read` .`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ActividadOfertas_lb_ActividadOfertas1`
    FOREIGN KEY (`inActPadreAct` )
    REFERENCES `ex4read` .`lb_actividadofertas` (`inActividadOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Todos los mensajes, dudas, contraofertas, respuestas etc que se llevan en torno a una oferta';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_tratos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_tratos` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_tratos` (
  `inTrato` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inTraOferta` INT NOT NULL COMMENT 'Oferta relacionada ' ,
  `inTraUsuOfrecio` INT NOT NULL COMMENT 'Usuario que realizó la oferta' ,
  `inTraUsuAcepto` INT NOT NULL COMMENT 'Usuario que acepta la oferta' ,
  `inTraFecha` DATETIME NOT NULL COMMENT 'Fecha en la que se cierra el trato (se actualiza cuando cada usuario acepta.)' ,
  `inTraEstado` INT NOT NULL DEFAULT 0 COMMENT '0: Cerrado (Acabo de cerrar el trato)\n1: Cumplido por ambas partes\n2: Incumplido por Oferente\n3: Inclumplido por Acepto \n4. En proceso (Cerrado pero no realizado fisicamente aun)\n5. Incumplido por ambos (Cuando ninguno de los dos marcó el hecho de su realización)' ,
  `txTraAcuEntrega` VARCHAR(500) NOT NULL COMMENT 'Permite indicar lugares, acuerdos y condiciones particulares de la entrega' ,
  `feTraFecEntrega` DATETIME NOT NULL COMMENT 'Fecha y hora acordada para la entrega.' ,
  PRIMARY KEY (`inTrato`) ,
  INDEX `fk_lb_tratos_lb_ofertas1_idx` (`inTraOferta` ASC) ,
  INDEX `fk_lb_tratos_lb_usuarios1_idx` (`inTraUsuOfrecio` ASC) ,
  INDEX `fk_lb_tratos_lb_usuarios2_idx` (`inTraUsuAcepto` ASC) ,
  CONSTRAINT `fk_lb_tratos_lb_ofertas1`
    FOREIGN KEY (`inTraOferta` )
    REFERENCES `ex4read` .`lb_ofertas` (`inOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_tratos_lb_usuarios1`
    FOREIGN KEY (`inTraUsuOfrecio` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_tratos_lb_usuarios2`
    FOREIGN KEY (`inTraUsuAcepto` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Se consigna información cuando dos usuarios cierran un trato de cambio / compra o venta de un ejemplar';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_calificausuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_calificausuarios` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_calificausuarios` (
  `inCalificacion` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inCalUsuCalifica` INT NOT NULL COMMENT 'Usuario que califica' ,
  `inCalUsuCalificado` INT NOT NULL COMMENT 'Usuario calificado' ,
  `inCalCalificacion` INT NOT NULL COMMENT 'Calificación otorgada de 1 a 5' ,
  `txCalObservacion` VARCHAR(500) NULL COMMENT 'Comentario anexo a la calificacion' ,
  `inCalReporteAbuso` INT NOT NULL DEFAULT 0 COMMENT '0: No es reporte de abuso\n1: Si es reporte de abuso' ,
  PRIMARY KEY (`inCalificacion`) ,
  INDEX `fk_lb_calificausuarios_lb_usuarios1_idx` (`inCalUsuCalifica` ASC) ,
  INDEX `fk_lb_calificausuarios_lb_usuarios2_idx` (`inCalUsuCalificado` ASC) ,
  CONSTRAINT `fk_lb_calificausuarios_lb_usuarios1`
    FOREIGN KEY (`inCalUsuCalifica` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_calificausuarios_lb_usuarios2`
    FOREIGN KEY (`inCalUsuCalificado` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Almacena las calificaciones que se generan entre usuarios';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_detallestratos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_detallestratos` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_detallestratos` (
  `inDetalleTrato` INT NOT NULL AUTO_INCREMENT COMMENT 'Id' ,
  `inDetTrato` INT NOT NULL COMMENT 'Trato que se detalla' ,
  `inDetEjemplarUsr` INT NULL COMMENT 'El ejemplar que el usuario oferente involucró en el trato' ,
  `inDetUsuarioOtro` INT NOT NULL COMMENT 'Usuario involucrado en el trato: El que acepta la propuesta.' ,
  `inDetUsuario` INT NOT NULL COMMENT 'Usuario que inició la oferta' ,
  `inDetEjemplarOtro` INT NULL COMMENT 'El ejemplar de la otra persona' ,
  `inDetValorUsr` DOUBLE NOT NULL DEFAULT 0 COMMENT 'El valor que yo estoy dispuesto a pagar' ,
  `inDetValorOtro` DOUBLE NOT NULL DEFAULT 0 COMMENT 'El valor que el otro me ofrecio' ,
  INDEX `fk_lb_detallestratos_lb_tratos1_idx` (`inDetTrato` ASC) ,
  PRIMARY KEY (`inDetalleTrato`) ,
  INDEX `fk_lb_detallestratos_lb_ejemplares1_idx` (`inDetEjemplarUsr` ASC) ,
  INDEX `fk_lb_detallestratos_lb_usuarios1_idx` (`inDetUsuario` ASC) ,
  INDEX `fk_lb_detallestratos_lb_ejemplares2_idx` (`inDetEjemplarOtro` ASC) ,
  INDEX `fk_lb_detallestratos_lb_usuarios2_idx` (`inDetUsuarioOtro` ASC) ,
  CONSTRAINT `fk_lb_detallestratos_lb_tratos1`
    FOREIGN KEY (`inDetTrato` )
    REFERENCES `ex4read` .`lb_tratos` (`inTrato` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_detallestratos_lb_ejemplares1`
    FOREIGN KEY (`inDetEjemplarUsr` )
    REFERENCES `ex4read` .`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_detallestratos_lb_usuarios1`
    FOREIGN KEY (`inDetUsuario` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_detallestratos_lb_ejemplares2`
    FOREIGN KEY (`inDetEjemplarOtro` )
    REFERENCES `ex4read` .`lb_ejemplares` (`inEjemplar` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_detallestratos_lb_usuarios2`
    FOREIGN KEY (`inDetUsuarioOtro` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Almacena la informacion detallada de cada trato que se realiza. Aqui se indica como queda el trato registrado: Que ejemplar cambiaré por cual otro, con que usuario, y si hay direro por la transaccion.';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_dispusuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_dispusuarios` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_dispusuarios` (
  `inDispUsuario` INT NOT NULL AUTO_INCREMENT COMMENT 'ID' ,
  `inDisUsuario` INT NOT NULL COMMENT 'ID del usuario' ,
  `txDisID` VARCHAR(45) NOT NULL COMMENT 'Identificacion del dispositivo' ,
  `txDisNombre` VARCHAR(45) NULL COMMENT 'Nombre del dispositivo' ,
  `txDisMarca` VARCHAR(45) NULL COMMENT 'Marca del dispositivo' ,
  `txDisModelo` VARCHAR(45) NULL COMMENT 'Modelo del dispositivo' ,
  `txDisSO` VARCHAR(45) NULL COMMENT 'Sistema operativo del dispositivo' ,
  PRIMARY KEY (`inDispUsuario`) ,
  INDEX `fk_lb_dispusuarios_lb_usuarios1_idx` (`inDisUsuario` ASC) ,
  CONSTRAINT `fk_lb_dispusuarios_lb_usuarios1`
    FOREIGN KEY (`inDisUsuario` )
    REFERENCES `ex4read` .`lb_usuarios` (`inUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Contiene cada uno de los dispositivos desde los cuales un usuario accede a la aplicacion';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_sesiones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_sesiones` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_sesiones` (
  `inSesion` INT NOT NULL AUTO_INCREMENT COMMENT 'ID' ,
  `inSesDispUsuario` INT NOT NULL COMMENT 'Dispositivo desde donde se genera la sesion' ,
  `txSesNumero` VARCHAR(45) NOT NULL COMMENT 'ID o Numero de la sesion' ,
  `inSesActiva` INT NOT NULL DEFAULT 1 COMMENT '0: Inactiva 1: Activa' ,
  `feSesFechaIni` DATETIME NOT NULL COMMENT 'Fecha de inicio de la sesion' ,
  `feSesFechaFin` DATETIME NULL COMMENT 'Fecha de fin de la sesion' ,
  `txIPAddr` VARCHAR(30) NOT NULL DEFAULT '000.000.000.000' COMMENT 'Dirección IP desde donde se genera la sesion' ,
  PRIMARY KEY (`inSesion`) ,
  INDEX `fk_lb_sesiones_lb_dispusuarios1_idx` (`inSesDispUsuario` ASC) ,
  CONSTRAINT `fk_lb_sesiones_lb_dispusuarios1`
    FOREIGN KEY (`inSesDispUsuario` )
    REFERENCES `ex4read` .`lb_dispusuarios` (`inDispUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Registra cada una de las sesiones generadas por cada usuario, en cada disposivivo.';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_actsesion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_actsesion` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_actsesion` (
  `inActSesion` INT NOT NULL AUTO_INCREMENT COMMENT 'ID' ,
  `inActSesionDisUs` INT NOT NULL COMMENT 'Id de la Sesion' ,
  `inActAccion` INT NOT NULL DEFAULT 0 COMMENT 'Todas las acciones que existan en el sistema enumeradas y quemadas en una tabla o arreglo' ,
  `txActMensaje` VARCHAR(50) NOT NULL COMMENT 'Mensaje de exito / fallo de la acción' ,
  `feActFecha` DATETIME NOT NULL COMMENT 'Fecha de la actividad' ,
  `inActFinalizada` INT NOT NULL DEFAULT 0 COMMENT '0: no 1:si' ,
  PRIMARY KEY (`inActSesion`) ,
  INDEX `fk_lb_ActSesion_lb_sesiones1_idx` (`inActSesionDisUs` ASC) ,
  CONSTRAINT `fk_lb_ActSesion_lb_sesiones1`
    FOREIGN KEY (`inActSesionDisUs` )
    REFERENCES `ex4read` .`lb_sesiones` (`inSesion` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Se entiende como el detalle de actividad de cada sesion';


-- -----------------------------------------------------
-- Table `ex4read` .`lb_generoslibros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ex4read` .`lb_generoslibros` ;

CREATE  TABLE IF NOT EXISTS `ex4read` .`lb_generoslibros` (
  `inGeneroLibro` INT NOT NULL AUTO_INCREMENT COMMENT 'Id Genero-Libro' ,
  `inGLiGenero` INT NOT NULL COMMENT 'Id del genero' ,
  `inGLiLibro` INT NOT NULL COMMENT 'Id del libro' ,
  INDEX `fk_lb_generosejemplares_lb_generos1_idx` (`inGLiGenero` ASC) ,
  INDEX `fk_lb_generosejemplares_lb_libros1_idx` (`inGLiLibro` ASC) ,
  PRIMARY KEY (`inGeneroLibro`) ,
  CONSTRAINT `fk_lb_generosejemplares_lb_generos1`
    FOREIGN KEY (`inGLiGenero` )
    REFERENCES `ex4read` .`lb_generos` (`inGenero` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_generosejemplares_lb_libros1`
    FOREIGN KEY (`inGLiLibro` )
    REFERENCES `ex4read` .`lb_libros` (`inLibro` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Permite la asociación de un libro con varios generos';

USE `ex4read` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
