# Jessica Jacobson Author Website

This project is a web application for the author Jessica Jacobson. It includes features such as article management, user authentication, language switching, and a comment system.

---

## Deliverables

1. **Complete CMS Source Code**:
   - Fully structured and commented source code for the CMS.
   - Organized into controllers, models, views, middleware, and configuration files.

2. **SQL Database Creation Script**:
   - A script to create the required database schema for the application.

3. **Documentation**:
   - Installation and environment setup guide.
   - Template integration guide.
   - SEO settings guide.
   - Language/content management overview.

---

## Features

- **Home Page**: Displays a list of articles.
- **Article Management**: Create, edit, and delete articles (admin only).
- **User Authentication**: Login, registration, and profile management.
- **Comment System**: Users can comment on articles.
- **Language Support**: Switch between English and French.
- **Admin Dashboard**: Manage articles and comments.

---

## Project Structure

```
htdocs/
├── public/                # Publicly accessible files (index.php, assets, etc.)
├── src/                   # Application source code
│   ├── Controllers/       # Application controllers
│   ├── Middleware/        # Middleware for authentication and admin access
│   ├── Models/            # Database models
│   ├── Views/             # Twig templates
│   ├── Config/            # Configuration files
│   └── web/               # Route definitions
├── database/              # SQL database creation scripts
│   └── schema.sql         # Database schema
├── .env                   # Environment variables
├── composer.json          # Composer dependencies
└── README.md              # Project documentation
```

---

## Installation and Environment Setup

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/your-repo/jessicajacobson.git
   cd jessicajacobson
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   ```

3. **Set Up Environment Variables**:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database credentials and other settings.

4. **Run Database Migrations**:
   - Import the SQL schema into your MySQL database:
     ```bash
     mysql -u root -p jessicajacobson < database/schema.sql
     ```

5. **Start the Development Server**:
   ```bash
   php -S localhost:8000 -t public
   ```

6. **Access the Application**:
   - Open your browser and navigate to `http://localhost:8000`.

---

## Template Integration Guide

1. **Twig Templates**:
   - All templates are located in the `src/Views/` directory.
   - Use Twig syntax to render dynamic content in templates.

2. **Customizing Templates**:
   - Modify existing templates (e.g., `layout.twig`, `article.twig`) to match the desired design.
   - Add new templates for additional pages as needed.

3. **Assets**:
   - Place CSS, JavaScript, and image files in the `public/assets/` directory.
   - Reference assets in templates using the base URL.

---

## SEO Settings Guide

1. **Meta Information**:
   - Default meta title and description are configured in the `.env` file:
     ```env
     META_TITLE="Home - Author Website"
     META_DESCRIPTION="Welcome to the author website"
     ```

2. **Canonical URL**:
   - Set the base URL of the website in the `.env` file:
     ```env
     CANONICAL_URL="http://example.com/"
     ```

3. **Dynamic Meta Tags**:
   - Meta tags for individual pages (e.g., articles) can be set dynamically in controllers.

---

## Language/Content Management Overview

1. **Language Switching**:
   - Users can switch between English and French using the `/change-language` route.
   - The selected language is stored in the session.

2. **Content Localization**:
   - Store localized content (e.g., article titles, descriptions) in the database with a `language` column.
   - Query content based on the selected language.

3. **Default Language**:
   - Set the default language in the `.env` file:
     ```env
     LANGUAGE="en"
     ```

---

## Troubleshooting

### Common Issues

1. **Database Connection Error**:
   - Ensure the database credentials in the `.env` file are correct.
   - Verify that the database server is running.

2. **Route Not Found**:
   - Ensure the requested route is defined in `src/web/Routes.php`.

3. **CSRF Token Mismatch**:
   - Ensure the CSRF middleware is properly configured.
   - Clear your browser cache and try again.

---

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

---

## Contact

For support or inquiries, please contact:

- **Name**: Jessica Jacobson
- **Email**: contact@jessicajacobson.com
- **Website**: [jessicajacobson.com](http://jessicajacobson.com)
