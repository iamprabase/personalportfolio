# Jessica Jacobson Author Website

This project is a web application for the author Jessica Jacobson. It includes features such as article management, user authentication, language switching, and a comment system.

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
├── .env                   # Environment variables
├── composer.json          # Composer dependencies
└── README.md              # Project documentation
```

---

## Requirements

- **PHP**: Version 8.0 or higher
- **Composer**: Dependency manager for PHP
- **MySQL**: Database for storing application data
- **Web Server**: Apache or Nginx

---

## Installation

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

## Configuration

### Environment Variables

The application uses a `.env` file for configuration. Below are the key variables:

| Variable         | Description                          |
|-------------------|--------------------------------------|
| `DB_HOST`        | Database host (e.g., `127.0.0.1`)   |
| `DB_NAME`        | Database name                       |
| `DB_USER`        | Database username                   |
| `DB_PASS`        | Database password                   |
| `APP_DEBUG`      | Enable/disable debug mode           |
| `META_TITLE`     | Default meta title for the website  |
| `META_DESCRIPTION` | Default meta description          |
| `CANONICAL_URL`  | Base URL of the website             |
| `LANGUAGE`       | Default language (`en` or `fr`)     |

---

## Key Features

### Language Switching

- Users can switch between English and French using the `/change-language` route.
- The selected language is stored in the session.

### Admin Dashboard

- Accessible at `/admin`.
- Requires admin authentication.
- Features include:
  - Article management (create, edit, delete).
  - Comment moderation.

### Authentication

- Login: `/auth/login`
- Registration: `/auth/register`
- Logout: `/auth/logout`

---

## Deployment

1. **Set Up a Web Server**:
   - Configure Apache or Nginx to point to the `public/` directory as the document root.

2. **Set Up Environment Variables**:
   - Ensure the `.env` file is configured for the production environment.

3. **Enable Debugging (Optional)**:
   - Set `APP_DEBUG=false` in the `.env` file for production.

4. **Run Database Migrations**:
   - Import the SQL schema into the production database.

5. **Restart the Server**:
   - Restart your web server to apply changes.

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