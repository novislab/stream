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
