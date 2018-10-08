# dmg-leaderboard
This is the completely rewritten Leaderboard Application.

# Setup (Development Instructions)

To start development on this application:
1. Clone this repository
2. Run `composer install`
2. Edit the .env file to include credentials for your local mysql
   install
3. Run `php artisan key:generate`
4. Run `php artisan migrate`

To run this application we recomend using Valet if you are on a Mac.
Otherwise use either Homstead or Laradoc. 

## Valet

Not using Valet?  Why not!?  If you are using a Mac, you should defintely set this up for a basic dev environment and use either Homestead or Laradock for your more advanced needs.

Read up on installing Valet [here](https://laravel.com/docs/5.4/valet)

## Homestead
If you are already using Homestead, you can simply integrate this
repository into your current Homestead environment.  

Alternatively, if you are new to Homestead, or you prefer to use site specific instances,
Homestead has already been configured here.  Just run ```vagrant up``` and you should be good to go.

#### after.sh

The database migration takes place in ```after.sh```.  This is where we can run any scripts against the Homestead instance.

####ssh

To shell into your Homestead instance, use ```vagrant ssh```.



## Docker
From the application root run `docker-compose up -d`

This will run nginx, php7, mysql8 and Mailhog.

