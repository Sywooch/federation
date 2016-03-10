<?php
$serverName = 'http://' . $_SERVER['SERVER_NAME'];

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<urlset xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns='http://www.sitemaps.org/schemas/sitemap/0.9' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'>\n";
if (! empty($urlsAll)) {
    foreach ($urlsAll as $urls) {
        if (! empty($urls)) {
            foreach ($urls as $url) {
                if (! empty($url)) {
                    foreach ($url as $u) {
                        echo "<url>\n\t";
                        echo "<loc>{$serverName}{$u['url']}</loc>\n\t";
                        echo "<changefreq>{$u['change']}</changefreq>\n\t";
                        echo "<priority>{$u['priority']}</priority>\n";
                        echo "</url>\n";
                    }
                }
            }
        }
    }
}
echo '</urlset>';