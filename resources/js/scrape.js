const { chromium } = require('playwright');

const url = process.argv[2]; // Получаем URL из аргументов командной строки

(async () => {
    //const browser = await chromium.launch(); //в безголовом не открывает
    const browser = await chromium.launch({ headless: false });

    const page = await browser.newPage({
        ignoreHTTPSErrors: true // игнорировать ошибки SSL (если есть)
    });

    await page.goto(url, { waitUntil: 'load', timeout: 60000, http2: false });
    const html = await page.content();
    console.log(html); // Выводим HTML в консоль

    await browser.close();
})();