-- Schema dotEx4read
--
-- Nuevo esquema para dotEx4read con puntos
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dotEx4read` DEFAULT CHARACTER SET utf8 ;

-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_lugares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_lugares` (
  `inLugar` INT NOT NULL AUTO_INCREMENT COMMENT 'Id Automatico',
  `txLugCodigo` VARCHAR(45) NOT NULL COMMENT 'Codigo del lugar: Ejemplo en Colombia DIVIPOLA',
  `txLugNombre` VARCHAR(100) NOT NULL COMMENT 'Nombre del lugar, Ciudad, Depto, etc.',
  `inLugPadre` INT NULL COMMENT 'Padre o entidad de orden superior que contiene este lugar',
  `inLugElegible` INT NOT NULL DEFAULT '0' COMMENT 'Indica si el registro puede ser elegido por un usuario 0: No elegible - 1 : Elegible',
  PRIMARY KEY (`inLugar`),
  INDEX `fk_lb_lugares_lb_lugares1_idx` (`inLugPadre` ASC),
  CONSTRAINT `fk_lb_lugares_lb_lugares1`
    FOREIGN KEY (`inLugPadre`)
    REFERENCES `dotEx4read`.`lb_lugares` (`inLugar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Se refiere a ciudades paises, departamentos, pueblos, etc';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_usuarios` (
  `inUsuario` INT NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `txUsuEmail` VARCHAR(200) NOT NULL COMMENT 'Mail del usuario',
  `txUsuTelefono` VARCHAR(200) NOT NULL DEFAULT '0' COMMENT 'Numero de telefono',
  `txUsuNombre` VARCHAR(300) NOT NULL COMMENT 'Nombre de usuario, por defecto es el email en el registro',
  `inUsuGenero` INT NOT NULL DEFAULT '2' COMMENT '0: Masculino 1: Femenino 2: Sin especificar',
  `txUsuImagen` LONGTEXT NOT NULL COMMENT 'Guarda la url de la imagen',
  `inUsuLugar` INT NOT NULL COMMENT 'Id de la tabla lugares',
  `txUsuNomMostrar` VARCHAR(300) NULL DEFAULT NULL COMMENT 'Si no se digita nada, se muestra el txUsuNombre',
  `feUsuNacimiento` DATETIME NULL COMMENT 'Fecha de nacimiento',
  `txUsuValidacion` VARCHAR(300) NULL COMMENT 'Cuando se registra el usuario el sistema genera un codigo que se envia en el email de confirmacion.  Este campo se utiliza tambien en los cambios de clave.',
  `inUsuEstado` INT NOT NULL DEFAULT '0' COMMENT '0: Esperando confirmacion 1: Activo 2: Cuarentena 3: Inactivo',
  `txUsuClave` VARCHAR(300) NOT NULL,
  `feFecRegistro` DATETIME NOT NULL,
  `feUsuUltIngreso` DATETIME NOT NULL COMMENT 'Fecha de ultimo ingreso del usuario',
  PRIMARY KEY (`inUsuario`),
  UNIQUE INDEX `txUsuEmail_UNIQUE` (`txUsuEmail` ASC),
  UNIQUE INDEX `txUsuTelefono_UNIQUE` (`txUsuTelefono` ASC),
  INDEX `fk_lb_usuarios_lb_lugares1_idx` (`inUsuLugar` ASC),
  CONSTRAINT `fk_lb_usuarios_lb_lugares1`
    FOREIGN KEY (`inUsuLugar`)
    REFERENCES `dotEx4read`.`lb_lugares` (`inLugar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Mantiene la base de datos de usuarios de Libreame';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_dispusuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_dispusuarios` (
  `inDispUsuario` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `inDisUsuario` INT NOT NULL COMMENT 'ID del usuario',
  `txDisID` VARCHAR(100) NOT NULL COMMENT 'Identificacion del dispositivo',
  `txDisNombre` VARCHAR(100) NULL COMMENT 'Nombre del dispositivo',
  `txDisMarca` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Marca del dispositivo',
  `txDisModelo` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Modelo del dispositivo',
  `txDisSO` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Sistema operativo del dispositivo',
  PRIMARY KEY (`inDispUsuario`),
  INDEX `fk_lb_dispusuarios_lb_usuarios1_idx` (`inDisUsuario` ASC),
  CONSTRAINT `fk_lb_dispusuarios_lb_usuarios1`
    FOREIGN KEY (`inDisUsuario`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Contiene cada uno de los dispositivos desde los cuales un usuario accede a la aplicacion';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_sesiones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_sesiones` (
  `inSesion` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `inSesDispUsuario` INT NOT NULL COMMENT 'Dispositivo desde donde se genera la sesion',
  `txSesNumero` VARCHAR(100) NOT NULL COMMENT 'ID o Numero de la sesion',
  `inSesActiva` INT NOT NULL DEFAULT '1' COMMENT '0: Inactiva 1: Activa',
  `feSesFechaIni` DATETIME NOT NULL COMMENT 'Fecha de inicio de la sesion',
  `feSesFechaFin` DATETIME NULL DEFAULT NULL COMMENT 'Fecha de fin de la sesion',
  `txIPAddr` VARCHAR(30) NOT NULL DEFAULT '000.000.000.000' COMMENT 'Direccion IP desde donde se genera la sesion',
  PRIMARY KEY (`inSesion`),
  INDEX `fk_lb_sesiones_lb_dispusuarios1_idx` (`inSesDispUsuario` ASC),
  CONSTRAINT `fk_lb_sesiones_lb_dispusuarios1`
    FOREIGN KEY (`inSesDispUsuario`)
    REFERENCES `dotEx4read`.`lb_dispusuarios` (`inDispUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Registra cada una de las sesiones generadas por cada usuario, en cada disposivivo.';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_actsesion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_actsesion` (
  `inActSesion` INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `inActSesionDisUs` INT NOT NULL COMMENT 'Id de la Sesion',
  `inActAccion` INT NOT NULL DEFAULT '0' COMMENT 'Todas las acciones que existan en el sistema enumeradas y quemadas en una tabla o arreglo',
  `txActMensaje` VARCHAR(500) NOT NULL COMMENT 'Mensaje de exito / fallo de la accion',
  `feActFecha` DATETIME NOT NULL COMMENT 'Fecha de la actividad',
  `inActFinalizada` INT NOT NULL DEFAULT '0' COMMENT '0: no 1:si',
  PRIMARY KEY (`inActSesion`),
  INDEX `fk_lb_ActSesion_lb_sesiones1_idx` (`inActSesionDisUs` ASC),
  CONSTRAINT `fk_lb_ActSesion_lb_sesiones1`
    FOREIGN KEY (`inActSesionDisUs`)
    REFERENCES `dotEx4read`.`lb_sesiones` (`inSesion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Se entiende como el detalle de actividad de cada sesion';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_titulos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_titulos` (
  `inIdTitulo` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del titulo',
  `txTitNTitulo` VARCHAR(200) NOT NULL COMMENT 'Titulo general de la obra',
  PRIMARY KEY (`inIdTitulo`))
ENGINE = InnoDB
COMMENT = 'Almacena un titulo general que agrupa varios libros: ejemplo Cien anhos de soledad, creada para agrupar muchos libros';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_idiomas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_idiomas` (
  `inIdIdioma` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del idioma',
  `txIdiNombre` VARCHAR(100) NOT NULL COMMENT 'Nombre del idioma',
  PRIMARY KEY (`inIdIdioma`))
ENGINE = InnoDB
COMMENT = 'Lista de idiomas, para los libros';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_libros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_libros` (
  `inLibro` INT NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `txLibTipoPublica` INT NOT NULL DEFAULT '0' COMMENT 'Tipo publicacion 0:Libro 1:Revista.....',
  `txLibTitulo` VARCHAR(200) NOT NULL COMMENT 'Titulo del libro',
  `txLibEdicionAnio` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Anho de la edicion',
  `txLibEdicionNum` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Numero de la edicion',
  `txLibEdicionPais` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Pais donde fue editado',
  `txEdicionDescripcion` VARCHAR(45) NULL DEFAULT NULL COMMENT 'Descripcion de la edicion: Pasta dura...de lujo, etc',
  `txLibCodigoOfic` VARCHAR(45) NULL DEFAULT NULL COMMENT 'ISBN - ISSN 10',
  `txLibCodigoOfic13` VARCHAR(45) NULL DEFAULT NULL COMMENT 'ISBN - ISSN 13',
  `txLibResumen` LONGTEXT NULL DEFAULT NULL COMMENT 'Resumen del libro',
  `txLibTomo` VARCHAR(45) NULL DEFAULT NULL COMMENT 'Tomo o numero del libro',
  `txLibVolumen` VARCHAR(45) NULL COMMENT 'Volumen del libro',
  `inLibIdioma` INT NULL,
  `txLibPaginas` VARCHAR(45) NULL COMMENT 'Numero de paginas del libro',
  `inLibTitTitulo` INT NULL COMMENT 'Id del titulo genera de la obra : Por ejemplo, puede ser una representacion de Cien anhos de soledad en chino',
  PRIMARY KEY (`inLibro`),
  INDEX `idx_tipopublica` (`txLibTipoPublica` ASC),
  INDEX `idx_titulo` (`txLibTitulo` ASC),
  INDEX `idx_ISBN10` (`txLibCodigoOfic` ASC),
  INDEX `idx_ISBN13` USING HASH (`txLibCodigoOfic13` ASC),
  INDEX `fk_lb_libros_lb_titulos1_idx` (`inLibTitTitulo` ASC),
  INDEX `fk_lb_libros_lb_idiomas1_idx` (`inLibIdioma` ASC),
  CONSTRAINT `fk_lb_libros_lb_titulos1`
    FOREIGN KEY (`inLibTitTitulo`)
    REFERENCES `dotEx4read`.`lb_titulos` (`inIdTitulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_libros_lb_idiomas1`
    FOREIGN KEY (`inLibIdioma`)
    REFERENCES `dotEx4read`.`lb_idiomas` (`inIdIdioma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Consigna la base de datos completa de libros y revisatas con codigos ISBN e ISSN, esta base de datos cuenta con una base de libros, pero se puede alimentar por los usuarios.';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_ejemplares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_ejemplares` (
  `inEjemplar` INT NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `inEjeUsuDueno` INT NOT NULL COMMENT 'Id Usuario duenho del ejemplar',
  `inEjeLibro` INT NOT NULL COMMENT 'Id del Libro (Generico)',
  `inEjeCantidad` INT NOT NULL DEFAULT '1' COMMENT 'En algun momento se va a activar la posibilidad de que un usuario pueda publicar varios ejemplares de un mismo libro',
  `dbEjeAvaluo` DOUBLE NOT NULL DEFAULT '0' COMMENT 'Valor en el que el usuario avalua su libro',
  `txEjeImagen` LONGTEXT NOT NULL COMMENT 'Guarda la url de la imagen',
  `inEjePuntos` INT NOT NULL DEFAULT 0 COMMENT 'Puntos que cuesta el ejemplar',
  `inEjePublicado` INT NOT NULL DEFAULT 1 COMMENT 'Indica si el ejemplar esta publicado : Publicado :1 / No publicado : 0',
  `inEjeBloqueado` INT NOT NULL DEFAULT 0 COMMENT 'Un ejemplar se bloquea cuando un usuario ya ha gastado sus puntos pero no ha entregado ningun ejemplar, entonces el sistema bloquea tantos ejemplares requiera para asegurar que el usuario no los baje de dotEx4read: No bloqueado : 0 , Bloqueado : 1',
  `inEjeEstado` INT NOT NULL DEFAULT 1 COMMENT 'Estado de 1 a 10: 10 Excelente 1 : Muy deteriorado',
  `inEjeCondicion` INT NOT NULL DEFAULT 1 COMMENT 'Condicion del ejemplar: 0: Nuevo / 1: Usado',
  `inEjeSoloventa` INT NOT NULL DEFAULT 0 COMMENT 'Indica si el ejemplar solo esta disponible para venta - 1: solo venta, 2: Venta y cambio',
  PRIMARY KEY (`inEjemplar`),
  INDEX `fk_lb_ejemplares_lb_usuarios1_idx` (`inEjeUsuDueno` ASC),
  INDEX `fk_lb_ejemplares_lb_libros1_idx` (`inEjeLibro` ASC),
  CONSTRAINT `fk_lb_ejemplares_lb_libros1`
    FOREIGN KEY (`inEjeLibro`)
    REFERENCES `dotEx4read`.`lb_libros` (`inLibro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_ejemplares_lb_usuarios1`
    FOREIGN KEY (`inEjeUsuDueno`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Un ejemplar es una instancia especifica de un Libro, que en teoria posee un usuario';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_generos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_generos` (
  `inGenero` INT NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `txGenNombre` VARCHAR(100) NOT NULL COMMENT 'Nombre del genero: NOVELAS.....',
  PRIMARY KEY (`inGenero`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Listado de Generos en los que se encuentran clasificados los libros en Libreame';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_generoslibros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_generoslibros` (
  `inGeneroLibro` INT NOT NULL AUTO_INCREMENT COMMENT 'Id Genero-Libro',
  `inGLiGenero` INT NOT NULL COMMENT 'Id del genero',
  `inGLiLibro` INT NOT NULL COMMENT 'Id del libro',
  PRIMARY KEY (`inGeneroLibro`),
  INDEX `fk_lb_generosejemplares_lb_generos1_idx` (`inGLiGenero` ASC),
  INDEX `fk_lb_generosejemplares_lb_libros1_idx` (`inGLiLibro` ASC),
  CONSTRAINT `fk_lb_generosejemplares_lb_generos1`
    FOREIGN KEY (`inGLiGenero`)
    REFERENCES `dotEx4read`.`lb_generos` (`inGenero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_generosejemplares_lb_libros1`
    FOREIGN KEY (`inGLiLibro`)
    REFERENCES `dotEx4read`.`lb_libros` (`inLibro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Permite la asociacion de un libro con varios generos';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_grupos` (
  `inGrupo` INT NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `inGruNombre` VARCHAR(200) NOT NULL COMMENT 'Nombre del grupo',
  `feGruFecha` DATETIME NOT NULL COMMENT 'Fecha de creacion del grupo',
  `inGruCantMiem` INT NOT NULL DEFAULT '0' COMMENT 'si cantiad de miembros es cero, significa que es ilimitado.',
  PRIMARY KEY (`inGrupo`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'contiene todos los grupos de usuarios que existen en el sistema. Cada usuario debe pertenecer a un grupo. Cuando un usuario se registra queda inscrito en un grupo por defecto: Creado de manera General este sera el grupo 1...con codigo fijo.Al inicio de operacion no va a existir la posibilidad de GRUPOS';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_indicepalabra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_indicepalabra` (
  `lbIndPalId` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id  del indice',
  `lbIndPalLibro` INT NOT NULL COMMENT 'Id del libro donde esta la ocurrencia',
  `lbIndPalPalabra` VARCHAR(100) NOT NULL COMMENT 'Palabra en minuscula',
  `lbIndPalIdioma` VARCHAR(45) NOT NULL COMMENT 'Idioma del libro, que se hereda a la palabra, para filtrar',
  PRIMARY KEY (`lbIndPalId`),
  INDEX `fk_lb_indicepalabra_lb_libros1_idx` (`lbIndPalLibro` ASC),
  INDEX `idx_palabra` (`lbIndPalPalabra` ASC),
  INDEX `idx_palabraidioma` (`lbIndPalPalabra` ASC, `lbIndPalIdioma` ASC),
  INDEX `idx_idiomapalabra` (`lbIndPalIdioma` ASC, `lbIndPalPalabra` ASC),
  CONSTRAINT `fk_lb_indicepalabra_lb_libros1`
    FOREIGN KEY (`lbIndPalLibro`)
    REFERENCES `dotEx4read`.`lb_libros` (`inLibro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'Indice creado manualmente cuando un Libro se crea, se modifica o se elimina para mejorar las busquedas';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_membresias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_membresias` (
  `inMembresia` INT NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `inMemUsuario` INT NOT NULL COMMENT 'Usuario miembro',
  `inMemGrupo` INT NOT NULL COMMENT 'Grupo al que el usuario es miembro',
  `inMemCreador` INT NOT NULL DEFAULT '0' COMMENT 'Indica si el usuario es creador del grupo 0: No - 1: Si',
  `inMemActiva` INT NOT NULL DEFAULT '1' COMMENT 'Indica si el usuario sigue siendo miembro del grupo, en principio no se tendra en cuenta este campo 0: Inactiva - 1:Activa',
  PRIMARY KEY (`inMembresia`),
  INDEX `fk_lb_membresias_lb_usuarios_idx` (`inMemUsuario` ASC),
  INDEX `fk_lb_membresias_lb_grupos1_idx` (`inMemGrupo` ASC),
  CONSTRAINT `fk_lb_membresias_lb_grupos1`
    FOREIGN KEY (`inMemGrupo`)
    REFERENCES `dotEx4read`.`lb_grupos` (`inGrupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_membresias_lb_usuarios`
    FOREIGN KEY (`inMemUsuario`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COMMENT = 'REgistra cada una de las membresias a grupos de cada usuario. Este modulo esta inhabilitado en el lanzamiento. solo va a existir un grupo y por ende un reporte de membresia por cada usuario. hasta que se decida la implementacion.';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_planes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_planes` (
  `inPlan` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del plan',
  `txPlanNombr` VARCHAR(100) NOT NULL COMMENT 'Nombre del plan',
  `txPlanDescripcion` TEXT(1000) NULL COMMENT 'Descripcion del plan',
  `inPlanVigente` INT NOT NULL DEFAULT 1 COMMENT 'Indica si un plan esta vigente para usar 0 : No vigente 1 : Vigente',
  `inPlanFree` INT NULL DEFAULT 0 COMMENT 'Indica si el plan es gratis',
  `inPlanDiasFree` INT NULL DEFAULT 0 COMMENT 'Cantidad de dias que esta gratis, si el 0, es gratis por siempre',
  `fePlanCreacion` DATETIME NOT NULL COMMENT 'FEcha en que se crea el plan ',
  `fePlanIniVigencia` DATETIME NOT NULL COMMENT 'Fecha de inicio de vigencia del plan',
  `fePlanFinVigencia` DATETIME NULL COMMENT 'Si es ilimitado la fecha es 30 anhos adelante',
  PRIMARY KEY (`inPlan`))
ENGINE = InnoDB
COMMENT = 'Contiene la informacion basica de los planes de dotEx4read';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_planesusuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_planesusuarios` (
  `inPlanUsuario` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del plan de usuario',
  `inUsuPlan` INT NOT NULL,
  `inPlUsPlanes` INT NOT NULL,
  `fePlUsInicio` DATETIME NOT NULL,
  `fePlUsFin` DATETIME NOT NULL COMMENT 'Cuando la vigencia sea ilimitada la fecha es 30 anhos adelante',
  INDEX `fk_table1_lb_usuarios1_idx` (`inUsuPlan` ASC),
  INDEX `fk_lb_planesusuarios_lb_planes1_idx` (`inPlUsPlanes` ASC),
  PRIMARY KEY (`inPlanUsuario`),
  CONSTRAINT `fk_table1_lb_usuarios1`
    FOREIGN KEY (`inUsuPlan`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_planesusuarios_lb_planes1`
    FOREIGN KEY (`inPlUsPlanes`)
    REFERENCES `dotEx4read`.`lb_planes` (`inPlan`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Contiene informacion del plan donde el usuario esta suscrito';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_busquedasusuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_busquedasusuarios` (
  `inBusqueda` INT NOT NULL AUTO_INCREMENT COMMENT 'Id de la busqueda',
  `inBusUsuario` INT NOT NULL,
  `txBusPalabra` VARCHAR(100) NOT NULL COMMENT 'Palabra buscada',
  `feBusFecha` DATETIME NOT NULL COMMENT 'Fecha en que se realiza la busqueda',
  PRIMARY KEY (`inBusqueda`),
  INDEX `fk_lb_busquedasusuarios_lb_usuarios1_idx` (`inBusUsuario` ASC),
  CONSTRAINT `fk_lb_busquedasusuarios_lb_usuarios1`
    FOREIGN KEY (`inBusUsuario`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Guarda todas las busquedas realizadas por los usuarios';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_megusta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_megusta` (
  `inIDMegusta` BIGINT NOT NULL COMMENT 'Id del me gusta',
  `inMegEjemplar` INT NOT NULL COMMENT 'Id del ejemplar',
  `inMegUsuario` INT NOT NULL COMMENT 'Id del usuario al que le gusta',
  `inMegMegusta` INT NOT NULL DEFAULT 1 COMMENT 'Si a una persona le gusta un ejemplar y luego apaga el me gusta, queda con el registro, en la tabla: 1: Me gusta 0 : Ya no me gusta',
  `feMegMegusta` DATETIME NOT NULL COMMENT 'Fecha en que indica que le gusta',
  INDEX `fk_table1_lb_ejemplares1_idx` (`inMegEjemplar` ASC),
  PRIMARY KEY (`inIDMegusta`),
  INDEX `fk_lb_megusta_lb_usuarios1_idx` (`inMegUsuario` ASC),
  CONSTRAINT `fk_table1_lb_ejemplares1`
    FOREIGN KEY (`inMegEjemplar`)
    REFERENCES `dotEx4read`.`lb_ejemplares` (`inEjemplar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_megusta_lb_usuarios1`
    FOREIGN KEY (`inMegUsuario`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_comentarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_comentarios` (
  `inIDComentario` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del comentario',
  `inComEjemplar` INT NOT NULL COMMENT 'Id del ejemplar',
  `inComUsuario` INT NOT NULL COMMENT 'Id del usuario',
  `txComComentario` LONGTEXT NOT NULL COMMENT 'Comentario',
  `feComFecComentario` DATETIME NOT NULL COMMENT 'Fecha del comentario',
  `inComActivo` INT NOT NULL DEFAULT 1 COMMENT 'Indica si el comentario esta activo o fue borrado : 1 Activo 0 : borrado-No mostrar',
  `inComComPadre` INT NULL COMMENT 'Id del comentario padre cuando se trata de una respuesta',
  INDEX `fk_lb_comentarios_lb_ejemplares1_idx` (`inComEjemplar` ASC),
  INDEX `fk_lb_comentarios_lb_usuarios1_idx` (`inComUsuario` ASC),
  PRIMARY KEY (`inIDComentario`),
  INDEX `fk_lb_comentarios_lb_comentarios1_idx` (`inComComPadre` ASC),
  CONSTRAINT `fk_lb_comentarios_lb_ejemplares1`
    FOREIGN KEY (`inComEjemplar`)
    REFERENCES `dotEx4read`.`lb_ejemplares` (`inEjemplar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_comentarios_lb_usuarios1`
    FOREIGN KEY (`inComUsuario`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_comentarios_lb_comentarios1`
    FOREIGN KEY (`inComComPadre`)
    REFERENCES `dotEx4read`.`lb_comentarios` (`inIDComentario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Comentarios de los usuarios sobre ejemplares';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_histejemplar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_histejemplar` (
  `inHistEjemplar` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del registro historico',
  `inHisEjeEjemplar` INT NOT NULL COMMENT 'Id del ejemplar',
  `feHisEjeRegistro` DATETIME NOT NULL COMMENT 'Fecha del movimiento de historia del ejemplar',
  `inHisEjeUsuario` INT NOT NULL COMMENT 'Usuario que realiza el movimiento',
  `inHisEjeMovimiento` INT NOT NULL DEFAULT 0 COMMENT 'Movimiento que realiza el usuario = 1: Publicacion del ejemplar 2: Bloqueo del ejemplar (Lo hace el sistema, el usr que queda es el que debe), 3: Solicita ejemplar, 4: Entrega ejemplar: Puntos, 5: Recibe ejemplar: Puntos, 6: Activa - Ofrece, 7: Inactiva, 8: Comenta, 9: Me gusta, 10: No me gusta, 11: Cambia estado (mejora o empeora de 1 a 10), 12: Mejora contenido: Idioma, ISBN, Autor etc., 13: Baja del sistema, 14: Vista del ejemplar (Consulta del detalle),15: Vendio ejemplar (trato cerrado), 16: Compro ejemplar(trato cerrado), 17: Acepta solicitud de ejemplar ',
  `inHisEjePadre` INT NULL COMMENT 'Permite encadenar transacciones de solicitud, compra, cambio, y entrega',
  `inHisEjeModoEntrega` INT NULL COMMENT '0: En el domicilio, 1: Encontrandose, 3. Courrier local, 4: Courrier Nacional, 5: Courrier internacional',
  INDEX `fk_table1_lb_ejemplares2_idx` (`inHisEjeEjemplar` ASC),
  PRIMARY KEY (`inHistEjemplar`),
  INDEX `fk_lb_histejemplar_lb_usuarios1_idx` (`inHisEjeUsuario` ASC),
  INDEX `fk_lb_histejemplar_lb_histejemplar1_idx` (`inHisEjePadre` ASC),
  CONSTRAINT `fk_table1_lb_ejemplares2`
    FOREIGN KEY (`inHisEjeEjemplar`)
    REFERENCES `dotEx4read`.`lb_ejemplares` (`inEjemplar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_histejemplar_lb_usuarios1`
    FOREIGN KEY (`inHisEjeUsuario`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_histejemplar_lb_histejemplar1`
    FOREIGN KEY (`inHisEjePadre`)
    REFERENCES `dotEx4read`.`lb_histejemplar` (`inHistEjemplar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Contiene la historia de las acciones que realian los usuarios sobre  los ejemplares';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_calificausuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_calificausuarios` (
  `inIDCalifica` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del registro de calificacion',
  `inCalUsuCalificado` INT NOT NULL COMMENT 'Usuario Calificado',
  `inCalUsuCalifica` INT NOT NULL COMMENT 'Usuario que califica',
  `inCalCalificacion` INT NOT NULL DEFAULT 1 COMMENT 'CAlificacion otorgada de 1 a 5',
  `txCalComentario` VARCHAR(500) NOT NULL DEFAULT 'Ninguno' COMMENT 'Comentario realizado justificando la calificacion',
  `feCalFecha` DATETIME NOT NULL COMMENT 'Fecha en que califica',
  `inCalHisEjemplar` INT NOT NULL COMMENT 'Historia del ejemplar, por el cual se realiza la calificacion',
  INDEX `fk_table1_lb_usuarios2_idx` (`inCalUsuCalificado` ASC),
  PRIMARY KEY (`inIDCalifica`),
  INDEX `fk_lb_calificausuarios_lb_usuarios3_idx` (`inCalUsuCalifica` ASC),
  INDEX `fk_lb_calificausuarios_lb_histejemplar1_idx` (`inCalHisEjemplar` ASC),
  CONSTRAINT `fk_table1_lb_usuarios2`
    FOREIGN KEY (`inCalUsuCalificado`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_calificausuarios_lb_usuarios3`
    FOREIGN KEY (`inCalUsuCalifica`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_calificausuarios_lb_histejemplar1`
    FOREIGN KEY (`inCalHisEjemplar`)
    REFERENCES `dotEx4read`.`lb_histejemplar` (`inHistEjemplar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Contiene las calificaciones que se realian por motivo de tratos realizados';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_puntosusuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_puntosusuario` (
  `inIDPuUs` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del registro de puntos',
  `inPuUsUsuario` INT NOT NULL COMMENT 'Usuario que obtiene o pierde los puntos',
  `inPuUsCantPuntos` INT NOT NULL DEFAULT 0 COMMENT 'Cantidad de puntos otorgados: Positivo o negativo, diferente de cero ',
  `inPuUsHisEje` INT NULL COMMENT 'Motivo de perdida o ganancia de puntos, es opcional',
  `txPuUsMotivo` VARCHAR(250) NOT NULL COMMENT 'Detalle del motivo de los puntos Sujeto a una transaccion',
  `fePuUsFechaPuntos` DATETIME NOT NULL COMMENT 'Fecha de movimiento de puntos',
  INDEX `fk_lb_puntosusuario_lb_usuarios1_idx` (`inPuUsUsuario` ASC),
  PRIMARY KEY (`inIDPuUs`),
  INDEX `fk_lb_puntosusuario_lb_histejemplar1_idx` (`inPuUsHisEje` ASC),
  CONSTRAINT `fk_lb_puntosusuario_lb_usuarios1`
    FOREIGN KEY (`inPuUsUsuario`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_puntosusuario_lb_histejemplar1`
    FOREIGN KEY (`inPuUsHisEje`)
    REFERENCES `dotEx4read`.`lb_histejemplar` (`inHistEjemplar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_negociacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_negociacion` (
  `inIDNegociacion` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del chat de negociacion',
  `inNegEjemplar` INT NOT NULL COMMENT 'Ejemplar que se esta negociando',
  `inNegUsuDuenho` INT NOT NULL COMMENT 'Usuario duenho del ejemplar',
  `inNegUsuSolicita` INT NOT NULL COMMENT 'Usuario que esta solicitando el ejemplar',
  `inNegUsuEscribe` INT NOT NULL COMMENT 'Usuario que escribe el mensaje',
  `txNegMensaje` TEXT(1000) NOT NULL COMMENT 'Texto del mensaje',
  `inNegMensLeido` INT NOT NULL DEFAULT 0 COMMENT 'Leido: 1, No leido : 0',
  `feNegFechaMens` DATETIME NOT NULL COMMENT 'Fecha y hora del mensaje',
  `inNegMensEliminado` INT NULL DEFAULT 0 COMMENT 'Eliminado por remitente : 1, Eliminado por receptor : 2, No eliminado : 0',
  PRIMARY KEY (`inIDNegociacion`),
  INDEX `fk_lb_negociacion_lb_ejemplares1_idx` (`inNegEjemplar` ASC),
  INDEX `fk_lb_negociacion_lb_usuarios1_idx` (`inNegUsuDuenho` ASC),
  INDEX `fk_lb_negociacion_lb_usuarios2_idx` (`inNegUsuSolicita` ASC),
  INDEX `fk_lb_negociacion_lb_usuarios3_idx` (`inNegUsuEscribe` ASC),
  CONSTRAINT `fk_lb_negociacion_lb_ejemplares1`
    FOREIGN KEY (`inNegEjemplar`)
    REFERENCES `dotEx4read`.`lb_ejemplares` (`inEjemplar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_negociacion_lb_usuarios1`
    FOREIGN KEY (`inNegUsuDuenho`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_negociacion_lb_usuarios2`
    FOREIGN KEY (`inNegUsuSolicita`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lb_negociacion_lb_usuarios3`
    FOREIGN KEY (`inNegUsuEscribe`)
    REFERENCES `dotEx4read`.`lb_usuarios` (`inUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Mantiene el chat de negociacion de un ejemplar ';

-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_autores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_autores` (
  `inIdAutor` INT NOT NULL AUTO_INCREMENT COMMENT 'Id del autor',
  `txAutNombre` VARCHAR(100) NOT NULL COMMENT 'Nombre del autor',
  `txAutPais` VARCHAR(100) NULL COMMENT 'Nacionalidad del autor - se cambiara luego por un id',
  PRIMARY KEY (`inIdAutor`))
ENGINE = InnoDB
COMMENT = 'Lista de autores';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_editoriales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_editoriales` (
  `inIdEditorial` INT NOT NULL AUTO_INCREMENT COMMENT 'Id de la editorial',
  `txEdiNombre` VARCHAR(100) NOT NULL COMMENT 'Nombre de la editorial',
  `txEdiPais` VARCHAR(100) NULL COMMENT 'Pais de la editorial-se cambiara luego por un ID ',
  PRIMARY KEY (`inIdEditorial`))
ENGINE = InnoDB
COMMENT = 'Lista de las editoriales';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_editorialeslibros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_editorialeslibros` (
  `inEdiLId` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave de la tabla',
  `inEdiLibLibro` INT NOT NULL COMMENT 'Id del libro',
  `inEdiLibroEditorial` INT NOT NULL COMMENT 'Id de la editorial',
  INDEX `fk_table1_lb_libros_idx` (`inEdiLibLibro` ASC),
  INDEX `fk_table1_lb_editoriales1_idx` (`inEdiLibroEditorial` ASC),
  PRIMARY KEY (`inEdiLId`),
  CONSTRAINT `fk_table1_lb_libros`
    FOREIGN KEY (`inEdiLibLibro`)
    REFERENCES `dotEx4read`.`lb_libros` (`inLibro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_lb_editoriales1`
    FOREIGN KEY (`inEdiLibroEditorial`)
    REFERENCES `dotEx4read`.`lb_editoriales` (`inIdEditorial`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Asociacion de editoriales Vs Libros';


-- Table `dotEx4read`.`lb_autoreslibros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_autoreslibros` (
  `inIdAutL` INT NOT NULL AUTO_INCREMENT COMMENT 'Lllave de la tabla',
  `inAutLIdAutor` INT NOT NULL COMMENT 'Id del autor',
  `inAutLIdLibro` INT NOT NULL COMMENT 'Id del libro',
  INDEX `fk_table2_lb_autores1_idx` (`inAutLIdAutor` ASC),
  INDEX `fk_table2_lb_libros1_idx` (`inAutLIdLibro` ASC),
  PRIMARY KEY (`inIdAutL`),
  CONSTRAINT `fk_table2_lb_autores1`
    FOREIGN KEY (`inAutLIdAutor`)
    REFERENCES `dotEx4read`.`lb_autores` (`inIdAutor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table2_lb_libros1`
    FOREIGN KEY (`inAutLIdLibro`)
    REFERENCES `dotEx4read`.`lb_libros` (`inLibro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Asociación de autores vs libros ';


-- -----------------------------------------------------
-- Table `dotEx4read`.`lb_preciosplanes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dotEx4read`.`lb_preciosplanes` (
  `inIdPrePId` INT NOT NULL AUTO_INCREMENT COMMENT 'Id de la tabla',
  `inIdPrePIdPlan` INT NOT NULL COMMENT 'Id del precio plan',
  `dbPrePPrecioplanMes` DECIMAL NOT NULL COMMENT 'Precio del plan si se paga por mes',
  `dbPrePPrecioplanAnio` DECIMAL NOT NULL COMMENT 'Precio del plan si se paga por año',
  `fePrePInicioVigencia` DATETIME NOT NULL COMMENT 'Inicio de la vigencia del plan',
  `fePrePFinVigencia` DATETIME NOT NULL COMMENT 'Fin de la vigencia del plan',
  INDEX `fk_lb_preciosplanes_lb_planes1_idx` (`inIdPrePIdPlan` ASC),
  PRIMARY KEY (`inIdPrePId`),
  CONSTRAINT `fk_lb_preciosplanes_lb_planes1`
    FOREIGN KEY (`inIdPrePIdPlan`)
    REFERENCES `dotEx4read`.`lb_planes` (`inPlan`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Precios de todos los planes';

--CREAR EN TODOS AMBIENTES

ALTER TABLE `dotex4read`.`lb_negociacion` 
ADD COLUMN `txNegIdConversacion` VARCHAR(50) NOT NULL AFTER `inNegMensEliminado`;


ALTER TABLE `dotex4read`.`lb_negociacion` 
ADD INDEX `fk_lb_negociacion_idconversacion_idx` (`txNegIdConversacion` ASC);

ALTER TABLE `dotex4read`.`lb_negociacion` 
ADD INDEX `fk_lb_negociacion_idconversacion2_idx` (`txNegIdConversacion` DESC);


ALTER TABLE `dotex4read`.`lb_ejemplares` 
ADD COLUMN `inEjeEstadoNegocio` INT(11) NOT NULL DEFAULT 0 COMMENT 'Estado de la negocuación actual : 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega\n5 - Entregado, 6 - Recibido' AFTER `inEjeSoloventa`,
ADD COLUMN `inEjeRegHisBloqueo` INT(11) NOT NULL DEFAULT 0 COMMENT 'Si está bloqueado, aquí se registra el ID de HisEjemplar de bloqueo vigente' AFTER `inEjeEstadoNegocio`,
ADD COLUMN `inEjeRegHisPublicacion` INT(11) NOT NULL DEFAULT 0 COMMENT 'Si esta / No publicado Publicado, aquí se registra el ID de HisEjemplar de publicacion / Despublicacion vigente' AFTER `inEjeRegHisBloqueo`,
ADD COLUMN `inEjeRegHisBajaSis` INT(11) NOT NULL DEFAULT 0 COMMENT 'Si se dió de baja, aquí se registra el ID de HisEjemplar de Baja del sistema' AFTER `inEjeRegHisPublicacion`,
ADD COLUMN `inEjeRegHisAprobDueno` INT(11) NOT NULL DEFAULT 0 COMMENT 'Si el dueno aprobó un negocio, aquí se registra el ID de HisEjemplar de Aprobacion' AFTER `inEjeRegHisBajaSis`,
ADD COLUMN `inEjeRegHisAprobSolic` INT(11) NOT NULL DEFAULT 0 COMMENT 'Si el solicitante aprobó un negocio, aquí se registra el ID de HisEjemplar de Aprobacion' AFTER `inEjeRegHisAprobDueno`,
ADD COLUMN `inEjeRegHisEntrega` INT(11) NOT NULL DEFAULT 0 COMMENT 'Si el dueno Entrego un ejemplar, aquí se registra el ID de HisEjemplar de Entrega' AFTER `inEjeRegHisAprobSolic`,
ADD COLUMN `inEjeRegHisRecibido` INT(11) NOT NULL DEFAULT 0 COMMENT 'Si el solicitante Recibio un ejemplar, aquí se registra el ID de HisEjemplar de Recibo' AFTER `inEjeRegHisEntrega`;
