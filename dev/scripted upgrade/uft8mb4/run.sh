DBNAME=pallets1
TEMPLATESQL=template.sql
PREQUERY=preQuery.sql
ALTERTABLES=alterTables.sql
LOGIN_PATH=palletsTest

echo Find {{DBNAME}} and replace with $DBNAME
sed -e "s/{{DBNAME}}/$DBNAME/g" $TEMPLATESQL >$PREQUERY
echo Creating alterTables.sql
mysql --login-path=$LOGIN_PATH <$PREQUERY | egrep '^ALTER' >$ALTERTABLES
echo Running alterTables.sql against $DBNAME
mysql --login-path=$LOGIN_PATH <$ALTERTABLES
