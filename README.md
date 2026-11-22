CarHub

1. Project Description

CarHub is a web application for car enthusiasts that combines a car marketplace with an automotive community.

Users can explore car listings, view vehicle details, publish car advertisements, save cars to favorites, write reviews, and discover automotive events.

The project is being developed as part of a Web Programming course.

2. Technology Stack

* Frontend: HTML, CSS, JavaScript
* Backend: PHP with FlightPHP
* Database: MySQL / MariaDB
* Database access: PHP PDO
* API documentation: OpenAPI / Swagger
* Version control: Git and GitHub

3. Main Features

* Browse and explore car listings.
* View detailed information about cars.
* Register and log in (planned).
* Publish car advertisements (planned).
* Save cars to favorites (planned).
* Review and rate cars (planned).
* Discover automotive events.
* Manage user profiles (planned).

The current implementation includes the static frontend and the Milestone 2 database and DAO layer.

4. User Roles

The planned user roles are:

* Guest: Browse publicly available cars and events.
* Registered User: Manage a profile, publish advertisements, save favorite cars, and write reviews.
* Administrator: Manage users, listings, and platform content.

Authentication and role-based permissions have not yet been implemented.

Test Accounts

The SQL dump contains sample user records, but authentication has not been implemented. The sample password hashes are placeholders and cannot be used to log in.

5. Database Design

The database contains six entities:

* Users — stores user accounts and roles.
* Cars — stores car listings and vehicle information.
* Brands — stores car manufacturers.
* Favorites — connects users with their favorite cars.
* Events — stores automotive events.
* Reviews — stores user reviews and ratings for cars.

Entity Relationships

* One user can publish multiple cars.
* One brand can be associated with multiple cars.
* One user can organize multiple events.
* One user can have multiple favorite cars.
* One car can be favorited by multiple users.
* One user can write multiple reviews.
* One car can have multiple reviews.

Entity-Relationship Diagram

The database structure is illustrated in the project ERD:

docs/ERD.png

6. External API

External API integration is planned for Milestone 3. The selected API and its purpose will be documented after implementation.

7. Project Structure

* frontend/ — HTML, CSS, JavaScript, page views, and static assets.
* backend/ — PHP application, configuration, DAO, routes, services, middleware, and logs.
* database/ — SQL database export and sample data.
* docs/ — project documentation, AI usage log, and database ERD.
* AGENTS.md — project architecture and development instructions.

8. Running the Project Locally

Requirements

* XAMPP with MySQL / MariaDB.
* PHP 8.2 or compatible version.
* Git.
* A code editor.

Frontend

1. Clone the repository.
2. Open the project in your code editor.
3. Run the frontend using a local development server.
4. Open frontend/index.html.

The frontend currently uses static demonstration data.

Backend and Database Setup

1. Start MySQL in XAMPP.
2. Import the database from the project root:

/Applications/XAMPP/xamppfiles/bin/mysql -u root < database/carhub.sql

3. Create the local configuration file:

cp backend/config/config.example.php backend/config/config.php

4. Adjust the database credentials in backend/config/config.php if necessary.
5. Test the database connection:

/Applications/XAMPP/xamppfiles/bin/php backend/test_connection.php

6. Test DAO CRUD operations:

/Applications/XAMPP/xamppfiles/bin/php backend/test_dao.php

The local backend/config/config.php file is ignored by Git and must not be committed.

9. API Documentation

OpenAPI / Swagger documentation will be added when the REST API is implemented.

Swagger URL: To be added.

10. Deployment

The application has not yet been deployed.

Application URL: To be added after deployment.

11. Project Documentation

* AGENTS.md — architecture and coding instructions.
* docs/AI_LOG.md — AI tools, prompts, identified issues, and corrections.
* docs/ERD.png — database entity-relationship diagram.

12. Project Status

Completed Milestone 1

* Project structure and initial setup.
* Static frontend pages.
* SPA navigation.
* Initial database design and ERD.

Completed Milestone 2

* MySQL database with six relational entities.
* Sample database records.
* PDO database connection.
* Reusable BaseDAO class.
* Six entity-specific DAO classes.
* CRUD operations tested using PHP CLI.

Planned Milestone 3

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