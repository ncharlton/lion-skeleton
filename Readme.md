# Lionapp 

A plattform to manage Learning Earning and Yearning particularly for users in developing countries.
The software uses Symfony 4.0.8 to provide an api and a frontend built with [vue-cli](https://github.com/vuejs/vue-cli/)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

Node.js v8.*
NPM v5.6
Composer v1.6.*

```
Give examples
```

### Installing

#### Symfony Backend

Navigate to /backend and install dependencies

```
composer install
```

After installing the dependencies open the .env file and set your database settings

```
# make sure the database exists
DATABASE_URL=mysql://root:@127.0.0.1:3306/db_name
```
Now migrate the databse

```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

#### Vue frontend

Navigate to /frontend and install dependencies

```
npm install
```


### Running the applications


#### Backend

```
# http://localhost:8000
php bin/console server:run
```

#### Frontend

```
# http://localhost:8080
npm run server
```


## Built With

* [Symfony](https://symfony.com/) - PHP framework
* [vue-cli](https://github.com/vuejs/vue-cli/) - CLI for rapid Vue.js development


