----------------
-- Modify the table structure of the database to match the new schema
----------------
-- Path: contrib/db/mysql-migrate-0.95-to-0.96.sql

-- MySQL dump 10.10

--  Add balance column to the userbillinfo table 
ALTER TABLE `userbillinfo` CHANGE `lastbill` `lastbill` DATE NULL DEFAULT NULL;
ALTER TABLE `userbillinfo` CHANGE `nextbill` `nextbill` DATE NULL DEFAULT NULL;
ALTER TABLE `userbillinfo` ADD `balance` decimal(10,2) NOT NULL DEFAULT '0.00';