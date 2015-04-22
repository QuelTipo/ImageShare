CREATE DATABASE imageshare;


USE imageshare;

/* An easy way to nerf the tables without dropping the database
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `USERS`;
DROP TABLE IF EXISTS `CAMERA`;
DROP TABLE IF EXISTS `ALBUM`;
DROP TABLE IF EXISTS `ALBUM_OF_MEDIA`;
DROP TABLE IF EXISTS `CAMERAS_OWNED`;
DROP TABLE IF EXISTS `COMMENTS`;
DROP TABLE IF EXISTS `FRIENDS`;
DROP TABLE IF EXISTS `GROUP_MEMBERS`;
DROP TABLE IF EXISTS `LOCATION`;
DROP TABLE IF EXISTS `MEDIA`;
DROP TABLE IF EXISTS `USER_GROUP`;
SET FOREIGN_KEY_CHECKS = 1;
*/

/* nerf all the stored procedures too 
DELETE FROM mysql.proc;
*/
-- DROP TABLE IF EXISTS `USERS`;
CREATE TABLE USERS (
	username varchar(10) primary key,
	displayname varchar(20),
	pass varchar(20) not null,
    statement text
);

-- DROP TABLE IF EXISTS `CAMERA`;
CREATE TABLE CAMERA (
	model varchar(20),
	manufacturer varchar(20),
	primary key(model, manufacturer)
);

-- DROP TABLE IF EXISTS `USER_GROUP`;
CREATE TABLE USER_GROUP (
	ID int primary key auto_increment,
	group_name varchar(20),
	admin varchar(10),
	foreign key(admin) references USERS(username)
);

-- DROP TABLE IF EXISTS `ALBUM`;
CREATE TABLE ALBUM (
	ID int primary key auto_increment,
	title varchar(10),
	private bool,
	group_id int,
	owner_name varchar(10),
	foreign key(group_id) references USER_GROUP(ID)
		on delete cascade,
	foreign key(owner_name) references USERS(username)
);

-- DROP TABLE IF EXISTS `LOCATION`;
CREATE TABLE LOCATION (
	longitude decimal,
	latitude decimal,
	description varchar(40),
	primary key(longitude,latitude),
	index(longitude),
	index(latitude)
);

-- DROP TABLE IF EXISTS `MEDIA`;
CREATE TABLE MEDIA (
	ID int primary key auto_increment,
	title varchar(30),
	height int,
	width int,
	filename varchar(40),
	description varchar(100),
	private bool,
	cam_model varchar(20),
	cam_man varchar(20),
	longitude decimal,
	latitude decimal,
	owner_name varchar(10),
    upload_date timestamp,	
    flag int,
   	extraparam1 varchar(20),
	extraparam2 varchar(20),
	foreign key(cam_model,cam_man) references CAMERA(model,manufacturer),
	foreign key(latitude,longitude) references LOCATION(latitude,longitude),
	foreign key(owner_name) references USERS(username)
		
);

-- DROP TABLE IF EXISTS `CAMERAS_OWNED`;
CREATE TABLE CAMERAS_OWNED(
	username varchar(10),
	cam_model varchar(20),
	cam_man varchar(20),
	foreign key(cam_model,cam_man) references CAMERA(model,manufacturer),
	foreign key(username) references USERS(username),
	primary key(username,cam_model,cam_man)
);

-- DROP TABLE IF EXISTS `FRIENDS`;
CREATE TABLE FRIENDS(
	username1 varchar(10),
	username2 varchar(10),
	foreign key(username1) references USERS(username),
	foreign key(username2) references USERS(username),
	primary key(username1,username2)
);

-- DROP TABLE IF EXISTS `GROUP_MEMBERS`;
CREATE TABLE GROUP_MEMBERS(
	groupID int,
	userID varchar(10),
	foreign key(userID) references USERS(username),
	foreign key(groupId) references USER_GROUP(ID)
		on delete cascade,
	primary key(groupID,userID)
);

-- DROP TABLE IF EXISTS `COMMENTS`;
CREATE TABLE COMMENTS(
	mediaID int,
	comment_number int,
	username varchar(10) null,
	tText text,
    comment_date timestamp,
	foreign key(username) references USERS(username),
	foreign key(mediaID) references MEDIA(ID)
		on delete cascade,
	primary key(mediaID,comment_number)
);

CREATE TABLE ALBUM_OF_MEDIA(
	albID int,
    mediaID int,
    foreign key(albID) references ALBUM(ID)
		on delete cascade,
    foreign key(mediaID) references MEDIA(ID)
		on delete cascade,
    primary key(albID,mediaID)
);
