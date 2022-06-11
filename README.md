# Fridge Master Project

## Setup Project

1. **Clone this repository** into a working directory (e.g., `~/Sites`)
  ```shell
  $ git clone git@github.com:alexdark2142/fridge-master.git
  ```

2. **Build and run docker container**
  ```shell
  $ cd laravelapp
  $ ./vendor/bin/sail up
  ````

3. **Install components and run migrate/seed**
  ```shell
  $ ./vendor/bin/sail bush
  $ composer install
  $ php artisan migrate --seed 
  ```
