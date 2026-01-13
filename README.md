# DigiSanstha v2

A modern, multi-tenant SaaS application built with Laravel 12, featuring a modular architecture with role-based access control and dynamic module management.

## 🚀 Features

- **Multi-Tenant Architecture**: Support for multiple companies with isolated data and configurations
- **Modular System**: Dynamic module and submodule management with granular access control
- **Role-Based Access Control (RBAC)**: 
  - Super Admin: Full system access and management capabilities
  - Client: Company-specific access based on assigned modules
- **Permission Management**: Fine-grained permission system for modules and submodules
- **Modern UI**: Built with FlyonUI components, Tailwind CSS, and Alpine.js
- **Responsive Design**: Mobile-first approach with modern UI/UX

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x and npm
- MySQL/PostgreSQL/SQLite
- Web server (Apache/Nginx) or PHP built-in server

## 🛠️ Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd digiSanstha-v2
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your `.env` file**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

   Or for development:
   ```bash
   npm run dev
   ```

## 🚦 Running the Application

### Development Mode

Run the development server with all services:
```bash
composer dev
```

This command runs:
- Laravel development server
- Queue worker
- Log viewer (Pail)
- Vite dev server

### Production Mode

1. **Build assets**
   ```bash
   npm run build
   ```

2. **Start the server**
   ```bash
   php artisan serve
   ```

   Or configure your web server (Apache/Nginx) to point to the `public` directory.

## 📁 Project Structure

```
digiSanstha-v2/
├── app/
│   ├── Helpers/          # Helper classes (MenuHelper, etc.)
│   ├── Http/
│   │   ├── Controllers/   # Application controllers
│   │   │   ├── Admin/     # Admin-specific controllers
│   │   │   └── ...
│   │   ├── Middleware/    # Custom middleware
│   │   └── Requests/      # Form request validation
│   ├── Models/           # Eloquent models
│   │   ├── User.php
│   │   ├── Company.php
│   │   ├── Module.php
│   │   ├── Submodule.php
│   │   └── Permission.php
│   └── Providers/        # Service providers
├── database/
│   ├── migrations/       # Database migrations
│   └── seeders/         # Database seeders
├── resources/
│   ├── views/           # Blade templates
│   ├── css/             # Stylesheets
│   └── js/              # JavaScript files
├── routes/
│   ├── web.php          # Web routes
│   └── auth.php         # Authentication routes
└── public/              # Public assets
```

## 🔐 User Types

### Super Admin
- Full system access
- Manage companies, modules, submodules, and permissions
- Assign modules/submodules to companies
- Manage all users

### Client
- Company-specific access
- Access only assigned modules/submodules
- Permission-based feature access

## 🎯 Core Concepts

### Modules
Modules are top-level features that can be assigned to companies. Each module can have:
- Name, slug, icon, description
- Order for display
- Active/inactive status
- Custom configuration (JSON)

### Submodules
Submodules are features within modules. They can be:
- Assigned independently to companies
- Have their own permissions
- Configured per company

### Companies
Companies represent tenants in the multi-tenant system:
- Each company can have multiple users
- Modules and submodules are assigned per company
- Each assignment can have custom configuration

### Permissions
Permissions provide fine-grained access control:
- Can be associated with modules or submodules
- Assigned to users per company
- Checked via middleware or model methods

## 🧪 Testing

Run tests using Pest:
```bash
composer test
```

Or using PHPUnit directly:
```bash
php artisan test
```

## 📝 Available Commands

- `php artisan migrate` - Run database migrations
- `php artisan db:seed` - Seed the database
- `php artisan serve` - Start development server
- `composer dev` - Start all development services
- `composer test` - Run tests
- `npm run dev` - Start Vite dev server
- `npm run build` - Build production assets

## 🛡️ Security

- Password hashing using Laravel's built-in hashing
- CSRF protection on all forms
- Authentication middleware for protected routes
- User type and permission checks via middleware
- SQL injection protection via Eloquent ORM

## 📦 Technologies Used

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Tailwind CSS 4, Alpine.js, FlyonUI
- **Build Tool**: Vite
- **Testing**: Pest PHP
- **Icons**: Iconify
- **Additional Libraries**: 
  - FullCalendar
  - ApexCharts
  - Flatpickr
  - Swiper

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📧 Support

For support, please open an issue in the repository.

---

Built with ❤️ using Laravel and FlyonUI
