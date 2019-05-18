-- Admin table to store main administator login password
CREATE TABLE admin
(
	username VARCHAR(20) PRIMARY KEY,
	password VARCHAR(40) NOT NULL
);

-- Dumping data for table `admin`
INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '827ccb0eea8a706c4c34a16891f84e7b');

-- Non-Admin table to store local user login password
CREATE TABLE staff
(
	username VARCHAR(20) PRIMARY KEY,
	password VARCHAR(40) NOT NULL
);

-- Dumping data for table `staff`
INSERT INTO `staff` (`username`, `password`) VALUES
('staff', '827ccb0eea8a706c4c34a16891f84e7b');

-- Table to record clients data
CREATE TABLE client_details
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

/*
Indivisual table for each client will be created 
on User action perform

+---------------+-----------------+
|  Date         |  Amount         |
+---------------+-----------------+
|               |                 |
+---------------------------------+

*/
