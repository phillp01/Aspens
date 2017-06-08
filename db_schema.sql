USE aspens;
 
CREATE TABLE students (
        id INTEGER AUTO_INCREMENT,
	studentID INTEGER UNIQUE NOT NULL,
        name VARCHAR(50) NOT NULL,
	class CHAR(5) NOT NULL,
	details1 VARCHAR(100),
	details2 VARCHAR(100),
	details3 VARCHAR(100),
        PRIMARY KEY (id)
);

