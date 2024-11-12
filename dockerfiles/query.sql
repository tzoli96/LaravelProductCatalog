SELECT
    pp.id AS product_package_id,       -- A termékcsomag azonosítóját adja vissza
    pp.title AS package_title,         -- A termékcsomag címét adja vissza
    SUM(latest_prices.price * ppc.quantity) AS total_price -- A termékcsomag teljes árát számítja ki a mennyiségek figyelembevételével
FROM
    product_packages AS pp             -- A termékcsomagokat tartalmazó tábla
        JOIN
    product_package_contents AS ppc ON pp.id = ppc.product_package_id -- Összekapcsoljuk a termékcsomag tartalmával (mely termékek tartoznak az adott csomaghoz)
        JOIN
    products AS p ON ppc.product_id = p.id -- Összekapcsoljuk a termékekkel, hogy elérjük a termékek adatait (pl. termékazonosító)
        JOIN
    (
        SELECT
            ph1.product_id,             -- A termék azonosítója
            ph1.price                   -- A termék aktuális ára az adott időpontig
        FROM
            price_history AS ph1         -- Az árváltozásokat tartalmazó tábla (minden terméknél elérhető minden árváltozás időponttal együtt)
                JOIN
            (
                SELECT product_id, MAX(updated_at) AS latest_date
                FROM price_history
                WHERE updated_at <= '2024-01-02 19:32:10' -- Csak az adott időpontig érvényes árakat vizsgáljuk
                GROUP BY product_id                     -- Minden termékhez kiválasztjuk a legfrissebb dátumot az adott időpontig
            ) AS ph2 ON ph1.product_id = ph2.product_id
                AND ph1.updated_at = ph2.latest_date -- Csak azokat az árakat választjuk ki, amelyek a legfrissebbek az adott dátumig
    ) AS latest_prices ON p.id = latest_prices.product_id -- A legfrissebb árakat összekapcsoljuk a termékekkel
WHERE
        pp.id = 1 -- Csak az 1-es azonosítójú termékcsomagot vizsgáljuk
GROUP BY
    pp.id; -- Csoportosítjuk a lekérdezést termékcsomagonként (mivel minden termékcsomagnál különböző termékek lehetnek)
