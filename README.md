# Code Complexity of [Shopsys FW](https://www.shopsys-framework.com/), [Spryker](https://spryker.com/) & [Sylius](http://sylius.org/)

[![Build Status](https://img.shields.io/travis/TomasVotruba/shopsys-spryker-and-sylius-analysis.svg?style=flat-square)](https://travis-ci.org/TomasVotruba/shopsys-spryker-and-sylius-analysis)

You can find nice summary of these metrics 2 posts:

- [Shopsys, Spryker & Sylius under Static Analysis](https://www.tomasvotruba.cz/blog/2017/08/28/shopsys-spriker-and-sylius-under-static-analysis/)
- [tba](tba)

To be sure we're not making them up, you can **run them yourself on you local machine**:


## 1. Install

[Spryker](https://spryker.com/) requires few extra PHP extensions. Here is how you add them:
 
**On Linux**
  
```bash
sudo apt-get install php-bcmath php-gmp php-redis php-bz2
```

### 1.1 Install this Repository

Then you can install this repository:

```bash
git clone https://github.com/TomasVotruba/shopsys-analysis.git shopsys-analysis
cd shopsys-analysis
composer install
```

### 1.2 Clones projects To Analyze

As project have dependencies in conflict, they have to be cloned to **own directories**.

If you have all access you need, you can run prepared composer command:

```bash
composer download-projects
```

**It downloads all 3 projects to `/project` directory** for you with locked commits and installed dependencies.

## 2. Run Analysis

```bash
bin/run analyze
```

And it will print this nice summary for every project:

![Preview](docs/preview-analyze.png)


### Easy Coding Standard

This will check all 3 projects with **[`ecs-psr2.neon`](/ecs-psr2.neon) checker set**

```bash
composer ecs-psr2-shopsys
composer ecs-psr2-spryker
composer ecs-psr2-sylius
```

This will check all 3 projects with **[`ecs-clean-code.neon`](/ecs-clean-code.neon) checker set**:

```bash
composer ecs-basic-shopsys
composer ecs-basic-spryker
composer ecs-basic-sylius
```

See `scripts` section in [`composer.json`](/composer.json) for more details.

### PHPStan

Run this command to see per level errors in every project:

```bash
bin/run phpstan
```

And it will print summary for every project:

![Preview](docs/preview-phpstan.png)
