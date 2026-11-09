<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class AvatarUploadTest extends TestCase
{
    public function test_avatar_can_be_uploaded_during_registration_and_replaced_in_profile(): void
    {
        Storage::fake('public');

        $email = Str::uuid().'@example.test';
        $user = null;

        try {
            $this->post(route('register'), [
                'name' => 'Тестовый пользователь',
                'email' => $email,
                'phone' => '+7 900 000-00-00',
                'password' => 'password',
                'password_confirmation' => 'password',
                'avatar' => UploadedFile::fake()->image('first-avatar.png'),
            ])->assertRedirect(route('cabinet'));

            $user = User::query()->where('email', $email)->firstOrFail();
            $firstAvatar = $user->avatar;

            $this->assertNotNull($firstAvatar);
            Storage::disk('public')->assertExists($firstAvatar);

            $this->actingAs($user)->post(route('update.profile'), [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => UploadedFile::fake()->image('second-avatar.jpg'),
            ])->assertSessionHas('success');

            $user->refresh();

            $this->assertNotSame($firstAvatar, $user->avatar);
            Storage::disk('public')->assertMissing($firstAvatar);
            Storage::disk('public')->assertExists($user->avatar);
        } finally {
            $user?->delete();
        }
    }
}
