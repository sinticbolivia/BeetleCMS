CREATE TABLE IF NOT EXISTS forms(
	form_id				integer		not null primary key autoincrement,
	title				varchar(128),
	description			text,
	subject				varchar(128),
	email				varchar(128),
	options				text,
	fields				text,
	html				text,
	template			text,
	form_file			varchar(256),
	message				text,
	status				varchar(64),
	creation_date		datetime
);
CREATE TABLE IF NOT EXISTS form_entries(
	id 					integer not null primary key autoincrement,
	form_id				integer not null,
	customer			varchar(128),
	email				varchar(128),
	subject				varchar(128),
	message				text,
	data				text,
	user_data			text,
	creation_date		datetime
);