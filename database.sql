create table users(
	username varchar(32),
	pwd varchar(256),
	role int(1),
	userid int(8) zerofill
);

create table customers(
	fname varchar(32),
	lanme varchar(32),
	email varchar(50),
	phone varchar(20),
	userid int(8) zerofill
);

create table employees(
	fname varchar(32),
	lname varchar(32),
	userid int(8) zerofill,
	role1 int(1),
	role2 int(1),
	role3 int(1)
);

create table boats(
	customer int(8) zerofill,
	idno int(8) zerofill,
	make TINYTEXT,
	model TINYTEXT,
	year int(4),
	color varchar(32),
	vin varchar(20),
	engine_size varchar(10),
	trailerno varchar(32),
	trailersize varchar(10)
);

create table trailers (
	vin varchar(20), 
	idno int(8) zerofill,
	customer int(8) zerofill,
	make tinytext, 
	model tinytext,
	year int(4)
);

create table motors(
	customer int(8) zerofill,
	idno int(8) zerofill,
	make tinytext,
	model tinytext,
	year int(4),
	vin varchar(20),
	modelno varchar(32)
);

create table services(
	customer int(8) zerofill, 
	employee int(8) zerofill,
	ticketno int(8) zerofill, 
	boatno int(8) zerofill, 
	engine1 int(8) zerofill,
	engine2 int(8) zerofill,
	engine3 int(8) zerofill, 
	trailerno int(8) zerofill,
	status int(1),
	labor int,
	servicetype int, 
	recieved date,
	estimated date,
	completed date
);

create table ticketitems(
	ticketno int(8) zerofill,
	itemno int(8) zerofill, 
	comments tinytext, 
	itemtype int(1)
);

create table parts(
	partno int(8) zerofill,
	partname tinytext, 
	partcost decimal(7,2)
);

create table serviceitem(
	itemno int(8) zerofill, 
	itemname tinytext, 
	itemextras tinytext
);