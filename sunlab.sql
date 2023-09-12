USE sweng;

DROP TABLE access;
DROP TABLE user;


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
    ('STUDENT',       1,                'edsger', 'Edsger Dijkstra'),
    ('STUDENT',       1,             '972607187',    'Mark Peschel'),
    ('STUDENT',       0, ';9308057671208700000?',     'Alan Turing'),
    (  'ADMIN',       1,                 'admin',   'Adam Inchoate')
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
    (       1,    'edsger',  'ENTRY', '2023-09-03T17:00:00',        1),
    (       2,    'edsger', 'EGRESS', '2023-09-03T19:00:00',        1),
    (       3,    'edsger',  'ENTRY', '2023-09-04T17:00:00',        1),
    (       4, '972607187',  'ENTRY', '2023-09-04T17:20:00',        0),
    (       5,    'edsger', 'EGRESS', '2023-09-04T19:00:00',        1),
    (       6,    'edsger',  'ENTRY', '2023-09-05T19:00:00',        1)
;

select * from user;
select * from access;
COMMIT;
