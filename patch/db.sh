rm -rf db
mkdir -p db/mysql
mkdir -p db/psql
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts arborist_db > /tmp/arborist_db.sql'
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts fence_db > /tmp/fence_db.sql'
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts indexd_db > /tmp/indexd_db.sql'
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts metadata > /tmp/metadata.sql'
docker exec -it  postgres su postgres bash -c 'pg_dump --format p --inserts metadata_db > /tmp/metadata_db.sql'

docker cp postgres:/tmp/arborist_db.sql db/psql/arborist_db.sql 
docker cp postgres:/tmp/fence_db.sql db/psql/fence_db.sql
docker cp postgres:/tmp/indexd_db.sql db/psql/indexd_db.sql
docker cp postgres:/tmp/metadata.sql db/psql/metadata.sql
docker cp postgres:/tmp/metadata_db.sql db/psql/metadata_db.sql


sudo apt install php7.4-cli -y
#cd db
#wget http://www.lightbox.ca/pg2mysql/pg2mysql-1.9.tar.bz2
#tar -xjvf pg2mysql-1.9.tar.bz2
#php pg2mysql_cli.php db/psql/fence_db.sql db/mysql/fence_db.sql InnoDB
php pg2mysql_cli.php db/psql/arborist_db.sql db/mysql/arborist_db.sql InnoDB
php pg2mysql_cli.php db/psql/fence_db.sql db/mysql/fence_db.sql InnoDB
php pg2mysql_cli.php db/psql/indexd_db.sql db/mysql/indexd_db.sql InnoDB
php pg2mysql_cli.php db/psql/metadata.sql db/mysql/metadata.sql InnoDB
php pg2mysql_cli.php db/psql/metadata_db.sql db/mysql/metadata_db.sql InnoDB


sed -i 's/public./gen3_arborist_db./g' db/mysql/arborist_db.sql
sed -i 's/public./gen3_fence_db./g' db/mysql/fence_db.sql
sed -i 's/public./gen3_indexd_db./g' db/mysql/indexd_db.sql
sed -i 's/public./gen3_metadata./g' db/mysql/metadata.sql
sed -i 's/public./gen3_metadata_db./g' db/mysql/metadata_db.sql

sed -i 's/ TYPE=InnoDB//g' db/mysql/arborist_db.sql
sed -i 's/ TYPE=InnoDB//g' db/mysql/fence_db.sql
sed -i 's/ TYPE=InnoDB//g' db/mysql/indexd_db.sql
sed -i 's/ TYPE=InnoDB//g' db/mysql/metadata.sql
sed -i 's/ TYPE=InnoDB//g' db/mysql/metadata_db.sql

sed -i "s/jsonb DEFAULT '{}'/JSON/g" db/mysql/arborist_db.sql
sed -i "s/jsonb DEFAULT '{}'/JSON/g" db/mysql/fence_db.sql
sed -i "s/jsonb DEFAULT '{}'/JSON/g" db/mysql/indexd_db.sql
sed -i "s/jsonb DEFAULT '{}'/JSON/g" db/mysql/metadata.sql
sed -i "s/jsonb DEFAULT '{}'/JSON/g" db/mysql/metadata_db.sql

sed -i 's/jsonb/JSON/g' db/mysql/arborist_db.sql
sed -i 's/jsonb/JSON/g' db/mysql/fence_db.sql
sed -i 's/jsonb/JSON/g' db/mysql/indexd_db.sql
sed -i 's/jsonb/JSON/g' db/mysql/metadata.sql
sed -i 's/jsonb/JSON/g' db/mysql/metadata_db.sql

sed -i 's/_pkey//g' db/mysql/arborist_db.sql
sed -i 's/_pkey//g' db/mysql/fence_db.sql
sed -i 's/_pkey//g' db/mysql/indexd_db.sql
sed -i 's/_pkey//g' db/mysql/metadata.sql
sed -i 's/_pkey//g' db/mysql/metadata_db.sql


sed -i 's/text\[\]/text/g' db/mysql/arborist_db.sql
sed -i 's/text\[\]/text/g' db/mysql/fence_db.sql
sed -i 's/text\[\]/text/g' db/mysql/indexd_db.sql
sed -i 's/text\[\]/text/g' db/mysql/metadata.sql
sed -i 's/text\[\]/text/g' db/mysql/metadata_db.sql

sed -i 's/\[\]//g' db/mysql/arborist_db.sql
sed -i 's/\[\]//g' db/mysql/fence_db.sql
sed -i 's/\[\]//g' db/mysql/indexd_db.sql
sed -i 's/\[\]//g' db/mysql/metadata.sql
sed -i 's/\[\]//g' db/mysql/metadata_db.sql


sed -i 's/varchar()/varchar(255)/g' db/mysql/arborist_db.sql
sed -i 's/varchar()/varchar(255)/g' db/mysql/fence_db.sql
sed -i 's/varchar()/varchar(255)/g' db/mysql/indexd_db.sql
sed -i 's/varchar()/varchar(255)/g' db/mysql/metadata.sql
sed -i 's/varchar()/varchar(255)/g' db/mysql/metadata_db.sql


sed -i "s/DEFAULT date_part('epoch'//g" db/mysql/arborist_db.sql
sed -i "s/DEFAULT date_part('epoch'//g" db/mysql/fence_db.sql
sed -i "s/DEFAULT date_part('epoch'//g" db/mysql/indexd_db.sql
sed -i "s/DEFAULT date_part('epoch'//g" db/mysql/metadata.sql
sed -i "s/DEFAULT date_part('epoch'//g" db/mysql/metadata_db.sql


sed -i "s/path gen3_arborist_db.ltree NOT NULL/path text NOT NULL/g" db/mysql/arborist_db.sql
sed -i "s/path gen3_arborist_db.ltree NOT NULL/path  NOT NULL/g" db/mysql/fence_db.sql
sed -i "s/path gen3_arborist_db.ltree NOT NULL/path text NOT NULL/g" db/mysql/indexd_db.sql
sed -i "s/path gen3_arborist_db.ltree NOT NULL/path text NOT NULL/g" db/mysql/metadata.sql
sed -i "s/path gen3_arborist_db.ltree NOT NULL/path text NOT NULL/g" db/mysql/metadata_db.sql


sed -i 's/varchar(255) NOT NULL/varchar(255)/g' db/mysql/arborist_db.sql
sed -i 's/varchar(255) NOT NULL/varchar(255)/g' db/mysql/fence_db.sql
sed -i 's/varchar(255) NOT NULL/varchar(255)/g' db/mysql/indexd_db.sql
sed -i 's/varchar(255) NOT NULL/varchar(255)/g' db/mysql/metadata.sql
sed -i 's/varchar(255) NOT NULL/varchar(255)/g' db/mysql/metadata_db.sql

sed -i 's/key varchar(255)/key_tag varchar(255)/g' db/mysql/arborist_db.sql
sed -i 's/key varchar(255)/key_tag varchar(255)/g' db/mysql/fence_db.sql
sed -i 's/key varchar(255)/key_tag varchar(255)/g' db/mysql/indexd_db.sql
sed -i 's/key varchar(255)/key_tag varchar(255)/g' db/mysql/metadata.sql
sed -i 's/key varchar(255)/key_tag varchar(255)/g' db/mysql/metadata_db.sql


sed -i 's/value varchar(255)/value_tag varchar(255)/g' db/mysql/arborist_db.sql
sed -i 's/value varchar(255)/value_tag varchar(255)/g' db/mysql/fence_db.sql
sed -i 's/value varchar(255)/value_tag varchar(255)/g' db/mysql/indexd_db.sql
sed -i 's/value varchar(255)/value_tag varchar(255)/g' db/mysql/metadata.sql
sed -i 's/value varchar(255)/value_tag varchar(255)/g' db/mysql/metadata_db.sql


  

docker cp db.sql mysql:/tmp/db.sql
docker cp db/mysql/arborist_db.sql mysql:/tmp/arborist_db.sql 
docker cp db/mysql/fence_db.sql mysql:/tmp/fence_db.sql
docker cp db/mysql/indexd_db.sql mysql:/tmp/indexd_db.sql
docker cp db/mysql/metadata.sql mysql:/tmp/metadata.sql 
docker cp db/mysql/metadata_db.sql mysql:/tmp/metadata_db.sql

docker exec -it  mysql bash -c 'mysql -u root -padmin -f < /tmp/db.sql'
docker exec -it  mysql bash -c 'mysql -u root -padmin -f gen3_arborist_db < /tmp/arborist_db.sql'
docker exec -it  mysql bash -c 'mysql -u root -padmin -f gen3_fence_db < /tmp/fence_db.sql'
docker exec -it  mysql bash -c 'mysql -u root -padmin -f gen3_indexd_db < /tmp/indexd_db.sql'
docker exec -it  mysql bash -c 'mysql -u root -padmin -f gen3_metadata < /tmp/metadata.sql'
docker exec -it  mysql bash -c 'mysql -u root -padmin -f gen3_metadata_db < /tmp/metadata_db.sql'

