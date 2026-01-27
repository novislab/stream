=== pest rules ===

## Pest Testing Guidelines

### Running Tests
- Run all tests: `php artisan test --compact`
- Run specific file: `php artisan test --compact tests/Feature/ExampleTest.php`
- Filter by name: `php artisan test --compact --filter=testName`
- Run with browser visible: `php artisan test --headed`

### Test File Location
- Feature tests: `tests/Feature/`
- Unit tests: `tests/Unit/`
- Component tests: `resources/views/` (alongside Livewire components)

### Test File Naming
- Feature/Unit tests: `ExampleTest.php`
- Component tests: `component-name.test.php` (next to `.blade.php` and `.php`)

### Test Structure

```php
<?php

use App\Models\User;

beforeEach(function () {
    // Setup that runs before each test
});

describe('feature name', function () {
    it('does something specific', function () {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->get('/dashboard');

        // Assert
        $response->assertStatus(200);
    });
});
```

### Using Factories
- Always use factories for creating test models.
- Check for existing factory states before manually setting attributes.

```php
// Good - use factory
$user = User::factory()->create(['email' => 'test@example.com']);

// Good - use factory state if available
$admin = User::factory()->admin()->create();

// Bad - manual creation
$user = new User();
$user->email = 'test@example.com';
$user->save();
```

### Expectations

```php
// Basic expectations
expect($value)->toBe(1);
expect($value)->toBeTrue();
expect($value)->toBeFalse();
expect($value)->toBeNull();
expect($value)->toBeEmpty();
expect($value)->toContain('text');
expect($value)->toHaveCount(3);

// Object expectations
expect($user)->toBeInstanceOf(User::class);
expect($user->email)->toBe('test@example.com');
```

---

## Browser Testing with Pest Browser Plugin

### Setup
Browser tests require the Pest browser plugin with Playwright.

### Running Browser Tests
- Headless (default): `php artisan test --filter="browser tests"`
- With visible browser: `php artisan test --headed --filter="browser tests"`

### Basic Browser Test

```php
describe('browser tests', function () {
    it('displays page correctly', function () {
        $page = visit('/login');

        $page->waitForText('Login')
            ->assertSee('Login')
            ->assertVisible('@email-input')
            ->assertVisible('@password-input');
    });
})->skip(! function_exists('visit'), 'Browser testing not installed');
```

### Using data-test Selectors
Use `data-test` attributes for reliable selectors. The `@` prefix is shorthand for `[data-test="..."]`.

```blade
{{-- In Blade template --}}
<flux:input data-test="email-input" wire:model="email" />
<flux:button data-test="submit-button" type="submit">Submit</flux:button>
```

```php
// In test - @ prefix targets data-test attributes
$page->type('@email-input', 'user@example.com')
    ->click('@submit-button');
```

### Browser Test Methods

| Method | Description |
|--------|-------------|
| `visit('/url')` | Navigate to URL |
| `type('@selector', 'text')` | Type into input field |
| `click('@selector')` | Click element |
| `wait(seconds)` | Pause execution |
| `waitForText('text')` | Wait for text to appear |
| `content()` | Get page HTML content |
| `screenshot()` | Take screenshot |

### Browser Test Assertions

| Assertion | Description |
|-----------|-------------|
| `assertSee('text')` | Assert text is visible |
| `assertDontSee('text')` | Assert text is not visible |
| `assertVisible('@selector')` | Assert element is visible |
| `assertPathIs('/path')` | Assert current URL path |
| `assertChecked('@checkbox')` | Assert checkbox is checked |
| `assertNoJavaScriptErrors()` | Assert no JS errors |

### Browser Test Tips
1. Always use `waitForText()` for the first assertion to ensure page is loaded.
2. Use `wait(2)` before `assertPathIs()` after navigation.
3. Add `->skip()` condition to skip if browser plugin not installed.

```php
describe('browser tests', function () {
    it('logs in successfully', function () {
        $user = User::factory()->create(['password' => 'password123']);

        visit('/login')
            ->waitForText('Login')
            ->type('@email-input', $user->email)
            ->type('@password-input', 'password123')
            ->click('@login-button')
            ->wait(2)
            ->assertPathIs('/dashboard');
    });
})->skip(! function_exists('visit'), 'Browser testing not installed');
```

---

## Livewire Component Testing

### Component Test vs Browser Test
- Use `Livewire::test()` for fast unit-style component tests.
- Use `visit()` browser tests for critical user flows and JS interactions.

### Component Test Example

```php
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::admin.login')
        ->assertStatus(200);
});

it('validates form', function () {
    Livewire::test('pages::admin.login')
        ->set('email', '')
        ->set('password', '')
        ->call('login')
        ->assertNoRedirect();
});

it('logs in admin user', function () {
    $user = User::factory()->create(['password' => 'password123']);
    $user->assignRole('admin');

    Livewire::test('pages::admin.login')
        ->set('email', $user->email)
        ->set('password', 'password123')
        ->call('login')
        ->assertRedirect(route('admin.dashboard'));
});
```

### Testing HTML with data-test Attributes
In component tests (not browser tests), use `assertSeeHtml()`:

```php
it('shows email input', function () {
    Livewire::test('pages::admin.login')
        ->assertSeeHtml('data-test="email-input"');
});
```

---

## Test Organization

### Grouping with describe()

```php
describe('component tests', function () {
    it('renders successfully', function () { /* ... */ });
    it('validates input', function () { /* ... */ });
});

describe('browser tests', function () {
    it('displays form correctly', function () { /* ... */ });
    it('submits form successfully', function () { /* ... */ });
})->skip(! function_exists('visit'), 'Browser testing not installed');
```

### Shared Setup with beforeEach()

```php
beforeEach(function () {
    Role::findOrCreate('admin');
});

it('test one', function () { /* ... */ });
it('test two', function () { /* ... */ });
```
