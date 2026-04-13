# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel 13 e-commerce application with multi-payment support (PayPal, Stripe), role-based access control, separate admin panel, and AI-powered features. Uses PHP 8.3+, Bootstrap 5, jQuery, Vite, and Laravel AI SDK.

## Common Commands

```bash
# Serve locally
php artisan serve

# Frontend assets
npm run dev          # Vite dev server (creates public/hot file)
npm run build        # Production build (outputs to public/build/)
# Note: If design/CSS not loading, delete public/hot when Vite dev server is not running

# Database
php artisan migrate
php artisan migrate:fresh --seed   # Reset DB with seed data
php artisan db:seed

# Cache
php artisan optimize        # Cache config, routes, views, events
php artisan optimize:clear  # Clear all caches

# Tests
php artisan test                           # Run all tests
php artisan test --filter=ExampleTest      # Run single test class
php artisan test tests/Feature/ExampleTest.php  # Run single test file

# Queue
php artisan queue:work          # Process queued jobs (run in separate terminal)
php artisan queue:failed        # List failed jobs
php artisan queue:retry all     # Retry all failed jobs

# Code style
./vendor/bin/pint             # Fix code style (Laravel Pint)
./vendor/bin/pint --test      # Check without fixing

# IDE helper (auto-runs on composer update)
php artisan ide-helper:generate
php artisan ide-helper:meta
```

## Architecture

### Authentication & Guards

Two auth guards defined in `config/auth.php`:
- **web** (default) — standard user sessions
- **admin** — admin panel sessions (same users table, role-checked)

API authentication uses **Laravel Sanctum** (`auth:sanctum` middleware). Login requires `active = 1` on the user record.

Three roles via `App\Enum\UserRole`: SUPER_ADMIN, ADMIN, CUSTOMER. Roles are managed through a `role_user` pivot table. Role checking happens in `CheckUserRoleMiddleware` (aliased as `role` in bootstrap/app.php).

### Layered Architecture

**Controllers -> Services -> Repositories -> Models**

- **Repositories** (`app/Repositories/`): `ProductRepository`, `OrderRepository` implementing interfaces. Bound in `RepositoryServiceProvider`.
- **Services** (`app/Services/`): `ProductService`, `OrderService` contain business logic. `OrderService` handles the full order creation flow (order + customer + products + logging + dispatches `SendOrderEmailJob`).
- **Traits** (`app/Traits/`): `CommonTrait` composes all others and is used by controllers, services, and middleware. Provides: `customLog()`, `hasRole()`, `decimalPrice()`, cart session helpers (`cartGet/cartSet/cartDelete`), PayPal API methods, and auth user helpers.

### Laravel 13 Features in Use

- **JSON:API Resources** (`app/Http/Resources/*JsonApiResource.php`): Spec-compliant `application/vnd.api+json` responses for the v2 API. Extend `JsonApiResource` with declarative `$attributes` and `$relationships` arrays.
- **PHP Attributes on Controllers**: Admin controllers use `#[Middleware('auth:admin')]` class-level attributes instead of route-group middleware.
- **Queue Job Attributes**: Jobs use `#[Tries(3)]`, `#[Timeout(60)]`, `#[Backoff(10, 30)]`, `#[FailOnTimeout]` PHP attributes instead of class properties.
- **AI SDK** (`laravel/ai`): `ProductDescriptionAgent` in `app/Ai/Agents/` generates product descriptions. Config in `config/ai.php`. Requires an AI provider API key (e.g., `OPENAI_API_KEY`) in `.env`.

### API Versioning

- **v1** (`api/v1/*`): Original endpoints using standard JSON resources.
- **v2** (`api/v2/*`): JSON:API spec-compliant endpoints using `JsonApiResource`. Supports sparse fieldsets (`?fields[products]=name,price`) and includes (`?include=orders`).
- **AI endpoints** (`api/ai/*`): AI-powered features, auth required via Sanctum.

### Payment Flow

- **Stripe**: `StripeController` creates PaymentIntent -> frontend confirms -> `CheckoutController@createStripeOrder` verifies with Stripe API and creates order via `OrderService`. Order creation is wrapped in `DB::transaction()`.
- **PayPal**: `PayPalController` handles order creation and capture through PayPal REST API v2. Injects `OrderService` for order creation. Access tokens and API calls managed in `PayPalTrait`. Capture endpoint requires `(object) []` body (not empty) to avoid `MALFORMED_REQUEST_JSON`.
- Both flows create orders via `OrderService::createOrder($cart)` which expects `$cart['payment_reference_code']` and `$cart['payment_method']` at the top level. After success, both redirect to `/order/success/{order_id}` and clear the cart.
- Payment credentials are accessed via `config('services.stripe.secret')` and `config('services.paypal.*')` — never use `env()` directly in application code.

CSRF is disabled for `stripe/*` routes in `bootstrap/app.php`.

### Frontend Build

Vite config has four entry points:
- `resources/css/frontend.css` + `resources/js/frontend.js` (public site)
- `resources/css/backend.css` + `resources/js/backend.js` (admin panel)

Layouts: `layouts/app.blade.php` (frontend), `layouts/admin.blade.php` (admin), `layouts/auth.blade.php` (auth pages).

### Frontend Design

The storefront uses a custom e-commerce design built with Bootstrap 5 classes and custom CSS in `resources/css/front-end.css`:

- **Header** (`layouts/includes/header.blade.php`): Dark top bar with promo text + account links, white navbar with "LaraShop" brand, active nav states, cart icon with server-side badge count (reads `session('cart.products')`), mobile hamburger menu.
- **Footer** (`layouts/includes/footer.blade.php`): Dark themed with brand column, social icons, Shop/Support/Company links, payment badges, copyright bar.
- **Auth pages** (`auth/login.blade.php`, `auth/register.blade.php`): Centered card layout with `.auth-card` / `.auth-page` classes, input groups with leading icons, hover-lift submit buttons.
- **Home page** (`page/home.blade.php`): Hero banner with CTA buttons, 4-feature strip (shipping, returns, security, support), dark CTA section.
- **Product listing** (`product/index.blade.php`): CSS Grid layout (`grid-template-columns: repeat(auto-fill, minmax(260px, 1fr))`), product cards with hover lift + image zoom, add-to-cart with cart icon.
- **Cart page** (`cart/index.blade.php`): Table-style item list with quantity controls, remove button, order summary sidebar with "Proceed to Checkout", empty state with CTA.
- **Profile page** (`profile/show.blade.php`, `profile/edit.blade.php`): User info card with avatar, recent orders list, edit form for name/email/password. Singleton resource route with `auth.basic` middleware.
- **Order success page** (`checkout/order-success.blade.php`): Confirmation page with green checkmark, order details, items list, shipping address, total, and action buttons.

### Cart System

Session-based cart using `SessionTrait` methods (`cartGet/cartSet/cartDelete`). Key routes:
- `POST /add-to-cart` — Add/increase/decrease product quantity (AJAX, returns JSON)
- `GET /cart` — Cart page view with `dbValidatedCart()` prices
- `POST /cart/remove` — Remove item entirely (AJAX, returns JSON)
- `GET /checkout` — Checkout page (redirects to `/products` if cart empty)

Cart JS (`resources/js/frontend/cart.js`) handles all AJAX operations: add-to-cart, quantity +/-, remove, cart badge updates, and cart page live total recalculation. The header cart badge is rendered server-side from `session('cart.products')` so it shows the correct count on every page.

### UUID Pattern

User, Product, Order, and OrderProduct models generate UUIDs. User UUID is generated in the model's `creating` event. Product UUID uses MySQL's `DB::raw('UUID()')` default in migration.

### Key Model Relationships

- **User**: belongsToMany(Role), hasMany(Order)
- **Order**: belongsTo(User), hasOne(OrderCustomer), hasMany(OrderProduct)
- **Product**: auto-generates unique slugs on create/update via `booted()`

### Database

Default connection is `sqlite` in `.env.example`, but the project uses MySQL in practice. The `active` field on users controls login eligibility. Password hashing is handled by the `hashed` cast on the User model — do not manually `bcrypt()` or `Hash::make()` passwords before storing.

### Queue & Jobs

Queue connection is `database`. Jobs are stored in the `jobs` table and processed by a worker.

```bash
php artisan queue:work          # Process jobs (run in separate terminal)
php artisan queue:work --once   # Process one job and stop
php artisan queue:failed        # List failed jobs
php artisan queue:retry all     # Retry all failed jobs
```

**Jobs** (`app/Jobs/`):
- `SendOrderEmailJob` — Dispatched by `OrderService` after order creation. Sends `OrderCreated` mailable to the customer email, updates `is_email_sent` flag. Uses `#[Tries(3)]`, `#[Timeout(60)]`, `#[Backoff(10, 30)]`.
- `SendEmailJob` — Generic email job (currently logs only, mail send commented out).

**Mailables** (`app/Mail/`):
- `OrderCreated` — Order confirmation email. Uses `mail.orders.created` blade template. Receives the `Order` model with `customer` and `order_products` relationships eager-loaded.

### Custom Logging

`CommonTrait::customLog()` writes to `storage/logs/{directory}/{filename}_{date}.log`. Used extensively in payment controllers and order service for debugging payment flows.

### Seeders

`DatabaseSeeder` runs: RoleSeeder (3 roles) -> UserSeeder (super_admin/admin/customer with password '123456') -> ProductSeeder (50 factory products).

## Important Warnings

- **CleanWebpackPlugin hazard**: Do NOT use CleanWebpackPlugin with Webpack 5 — it previously deleted the entire source directory. The project now uses Vite.
- **Node compatibility**: Project must be compatible with Node 22.17.1.
- **Never use `env()` in application code** — always use `config()`. The `env()` helper returns null when config is cached. Third-party credentials are in `config/services.php`.
- **Rate limiting**: Login and registration routes have `throttle:5,1` middleware (5 attempts per minute).
- The `composer.lock` is gitignored.
