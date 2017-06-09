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

## Install

```bash
git clone https://github.com/TomasVotruba/shopsys-analysis.git
cd shopsys-analysis
composer install
```

## Clones projects

As project have dependencies in conflict, they have to be cloned to own directories.

**Shopsys**

```bash
git clone git@git.shopsys-framework.com:shopsys/shopsys-framework.git --depth 1 project/shopsys
composer install -d project/shopsys
```

**Sylius**

```bash
git clone https://github.com/Sylius/Sylius.git --depth 1 --single-branch --branch v1.0.0-beta.2 project/sylius
composer install -d project/sylius
```

**Spryker**

```bash
git clone https://github.com/spryker/demoshop --depth 1 --single-branch --branch 2.14 project/spryker
composer install -d project/spryker
```
