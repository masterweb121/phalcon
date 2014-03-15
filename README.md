phalcon
=======

Install
-------
	mkdir -p /var/tmp/cache/linux/
	chmod 777 -R /var/tmp/cache

    pecl install mongo
    pecl install redis
    pecl install phalcon

Install MongoDB
------
	cat <<EOF | mongo
	use admin
	db.addUser('admin','password')
	db.system.users.find()
	exit
	EOF
	
	cat <<EOF | mongo -u admin -p password admin
	use radio
	db.addUser('user','password')
	db.system.users.find()
	exit
	EOF
