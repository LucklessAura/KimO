drop table supervisors;
drop table children;
drop table alreadylogged;


create table supervisors (
id number(36,2) primary key,
email varchar2(150),
username varchar2(100),
password varchar2(20),
location varchar2(50),
lastUpdate timestamp
);

create table children (
id number(36,2) primary key,
supervisorID number(36,2),
username varchar2(100),
password varchar2(100),
location varchar2(50),
lastUpdate timestamp
);


create table alreadyLogged (
id number(36,2) primary key,
userid number(38),
seriesIdentifier varchar2(300) not null,
token raw(300) not null
);

create table PassResetTable(
id number(28,0),
code varchar(1000),
issued timestamp
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




create or replace procedure LogInChild(v_username in varchar2 , v_password in varchar2, v_id out number) is
begin
select id into v_id from children where v_username = username and v_password = password;
exception when no_data_found then
  v_id :=-1;
  return;
return;
end;



delete from supervisors where id =0;

insert into supervisors(id,email,username,password,location,lastupdate) values (supervisorid.NEXTVAL,'dummy','dummy','dummy','0.000,0.000',systimestamp);

insert into children(id,supervisorid,username,password,location,lastupdate) values (childid.NEXTVAL,1,'dummy_child','dummy','0.000,0.000',systimestamp);

insert into children(id,supervisorid,username,password,location,lastupdate) values (childid.NEXTVAL,1,'dummy_child2','dummy','1.000,1.000',systimestamp);

commit;



create or replace package apex_mail_p
is
 g_smtp_host varchar2 (256) := '127.0.0.1';
 g_smtp_port pls_integer := 25;
 g_smtp_domain varchar2 (256) := 'smtp.gmail.com';
 g_mailer_id constant varchar2 (256) := 'Mailer by Oracle UTL_SMTP';
 -- send mail using UTL_SMTP
 procedure mail (
 p_sender in varchar2
 , p_recipient in varchar2
 , p_subject in varchar2
 , p_message in varchar2
 );
end;
/
 
create or replace package body apex_mail_p
is
 -- Write a MIME header
 procedure write_mime_header (
 p_conn in out nocopy utl_smtp.connection
 , p_name in varchar2
 , p_value in varchar2
 )
 is
 begin
 utl_smtp.write_data ( p_conn
 , p_name || ': ' || p_value || utl_tcp.crlf
 );
 end;
 procedure mail (
 p_sender in varchar2
 , p_recipient in varchar2
 , p_subject in varchar2
 , p_message in varchar2
 )
 is
 l_conn utl_smtp.connection;
 nls_charset varchar2(255);
 p_to varchar2(250);
 j number:=null;
 p_recipient_store varchar2(4000);
 begin
 -- get characterset
 select value
 into nls_charset
 from nls_database_parameters
 where parameter = 'NLS_CHARACTERSET';
 -- establish connection and autheticate
 l_conn := utl_smtp.open_connection (g_smtp_host, g_smtp_port);
 utl_smtp.ehlo(l_conn, g_smtp_domain);
 utl_smtp.command(l_conn, 'auth login');
 utl_smtp.command(l_conn, UTL_RAW.CAST_TO_VARCHAR2(UTL_ENCODE.BASE64_ENCODE(UTL_RAW.CAST_TO_RAW('dbmsp030@gmail.com'))));
 utl_smtp.command(l_conn, UTL_RAW.CAST_TO_VARCHAR2(UTL_ENCODE.BASE64_ENCODE(UTL_RAW.CAST_TO_RAW('Project_13'))));
 -- set from/recipient
 utl_smtp.command(l_conn, 'MAIL FROM: <'||p_sender||'>');
 --loop through all reciepients and issue the RCPT TO command for each one
 p_recipient_store:=p_recipient;
 while nvl(length(p_recipient_store),0)>0
 loop
 select decode(instr(p_recipient_store, ','),
 0,
 length(p_recipient_store) + 1,
 instr(p_recipient_store, ','))
 into j
 from dual;
 p_to:=substr(p_recipient_store,1,j-1);
 utl_smtp.command(l_conn, 'RCPT TO: <'||p_to||'>');
 p_recipient_store:=substr(p_recipient_store,j+1);
 end loop;
 -- write mime headers
 utl_smtp.open_data (l_conn);
 write_mime_header (l_conn, 'From', p_sender);
 write_mime_header (l_conn, 'To', p_recipient);
 write_mime_header (l_conn, 'Subject', p_subject);
 write_mime_header (l_conn, 'Content-Type', 'text/plain');
 write_mime_header (l_conn, 'X-Mailer', g_mailer_id);
 utl_smtp.write_data (l_conn, utl_tcp.crlf);
 -- write message body
 utl_smtp.write_data (l_conn, p_message);
 utl_smtp.close_data (l_conn);
 -- end connection
 utl_smtp.quit (l_conn);
 exception
 when others
 then
 begin
 utl_smtp.quit(l_conn);
 exception
 when others then
 null;
 end;
 raise_application_error(-20000,'Failed to send mail due to the following error: ' || sqlerrm);
 end;
end;
/


create or replace procedure register(usernm in varchar2, emailus in varchar2,value out int) is
v_pass varchar2(10);
v_id number(38,0);
begin
v_pass := dbms_random.string('X', 10);
begin
  select id into v_id from supervisors where username = usernm;
  EXCEPTION WHEN no_data_found THEN
          begin
            select id into v_id from supervisors where email = emailus ;
            EXCEPTION WHEN no_data_found THEN
                    insert into supervisors (id,username,password,email,location) values (supervisorid.nextval,usernm,v_pass,emailus,'0.000,0.000');
                      apex_mail_p.mail('Oracleappsnotes', emailus, 'Thank you for registering', usernm 
                      || ' thank you for choosing us
                      '  ||'<br> Your password is: ' || v_pass || '<br> Please change it as fast as possible');
                    value:=0;
                    return;
            end;
            value:=1;
            return;
  end;
value:=2;
return;
end;



create or replace procedure issuerestcode(emailaddr in varchar2 , value out int,link in varchar2) is
v_code varchar2(1000);
v_id number(38,0);
v_username varchar2(70);
begin
begin
select id into v_id from supervisors where EMAIL = emailaddr;
exception when no_data_found then
  value :=1;
  return;
end;
select username into v_username from supervisors where id = v_id; 
v_code := to_char(v_id) || ' '|| v_username || ' ' || emailaddr || ' ' || TO_CHAR(systimestamp);
v_code := utl_encode.text_encode(v_code,'AL32UTF8',UTL_ENCODE.BASE64);
v_code := replace(replace(v_code,chr(10)),chr(13));
insert into passresettable (id,code,issued) values (passreset_seq.nextval,v_code,systimestamp);
  apex_mail_p.mail('Oracleappsnotes', emailaddr, 'Password Reset', v_username 
                      || ' you have issued a password reset link, please follow this link '  || link || '/changePass.php' || '?' ||'code=' || v_code || '<br> The link will be avariable for the next 24 hours'  || '<br> If you did not ask for this please ignore the email');
value :=0;
return;
end;


create sequence passreset_seq start with 1;

create or replace procedure IsCodeValid(v_code in varchar2,value out int) is
v_id number(38,0);
begin
begin
select id into v_id from passresettable where trim(v_code)=trim(code);
exception when no_data_found then
  value:=0;
  return;
end;
value:=1;
return ;
end;


create or replace procedure resettablemanage is
cursor issuedtime is select issued from passresettable order by ISSUED asc;
var_iss timestamp;
v_diff int;
begin
open issuedtime;
loop
  fetch issuedtime into var_iss;
  exit when issuedtime%notfound;
  select  extract(day from diff) days into v_diff from (select systimestamp - var_iss diff from dual);
  if v_diff >=1 then
    delete from passresettable where issued = var_iss;
  else
    return;
  end if;
end loop;
end;



BEGIN
   DBMS_NETWORK_ACL_ADMIN.DROP_ACL(
      acl => 'send_mail.xml');

  DBMS_NETWORK_ACL_ADMIN.create_acl (
    acl          => 'send_mail.xml',
    description  => 'Purpose of the acl is to send mail',
    principal    => 'STUDENT',
    is_grant     => TRUE,
    privilege    => 'connect',
    start_date   => SYSTIMESTAMP,
    end_date     => NULL);

   DBMS_NETWORK_ACL_ADMIN.assign_acl (
    acl         => 'send_mail.xml',
    host        => '127.0.0.1',
    lower_port  => 25,
    upper_port  => 25);

  COMMIT;
END;
/



begin
apex_mail_p.mail('Oracleappsnotes', 'rerin@rockmail.top', 'Thank you for registering',  
                     ' thank you for choosing us
                      '  ||'<br> Your password is: '  || '<br> Please change it as fast as possible');
end;