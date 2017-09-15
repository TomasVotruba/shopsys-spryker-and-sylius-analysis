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
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt-get install php7.1-bcmath
sudo apt-get install php7.1-gmp
sudo apt-get install php7.1-redis
sudo apt-get install php7.1-bz2
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



**Shopsys**

You need to request access to Beta first - [do it here](https://www.shopsys-framework.com/) .

```bash
git clone git@git.shopsys-framework.com:shopsys/shopsys-framework.git --depth 1 project/shopsys
git -C project/shopsys checkout bc0de371836afff333c364b517b7c8ef2050060e
# September 5, 2017
```

**Sylius**

```bash
git clone https://github.com/Sylius/Sylius.git --depth 1 --single-branch --branch v1.0.0-beta.3 project/sylius
# July 25, 2017
# https://github.com/Sylius/Sylius/releases/tag/v1.0.0-beta.3
```

**Spryker**

This will install sandbox, but the framework code is in localed in its `spryker/*` dependencies. 
Therefore `composer install` command is needed in addition to git clone.

```bash
git clone https://github.com/spryker/demoshop --depth 1 --single-branch --branch 2.14 project/spryker
composer install --working-dir project/spryker
# May 24, 2017
# https://github.com/spryker/demoshop/tree/2.14
# later version had issues with installation
```

## 2. Run Analysis

```bash
bin/analyze
```

And it will print this nice summary for every project:


![Preview](docs/preview.png)


### Easy Coding Standard

Run by these commands. See `scripts` section in `composer.json` for more details:

```bash
composer ecs-basic
composer ecs-psr2
```

### PHPStan

Run this command. See `scripts` section in `composer.json` for more details:

```bash
composer phpstan-0
composer phpstan-max
```
