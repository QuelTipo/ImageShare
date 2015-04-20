INSERT INTO users
    (username,displayname,pass,statement)
VALUES
    ('catlover','Tim Gusterson','meowmeow',
    'I love chicken, I love liver, Meow Mix Meow Mix
     please deliver!'),
    ('catlover87','John Windley','hisshiss',
     'I think cats are pretty cool!'),
    ('meanguy','Up Yours','screwyou',
     'Cats are so dumb and people who like them are
      even dumber. Man you are all so dumb.'),
    ('katniss','Katniss Everdeen','mockingjay',
     'If this were the Hunger Games I would totally win
      because I am so righteous and everyone loves me. Especially
      Olive Loaf... I mean... Peeta.'),
    ('mario45','Mario Mario','yahooo',
     'Its-a-me, Mario!'),
    ('luigi1964','Luigi Mario','whaa',
     'Its Weegee time!'),
    ('justpeachy','Princess Peach','toad',
     'Come on over, Mario for some cake! Not
      you, Luigi...'),
    ('deutsch','Hans Brinkle','wurst',
     'Sprechen Sie Deutsch?!'),
    ('luffy','Monkey D. Luffy','pirate',
     'Im gonna be the pirate king!'),
    ('dragon','Kiryu Kazuma','rgg05',
     'Got a death wish? Then step the hell up, its time
      to die!'),
    ('ketchum92','Ash Ketchum','pikachu',
     'Gotta snap em all!');

INSERT INTO camera
    (model,manufacturer)
VALUES
    ('iPhone 6', 'Apple'),
    ('iPhone 5', 'Apple'),
    ('CyberShot H400', 'Sony'),
    ('Powershot 52', 'Canon'),
    ('Galaxy S2', 'Samsung'),
    ('Z2300', 'Polaroid'),
    ('Pokemon Camera', 'Tiger'),
    ('Disposable', 'Fuji'),
    ('Hero3', 'GoPro'),
    ('D3300', 'Nikon');

INSERT INTO user_group
    (group_name,admin)
VALUES
    ('Mushroom Kingdom','mario45'),
    ('Cat Lovers','catlover'),
    ('Tough Guys','dragon'),
    ('Cat Lovers','ketchum92');

INSERT INTO album
    (title,private,group_id)
VALUES
    ('Karting',false,1),
    ('Cats',false,2),
    ('Toughness',false,3),
    ('Chilling',true,3),
    ('Meow Meow',false,4),
    ('Kitties?',true,4);

INSERT INTO album
    (title,private,owner_name)
VALUES
    ('Pokemans',false,'ketchum92'),
    ('Fighting',false,'dragon'),
    ('Party!',true,'deutsch'),
    ('My cats',true,'catlover87');

INSERT INTO group_members
    (groupID,userID)
VALUES
    (1,'mario45'),
    (1,'luigi1964'),
    (1,'justpeachy'),
    (2,'catlover'),
    (2,'catlover87'),
    (2,'dragon'),
    (3,'dragon'),
    (3,'luffy'),
    (3,'katniss'),
    (4,'ketchum92'),
    (4,'catlover'),
    (4,'justpeachy');

INSERT INTO cameras_owned
    (username,cam_model,cam_man)
VALUES
    ('catlover','D3300','Nikon'),
    ('catlover','Galaxy S2','Samsung'),
    ('catlover87','Z2300','Polaroid'),
    ('catlover87','Disposable','Fuji'),
    ('deutsch','Powershot 52','Canon'),
    ('dragon','iPhone 6','Apple'),
    ('dragon','Hero3','GoPro'),
    ('justpeachy','iPhone 5','Apple'),
    ('katniss','CyberShot H400','Sony'),
    ('ketchum92','Pokemon Camera','Tiger'),
    ('luffy','Disposable','Fuji'),
    ('luigi1964','Galaxy S2','Samsung'),
    ('mario45','iPhone 6','Apple'),
    ('meanguy','Z2300','Polaroid');

INSERT INTO location
    (latitude,longitude,description)
VALUES
    (35.6833,139.6833,'Tokyo'),
    (64.1333,21.9333,'Mushroom Kingdom Kart Track'),
    (65.0,18.0,'Mushroom Kingdom'),
    (36.0000,86.0000,'Knoxville,Tennessee'),
    (54.7681,101.8642,'Flin Flon, Manitoba'),
    (51.0486,114.0708,'Calgary,Alberta'),
    (48.1333,11.5667,'Munich,Germany'),
    (52.5167,13.3833,'Berlin,Germany'),
    (32.2989,90.1847,'Jackson,Mississippi'),
    (34.4,135.2,'Johto Region');

INSERT INTO media
    (title,height,width,filename,description,private,cam_model,
     cam_man,latitude,longitude,owner_name,upload_date,flag,extraparam1)
VALUES
    ('Unimpressed Cat',475,632,'cat1.jpg','An unimpressed cat.',
     false,'D3300','Nikon',36.0000,86.0000,'catlover',CURDATE(),0,'JPEG'),
    ('Stallion',349,512,'cat2.jpg','This cat is suave.',false,
     'D3300','Nikon',36.0000,86.0000,'catlover',CURDATE(),0,'JPEG'),
    ('Kitty Love',475,632,'cat3.jpg','Cats in love!',false,
     'Galaxy S2','Samsung',36.0000,86.0000,'catlover',CURDATE(),0,'JPEG'),
    ('Drunk Cat',475,632,'cat4.jpg','This cat got way too crunk.',false,
     'D3300','Nikon',36.0000,86.0000,'catlover',CURDATE(),0,'JPEG'),
    ('Billy',536,536,'cat5.jpg','Poor cross-eyed kitty!',true,
     'Galaxy S2','Samsung',54.7681,101.8642,'catlover',CURDATE(),0,'JPEG'),
    ('Regal',475,632,'cat1.jpg','This cat is king!',false,
     'Disposable','Fuji',54.7681,101.8642,'catlover87',CURDATE(),0,'JPEG'),
    ('CUTE!',475,632,'cat2.jpg','OMG WHAT A CUTIE!',false,
     'Z2300','Polaroid',54.6781,101.8642,'catlover87',CURDATE(),0,'JPEG'),
    ('Sweet Kittens',475,632,'cat3.jpg','These kittens actually hate each other',false,
     'Disposable','Fuji',32.2989,90.1847,'catlover87',CURDATE(),0,'JPEG'),
    ('Science Cat',400,400,'cat4.jpeg','This cat got his doctorate before I did.',false,
     'Z2300','Polaroid',32.2989,90.1847,'catlover87',CURDATE(),0,'JPEG'),
    ('Jerk!',450,600,'cat5.jpg','This cat really stinks',true,
     'Z2300','Polaroid',51.0486,114.0708,'catlover87',CURDATE(),0,'JPEG'),
    ('JA!',428,420,'germany1.jpg','Ich trinkt das bier!',false,
     'Powershot 52','Canon',48.1333,11.5667,'deutsch',CURDATE(),0,'JPEG'),
    ('JAA!',386,580,'germany2.jpg','Gesongen!',false,
     'Powershot 52','Canon',48.1333,11.5667,'deutsch',CURDATE(),0,'JPEG'),
    ('JAAA!',372,620,'germany3.jpg','Der Gertztrauminnerplatz',false,
     'Powershot 52','Canon',48.1333,11.5667,'deutsch',CURDATE(),0,'JPEG'),
    ('JAAAA!',372,496,'germany4.jpeg','Schnitzel!',false,
     'Powershot 52','Canon',52.5167,13.3833,'deutsch',CURDATE(),0,'JPEG'),
    ('JAAAAA!',331,624,'germany5.jpg','Mein freund!',true,
     'Powershot 52','Canon',52.5167,13.3833,'deutsch',CURDATE(),0,'JPEG'),
    ('Friday Night',455,809,'dragon1.jpg','Last Friday I fought a bunch of dudes',false,
     'iPhone 6','Apple',35.6833,139.6833,'dragon',CURDATE(),0,'JPEG'),
    ('Just Desserts',720,1280,'dragon2.jpg','This is what happens when you try to give me a ticket.',false,
     'iPhone 6','Apple',35.6833,139.6833,'dragon',CURDATE(),0,'JPEG'),
    ('Keep It Brief',960,1280,'dragon3.jpg','We had a brief conversation. Get it?',false,
     'iPhone 6','Apple',35.6833,139.6833,'dragon',CURDATE(),0,'JPEG'),
    ('Reaching Out',576,1024,'dragon4.jpg','Giving a helping hand',false,
     'iPhone 6','Apple',35.6833,139.6833,'dragon',CURDATE(),0,'JPEG'),
    ('Smoooooth!',563,1000,'dragon5.jpg','Sometimes I need pampering too',true,
     'iPhone 6','Apple',35.6833,139.6833,'dragon',CURDATE(),0,'JPEG'),
    ('Umbrella discipline',611,600,'peach1.jpg','I showed the umbrella who is boss!',false,
     'iPhone 5','Apple',65.0,18.0,'justpeachy',CURDATE(),0,'JPEG'),
    ('Me and Bae',360,500,'peach5.png','Who da hottest?',true,
     'iPhone 5','Apple',65.0,18.0,'justpeachy',CURDATE(),0,'PNG'),
    ('Skating',720,1280,'peach6.jpg','Not fun unless goombas get murdered...',false,
     'iPhone 5','Apple',65.0,18.0,'justpeachy',CURDATE(),0,'JPEG'),
    ('Selfie',412,500,'peachselfie.jpg','This princess excuses nobody!',false,
     'iPhone 5','Apple',65.0,18.0,'justpeachy',CURDATE(),0,'JPEG'),
    ('Glam Driving',460,776,'peach2.jpg','Keep it on fleek behind the wheel!',false,
     'iPhone 5','Apple',64.1333,21.9333,'justpeachy',CURDATE(),0,'JPEG'),
    ('Why am I a cat?',371,660,'peach3.png','This was a fantasy of Mario... what a perv!',false,
     'iPhone 5','Apple',64.1333,21.9333,'justpeachy',CURDATE(),0,'JPEG'),
    ('Me.',442,860,'katniss1.jpg','See title',false,
     'CyberShot H400','Sony',32.2989,90.1847,'katniss',CURDATE(),0,'JPEG'),
    ('Me again.',393,590,'katniss2.jpg','See title again',false,
     'CyberShot H400','Sony',32.2989,90.1847,'katniss',CURDATE(),0,'JPEG'),
    ('Me at karaoke.',576,864,'katniss3.jpg','See title at karaoke',false,
     'CyberShot H400','Sony',32.2989,90.1847,'katniss',CURDATE(),0,'JPEG'),
    ('Peeta.',450,500,'katniss4.jpg','Yup',false,
     'CyberShot H400','Sony',32.2989,90.1847,'katniss',CURDATE(),0,'JPEG'),
    ('Meee n da crew!!!1',720,1280,'ketchumselfie.jpg','Sup',false,
     'Pokemon Camera','Tiger',34.4,135.2,'ketchum92',CURDATE(),0,'JPEG'),  
    ('Meow wat',600,577,'ketchum1.png','Yo found dis sweet cat',false,
     'Pokemon Camera','Tiger',34.4,135.2,'ketchum92',CURDATE(),0,'PNG'),
    ('LOL WUT',612,612,'ketchum2.jpg','Dis cat is a poser',false,
     'Pokemon Camera','Tiger',34.4,135.2,'ketchum92',CURDATE(),0,'JPEG'),
    ('Dragonite',700,947,'ketchum3.jpg','Dis Dragonite wuz aight',false,
     'Pokemon Camera','Tiger',34.4,135.2,'ketchum92',CURDATE(),0,'JPEG'),
    ('Jigglytuff',406,500,'ketchum4.gif','Yo don mess with Jiggle or u wiggle',false,
     'Pokemon Camera','Tiger',34.4,135.2,'ketchum92',CURDATE(),0,'GIF'),
    ('Bounty',906,640,'luffy1.jpg','So little!',false,
     'Disposable','Fuji',48.1333,11.5667,'luffy',CURDATE(),0,'JPEG'),
    ('Straw Hats',480,640,'luffy2.png','My crew!',false,
     'Disposable','Fuji',51.0486,114.0708,'luffy',CURDATE(),0,'PNG'),
    ('Walk',600,800,'luffy3.jpg','Out for a stroll!',false,
     'Disposable','Fuji',54.7681,101.8642,'luffy',CURDATE(),0,'JPEG'),
    ('Ace',410,585,'luffy4.jpg','Me and bro (RIP)',true,
     'Disposable','Fuji',48.1333,11.5667,'luffy',CURDATE(),0,'JPEG'),
    ('Just me',306,306,'luigiselfie.jpg','Am I cool? I think so.',false,
     'Galaxy S2','Samsung',65.0,18.0,'luigi1964',CURDATE(),0,'JPEG'),
    ('Daisy',370,445,'daisy.png','The light of my life!',false,
     'Galaxy S2','Samsung',65.0,18.0,'luigi1964',CURDATE(),0,'PNG'), 
    ('Ghostbusting',349,620,'luigi3.jpg','You would be scared too!',false,
     'Galaxy S2','Samsung',65.0,18.0,'luigi1964',CURDATE(),0,'JPEG'),
    ('Karting',462,615,'luigi1.jpg','Sometime I get too into the race.',false,
     'Galaxy S2','Samsung',64.1333,21.9333,'luigi1964',CURDATE(),0,'JPEG'),
    ('See you later!',768,1024,'luigi2.jpg','Eat my dust, suckers!',false,
     'Galaxy S2','Samsung',64.1333,21.9333,'luigi1964',CURDATE(),0,'JPEG'),
    ('YAHOO!',480,854,'mario2.jpg','Its-a-me, Mario!',false,
     'iPhone 6','Apple',65.0,18.0,'mario45',CURDATE(),0,'JPEG'),
    ('YIPEE!',511,354,'mario4.png','Its-a-me, Dr. Mario!',false,
     'iPhone 6','Apple',65.0,18.0,'mario45',CURDATE(),0,'PNG'),
    ('WOAHOOO!',480,611,'mario5.png','Its-a-me, Mario! ... and some other guys',false,
     'iPhone 6','Apple',65.0,18.0,'mario45',CURDATE(),0,'PNG'),
    ('WOOOO!',486,864,'rosalina.jpg','This girl, she is-a so sexy!',true,
     'iPhone 6','Apple',65.0,18.0,'mario45',CURDATE(),0,'JPEG'),
    ('WEEEEE!',370,628,'mario1.jpg','Eat-a my dust paisanos!',false,
     'iPhone 6','Apple',64.1333,21.9333,'mario45',CURDATE(),0,'JPEG'),
    ('Me as a baby',275,275,'meanguy3.jpg','Get that bottle outta my face!',false,
     'Z2300','Polaroid',36.0000,86.0000,'meanguy',CURDATE(),0,'JPEG'),
    ('Me as a teen',400,600,'meanguy.jpg','I told you Id carve the turkey!!!',false,
     'Z2300','Polaroid',54.7681,101.8642,'meanguy',CURDATE(),0,'JPEG'),
    ('Me now',423,600,'meanguy2.jpg','I hate you!!!',false,
     'Z2300','Polaroid',36.0000,86.0000,'meanguy',CURDATE(),0,'JPEG');

INSERT INTO media
    (title,height,width,filename,description,private,cam_model,
     cam_man,latitude,longitude,owner_name,upload_date,flag,extraparam1,extraparam2)
VALUES
    ('Me Fighting',360,640,'dragon6.mp4','This is what happens!',false,
     'Hero3','GoPro',35.6833,139.6833,'dragon',CURDATE(),1,'3:52','MP4'),
    ('I Win Everywhere!',360,640,'katniss5.mp4','Yes I do!',false,
     'CyberShot H400','Sony',32.2989,90.1847,'katniss',CURDATE(),1,'2:19','MP4');

INSERT INTO friends
    (username1,username2)
VALUES
    ('catlover','catlover87'),
    ('catlover87','catlover'),
    ('dragon','luffy'),
    ('luffy','dragon'),
    ('ketchum92','luffy'),
    ('luffy','ketchum92'),
    ('mario45','luigi1964'),
    ('luigi1964','mario45'),
    ('mario45','justpeachy'),
    ('justpeachy','mario45'),
    ('luigi1964','justpeachy'),
    ('justpeachy','luigi1964'),
    ('katniss','meanguy'),
    ('meanguy','katniss'),
    ('catlover','catlover'),
    ('catlover87','catlover87'),
    ('deutsch','deutsch'),
    ('dragon','dragon'),
    ('justpeachy','justpeachy'),
    ('katniss','katniss'),
    ('ketchum92','ketchum92'),
    ('luffy','luffy'),
    ('luigi1964','luigi1964'),
    ('mario45','mario45'),
    ('meanguy','meanguy');

INSERT INTO album_of_media
    (albID,mediaID)
VALUES
    (1,25),
    (1,26),
    (1,43),
    (1,44),
    (1,49),
    (2,1),
    (2,3),
    (2,5),
    (2,7),
    (3,17),
    (3,18),
    (3,27),
    (3,54),
    (3,39),
    (4,38),
    (4,20),
    (4,29),
    (5,3),
    (5,2),
    (5,1),
    (5,5),
    (5,32),
    (6,33),
    (6,26),
    (7,32),
    (7,34),
    (7,35),
    (8,17),
    (8,18),
    (8,19),
    (8,53),
    (9,11),
    (9,12),
    (9,13),
    (10,6),
    (10,7),
    (10,10);