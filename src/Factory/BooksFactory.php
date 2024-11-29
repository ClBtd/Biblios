<?php

namespace App\Factory;

use App\Entity\Books;
use App\Enum\BookStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Books>
 */
final class BooksFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Books::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'author' => AuthorsFactory::random(),
            'editedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'editor' => EditorsFactory::random(),
            'isbn' => self::faker()->isbn13(),
            'pageNumber' => self::faker()->randomNumber(),
            'plot' => self::faker()->text(),
            'status' => self::faker()->randomElement(BookStatus::cases()),
            'title' => self::faker()->unique()->sentence(),
            'cover' => self::faker()->imageUrl(330, 500, 'couverture', true)
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Books $books): void {})
        ;
    }
}
