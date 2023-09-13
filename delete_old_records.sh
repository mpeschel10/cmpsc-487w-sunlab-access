#!/bin/sh
# mariadb --user=AzureDiamond --password=hunter2 sweng < /opt/sweng/delete_old_records.sql
mysql --user=AzureDiamond --password=hunter2 sweng < /opt/sweng/delete_old_records.sql
