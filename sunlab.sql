drop table access;

CREATE TABLE access (
    event_id INT,
    user_id INT,
    kind SET('ENTRY', 'EGRESS'),
    timestamp DATETIME,
    allowed BOOL,
    CONSTRAINT PK_access PRIMARY KEY (event_id)
);

INSERT INTO access 
    (event_id, user_id,      kind,             timestamp, allowed)
VALUES
    (       1,        1,  'ENTRY', '2023-09-03T17:00:00',        1),
    (       2,        1, 'EGRESS', '2023-09-03T19:00:00',        1),

    (       3,        1,  'ENTRY', '2023-09-04T17:00:00',        1),
    (       4,        2,  'ENTRY', '2023-09-04T17:20:00',        0),
    (       5,        1, 'EGRESS', '2023-09-04T19:00:00',        1),

    (       6,        1,  'ENTRY', '2023-09-05T19:00:00',        1)
;
select * from access;


commit;
