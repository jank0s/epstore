#!/bin/bash
if [ ${PWD##*/} = "conf" ]; then
	cd ..
fi

# Install required dependencies
sudo apt-get update
sudo apt-get install apache2 mysql-server mysql-client php php-mysql php-pear php-dev libapache2-mod-php -y
sudo apt-get install php-curl -y
sudo pear install -Z HTML_QuickForm2
sudo pear install HTML_QuickForm2_Captcha-0.1.2
sudo pear install Services_ReCaptcha

# Prepare apache conf and SSL certificates
sudo a2enmod rewrite
sudo a2enmod ssl
if [ ! -d "/etc/apache2/ssl" ]; then
	sudo mkdir /etc/apache2/ssl
fi
sudo cp cert/server/* /etc/apache2/ssl/
sudo cp conf/000-default.conf /etc/apache2/sites-available/
sudo cp conf/default-ssl.conf /etc/apache2/sites-available/
sudo a2ensite 000-default.conf
sudo a2ensite default-ssl.conf

# Copy app data to /var/www/html
if [ -d "/var/www/html" ]; then
	sudo mv /var/www/html "/var/www/html_bak_"$(date +"%Y-%m-%d_%H-%M-%S")
fi
sudo cp -R app /var/www/html
# Folder rights for image upload
sudo chown -R www-data:www-data /var/www/html/static/images

# Prepare folder for logs
if [ ! -d "/var/log/epstore" ]; then
    sudo mkdir /var/log/epstore
fi
sudo chown -R www-data:www-data /var/log/epstore

# Initialize database
echo "Enter root password for MySQL"
mysql -u root -p < db/baza.sql

# Restart apache
sudo service apache2 restart
