[![codeception](https://github.com/strannyi-tip/string-list/actions/workflows/php.yml/badge.svg?branch=main)](https://github.com/strannyi-tip/string-list/actions/workflows/php.yml)

# string-list
## Simple list of strings

# usage:
```php
$list = new StringList();
$list[0] = 'string';
$list[1] = new SimpleString('string');
```
```php
$list = new StringList(new SimpleString('string'));
```
```php
$list = new StringList('one', 'two', new SimpleString('three'));
```

# Also
> [!CAUTION]
> Use int-based indexes only!
