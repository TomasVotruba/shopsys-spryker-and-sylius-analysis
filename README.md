# Static Analytics and Code Complexity of Shopsys FW, Sylius and ...? 

Inspired by:

- [Code complexity: Symfony vs. Laravel](https://medium.com/@taylorotwell/measuring-code-complexity-64356da605f9)
- [critics of some metrics](https://news.ycombinator.com/item?id=13364649)
- [Gist by @pmjones - Laravel complexity over time](https://gist.github.com/pmjones/20109b503a4636fc58046382e7dece75)  
- [Diploma Thesis by @mhujer on Continuous Integration, sections 3.4-3.8](https://blog.martinhujer.cz/bp/)

Based on feedback on the post, thesis and consultancy with @mhujer, there I've created 2 groups of metrics - *Basic* & *Advanced*.

 
### Basic - sexy for laics, but not really telling anyhting

- Lines of Code (measured by [sebastianbergmann/phploc](https://github.com/sebastianbergmann/phploc))
- Average method complexity
- Maximum method complexity
- @todo

### Advanced - interesting for advanced programmers, more technical

- @todo...


## Install

Clone this repository and install dependencies: 

```bash
composer install
```

## Run

```bash
composer complete
```

## View Results

Run in CLI:
 
```bash
php -S localhost:8001/output
```

Open [localhost:8001](https://localhost:8001) in browser.
