# olx-parser

A Laravel application that tracks OLX listing prices and notifies subscribers via email when a price changes.

## Price Services

Two implementations of `PriceServiceInterface` are available:

### `OlxPriceService`

Fetches the listing page HTML and extracts the price from the `application/ld+json` structured data block.

### `OlxApiPriceService`

Fetches the price directly from the OLX internal JSON API — no HTML parsing required.

**How it works:**

1. **Extract offer ID from URL**
   OLX URLs follow the pattern `.../title-ID{id}.html`. The service uses a regex to extract the numeric ID.

2. **Call the API**
   ```
   GET https://www.olx.ua/api/v1/offers/{id}/
   ```

3. **Read the price**
   The price is located at `data.price.value.value` in the response JSON.

**Comparison**

| Feature    | `OlxPriceService`  | `OlxApiPriceService` |
|------------|--------------------|----------------------|
| Source     | HTML page          | JSON API             |
| Parsing    | DOM + JSON-LD      | Pure JSON            |
| Stability  | Depends on markup  | More stable          |

To switch the active implementation, update the binding in `AppServiceProvider`:

```php
$this->app->bind(PriceServiceInterface::class, OlxApiPriceService::class);
```

---

For more details see [docs/development.md](docs/development.md).