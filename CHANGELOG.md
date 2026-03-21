# Changelog

## [2.2.0](https://github.com/RubenJ01/php-slugify/compare/v2.1.0...v2.2.0) (2026-03-21)


### Features

* add Infection for mutation testing ([#21](https://github.com/RubenJ01/php-slugify/issues/21)) ([7c8f135](https://github.com/RubenJ01/php-slugify/commit/7c8f135cff4623ea1b5f73c56023c68cbf392d0c))


### Bug Fixes

* resolve escaped mutations for 100% mutation score ([#23](https://github.com/RubenJ01/php-slugify/issues/23)) ([b1eb685](https://github.com/RubenJ01/php-slugify/commit/b1eb6857fd3b88619c2008c9f3322f75c9594c65))

## [2.1.0](https://github.com/RubenJ01/php-slugify/compare/v2.0.0...v2.1.0) (2026-03-14)


### Features

* add language-aware transliteration with locale option ([#17](https://github.com/RubenJ01/php-slugify/issues/17)) ([aa26c5f](https://github.com/RubenJ01/php-slugify/commit/aa26c5ffa4eca1341eb448433817df4383d11f24))
* add maxLength option for word-boundary truncation ([#19](https://github.com/RubenJ01/php-slugify/issues/19)) ([bd7c9a1](https://github.com/RubenJ01/php-slugify/commit/bd7c9a1391baaf9ca4a5319b257aa7b4ec74deea))

## [2.0.0](https://github.com/RubenJ01/php-slugify/compare/v1.0.0...v2.0.0) (2026-03-14)


### ⚠ BREAKING CHANGES

* empty input now returns `''` instead of `'n-a'` by default. Use the `emptyValue` parameter to restore the previous behavior.

### Features

* add custom character mapping support to slugify ([8ae096a](https://github.com/RubenJ01/php-slugify/commit/8ae096a2e2eb7deb6982221bf2459d48dcf78a81)), closes [#4](https://github.com/RubenJ01/php-slugify/issues/4)
* make empty string behavior configurable ([#14](https://github.com/RubenJ01/php-slugify/issues/14)) ([7a1b7f7](https://github.com/RubenJ01/php-slugify/commit/7a1b7f78b29769fb812a939cb1f5f08deed6fc6f)), closes [#3](https://github.com/RubenJ01/php-slugify/issues/3)
* **slugger:** created an interface for the slugger class ([22bcfb8](https://github.com/RubenJ01/php-slugify/commit/22bcfb86a7acfb2ab95fbe299540508e06fa381d))


### Bug Fixes

* improve Woodpecker CI pipeline compatibility ([1f84f96](https://github.com/RubenJ01/php-slugify/commit/1f84f96b379650a9f2a4698fb51b3d0339319c97))

## 1.0.0 (2026-03-12)


### Features

* **documentation:** added a readme ([00d43df](https://github.com/RubenJ01/php-slugify/commit/00d43df6e85a1b99e740a4e816ba33482aa0a90b))
* **implementation:** created a minimum working version that satisfies all unit tests ([7dcd4c3](https://github.com/RubenJ01/php-slugify/commit/7dcd4c325a86b8c2ba66a0eadf78b32ff36ebb22))
* **slugger:** added a factory class for creation of the slugger ([30f0900](https://github.com/RubenJ01/php-slugify/commit/30f090057bcb0b830939225e40678e3ff642b0ef))
* **tests:** added unit tests for a mvp ([9d62352](https://github.com/RubenJ01/php-slugify/commit/9d62352288cf13d2e646ca50808c13fb636f1dc9))
