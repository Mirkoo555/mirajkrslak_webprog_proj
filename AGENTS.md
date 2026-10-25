# AGENTS.md

## Project Description

CarHub is a web application for car enthusiasts that combines a car marketplace
with an automotive community.

Users will be able to browse car listings, publish advertisements, save cars
to favorites, write reviews, and discover automotive events.

## Technology Stack

- Frontend: HTML, CSS, JavaScript
- Backend: PHP with FlightPHP
- Database: MySQL
- Database access: PHP PDO
- API documentation: OpenAPI / Swagger

## Project Architecture

The application uses a Single-Page Application (SPA) frontend and a REST API
backend.

The frontend and backend must remain separate.

The frontend uses HTML, CSS, and JavaScript. Navigation between pages should
not require a full page reload.

The backend will use FlightPHP to provide REST API endpoints. Business logic
will be placed in services, and database operations will be handled by DAO
classes using PHP PDO.

## Folder Structure

- `frontend/css/` — stylesheet files.
- `frontend/js/` — JavaScript files.
- `frontend/views/` — HTML page templates.
- `frontend/assets/` — static assets such as images and icons.
- `backend/routes/` — REST API routes.
- `backend/services/` — application business logic.
- `backend/dao/` — database access objects.
- `backend/middleware/` — reusable middleware.
- `backend/config/` — configuration files.
- `backend/logs/` — application logs; must not be committed to Git.
- `docs/` — project documentation and ERD.

## Database Entities

The planned database entities are:

- Users
- Cars
- Brands
- Favorites
- Events
- Reviews

The ERD is stored in `docs/ERD.png`.

## Coding Rules

- Use clear and descriptive variable and function names.
- Keep frontend and backend code separate.
- Keep JavaScript navigation consistent with the existing SPA structure.
- Reuse existing CSS classes and design variables where appropriate.
- Keep the interface responsive on desktop and mobile devices.
- Do not introduce a database connection or backend integration during
  Milestone 1.
- Do not introduce additional libraries without a clear need.
- Do not commit credentials, API keys, secrets, or log files.
- Keep documentation updated when project architecture changes.

## Current Milestone

Milestone 1 focuses on project setup, static frontend pages, and database
planning.

Do not implement database operations, authentication logic, or REST API
endpoints until the relevant milestone.