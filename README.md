# API Documentation

**Project Name:** API – C01
**Architecture:** RESTful API
**Authentication:** Laravel Sanctum
**Data Format:** JSON
**Base URL:** `{{BASE_URL}}`

---

## 1. Overview

The **API – C01** provides a secure and scalable backend for user authentication and task management. The API follows RESTful principles and is designed to be easily consumable by web, mobile, and third-party applications.

All protected endpoints are secured using **Laravel Sanctum**, ensuring token-based authentication. Requests and responses are standardized in **JSON format**, enabling predictable integration and easy debugging.

The API is organized into modular sections:

* Authentication (Auth)
* Task Management
* Supporting/Public APIs (Categories, Testing)

---

## 2. Authentication & Security

### Authentication Method

This API uses **Laravel Sanctum** for authentication. After successful login, users receive an **access token**, which must be included in the request headers for all protected routes.

### Required Headers (Authenticated Requests)

```
Authorization: Bearer {access_token}
Content-Type: application/json
Accept: application/json
```

If the token is missing, invalid, or expired, the API will return a `401 Unauthorized` response.

---

## 3. Authentication Module

### 3.1 Register User

**Endpoint:**
`POST /v1/register`

**Description:**
Creates a new user account.

**Request Body (JSON):**

```json
{
  "name": "Jabed",
  "email": "info1@jabed.com",
  "password": "123456"
}
```

**Response:**

* Success message
* User information
* Authentication token (if configured)

---

### 3.2 Login User

**Endpoint:**
`POST /api/v1/login`

**Description:**
Authenticates a user and returns an access token.

**Request Body (JSON):**

```json
{
  "email": "info@jabed.com",
  "password": "123456"
}
```

**Response:**

* Access token
* Authenticated user details

---

### 3.3 Logout User

**Endpoint:**
`POST /v1/logout`

**Authentication:** Required

**Description:**
Invalidates the current access token and logs the user out.

**Headers:**

```
Authorization: Bearer {access_token}
Accept: application/json
```

---

## 4. Task Management Module

The Task Management module allows authenticated users to create, view, update, and delete tasks. Each task is associated with the authenticated user to ensure data ownership and security.

### Common Features

* Token-protected endpoints
* User-based task ownership
* Support for file uploads (task images)

---

### 4.1 Create Task

**Endpoint:**
`POST /v1/tasks/create`

**Authentication:** Required

**Request Type:** `multipart/form-data`

**Form Data Parameters:**

| Field       | Type | Description         |
| ----------- | ---- | ------------------- |
| title       | text | Task title          |
| description | text | Task description    |
| image       | file | Optional task image |

**Response:**

* Task creation confirmation
* Task details

---

### 4.2 Get All Tasks

**Endpoint:**
`GET /v1/get-all-task`

**Authentication:** Required

**Description:**
Retrieves all tasks belonging to the authenticated user.

**Response:**

* List of tasks
* Pagination (if enabled)

---

### 4.3 Edit Task (Fetch Single Task)

**Endpoint:**
`GET /v1/tasks/edit/{id}`

**Authentication:** Required

**Description:**
Fetches task details for editing.

**URL Parameter:**

* `id` → Task ID

**Response:**

* Task information

---

### 4.4 Update Task

**Endpoint:**
`POST /v1/tasks/update/{id}`

**Authentication:** Required

**Request Body (JSON):**

```json
{
  "title": "The Title",
  "description": "test description update"
}
```

**Response:**

* Updated task data
* Success message

---

### 4.5 Delete Task

**Endpoint:**
`DELETE /api/v1/tasks/delete/{id}`

**Authentication:** Recommended

**Description:**
Deletes a task by ID.

**Response:**

* Deletion confirmation message

---

## 5. Categories Module

### 5.1 Get All Categories

**Endpoint:**
`GET /api/v1/categories`

**Description:**
Returns a list of all available categories.

**Authentication:** Not required

---

### 5.2 Categories with Products

**Endpoint:**
`GET /api/v1/categories-with-products`

**Description:**
Fetches categories along with their associated products.

**Authentication:** Not required

---

## 6. Environment Variables

The following Postman environment variables are used:

| Variable       | Description                       |
| -------------- | --------------------------------- |
| `BASE_URL`     | Base URL of the API               |
| `access_token` | Bearer token received after login |

---

## 7. Error Handling

The API follows standard HTTP response codes:

| Status Code | Meaning          |
| ----------- | ---------------- |
| 200         | Success          |
| 201         | Resource created |
| 401         | Unauthorized     |
| 403         | Forbidden        |
| 404         | Not Found        |
| 422         | Validation Error |
| 500         | Server Error     |

Error responses are returned in JSON format with clear messages to aid debugging.

---

## 8. Conclusion

This API is designed to be **secure, modular, and developer-friendly**, making it suitable for production-ready applications. With Laravel Sanctum-based authentication, consistent request/response structures, and well-defined modules, it supports scalable frontend and third-party integrations.

For testing and exploration, the provided Postman collection serves as the primary reference and validation tool for all endpoints.

---

Jabed Hosen
