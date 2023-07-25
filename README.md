
# Fantasy Football Cub - Sample Project

We have football teams. Each team has a name, country, money balance and players.
Each player has a name and surname.
Teams can sell/buy players.


## Environment Variables

To run this project, you will need to update the following environment variables to your .env file

`DB_CONNECTION`
`DB_HOST`
`DB_PORT`
`DB_DATABASE`
`DB_USERNAME`
`DB_PASSWORD`


## Installation

To use Laravel Sail, you must have Docker and Docker Compose installed on your machine. 

then go to the project root directory and run

 ```bash
  sail composer install
```
 ```bash
  sail php artisan migrate
```
```bash
  sail up
```

the application will be accessibe at [127.0.0.1](127.0.0.1)





## Web Routes

#### Page to add a player or Team

```HTTP
  GET http://127.0.0.1/teams
```

#### Page to list all the teams and associated players with the option to edit and delete them

```HTTP
  GET http://127.0.0.1/team-player
```

#### Page to buy and sell players

```HTTP
  GET http://127.0.0.1/sell-buy-player
```


## Authors

- [Osmar Rodrigues](https://www.linkedin.com/in/osmar-rodrigues-90a79b78/e)

