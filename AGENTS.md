AGENTS.md

Project Description

CarHub is a web application for car enthusiasts that combines a car marketplace with an automotive community.

Users can browse car listings, view vehicle details, publish advertisements, save cars to favorites, write reviews, and discover automotive events.

Technology Stack

* Frontend: HTML, CSS, JavaScript
* Backend: PHP 8.2
* Database: MySQL / MariaDB
* Database access: PHP PDO
* Backend framework: FlightPHP (planned for Milestone 3)
* API documentation: OpenAPI / Swagger (planned for Milestone 3)
* Version control: Git and GitHub

Project Architecture

The application uses a Single-Page Application (SPA) frontend and a REST API backend.

The frontend and backend must remain separate.

The frontend uses HTML, CSS, and JavaScript. Navigation between pages should not require a full page reload.

The backend follows a layered architecture:

* Routes handle HTTP requests.
* Services contain business logic and validation.
* DAO classes handle database operations using PDO.
* Configuration files contain database and application settings.

The DAO layer currently uses a reusable BaseDAO class and individual DAO classes for each database entity.

Folder Structure

* frontend/css/ — stylesheet files.
* frontend/js/ — JavaScript files.
* frontend/views/ — HTML page templates.
* frontend/assets/ — static assets such as images and icons.
* backend/config/ — database and application configuration.
* backend/dao/ — database access objects.
* backend/services/ — application business logic.
* backend/routes/ — REST API routes.
* backend/middleware/ — reusable middleware.
* backend/logs/ — application logs; must not be committed to Git.
* database/ — SQL database export and sample data.
* docs/ — project documentation and ERD.

Database Entities

The implemented database contains six entities:

* Users
* Cars
* Brands
* Favorites
* Events
* Reviews

The database schema and sample records are stored in database/carhub.sql.

The ERD is stored in docs/ERD.png.

Database and DAO Rules

* Use PHP PDO for database access.
* Use prepared statements for queries involving user-supplied values.
* Reuse common CRUD operations through BaseDAO.
* Each entity must have its own DAO class.
* Only explicitly allowed fields may be used in dynamic INSERT and UPDATE statements.
* Database credentials must be stored in the local backend/config/config.php file.
* Commit backend/config/config.example.php, never the local configuration file.
* Never commit passwords, API keys, or other secrets.

Coding Rules

* Use clear and descriptive variable and function names.
* Keep frontend and backend code separate.
* Keep JavaScript navigation consistent with the existing SPA structure.
* Reuse existing CSS classes and design variables where appropriate.
* Keep the interface responsive on desktop and mobile devices.
* Update documentation when project architecture changes.
* Test PHP syntax after creating or modifying PHP files.
* Verify database operations using the DAO test script.

Current Project Status

Milestone 1 — Completed

* Project setup.
* Static frontend pages.
* SPA navigation.
* Initial database design and ERD.

Milestone 2 — Completed

* MySQL database with six relational entities.
* Sample database records.
* PDO database connection.
* Reusable BaseDAO class.
* Individual DAO classes for all six entities.
* CRUD operations tested using PHP CLI.
* SQL database export created in database/carhub.sql.
* Local database configuration separated from the committed example configuration.

Milestone 3 — Planned

* Service layer and business validation.
* FlightPHP REST API routes.
* OpenAPI / Swagger documentation.
* External API integration.

Planned Later Work

* Authentication and authorization.
* JWT-based authentication.
* Middleware and application logging.
* Full frontend and backend integration.
* Deployment.