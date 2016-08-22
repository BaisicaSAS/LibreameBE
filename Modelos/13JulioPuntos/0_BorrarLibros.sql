

delete from dotex4read.lb_titulos where inIdTitulo > 0;
alter table dotEx4read.lb_titulos  auto_increment=1;

delete from dotex4read.lb_autoreslibros where inIdAutL > 0;
alter table dotEx4read.lb_autoreslibros  auto_increment=1;

delete from dotex4read.lb_editorialeslibros where inEdiLId > 0;
alter table dotEx4read.lb_editorialeslibros  auto_increment=1;

delete from dotex4read.lb_generoslibros where inGeneroLibro > 0;
alter table dotEx4read.lb_generoslibros  auto_increment=1;

delete from dotex4read.lb_puntosusuario where inIDPuUs > 0;
alter table dotEx4read.lb_puntosusuario  auto_increment=1;

delete from dotex4read.lb_histejemplar where inHistEjemplar > 0;
alter table dotEx4read.lb_histejemplar  auto_increment=1;

delete from dotex4read.lb_ejemplares where inEjemplar > 0;
alter table dotEx4read.lb_ejemplares  auto_increment=1;

delete from dotex4read.lb_libros where inLibro > 0;
alter table dotEx4read.lb_libros  auto_increment=1;

commit;
 
 