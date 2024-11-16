## Prepare

```bash
git clone https://github.com/Khoroshun/laravel-setup.git .
```

```bash
cat .env.example >> .env
```

Update variables to your needs.

## Install Project

Run your docker containers
```bash
docker compose up -d
```

Install dependency
```bash
docker compose exec php composer install
```

Change permissions to created project
```bash
sudo chown $(id -u):$(id -g) ./ -Rf
```

Change permissions to storage folder
```bash
sudo chmod 777 storage/ -Rf
```

Generate app key
```bash
docker compose exec --user $(id -u):$(id -g) php ./artisan key:generate
```


Restart docker-compose
```bash
docker compose stop
```    
```bash
docker compose up -d
```    
                                                                                           
Migrate database                                                                           
```bash
docker compose exec php ./artisan migrate --seed          
```                                                                                        

### Project links

**Project** - http://127.0.0.1:8080

**DB** - http://127.0.0.1:8084/?pgsql=postgres
