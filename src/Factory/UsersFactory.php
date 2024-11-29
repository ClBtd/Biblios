<?php

namespace App\Factory;

use App\Entity\Users;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Users>
 */
final class UsersFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Users::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->safeEmail(),
            'firstname' => self::faker()->firstName($gender = 'male'|'female'),
            'lastname' => self::faker()->lastName(),
            'password' => $this->hasher->hashPassword(new Users(), 'abcd1234'),
            'roles' => [self::faker()->randomElement(['ROLE_AJOUT_DE_LIVRE', 'ROLE_EDITION_DE_LIVRE', 'ROLE_ADMIN'])]
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Users $users): void {})
        ;
    }
}
