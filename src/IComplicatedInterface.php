<?php declare(strict_types=1);

namespace Winnie\LaraDebut;

// 複雜的介面
interface IComplicatedInterface
{
    public function method1(string $a, string $b, bool $c, int $x, object $o);
    public function method2(string $b, bool $c, int $x, object $o);
    public function method3(bool $c, int $x, object $o);
}
