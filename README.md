# LaraDiner #14 - 單元測試的藝術 第五、六章

講者：[Winnie Lin](https://github.com/onecentlin)

單元測試的藝術 第二版 (The Art of Unit Testing: with examples in C# 2nd Edition)

## Chapter 5 : 隔離（模擬）框架

- [Mockery](http://docs.mockery.io/en/latest/index.html) - 範例採用 Mockery
- [PHPUnit 內建](https://phpunit.readthedocs.io/en/7.4/test-doubles.html)

## Chapter 6 : 深入了解隔離框架

### 範例執行

C# 範例程式碼以 PHP 改寫

- PHP 版本 >= 7.1
- PHPUnit 版本 7.4.4

安裝必要套件

```bash
composer install
```

執行測試

```bash
./vendor/bin/phpunit
```