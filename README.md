# Welcome to Distribution Plus CRM / Salesportal

This document is in Markdown.

DPLUS CRM / SALES PORTAL is powered by Processwire read more at
https://github.com/processwire/processwire/blob/master/README.md


## Table of Contents

1. [About](#about-distribution)
2. [Server Preparation](#Prepare-the)
3. [Installation](#Install-DPlus)


## About Distribution Plus CRM

CRM is a Customer Relation Management tool. Sales reps can use this tool
to manage their day-to-day tasks and activities. They can view their customer's
orders and add actions like notes or tasks that will be tied to them. Sales reps can
also use the CRM to create quotes and orders, and also push quotes to orders.


## Installing DPlus CRM
1. Get the most recent copy of DPlus CRM on the [Soft Server](http://192.168.1.2/dpluso/)
and log in to the Processwire, click on Setup -> Export. Name it dpluso, get a zip/file download, leave the config properties checked.
2. Prepare the new server with directories each Dplus CRM installation needs these directories:
    * /var/www/html/orderfiles/
    * /var/www/html/files/
    * /var/www/html/files/json/
    * /var/www/html/data#  <- # should be the company # that the salesportal will be installed for
    * /var/www/html/dpluso/ <- default salesportal directory
3. Download Processwire from [Processwire](https://processwire.com/download/)
    * If this a new installation no others have been made, use the 3.0 master link
    * If not or if you want a for sure installation, use 2.8
    * Download the zip open it up, inside it stick the dpluso/ zip download stick the bottom most site-dpluso directory in the processwire directory which has other site-*
    * Upload the directory under processwire*master to /var/www/html/dpluso/
4. Install DPlus CRM
    * Go to that server IP or address with dpluso/ added to the url.
    * Go through the Processwire installation, choose site-dpluso as the profile
    * Follow the steps use cptecomm login as the database credentials, name the database dpluso
    * For the admin link use manage, and the color scheme warm
    * For the admin credentials use the rcapsys login





------

Copyright 2017 by CPTech
