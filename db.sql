create table users(
	userid int(8) zerofill auto_increment not null,
	username varchar(32),
	password varchar(256),
	fname varchar(32),
	lname varchar(32),
	email varchar(50), 
	phone varchar(32), 
	role int(1), 
	primary key (userid)
);

create table boats(
	boatid int(8) zerofill auto_increment not null,
	customer int(8),
	make TINYTEXT,
	model TINYTEXT,
	year int(4),
	color varchar(32),
	vin varchar(32), 
	engine_size varchar(10),
	primary key (boatid)
);

create table motors(
	motorid int(8) zerofill auto_increment not null,
	customer int(8),
	make TINYTEXT,
	model TINYTEXT, 
	year int(4), 
	vin varchar(32),
	modelno varchar(32),
	primary key (motorid)
);

create table trailers(
	trailerid int(8) zerofill auto_increment not null,
	customer int(8),
	make TINYTEXT,
	model TINYTEXT,
	year int(4),
	vin varchar(32),
	primary key (trailerid)
);

create table services(
	serviceid int(8) zerofill auto_increment not null,
	customer int(8),
	employee int(8),
	boatid int(8),
	engine1 int(8),
	engine2 int(8),
	engine3 int(8),
	trailerid int(8),
	status int(1),
	hours decimal(5,2),
	recieved date,
	estimated date,
	completed date,
	primary key (serviceid)
);

create table partitems(
	partnumber int(8) zerofill auto_increment not null,
	partname TINYTEXT,
	partcost decimal(7,2),
	primary key (partnumber)
);

create table ticketlines(
	ticketid int(8),
	itemtype int(1),
	partnumber int(8),
	comments TINYTEXT
);