<?php

/**
 * @copyright (2019 - 2022) - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

use App\Database\Models\User;
use App\Database\Models\Token;
use Core\Testing\ApplicationTestCase;
use App\Database\Factories\UserFactory;
use App\Database\Factories\TokenFactory;
use Core\Testing\Concerns\RefreshDatabase;

class EmailVerificationTest extends ApplicationTestCase
{
    use RefreshDatabase;

    public function test_can_verify_email()
    {
        $user = (new UserFactory())->create(['email_verified' => null]);
        $token = (new TokenFactory())->create(['email' => $user->email]);

        $client = $this->get("email/verify?email={$token->email}&token={$token->token}");
        $client->assertRedirectedToUrl(url('login'));

        $this->assertDatabaseDoesNotHave('tokens', $token->toArray());
    }
}
