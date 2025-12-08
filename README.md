# Human Resource Management System (HRM)

A comprehensive Laravel-based Human Resource Management System for managing employees, departments, and skills.

## Features

- 👥 **Employee Management** - Create, read, update, and delete employee records
- 🏢 **Department Management** - Organize employees into departments
- 🎯 **Skills Management** - Track employee skills and expertise
- 🔍 **Advanced Search** - Search employees by name, email, or phone
- 🎨 **Modern UI** - Clean and responsive interface with dark mode support
- 📊 **Pagination** - Efficient data browsing with pagination
- 🔐 **Authentication** - Secure user authentication with Laravel Breeze

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (default) or MySQL/PostgreSQL

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd momagicbd
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

**Option A: Using SQLite (Default)**

```bash
# Create SQLite database file
touch database/database.sqlite
```

Make sure your `.env` file has:

```env
DB_CONNECTION=sqlite
```

**Option B: Using MySQL**

Update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hrm_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
# Run database migrations
php artisan migrate
```

### 6. Seed Database (Optional)

```bash
# Seed the database with sample data
php artisan db:seed
```

This will create:

- Sample departments
- Sample skills
- Sample employees with relationships

### 7. Build Assets

```bash
# Build frontend assets
npm run build

# Or for development with hot reload
npm run dev
```

### 8. Start Development Server

```bash
# Start Laravel development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Quick Setup (All-in-One)

For a quick setup, you can use the composer script:

```bash
composer setup
```

This will:

1. Install composer dependencies
2. Copy `.env.example` to `.env`
3. Generate application key
4. Run migrations
5. Install npm dependencies
6. Build assets

## Development

### Running the Application

**Option 1: Simple Development Server**

```bash
php artisan serve
```

**Option 2: With Asset Watching**

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

**Option 3: All Services (Recommended)**

```bash
composer dev
```

This runs:

- Laravel development server
- Queue worker
- Log viewer (Pail)
- Vite dev server

### Creating a User Account

**Option 1: Via Registration**

1. Visit `http://localhost:8000/register`
2. Fill in the registration form
3. Login with your credentials

**Option 2: Via Tinker**

```bash
php artisan tinker
```

```php
User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password')
]);
```

## Database Seeding

### Seed All Tables

```bash
php artisan db:seed
```

### Seed Specific Seeders

```bash
# Seed departments only
php artisan db:seed --class=DepartmentSeeder

# Seed skills only
php artisan db:seed --class=SkillSeeder

# Seed employees only
php artisan db:seed --class=EmployeeSeeder
```

### Fresh Migration with Seeding

```bash
# Drop all tables, re-run migrations, and seed
php artisan migrate:fresh --seed
```

## Usage

### Managing Employees

1. **View Employees**: Navigate to "Employees" in the navigation menu
2. **Add Employee**: Click "Add Employee" button
3. **Search**: Use the search bar to filter by name, email, or phone
4. **Filter by Department**: Use the department dropdown
5. **Edit/Delete**: Use action buttons in the employee list

### Managing Departments

1. Navigate to "Departments" in the navigation menu
2. Create, edit, or delete departments
3. View employee count per department

### Managing Skills

1. Navigate to "Skills" in the navigation menu
2. Add skills that can be assigned to employees
3. View and manage all available skills

## Project Structure

```
momagicbd/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── EmployeeController.php
│   │   │   ├── DepartmentController.php
│   │   │   └── SkillController.php
│   │   └── Requests/
│   └── Models/
│       ├── Employee.php
│       ├── Department.php
│       └── Skill.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── employees/
│       ├── departments/
│       └── skills/
└── routes/
    └── web.php
```

## Testing

```bash
# Run all tests
php artisan test

# Or using composer
composer test
```

## Technologies Used

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates, Alpine.js, Tailwind CSS
- **Database**: SQLite/MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **Build Tool**: Vite

## Key Features Explained

### Search Functionality

- Multi-field search for employees (name, email, phone)
- Real-time filtering with maintained pagination
- URL-based filtering for shareable links

### Skills Management

- Many-to-many relationship between employees and skills
- Multi-select component for assigning skills
- Visual skill badges on employee profiles

### Department Filtering

- Filter employees by department
- Pagination-aware filtering
- Combined search and department filtering

## Troubleshooting

### Database Issues

```bash
# Clear and rebuild database
php artisan migrate:fresh --seed
```

### Cache Issues

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Permission Issues (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions, please open an issue in the repository.
