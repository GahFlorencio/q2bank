<p align="center"><img src="https://s3-sa-east-1.amazonaws.com/prod-jobsite-files.kenoby.com/uploads/q2pay-1645390590-q2-logotipo-azulpng.png" width="200"></p>


## Payment API

This is an api that simulates transactions between merchants and customers using a mocked payment gateway.

## Build Docker
Run on root these commands
```
cp env.example .env

cp docker-compose.env.example docker-compose.env

sudo docker-compose --env-file=docker-compose.env up -d
```


