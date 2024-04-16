# Setting up a Linux server with Debian

----------------------- Install Pakages ----------------------
# Install PHP on the server
apt-get install php

# Example: Install Apache2
apt-get install apache2

# Install pip for Python 3
apt-get update
sudo apt install python3-pip


# Install Magika
pip install magika

----------------------- Source code files -----------------------


# copy index.html and Magika.php, FileChecker.php to /var/www/html/


----------------------- upload large files ------------------------

# To upload large files, modify the PHP configuration:
# Open the PHP configuration file
nano /etc/php/[version]/[service]/php.ini

# Modify the following settings to allow larger file uploads:
upload_max_filesize = 15M
post_max_size = 15M

# Save the changes and exit the editor and restart the service :
/etc/init.d/apache2 restart

# Additionally, make Max Size changes inside:
nano /var/www/html/magika.php
