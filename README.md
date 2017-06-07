# Static Analytics and Code Complexity of Shopsys FW, Sylius and ...? 

Inspired by:

- [Code complexity: Symfony vs. Laravel](https://medium.com/@taylorotwell/measuring-code-complexity-64356da605f9)
- [critics of some metrics](https://news.ycombinator.com/item?id=13364649)
- [Gist by @pmjones - Laravel complexity over time](https://gist.github.com/pmjones/20109b503a4636fc58046382e7dece75)  

Based on feedback on the article and the post, there I've created 2 groups of metrics - *Basic* & *Advanced*.

### Basic

- Lines of Code (measured by [sebastianbergmann/phploc](https://github.com/sebastianbergmann/phploc))
- Average method complexity
- Maximum method complexity

### Advanced

...


## Install

```bash
composer require --dev phploc/phploc # Lines of Code
```

## Run

```bash
vendor/bin/phploc vendodr/shopsys/...
```
