drop table supervisors;
drop table children;
drop table alreadylogged;


create table supervisors (
id number(36,2) primary key,
email varchar2(150),
username varchar2(100),
password varchar2(20),
location varchar2(50)
);

create table children (
id number(36,2) primary key,
supervisorID number(36,2),
username varchar2(100),
password varchar2(100),
location varchar2(50)
);


create table alreadyLogged (
id number(36,2) primary key,
userid number(38),
seriesIdentifier varchar2(300) not null,
token raw(300) not null
);



drop sequence supervisorID;
create sequence supervisorID minvalue 0 increment by 1;

drop sequence childID;
create sequence childID minvalue 0 increment by 1;


drop sequence loginID;
create sequence loginID minvalue 0 increment by 1;



create or replace procedure rememberLogin(v_seriesIdentifier in varchar2, v_token in varchar2,v_id in number) is
v_raw raw(300);
v_aux number;
begin
begin
select id into v_aux from alreadylogged where userid = v_id and rownum<=1;
exception when no_data_found then
v_raw :=UTL_RAW.CAST_TO_RAW(v_token);
v_raw := dbms_crypto.Hash(src => v_raw, typ => DBMS_CRYPTO.HASH_SH1);
insert into alreadylogged (id,userid,seriesidentifier,token) values (loginid.nextval,v_id,v_seriesidentifier,v_raw);
return;
end;
delete from alreadylogged where userid = v_id;
v_raw :=UTL_RAW.CAST_TO_RAW(v_token);
v_raw := dbms_crypto.Hash(src => v_raw, typ => DBMS_CRYPTO.HASH_SH1);
insert into alreadylogged (id,userid,seriesidentifier,token) values (loginid.nextval,v_id,v_seriesidentifier,v_raw);
return;
end;

create or replace procedure isLoginValid(v_seriesIdentifier in varchar2, v_token in varchar2,v_response out varchar2) is
v_raw raw(300);
v_id number;
begin
begin
v_raw :=UTL_RAW.CAST_TO_RAW(v_token);
v_raw := dbms_crypto.Hash(src => v_raw, typ => DBMS_CRYPTO.HASH_SH1);
select id into v_id from ALREADYLOGGED where v_seriesIdentifier= SERIESIDENTIFIER;
exception when no_data_found then 
  v_response := '-1';
  return;
end;
begin
select id into v_id from ALREADYLOGGED where v_seriesIdentifier = SERIESIDENTIFIER and v_raw = token;
exception when no_data_found then 
  v_response := '-2';
  return;
end;
v_response :='1';
return;
end;



create or replace procedure LogIn(v_username in varchar2 , v_password in varchar2, v_id out number) is
begin
select id into v_id from SUPERVISORS where v_username = username and v_password = password;
exception when no_data_found then
  v_id :=-1;
  return;
return;
end;

delete from supervisors where id =0;

insert into supervisors(id,email,username,password,location) values (supervisorid.NEXTVAL,'dummy','dummy','dummy','0.000,0.000');

insert into children(id,supervisorid,username,password,location) values (childid.NEXTVAL,1,'dummy_child','dummy','0.000,0.000');

commit;
