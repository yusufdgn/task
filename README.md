# API endpoints

#### Authentication
Bearer TOKEN

### Register
****POST**** `/register` </br>
`{
    "email": "yd@****.com",
    "firstName": "Yusuf",
    "lastName": "Doğan",
    "country": "TR",
    "phoneNumber": "90507837****"
}`

### Login
**POST** `/login` </br>
```
{
    "email": "yd@****.com"
}
```

### Create Subscription
**POST** `/subscription` </br>
```
{
	"cardNo": "4111111111111111",
	"cardOwner": "Yusuf Doğan",
	"expireMonth": 12,
	"expireYear": 22,
	"cvv": "000"
}
```

### Read Subscription
**GET** `/subscription` </br>

### Delete Subscription
**DELETE** `/subscription` </br>
```
{
	"cancellationReason": "reason",
	"force": 1
}
```

### Credit Card List
**GET** `/credit-cards` </br>

### Subscription Hook
**POST** `/subscription-hook` </br>
```
{
  "queue" : {
    "type" : "SubscriberUpdate",
    "createDate" : "2020-04-20 21:29:20",
    "appId" : "2"
  },
  "parameters" : {
    "package" : {
      "currency" : "USD",
      "packageType" : "subscription",
      "packageId" : "zotlo_premium",
      "price" : 2.9900000000000002,
      "name" : "Zotlo Premium"
    },
    "newPackage" : {
      "discountPrice" : "0.00",
      "period" : 30,
      "startDate" : "2020-08-04 10:48:30",
      "price" : "2.99",
      "packageId" : "zotlo_premium",
      "createDate" : "2020-08-04 10:48:30",
      "currency" : "USD",
      "subscriberId" : "3133"
    },
    "customer" : {
      "email" : "test@zotlo.com",
      "id" : 1,
      "createDate" : "2020-05-13 12:57:36",
      "country" : "TR",
      "lastname" : "Test",
      "firstname" : "Test"
    },
    "card" : {
      "cardNumber" : "411111******1111",
      "expireDate" : "12\/20"
    },
    "profile" : {
      "customParameters" : {
        "country" : "RU",
        "source" : "Landing"
      },
      "quantity" : 1,
      "cancellation" : {
        "date" : "2020-08-13 13:25:08",
        "code" : "CU00001",
        "reason" : "Not Interest"
      },
      "originalTransactionId" : "0587875f-13ea-4d71-9bca-a7204caed583", // Change Transaction ID 
      "subscriptionType" : "paid",
      "pendingQuantity" : 0,
      "subscriberId" : "3f76764b-f92f-469e-b86d-d48de8a4b976", // Change Subscriber ID
      "language" : "tr",
      "expireDate" : "2020-09-03 10:48:30",
      "package" : "zotlo_premium",
      "realStatus" : "active",
      "startDate" : "2020-08-04 10:48:30",
      "country" : "TR",
      "status" : "active",
      "phoneNumber" : "+905555555555"
    },
    "package_update" : 0
  }
}
```

## Command
```
-> docker exec -it task_webserver bash
-> php bin/console app:subscription-checker
```