# Clipmark

A self-hosted Pocket alternative. Save articles, subscribe to RSS feeds, organize your reading.

![Cover](public/README-cover.png)

## Features

- **Save Articles** - Capture any article with a single click for later reading
- **RSS Aggregation** - Subscribe to your favorite sources and get new content automatically
- **Smart Categories** - Organize articles with tags and categories
- **Reader Mode** - Clean, distraction-free reading experience
- **Search & Filter** - Quickly find articles across your entire library
- **Archive System** - Keep read articles organized without cluttering your feed
- **Favorites** - Star important articles for quick access
- **Modern UI** - Clean, editorial-inspired interface built with Vue 3 and Tailwind CSS 4
- **Dark Mode** - Full dark mode support for comfortable reading

## Tech Stack

### Backend
- **PHP 8.4** - Latest PHP features and performance improvements
- **Laravel 12** - Modern Laravel framework with streamlined structure
- **Laravel Octane** - High-performance application server
- **SQLite** - Lightweight database (easily switchable to MySQL/PostgreSQL)

### Frontend
- **Vue 3** - Progressive JavaScript framework
- **Inertia.js v2** - Modern monolith architecture with SPA feel
- **Tailwind CSS 4** - Utility-first CSS framework
- **TypeScript** - Type-safe JavaScript
- **Reka UI** - Accessible component library

### Development Tools
- **Pest 4** - Modern PHP testing framework
- **Laravel Pint** - Opinionated code formatter
- **Larastan (PHPStan)** - Static analysis tool
- **ESLint** - JavaScript linter
- **Prettier** - Code formatter
- **Vite** - Next-generation frontend tooling
- **Bun** - Fast JavaScript runtime and package manager

## Requirements

- PHP 8.4 or higher
- Composer
- Node.js 22 >= and Bun (or npm/yarn)
- SQLite extension (or MySQL/PostgreSQL)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/SirMishaa/Clipmark
   cd Clipmark
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   bun install
   ```

4. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Create database, run migrations and seeders**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```

6. **Start the development server**
   ```bash
   composer run dev
   ```

   This will start:
    - Laravel development server (http://localhost:8000)
    - Queue worker for background jobs (RSS fetching)
    - Vite dev server for hot module replacement

   Alternatively, for high-performance development with Octane:
   ```bash
   composer run dev:octane
   ```

7. **Visit the application**

   Open your browser and navigate to [http://localhost:8000](http://localhost:8000)

## Available Scripts

### Composer Scripts

- `composer run dev` - Start all development services
- `composer run dev:octane` - Start with Laravel Octane
- `composer run test` - Run the test suite
- `composer run lint` - Run PHPStan static analysis

### Bun Scripts

- `bun run dev` - Start Vite development server
- `bun run build` - Build frontend assets for production
- `bun run lint` - Run ESLint and auto-fix issues
- `bun run format` - Format code with Prettier

### Artisan Commands

- `php artisan test` - Run tests
- `php artisan feeds:refresh` - Manually refresh all RSS feeds
- `php artisan articles:cleanup` - Clean up old archived articles
- `php artisan queue:work` - Process queued jobs

## Project Structure

```
Clipmark/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ArticleController.php
│   │       ├── SourceController.php
│   │       ├── CategoryController.php
│   │       └── ...
│   ├── Models/
│   │   ├── Article.php
│   │   ├── Source.php
│   │   ├── Category.php
│   │   └── User.php
│   ├── Jobs/
│   │   └── RefreshFeed.php
│   └── Services/
│       ├── ArticleParser.php
│       └── FeedParser.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   │   ├── Dashboard.vue
│   │   │   ├── Articles/
│   │   │   ├── Sources/
│   │   │   └── Categories/
│   │   ├── Components/
│   │   │   ├── ArticleCard.vue
│   │   │   ├── SourceCard.vue
│   │   │   ├── ReaderView.vue
│   │   │   └── ...
│   │   └── Layouts/
│   │       └── AppLayout.vue
│   └── views/
├── routes/
│   └── web.php
├── tests/
│   ├── Feature/
│   └── Unit/
└── ...
```

## Configuration

### RSS Feed Refresh

Feeds are refreshed automatically via scheduled jobs. Configure the frequency in `app/Console/Kernel.php`:

```php
$schedule->command('feeds:refresh')->hourly();
```

For local development, process jobs manually:
```bash
php artisan queue:work
```

### Article Parsing

The application uses a content extraction service to parse article content. Configure the parser in your `.env`:

```env
PARSER_DRIVER=default
```

## Database Schema

### Core Models

- **User** - Application users
- **Article** - Saved articles with metadata
- **Source** - RSS feed sources
- **Category** - User-defined categories
- **Tag** - Article tags (pivot with articles)

[//]: # (## API Endpoints)

[//]: # ()
[//]: # (| Method | Endpoint         | Description                    |)

[//]: # (|--------|------------------|--------------------------------|)

[//]: # (| GET    | `/articles`      | List all articles              |)

[//]: # (| POST   | `/articles`      | Save a new article             |)

[//]: # (| GET    | `/articles/{id}` | Get article details            |)

[//]: # (| PATCH  | `/articles/{id}` | Update article &#40;star, archive&#41; |)

[//]: # (| DELETE | `/articles/{id}` | Delete an article              |)

[//]: # (| GET    | `/sources`       | List RSS sources               |)

[//]: # (| POST   | `/sources`       | Add a new RSS source           |)

[//]: # (| DELETE | `/sources/{id}`  | Remove a source                |)

[//]: # (| GET    | `/categories`    | List categories                |)

[//]: # (| POST   | `/categories`    | Create category                |)

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Write tests for your changes
4. Ensure tests pass (`php artisan test`)
5. Format your code (`vendor/bin/pint && bun run format`)
6. Commit your changes (`git commit -m 'Add amazing feature'`)
7. Push to the branch (`git push origin feature/amazing-feature`)
8. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Acknowledgments

- Inspired by [Pocket](https://getpocket.com) (RIP)
- Built with [Laravel](https://laravel.com)
- UI powered by [Inertia.js](https://inertiajs.com) and [Vue.js](https://vuejs.org)
- Styled with [Tailwind CSS](https://tailwindcss.com)
