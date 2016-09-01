
##Libros que no están cargados como ejemplares (Puede ser que no tengan propietario)
select * from lb_libros where inLibro not in 
(select inEjeLibro from lb_ejemplares);

##Libros que no tienen editorial
select * from lb_libros where inLibro not in (select inEdiLibLibro from lb_editorialeslibros);

##Libros que no tienen autor
select * from lb_libros where inLibro not in (select inAutLIdLibro from lb_autoreslibros);

##Libros que no tienen genero
select * from lb_libros where inLibro not in (select inGLiLibro from lb_generoslibros);

##Ejemplares que no tienen propietario
select inEjeLibro from lb_ejemplares where inEjeUsuDueno IS NULL;

##Libros que no tienen propietario
select * from lb_libros where inLibro in (select inEjeLibro from lb_ejemplares where inEjeUsuDueno IS NULL);


##Libros con más de un ejemplar
select inEjeLibro, count(1) from lb_ejemplares
group by inEjeLibro having count(1) > 1;

##Todos los ejemplares
select l.txLibtitulo, e.* from lb_ejemplares e, lb_libros l where e.inEjeLibro = l.inLibro and e.inEjemplar = 11;

##Libros con más de un ejemplar
##select txNomLibro
##group by inEjeLibro having count(1) > 1;


select count(1) from lb_generoslibros;

select count(1) from lb_libros;


select * from lb_autores where txautnombre like "%gabriel%" ;

Select * from lb_autoreslibros where inautlidautor = 184;

select * from lb_ejemplares where inejelibro in (Select inautlidlibro from lb_autoreslibros where inautlidautor = 184);


/**************************************************/
/*consulta para recuperar feed ejemplares
/**************************************************/


/* ESTA ES LA CONSULTA */
SELECT e.inEjemplar, l.txLibTitulo, e.*, u.*, count(mg.inidmegusta), count(c.inidcomentario), max(h.fehisejeregistro) fechapub  FROM Lb_Ejemplares e
LEFT JOIN lb_libros l ON e.inejelibro = l.inlibro 
LEFT JOIN lb_usuarios u ON e.inejeusudueno = u.inusuario
LEFT JOIN lb_membresias m ON e.inejeusudueno = m.inmemusuario
LEFT JOIN lb_megusta mg ON mg.inMegEjemplar = e.inejemplar 
LEFT JOIN lb_comentarios c ON c.inComEjemplar = e.inejemplar 
LEFT JOIN lb_histejemplar h ON h.inhisejeejemplar = e.inejemplar 
WHERE e.inejemplar > 0 and e.inejepublicado <= 1
and h.inHisEjeMovimiento = 1
group by  e.inEjemplar
order by fechapub


/***