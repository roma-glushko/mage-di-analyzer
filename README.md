# MageDIAnalyzer

MageDIAnalyzer helps to calculate and report how Magento modules affect Magento2 DI compilation process and boostrapping process.

Features:

- 🚨Calculates how many Kb each modules add to the DI metadata
- 📈Counts how many arguments, preferences, virtual types modules add to DI metadata files

## Installation

The process is the same as for any other composer-based project:

```bash
git clone https://github.com/roma-glushko/mage-di-analyzer.git
cd mage-di-analyzer
composer install
```

## Usage

Put your project to the production mode and copy DI metadata files from `generated/metadata` to the project `tmp` directory.

Then, MageDIAnalyzer will be able to check the files by running:

```bash
./bin/mage-di-analyzer analyze ./tmp/ -a global -f csv
```

## Command Examples

```bash
./bin/mage-di-analyzer analyze ./tmp/ -a global -f csv
./bin/mage-di-analyzer analyze ./tmp/ -a adminhtml -f csv
./bin/mage-di-analyzer analyze ./tmp/ -a frontend -f csv
./bin/mage-di-analyzer analyze ./tmp/ -a crontab -f csv
./bin/mage-di-analyzer analyze ./tmp/ -a webapi_rest -f csv
./bin/mage-di-analyzer analyze ./tmp/ -a webapi_soap -f csv
```
