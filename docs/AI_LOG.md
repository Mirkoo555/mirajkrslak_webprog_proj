# AI Usage Log — CarHub

## Milestone 1: Initial Setup, Static Frontend and Database Planning

### 1. AI Tools Used

- Tool: ChatGPT
- Purpose: Frontend development assistance, HTML and CSS styling,
  JavaScript SPA navigation, project documentation, and database planning.

### 2. Main Prompts and Tasks

The following tasks were completed with AI assistance:

- Create a responsive homepage for the CarHub automotive marketplace
  and community.
- Create static Login and Register pages.
- Implement SPA navigation using JavaScript and the Fetch API.
- Create the Cars, Car Details, Events, and About pages.
- Implement navigation between car listings and individual car details.
- Plan the database entities and their relationships.
- Draft the README.md and AGENTS.md documentation.
- Improve the responsive styling and visual consistency of the frontend.

### 3. Issues Identified and Corrected

#### Case 1: Login Page Was Not Loading Correctly

**What was wrong:**

The JavaScript navigation displayed placeholder text instead of loading
the actual Login page from `frontend/views/login.html`.

**How the problem was identified:**

The Login page displayed placeholder content instead of the expected
form with email and password fields.

**How it was fixed:**

The navigation code was updated to fetch `views/login.html` and insert
the returned HTML into the `app-content` element.

**Verification:**

The Login form was manually checked in the browser after saving the
JavaScript file and refreshing the application.

#### Case 2: Register Page Was Not Loading Correctly

**What was wrong:**

The Register navigation displayed placeholder content instead of the
actual form stored in `frontend/views/register.html`.

**How the problem was identified:**

Clicking Register displayed placeholder content even though the
registration form existed in the project.

**How it was fixed:**

The navigation code was updated to fetch `views/register.html` and
insert the returned HTML into the `app-content` element.

**Verification:**

The Register form was manually checked in the browser after the change.

#### Case 3: Every Car Details Link Opened the BMW M4

**What was wrong:**

Clicking Details for the Audi RS5 or Mercedes-Benz C-Class opened the
same details page with BMW M4 information.

**How the problem was identified:**

The developer tested the Details links for different cars and noticed
that the displayed vehicle did not match the selected listing.

**How it was fixed:**

Unique car IDs were added to the listing links. The JavaScript navigation
was updated to read the selected car ID and display the corresponding
car data on the details page.

**Verification:**

The developer tested the car listings and confirmed that the BMW, Audi,
and Mercedes displayed their respective names, prices, and specifications.

### 4. Human Review and Verification

The developer manually tested the frontend in a browser after changes
were made.

The following pages and interactions were checked:

- Home page.
- Explore Cars page.
- BMW, Audi, and Mercedes details.
- Login page.
- Register page.
- Events page.
- About page.
- SPA navigation between pages.

The developer identified problems through browser testing and requested
corrections when the displayed content did not match the expected result.

### 5. Limitations

The frontend currently uses static demonstration data.

Authentication, database operations, backend integration, and functional
user account management have not yet been implemented.

The car details are selected from static JavaScript data rather than
being retrieved from a database.

External API integration and REST API documentation are planned for
later project milestones.

### 6. AI-Assisted Development Notes

AI-generated code was reviewed and tested by the developer.

When the initial implementation did not behave as expected, the developer
reported the issue and tested the subsequent correction.

The project documentation was updated to describe the current milestone
and distinguish implemented frontend features from planned functionality.