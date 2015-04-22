use imageshare;

delimiter //

create procedure location_getAll()
begin
	select * from location;
end//

delimiter ;