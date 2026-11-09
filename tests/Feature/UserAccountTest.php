<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserAccountTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_change_password(): void
    {
        $user = User::create([
            'name' => 'Тестовый пользователь',
            'email' => 'password-change@example.test',
            'password' => 'old-password',
            'phone' => '+7 900 000-00-00',
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->post(route('change.password'), [
                'current_password' => 'old-password',
                'new_password' => 'new-password',
                'new_password_confirmation' => 'new-password',
            ])
            ->assertRedirect(route('cabinet', ['section' => 'profile']))
            ->assertSessionHas('success', 'Пароль успешно изменён!');

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_wrong_current_password_does_not_change_password(): void
    {
        $user = User::create([
            'name' => 'Тестовый пользователь',
            'email' => 'wrong-password@example.test',
            'password' => 'old-password',
            'phone' => '+7 900 000-00-01',
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->from(route('cabinet', ['section' => 'profile']))
            ->post(route('change.password'), [
                'current_password' => 'wrong-password',
                'new_password' => 'new-password',
                'new_password_confirmation' => 'new-password',
            ])
            ->assertRedirect(route('cabinet', ['section' => 'profile']))
            ->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }

    public function test_order_price_includes_each_selected_additional_service(): void
    {
        $user = User::create([
            'name' => 'Тестовый пользователь',
            'email' => 'order-price@example.test',
            'password' => 'password',
            'phone' => '+7 900 000-00-02',
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->post(route('create.order'), [
                'fio' => 'Тестовый Пользователь',
                'email' => $user->email,
                'phone' => $user->phone,
                'children_count' => 10,
                'children_ages' => '7, 8',
                'hero_type' => 'animaciya',
                'hero_name' => 'Стич',
                'duration' => '45 минут',
                'additional' => ['neon', 'serebro'],
                'address' => 'ул. Тестовая, д. 1',
                'apartment' => '1',
                'date' => '2030-01-15',
                'time' => '13:47',
            ])
            ->assertRedirect(route('cabinet', ['section' => 'orders']));

        $order = Order::query()->where('user_id', $user->id)->firstOrFail();

        $this->assertSame('5960.00', $order->price);
    }

    public function test_order_form_displays_live_total_block(): void
    {
        $user = User::create([
            'name' => 'Тестовый пользователь',
            'email' => 'order-form@example.test',
            'password' => 'password',
            'phone' => '+7 900 000-00-03',
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('cabinet', ['section' => 'order-form']))
            ->assertOk()
            ->assertSee('Итоговая сумма заказа')
            ->assertSee('id="order-total-value"', false);
    }
}
