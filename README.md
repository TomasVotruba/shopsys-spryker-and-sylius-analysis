# Code Complexity of [Shopsys FW](https://www.shopsys-framework.com/), [Spryker](https://spryker.com/) & [Sylius](http://sylius.org/)

[![Build Status](https://img.shields.io/travis/TomasVotruba/shopsys-analysis.svg?style=flat-square)](https://travis-ci.org/TomasVotruba/shopsys-analysis)


You can find nice summary of these metrics [in a blogpost](@todo - complete when published).

But to be sure, you can **run them yourself on you local machine**:


## Install

See [Setup page](/docs/setup.md)

@todo move here?


```bash
composer update
```

## Run Analysis

```bash
bin/analyze
```


@todo: screenshot



## Extra - PHPMetrics

A [PHPMetrics](https://github.com/phpmetrics/PhpMetrics) tool is not included in main analysis, because it provides various data and graphs and the most important numbers are already included in previous tools. Yet you could **be interested in specific metrics or their relations** (e.g. complexity/lines of code) and PHPMetrics is the best tool to find them in.

You can run it:

```bash
composer met # php metrics output
```

It will take a while - around 8-10 minutes - thanks to big amount of code for Spryker. So take a break a and have a coffee.

Then, you can go to particular directories to see results:

```php
/output/shopsys/php-metrics/
/output/spryker/php-metrics/
/output/sylius/php-metrics/
```


### Resources

If you want to read more about code complexity, you can read sources used for this analysis: 

- [Code complexity: Symfony vs. Laravel](https://medium.com/@taylorotwell/measuring-code-complexity-64356da605f9)
    - [critics of some metrics](https://news.ycombinator.com/item?id=13364649)
- [Diploma Thesis by @mhujer on Continuous Integration, sections 3.4-3.8](https://blog.martinhujer.cz/bp/)
- [Visualize Code Quality via PHPMetrics](https://www.sitepoint.com/visualize-codes-quality-phpmetrics/)


### Notes

- PHPMetrics excludes `/vendor` (and [other directories](https://github.com/phpmetrics/PhpMetrics/blob/d0a127cd2da8e75a56b7a27eff7a153c6fed83e6/src/Hal/Application/Config/TreeBuilder.php#L48)) by default, so `--exlude=...` filter have to be added manually to override and reset this default settings.
