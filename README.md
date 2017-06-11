# Code Complexity of Shopsys FW, Sylius and Spryker 

```bash
"sebastian/phpcpd": "^3.0",
```

- **Lines of Code**
- **Class complexity**

```bash
"sebastian/phpcpd": "^3.0",
```

- **Method complexity**
- **Duplicated code**

```bash
"pdepend/pdepend": "^2.5",
```

- **Visualization of Code by PDepend Pyramid** [metrics of expalined](https://pdepend.org/documentation/handbook/reports/overview-pyramid.html), 
 
    "The Overview Pyramid provides a simple and size independent way to get a first impression of a software system, and this without an expensive source code analysis."


```bash
"phpmetrics/phpmetrics": "^1.5"
```

- **Maintainability / Complexity** image from index

See *Object oriented metrics* section in generated results

- **Average LCOM** (lack of cohesion in methods)  
- **Logical lines of code by class**
- **Logical lines of code by method**

## Install

See [Setup page](/docs/setup.md)

## Run Analysis

You can run 4 anylysing tools by themselves using short :

```bash
composer loc
composer cpd
composer dep
composer met
```

See `scripts` section in the end of [`composer.json`](composer.json) for more.


## View Generated Results of Some Tools  

Run local server to `/output` directory:

```bash
php -S localhost:8001 -t output
```

And open particular files:

- [see pdepend.svg](http://localhost:8001/pdepend/pdepend.svg)
- [see pyramid.svg](http://localhost:8001/pdepend/pyramid.svg)
- [see PHP Metrics report](http://localhost:8001/php-metrics/)


### Notes

- PHPMetrics excludes `/vendor` by default, so `--exlude=...` filter have to be added manually.



### Resources
 
If you want to read more about code complexity, you can read sources used for this analysis. 

- [Code complexity: Symfony vs. Laravel](https://medium.com/@taylorotwell/measuring-code-complexity-64356da605f9)
    - [critics of some metrics](https://news.ycombinator.com/item?id=13364649)
    - [Gist by @pmjones - Laravel complexity over time](https://gist.github.com/pmjones/20109b503a4636fc58046382e7dece75)  
- [Diploma Thesis by @mhujer on Continuous Integration, sections 3.4-3.8](https://blog.martinhujer.cz/bp/)
- [Visualize Code Quality via PHPMetrics](https://www.sitepoint.com/visualize-codes-quality-phpmetrics/)
    - [Average Code Metric Values in PHP](https://kaosktrl.wordpress.com/2012/08/18/php-code-metrics-statistics/)
