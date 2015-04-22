use imageshare;

delimiter //

drop procedure location_getAll//

create procedure location_getAll()
begin
	select * from location;
end//

delimiter ;