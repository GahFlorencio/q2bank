<p align="center"><img src="https://user-images.githubusercontent.com/44595199/184076224-b0af60ff-796e-4f16-9cd3-71d450d4e265.png" width="200"></p>


## Payment API

This is an api that simulates transactions between merchants and customers using a mocked payment gateway.

## Host
Add on hosts this line below
```
127.0.0.1   q2bank.local
```

## Build Docker
Run on root these commands
```
cp env.example .env

cp docker-compose.env.example docker-compose.env

sudo docker-compose --env-file=docker-compose.env up -d
```

## Composer
After build Docker connect and run composer and artisan commands bellow

```
docker-compose --env-file=docker-compose.env exec -u laradock workspace bash

composer install && php artisan migrate && php artisan db:seed

```


## Usage
Route to make a payment  
<b>POST</b>
``
q2bank.local/api/payment/pay
``
### Payload
### Specifications

| Attibute | Required |  type   | rules                                |
|:--------:|:--------:|:-------:|:-------------------------------------|
|  payer   |   true   | integer | Valid user that is not a company     |
|  receiver   |   true   | integer | Valid user that is not a company     |
|  value   |   true   | integer | Valid integer value, Accept Floating |

### Example:
```` 
{
    "payer" : 2,
    "receiver" :1,
    "value": 20.0
}
````
## Response

|                                 Message                                 |                  Description                  | Status Code |
|:-----------------------------------------------------------------------:|:---------------------------------------------:|:-----------:|
|                        Failed to create Payment                         | Failed to create a Payment record on database |     500     |
| Payment gateway declined transaction or is down, please try again later |      Payment Gateway Refused or is Down       |     500     |
|                       Payer can not be a company                        |          Payer can not be a company           |     400     |
|                      Receiver have to be a company                      |         Receiver have to be a company         |     400     |
|                Payer does not have the balance available                |   Payer does not have the balance available   |     400     |
|                       Payment made successfully                         |          Payment made successfully            |    200      |



