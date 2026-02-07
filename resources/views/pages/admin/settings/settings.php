<?php

declare(strict_types=1);

use App\Models\Setting;
use Flux\Flux;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Admin Settings')] class extends Component
{
    // General Settings
    #[Validate('required|string|max:255')]
    public string $appName = '';

    #[Validate('required|url|max:255')]
    public string $appUrl = '';

    #[Validate('required|in:local,testing,production')]
    public string $appEnv = 'local';

    #[Validate('required|boolean')]
    public bool $appDebug = false;

    #[Validate('required|timezone')]
    public string $appTimezone = 'UTC';

    #[Validate('required|string|max:10')]
    public string $appLocale = 'en';

    #[Validate('required|string|max:10')]
    public string $appFallbackLocale = 'en';

    // Mail Settings
    #[Validate('required|in:smtp,mailgun,ses,sendmail,log,postmark,resend')]
    public string $mailDriver = 'log';

    #[Validate('nullable|string|max:255')]
    public ?string $mailHost = null;

    #[Validate('nullable|string|max:5')]
    public ?string $mailPort = null;

    #[Validate('nullable|string|max:255')]
    public ?string $mailUsername = null;

    #[Validate('nullable|string')]
    public ?string $mailPassword = null;

    #[Validate('nullable|in:tls,ssl')]
    public ?string $mailEncryption = null;

    #[Validate('nullable|email|max:255')]
    public ?string $mailFromAddress = null;

    #[Validate('nullable|string|max:255')]
    public ?string $mailFromName = null;

    // Cache Settings
    #[Validate('required|in:file,redis,database,memcached,array')]
    public string $cacheDriver = 'redis';

    // Session Settings
    #[Validate('required|in:file,redis,database,cookie')]
    public string $sessionDriver = 'redis';

    #[Validate('required|integer|min:5|max:525600')]
    public int $sessionLifetime = 120;

    // Queue Settings
    #[Validate('required|in:sync,database,redis,sqs,beanstalkd')]
    public string $queueDriver = 'redis';

    public function mount(): void
    {
        // General Settings
        $this->appName = Setting::get('app_name', config('app.name'));
        $this->appUrl = config('app.url');
        $this->appEnv = config('app.env');
        $this->appDebug = config('app.debug');
        $this->appTimezone = config('app.timezone');
        $this->appLocale = config('app.locale');
        $this->appFallbackLocale = config('app.fallback_locale');

        // Mail Settings
        $this->mailDriver = config('mail.default');
        $this->mailHost = config('mail.mailers.smtp.host');
        $this->mailPort = config('mail.mailers.smtp.port');
        $this->mailUsername = config('mail.mailers.smtp.username');
        $this->mailPassword = config('mail.mailers.smtp.password');
        $this->mailEncryption = config('mail.mailers.smtp.encryption');
        $this->mailFromAddress = config('mail.from.address');
        $this->mailFromName = config('mail.from.name');

        // Cache Settings
        $this->cacheDriver = config('cache.default');

        // Session Settings
        $this->sessionDriver = config('session.driver');
        $this->sessionLifetime = config('session.lifetime');

        // Queue Settings
        $this->queueDriver = config('queue.default');
    }

    public function save(): void
    {
        $this->validate();

        // Create backup of .env file
        $this->createEnvBackup();

        try {
            // Prepare environment updates
            $envUpdates = [];

            // General Settings
            $envUpdates['APP_NAME'] = $this->appName;
            $envUpdates['APP_URL'] = $this->appUrl;
            $envUpdates['APP_ENV'] = $this->appEnv;
            $envUpdates['APP_DEBUG'] = $this->appDebug ? 'true' : 'false';
            $envUpdates['APP_TIMEZONE'] = $this->appTimezone;
            $envUpdates['APP_LOCALE'] = $this->appLocale;
            $envUpdates['APP_FALLBACK_LOCALE'] = $this->appFallbackLocale;

            // Mail Settings
            $envUpdates['MAIL_MAILER'] = $this->mailDriver;
            if ($this->mailDriver === 'smtp') {
                $envUpdates['MAIL_HOST'] = $this->mailHost ?? '';
                $envUpdates['MAIL_PORT'] = $this->mailPort ?? '587';
                $envUpdates['MAIL_USERNAME'] = $this->mailUsername ?? '';
                $envUpdates['MAIL_PASSWORD'] = $this->mailPassword ?? '';
                $envUpdates['MAIL_ENCRYPTION'] = $this->mailEncryption ?? 'tls';
            }
            $envUpdates['MAIL_FROM_ADDRESS'] = $this->mailFromAddress ?? '';
            $envUpdates['MAIL_FROM_NAME'] = $this->mailFromName ?? '';

            // Cache Settings
            $envUpdates['CACHE_DRIVER'] = $this->cacheDriver;

            // Session Settings
            $envUpdates['SESSION_DRIVER'] = $this->sessionDriver;
            $envUpdates['SESSION_LIFETIME'] = (string) $this->sessionLifetime;

            // Queue Settings
            $envUpdates['QUEUE_CONNECTION'] = $this->queueDriver;

            // Update .env file
            $this->updateEnvFileMultiple($envUpdates);

            // Update settings in database
            Setting::set('app_name', $this->appName);

            Flux::toast('Settings saved successfully.');

        } catch (Exception $e) {
            Flux::toast('Error saving settings: '.$e->getMessage(), 'error');
        }
    }

    private function createEnvBackup(): bool
    {
        $envPath = base_path('.env');
        $backupPath = base_path('.env.backup.'.date('Y-m-d_H-i-s'));

        if (! file_exists($envPath)) {
            return false;
        }

        return copy($envPath, $backupPath);
    }

    private function updateEnvFileMultiple(array $updates): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            throw new Exception('.env file not found');
        }

        $envContent = file_get_contents($envPath);

        foreach ($updates as $key => $value) {
            $escapedValue = (str_contains((string) $value, ' ') || str_contains((string) $value, '#')) ? '"'.$value.'"' : $value;
            $pattern = "/^{$key}=.*/m";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "{$key}={$escapedValue}", $envContent);
            } else {
                $envContent .= "\n{$key}={$escapedValue}";
            }
        }

        if (file_put_contents($envPath, $envContent) === false) {
            throw new Exception('Failed to write to .env file');
        }
    }

    public function getPopularTimezones(): array
    {
        return [
            'UTC' => 'UTC (Coordinated Universal Time)',
            'Africa/Lagos' => 'Lagos, Nigeria',
            'Africa/Nairobi' => 'Nairobi, Kenya',
            'Africa/Johannesburg' => 'Johannesburg, South Africa',
            'Africa/Cairo' => 'Cairo, Egypt',
            'America/New_York' => 'New York, USA (EST/EDT)',
            'America/Chicago' => 'Chicago, USA (CST/CDT)',
            'America/Denver' => 'Denver, USA (MST/MDT)',
            'America/Los_Angeles' => 'Los Angeles, USA (PST/PDT)',
            'America/Sao_Paulo' => 'São Paulo, Brazil',
            'Europe/London' => 'London, UK (GMT/BST)',
            'Europe/Paris' => 'Paris, France',
            'Europe/Berlin' => 'Berlin, Germany',
            'Europe/Moscow' => 'Moscow, Russia',
            'Asia/Dubai' => 'Dubai, UAE',
            'Asia/Kolkata' => 'Kolkata, India',
            'Asia/Shanghai' => 'Shanghai, China',
            'Asia/Tokyo' => 'Tokyo, Japan',
            'Asia/Singapore' => 'Singapore',
            'Australia/Sydney' => 'Sydney, Australia',
        ];
    }

    public function getPopularLocales(): array
    {
        return [
            'en' => 'English',
            'fr' => 'French',
            'es' => 'Spanish',
            'pt' => 'Portuguese',
            'de' => 'German',
            'it' => 'Italian',
            'ru' => 'Russian',
            'ar' => 'Arabic',
            'zh' => 'Chinese',
            'ja' => 'Japanese',
            'hi' => 'Hindi',
        ];
    }

    public function getMailDrivers(): array
    {
        return [
            'smtp' => 'SMTP',
            'mailgun' => 'Mailgun',
            'ses' => 'Amazon SES',
            'sendmail' => 'Sendmail',
            'log' => 'Log (for development)',
            'postmark' => 'Postmark',
            'resend' => 'Resend',
        ];
    }

    public function getCacheDrivers(): array
    {
        return [
            'file' => 'File',
            'redis' => 'Redis',
            'database' => 'Database',
            'memcached' => 'Memcached',
            'array' => 'Array (for testing)',
        ];
    }

    public function getSessionDrivers(): array
    {
        return [
            'file' => 'File',
            'redis' => 'Redis',
            'database' => 'Database',
            'cookie' => 'Cookie',
        ];
    }

    public function getQueueDrivers(): array
    {
        return [
            'sync' => 'Sync (immediate)',
            'database' => 'Database',
            'redis' => 'Redis',
            'sqs' => 'Amazon SQS',
            'beanstalkd' => 'Beanstalkd',
        ];
    }

    public function optimizeClear(): void
    {
        try {
            Artisan::call('optimize:clear');
            Flux::toast('Application cache cleared successfully.');
        } catch (Exception $e) {
            Flux::toast('Error clearing cache: '.$e->getMessage(), 'error');
        }
    }

    public function optimizeView(): void
    {
        try {
            Artisan::call('view:cache');
            Flux::toast('Views compiled successfully.');
        } catch (Exception $e) {
            Flux::toast('Error compiling views: '.$e->getMessage(), 'error');
        }
    }
};
