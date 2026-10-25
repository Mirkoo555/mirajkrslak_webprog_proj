// ===== SPA NAVIGATION =====

document.addEventListener("DOMContentLoaded", function () {
    const appContent = document.getElementById("app-content");
    const homeContent = appContent.innerHTML;

    // ===== CAR DATA =====

    const cars = {
        1: {
            name: "BMW M4",
            category: "SPORTS COUPE",
            price: "€72,000",
            year: "2023",
            fuel: "Petrol",
            transmission: "Automatic",
            description:
                "The BMW M4 combines aggressive styling, impressive performance and everyday comfort.",
            imageClass: "car-image-one"
        },
        2: {
            name: "Audi RS5",
            category: "PERFORMANCE",
            price: "€65,000",
            year: "2022",
            fuel: "Petrol",
            transmission: "Automatic",
            description:
                "The Audi RS5 combines powerful performance, distinctive styling and a comfortable interior.",
            imageClass: "car-image-two"
        },
        3: {
            name: "Mercedes-Benz C-Class",
            category: "LUXURY",
            price: "€48,000",
            year: "2023",
            fuel: "Diesel",
            transmission: "Automatic",
            description:
                "The Mercedes-Benz C-Class offers elegant design, a refined interior and comfortable driving.",
            imageClass: "car-image-three"
        }
    };

    // ===== DISPLAY CAR DETAILS =====

    function displayCarDetails(carId) {
        const car = cars[carId];

        if (!car) {
            appContent.innerHTML = `
                <section class="featured-section">
                    <h2>Car not found</h2>
                    <a href="#cars" data-page="cars">Back to Cars</a>
                </section>
            `;
            return;
        }

        const image = appContent.querySelector(".car-details-image");
        const category = appContent.querySelector(".car-details-info .eyebrow");
        const title = appContent.querySelector(".car-details-info h1");
        const description = appContent.querySelector(".car-details-description");
        const price = appContent.querySelector(".details-price");
        const specifications = appContent.querySelectorAll(".specification strong");

        if (
            !image ||
            !category ||
            !title ||
            !description ||
            !price ||
            specifications.length < 4
        ) {
            console.error("Car details elements are missing in car-details.html.");
            return;
        }

        image.className = "car-details-image " + car.imageClass;
        category.textContent = car.category;
        title.textContent = car.name;
        description.textContent = car.description;
        price.textContent = car.price;

        specifications[0].textContent = car.year;
        specifications[1].textContent = car.fuel;
        specifications[2].textContent = car.transmission;
        specifications[3].textContent = car.category;
    }

    // ===== ABOUT PAGE =====

    function displayAboutPage() {
        appContent.innerHTML = `
            <section class="featured-section">
                <p class="eyebrow">GET TO KNOW US</p>

                <h2>About CarHub</h2>

                <p class="hero-description">
                    CarHub is a platform designed for people who love cars.
                    We bring car listings and the automotive community
                    together in one place.
                </p>

                <div class="car-grid about-grid">

                    <article class="car-card">
                        <div class="car-info">
                            <p class="car-category">01 — DISCOVER</p>
                            <h3>Explore Cars</h3>
                            <p>
                                Discover different vehicles, explore their
                                details and find your next ride.
                            </p>
                        </div>
                    </article>

                    <article class="car-card">
                        <div class="car-info">
                            <p class="car-category">02 — CONNECT</p>
                            <h3>Automotive Community</h3>
                            <p>
                                Discover automotive events and connect
                                with people who share your passion for cars.
                            </p>
                        </div>
                    </article>

                    <article class="car-card">
                        <div class="car-info">
                            <p class="car-category">03 — SAVE</p>
                            <h3>Your Favorites</h3>
                            <p>
                                Keep track of interesting vehicles and
                                save the cars you want to explore further.
                            </p>
                        </div>
                    </article>

                </div>

                <div class="about-cta">
                    <h2>Ready to Explore?</h2>

                    <p class="hero-description">
                        Start discovering vehicles and exploring
                        the automotive community.
                    </p>

                    <a href="#cars" data-page="cars" class="primary-button">
                        Explore Cars
                    </a>
                </div>
            </section>
        `;
    }

    // ===== NAVIGATE BETWEEN PAGES =====

    async function navigateToPage(page, carId = null) {
        console.log("Opening page:", page, "Car ID:", carId);

        // HOME PAGE
        if (page === "home") {
            appContent.innerHTML = homeContent;
            return;
        }

        // ABOUT PAGE
        if (page === "about") {
            displayAboutPage();
            return;
        }

        // AVAILABLE HTML PAGES
        const pages = {
            cars: "views/cars.html",
            login: "views/login.html",
            register: "views/register.html",
            "car-details": "views/car-details.html",
            events: "views/events.html"
        };

        // LOAD HTML PAGE
        if (pages[page]) {
            try {
                const response = await fetch(pages[page]);

                if (!response.ok) {
                    throw new Error("Could not load page: " + page);
                }

                appContent.innerHTML = await response.text();

                if (page === "car-details") {
                    displayCarDetails(carId);
                }
            } catch (error) {
                console.error(error);

                appContent.innerHTML = `
                    <section class="featured-section">
                        <h2>Unable to load page</h2>
                        <p>Please try again later.</p>
                    </section>
                `;
            }

            return;
        }

        // OTHER PAGES
        appContent.innerHTML = `
            <section class="featured-section">
                <h2>${page.charAt(0).toUpperCase() + page.slice(1)}</h2>
                <p>This page is coming soon.</p>
            </section>
        `;
    }

    // ===== HANDLE NAVIGATION CLICKS =====

    document.addEventListener("click", function (event) {
        const link = event.target.closest("[data-page]");

        if (!link) {
            return;
        }

        event.preventDefault();

        const page = link.dataset.page;
        const carId = link.dataset.carId || null;

        const newHash =
            page === "car-details" && carId
                ? `#car-details/${carId}`
                : `#${page}`;

        if (window.location.hash === newHash) {
            navigateToPage(page, carId);
        } else {
            window.location.hash = newHash;
        }
    });

    // ===== HANDLE BROWSER BACK/FORWARD =====

    window.addEventListener("hashchange", function () {
        const parts = window.location.hash.substring(1).split("/");
        const page = parts[0] || "home";
        const carId = parts[1] || null;

        navigateToPage(page, carId);
    });

    // ===== LOAD INITIAL PAGE =====

    const parts = window.location.hash.substring(1).split("/");
    const initialPage = parts[0] || "home";
    const initialCarId = parts[1] || null;

    navigateToPage(initialPage, initialCarId);
});