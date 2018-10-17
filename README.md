# MariaDB Cluster Monitoring

a monitoring interface for a MariaDB cluster

![Screenshot](https://raw.githubusercontent.com/Jooyeshgar/MariaDB-Cluster-Monitoring/master/assets/screenshot1.png)


## Installation

copy entire file into your root of PHP web server.

```bash
cd /var/www/html
git clone https://github.com/Jooyeshgar/MariaDB-Cluster-Monitoring.git
cd MariaDB-Cluster-Monitoring
composer install
mv nodes-default.conf nodes.conf
vi nodes.conf
```

## Run

```bash
visit http://localhost/MariaDB-Cluster-Monitoring/
```