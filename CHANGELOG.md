# Change Log

All notable changes to this project will be documented in this file. This project adheres
to [Semantic Versioning] (http://semver.org/). For change log format,
use [Keep a Changelog] (http://keepachangelog.com/).

## [1.0.0-beta2] - 2021-07-07

### Added

- New helper methods to build queries: `whereContains()`, `whereStartsWith()`, `whereEndsWith()`, `havingContains()`, `havingStartsWith()`, `havingEndsWith()`

### Changed

- Stop to beautify and indent... SQL queries

### Removed

- @package attributes from PhpDoc

### Fixed

- Count method of query builder with grouped select

## [1.0.0-beta1] - 2021-06-02

Initial development.
