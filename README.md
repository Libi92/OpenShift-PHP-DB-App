# Developing a PHP + DB application on OpenShift

This documentation explains the steps to install OpenShift **commandline tool** and steps for deploying a **PHP application with database** on OpenShift Cloud. You can host only 3 applications free *openshift online* account.

##Prerequisites

*   An active openshift account.
You can register at https://www.openshift.com/ with your github account
*   Knowledge in PHP.

## Installation

To install commadline tool we first need to install Rubi with gem.

####Step 1: Install Ruby with RubyGems

From terminal, run the following command to install Ruby:
```
$ sudo apt-get install ruby-full
```
Rubygems are now part of the ruby package. However, with older Ubuntu repositories, you may need to run the following command to explicitly install RubyGems:
```
$ sudo apt-get install rubygems
```

####Step 2: Install Git

Run the following command to install Git version control:
```
$ sudo apt-get install git-core
```

####Step 3: Install Client Tools

When the required software has been successfully installed, run the following command to install the client tools:
```
$ sudo gem install rhc
```

##Setting up Your Machine

After installation is complete, open a Terminal window and run:
```
$ rhc setup
```

The OpenShift interactive setup wizard displays and prompts you to complete the rest of the process.

You’ll be prompted for your OpenShift username and password:

>Login to openshift.redhat.com: user@example.com
>Password: password


You are then prompted to generate an authorization token. Answering yes stores a token in your home directory to be used on subsequent requests. When it expires, you are prompted for your password again.


>OpenShift can create and store a token on disk which allows to you to access the server without using your password. The key is stored in your home directory and should be kept secret. You can delete the key at any time by running 'rhc logout'.
>Generate a token now? (yes|no) yes
>Generating an authorization token for this client ... lasts about 1 day

After creating a configuration file, setup will configure SSH keys so that your system can remotely connect to your applications, including deploying your applications using Git:


>No SSH keys were found. We will generate a pair of keys for you.
>Created: /home/.ssh/id_rsa.pub


After the new SSH keys are generated, the public key, id_rsa.pub, must be uploaded to the OpenShift server to authenticate your system to the remote server. Enter a name to use for your key, or leave it blank to use the default name. In the following example the default name is used.

>Your public ssh key must be uploaded to the OpenShift server to access code.
>Upload now? (yes|no) yes

>Since you do not have any keys associated with your OpenShift account, your new key will be uploaded as the 'default' key

>Uploading key 'default' from /home/.ssh/id_rsa.pub ... done

After verifying that Git is installed, you will be asked to set up your domain if you don’t already have one:

>Checking for a domain ... none

>Your domain is unique to your account and is the suffix of the public URLs we assign to your applications. You may configure your domain here or leave it blank and use 'rhc domain create' to create a domain later. You will not be able to create applications without first creating a domain.

>Please enter a domain (letters and numbers only) |<none>|: MyDomain
>Your domain name 'MyDomain' has been successfully created

Finally, the setup wizard verifies whether any applications exist under your domain. In the example below, no applications have been created. In this case the setup wizard shows the types of applications that can be created with the associated commands. The setup wizard then completes by displaying the current gear consumption along with the gear sizes available to the given user.

##Creating a PHP Project

Once that is completed, open a terminal on a local machine and change into the directory where you would like the OpenShift application source code to be located. At the command prompt, enter the following command to create a PHP application:
```
$ rhc app create <app-name> php-5.4
```
A sample project with a single **index.php** file is created. You can edit this file or add new php files. The public domain url of your app will be shown in the output.
You an make code changes on a local machine, check those changes in locally, and then git push those changes to OpenShift. One of the primary advantages of the Git version control system is that it does not require a continuous online presence in order to run. A developer can easily check in (commit, in Git terminology) and revert changes locally before deciding to upload those changes to OpenShift.

Now that you have made this incredibly complicated code change, the new code must be deployed to the server. You can accomplish this task using Git.

To add the change to the Git repository’s index and stage it for the next commit, use the command git add:
```
$ git add --all .
```
Next commit the staged changes to the Git repository, with a log message to explain the changes:
```
$ git commit -m "Your commit message"
```
Finally, push these changes to the remote OpenShift application.
```
$ git push
```

The git push will automatically deploy the project in the public domain.

##Creating a PHP application with MySQL

Getting a PHP app with a MySQL backend deployed onto OpenShift is as easy as executing two commands:
```
$ rhc app create MyApp php-5.4
$ rhc cartridge add mysql-5.5 -a MyApp
```
These two commands create your "server" and install and configure PHP, MySQL, and a git repository on the server. You can now visit your application on the web at:

http://MyApp-MyDomain.rhcloud.com/
####phpMyAdmin

The phpmyadmin cartridge provides phpMyAdmin on OpenShift. In order to add this cartridge to an application, the MySQL cartridge must already be present. Once installed, phpMyAdmin can be used by navigating to http://app-domain.rhcloud.com/phpmyadmin with the MySQL login credentials.

**Or Simply you can use a web interface to do this all**, which is at https://hub.openshift.com/quickstarts/117-php-mysql-and-phpmyadmin

###MySQL connection in PHP
Use the following code for MySQL db connectivity.
```php
define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));

$dbhost = constant("DB_HOST"); // Host name 
$dbport = constant("DB_PORT"); // Host port
$dbusername = constant("DB_USER"); // Mysql username 
$dbpassword = constant("DB_PASS"); // Mysql password 
$db_name = constant("DB_NAME"); // Database name

$conn = mysqli_connect($dbhost, $dbusername,$dbpassword,$db_name)or
    die("Could not connect: " . mysql_error());
```

Connection parameters can be found from openshift *environment variables*.