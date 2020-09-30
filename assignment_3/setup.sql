/* The 'misc' database was created as part of another programming assignment. */
/* This database already has three tables, 'users', 'Profile' and 'Position'. */
USE misc;

/* Additional tables required for this assignment. */

/* 'Institution' table. */

CREATE TABLE Institution (
    institution_id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    PRIMARY KEY(institution_id),
    UNIQUE(name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Institution (name) VALUES ('Duke University');
INSERT INTO Institution (name) VALUES ('Michigan State University');
INSERT INTO Institution (name) VALUES ('Mississippi State University');
INSERT INTO Institution (name) VALUES ('Montana State University');
INSERT INTO Institution (name) VALUES ('Stanford University');
INSERT INTO Institution (name) VALUES ('University of Cambridge');
INSERT INTO Institution (name) VALUES ('University of Michigan');
INSERT INTO Institution (name) VALUES ('University of Oxford');
INSERT INTO Institution (name) VALUES ('University of Virginia');

/* 'Education' table. */

CREATE TABLE Education (
    profile_id INTEGER,
    institution_id INTEGER,
    rank INTEGER,
    year INTEGER,
    CONSTRAINT education_ibfk_1
        FOREIGN KEY (profile_id)
        REFERENCES Profile (profile_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT education_ibfk_2
        FOREIGN KEY (institution_id)
        REFERENCES Institution (institution_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(profile_id, institution_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
