CREATE TABLE IF NOT EXISTS forms(
	form_id				bigint		not null auto_increment primary key,
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
	id 					bigint not null auto_increment primary key,
	form_id				bigint not null,
	customer			varchar(128),
	email				varchar(128),
	subject				varchar(128),
	message				text,
	data				text,
	user_data			text,
	creation_date		datetime
);