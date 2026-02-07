<?php

declare(strict_types=1);

use App\Models\SocialLink;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::admin')] #[Title('Admin Social Links')] class extends Component
{
    public $socialLinks;

    public $showAddForm = false;

    // New social link form fields
    #[Validate('required|string|max:255')]
    public string $new_platform = '';

    #[Validate('required|url|max:255')]
    public string $new_url = '';

    // Array to hold editing states for each social link
    public $editingSocialLinks = [];

    public function mount(): void
    {
        $this->socialLinks = SocialLink::all();
        $this->initializeEditingSocialLinks();
    }

    public function initializeEditingSocialLinks(): void
    {
        foreach ($this->socialLinks as $socialLink) {
            $this->editingSocialLinks[$socialLink->id] = [
                'platform' => $socialLink->platform,
                'url' => $socialLink->url,
            ];
        }
    }

    public function showAddSocialLinkForm(): void
    {
        $this->showAddForm = true;
        $this->reset(['new_platform', 'new_url']);
    }

    public function hideAddSocialLinkForm(): void
    {
        $this->showAddForm = false;
        $this->reset(['new_platform', 'new_url']);
    }

    public function saveNewSocialLink(): void
    {
        $this->validate([
            'new_platform' => 'required|string|max:255',
            'new_url' => 'required|url|max:255',
        ]);

        SocialLink::create([
            'platform' => $this->new_platform,
            'url' => $this->new_url,
        ]);

        $this->hideAddSocialLinkForm();
        $this->socialLinks = SocialLink::all();
        $this->initializeEditingSocialLinks();
        Flux::toast('Social link added successfully.');
    }

    public function updateSocialLink($id): void
    {
        $socialLink = SocialLink::find($id);
        if (! $socialLink) {
            return;
        }

        $editingData = $this->editingSocialLinks[$id] ?? [];

        $this->validate([
            "editingSocialLinks.{$id}.platform" => 'required|string|max:255',
            "editingSocialLinks.{$id}.url" => 'required|url|max:255',
        ]);

        $socialLink->update($editingData);
        $this->socialLinks = SocialLink::all();
        $this->initializeEditingSocialLinks();
        Flux::toast('Social link updated successfully.');
    }

    public function deleteSocialLink($id): void
    {
        $socialLink = SocialLink::find($id);
        if ($socialLink) {
            $socialLink->delete();
            unset($this->editingSocialLinks[$id]);
            $this->socialLinks = SocialLink::all();
            Flux::toast('Social link deleted successfully.');
        }
    }

    public function resetSocialLink($id): void
    {
        $socialLink = SocialLink::find($id);
        if ($socialLink) {
            $this->editingSocialLinks[$id] = [
                'platform' => $socialLink->platform,
                'url' => $socialLink->url,
            ];
            Flux::toast('Social link reset to original values.');
        }
    }
};
