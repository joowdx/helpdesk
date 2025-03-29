<?php

namespace App\Filament\Clusters\Management\Pages;

use App\Filament\Clusters\Management;
use App\Filament\Clusters\Management\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Settings extends Page
{
    use InteractsWithFormActions;

    public array $data = [];

    protected static ?int $navigationSort = PHP_INT_MAX;

    protected static ?string $navigationIcon = 'gmdi-settings-o';

    protected static string $view = 'filament.panels.admin.clusters.organization.pages.settings';

    protected static ?string $cluster = Management::class;

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()->getId() !== 'root';
    }

    public function mount(): void
    {
        abort_unless(static::canAccess(), 403);

        $this->fillForm();
    }

    public function getBreadcrumbs(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $cluster::unshiftClusterBreadcrumbs([
                Settings::getUrl() => static::getTitle(),
            ]);
        }

        return [];
    }

    public function form(Form $form): Form
    {
        return OrganizationResource::form($form)
            ->columns(null)
            ->statePath('data');
    }

    public function update(): void
    {
        $data = $this->form->getState();

        $organization = Organization::find(Auth::user()->organization_id);

        DB::transaction(function () use ($data, $organization) {
            $organization->update($data);

            Notification::make()
                ->success()
                ->title('Settings updated')
                ->send();
        });
    }

    protected function fillForm(): void
    {
        $this->form->fill(Organization::find(Auth::user()->organization_id)->toArray());
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('Update')
                ->submit('update')
                ->keyBindings(['mod+s']),
        ];
    }
}
