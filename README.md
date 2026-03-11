# Fruits and Vegetables API

A containerized PHP API for managing fruits and vegetables.

## 🚀 How to Run

**1. Clone & Configure**

```bash
git clone <repository_url>
cd fruits-and-vegetables

```

Create a `.env` file in the root directory (adjust ports/credentials as needed):

```ini
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=fruits_db
MYSQL_USER=user
MYSQL_PASSWORD=password
MYSQL_PORT=3306
NGINX_PORT=8080

```

**2. Start the Application**

```bash
docker-compose up -d --build

```

*The API is now accessible at `http://localhost:8080` (or your configured `NGINX_PORT`).*

**3. Stop or Reset**

```bash
docker-compose down      # Stops the containers safely
docker-compose down -v   # Stops containers AND wipes the database volume

```

---

## 🧪 Running Tests

This project uses PHPUnit for unit testing. You can run the test suite directly inside the Docker container:

```bash
docker-compose exec app bin/phpunit

```

Alternatively, if you are working directly inside the `application` directory locally:

```bash
cd application
bin/phpunit

```

---

## 📂 Source Code Structure

```text
.
├── application/             # Core PHP application
│   ├── src/                 # Source code (Symfony/Modern PHP)
│   │   ├── Controller/      # API Endpoints
│   │   ├── Dto/             # Data Transfer Objects & Request Payloads
│   │   ├── Entity/          # Doctrine Database Entities
│   │   ├── Enum/            # Strongly typed enumerations (e.g., ProductTypeEnum)
│   │   ├── Repository/      # Database query logic
│   │   └── Service/         # Core business logic and managers
│   └── tests/               # PHPUnit test suites
├── nginx/                   # Nginx reverse proxy configurations
├── docker-compose.yml       # Docker services definition (web, app, db)
└── Dockerfile               # PHP image build instructions

```

---

## 🔌 API Documentation

All product endpoints are routed dynamically based on the product type.

* **Valid `{type}` parameters:** `fruit`, `vegetable`

### Product Management

| Method | Endpoint | Description | Query / Payload |
| --- | --- | --- | --- |
| **GET** | `/api/products/{type}` | List all products of a specific type. | - |
| **GET** | `/api/products/{type}/search` | Search for products by name. | `?query=search_term` |
| **POST** | `/api/products/{type}` | Create a new product. | JSON object (name, quantity, etc.) |
| **DELETE** | `/api/products/{type}/{id}` | Delete a product by its ID. | - |

### Batch Operations

| Method | Endpoint | Description | Query / Payload |
| --- | --- | --- | --- |
| **POST** | `/api/import` | Batch import products. | JSON payload or `multipart/form-data` file upload. |

---
