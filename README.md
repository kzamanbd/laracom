# LaraEcom - Laravel E-commerce Platform

<p align="center">
    <img src="public/favicon.png" width="100" alt="LaraEcom Logo">
</p>

A modern, full-featured e-commerce platform built with Laravel 12, Livewire 3, and Tailwind CSS 4. LaraEcom provides a complete online shopping solution with a beautiful storefront and comprehensive admin features.

## ✨ Features

### 🛍️ Storefront

- **Modern Design**: Clean, responsive design built with Tailwind CSS 4
- **Product Catalog**: Browse products with categories, search, and filtering
- **Shopping Cart**: Real-time cart management with Livewire
- **Quick View**: Product quick view modal for fast browsing
- **Wishlist**: Save favorite products for later
- **Checkout Process**: Streamlined checkout with multiple payment options
- **User Account**: Customer registration, login, and account management
- **Blog System**: Content management with blog posts
- **SEO Friendly**: Optimized URLs and meta tags

### 🎛️ Admin Features

- **Product Management**: Full CRUD operations for products
- **Category Management**: Organize products with hierarchical categories
- **Order Management**: Track and manage customer orders
- **Customer Management**: User account administration
- **Media Management**: Image upload and management system
- **Tax & Shipping**: Configure tax rates and shipping options
- **Content Management**: Manage blog posts and static pages

### 🚀 Technology Stack

- **Backend**: Laravel 12 with PHP 8.3+
- **Frontend**: Livewire 3 + Volt for dynamic interactions
- **Styling**: Tailwind CSS 4 with modern design system
- **Database**: SQLite (development) / MySQL (production)
- **Testing**: Pest PHP for comprehensive testing
- **Code Quality**: Laravel Pint for code formatting

## 📋 Requirements

- PHP 8.3 or higher
- Composer
- Node.js 18+ and npm
- SQLite (for development) or MySQL/PostgreSQL

## 🚀 Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/kzamanbd/laracom.git
   cd laracom
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install Node.js dependencies**

   ```bash
   npm install
   ```

4. **Environment setup**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**

   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

6. **Build assets**

   ```bash
   npm run build
   # or for development
   npm run dev
   ```

7. **Start the development server**

   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000` (or via Laravel Herd at `https://laracom.test`).

## 🧪 Testing

Run the test suite using Pest:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ProductTest.php

# Run with coverage
php artisan test --coverage
```

## 🏗️ Project Structure

```
app/
├── Http/Controllers/          # Controllers
├── Livewire/                  # Livewire components
│   ├── Actions/              # Action classes
│   ├── Forms/                # Form classes
│   └── Storefront/           # Storefront components
├── Models/                   # Eloquent models
├── Services/                 # Business logic services
└── View/Components/          # Blade components

resources/
├── views/
│   ├── livewire/            # Livewire component views
│   └── storefront/          # Frontend views
├── css/                     # Tailwind CSS files
└── js/                      # JavaScript files

database/
├── factories/               # Model factories
├── migrations/              # Database migrations
└── seeders/                 # Database seeders
```

## 🔧 Key Components

### Models

- **Product**: Core product model with categories, media, and pricing
- **Cart & CartItem**: Shopping cart functionality
- **Order & OrderItem**: Order management system
- **Customer**: Customer account management
- **Category**: Product categorization
- **Media**: File and image management

### Services

- **CartService**: Shopping cart business logic
- **ProductService**: Product-related operations

### Livewire Components

- **Cart Management**: Real-time cart updates
- **Product Display**: Dynamic product cards and listings
- **Quick View**: Modal product previews

## 🎨 Frontend Features

- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Interactive Components**: Livewire-powered dynamic interfaces
- **Modern JavaScript**: ES6+ with Vite bundling
- **Performance Optimized**: Lazy loading and efficient asset management

## 🛠️ Development

### Code Quality

```bash
# Format code with Pint
vendor/bin/pint

# Run tests
php artisan test

# Generate IDE helpers
php artisan ide-helper:generate
```

### Asset Compilation

```bash
# Development with hot reload
npm run dev

# Production build
npm run build
```

## 📝 API Routes

The application includes RESTful routes for:

- Product catalog (`/shop`, `/product/{slug}`)
- Shopping cart (`/cart`)
- Checkout process (`/checkout`)
- User account (`/my-account`)
- Blog system (`/blog`)

## 🔒 Security

- CSRF protection on all forms
- SQL injection prevention with Eloquent ORM
- XSS protection with Blade templating
- Secure session management
- Input validation and sanitization

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

Please ensure your code follows the project's coding standards and includes appropriate tests.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com) - The PHP Framework for Web Artisans
- [Livewire](https://livewire.laravel.com) for dynamic frontend interactions
- [Tailwind CSS](https://tailwindcss.com) for styling
- [Pest PHP](https://pestphp.com) for testing
