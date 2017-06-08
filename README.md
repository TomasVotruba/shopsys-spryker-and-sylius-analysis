# Static Analytics and Code Complexity of Shopsys FW, Sylius and ...? 

## Used Tools

```json
"phploc/phploc": "^4.0",
"sebastian/phpcpd": "^3.0",
"pdepend/pdepend": "^2.5",
"phpmetrics/phpmetrics": "^2.2"
```

## Sources of Inspiration 

- 1. [Code complexity: Symfony vs. Laravel](https://medium.com/@taylorotwell/measuring-code-complexity-64356da605f9)
- 2. [critics of some metrics](https://news.ycombinator.com/item?id=13364649)
- 3. [Gist by @pmjones - Laravel complexity over time](https://gist.github.com/pmjones/20109b503a4636fc58046382e7dece75)  
- 4. [Diploma Thesis by @mhujer on Continuous Integration, sections 3.4-3.8](https://blog.martinhujer.cz/bp/)
- 5. [Visualize Code Quality via PHPMetrics](https://www.sitepoint.com/visualize-codes-quality-phpmetrics/)
- 6. [Average Code Metric Values in PHP](https://kaosktrl.wordpress.com/2012/08/18/php-code-metrics-statistics/)

Based on feedback on the post, thesis and after insightful consultancy with @mhujer, I've created 2 groups of metrics - *Basic* & *Advanced*.


### A. Basic 

Catchy and sexy for laics, but not telling much technical (see [Source 2.](https://news.ycombinator.com/item?id=13364649))
These can grab your attention very well.

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

### B. Advanced 

Interesting for advanced programmers, more technical and relevant to real code maintainability.

```bash
"pdepend/pdepend": "^2.5",
```


- **visualization of code by PDepend Pyramid** [metrics of expalined](https://pdepend.org/documentation/handbook/reports/overview-pyramid.html), 
 
    "The Overview Pyramid provides a simple and size independent way to get a first impression of a software system, and this without an expensive source code analysis."

- `pdepend.svg` rather than metrics provdies **weak and strong classes** in application


```bash
"phpmetrics/phpmetrics": "^2.2"
```
 
- **Lcom (lack of cohesion in methods) / Cyclomatic complexity** 
- **Difficulty / Loc (lines of code)** 


## Install

Clone this repository and install dependencies: 

```bash
composer install
```


## Run

To make is easy for you, there is prepared shortcut script in [`composer.json`](composer.json) that runs all 4 tools on all projects to compare.

```bash
composer complete 
```

Or you can run all 4 tools by themselves:

```bash
composer loc
composer cpd
composer dep
composer met
```

See `scripts` section in the end of [`composer.json`](composer.json) for more.


## View Generated Results of Some Tools  

- [see pdepend.svg](output/pdepend/pdepend.svg)
- [see pyramid.svg](output/pdepend/pyramid.svg)
- [see PHP Metrics report](output/php-metrics/)
