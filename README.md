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

> "The Overview Pyramid provides a simple and size independent way to get a first impression of a software system, and this without an expensive source code analysis."


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

You can run 4 analysing tools:

```bash
composer loc # 1. lines of code, avg. class and method complexity
composer cpd # 2. % of duplicated code
composer dep # 3. visual pyramid
composer met # 4. php metrics output
```

See `scripts` section in the end of [`composer.json`](composer.json) for more.


## View Generated Results of Some Tools  

All output can be found in `/output` per project.


### Resources

If you want to read more about code complexity, you can read sources used for this analysis: 

- [Code complexity: Symfony vs. Laravel](https://medium.com/@taylorotwell/measuring-code-complexity-64356da605f9)
    - [critics of some metrics](https://news.ycombinator.com/item?id=13364649)
- [Diploma Thesis by @mhujer on Continuous Integration, sections 3.4-3.8](https://blog.martinhujer.cz/bp/)
- [Visualization of Code by PDepend Pyramid - metrics of expalined](https://pdepend.org/documentation/handbook/reports/overview-pyramid.html) 
- [Visualize Code Quality via PHPMetrics](https://www.sitepoint.com/visualize-codes-quality-phpmetrics/)


### Notes

- PHPMetrics excludes `/vendor` by default, so `--exlude=...` filter have to be added manually to override and reset this default settings.
