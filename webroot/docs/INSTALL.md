# Installing Toggen WMS to a Docker Test Environment

**Note:** PHP7.4 is required as some of the code makes use of new features from this version

1. Create a database in MYSQL, create and grant a user access
   ```sql
   CREATE DATABASE tgnwmsdbc4;
   GRANT ALL PRIVILEGES ON tgnwmsdbc4.* TO tgndbuser@localhost IDENTIFIED BY 'RandomCakeNameBoxPhoneNote';
   FLUSH PRIVILEGES;
   ```
2. Clone this repo
   ```sh
   git clone -b cakephp4 https://github.com/jmcd73/tgn-wms.git tgnwms
   # pull the docker repo
   cd tgnwms
   git submodule update --init --recursive
   ```
3. Install the database schema
   ```sh
   mysql -utgndbuser -p tgnwmsdbc4 < dev/sampledbs/skeleton-db.sql
   ```
4. Build docker image
   ```sh
   cd docker/
   docker build -t tgn/php74:v13 .
   ```
5. Run the container

   Edit the docker-command.sh file

   ```sh
   #!/bin/sh
   WEB_DIR=test
   CUPS_PORT=652
   APACHE_PORT=8052
   DOCKER_TAG=tgn/php74\:v13 # tag (-t) you used for docker build
   VOLUME=~/sites/tgnwms/
   CONTAINER_NAME=${WEB_DIR}

   docker run  --name $CONTAINER_NAME \
   -v ${VOLUME}:/var/www/${WEBDIR}  -d \
   -p ${CUPS_PORT}:631 -p ${APACHE_PORT}:80 $DOCKER_TAG
   ```

   Run it

   ```
   ./docker-command.sh
   ```

6. Test connection to CUPS and Apache

   > [http://localhost:652/](http://localhost:652/)
   >
   > [http://localhost:8052/test](http://localhost:8052/test)

   You should get the CUPS admin page for the first URL and a HTTP 500 ERROR for the second

   Note that Google Chrome will refuse to connect to the https://localhost:652 page. So to add or remove printers you need to use Firefox or Safari

7. Login to the docker container

   ```sh
   docker exec -ti tgnwms /bin/bash
   # you should see a root prompt
   root@495bdffd3c45:/var/www#

   # you can check apache logs for errors
   cd /var/log/apache2/
   vim error.log

   # cakephp 4 application error logs are in /var/www/logs

   ```

8. Install the vendor files and support files for bootstrap-ui

   Still in the docker container...

   ```sh
   cd /var/www/test

   # install the PHP dependencies
   composer install

   # install bootstrap-ui deps
   cd vendor/friendsofcake/bootstrap-ui/

   root@d3ad0c48ca65:/var/www/vendor/friendsofcake/bootstrap-ui# npm install
   npm WARN deprecated popper.js@1.16.1: You can find the new Popper v2 at @popperjs/core, this package is dedicated to the legacy
   v1
   /var/www/vendor/friendsofcake/bootstrap-ui
   ├── bootstrap@4.4.1
   ├── jquery@3.5.0
   └── popper.js@1.16.1
   npm WARN bootstrap-ui No repository field.
   npm WARN bootstrap-ui No license field.

   # IMPORTANT

   # install jquery 3.4.1 because the default install of 3.5.0 breaks the
   # navbar collapse / expand accordion

   npm i jquery@3.4.1
   ```

9) Copy don't symlink the assets for plugins to the webroot.

   using symlinks breaks if you try to switch out of docker and run `bin/cake server`

   ```sh
   # still in container
   cd /var/www
   root@d3ad0c48ca65:/var/www# bin/cake plugin assets copy

   For plugin: BootstrapUI
   -------------------------------------------------------------------------------

   For plugin: DebugKit
   -------------------------------------------------------------------------------

   Done

   ```

10. Copy bootstrap, jquery and popper.js into webroot/bootstrap_u_i

    ```sh
    cd /var/www/test/vendor/friendsofcake/bootstrap-ui/node_modules/
    cp -rv bootstrap/dist/* /var/www/test/webroot/bootstrap_u_i/
    cp -rv jquery/dist/* /var/www/test/webroot/bootstrap_u_i/js/
    cp -rv popper.js/dist/umd/* /var/www/test/webroot/bootstrap_u_i/js/
    ```

    Edit the file to have the correct host, user, db, password parameters

    ```php

        'Datasources' => [
            'default' => [
                'host' => \$dbHost,
                //'port' => 'non_standard_port_number',
                'username' => 'tgndbuser',
                'password' => 'RandomCakeNameBoxPhoneNote',
                'database' => 'tgnwmsdbc4',
                //'schema' => 'myapp',
                //'url' => env('DATABASE_URL', null),
            ],

    ```

11. Install htaccess files

    ```sh
    cd /var/www
    co htaccess.txt .htaccess
    cd webroot/
    mv htaccess.txt .htaccess
    ```

12. At this point if the above instructions are correct you should be able to connect to [http://localhost:8052](http://localhost:8052) and get the login screen

| Username          | Password | Role Description                                                                        |
| ----------------- | -------- | --------------------------------------------------------------------------------------- |
| admin@example.com | admin    | admin - Allowed to view, update and delete everything. Has access to Admin menu         |
| user@example.com  | user     | user - Allowed to view everything and update / delete selected items. Admin menu hidden |

### Default root password for docker container

The default **root** password for the docker container is defined in the Dockerfile as `HeartMindSoul`. You will need this if when you add printers via CUPS.

The `dev/sampledbs/skeleton-db.sql` file imported above pre-populates the database with:

- Sample labels
- A PDF Printer that outputs to /var/www/PDF
- Inventory Statuses
- Example product types
- Shifts
- Production Lines
- Print Templates
- Menus

You need modify the above to suit your use case and add your own

- Locations
- Items
- Pack Sizes

## Next Steps

After completing the above installation steps see [SETUP.md](SETUP.md) for a step by step for configuring your own customized environment
