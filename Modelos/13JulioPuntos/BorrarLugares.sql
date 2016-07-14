SELECT * FROM dotex4read.lb_lugares;

update dotex4read.lb_lugares set inlugpadre = NULL where inlugar>1;

delete FROM dotex4read.lb_lugares where inlugar>0;
alter table dotEx4read.lb_lugares  auto_increment=1;
commit;
commit;commit;
commit;commit;
commit;commit;
commit;