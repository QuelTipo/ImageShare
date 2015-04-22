use imageshare;
delimiter //

-- This retrieves the specific album given the id primary key */

create procedure album_getByPk(in i_id int)
begin
    select * from album where ID = i_id;
end//

-- This retrieves all the information associated with an album
-- given an id primary key.

create procedure album_getInfoByPk(in i_id int)
begin
    select 	a.title, a.private, a.group_id,
		ug.group_name,
		a.username
    from album a
    join user_group ug
	 on a.group_id = ug.ID;
end//

-- This retrieves all the images in an album given
--   a certain id primary key. It does so by returning
--   the title, filename, and privacy flag of the images
--   and processes this on the page after the information
--   has been retrieved.


create procedure album_getImagesByPk(in i_id int)
begin
    select m.*
    from album_of_media as a,media as m
    where a.albID = i_id and
          m.ID = a.mediaID;
end//


create procedure album_getPhotosNotAdded(in i_username varchar(10),
                                         in i_albumid int)
begin
    select m.ID,m.title from media as m
    where m.owner_name=i_username and
        m.ID not in 
        (select mediaID from album_of_media
         where albID = i_albumid);
          
end//


create procedure album_getUsersPhotosAdded(in i_username varchar(10),
                                           in i_albumid int)
begin
    select m.ID,m.title from media as m
    where m.owner_name=i_username and
        m.ID in 
        (select mediaID from album_of_media
         where albID = i_albumid);
end//


-- This deletes an album. Clearly you're going to want to check if it belongs
-- to the entity doing the deleting first by using users_isUsersAlbum
-- (or groups_isGroupsAlbum).

create procedure album_deleteAlbum(in i_album_id int)
begin
    delete from album where ID=i_album_id;
end//

-- This switches the privacy level on a given album. Given that
--   privacy is binary, we just change the value to its opposite.
--   Naturally, check to see if the album belongs to the party
--   doing the changing first.

create procedure album_switchPrivacy(in i_album_id int)
begin
    declare temp bool default false;
    select private into temp
    from album where i_album_id=ID;
    if temp=false then
       update album set private=true where i_album_id=ID;
    else
        update album set private=false where i_album_id_ID;
    end if;
end//

delimiter ;