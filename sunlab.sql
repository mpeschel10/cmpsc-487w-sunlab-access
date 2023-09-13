USE sweng;

DROP TABLE IF EXISTS access;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
    id VARCHAR(256),
    name VARCHAR(256),
    kind SET('STUDENT', 'ADMIN'),
    allowed BOOLEAN,
    CONSTRAINT PK_user PRIMARY KEY (id)
);

INSERT INTO user
    (     kind, allowed,                      id,              name)
VALUES
    ('STUDENT',       1,                    'jj',  'Japheth Beiler'),
    ('STUDENT',       1,             '972607187',    'Mark Peschel'),
    ('STUDENT',       0, ';9308057671208700000?',   'Tyler Lindsay'),
    (  'ADMIN',       1,          'AzureDiamond',    'Gabriel Marx')
;

CREATE TABLE access (
    id INT AUTO_INCREMENT,
    user_id VARCHAR(256),
    kind SET('ENTRY', 'EGRESS'),
    timestamp DATETIME,
    allowed BOOLEAN,
    CONSTRAINT PK_access PRIMARY KEY (id)
);

INSERT INTO access 
    (      id,   user_id,     kind,             timestamp, allowed)
VALUES
    (      -2,  'dino dan',  'ENTRY', ' 400-02-19T08:00:00',        0),
    (      -1,     't-rex',  'ENTRY', ' 800-08-22T15:00:00',        0),
    (       1,   'mimmoth',  'ENTRY', '1890-09-04T03:00:00',        0),
    (       2,    'edsger',  'ENTRY', '2023-09-03T17:00:00',        1),
    (       3,    'edsger', 'EGRESS', '2023-09-03T19:00:00',        1),
    (       4,    'edsger',  'ENTRY', '2023-09-04T17:00:00',        1),
    (       5, '972607187',  'ENTRY', '2023-09-04T17:20:00',        0),
    (       6,    'edsger', 'EGRESS', '2023-09-04T19:00:00',        1),
    (       7,    'edsger',  'ENTRY', '2023-09-05T19:00:00',        1)
;

SELECT * FROM user;
SELECT * FROM access;
COMMIT;
