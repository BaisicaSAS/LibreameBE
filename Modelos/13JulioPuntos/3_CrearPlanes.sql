## Crear Planes
## Crear Precios Planes

SELECT * FROM dotex4read.lb_planes;

delete FROM dotex4read.lb_planesusuarios where inUsuPlan > 0;
alter table dotEx4read.lb_planesusuarios auto_increment=1;
delete FROM dotex4read.lb_preciosplanes where inIdPrePIdPlan > 0;
alter table dotEx4read.lb_preciosplanes auto_increment=1;
delete FROM dotex4read.lb_planes where inPlan > 0;
alter table dotEx4read.lb_planes auto_increment=1;
commit;

INSERT INTO `dotex4read`.`lb_planes`(`inPlan`,`txPlanNombr`,`txPlanDescripcion`,`inPlanVigente`,`inPlanFree`,`inPlanDiasFree`,
`fePlanCreacion`,`fePlanIniVigencia`,`fePlanFinVigencia`)VALUES(1,'Básico','Plan freemium para las personas que están iniciando en el maravillosos mundo de la lectura',
1, 1, 0,'2016-01-01 00:00:00','2016-01-01 00:00:00','2046-01-01 00:00:00');

INSERT INTO `dotex4read`.`lb_preciosplanes`(`inIdPrePId`,`inIdPrePIdPlan`,`dbPrePPrecioplanMes`,`dbPrePPrecioplanAnio`,
`fePrePInicioVigencia`,`fePrePFinVigencia`)VALUES(1, 1, 0, 0, '2016-01-01 00:00:00','2046-01-01 00:00:00');


commit;commit;
commit;commit;
commit;commit;
commit;

##Se crean todos los planes