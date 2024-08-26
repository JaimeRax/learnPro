# LearnPro

![PHP](https://img.shields.io/badge/PHP-8.0%2B-blue.svg)
![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)

**LearnPro** is a comprehensive platform designed to streamline the administrative and academic management of educational institutions. This platform facilitates key functions such as student enrollment, course assignment, fee management, grade tracking, and reporting.

## Features

- **Student Enrollment**: Easy management of student admissions and registrations.
- **Course Assignment**: Automated assignment of courses to students and teachers.
- **Payment Processing**: Efficient management of student fees and billing cycles.
- **Grade Tracking**: Simplified input and management of student grades by teachers.
- **Reporting**: Generate detailed reports on student performance and financials.

## Installation

### Prerequisites

- PHP 8.0+
- Composer
- MySQL or MariaDB
- Node.js & npm

### Steps

1. Clone the repository:

    ```bash
    git clone git@github.com:JaimeRax/learnPro.git
    ```

2. Navigate to the project directory:

    ```bash
    cd learnpro
    ```

3. Install the dependencies:

    ```bash
    composer install
    npm install
    ```

4. Set up the environment file:

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database and mail server details.

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Run database migrations and seeders:

    ```bash
    php artisan migrate --seed
    ```

7. Start the development server:

    ```bash
    php artisan serve
    ```

## Usage

- Access the platform by visiting `http://localhost:8000` in your browser.
- Admin and teacher users can log in with their credentials to manage the system.

## Contributing

If you wish to contribute, please fork the repository and submit a pull request. Ensure your code adheres to the project's coding standards.

<!--## License-->
<!---->
<!--This project is licensed under the MIT License. See the `LICENSE` file for more details.-->

