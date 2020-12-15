select count(*) as count, group_concat(cod_user separator ',') as users, cod_room
from user_room 
group by cod_room
having count like 2;


-- SALAS ABIERTAS PARA UN USUARIO
select ur.cod_room from user as u
join user_room as ur
on u.cod_user = ur.cod_user
where u.cod_user like 1
group by ur.cod_room;


-- Nombre de usuario sala 1vs1
select u.cod_user, nick, photo from user as u
join user_room as ur
on u.cod_user = ur.cod_user
where ur.cod_room like '1-18' and u.cod_user not like '1';

-- Usuario contrario para cada sala
select u.cod_user as codUser, nick, photo, count(*) as count, ur.cod_room as codRoom, img_room, max(date_message) as date_msg, typeOfRoom from user as u
	join user_room as ur
	on u.cod_user = ur.cod_user
    join room as r
    on r.cod_room = ur.cod_room
    join message as m
    on r.cod_room = m.cod_room
	where ur.cod_room in
	(select ur.cod_room from user as u
	join user_room as ur
	on u.cod_user = ur.cod_user
	where u.cod_user like 1
	group by ur.cod_room)
	and u.cod_user not like 1
	group by ur.cod_room
    order by date_msg desc;
    
    
-- Ver si la sala esta vista

select * from user_room
where cod_user like '1' and cod_room like '1-17';

select * from message
where cod_room like '1-4';

-- Mensaje de una sala de todos los usuarios
select u.cod_user as codUser, nick, photo, cod_room as codRoom, text_message, date_message from user as u
    join message as m
    on u.cod_user = m.cod_user
    where m.cod_room like '1-17'
    order by date_message;
    
    
    -- si son amigos dos usuarios 
    
    select nick, photo, cod_user, status from
    (select if(userA not like '3', userA, userB) as otherUser, min(status) as status from friend as f
    where userA like '3' or userB like '3'
    group by code) as inter
    join user as u
    on inter.otherUser = u.cod_user;
    
    select nick, photo, cod_user
    from user
    where rol not like 1;
    