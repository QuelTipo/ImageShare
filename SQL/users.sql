use imageshare;
delimiter //
   
-- This checks to see if a username has already been
--    taken by someone else in the system.
--

create procedure users_usernameTaken(in i_username varchar(10))
begin
    declare temp int default 0;
    select count(*) into temp
    from users where username=i_username;
    if temp=0 then
	select 0 as result;
    else
	select 1 as result;
    end if;
end//

create procedure users_login(in i_username varchar(10),
                             in i_pass varchar(20))
begin
    select * from users where i_username=username
                        and i_pass=pass;
end//

--
--   To enter a new user in the system once they've selected their username,
--   displayname, and password
--


create procedure users_enterUser(in i_username varchar(10),
				 in i_displayname varchar(20),
				 in i_pass varchar(20),
                                 in i_statement text)
begin
    insert into users (username,displayname,pass,statement) 
    values (i_username,i_displayname,i_pass,i_statement);
end//



--
--    This procedure is for retrieving the ids of media owned by the user
--    for display based on whether or not the person viewing the user page
--    is the person's friend or not. It's up to the PHP code to choose
--    which pictures will be on display and how many of them.
--    
--    Note that for this to work, a person will need to be friends with
--    themselves in the system if they want to see their own files! Perhaps
--    this can be revised so we can avoid this. For now when retrieving a list
--    of friends, it'll be best to remove a person from the list of their results
--    when retrieving their friends.

create procedure users_getMediaID(in i_username varchar(10), in friend bool)
begin
    if friend then
        select ID from media where owner_name = i_username;
    else
        select ID from media where owner_name = i_username and
        private = false;
    end if;
end//

create procedure users_getDisplayName(in i_username varchar(10))
begin
    select displayname from users where i_username=username;
end//


create procedure users_getStatement(in i_username varchar(10))
begin
    select statement from users where i_username=username;
end//

--
--   This is to retrieve the filename of a given piece of media based on the ID
--   so we can retrieve the file and create a thumbnail for it.

create procedure users_getMediaFilename(in i_id int)
begin
	select filename from media where ID = i_id;
end//

--
--	This is used to add a new friend into the system. 
--

create procedure users_addNewFriend(in i_username_1 varchar(10), 
				    in i_username_2 varchar(10))
begin
	insert into friends(username1,username2)
    values(i_username_1,i_username_2);
end//

--
--    This checks to see if a friendship exists in the system. It checks for one
--    direction of the relationship first, then the other. If we get two records
--    returned, then the two folks are friends.

create procedure users_areFriends(in i_username_1 varchar(10),
				  in i_username_2 varchar(10))
begin
    declare total int default 0;
    declare temp int default 0;
    select count(*) into temp from friends 
    where i_username_1=username1 and
          i_username_2=username2;
    set total:=total+temp;
    select count(*) into temp from friends 
    where i_username_1=username2 and
          i_username_2=username1;
    set total:=total+temp;
    if total=2 then
        select 1 as result;
    else
        select 0 as result;
    end if;
end//

create procedure users_getFriends(in i_username varchar(10))
begin
    select username2 from friends
    where username1=i_username and
          username2<>i_username;
end//

-- 
--	This returns the list of groups the member is involved in.
--

create procedure users_getGroups(in i_username_1 varchar(10))

begin
    select groupID from group_members where userID = i_username_1;
end//

-- 
--    This returns the list of albums the user has based on whether
--    or not the person viewing the page is a friend or not. The same
--    considerations that applied to retrieving media on a user page
--    apply here.

create procedure users_getAlbums(in i_username_1 varchar(10), in friend bool)
begin
    if friend then
        select ID from album where i_username_1=owner_name;
    else
        select ID from album where i_username_1=owner_name and
                                   private=false;
    end if;
end//

--
--    This gets the cameras that the user owns, be it for listing the
--    cameras or creating a list form the user can select from when
--    entering the camera data for a piece of media.

create procedure users_getCameras(in i_username_1 varchar(10))
begin
    select cam_model,cam_man from cameras_owned where username=i_username_1;
end//

--
--   This procedure returns whether or not a given camera belongs to a specific
--   user. This procedure is important for when a user enters their camera info
--   when adding a new piece of media. If the camera isn't listed as owned by
--   the user, then we definitely want to add it using the following procedure.

create procedure users_isCameraOwned(in i_username varchar(10),
				     in i_cam_model varchar(20),
				     in i_cam_man varchar(20))
begin
    declare temp int default 0;
    select count(*) into temp
    from cameras_owned where i_username=username and
			     i_cam_model=cam_model and
                             i_cam_man=cam_man;
    if count=1 then
        select 1 as result;
    else
        select 0 as result;
    end if;
end//

-- 
--   This procedure is for inserting a new entry in the cameras_owned
--   table. It is of course necessary to check if the camera already
--   exists in the cameras table first. If not, then it will be created.

create procedure users_insertCamerasOwned(in i_username_1 varchar(10),
                                          in i_cam_model varchar(20),
                                          in i_cam_man varchar(20))
begin
    declare count_camera int default 0;
    select count(*) into count_camera
    from camera where model=i_cam_model and manufacturer=i_cam_man;
    
    if count_camera = 0 then
        insert into camera (model,manfuacturer) values (i_cam_model,i_cam_man);
    end if;

    insert into cameras_owned(username,cam_model,cam_man) 
    values (i_username_1,i_cam_model,i_cam_man);
end//

--
--    This allows creates an album for the user when requested
--

create procedure users_createAlbum(in i_username_1 varchar(10),
                                   in i_title varchar(10),
                                   in private bool)
begin
    insert into album(title,private,owner_name) values (i_title,private,i_username_1);
end//



--
--   This is used to assert whether or not a piece of media belongs
--   to somebody before changes can be made to it. Useful also
--   for when a user wants to remove a piece of media from the album
--   of a group it is has placed it in.

create procedure users_isUsersMedia(in i_media_id int, 
				    in i_username varchar(10))
begin
    declare temp int default 0;
    select count(*) into temp from media
    where i_media_id=ID and
          i_username=owner_name;
    if count=1 then
        select 1 as result;
    else
	select 0 as result;
    end if;
end//

--
--    This asserts whether or not an album belongs to a particular user
--

create procedure users_isUsersAlbum(in i_album_id int,
				    in i_username varchar(10))
begin
    declare temp int default 0;
    select count(*) into temp from media
    where i_album_id=ID and
          i_username=owner_name;
    if count=1 then
        select 1 as result;
    else
        select 0 as result;
    end if;
end//

--
--   This is called when a user desires adding a piece of media to an album.
--   it does so by adding a new entry to the album_of_media relation.

create procedure users_addMediatoAlbum(in i_media_id int,
                                       in i_album_id int)
begin
    insert into album_of_media(albID, mediaID) values (i_album_id,i_media_id);
end//

--
--    This procedure is used to determine whether a given piece of media
--    is viewable by a given user if the media is marked private.

create procedure users_canViewMedia(in i_media_id int,
                                    in i_username varchar(10))
begin
    declare user_name varchar(10);
    select owner_name into user_name from media
    where ID=i_media_id;
    call users_areFriends(i_username,user_name);
end//

-- 
--   This allows a user to delete a piece of media from an album
--   by removing it from the album_of_media relation.
    
create procedure users_deleteMediaFromAlbum(in i_media_id int,
                                            in i_album_id int)
begin
    delete from album_of_media where albID=i_album_id and
                                     mediaID = i_media_id;
end//

delimiter ;