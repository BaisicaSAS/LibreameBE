SELECT count(1) FROM dotex4read.lb_indicepalabra;

delete FROM lb_indicepalabra where lbindpalid > 0;

alter table lb_indicepalabra auto_increment=1;

SELECT * FROM dotex4read.lb_indicepalabra;

SELECT * FROM dotex4read.lb_indicepalabra
where lbindpalpalabra like "%gabriel%";