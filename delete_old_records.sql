DELETE FROM access WHERE timestamp <= DATE_SUB(UTC_DATE(), INTERVAL 5 YEAR);