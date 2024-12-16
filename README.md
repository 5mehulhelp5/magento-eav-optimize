# EavOptimize - Magento 2 Plugin

## Description

The **EavOptimize** plugin provides a solution to optimize the performance of fetching attribute options in Magento 2. It introduces **memoization** and **caching** for EAV (Entity-Attribute-Value) attribute option values, which can improve store performance by reducing redundant database calls.

Additionally, this module forces the default value of `cache_user_defined_attributes` system configuration to `1`, ensuring that custom attributes are cached by default for better efficiency.
You can still disable this config in adminhtml.

## Features

- **Memoization:** Stores attribute option values in memory for faster repeated access during the same request lifecycle.
- **Caching:** Adds caching for custom attribute values fetched through `getAttributeText()` calls for improved overall performance.
- **Configuration Options in Admin Panel:** Allows enabling or disabling caching through a Magento System Configuration field.
- **Default Caching Behavior:** Automatically activates caching for custom attributes by setting `cache_user_defined_attributes` to `1` by default in the configuration.

## Configuration

To manage the caching behavior, navigate to the **Admin Panel**:

1. Go to `Stores > Configuration > Advanced > Developer`.
2. Locate the **Caching** section.
3. Check the `Cache Attribute Options Values` setting:
    - **Yes (default):** Enables caching for attribute option values retrieved using `getAttributeText()`.
    - **No:** Disables caching.

## Installation

1. Install the module using composer:   
   `composer require blackbird/module-eav-optimize`

2. Run the following commands to register and enable the module:
   ```bash
   bin/magento module:enable Blackbird_EavOptimize
   bin/magento setup:upgrade
   bin/magento cache:flush
   ```

## Technical Details

### Why Use EavOptimize?
Fetching EAV attribute options using `getAttributeText()` in Magento can result in multiple redundant queries, especially in cases where multiple calls retrieve the same data. The `EavOptimize` plugin avoids such performance bottlenecks by leveraging memoization to reuse data within a single request and caching to persist retrieved attribute options across requests.

### Changes Introduced
- The plugin overrides or interacts with default Magento EAV functionality to add memoization for EAV attribute option values at runtime in the class `Magento\Eav\Model\Entity\Attribute\Source\Table`.
- Adjustments are made to cache attribute options by default through `config.xml`:
  ```xml
  <default>
      <dev>
          <caching>
              <cache_user_defined_attributes>1</cache_user_defined_attributes>
              <cache_option_values>1</cache_option_values>
          </caching>
      </dev>
  </default>
  ```
- A system configuration option has been added (`system.xml`) to allow admin users to control caching behavior (`Cache Attribute Options Values`).

### Performance Benefits
1. Reduces the number of database queries during attribute option lookups.
2. Improves overall page load times, especially for pages that frequently query for attribute text (e.g., product pages, category pages).
3. Ensures smoother performance under heavy load.

## Compatibility

This module is compatible with:
- **Magento 2** version 2.3.x and above.
- PHP version used should align with Magento's compatibility.

## Usage Example

### Without EavOptimize:
When fetching an attribute's option text multiple times (e.g., by calling `getAttributeText()` in a loop), Magento may execute redundant database calls to retrieve the same data repeatedly.

### With EavOptimize:
The plugin stores these values in memory through memoization during runtime. For subsequent calls, the data is fetched directly from memory or cache instead of querying the database.

Example:
```php
$product = $productRepository->getById(1);
echo $product->getAttributeText('color'); // First call - fetched from DB or cache
echo $product->getAttributeText('color'); // Second call - fetched from memoized storage
```
---

Enjoy improved performance while managing your EAV attributes with EavOptimize! 🚀
