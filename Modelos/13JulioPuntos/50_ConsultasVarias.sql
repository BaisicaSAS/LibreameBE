
##Libros que no están cargados como ejemplares (Puede ser que no tengan propietario)
select * from lb_libros where inLibro not in (select inEjeLibro from lb_ejemplares where lb_histejemplar);

##Libros que no tienen editorial
select * from lb_libros where inLibro not in (select inEdiLibLibro from lb_editorialeslibros);

##Libros que no tienen autor
select * from lb_libros where inLibro not in (select inAutLIdLibro from lb_autoreslibros);

##Libros que no tienen genero
select * from lb_libros where inLibro not in (select inGLiLibro from lb_generoslibros);

##Libros que no tienen propietario
select * from lb_libros where inLibro in (select inEjeLibro from lb_ejemplares where inEjeUsuDueno IS NULL);

##Libros con más de un ejemplar
select inEjeLibro, count(1) from lb_ejemplares
group by inEjeLibro having count(1) > 1;

select count(1) from lb_generoslibros;

select count(1) from lb_libros;



select * from lbejemplares