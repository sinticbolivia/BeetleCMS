CREATE TABLE IF NOT EXISTS newsletter_list(
	id 				bigint not null auto_increment primary key,
	name			varchar(128),
	description		text,
	status			varchar(64) default 'active',
	creation_date	datetime
);
CREATE TABLE IF NOT EXISTS newsletter_customers(
	id				bigint not null auto_increment primary key,
	list_id			bigint not null default 0,
	firstname		varchar(128),
	lastname		varchar(128),
	email			varchar(128),
	source			varchar(64) default 'website',
	status			varchar(32) default 'enabled',
	creation_date	datetime
);
CREATE TABLE IF NOT EXISTS newsletter_queues(
	id				bigint not null auto_increment primary key,
	type			varchar(64),
	list_id			bigint not null,
	customer_id		bigint not null,
	status			varchar(64) default 'pending',
	data			text,
	creation_date	datetime,
	sent_date		datetime
);