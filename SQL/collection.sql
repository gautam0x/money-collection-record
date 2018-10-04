/* Admin table to store main administator login password*/
CREATE TABLE admin
(
	username VARCHAR(20) PRIMARY KEY,
	password VARCHAR(40) NOT NULL
);

/* Non-Admin table to store local user login password*/
CREATE TABLE staff
(
	username VARCHAR(20) PRIMARY KEY,
	password VARCHAR(40) NOT NULL
);

/* Table to record clients data */
CREATE TABLE peoples
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(25) NOT NULL ,
	information VARCHAR(35) NOT NULL ,
	account_type VARCHAR(25) NOT NULL ,
	join_date DATE NOT NULL ,
	last_update DATE NOT NULL ,
	loan_amount DECIMAL NOT NULL,
	total_balance DECIMAL NOT NULL
);