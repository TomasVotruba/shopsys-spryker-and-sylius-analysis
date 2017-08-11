# Setup

Spryker requires few PHP extensions. Here is how you add them:
 
**On Linux**
  
```bash
sudo 
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt-get install php7.1-bcmath
sudo apt-get install php7.1-gmp
sudo apt-get install php7.1-redis
sudo apt-get install php7.1-bz2
```

## Install this Repository

```bash
git clone https://github.com/TomasVotruba/shopsys-analysis.git shopsys-analysis
cd shopsys-analysis
composer install
```

## Clones projects To Analyze

As project have dependencies in conflict, they have to be cloned to own directories.

**Shopsys**

```bash
git clone git@git.shopsys-framework.com:shopsys/shopsys-framework.git --depth 1 project/shopsys
cd project/shopsys
git checkout 829cfde7
# August 7, 2017
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
composer install -d project/spryker
# May 24, 2017
# https://github.com/spryker/demoshop/tree/2.14
# later version had issues with installation
```
