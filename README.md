# Three.js product configurator starter: price it server-side, not in JavaScript

A tiny, framework-free Three.js product configurator that shows the one architectural decision most browser configurators get wrong: **the price must be computed on the server, never trusted from the browser.**

The product here is a generic parametric shelf. Pick the width, the number of shelves and the finish, watch it rebuild in 3D, and see the price update. The point is not the shelf. The point is where the number comes from.

## The lesson

Open the devtools on a lot of product configurators, switch to the Network or Sources tab, and you can read the price list. Quantity tiers, material multipliers, discounts, all sitting in the JavaScript bundle. Anyone can change the number before it reaches your order.

Obfuscating the bundle does not fix this. It buys a false sense of safety. Someone with the Network tab still sees the request go out.

The fix is boring and total: the browser price is a preview for instant feel while the user drags a slider. The server recomputes the price from scratch when a quote or order is created, and that number is the only one that counts. If the two ever disagree, the browser was wrong by definition.

This repo shows both sides so the contrast is obvious:

- [`index.html`](index.html) builds the 3D shelf and shows a live price. That client price is clearly marked as a preview, for UX only.
- [`price.php`](price.php) is the authoritative pricing. In production this is the only price that reaches an order. Swap PHP for whatever your backend speaks, the shape is the same.

## Run it

Static front end, no build step:

```bash
# any static server works
npx serve .
# or
python -m http.server 8000
```

Open the page. To see the server have the final say, serve `price.php` with PHP and point the fetch in `index.html` at it:

```bash
php -S localhost:8000
```

The client still draws an instant price while you configure. On "Get quote" it asks the server, and the server's number wins.

## What this is and is not

This is an educational starter: generic geometry, clean code, MIT licensed. Fork it, strip it, learn the pattern.

It is not a production system. A real configurator for your products carries your actual geometry, your pricing rules, validation so nobody configures something you cannot manufacture, a quote and order flow, roles, and a back office. That is custom work.

## Who made this

I build custom 3D product configurators for manufacturers: furniture, pergolas, gates, packaging, trade-fair stands, wellness. The client configures a made-to-measure product, sees it in 3D, and gets a price computed on my terms, not guessed in the browser.

If you need a production configurator for your own products, that is what I do.

- Site: https://grodev.pl/konfigurator-produktowy-3d
- International: https://grodev.pl/en/custom-3d-configurator
- The full write-up behind this repo: https://dev.to/gronskideveloper/your-product-configurator-should-price-server-side-not-in-javascript

Dominik Groński GroDev, Poznań.

## License

MIT. See [LICENSE](LICENSE).
