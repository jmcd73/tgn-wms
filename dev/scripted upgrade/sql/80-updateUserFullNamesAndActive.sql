INSERT INTO users ( id, active, full_name)
VALUES (1, 1, 'James McDonald'),
(2, 1, 'James Newlands'),
(4, 1, 'Paul Heagney'),
(5, 1, 'Mark Schierhuber'),
(6, 1, 'Phil Paul'),
(7, 1, 'Adriana Daley'),
(8, 1, 'Angela Ritter'),
(9, 1, 'Wayne Vollmer'),
(10, 1, 'Steve Tucker'),
(11, 1, 'Jayne Bennett'),
(12, 1, 'Josh Tuckwell'),
(13, 1, 'QA Test'),
(14, 1, 'Sharon Yates'),
(15, 1, 'Jessica Merrick'),
(16, 1, 'Natalie Stokes'),
(17, 1, 'Mitch Cremen')
ON DUPLICATE KEY UPDATE
id=VALUES(id), active=VALUES(active), full_name=VALUES(full_name)