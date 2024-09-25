# Change Log

All notable changes to this project will be documented in this file. This project adheres
to [Semantic Versioning] (http://semver.org/). For change log format,
use [Keep a Changelog] (http://keepachangelog.com/).

## [1.0.0-beta11] - 2024-09-25

### Changed

- Bump `hectororm/connection` version to 1.0.0-beta7

## [1.0.0-beta10] - 2024-07-10

### Changed

- INSERT syntax to be conformed to SQL

### Removed

- `Assignment` component on `QueryBuilder` class

## [1.0.0-beta9] - 2024-03-19

### Added

- "Ignore" parameter for inserts to the query builder

## [1.0.0-beta8] - 2024-03-19

### Added

- "Ignore" parameter for inserts

### Changed

- The distinct parameter is reset when select is reset

## [1.0.0-beta7] - 2023-07-21

### Added

- The distinct parameter can be a closure

### Changed

- Quote aliases in components

## [1.0.0-beta6] - 2022-09-05

### Added

- `QueryBuilder::insert()` accept a statement in assignment

### Changed

- Compatibility with `hectororm/connection` version 1.0.0-beta6

## [1.0.0-beta5] - 2022-06-24

### Added

- Bind parameters in builder and queries objects

### Changed

- `QueryBuilder` implements `StatementInterface`
- Use `BinParamList` object instead array

## [1.0.0-beta4] - 2022-02-19

### Fixed

- Array cast of sub values for binding
- Count with "having" conditions
- Count with DISTINCT selection

## [1.0.0-beta3] - 2021-08-27

### Added

- New helper methods to build queries: `whereNull()`, `whereNotNull()`, `havingNull()`, `havingNotNull()`

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
