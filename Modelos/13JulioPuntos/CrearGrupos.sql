SELECT * FROM dotex4read.lb_grupos;

delete FROM dotex4read.lb_grupos where ingrupo > 0;
alter table dotEx4read.lb_grupos auto_increment=1;
commit;
commit;commit;
commit;commit;
commit;commit;
commit;

insert into dotEx4read.lb_grupos (ingrunombre, fegrufecha, ingrucantmiem) values ('GRUPO GENERAL EX4READ', '2016-07-13 00:00:00', 0);