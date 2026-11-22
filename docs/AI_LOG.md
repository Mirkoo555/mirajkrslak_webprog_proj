AI Usage Log — CarHub

Milestone 1: Initial Setup, Static Frontend and Database Planning

1. AI Tools Used

* Tool: ChatGPT
* Purpose: Frontend development assistance, HTML and CSS styling, JavaScript SPA navigation, project documentation, and database planning.

2. Main Prompts and Tasks

The following tasks were completed with AI assistance:

* Create a responsive homepage for the CarHub automotive marketplace and community.
* Implement SPA navigation using JavaScript and the Fetch API.
* Implement navigation between car listings and individual car details.
* Plan the database entities and their relationships.
* Draft the README.md and AGENTS.md documentation.
* Improve the responsive styling and visual consistency of the frontend.

3. Issues Identified and Corrected

Case 1: Login Page Was Not Loading Correctly

What was wrong:

The JavaScript navigation displayed placeholder text instead of loading the actual Login page from frontend/views/login.html.

How the problem was identified:

The Login page displayed placeholder content instead of the expected form with email and password fields.

How it was fixed:

The navigation code was updated to fetch views/login.html and insert the returned HTML into the app-content element.

Verification:

The Login form was manually checked in the browser after saving the JavaScript file and refreshing the application.

Case 2: Register Page Was Not Loading Correctly

What was wrong:

The Register navigation displayed placeholder content instead of the actual form stored in frontend/views/register.html.

How the problem was identified:

Clicking Register displayed placeholder content even though the registration form existed in the project.

How it was fixed:

The navigation code was updated to fetch views/register.html and insert the returned HTML into the app-content element.

Verification:

The Register form was manually checked in the browser after the change.

Case 3: Every Car Details Link Opened the BMW M4

What was wrong:

Clicking Details for the Audi RS5 or Mercedes-Benz C-Class opened the same details page with BMW M4 information.

How the problem was identified:

The developer tested the Details links for different cars and noticed that the displayed vehicle did not match the selected listing.

How it was fixed:

Unique car IDs were added to the listing links. The JavaScript navigation was updated to read the selected car ID and display the corresponding car data on the details page.

Verification:

The developer tested the car listings and confirmed that the BMW, Audi, and Mercedes displayed their respective names, prices, and specifications.

4. Human Review and Verification

The developer manually tested the frontend in a browser after changes were made.

The following pages and interactions were checked:

* Home page.
* Explore Cars page.
* BMW, Audi, and Mercedes details.
* Login page.
* Register page.
* Events page.
* About page.
* SPA navigation between pages.

The developer identified problems through browser testing and requested corrections when the displayed content did not match the expected result.

5. Limitations

The frontend uses static demonstration data.

Authentication, database integration, and functional user account management were not implemented during this milestone.

The car details were selected from static JavaScript data rather than retrieved from a database.

External API integration and REST API documentation were planned for later project milestones.

6. AI-Assisted Development Notes

AI-generated code was reviewed and tested by the developer.

When the initial implementation did not behave as expected, the developer reported the issue and tested the subsequent correction.

The project documentation was updated to describe the implemented frontend features and distinguish them from planned functionality.

⸻

Milestone 2: Database and DAO Layer

1. AI Tools Used

* ChatGPT: Used for assistance with PHP database-related files, PDO connectivity, DAO structure, and database implementation.

2. Main Tasks

AI assistance was used during the implementation of the database connection and DAO layer.

The main tasks included:

* Creating PHP files for database connectivity.
* Understanding how PDO connects PHP with MySQL.
* Structuring the reusable BaseDAO class and individual DAO classes.
* Reviewing database-related code and resolving implementation issues.

3. Issues Identified and Corrected

During implementation, some initial code and configuration instructions required adjustments before they worked correctly.

The developer used PHP error messages and test results to identify problems and verify corrections.


Case 1: DAO Implementation and Database Operations

What was wrong:

Some initial DAO implementation details required correction to ensure that the CRUD operations worked consistently with the database tables and their primary keys.

How the problem was identified:

The PHP syntax checks and CRUD tests were used to identify implementation issues.

How it was fixed:

The DAO structure and database operations were reviewed and adjusted.

Verification:

CRUD tests subsequently passed for all six database entities.

4. Testing and Verification

The database connection was tested using PHP CLI.

CRUD operations were tested for all six database entities. The tests covered:

* Creating records.
* Reading records.
* Updating records.
* Deleting records.

The SQL database export was also checked to confirm that the database structure and sample records were included.

5. Developer Review

AI suggestions were reviewed during implementation and adjusted when necessary.

The developer checked the PHP files, database connection, and CRUD test results to verify that the implementation worked as expected.



⸻

Milestone 3: Business Logic, REST API and External API Integration

1. AI Tools Used

* ChatGPT: Used for assistance with PHP service classes, FlightPHP controllers and routes, REST API implementation, OpenAPI documentation, external API integration, and frontend functionality.

2. Main Tasks

AI assistance was used during the implementation of the business logic and presentation layers.

The main tasks included:

* Creating service classes for Users, Cars, Brands, Favorites, Events, and Reviews.
* Implementing input validation and business rules in the service layer.
* Implementing CRUD REST API endpoints using FlightPHP.
* Creating controllers for all six database entities.
* Returning JSON responses with appropriate HTTP status codes.
* Creating OpenAPI 3.0 documentation and a Swagger UI page.
* Integrating the NHTSA vPIC API to retrieve vehicle models by make.
* Implementing the Vehicle Model Finder feature in the frontend.
* Handling external API timeouts, errors, and logging.

3. Issues Identified and Corrected

During implementation, PHP errors, API responses, validation results, and frontend behavior were checked. Some implementation details required adjustments before the expected functionality worked correctly.

Case 1: Service Layer Validation

What was wrong:

The application needed validation rules to prevent invalid data from being passed to the DAO layer.

How the problem was addressed:

Validation was implemented in the service classes for all six entities. The rules cover required fields, valid email addresses, password length, positive IDs, vehicle year and price, event dates, and review ratings. Duplicate favorites are also checked.

Verification:

Service tests were created for all six entities to check CRUD operations and validation behavior.

Case 2: REST API Responses and Error Handling

What was wrong:

The API needed consistent responses for successful requests, invalid input, missing records, and unexpected errors.

How the problem was addressed:

FlightPHP controllers were implemented for all six entities. The controllers return JSON responses and use appropriate HTTP status codes, including 200, 201, 400, 404, and 500. User responses were also adjusted to avoid exposing stored passwords.

Verification:

CRUD endpoints were tested using HTTP requests. Successful operations and expected error responses were checked.

Case 3: External Vehicle API Integration

What was wrong:

The frontend needed a way to retrieve vehicle models from an external data source instead of relying only on static vehicle information.

How the problem was addressed:

The NHTSA vPIC API was integrated through a PHP service using cURL. A Vehicle Model Finder interface was added to the Cars page, allowing users to search for models by vehicle make.

Timeout handling, connection error handling, HTTP status checks, and error logging were implemented.

Verification:

The BMW search was tested and returned 265 models. A request without a make parameter returned HTTP 400. The frontend was also manually checked in the browser.

4. Documentation and Testing

OpenAPI 3.0 documentation was added in docs/openapi.yaml, covering the application endpoints and the external vehicle lookup endpoint.

A Swagger UI page was added in docs/api-docs.html.

PHP syntax checks were performed on the controllers, services, and service test files. JavaScript syntax was also checked.

CRUD operations were tested for all six entities. External API responses and frontend functionality were checked separately.

5. Developer Review

AI suggestions and generated code were reviewed during implementation.

The developer ran PHP syntax checks, service tests, HTTP requests, and browser tests to verify the implementation.

When issues were identified, the implementation was adjusted and tested again.

6. Limitations

The external vehicle lookup depends on the availability of the NHTSA vPIC API and an active internet connection.

The application includes the business logic and REST API implementation, while authentication and role-based authorization are planned for a later milestone.
