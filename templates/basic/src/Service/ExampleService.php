<?php
declare(strict_types=1);
namespace App\Service;
final class ExampleService {
    public function greet(string $name): string { return 'Bonjour ' . $name; }
}
