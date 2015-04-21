use imageshare;
delimiter //

--
--    This procedure retrieves the entry for a piece of media when provided
--    with the primary key.

create procedure media_getByPk(in i_id int)
begin
    select * from media where ID = i_id;
end//

-- This procedure is used to add a comment to a piece of a media.

create procedure media_addComment(in i_media_id int, in i_number int, in i_username varchar(10), in i_tText text)
begin
    insert into comments (mediaID, comment_number, username, tText) values (i_media_id, i_number, i_username, i_tText);
end//

-- Here we retrieve all of the info of piece of media when provided the
--  primary key

create procedure media_getInfoByPk(in i_id int)
begin
	select 	m.title, m.height, m.width, m.filename, m.description, m.flag, m.private,
			c.model, c.manufacturer,
			l.longitude, l.latitude, l.description, 
			u.username
	from media m
	inner join camera c
		on m.cam_model = c.model and
		m.cam_man = c.manufacturer
	inner join location l
		on m.longitude = l.longitude and
		m.latitiude = l.latitude
	inner join users u
		on m.owner_name = u.username;
end//

call media_getByPk(1);

--
--    This allows us to retrieve the text description of a location
--    when provided the longitude and latitude.

create procedure media_getLocationDescription(in i_longitude decimal,
					      in i_latitude decimal)
begin
    select description from location where longitude=i_longitude and										   latitude=i_latitude;
end//

-- Here we retrieve the comments associated with a piece of media.

create procedure media_getCommentsByPk(in i_id int)
begin
	select c.comment_number, c.username, c.tText
	from comments c
	where mediaId = i_id;
end//

-- This procedure allows us to add a new piece of media to the database.
--   Note that when it comes to the camera, we check beforehand to see if the
--   camera belongs to the user, and if it doesn't, we add it then.

create procedure media_addNew(	in i_title varchar(30),
								in i_height int,
								in i_width int,
								in i_filename varchar(40),
								in i_description varchar(100),
								in i_private bool,
								in i_cam_model varchar(20),
								in i_cam_man varchar(20),
								in i_longitude decimal,
								in i_latitude decimal,
								in i_owner_name varchar(10),
								in i_flag int,
								in i_extraparam1 varchar(20),
								in i_extraparam2 varchar(20))
begin
	insert into media 
	(title,
	height,
	width,
	filename,
	description,
	private,
	cam_model,
	cam_man,
	longitude,
	latitude,
	owner_name,
    private,
	flag,
	extraparam1,
	extraparam2)
	values
	(i_title,
	i_height,
	i_width,
	i_filename,
	i_description,
	i_private,
	i_cam_model,
	i_cam_man,
	i_longitude,
	i_latitude,
	i_owner_name,
	i_flag,
	i_extraparam1,
	i_extraparam2);

end//

-- This deletes a piece of media from the media relation. Naturally you're
--   going to want to check to see if the one doing the deletion owns the piece
--   of piece of media in question first.

create procedure media_deleteMedia(in i_ID int)
begin
    delete from media where ID=i_ID;
end//

-- This allows the owner of a piece of media to switch the privacy level
--   on it. Thus, it is necessary to check to see if the piece of media belongs
--   to the person doing the changing first!

create procedure media_switchPrivacy(in i_media_id int)
begin
    declare temp bool default false;
    select private into temp
    from media where i_media_id=ID;
    if temp=false then
        update media set private=true where i_media_id=ID;
    else
        update media set private=false where i_media_id_ID;
    end if;
end//

-- Since we do a lot of privilege checking, we need a quick way
--   to retrieve whether or not a given piece of media has been marked
--   private.

create procedure media_isPrivate(in i_media_id int, out is_private bool)
begin
    select private into is_private
    from media where ID=i_media_id;
end//

-- This is to retrieve a list of media based on a given location.
--   Note that it is up to the site afterwards to determine whether
--   or not every member of this list is viewable by the person viewing
--   it.

create procedure media_getMediaFromLocation(in i_longitude decimal,
                                            in i_latitude decimal)
begin
    select ID from media
    where longitude=i_longitude and
          latitude=i_latitude;
end//

-- This is to retrieve a list of media based on a given camera.
--   Note that it is up to the site afterwards to determine whether
--   or not every member of this list is viewable by the person hoping
--   to view it.

create procedure media_getMediaByCamera(in i_cam_model varchar(20),
                                        in i_cam_man varchar(20))
begin
    select ID from media
    where i_cam_model = cam_model and
          i_cam_man = cam_man;
end//

delimiter ;
