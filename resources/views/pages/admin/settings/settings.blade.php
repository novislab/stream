<div class="space-y-6">
    <flux:heading size="xl">Settings</flux:heading>

    <form wire:submit="save" class="space-y-6">
        {{-- General Settings --}}
        <flux:card class="dark:bg-zinc-950">
            <div class="space-y-6">
                <flux:heading size="lg">General Settings</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Application Name</flux:label>
                        <flux:description>The name of your application displayed across the site.</flux:description>
                        <flux:input
                            wire:model="appName"
                            placeholder="My Application"
                        />
                        <flux:error name="appName" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Application URL</flux:label>
                        <flux:description>The base URL of your application.</flux:description>
                        <flux:input
                            type="url"
                            wire:model="appUrl"
                            placeholder="https://example.com"
                        />
                        <flux:error name="appUrl" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Application Environment</flux:label>
                        <flux:description>Current environment of your application.</flux:description>
                        <flux:select wire:model="appEnv">
                            <option value="local">Local</option>
                            <option value="testing">Testing</option>
                            <option value="production">Production</option>
                        </flux:select>
                        <flux:error name="appEnv" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Debug Mode</flux:label>
                        <flux:description>Enable or disable detailed error reporting.</flux:description>
                        <flux:checkbox wire:model="appDebug" label="Enable debug mode" />
                        <flux:error name="appDebug" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Timezone</flux:label>
                        <flux:description>The default timezone for your application.</flux:description>
                        <flux:select wire:model="appTimezone">
                            @foreach($this->getPopularTimezones() as $value => $label)
                                <option value="{{ $value }}" {{ $value === $appTimezone ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="appTimezone" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Locale</flux:label>
                        <flux:description>The default language for your application.</flux:description>
                        <flux:select wire:model="appLocale">
                            @foreach($this->getPopularLocales() as $code => $name)
                                <option value="{{ $code }}" {{ $code === $appLocale ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="appLocale" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Fallback Locale</flux:label>
                        <flux:description>The fallback language when translations are missing.</flux:description>
                        <flux:select wire:model="appFallbackLocale">
                            @foreach($this->getPopularLocales() as $code => $name)
                                <option value="{{ $code }}" {{ $code === $appFallbackLocale ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="appFallbackLocale" />
                    </flux:field>
                </div>
            </div>
        </flux:card>

        {{-- Mail Settings --}}
        <flux:card class="dark:bg-zinc-950">
            <div class="space-y-6">
                <flux:heading size="lg">Mail Settings</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Mail Driver</flux:label>
                        <flux:description>The mail service to use for sending emails.</flux:description>
                        <flux:select wire:model="mailDriver" id="mailDriver">
                            @foreach($this->getMailDrivers() as $value => $label)
                                <option value="{{ $value }}" {{ $value === $mailDriver ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="mailDriver" />
                    </flux:field>

                    <flux:field>
                        <flux:label>From Address</flux:label>
                        <flux:description>The default email address for outgoing mail.</flux:description>
                        <flux:input
                            type="email"
                            wire:model="mailFromAddress"
                            placeholder="noreply@example.com"
                        />
                        <flux:error name="mailFromAddress" />
                    </flux:field>

                    <flux:field>
                        <flux:label>From Name</flux:label>
                        <flux:description>The default name for outgoing mail.</flux:description>
                        <flux:input
                            wire:model="mailFromName"
                            placeholder="Application Name"
                        />
                        <flux:error name="mailFromName" />
                    </flux:field>
                </div>

                {{-- SMTP Settings (conditional) --}}
                <div id="smtpSettings" class="space-y-6 {{ $mailDriver !== 'smtp' ? 'hidden' : '' }}">
                    <flux:subheading>SMTP Configuration</flux:subheading>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>SMTP Host</flux:label>
                            <flux:description>The SMTP server hostname.</flux:description>
                            <flux:input
                                wire:model="mailHost"
                                placeholder="smtp.example.com"
                            />
                            <flux:error name="mailHost" />
                        </flux:field>

                        <flux:field>
                            <flux:label>SMTP Port</flux:label>
                            <flux:description>The SMTP server port.</flux:description>
                            <flux:input
                                type="number"
                                wire:model="mailPort"
                                placeholder="587"
                            />
                            <flux:error name="mailPort" />
                        </flux:field>

                        <flux:field>
                            <flux:label>SMTP Username</flux:label>
                            <flux:description>The SMTP username for authentication.</flux:description>
                            <flux:input
                                wire:model="mailUsername"
                                placeholder="username@example.com"
                            />
                            <flux:error name="mailUsername" />
                        </flux:field>

                        <flux:field>
                            <flux:label>SMTP Password</flux:label>
                            <flux:description>The SMTP password for authentication.</flux:description>
                            <flux:input
                                type="password"
                                wire:model="mailPassword"
                                placeholder="••••••••"
                            />
                            <flux:error name="mailPassword" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Encryption</flux:label>
                            <flux:description>The encryption protocol to use.</flux:description>
                            <flux:select wire:model="mailEncryption">
                                <option value="">None</option>
                                <option value="tls">TLS</option>
                                <option value="ssl">SSL</option>
                            </flux:select>
                            <flux:error name="mailEncryption" />
                        </flux:field>
                    </div>
                </div>
            </div>
        </flux:card>

        {{-- Cache & Session Settings --}}
        <flux:card class="dark:bg-zinc-950">
            <div class="space-y-6">
                <flux:heading size="lg">Cache & Session Settings</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Cache Driver</flux:label>
                        <flux:description>The caching system to use.</flux:description>
                        <flux:select wire:model="cacheDriver">
                            @foreach($this->getCacheDrivers() as $value => $label)
                                <option value="{{ $value }}" {{ $value === $cacheDriver ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="cacheDriver" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Session Driver</flux:label>
                        <flux:description>The session storage system to use.</flux:description>
                        <flux:select wire:model="sessionDriver">
                            @foreach($this->getSessionDrivers() as $value => $label)
                                <option value="{{ $value }}" {{ $value === $sessionDriver ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="sessionDriver" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Session Lifetime</flux:label>
                        <flux:description>Session lifetime in minutes.</flux:description>
                        <flux:input
                            type="number"
                            wire:model="sessionLifetime"
                            placeholder="120"
                        />
                        <flux:error name="sessionLifetime" />
                    </flux:field>
                </div>
            </div>
        </flux:card>

        {{-- Queue Settings --}}
        <flux:card class="dark:bg-zinc-950">
            <div class="space-y-6">
                <flux:heading size="lg">Queue Settings</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Queue Driver</flux:label>
                        <flux:description>The queue system to use for background jobs.</flux:description>
                        <flux:select wire:model="queueDriver">
                            @foreach($this->getQueueDrivers() as $value => $label)
                                <option value="{{ $value }}" {{ $value === $queueDriver ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="queueDriver" />
                    </flux:field>
                </div>
            </div>
        </flux:card>

        {{-- Optimize Actions --}}
        <flux:card class="dark:bg-zinc-950">
            <div class="space-y-6">
                <flux:heading size="lg">Application Optimization</flux:heading>
                <flux:description class="text-sm text-gray-500">Clear caches and optimize the application for better performance.</flux:description>

                <div class="grid grid-cols-2 sm:grid-cols-2 gap-4">
                    <flux:button wire:click="optimizeClear" icon="trash" variant="filled" class="w-full">
                        Clear All
                    </flux:button>
                    <flux:button wire:click="optimizeView" icon="document" variant="filled" class="w-full">
                        Views
                    </flux:button>
                </div>
            </div>
        </flux:card>

        {{-- Save Button --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <flux:button type="submit" variant="primary" icon="check" class="w-full sm:w-auto">
                Save Settings
            </flux:button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mailDriver = document.getElementById('mailDriver');
            const smtpSettings = document.getElementById('smtpSettings');

            if (mailDriver && smtpSettings) {
                mailDriver.addEventListener('change', function() {
                    if (this.value === 'smtp') {
                        smtpSettings.classList.remove('hidden');
                    } else {
                        smtpSettings.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</div>