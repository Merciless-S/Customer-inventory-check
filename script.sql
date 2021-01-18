

 create database covid;
 use covid;
DROP TABLE IF EXISTS CUSAPP;
DROP TABLE IF EXISTS CUSENV;
DROP TABLE IF EXISTS APP;
DROP TABLE IF EXISTS HARDWARE;
 DROP TABLE IF EXISTS CUSTOMER;
 CREATE TABLE CUSTOMER
 (cusID INT,
 cusName varChar(100),
 contactName varChar(100),
 contactNo varChar(100),
 primary key (cusID)
 );
 
 
 CREATE TABLE HARDWARE
 (
 machineID varchar(100),
 manufacturer varchar(100),
 model varchar(100),
 vendor varchar(100),
 EOL varchar(100),
 primary key (machineID)
 );
 
 
 CREATE TABLE APP
 (
 appID varchar(100),
 appName varchar(100),
 Rel varchar(100),
 EOL DATE,
 primary key (appID)
 );
 
 
 CREATE TABLE CUSENV
 (
 cusID int,
 sysNo int,
 machineID varchar(100),
 purDate DATE,
 Support DATE,
 OS varchar(100),
 Web varchar(100),
 Java varchar(100),
 PHP varchar(100),
 primary key (cusID, sysNO),
 constraint FOREIGN KEY (cusID) references CUSTOMER(cusID),
constraint FOREIGN KEY (machineID) references HARDWARE(machineID)
 );
 

 CREATE TABLE CUSAPP
 (
cusID int,
appID varchar(100),
purDate DATE,
Support DATE,
primary key (cusID, appID),
constraint FOREIGN KEY (cusID) references CUSTOMER(cusID),
constraint FOREIGN KEY (appID) references APP(appID)
);

insert into CUSTOMER VALUES (11001, "Clairs", "James Smith", "2123546000");
insert into CUSTOMER VALUES (11002, "SterBucks", "Jenny Will", "5134445000");
insert into HARDWARE VALUES ("m0001", "HP", "DL380", "NewTech", DATE '2025-10-30');
insert into HARDWARE VALUES ("m0002", "SUN", "NS2", "ServerDepot", DATE '2027-01-01');
insert into APP VALUES ("a000120", "SalesManager", "2.0", NULL);
insert into APP values ("a000121", "SalesManager", "2.1", NULL);
insert into APP values ("a000211", "Primo", "11.0", DATE '2023-06-30');
INSERT INTO CUSENV VALUES (11001,1,"m0001", DATE '2017-01-31', DATE '2022-12-21', 'Centos8', "Tomacat 7", "8", "5.5");
INSERT INTO CUSENV VALUES (11001,2,"m0001", DATE '2018-03-21', DATE '2023-12-21', 'Centos8', "Tomacat 7", "8", "7.1");
INSERT INTO CUSENV VALUES (11002,1,"m0002", DATE '2017-09-30', NULL, 'Redhat6.2', "Apache2.4.2", "7", NULL);
INSERT INTO CUSAPP VALUES (11001, 'a000120', DATE '2019-06-01', DATE '2021-06-01');
INSERT INTO CUSAPP VALUES (11001, 'a000211', DATE '2019-10-31', DATE '2021-10-31');
INSERT INTO CUSAPP VALUES (11002, 'a000120', DATE '2018-04-15', NULL);
SELECT * FROM customer;
SELECT * FROM CUSAPP;
SELECT * FROM CUSENV;
SELECT * FROM APP;
SELECT * FROM hardware;
