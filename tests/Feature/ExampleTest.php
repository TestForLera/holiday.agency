<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Service;
use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_guest_ordering_a_service_is_sent_to_the_login_modal(): void
    {
        $service = Service::query()->where('is_active', true)->firstOrFail();
        $cabinetUrl = route('cabinet', [
            'section' => 'order-form',
            'service' => $service->id,
        ]);

        $this->get(route('services.order', $service))
            ->assertRedirect('/')
            ->assertSessionHas('open_auth', 'login')
            ->assertSessionHas('url.intended', $cabinetUrl);
    }

    public function test_selected_service_prefills_the_order_section_in_cabinet(): void
    {
        $user = User::query()->where('role', 'user')->firstOrFail();
        $service = Service::query()
            ->where('is_active', true)
            ->where('title', 'like', '%45 минут%')
            ->firstOrFail();

        $this->actingAs($user)
            ->get(route('cabinet', ['section' => 'order-form', 'service' => $service->id]))
            ->assertOk()
            ->assertSee('Вы выбрали программу')
            ->assertSee($service->title)
            ->assertSee('value="animaciya"', false)
            ->assertSee('value="45 минут" selected', false);
    }

    public function test_admin_sections_render_with_the_shared_interface(): void
    {
        $admin = User::query()->where('role', 'admin')->firstOrFail();

        $pages = [
            route('admin.dashboard') => 'Управление сайтом',
            route('admin.orders') => 'Заявки клиентов',
            route('admin.users') => 'Пользователи',
            route('admin.services.index') => 'Добавить программу',
            route('admin.packages.index') => 'Добавить пакет',
            route('admin.heroes.index') => 'Герои',
            route('admin.content.edit') => 'Контент главной страницы',
            route('admin.reviews') => 'Отзывы клиентов',
        ];

        foreach ($pages as $url => $expectedText) {
            $this->actingAs($admin)
                ->get($url)
                ->assertOk()
                ->assertSee('Административная панель')
                ->assertSee($expectedText);
        }
    }
}
