/* The 'misc' database was created as part of another programming assignment. */
/* This database already has two tables, 'users' and 'Profile'. */
USE misc;

/* Additional table required for this assignment: */
CREATE TABLE Position (
    position_id INTEGER NOT NULL AUTO_INCREMENT,
    profile_id INTEGER,
    rank INTEGER,
    year INTEGER,
    description TEXT,
    PRIMARY KEY(position_id),
    CONSTRAINT position_ibfk_1
        FOREIGN KEY (profile_id)
        REFERENCES Profile (profile_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
