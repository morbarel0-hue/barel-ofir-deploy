import sys, io, os, base64, time
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8', errors='replace')
sys.stderr = io.TextIOWrapper(sys.stderr.buffer, encoding='utf-8', errors='replace')

from playwright.sync_api import sync_playwright
import openai

API_KEY = sys.argv[1]
gpt = openai.OpenAI(api_key=API_KEY)
HTML_DIR = r"C:\Users\morba\Downloads\barel-files"
os.makedirs("qa", exist_ok=True)

def shoot(url, path, mobile=False):
    with sync_playwright() as p:
        br = p.chromium.launch()
        if mobile:
            ctx = br.new_context(**p.devices["iPhone 13"])
            pg = ctx.new_page()
        else:
            pg = br.new_page(viewport={"width": 1280, "height": 900})
        try:
            pg.goto(url, wait_until="networkidle", timeout=25000)
            time.sleep(1)
            pg.screenshot(path=path, full_page=True)
            print(f"  Shot: {path}")
        except Exception as e:
            print(f"  ERR: {e}")
        br.close()

def shoot_orig(html_file, path):
    from pathlib import Path
    uri = "file:///" + str(Path(html_file).resolve()).replace("\\", "/")
    with sync_playwright() as p:
        br = p.chromium.launch()
        pg = br.new_page(viewport={"width": 1280, "height": 900})
        try:
            pg.goto(uri, wait_until="networkidle", timeout=15000)
            pg.screenshot(path=path, full_page=True)
        except Exception as e:
            print(f"  ERR orig: {e}")
        br.close()

def b64img(path):
    return base64.b64encode(open(path, "rb").read()).decode()

def ask_gpt(live, orig, name, mobile=False):
    try:
        r = gpt.chat.completions.create(
            model="gpt-4o",
            messages=[{"role": "user", "content": [
                {"type": "text", "text": (
                    f"You are a professional QA engineer. Compare the {'mobile' if mobile else 'desktop'} version of page '{name}'.\n"
                    "Image 1 = LIVE site (barelofir.co.il). Image 2 = DESIRED design (original HTML).\n"
                    "List every visible difference: colors, sizes, missing sections, broken layout, fonts.\n"
                    "Be specific (e.g. 'hero height is 200px but should be 400px').\n"
                    "If they are identical write ONLY: PERFECT"
                )},
                {"type": "image_url", "image_url": {"url": f"data:image/png;base64,{b64img(live)}", "detail": "high"}},
                {"type": "image_url", "image_url": {"url": f"data:image/png;base64,{b64img(orig)}", "detail": "high"}},
            ]}],
            max_tokens=2000
        )
        return r.choices[0].message.content
    except Exception as e:
        return f"GPT ERROR: {e}"

PAGES = [
    ("homepage", "https://barelofir.co.il/", "barel-homepage.html"),
    ("category", "https://barelofir.co.il/product-category/%d7%9b%d7%9c%d7%99-%d7%a2%d7%91%d7%95%d7%93%d7%94-%d7%97%d7%a9%d7%9e%d7%9c%d7%99%d7%99%d7%9d/", "barel-category.html"),
    ("cart",     "https://barelofir.co.il/cart/",    "barel-cart.html"),
    ("about",    "https://barelofir.co.il/about/",   "barel-about.html"),
    ("contact",  "https://barelofir.co.il/contact/", "barel-contact.html"),
]

REPORTS = {}
for name, url, html_file in PAGES:
    print(f"\n--- {name} ---")
    live_d = f"qa/live_{name}.png"
    live_m = f"qa/mobile_{name}.png"
    orig   = f"qa/orig_{name}.png"

    shoot(url, live_d)
    shoot(url, live_m, mobile=True)

    orig_path = os.path.join(HTML_DIR, html_file)
    if not os.path.exists(orig_path):
        print(f"  SKIP: {orig_path} not found")
        continue

    shoot_orig(orig_path, orig)

    print(f"  Asking GPT-4o desktop...")
    report_d = ask_gpt(live_d, orig, name)
    print(f"  Asking GPT-4o mobile...")
    report_m = ask_gpt(live_m, orig, name, mobile=True)

    REPORTS[name] = {"desktop": report_d, "mobile": report_m}

    report_file = f"qa/report_{name}.txt"
    with open(report_file, "w", encoding="utf-8") as f:
        f.write(f"PAGE: {name}\n\nDESKTOP:\n{report_d}\n\n{'='*60}\n\nMOBILE:\n{report_m}\n")

    print(f"\n  Desktop GPT:\n{report_d}")
    print(f"\n  Mobile GPT:\n{report_m[:400]}")

print("\n" + "="*60)
print("SUMMARY:")
all_perfect = True
for name, data in REPORTS.items():
    d_ok = "PERFECT" in data["desktop"]
    m_ok = "PERFECT" in data["mobile"]
    ok = d_ok and m_ok
    if not ok:
        all_perfect = False
    print(f"  {name}: desktop={'PERFECT' if d_ok else 'ISSUES'} | mobile={'PERFECT' if m_ok else 'ISSUES'}")

if all_perfect:
    print("\nALL PERFECT!")
else:
    print("\nIssues found. Check qa/report_*.txt for details.")
