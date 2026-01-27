<laravel-boost-guidelines>
=== .ai/livewire rules ===

## Key Principles

- Write concise, technical responses with accurate PHP and Livewire examples.
- Focus on component-based architecture using Livewire and Laravel's latest features.
- Follow Laravel and Livewire best practices and conventions.
- Use object-oriented programming with a focus on SOLID principles.
- Prefer iteration and modularization over duplication.
- Use descriptive variable, method, and component names.
- Use lowercase with dashes for directories (e.g., `resources/views/pages/admin`).
- Favor dependency injection and service containers.

## PHP/Laravel Best Practices

- Use PHP 8.4+ features (typed properties, match expressions, constructor promotion).
- Follow PSR-12 coding standards.
- Use strict typing: `declare(strict_types=1);`
- Utilize Laravel 12's built-in features and helpers.
- Implement proper error handling and logging using Laravel's exception handling.
- Use Laravel's validation features via Form Requests.
- Implement middleware for request filtering and modification.
- Use Eloquent ORM for database interactions, avoid raw SQL.
- Implement proper database migrations, seeders, and factories.
- Use Laravel's caching mechanisms for improved performance.
- Implement job queues for long-running tasks.
- Use Laravel's event and listener system for decoupled code.

## Livewire Best Practices

- Use Livewire for dynamic components and real-time user interactions.
- Favor Livewire's lifecycle hooks (`mount()`, `updated*()`, `rendering()`).
- Use Livewire 4 features for optimization and reactivity.
- Handle state management using Livewire properties and actions.
- Use `wire:loading` and `wire:target` for loading feedback.
- Apply Livewire's security measures (locked properties, validation).
- Break down complex UIs into smaller, reusable components.
- Use `wire:key` in loops to ensure proper DOM diffing.
- Prefer single-file components (SFC) for simpler components.
- Use Form Objects for complex form handling.

## Tailwind CSS & Flux UI

- Use Tailwind CSS for styling, following utility-first approach.
- Use Flux UI components when available (`<flux:button>`, `<flux:input>`).
- Follow consistent design language using Tailwind classes.
- Implement responsive design using Tailwind breakpoints.
- Support dark mode using `dark:` variants.
- Optimize for accessibility (aria-attributes, focus states).

## Alpine.js Integration

- Use Alpine.js for lightweight client-side interactions.
- Access Livewire from Alpine via `$wire`.
- Use `x-data`, `x-show`, `x-on` for local UI state.
- Prefer Livewire for server state, Alpine for UI-only state.

---

## Livewire Commands

Use these artisan commands for Livewire development:

### `livewire:make` - Creating Components

Creates single-file components (SFC) in `resources/views/pages/` by default.

```bash
# Create a component
php artisan livewire:make ComponentName
# Output: resources/views/pages/⚡component-name.blade.php

# Create in a subdirectory
php artisan livewire:make Admin/Dashboard
# Output: resources/views/pages/admin/⚡dashboard.blade.php

# Create multi-file component (separate class + view)
php artisan livewire:make ComponentName --mfc

# Create class-based component (traditional style)
php artisan livewire:make ComponentName --class
```

**When to use:** Every time you need a new Livewire component. Use subdirectories to organize by feature (e.g., `Admin/Users/Index`).

### `livewire:form` - Form Objects

Creates a form class in `app/Livewire/Forms/`.

```bash
php artisan livewire:form PostForm
# Output: app/Livewire/Forms/PostForm.php
```

**When to use:** When a component has complex form logic with multiple fields and validation. Forms encapsulate validation rules, reset logic, and data handling.

```php
// Usage in component
public PostForm $form;

public function save(): void
{
    $this->form->store();
}
```

### `livewire:attribute` - Custom Attributes

Creates a custom attribute class in `app/Livewire/Attributes/`.

```bash
php artisan livewire:attribute MyAttribute
# Output: app/Livewire/Attributes/MyAttribute.php
```

**When to use:** When you need reusable component behavior via PHP attributes. Rare - only for advanced customization.

### `livewire:layout` - App Layouts

Creates a layout file at `resources/views/layouts/app.blade.php`.

```bash
php artisan livewire:layout
# Output: resources/views/layouts/app.blade.php
```

**When to use:** Once per project setup, or when creating additional layouts. Required for `Route::livewire()` pages.

### `livewire:convert` - Convert Component Format

Converts between single-file and multi-file component formats.

```bash
# Convert SFC to MFC
php artisan livewire:convert ComponentName --to-mfc

# Convert MFC to SFC
php artisan livewire:convert ComponentName --to-sfc
```

**When to use:** When refactoring. Use MFC for complex components with lots of PHP logic. Use SFC for simpler, view-heavy components.

### `livewire:stubs` - Customize Templates

Publishes stub files to `stubs/livewire/` for customization.

```bash
php artisan livewire:stubs
# Output: stubs/livewire/*.stub
```

**When to use:** When you want to customize the default templates used by `livewire:make`.

## Routing Page Components

Use `Route::livewire()` (Livewire 4) for full-page components:

```php
Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');
```

- `pages::` namespace maps to `resources/views/pages/`
- `pages::admin.dashboard` resolves to `resources/views/pages/admin/⚡dashboard.blade.php`

## HTML Directives

Use these `wire:` directives in Blade templates:

### Data Binding & Actions

| Directive | When to Use |
|-----------|-------------|
| `wire:model` | Bind input to component property. Add `.live` for real-time, `.blur` for on blur, `.debounce.500ms` for delay |
| `wire:click` | Trigger component method on click |
| `wire:submit` | Handle form submission (use `.prevent` to prevent default) |
| `wire:bind` | Two-way bind child component property to parent |

### Loading & State

| Directive | When to Use |
|-----------|-------------|
| `wire:loading` | Show element while request is processing |
| `wire:dirty` | Show element when input differs from server state |
| `wire:offline` | Show element when browser is offline |
| `wire:cloak` | Hide element until Livewire initializes (prevents flash) |

### Navigation & SPA

| Directive | When to Use |
|-----------|-------------|
| `wire:navigate` | SPA-style navigation without full page reload |
| `wire:current` | Apply class/attribute when link matches current URL |

### UX Enhancements

| Directive | When to Use |
|-----------|-------------|
| `wire:confirm` | Show confirmation dialog before action |
| `wire:transition` | Apply transitions when element appears/disappears |
| `wire:init` | Run method when component initializes on page |
| `wire:poll` | Periodically refresh component (e.g., `wire:poll.5s`) |

### Advanced

| Directive | When to Use |
|-----------|-------------|
| `wire:intersect` | Trigger action when element enters viewport (infinite scroll) |
| `wire:ignore` | Exclude element from Livewire DOM updates (for JS libraries) |
| `wire:ref` | Reference element in component via `$this->refs['name']` |
| `wire:replace` | Replace entire element instead of morphing |
| `wire:show` | Toggle visibility without removing from DOM |
| `wire:sort` | Enable drag-and-drop sorting |
| `wire:stream` | Stream content updates in real-time |
| `wire:text` | Set text content reactively |

## PHP Attributes

Use these attributes on component classes and properties:

### Component Configuration

| Attribute | When to Use |
|-----------|-------------|
| `#[Layout('layouts::app')]` | Set layout for full-page component |
| `#[Title('Page Title')]` | Set page title for full-page component |
| `#[Lazy]` | Lazy load component (renders placeholder first) |
| `#[Isolate]` | Prevent component from re-rendering with parent |

### Property Modifiers

| Attribute | When to Use |
|-----------|-------------|
| `#[Url]` | Sync property with URL query string |
| `#[Session]` | Persist property in session |
| `#[Locked]` | Prevent property from being modified by frontend |
| `#[Modelable]` | Allow parent to bind to this property with `wire:model` |
| `#[Reactive]` | Re-render when parent passes new value |
| `#[Validate]` | Define validation rules inline |

### Methods & Computed

| Attribute | When to Use |
|-----------|-------------|
| `#[Computed]` | Cache computed value (like Vue computed) |
| `#[On('event-name')]` | Listen for Livewire event |
| `#[Renderless]` | Method doesn't trigger re-render |

### JavaScript Integration

| Attribute | When to Use |
|-----------|-------------|
| `#[Js]` | Make property available to Alpine via `$wire.propName` |
| `#[Json]` | Encode property as JSON for JavaScript |

### Performance

| Attribute | When to Use |
|-----------|-------------|
| `#[Async]` | Run method asynchronously |
| `#[Defer]` | Batch updates until next network request |
| `#[Transition]` | Apply CSS transitions to changes |

## Blade Directives

| Directive | When to Use |
|-----------|-------------|
| `@persist('key')` | Preserve element state across page navigations (e.g., video player) |
| `@teleport('selector')` | Render content elsewhere in DOM (e.g., modals to body) |
| `@island` | Mark component as isolated island (partial hydration) |
| `@placeholder` | Define placeholder content for lazy-loaded components |

---

## Testing Livewire Components

### Pest Configuration for View-Based Components

Update `tests/Pest.php` to include view-based component tests:

```php
pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature', '../resources/views');
```

Update `phpunit.xml` to add a component test suite:

```xml
<testsuite name="Components">
    <directory suffix=".test.php">resources/views</directory>
</testsuite>
```

### Creating Your First Test

Generate a test file alongside a component using the `--test` flag:

```bash
php artisan make:livewire post.create --test
```

For multi-file components, this creates a test at `resources/views/components/post/create.test.php`:

```php
<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('post.create')
        ->assertStatus(200);
});
```

For class-based components, a PHPUnit test is created at `tests/Feature/Livewire/Post/CreateTest.php`.

### Testing a Page Contains a Component

```php
it('component exists on the page', function () {
    $this->get('/posts/create')
        ->assertSeeLivewire('post.create');
});
```

> **Smoke tests provide huge value** - They ensure no catastrophic problems exist, require little maintenance, and give confidence that pages render successfully.

### Browser Testing (Pest v4 + Playwright)

Install browser testing:

```bash
composer require pestphp/pest-plugin-browser --dev
npm install playwright@latest
npx playwright install
```

Use `Livewire::visit()` for real browser tests:

```php
it('can create a new post', function () {
    Livewire::visit('post.create')
        ->type('[wire\:model="title"]', 'My first post')
        ->type('[wire\:model="content"]', 'This is the content')
        ->press('Save')
        ->assertSee('Post created successfully');
});
```

#### Using data-test Attributes

Add `data-test` attributes to elements for reliable test selectors:

```blade
<flux:input data-test="email-input" wire:model="email" />
<flux:button data-test="submit-button" type="submit">Save</flux:button>
```

In browser tests, use the `@` selector shorthand:

```php
it('can login', function () {
    Livewire::visit('admin.login')
        ->type('@email-input', 'admin@test.com')
        ->type('@password-input', 'password123')
        ->press('@login-button')
        ->assertPathIs('/admin/dashboard');
});
```

#### Browser Test Assertions

| Method | Description |
|--------|-------------|
| `->visit('/url')` | Navigate to URL |
| `->type('@selector', 'text')` | Type into input |
| `->press('@button')` | Click a button |
| `->click('@element')` | Click any element |
| `->check('@checkbox')` | Check a checkbox |
| `->uncheck('@checkbox')` | Uncheck a checkbox |
| `->select('@select', 'value')` | Select dropdown option |
| `->assertSee('text')` | Assert text visible |
| `->assertDontSee('text')` | Assert text not visible |
| `->assertPathIs('/path')` | Assert current URL path |
| `->assertVisible('@element')` | Assert element visible |
| `->assertNotVisible('@element')` | Assert element hidden |
| `->screenshot('name')` | Take screenshot for debugging |
| `->pause(1000)` | Pause execution (ms) |

> **When to use browser tests**: Use for critical user flows and complex JS interactions. For most component testing, `Livewire::test()` is faster and sufficient.

### Testing Views

```php
use App\Models\Post;

it('displays posts', function () {
    Post::factory()->create(['title' => 'My first post']);
    Post::factory()->create(['title' => 'My second post']);

    Livewire::test('show-posts')
        ->assertSee('My first post')
        ->assertSee('My second post');
});

// Assert view data
it('passes all posts to the view', function () {
    Post::factory()->count(3)->create();

    Livewire::test('show-posts')
        ->assertViewHas('posts', function ($posts) {
            return count($posts) === 3;
        });
});
```

### Testing HTML with data-test Attributes

In component tests (not browser tests), use `assertSeeHtml()` to verify data-test attributes:

```php
it('shows email input', function () {
    Livewire::test('pages::admin.login')
        ->assertSeeHtml('data-test="email-input"');
});

it('shows login button', function () {
    Livewire::test('pages::admin.login')
        ->assertSeeHtml('data-test="login-button"');
});
```

> **Note**: The `@` selector syntax only works in browser tests (`Livewire::visit()`). For component tests (`Livewire::test()`), use `assertSeeHtml()` with the full attribute string.

### Testing with Authentication

```php
use App\Models\User;
use App\Models\Post;

it('user only sees their own posts', function () {
    $user = User::factory()
        ->has(Post::factory()->count(3))
        ->create();

    $stranger = User::factory()
        ->has(Post::factory()->count(2))
        ->create();

    Livewire::actingAs($user)
        ->test('show-posts')
        ->assertViewHas('posts', function ($posts) {
            return count($posts) === 3;
        });
});
```

### Testing Properties

```php
it('can set the title property', function () {
    Livewire::test('post.create')
        ->set('title', 'My amazing post')
        ->assertSet('title', 'My amazing post');
});

// Initialize with mount parameters
it('title field is populated when editing', function () {
    $post = Post::factory()->create(['title' => 'Existing post title']);

    Livewire::test('post.edit', ['post' => $post])
        ->assertSet('title', 'Existing post title');
});
```

### Setting URL Parameters

```php
it('can search posts via url query string', function () {
    Post::factory()->create(['title' => 'Laravel testing']);
    Post::factory()->create(['title' => 'Vue components']);

    Livewire::withQueryParams(['search' => 'Laravel'])
        ->test('search-posts')
        ->assertSee('Laravel testing')
        ->assertDontSee('Vue components');
});
```

### Setting Cookies

```php
it('loads discount token from cookie', function () {
    Livewire::withCookies(['discountToken' => 'SUMMER2024'])
        ->test('cart')
        ->assertSet('discountToken', 'SUMMER2024');
});
```

### Calling Actions

```php
use App\Models\Post;

it('can create a post', function () {
    expect(Post::count())->toBe(0);

    Livewire::test('post.create')
        ->set('title', 'My new post')
        ->set('content', 'Post content here')
        ->call('save');

    expect(Post::count())->toBe(1);
});

// With parameters
Livewire::test('post.show')
    ->call('deletePost', $postId);
```

### Testing Validation

```php
it('title field is required', function () {
    Livewire::test('post.create')
        ->set('title', '')
        ->call('save')
        ->assertHasErrors('title');
});

// Test specific rules
it('title must be at least 3 characters', function () {
    Livewire::test('post.create')
        ->set('title', 'ab')
        ->call('save')
        ->assertHasErrors(['title' => ['min:3']]);
});
```

### Testing Authorization

```php
use App\Models\User;
use App\Models\Post;

it('cannot update another users post', function () {
    $user = User::factory()->create();
    $stranger = User::factory()->create();
    $post = Post::factory()->for($stranger)->create();

    Livewire::actingAs($user)
        ->test('post.edit', ['post' => $post])
        ->set('title', 'Hacked!')
        ->call('save')
        ->assertForbidden();
});
```

### Testing Redirects

```php
it('redirects to posts index after creating', function () {
    Livewire::test('post.create')
        ->set('title', 'New post')
        ->set('content', 'Content here')
        ->call('save')
        ->assertRedirect('/posts');
});

// Named routes
->assertRedirect(route('posts.index'));
->assertRedirectToRoute('posts.index');
```

### Testing Events

```php
it('dispatches event when post is created', function () {
    Livewire::test('post.create')
        ->set('title', 'New post')
        ->call('save')
        ->assertDispatched('post-created');
});

// Test event communication between components
it('updates post count when event is dispatched', function () {
    $badge = Livewire::test('post-count-badge')
        ->assertSee('0');

    Livewire::test('post.create')
        ->set('title', 'New post')
        ->call('save')
        ->assertDispatched('post-created');

    $badge->dispatch('post-created')
        ->assertSee('1');
});

// Assert with parameters
it('dispatches notification when deleting post', function () {
    Livewire::test('post.show')
        ->call('delete', postId: 3)
        ->assertDispatched('notify', message: 'Post deleted');
});

// Complex assertions with closure
->assertDispatched('notify', function ($event, $params) {
    return ($params['message'] ?? '') === 'Post deleted';
});
```

### PHPUnit Example

```php
<?php

namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use App\Models\Post;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    public function test_can_create_post()
    {
        $this->assertEquals(0, Post::count());

        Livewire::test('post.create')
            ->set('title', 'My new post')
            ->set('content', 'Post content')
            ->call('save');

        $this->assertEquals(1, Post::count());
    }

    public function test_title_is_required()
    {
        Livewire::test('post.create')
            ->set('title', '')
            ->call('save')
            ->assertHasErrors('title');
    }
}
```

### All Available Testing Methods

#### Setup Methods

| Method | Description |
|--------|-------------|
| `Livewire::test('post.create')` | Test the post.create component |
| `Livewire::test(UpdatePost::class, ['post' => $post])` | Test with parameters passed to mount() |
| `Livewire::actingAs($user)` | Set authenticated user |
| `Livewire::withQueryParams(['search' => '...'])` | Set URL query parameters |
| `Livewire::withCookie('name', 'value')` | Set a cookie |
| `Livewire::withCookies(['color' => 'blue'])` | Set multiple cookies |
| `Livewire::withHeaders(['X-Header' => 'value'])` | Set custom headers |
| `Livewire::withoutLazyLoading()` | Disable lazy loading |

#### Interacting with Components

| Method | Description |
|--------|-------------|
| `set('title', '...')` | Set a property value |
| `set(['title' => '...', 'content' => '...'])` | Set multiple properties |
| `toggle('sortAsc')` | Toggle boolean property |
| `call('save')` | Call an action/method |
| `call('remove', $postId)` | Call method with parameters |
| `refresh()` | Trigger component re-render |
| `dispatch('post-created')` | Dispatch an event |
| `dispatch('post-created', postId: $post->id)` | Dispatch with parameters |

#### Assertions

| Method | Description |
|--------|-------------|
| `assertSet('title', '...')` | Property equals value |
| `assertNotSet('title', '...')` | Property does not equal value |
| `assertCount('posts', 3)` | Property contains 3 items |
| `assertSee('...')` | Text in rendered HTML |
| `assertDontSee('...')` | Text not in rendered HTML |
| `assertSeeHtml('<div>...</div>')` | Raw HTML present |
| `assertDontSeeHtml('<div>...</div>')` | Raw HTML not present |
| `assertSeeInOrder(['first', 'second'])` | Strings appear in order |
| `assertDispatched('post-created')` | Event was dispatched |
| `assertNotDispatched('post-created')` | Event was not dispatched |
| `assertHasErrors('title')` | Validation failed for property |
| `assertHasErrors(['title' => ['required']])` | Specific rules failed |
| `assertHasNoErrors('title')` | No validation errors |
| `assertRedirect()` | Redirect was triggered |
| `assertRedirect('/posts')` | Redirect to specific URL |
| `assertRedirectToRoute('posts.index')` | Redirect to named route |
| `assertNoRedirect()` | No redirect triggered |
| `assertViewHas('posts')` | Data passed to view |
| `assertViewHas('postCount', 3)` | View data has value |
| `assertViewIs('livewire.show-posts')` | Specific view rendered |
| `assertFileDownloaded()` | File download triggered |
| `assertFileDownloaded($filename)` | Specific file downloaded |
| `assertUnauthorized()` | Authorization exception (401) |
| `assertForbidden()` | Access forbidden (403) |
| `assertStatus(500)` | Specific status code |

---

## Security & Authorization

### Protected Properties

```php
use Livewire\Attributes\Locked;

new class extends Component {
    #[Locked]
    public int $userId; // Cannot be modified from frontend

    public function mount(): void
    {
        $this->userId = auth()->id();
    }
};
```

### Authorization in Components

```php
new class extends Component {
    public Post $post;

    public function mount(Post $post): void
    {
        // Authorize on mount
        $this->authorize('view', $post);
        $this->post = $post;
    }

    public function delete(): void
    {
        // Authorize before action
        $this->authorize('delete', $this->post);
        $this->post->delete();
    }
};
```

### Validation

```php
use Livewire\Attributes\Validate;

new class extends Component {
    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|email|unique:users,email')]
    public string $email = '';

    public function save(): void
    {
        $this->validate(); // Validates all #[Validate] properties

        // Or validate specific fields
        $this->validateOnly('email');
    }
};
```

### Rate Limiting

```php
use Illuminate\Support\Facades\RateLimiter;

new class extends Component {
    public function sendMessage(): void
    {
        $key = 'send-message:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('message', 'Too many attempts. Try again later.');
            return;
        }

        RateLimiter::hit($key, 60); // 5 attempts per minute

        // Send message...
    }
};
```

---

## Common Patterns

### Modals

```php
// Parent component
new class extends Component {
    public bool $showModal = false;

    #[On('close-modal')]
    public function closeModal(): void
    {
        $this->showModal = false;
    }
};
```

```blade
{{-- Parent view --}}
<flux:button wire:click="$set('showModal', true)">Open Modal</flux:button>

<flux:modal wire:model="showModal">
    <livewire:edit-user :user="$user" />
</flux:modal>
```

```php
// Child component dispatches event to close
public function save(): void
{
    $this->user->save();
    $this->dispatch('close-modal');
}
```

### Search with Debounce

```php
use Livewire\Attributes\Url;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Url]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage(); // Reset pagination on search
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->paginate(10);
    }
};
```

```blade
<flux:input wire:model.live.debounce.300ms="search" placeholder="Search..." />

@foreach($this->users as $user)
    <div wire:key="user-{{ $user->id }}">{{ $user->name }}</div>
@endforeach

{{ $this->users->links() }}
```

### Infinite Scroll

```php
new class extends Component {
    public int $perPage = 10;

    #[Computed]
    public function posts()
    {
        return Post::latest()->take($this->perPage)->get();
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
    }
};
```

```blade
@foreach($this->posts as $post)
    <div wire:key="post-{{ $post->id }}">{{ $post->title }}</div>
@endforeach

<div wire:intersect="loadMore">
    <span wire:loading>Loading more...</span>
</div>
```

### File Uploads

```php
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component {
    use WithFileUploads;

    #[Validate('image|max:1024')] // 1MB max
    public $photo;

    public function save(): void
    {
        $this->validate();
        $path = $this->photo->store('photos', 'public');

        auth()->user()->update(['avatar' => $path]);
    }
};
```

```blade
<input type="file" wire:model="photo">

@error('photo') <span>{{ $message }}</span> @enderror

@if ($photo)
    <img src="{{ $photo->temporaryUrl() }}" alt="Preview">
@endif

<flux:button wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove>Upload</span>
    <span wire:loading>Uploading...</span>
</flux:button>
```

### Events Between Components

```php
// Emitter component
new class extends Component {
    public function save(): void
    {
        $this->dispatch('post-created', postId: $post->id);

        // Dispatch to specific component
        $this->dispatch('refresh')->to(PostList::class);

        // Dispatch to parent only
        $this->dispatch('saved')->up();
    }
};

// Listener component
new class extends Component {
    #[On('post-created')]
    public function handlePostCreated(int $postId): void
    {
        // Handle the event
    }

    #[On('refresh')]
    public function refresh(): void
    {
        // Refresh data
    }
};
```

=== .ai/pest rules ===

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

=== .ai/git rules ===

=== git rules ===

## Git Commit Guidelines

### Commit Strategy
- Group related changes by file, folder, or feature.
- Commit each group separately, one by one.
- Do not bundle unrelated changes into a single commit.

### Commit Messages
- Keep messages simple and short (50 characters or less).
- Use imperative mood: "Add", "Fix", "Update", "Remove".
- Do not include AI co-author or attribution in commits.

### Examples

```bash
# Good - grouped by feature/folder
git commit -m "Add user authentication routes"
git commit -m "Add login form component"
git commit -m "Update user model with auth methods"

# Bad - too many unrelated changes
git commit -m "Add auth, fix styles, update readme, refactor utils"
```

### Commit Order
1. Stage files for one feature or folder.
2. Commit with a short message.
3. Repeat for each group.

```bash
git add app/Models/User.php
git commit -m "Add email verification to User model"

git add resources/views/auth/
git commit -m "Add auth blade templates"

git add routes/web.php
git commit -m "Add auth routes"
```

=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

## Foundational Context
This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4.1
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- livewire/flux (FLUXUI_FREE) - v2
- livewire/flux-pro (FLUXUI_PRO) - v
- livewire/livewire (LIVEWIRE) - v4
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- tailwindcss (TAILWINDCSS) - v4

## Conventions
- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts
- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## Application Structure & Architecture
- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling
- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Replies
- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files
- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

## Laravel Boost
- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan
- Use the `list-artisan-commands` tool when you need to call an Artisan command to double-check the available parameters.

## URLs
- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Tinker / Debugging
- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading Browser Logs With the `browser-logs` Tool
- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)
- Boost comes with a powerful `search-docs` tool you should use before any other approaches when dealing with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- The `search-docs` tool is perfect for all Laravel-related packages, including Laravel, Inertia, Livewire, Filament, Tailwind, Pest, Nova, Nightwatch, etc.
- You must use this tool to search for Laravel ecosystem documentation before falling back to other approaches.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries to start. For example: `['rate limiting', 'routing rate limiting', 'routing']`.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax
- You can and should pass multiple queries at once. The most relevant results will be returned first.

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

=== php rules ===

## PHP

- Always use curly braces for control structures, even if it has one line.

### Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.

### Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Comments
- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless there is something very complex going on.

## PHPDoc Blocks
- Add useful array shape type definitions for arrays when appropriate.

## Enums
- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

=== tests rules ===

## Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

## Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Database
- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation
- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources
- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

### Controllers & Validation
- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

### Queues
- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

### Authentication & Authorization
- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

### URL Generation
- When generating links to other pages, prefer named routes and the `route()` function.

### Configuration
- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

### Testing
- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

### Vite Error
- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== laravel/v12 rules ===

## Laravel 12

- Use the `search-docs` tool to get version-specific documentation.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

### Laravel 12 Structure
- In Laravel 12, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app\Console\Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

### Database
- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 12 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models
- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== fluxui-pro/core rules ===

## Flux UI Pro

- This project is using the Pro version of Flux UI. It has full access to the free components and variants, as well as full access to the Pro components and variants.
- Flux UI is a component library for Livewire. Flux is a robust, hand-crafted UI component library for your Livewire applications. It's built using Tailwind CSS and provides a set of components that are easy to use and customize.
- You should use Flux UI components when available.
- Fallback to standard Blade components if Flux is unavailable.
- If available, use the `search-docs` tool to get the exact documentation and code snippets available for this project.
- Flux UI components look like this:

<code-snippet name="Flux UI Component Example" lang="blade">
    <flux:button variant="primary"/>
</code-snippet>

### Available Components
This is correct as of Boost installation, but there may be additional components within the codebase.

<available-flux-components>
accordion, autocomplete, avatar, badge, brand, breadcrumbs, button, calendar, callout, card, chart, checkbox, command, composer, context, date-picker, dropdown, editor, field, file-upload, heading, icon, input, kanban, modal, navbar, otp-input, pagination, pillbox, popover, profile, radio, select, separator, skeleton, slider, switch, table, tabs, text, textarea, time-picker, toast, tooltip
</available-flux-components>

=== fluxui-pro/v rules ===

## Flux UI Pro

- This project is using the Pro version of Flux UI. It has full access to the free components and variants, as well as full access to the Pro components and variants.
- Flux UI is a component library for Livewire. Flux is a robust, hand-crafted UI component library for your Livewire applications. It's built using Tailwind CSS and provides a set of components that are easy to use and customize.
- You should use Flux UI components when available.
- Fallback to standard Blade components if Flux is unavailable.
- If available, use the `search-docs` tool to get the exact documentation and code snippets available for this project.
- Flux UI components look like this:

<code-snippet name="Flux UI Component Example" lang="blade">
    <flux:button variant="primary"/>
</code-snippet>

### Available Components
This is correct as of Boost installation, but there may be additional components within the codebase.

<available-flux-components>
accordion, autocomplete, avatar, badge, brand, breadcrumbs, button, calendar, callout, card, chart, checkbox, command, composer, context, date-picker, dropdown, editor, field, file-upload, heading, icon, input, kanban, modal, navbar, otp-input, pagination, pillbox, popover, profile, radio, select, separator, skeleton, slider, switch, table, tabs, text, textarea, time-picker, toast, tooltip
</available-flux-components>

=== livewire/core rules ===

## Livewire

- Use the `search-docs` tool to find exact version-specific documentation for how to write Livewire and Livewire tests.
- Use the `php artisan make:livewire [Posts\CreatePost]` Artisan command to create new components.
- State should live on the server, with the UI reflecting it.
- All Livewire requests hit the Laravel backend; they're like regular HTTP requests. Always validate form data and run authorization checks in Livewire actions.

## Livewire Best Practices
- Livewire components require a single root element.
- Use `wire:loading` and `wire:dirty` for delightful loading states.
- Add `wire:key` in loops:

    ```blade
    @foreach ($items as $item)
        <div wire:key="item-{{ $item->id }}">
            {{ $item->name }}
        </div>
    @endforeach
    ```

- Prefer lifecycle hooks like `mount()`, `updatedFoo()` for initialization and reactive side effects:

<code-snippet name="Lifecycle Hook Examples" lang="php">
    public function mount(User $user) { $this->user = $user; }
    public function updatedSearch() { $this->resetPage(); }
</code-snippet>

## Testing Livewire

<code-snippet name="Example Livewire Component Test" lang="php">
    Livewire::test(Counter::class)
        ->assertSet('count', 0)
        ->call('increment')
        ->assertSet('count', 1)
        ->assertSee(1)
        ->assertStatus(200);
</code-snippet>

<code-snippet name="Testing Livewire Component Exists on Page" lang="php">
    $this->get('/posts/create')
    ->assertSeeLivewire(CreatePost::class);
</code-snippet>

=== pint/core rules ===

## Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.

=== pest/core rules ===

## Pest
### Testing
- If you need to verify a feature is working, write or update a Unit / Feature test.

### Pest Tests
- All tests must be written using Pest. Use `php artisan make:test --pest {name}`.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files - these are core to the application.
- Tests should test all of the happy paths, failure paths, and weird paths.
- Tests live in the `tests/Feature` and `tests/Unit` directories.
- Pest tests look and behave like this:
<code-snippet name="Basic Pest Test Example" lang="php">
it('is true', function () {
    expect(true)->toBeTrue();
});
</code-snippet>

### Running Tests
- Run the minimal number of tests using an appropriate filter before finalizing code edits.
- To run all tests: `php artisan test --compact`.
- To run all tests in a file: `php artisan test --compact tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --compact --filter=testName` (recommended after making a change to a related file).
- When the tests relating to your changes are passing, ask the user if they would like to run the entire test suite to ensure everything is still passing.

### Pest Assertions
- When asserting status codes on a response, use the specific method like `assertForbidden` and `assertNotFound` instead of using `assertStatus(403)` or similar, e.g.:
<code-snippet name="Pest Example Asserting postJson Response" lang="php">
it('returns all', function () {
    $response = $this->postJson('/api/docs', []);

    $response->assertSuccessful();
});
</code-snippet>

### Mocking
- Mocking can be very helpful when appropriate.
- When mocking, you can use the `Pest\Laravel\mock` Pest function, but always import it via `use function Pest\Laravel\mock;` before using it. Alternatively, you can use `$this->mock()` if existing tests do.
- You can also create partial mocks using the same import or self method.

### Datasets
- Use datasets in Pest to simplify tests that have a lot of duplicated data. This is often the case when testing validation rules, so consider this solution when writing tests for validation rules.

<code-snippet name="Pest Dataset Example" lang="php">
it('has emails', function (string $email) {
    expect($email)->not->toBeEmpty();
})->with([
    'james' => 'james@laravel.com',
    'taylor' => 'taylor@laravel.com',
]);
</code-snippet>

=== pest/v4 rules ===

## Pest 4

- Pest 4 is a huge upgrade to Pest and offers: browser testing, smoke testing, visual regression testing, test sharding, and faster type coverage.
- Browser testing is incredibly powerful and useful for this project.
- Browser tests should live in `tests/Browser/`.
- Use the `search-docs` tool for detailed guidance on utilizing these features.

### Browser Testing
- You can use Laravel features like `Event::fake()`, `assertAuthenticated()`, and model factories within Pest 4 browser tests, as well as `RefreshDatabase` (when needed) to ensure a clean state for each test.
- Interact with the page (click, type, scroll, select, submit, drag-and-drop, touch gestures, etc.) when appropriate to complete the test.
- If requested, test on multiple browsers (Chrome, Firefox, Safari).
- If requested, test on different devices and viewports (like iPhone 14 Pro, tablets, or custom breakpoints).
- Switch color schemes (light/dark mode) when appropriate.
- Take screenshots or pause tests for debugging when appropriate.

### Example Tests

<code-snippet name="Pest Browser Test Example" lang="php">
it('may reset the password', function () {
    Notification::fake();

    $this->actingAs(User::factory()->create());

    $page = visit('/sign-in'); // Visit on a real browser...

    $page->assertSee('Sign In')
        ->assertNoJavascriptErrors() // or ->assertNoConsoleLogs()
        ->click('Forgot Password?')
        ->fill('email', 'nuno@laravel.com')
        ->click('Send Reset Link')
        ->assertSee('We have emailed your password reset link!')

    Notification::assertSent(ResetPassword::class);
});
</code-snippet>

<code-snippet name="Pest Smoke Testing Example" lang="php">
$pages = visit(['/', '/about', '/contact']);

$pages->assertNoJavascriptErrors()->assertNoConsoleLogs();
</code-snippet>

=== tailwindcss/core rules ===

## Tailwind CSS

- Use Tailwind CSS classes to style HTML; check and use existing Tailwind conventions within the project before writing your own.
- Offer to extract repeated patterns into components that match the project's conventions (i.e. Blade, JSX, Vue, etc.).
- Think through class placement, order, priority, and defaults. Remove redundant classes, add classes to parent or child carefully to limit repetition, and group elements logically.
- You can use the `search-docs` tool to get exact examples from the official documentation when needed.

### Spacing
- When listing items, use gap utilities for spacing; don't use margins.

<code-snippet name="Valid Flex Gap Spacing Example" lang="html">
    <div class="flex gap-8">
        <div>Superior</div>
        <div>Michigan</div>
        <div>Erie</div>
    </div>
</code-snippet>

### Dark Mode
- If existing pages and components support dark mode, new pages and components must support dark mode in a similar way, typically using `dark:`.

=== tailwindcss/v4 rules ===

## Tailwind CSS 4

- Always use Tailwind CSS v4; do not use the deprecated utilities.
- `corePlugins` is not supported in Tailwind v4.
- In Tailwind v4, configuration is CSS-first using the `@theme` directive — no separate `tailwind.config.js` file is needed.

<code-snippet name="Extending Theme in CSS" lang="css">
@theme {
  --color-brand: oklch(0.72 0.11 178);
}
</code-snippet>

- In Tailwind v4, you import Tailwind using a regular CSS `@import` statement, not using the `@tailwind` directives used in v3:

<code-snippet name="Tailwind v4 Import Tailwind Diff" lang="diff">
   - @tailwind base;
   - @tailwind components;
   - @tailwind utilities;
   + @import "tailwindcss";
</code-snippet>

### Replaced Utilities
- Tailwind v4 removed deprecated utilities. Do not use the deprecated option; use the replacement.
- Opacity values are still numeric.

| Deprecated |	Replacement |
|------------+--------------|
| bg-opacity-* | bg-black/* |
| text-opacity-* | text-black/* |
| border-opacity-* | border-black/* |
| divide-opacity-* | divide-black/* |
| ring-opacity-* | ring-black/* |
| placeholder-opacity-* | placeholder-black/* |
| flex-shrink-* | shrink-* |
| flex-grow-* | grow-* |
| overflow-ellipsis | text-ellipsis |
| decoration-slice | box-decoration-slice |
| decoration-clone | box-decoration-clone |
</laravel-boost-guidelines>
