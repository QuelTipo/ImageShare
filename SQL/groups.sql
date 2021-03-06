use imageshare;
delimiter //

-- This creates a new group with the person who created it as the admin. */
drop procedure groups_newGroup//
create procedure groups_newGroup(in i_username_1 varchar(10), in i_group_name varchar(10))
begin
	declare nextNum int;
    
	insert into user_group(group_name,admin) values (i_group_name,i_username_1);
	
	SELECT `AUTO_INCREMENT`
	FROM  INFORMATION_SCHEMA.TABLES
	WHERE TABLE_SCHEMA = 'imageshare'
	AND   TABLE_NAME   = 'user_group'
	into nextNum;

	select nextNum - 1 as id;
end//

-- This gets all the albums viewable by the person
--   viewing the group page

create procedure groups_getByPk(in i_id int)
begin
    select * from user_group where i_id=ID;
end//

create procedure groups_getAlbums(in i_id int, private bool)
begin
    if private then
        select * from album where group_id=i_id;
    else
        select * from album where group_id=i_id and private=false;
    end if;
end//

-- This retrieves all the members of the groups */

create procedure groups_getMembers(in i_id int)
begin
    select u.username, u.displayname from
	group_members gm
	inner join users u
		on gm.userID = u.username
	where groupID=i_id;
end//

-- Rather than incorporating verification into all of the
--   adminly duties, let's just create a procedure that will
--   return whether or not the person on the page can do them

create procedure groups_isAdmin(in i_username_1 varchar(10), 
				in group_id int, 
				out i_admin bool)
begin
    declare temp int default 0;
    
    select count(*) into temp
    from user_group where group_id=ID and i_username_1=admin;
    if temp=1 then
        set i_admin = true;
    else
        set i_admin = false;
    end if;
end//

-- We do the same with group members as we do with admins.*/

delimiter //
create procedure groups_isMember(in i_username_1 varchar(10),
				 in group_id int)
begin
    declare temp int default 0;
    select count(*) into temp
    from group_members where group_id=groupID and i_username_1=userID;
    if temp=1 then
        select 1 as result;
    else
        select 0 as result;
    end if;
end//


-- This checks to see if a particular album belongs to a group.

create procedure groups_isGroupsAlbum(in i_groupid int, in i_albumid int, out owns bool)
begin
    declare temp int default 0;
    select count(*) into temp
    from album where group_id = i_groupid and ID = i_albumid;
    if temp=1 then
        set owns = true;
    else
        set owns = false;
    end if;
end//

-- This allows a group to create an album.

create procedure groups_createAlbum(in i_title varchar(10), 
				    in i_private bool,
				    in i_group_id int)
begin
    insert into album(title,private,group_id)
    values (i_title,i_private,i_group_id);
end//

-- This procedure will be invoked by the admin to add the
--   prospective group member into the group

delimiter //

drop procedure groups_addMember;

create procedure groups_addMember(in i_username_1 varchar(10), in i_ID int)
begin
    insert into group_members (groupID,userID) values (i_ID,i_username_1);
end//

-- This procedure will be invoked by the admin to remove a group
--   member from the group

create procedure groups_removeMember(in i_username varchar(10), in i_ID int)
begin
    delete from group_members where groupID=i_ID and
				    userID=i_username;
end//

delimiter //

create procedure groups_getMedia(in i_id int, in i_private boolean)
begin
	select m.*
	from media m
	inner join album_of_media am
		on am.mediaID = m.id
	inner join album a
		on a.id = am.albID
	where a.group_id=i_id and a.private=i_private;
end//

delimiter ;
