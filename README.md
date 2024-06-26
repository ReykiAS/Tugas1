# API Documentation

## Description

This is an *api* to fetch products.

## Base URL

The base URL for all API requests is:

`[http](http://tugas1.devv/)://Tugas1.dev`

## Create user account.

### Endpoints

### `Post {{base_url}}/v1/user`

### Request Body

- `username` : String.
- `email` : String.
- `password` : String.
- `Confirmation Password` : String.
- `photo` : String

### Response

`201 Created` user has been successfully created

```json
{
  "username": "user",
  "email": "user@example.com",
  "password": "rahasia"
  "photo": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
}
```

## Errors

`500 Bad Request` the request body is malformed or missing required fields

```json
{
  "error": "Missing required field: username"
}
```

`500 Internal Server Error`: An unexpected error occurred on the server.

## Login user account.

### Endpoints

### `Post {{base_url}}/v1/login`

### Request Body

- `username` : String.
- `email` : String.
- `password` : String.

### Response

`201 Created` user has been successfully created

```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM...", 
```

## Errors

`422 Unprocessable Content`  the server understands the content of the request, but it cannot process the contained instructions because of semantic errors

```json
{
    "message": "The provided credentials are incorrect.",
}
```

`401 Unauthorized`  

```json
{
    "message": "Invalid Username or Password.",
}
```

`500 Internal Server Error`: An unexpected error occurred on the server.

## Update user account.

### Endpoints

### `Post {{base_url}}/v1/user`

### Header

- `Authorization` :  Bearer token

### Request Body

- `username` : String.
- `email` : String.
- `password` : String.
- `Confirmation Password` : String.
- `photo` : String

### Response

`201 Created` user has been successfully created

```json

HTTP/1.1 200 OK
Content-Type: application/json

{
  "username": "user",
  "email": "user@example.com",
  "password": "rahasia"
  "photo": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
}

```

## Errors

`500 Bad Request` the request body is malformed or missing required fields

```json
{
  "error": "Missing required field: username"
}
```

`500 Internal Server Error`: An unexpected error occurred on the server.

## Returns a list of all products.

### Endpoints

### `GET {{base_url}}/v1/products`

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `qty`: Integer.
- `name_category`: String.
- `name_brand`: String.
- `price`: Integer.
- `url`: string.

### Request Method

```
GET /products
```

### Response

- `200 Ok`if not user

```json
{
    "data": [
        {
            "id": 1,
            "name": "The Great Gatsby",
            "qty": 100,
            "name_category": "Book",
            "name_brand": "Media",
            "price": 1000",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
        {
        "id": 2,
            "name": "The Great Gatsby",
            "qty": 100,
            "name_category": "Book",
            "name_brand": "Media",
            "price": 10000,
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
            
        },
        "id": 3,
            "name": "The Great Gatsby",
            "qty": 100,
            "name_category": "Book",
            "name_brand": "Media",
            "price": 10000,
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
            
        },
        "id": 4,
            "name": "The Great Gatsby",
            "qty": 100,
            "name_category": "Book",
            "name_brand": "Media",
            "price": 10000,
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
            
        },
    ]
}

```

`200 Ok` if user

```json
{
    "data": [
        {
            "id": 1,
            "name": "The Great Gatsby",
            "qty": 100,
            "name_category": "Book",
            "name_brand": "Media",
            "price": 1000",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
        {
        "id": 4,
            "name": "The Great Gatsby",
            "qty": 100,
            "name_category": "Book",
            "name_brand": "Media",
            "price": 10000,
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
            
        },
        
    ]
}

```

## Errors

This API uses the following error codes:

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Product Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Returns selected product.

### Endpoints

### `GET {{base_url}}/v1/product{{id}}`

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `qty`: Integer.
- `name_category`: String.
- `name_brand`: String.
- `price`: Integer.
- `url`: String.

### Response

- `200 Ok`

```json
{
    "data": [
        {
            "id": 1,
            "name": "The Great Gatsby",
            "qty": 100,
            "name_category": "Book",
            "name_brand": "Media",
            "price": 1000",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
       
    ]
}

```

## Errors

This API uses the following error codes:

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Product Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## update product data.

### Endpoints

### `put {{base_url}}/v1/product/{{id}}`

### Header

- `Authorization` :  Bearer token

### **Request Body**

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `qty`: Integer.
- `name_category`: String.
- `name_brand`: String.
- `price`: Integer.
- `url` : String

### Response

- `200 Ok`  If the product is successfully updated, the response body may contain the updated product data

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "id": 1,
  "name": "The Great Gatsby",
  "qty": 100,
  "name_category": "Book",
  "name_brand": "Education",
  "price": 1000,
  "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Product Not Found",
        },
       
    ]
}

```

- `400 Bad Request`: If the request body is malformed or missing required fields.

```json
{
    "data": [
        {
            "messages": "Missing required field: price",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Delete product data.

### Endpoints

### `delete {{base_url}}/v1/product/{{id}}`

### Header

- `Authorization` :  Bearer token

### Response

- `200 Ok`  The product has been successfully deleted

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "message": "Product with ID 1 has been deleted successfully."
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Product with ID 1 not found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Returns deleted product.

### Endpoints

### `GET {{base_url}}/v1/product/deleted`

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `qty`: Integer.
- `name_category`: String.
- `name_brand`: String.
- `price`: Integer.
- `url`: String.

### Response

```json
{
    "data": [
        {
            "id": 1,
            "name": "The Great Gatsby",
            "qty": 100,
            "name_category": "Book",
            "name_brand": "Media",
            "price": 1000",
        },
       
    ]
}

```

## Errors

This API uses the following error codes:

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Product Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Restore product data.

### Endpoints

### `delete {{base_url}}/v1/product/{{id}}/restore`

### Header

- `Authorization` :  Bearer token

### Response

- `200 Ok`  The product has been successfully restore.

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "message": "Product with ID 1 has been recovered."
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Product with ID 1 not found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

---

## Returns a list of all brands.

### Endpoints

### `GET {{base_url}}/v1/brands`

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `url`: string.

### Request Method

```
GET /brands
```

### Response

- `200 Ok`

```json
{
    "data": [
        {
            "id": 1,
            "name": "nesley",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
         {
            "id": 2,
            "name": "Nufo",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
        
    ]
}

```

## Errors

This API uses the following error codes:

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Brands Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Returns selected brand.

### Endpoints

### `GET {{base_url}}/v1/brand/{{id}}`

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `url`: string.

### Response

- `200 Ok`

```json
{
    {
            "id": 1,
            "name": "nesley",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
       
    ]
}

```

## Errors

This API uses the following error codes:

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "brand Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Update brand data.

### Endpoints

### `put {base_url}}/v1/brand/{{id}}`

### Header

- `Authorization` :  Bearer token

### **Request Body**

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `url`: string.

### Response

- `200 Ok`  If the product is successfully updated, the response body may contain the updated product data

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "id": 1,
            "name": "nesleyy",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "brand Not Found",
        },
       
    ]
}

```

- `400 Bad Request`: If the request body is malformed or missing required fields.

```json
{
    "data": [
        {
            "messages": "Missing required field: price",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Delete brand data.

### Endpoints

### `delete {{base_url}}/v1/brand/{{id}}`

### Header

- `Authorization` :  Bearer token

### Response

- `200 Ok`  The product has been successfully deleted

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "message": "brand with ID 1 has been deleted successfully."
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "brand with ID 1 not found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Endpoints

### `GET {{base_url}}/v1/brands/deleted`

Returns deleted brand.

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- 

### Response

```json
{
					  "id": 1,
            "name": "nesleyy",
}
```

## Errors

This API uses the following error codes:

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "brand Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Restore brand data.

### Endpoints

### `delete {{base_url}}/v1/brand/{{id}}/restore`

### Header

- `Authorization` :  Bearer token

### Response

- `200 Ok`  The product has been successfully restored.

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "message": "Brand with ID 1 has been recovered."
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Brand with ID 1 not found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

---

## Returns a list of all categories.

### Endpoints

### `GET {{base_url}}/v1/categories`

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `url`: string.

### Request Method

```
GET /categories
```

### Response

- `200 Ok`

```json
{
    "data": [
        {
            "id": 1,
            "name": "book",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
         {
            "id": 2,
            "name": "education",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
        
    ]
}

```

## Errors

This API uses the following error codes:

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "categories Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Returns selected brand.

### Endpoints

### `GET {{base_url}}/v1/category/{{id}}`

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `url`: string.

### Response

- `200 Ok`

```json
{
    {
            "id": 1,
            "name": "book",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
        },
       
    ]
}

```

## Errors

This API uses the following error codes:

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "category Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Update brand data.

### Endpoints

### `put {{base_url}}/v1/category/{{id}}`

### Header

- `Authorization` :  Bearer token

### **Request Body**

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- `url`: string.

### Response

- `200 Ok`  If the product is successfully updated, the response body may contain the updated product data

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "id": 1,
            "name": "books",
            "url": "photos/f0GtElrRVKZewsTayq5NtMw1uNp4XDl3pq6sm53S.png"
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "category Not Found",
        },
       
    ]
}

```

- `400 Bad Request`: If the request body is malformed or missing required fields.

```json
{
    "data": [
        {
            "messages": "Missing required field: price",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Delete brand data.

### Endpoints

### `delete {{base_url}}/v1/category/{{id}}`

### Header

- `Authorization` :  Bearer token

### Response

- `200 Ok`  The product has been successfully deleted

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "message": "category with ID 1 has been deleted successfully."
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "category with ID 1 not found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Returns deleted categories.

### Endpoints

### `GET {{api}}/v1/categories/deleted`

### Header

- `Authorization` :  Bearer token

### Response

Returns a JSON object with the following properties:

- `id`: Integer.
- `name`: String.
- 

### Response

```json
{
					  "id": 1,
            "name": "edukasi",
}
```

## Errors

This API uses the following error codes:

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Brand Not Found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

## Restore category data.

### Endpoints

### `delete {{api}}/v1/brand/{{id}}/restore`

### Header

- `Authorization` :  Bearer token

### Response

- `200 Ok`  The product has been successfully restore

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "message": "Category with ID 1 has been recovered."
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `404 Not Found`: The requested resource was not found.

```json
{
    "data": [
        {
            "messages": "Category with ID 1 not found",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.

---

## Logout User

### Endpoints

### `Post {{base_url}}/v1/logout`

### Header

- `Authorization` :  Bearer token

### Response

- `200 Ok`  The product has been successfully deleted

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
  "message": "User Already Logout"
}

```

## Errors

- `401 Unauthorized`: The API key provided was invalid or missing.

```json
{
    "data": [
        {
            "messages": "The provided credentials are incorrect.",
        },
       
    ]
}

```

- `500 Internal Server Error`: An unexpected error occurred on the server.
