#About

Little REST API for Users.


#How to run 
- Set up vagrant...

-   ```sh
    $ vagrant up
    ```
-   ```sh
    $ vagrant ssh
    ```
-   ```sh
    $ cd /vagrant
    ```
-   ```sh
    $ vendor/bin/phinx migrate -e development
    ```
- Done :D

#API Documentation


## User Resources
## GET

    GET user/:id

### Description
Returns a user based on id

***


### Parameters
- **id** _(required)_ — User id 
    
***

### Return format
An array with the following keys and values:

- **data** — Main Array.
    - 'email' — The user id;
    - 'first_name' — First name;
    - 'last_name' — Last name;
    
***

### Errors
When the id doesn't match with any **valid** user

- **data** — false
- **message** - "No user"

***

### Example
**Request**

    http://www.testbox.dev/users/1

**Return** __for a valid id__
``` json
{
    "data": {
        "email": "medelling24@gmail.com",
        "first_name": "Luis",
        "last_name": "Medellin"
    }
}
```

##POST

 
    POST user

### Description
Create a new user

***


### Parameters

- **email** _(required)_ — User email
- **first_name** _(required)_ — User first name
- **last_name** _(required)_ — User last name
- **password** _(required)_ — User password (not encrypted)
    
***

### Return format
An array with the following keys and values:

- **data** — new user id.

***

### Errors
When the email already exists for a **valid** user


-  **error**: false,
-  **message**: "User Already Exist"


***

### Example
**Request**

    http://www.testbox.dev/users
    
**Body**
``` json
    {
            "email": "medelling24@gmail.com",
            "first_name": "Luis",
            "last_name": "Medellin"
    }
```

**Return** __for a valid email__
``` json
{
    "data": 9
}
```
##PUT
 
    PUT user/:id

### Description
Update a user

***

### URL Parameters

- **id** _(required)_ — User id
    
***


### Body Parameters

- **email** _(required)_ — User email
- **first_name** _(required)_ — User first name
- **last_name** _(required)_ — User last name
- **password** _(required)_ — User password (not encrypted)
    
***

### Return format
An array with the following keys and values:

- **message** — "updated".

***

### Errors
When the id does not exists for a **valid** user


-  **error**: false,
-  **message**: "No User"


***

### Example
**Request**

    http://www.testbox.dev/users/1
    
**Body**
``` json
    {
            "email": "medelling24@gmail.com",
            "first_name": "Luis",
            "last_name": "Medellin"
    }
```

**Return** __for a valid id__
``` json
{
    "message": "updated"
}
```

##DELETE
    DELETE user/:id

### Description
Deletes a user based on id

***


### Parameters
- **id** _(required)_ — User id 
    
***

### Return format
An array with the following keys and values:

- **message** — "deleted"

***

### Errors
When the id doesn't match with any **valid** user

- **data** — false
- **message** - "No user"

***

### Example
**Request**

    http://www.testbox.dev/users/1

**Return** __for a valid id__
``` json
{
    "message": "deleted"
}
```


#Tests

        php vendor/bin/phpunit tests/UsersTest.php 

