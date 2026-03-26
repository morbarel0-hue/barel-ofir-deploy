import os, base64, time, sys
from playwright.sync_api import sync_playwright
import openai

API_KEY = sys.argv[1] if len(sys.argv) > 1 else ""
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
        except Exception as e:
            print(f"  ERR shoot {url}: {e}")
        br.close()

def shoot_orig(html_file, path):
    from pathlib import Path
    with sync_playwright() as p:
        br = p.chromium.launch()
        pg = br.new_page(viewport={"width": 1280, "height": 900})
        try:
            pg.goto("file:///" + str(Path(html_file).resolve()).replace("\\", "/"),
                    wait_until="networkidle", timeout=15000)
            pg.screenshot(path=path, full_page=True)
        except Exception as e:
            print(f"  ERR orig {html_file}: {e}")
        br.close()

def b64(path):
    return base64.b64encode(open(path, "rb").read()).decode()

def ask_gpt(live, orig, name, mobile=False):
    try:
        r = gpt.chat.completions.create(
            model="gpt-4o",
            messages=[{"role": "user", "content": [
                {"type": "text", "text": f"""אתה QA engineer מקצועי.
השווה {"מובייל" if mobile else "דסקטופ"} של דף '{name}'.
תמונה 1 = האתר החי (barelofir.co.il).
תמונה 2 = העיצוב הרצוי (HTML מקורי).

בדוק:
- האם כל הסקציות קיימות (hero, trust bar, קטגוריות, מוצרים, footer וכו')?
- צבעים (אדום #c0001a, רקע שחור #111 וכו')
- גדלים ורווחים
- טיפוגרפיה (כותרות, גופן Rubik/Heebo)
- אלמנטים חסרים לגמרי
- CSS שבור (תצוגה לא נכונה)

פרט כל הבדל ברשימת נקודות.
אם זהה לחלוטין כתוב רק: PERFECT"""},
                {"type": "image_url", "image_url": {"url": f"data:image/png;base64,{b64(live)}", "detail": "high"}},
                {"type": "image_url", "image_url": {"url": f"data:image/png;base64,{b64(orig)}", "detail": "high"}},
            ]}],
            max_tokens=2000
        )
        return r.choices[0].message.content
    except Exception as e:
        return f"GPT ERROR: {e}"

PAGES = [
    ("homepage", "דף הבית",  "https://barelofir.co.il/",         "barel-homepage.html"),
    ("shop",     "חנות",     "https://barelofir.co.il/product-category/%d7%9b%d7%9c%d7%99-%d7%a2%d7%91%d7%95%d7%93%d7%94-%d7%97%d7%a9%d7%9e%d7%9c%d7%99%d7%99%d7%9d/", "barel-category.html"),
    ("cart",     "עגלה",     "https://barelofir.co.il/cart/",     "barel-cart.html"),
    ("about",    "אודות",    "https://barelofir.co.il/about/",    "barel-about.html"),
    ("contact",  "צור קשר", "https://barelofir.co.il/contact/",  "barel-contact.html"),
]

REPORTS = {}

for name, hname, url, html_file in PAGES:
    print(f"\n📸 מצלם {hname}...")
    live_d = f"qa/live_{name}.png"
    live_m = f"qa/mobile_{name}.png"
    orig   = f"qa/orig_{name}.png"

    shoot(url, live_d)
    shoot(url, live_m, mobile=True)
    orig_path = os.path.join(HTML_DIR, html_file)
    if os.path.exists(orig_path):
        shoot_orig(orig_path, orig)
    else:
        print(f"  ⚠️ HTML מקורי לא נמצא: {orig_path}")
        continue

    print(f"  🤖 שואל GPT-4o על {hname}...")
    report_d = ask_gpt(live_d, orig, hname)
    report_m = ask_gpt(live_m, orig, hname, mobile=True)

    REPORTS[name] = {"desktop": report_d, "mobile": report_m, "hname": hname}

    with open(f"qa/report_{name}.txt", "w", encoding="utf-8") as f:
        f.write(f"=== {hname} ===\n\nDESKTOP:\n{report_d}\n\nMOBILE:\n{report_m}\n")

    print(f"\n  DESKTOP [{hname}]:\n{report_d[:500]}")
    print(f"\n  MOBILE [{hname}]:\n{report_m[:300]}")

# Summary
print("\n" + "="*60)
print("📋 סיכום QA:")
all_ok = True
for name, data in REPORTS.items():
    d_ok = "PERFECT" in data["desktop"]
    m_ok = "PERFECT" in data["mobile"]
    status = "✅ PERFECT" if (d_ok and m_ok) else f"❌ יש הבדלים"
    print(f"  {data['hname']}: {status}")
    if not d_ok or not m_ok:
        all_ok = False

if all_ok:
    print("\n🎉 כל הדפים מושלמים!")
else:
    print("\n📁 דוחות מלאים נשמרו ב-qa/report_*.txt")
    print("תקן לפי הדוחות ורוץ שוב.")
