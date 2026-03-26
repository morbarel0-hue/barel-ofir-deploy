import puppeteer from 'puppeteer';

const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 900 });
const url = 'https://barelofir.co.il/product/%d7%9e%d7%a7%d7%93%d7%97-hss-%d7%98%d7%99%d7%98%d7%a0%d7%99%d7%95%d7%9d-2-0-%d7%9e%d7%9e-2-%d7%99%d7%97-%d7%91%d7%91%d7%9c%d7%99%d7%a1%d7%98%d7%a8-the-hardware-company/';
await page.goto(url, { waitUntil: 'networkidle2', timeout: 30000 });
const title = await page.title();
console.log('Title:', title);
await page.screenshot({ path: 'temporary screenshots/single-prod-test.png', fullPage: false });
console.log('done');
await browser.close();
