-- Execute the following create trigger command in blocks

create trigger tg_deploy_schedule_upd after update on Deploy_Schedule
for each row
begin
	if not new.start_date <=> old.start_date then
		insert into Deploy_Schedule_Audit(deploy_schedule_id, action, column_name, old_value, new_value, modified_date)
			values (old.id, 'update', 'start_date', old.start_date, new.start_date, sysdate());
	end if;
	if not new.end_date <=> old.end_date then
		insert into Deploy_Schedule_Audit(deploy_schedule_id, action, column_name, old_value, new_value, modified_date)
			values (old.id, 'update', 'end_date', old.end_date, new.end_date, sysdate());
	end if;
end;

create trigger tg_deploy_schedule_del after delete on Deploy_Schedule
for each row
begin
		insert into Deploy_Schedule_Audit(deploy_schedule_id, action, column_name, old_value, new_value, modified_date)
			values (old.id, 'delete', null, null, null, sysdate());
end;

create trigger tg_repair_schedule_upd after update on Repair_Schedule
for each row
begin
	if not new.start_date <=> old.start_date then
		insert into Repair_Schedule_Audit(repair_schedule_id, action, column_name, old_value, new_value, modified_date)
			values (old.id, 'update', 'start_date', old.start_date, new.start_date, sysdate());
	end if;
	if not new.end_date <=> old.end_date then
		insert into Repair_Schedule_Audit(repair_schedule_id, action, column_name, old_value, new_value, modified_date)
			values (old.id, 'update', 'end_date', old.end_date, new.end_date, sysdate());
	end if;
end;

create trigger tg_repair_schedule_del after delete on Repair_Schedule
for each row
begin
		insert into Repair_Schedule_Audit(repair_schedule_id, action, column_name, old_value, new_value, modified_date)
			values (old.id, 'delete', null, null, null, sysdate());
end;

create trigger tg_request_upd after update on Request
for each row
begin
	if not new.status <=> old.status then
		insert into Request_Audit(request_id, requesting_resource_id, incident_id, sender_username, action, column_name, old_value, new_value, modified_date)
			values (old.id, old.requesting_resource_id, old.incident_id, old.sender_username, 'update', 'status', old.status, new.status, sysdate());
	end if;
end;

create trigger tg_request_del after delete on Request
for each row
begin
insert into Request_Audit(request_id, requesting_resource_id, incident_id, sender_username, action, column_name, old_value, new_value, modified_date)
			values (old.id, old.requesting_resource_id, old.incident_id, old.sender_username, 'delete', null, null, null, sysdate());
end;


create trigger tg_resource_del after delete on Resource
for each row
begin
insert into Resource_Audit(resource_id, resource_name, owner_username, action, column_name, old_value, new_value, modified_date)
			values (old.id, old.name, old.owner_username, 'delete', null, null, null, sysdate());
end;

create trigger tg_resource_upd after update on Resource
for each row
begin
	if not new.primary_ESF_id <=> old.primary_ESF_id then
    insert into Resource_Audit(resource_id, resource_name, owner_username, action, column_name, old_value, new_value, modified_date)
          values (old.id, old.name, old.owner_username, 'update', 'primary_ESF_id', old.primary_ESF_id, new.primary_ESF_id, sysdate());
	end if;
	if not new.model <=> old.model then
    insert into Resource_Audit(resource_id, resource_name, owner_username, action, column_name, old_value, new_value, modified_date)
          values (old.id, old.name, old.owner_username, 'update', 'model', old.model, new.model, sysdate());
	end if;
  if not new.lon <=> old.lon then
    insert into Resource_Audit(resource_id, resource_name, owner_username, action, column_name, old_value, new_value, modified_date)
          values (old.id, old.name, old.owner_username, 'update', 'lon', old.lon, new.lon, sysdate());
	end if;
  if not new.lat <=> old.lat then
    insert into Resource_Audit(resource_id, resource_name, owner_username, action, column_name, old_value, new_value, modified_date)
          values (old.id, old.name, old.owner_username, 'update', 'lat', old.lat, new.lat, sysdate());
	end if;
  if not new.cost_dollar_amount <=> old.cost_dollar_amount then
    insert into Resource_Audit(resource_id, resource_name, owner_username, action, column_name, old_value, new_value, modified_date)
          values (old.id, old.name, old.owner_username, 'update', 'cost_dollar_amount', old.cost_dollar_amount, new.cost_dollar_amount, sysdate());
	end if;
  if not new.cost_denominator <=> old.cost_denominator then
    insert into Resource_Audit(resource_id, resource_name, owner_username, action, column_name, old_value, new_value, modified_date)
          values (old.id, old.name, old.owner_username, 'update', 'cost_denominator', old.cost_denominator, new.cost_denominator, sysdate());
	end if;
end;
