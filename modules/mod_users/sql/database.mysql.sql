CREATE TABLE IF NOT EXISTS users (
    user_id       			INTEGER  NOT NULL       PRIMARY KEY AUTO_INCREMENT,
    first_name    			VARCHAR( 100 ),
    last_name     			VARCHAR( 100 ),
    username      			varchar(128),
    pwd           			varchar(512),
    email         			varchar(128),
    status        			varchar(32),
    role_id       			INTEGER         NOT NULL,
    store_id				INTEGER,
    last_modification_date	DATETIME,
    creation_date 			DATETIME
);
CREATE TABLE IF NOT EXISTS user_meta (
    meta_id       INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id       INTEGER,
    meta_key      varchar(128),
    meta_value    TEXT,
    creation_date datetime
);

CREATE TABLE IF NOT EXISTS user_roles (
    role_id                	INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    role_name              	varchar(128),
    role_description       	TEXT,
    role_key				varchar(128),
    last_modification_date 	datetime,
    creation_date          	datetime
);
CREATE TABLE IF NOT EXISTS role2permission (
    id            INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    role_id       INTEGER NOT NULL,
    permission_id INTEGER NOT NULL,
    creation_date datetime
);
CREATE TABLE IF NOT EXISTS permissions (
    permission_id          INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `group`					varchar(128) default 'unknow',
    permission             varchar(256),
    attributes             TEXT,
    label                  VARCHAR( 100 ),
    last_modification_date datetime,
    creation_date          datetime
);
