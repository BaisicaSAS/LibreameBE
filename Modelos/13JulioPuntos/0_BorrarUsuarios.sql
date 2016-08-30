
delete FROM dotex4read.lb_actsesion where inactsesion > 0;
delete FROM dotex4read.lb_sesiones where insesion > 0;
delete FROM dotex4read.lb_dispusuarios where indispusuario > 0;
delete FROM dotex4read.lb_membresias where inmembresia > 0;
delete FROM dotex4read.lb_planesusuarios where inplanusuario > 0;
delete FROM dotex4read.lb_usuarios where inusuario > 0;

alter table dotEx4read.lb_actsesion  auto_increment=1;
alter table dotEx4read.lb_sesiones  auto_increment=1;
alter table dotEx4read.lb_dispusuarios  auto_increment=1;
alter table dotEx4read.lb_membresias  auto_increment=1;
alter table dotEx4read.lb_planesusuarios  auto_increment=1;
alter table dotEx4read.lb_usuarios  auto_increment=1;

SELECT * FROM dotex4read.lb_usuarios;
commit;

