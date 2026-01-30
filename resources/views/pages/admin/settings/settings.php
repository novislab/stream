<?php

declare(strict_types=1);

use App\Models\Setting;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Admin Settings')] class extends Component
{
    #[Validate('required|string|max:255')]
    public string $appName = '';

    #[Validate('nullable|url|max:255')]
    public ?string $whatsappLink = null;

    #[Validate('nullable|url|max:255')]
    public ?string $telegramLink = null;

    #[Validate('nullable|string|max:5000')]
    public ?string $accountDetails = null;

    public function mount(): void
    {
        $this->appName = Setting::get('app_name', config('app.name'));
        $this->whatsappLink = Setting::get('whatsapp_link');
        $this->telegramLink = Setting::get('telegram_link');
        $this->accountDetails = Setting::get('account_details');
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('app_name', $this->appName);
        Setting::set('whatsapp_link', $this->whatsappLink);
        Setting::set('telegram_link', $this->telegramLink);
        Setting::set('account_details', $this->accountDetails);

        $this->updateEnvFile('APP_NAME', $this->appName);

        Flux::toast('Settings saved successfully.');
    }

    private function updateEnvFile(string $key, string $value): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return;
        }

        $envContent = file_get_contents($envPath);

        $escapedValue = str_contains($value, ' ') ? '"'.$value.'"' : $value;

        $pattern = "/^{$key}=.*/m";

        if (preg_match($pattern, $envContent)) {
            $envContent = preg_replace($pattern, "{$key}={$escapedValue}", $envContent);
        } else {
            $envContent .= "\n{$key}={$escapedValue}";
        }

        file_put_contents($envPath, $envContent);
    }
};
