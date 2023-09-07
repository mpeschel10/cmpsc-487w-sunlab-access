drop table access;
drop table user;


CREATE TABLE user (
    id VARCHAR(256),
    kind SET('STUDENT', 'ADMIN'),
    allowed BOOLEAN,
    CONSTRAINT PK_user PRIMARY KEY (id)
);

INSERT INTO user
    (     kind, allowed,        id)
VALUES
    ('STUDENT',       1,    'gabe'),
    ('STUDENT',       1,    'mark'),
    ('STUDENT',       0,   'tyler'),
    (  'ADMIN',       1,   'admin')
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
    (       1, 'hsy5393',  'ENTRY', '2023-09-03T17:00:00',        1),
    (       2, 'hsy5393', 'EGRESS', '2023-09-03T19:00:00',        1),
    
    (       3, 'hsy5393',  'ENTRY', '2023-09-04T17:00:00',        1),
    (       4,     'bob',  'ENTRY', '2023-09-04T17:20:00',        0),
    (       5, 'hsy5393', 'EGRESS', '2023-09-04T19:00:00',        1),

    (       6, 'hsy5393',  'ENTRY', '2023-09-05T19:00:00',        1)
;

select * from user;
select * from access;
commit;
