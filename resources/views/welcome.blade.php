<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Gintung Master Fitness | Gym Terbaik di Ciputat</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template/assets/images/favicon.ico') }}"/>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/css/feather.min.css') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark:        #0a0f1e;
            --dark-mid:    #0f172a;
            --dark-card:   #1e293b;
            --dark-hover:  #253044;
            --accent:      #f59e0b;
            --accent-2:    #fb923c;
            --accent-soft: rgba(245,158,11,0.12);
            --text-muted:  #94a3b8;
            --border:      rgba(255,255,255,0.07);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            background-color: var(--dark);
            font-family: 'DM Sans', sans-serif;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        /* ══ NAVBAR ══ */
        .top-nav {
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 500; padding: 0 1.5rem;
            transition: background 0.3s, border-bottom 0.3s;
        }
        .top-nav.scrolled {
            background: rgba(10,15,30,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center;
            justify-content: space-between; height: 68px;
        }
        .nav-logo {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            font-size: 1.05rem; letter-spacing: 0.02em;
            color: #fff; text-decoration: none;
            display: flex; align-items: center; gap: 8px;
        }
        .nav-logo .a { color: var(--accent); }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-link-item {
            color: var(--text-muted); text-decoration: none;
            font-size: 0.875rem; font-weight: 500;
            padding: 7px 14px; border-radius: 8px;
            transition: color 0.2s, background 0.2s;
        }
        .nav-link-item:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .btn-cta-nav {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e; font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700; font-size: 0.85rem;
            padding: 9px 20px; border-radius: 999px;
            text-decoration: none; border: none; cursor: pointer;
            transition: opacity 0.2s, transform 0.15s; white-space: nowrap;
        }
        .btn-cta-nav:hover { opacity: 0.88; transform: scale(1.03); color: #0a0f1e; }
        .nav-mobile-toggle {
            display: none; flex-direction: column; gap: 5px;
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border); border-radius: 8px;
            cursor: pointer; padding: 8px 7px;
        }
        .nav-mobile-toggle span {
            display: block; height: 2px; background: #e2e8f0;
            border-radius: 2px; transition: transform 0.25s, opacity 0.2s;
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-mobile-toggle { display: flex; }
        }

        /* ══ MOBILE MENU DRAWER ══ */
        .mobile-menu {
            position: fixed;
            top: 68px; left: 0; right: 0;
            z-index: 499;
            background: rgba(10,15,30,0.97);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.5rem 1.5rem;
            flex-direction: column;
            gap: 4px;
            transform: translateY(-8px);
            opacity: 0;
            pointer-events: none;
            transition: transform 0.25s ease, opacity 0.25s ease;
            display: flex;
        }
        .mobile-menu.open {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }
        .mobile-menu a {
            color: var(--text-muted); text-decoration: none;
            font-size: 0.95rem; font-weight: 500;
            padding: 11px 14px; border-radius: 10px;
            transition: color 0.2s, background 0.2s;
            display: flex; align-items: center; gap: 10px;
        }
        .mobile-menu a:hover, .mobile-menu a:active { color: #fff; background: rgba(255,255,255,0.06); }
        .mobile-divider { height: 1px; background: var(--border); margin: 8px 0; }
        .btn-cta-mobile {
            display: flex !important; align-items: center;
            justify-content: center; gap: 8px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2)) !important;
            color: #0a0f1e !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700 !important; font-size: 0.9rem;
            padding: 13px 20px !important; border-radius: 10px !important;
            margin-top: 4px;
        }

        /* Hamburger → X animasi */
        .nav-mobile-toggle.active span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .nav-mobile-toggle.active span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .nav-mobile-toggle.active span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ══ HERO ══ */
        .hero {
            position: relative; min-height: 100vh;
            display: flex; align-items: center; overflow: hidden;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background: url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80") no-repeat center center / cover;
            filter: brightness(0.22) saturate(0.8);
            transform: scale(1.05);
            animation: heroZoom 12s ease infinite alternate;
        }
        @keyframes heroZoom {
            from { transform: scale(1.05); }
            to   { transform: scale(1.12); }
        }
        .hero-overlay-1 {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, var(--dark) 0%, transparent 30%, transparent 60%, var(--dark) 100%);
        }
        .hero-overlay-2 {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 50%, rgba(245,158,11,0.08) 0%, transparent 70%);
        }
        .hero-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 0%, transparent 100%);
        }
        .hero-content {
            position: relative; z-index: 2;
            max-width: 1200px; margin: 0 auto;
            padding: 0 1.5rem; width: 100%;
        }
        .hero-inner {
            max-width: 780px; margin: 0 auto; text-align: center;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.22);
            color: var(--accent); font-size: 0.78rem;
            font-weight: 700; letter-spacing: 0.04em;
            text-transform: uppercase; padding: 6px 16px;
            border-radius: 999px; margin-bottom: 1.75rem;
            animation: fadeUp 0.6s 0.1s ease both;
        }
        .eyebrow-dot {
            width: 6px; height: 6px; background: var(--accent);
            border-radius: 50%; box-shadow: 0 0 8px var(--accent);
            animation: pulse 2s ease infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.7); }
        }
        .hero-title {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            font-size: clamp(2.6rem, 6vw, 4.5rem);
            line-height: 1.08; color: #fff;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s 0.2s ease both;
        }
        .hero-title .line-accent {
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-sub {
            font-size: 1.08rem; color: var(--text-muted);
            line-height: 1.75; margin-bottom: 2.5rem;
            animation: fadeUp 0.6s 0.3s ease both;
            max-width: 580px; margin-left: auto; margin-right: auto;
        }
        .hero-btns {
            display: flex; justify-content: center;
            gap: 12px; flex-wrap: wrap;
            animation: fadeUp 0.6s 0.4s ease both;
            margin-bottom: 3.5rem;
        }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e; font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 0.95rem;
            padding: 14px 32px; border-radius: 999px;
            text-decoration: none; border: none;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 0 30px rgba(245,158,11,0.25);
        }
        .btn-hero-primary:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 8px 40px rgba(245,158,11,0.4);
            color: #0a0f1e;
        }
        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.06); color: #e2e8f0;
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            font-size: 0.95rem; padding: 14px 32px;
            border-radius: 999px; text-decoration: none;
            border: 1px solid rgba(255,255,255,0.12);
            transition: background 0.2s, border-color 0.2s;
        }
        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.10);
            border-color: rgba(255,255,255,0.22); color: #fff;
        }

        /* Hero Stats */
        .hero-stats {
            display: flex; justify-content: center;
            gap: 2px; animation: fadeUp 0.6s 0.5s ease both;
        }
        .stat-item { padding: 14px 28px; text-align: center; border-right: 1px solid var(--border); }
        .stat-item:last-child { border-right: none; }
        .stat-num {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            font-size: 1.6rem; color: #fff; line-height: 1;
        }
        .stat-num .accent { color: var(--accent); }
        .stat-lbl { font-size: 0.75rem; color: var(--text-muted); margin-top: 3px; }

        /* Scroll hint */
        .scroll-hint {
            position: absolute; bottom: 2rem; left: 50%;
            transform: translateX(-50%); z-index: 2;
            display: flex; flex-direction: column;
            align-items: center; gap: 6px;
            color: var(--text-muted); font-size: 0.72rem;
            letter-spacing: 0.06em; text-transform: uppercase;
            animation: fadeIn 1s 1s ease both;
        }
        .scroll-line {
            width: 1px; height: 40px;
            background: linear-gradient(180deg, var(--accent), transparent);
            animation: scrollPulse 2s ease infinite;
        }
        @keyframes scrollPulse {
            0%   { opacity: 0; transform: scaleY(0) translateY(-50%); }
            50%  { opacity: 1; transform: scaleY(1) translateY(0%); }
            100% { opacity: 0; transform: scaleY(1) translateY(100%); }
        }

        /* ══ WHY US ══ */
        .why-section {
            padding: 7rem 1.5rem;
            position: relative;
        }
        .why-section::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(245,158,11,0.3), transparent);
        }
        .section-label {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 0.75rem; font-weight: 700;
            letter-spacing: 0.02em; text-transform: uppercase;
            color: var(--accent); margin-bottom: 12px;
        }
        .section-label::before {
            content: ''; display: block; width: 24px; height: 2px;
            background: var(--accent); border-radius: 2px;
        }
        .section-title {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            color: #fff; line-height: 1.15; margin-bottom: 1rem;
        }
        .section-sub {
            color: var(--text-muted); font-size: 1rem;
            line-height: 1.7; max-width: 520px;
        }
        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 1.1rem; margin-top: 4rem;
        }
        .feat-card {
            background: var(--dark-card); border: 1px solid var(--border);
            border-radius: 18px; padding: 2rem;
            position: relative; overflow: hidden;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
            animation: fadeUp 0.5s ease both;
        }
        .feat-card:nth-child(1) { animation-delay: 0.1s; }
        .feat-card:nth-child(2) { animation-delay: 0.18s; }
        .feat-card:nth-child(3) { animation-delay: 0.26s; }
        .feat-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0; transition: opacity 0.3s;
        }
        .feat-card:hover {
            border-color: rgba(245,158,11,0.25);
            transform: translateY(-6px);
            box-shadow: 0 16px 50px rgba(0,0,0,0.4);
        }
        .feat-card:hover::before { opacity: 1; }
        .feat-card::after {
            content: ''; position: absolute;
            width: 150px; height: 150px; border-radius: 50%;
            background: var(--accent-soft);
            top: -60px; right: -60px;
            opacity: 0; transition: opacity 0.3s; pointer-events: none;
        }
        .feat-card:hover::after { opacity: 1; }
        .feat-icon {
            width: 52px; height: 52px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.2);
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            color: var(--accent); font-size: 20px;
            margin-bottom: 1.5rem; transition: transform 0.3s;
        }
        .feat-card:hover .feat-icon { transform: scale(1.1) rotate(-5deg); }
        .feat-title {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            font-size: 1.05rem; color: #fff; margin-bottom: 10px;
        }
        .feat-desc { color: var(--text-muted); font-size: 0.875rem; line-height: 1.7; }
        .feat-tag {
            display: inline-block; margin-top: 1.25rem;
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.06em; color: var(--accent); text-transform: uppercase;
        }

        /* ══ CLASSES / PROGRAM ══ */
        .classes-section {
            padding: 6rem 1.5rem;
            position: relative;
        }
        .classes-section::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
        }
        .classes-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem; margin-top: 3.5rem;
        }
        .class-card {
            background: var(--dark-card); border: 1px solid var(--border);
            border-radius: 18px; overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
        }
        .class-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            border-color: rgba(245,158,11,0.2);
        }
        .class-img-wrap {
            position: relative; height: 180px; overflow: hidden;
        }
        .class-img-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.4s;
            filter: brightness(0.75) saturate(0.9);
        }
        .class-card:hover .class-img-wrap img { transform: scale(1.07); }
        .class-badge {
            position: absolute; top: 12px; left: 12px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e; font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 0.7rem;
            letter-spacing: 0.06em; padding: 4px 12px;
            border-radius: 999px; text-transform: uppercase;
        }
        .class-body { padding: 1.5rem; }
        .class-title {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            font-size: 1rem; color: #fff; margin-bottom: 8px;
        }
        .class-desc { color: var(--text-muted); font-size: 0.85rem; line-height: 1.6; }
        .class-meta {
            display: flex; align-items: center; gap: 12px;
            margin-top: 1rem; padding-top: 1rem;
            border-top: 1px solid var(--border);
        }
        .class-meta-item {
            display: flex; align-items: center; gap: 5px;
            font-size: 0.78rem; color: var(--text-muted);
        }
        .class-meta-item i { color: var(--accent); font-size: 13px; }

        /* ══ PRICING ══ */
        .pricing-section {
            padding: 6rem 1.5rem;
            position: relative;
        }
        .pricing-section::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(245,158,11,0.25), transparent);
        }
        .pricing-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem; margin-top: 3.5rem; align-items: start;
        }
        .price-card {
            background: var(--dark-card); border: 1px solid var(--border);
            border-radius: 20px; padding: 2rem;
            position: relative; overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
        }
        .price-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        }
        .price-card.popular {
            border-color: rgba(245,158,11,0.4);
            background: linear-gradient(160deg, #1e293b 0%, #1a2540 100%);
        }
        .price-card.popular::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
        }
        .popular-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e; font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800; font-size: 0.68rem;
            letter-spacing: 0.06em; padding: 4px 12px;
            border-radius: 999px; text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .price-plan {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            font-size: 0.85rem; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.04em;
            margin-bottom: 8px;
        }
        .price-amount {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            font-size: 2.4rem; color: #fff; line-height: 1;
            margin-bottom: 4px;
        }
        .price-amount .currency {
            font-size: 1.1rem; color: var(--accent);
            vertical-align: super; margin-right: 2px;
        }
        .price-period {
            font-size: 0.82rem; color: var(--text-muted); margin-bottom: 1.5rem;
        }
        .price-divider {
            height: 1px; background: var(--border); margin-bottom: 1.5rem;
        }
        .price-features { list-style: none; margin-bottom: 2rem; }
        .price-features li {
            display: flex; align-items: flex-start; gap: 10px;
            font-size: 0.875rem; color: #cbd5e1;
            padding: 6px 0;
        }
        .price-features li::before {
            content: '✓';
            color: var(--accent); font-weight: 800;
            font-size: 0.8rem; flex-shrink: 0;
            margin-top: 2px;
        }
        .price-features li.muted { color: var(--text-muted); }
        .price-features li.muted::before { content: '—'; color: var(--text-muted); }
        .btn-price {
            display: block; text-align: center;
            padding: 12px 24px; border-radius: 999px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            font-size: 0.88rem; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-price-outline {
            border: 1px solid rgba(245,158,11,0.4);
            color: var(--accent); background: transparent;
        }
        .btn-price-outline:hover {
            background: var(--accent-soft); color: var(--accent);
        }
        .btn-price-fill {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #0a0f1e; border: none;
            box-shadow: 0 0 24px rgba(245,158,11,0.25);
        }
        .btn-price-fill:hover {
            opacity: 0.88; transform: scale(1.02); color: #0a0f1e;
        }

        /* ══ TRAINER STRIP ══ */
        .trainer-section {
            padding: 5rem 1.5rem;
            position: relative;
        }
        .trainer-section::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
        }
        .trainer-strip {
            background: linear-gradient(135deg, #1a2235 0%, #1e293b 100%);
            border: 1px solid rgba(245,158,11,0.15);
            border-radius: 22px;
            padding: 3rem 2.5rem;
            display: flex; align-items: center; gap: 3rem;
            flex-wrap: wrap;
        }
        .trainer-icon-wrap {
            width: 80px; height: 80px; flex-shrink: 0;
            background: var(--accent-soft);
            border: 2px solid rgba(245,158,11,0.25);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--accent); font-size: 32px;
        }
        .trainer-text { flex: 1; min-width: 220px; }
        .trainer-text h3 {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            font-size: 1.35rem; color: #fff; margin-bottom: 8px;
        }
        .trainer-text p {
            color: var(--text-muted); font-size: 0.9rem; line-height: 1.65;
        }
        .trainer-badges {
            display: flex; flex-wrap: wrap; gap: 8px; margin-top: 1rem;
        }
        .t-badge {
            background: var(--accent-soft); border: 1px solid rgba(245,158,11,0.2);
            color: var(--accent); font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.02em; padding: 5px 12px;
            border-radius: 999px; text-transform: uppercase;
        }

        /* ══ LOCATION & CONTACT ══ */
        .contact-section {
            padding: 6rem 1.5rem;
            position: relative;
        }
        .contact-section::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(245,158,11,0.25), transparent);
        }
        .contact-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 2rem; margin-top: 3.5rem;
        }
        .contact-card {
            background: var(--dark-card); border: 1px solid var(--border);
            border-radius: 18px; padding: 2rem;
            transition: border-color 0.3s;
        }
        .contact-card:hover { border-color: rgba(245,158,11,0.2); }
        .contact-card-icon {
            width: 48px; height: 48px;
            background: var(--accent-soft);
            border: 1px solid rgba(245,158,11,0.2);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: var(--accent); font-size: 18px; margin-bottom: 1.25rem;
        }
        .contact-card h4 {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            font-size: 0.95rem; color: #fff; margin-bottom: 6px;
        }
        .contact-card p {
            color: var(--text-muted); font-size: 0.875rem; line-height: 1.65;
        }
        .contact-card a {
            color: var(--accent); text-decoration: none;
            font-weight: 600; font-size: 0.95rem;
        }
        .contact-card a:hover { text-decoration: underline; }
        .btn-wa {
            display: inline-flex; align-items: center; gap: 8px;
            background: #25d366; color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            font-size: 0.88rem; padding: 11px 22px;
            border-radius: 999px; text-decoration: none;
            margin-top: 1rem;
            transition: opacity 0.2s, transform 0.15s;
            box-shadow: 0 0 20px rgba(37,211,102,0.2);
        }
        .btn-wa:hover { opacity: 0.9; transform: scale(1.03); color: #fff; }

        /* ══ CTA ══ */
        .cta-section { padding: 5rem 1.5rem 7rem; }
        .cta-box {
            max-width: 700px; margin: 0 auto;
            background: var(--dark-card);
            border: 1px solid rgba(245,158,11,0.15);
            border-radius: 24px; padding: 3.5rem 2.5rem;
            text-align: center; position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: ''; position: absolute;
            top: -80px; left: 50%; transform: translateX(-50%);
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(245,158,11,0.09) 0%, transparent 70%);
            pointer-events: none;
        }
        .cta-title {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            color: #fff; margin-bottom: 12px;
        }
        .cta-sub {
            color: var(--text-muted); font-size: 0.95rem;
            line-height: 1.7; margin-bottom: 2rem;
        }

        /* ══ FOOTER ══ */
        footer { border-top: 1px solid var(--border); padding: 2rem 1.5rem; }
        .footer-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center;
            justify-content: space-between; flex-wrap: wrap; gap: 1rem;
        }
        .footer-logo {
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            font-size: 0.95rem; letter-spacing: 0.02em; color: #fff;
        }
        .footer-logo .a { color: var(--accent); }
        .footer-copy { font-size: 0.8rem; color: var(--text-muted); }

        /* ══ Utilities ══ */
        .container-max { max-width: 1200px; margin: 0 auto; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; } to { opacity: 1; }
        }
        .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 900px) {
            .features-grid, .classes-grid, .pricing-grid { grid-template-columns: 1fr; }
            .contact-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 580px) {
            .hero-stats { flex-direction: column; gap: 0; }
            .stat-item { border-right: none; border-bottom: 1px solid var(--border); padding: 10px 20px; }
            .stat-item:last-child { border-bottom: none; }
            .cta-box { padding: 2rem 1.25rem; }
            .trainer-strip { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav class="top-nav" id="navbar">
    <div class="nav-inner">
        <a href="#" class="nav-logo"><img src="{{ asset('template/assets/images/logo-abbr.png') }}" style="height:48px" alt="GMF"></a>
        <div class="nav-links">
            <a href="#tentang"  class="nav-link-item">Tentang</a>
            <a href="#kelas"    class="nav-link-item">Kelas</a>
            <a href="#harga"    class="nav-link-item">Harga</a>
            <a href="#kontak"   class="nav-link-item">Kontak</a>
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('dashboard') }}" class="btn-cta-nav" style="margin-left:8px;">
                        <i class="feather-grid"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-cta-nav" style="margin-left:8px;">
                        <i class="feather-log-in"></i> Login Member
                    </a>
                @endauth
            @endif
        </div>
        <button class="nav-mobile-toggle" id="mobileToggle" type="button" aria-label="Buka menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- ══ MOBILE MENU DRAWER ══ --}}
<div class="mobile-menu" id="mobileMenu">
    <a href="#tentang"  onclick="closeMobileMenu()"> Tentang Kami</a>
    <a href="#kelas"    onclick="closeMobileMenu()"> Program Kelas</a>
    <a href="#harga"    onclick="closeMobileMenu()"> Harga Paket</a>
    <a href="#kontak"   onclick="closeMobileMenu()"> Kontak & Lokasi</a>
    <div class="mobile-divider"></div>
    @if(Route::has('login'))
        @auth
            <a href="{{ url('dashboard') }}" class="btn-cta-mobile">
                <i class="feather-grid"></i> Buka Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-cta-mobile">
                <i class="feather-log-in"></i> Login Member
            </a>
        @endauth
    @endif
</div>

{{-- ══ HERO ══ --}}
<section id="beranda" class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay-1"></div>
    <div class="hero-overlay-2"></div>
    <div class="hero-grid"></div>

    <div class="hero-content">
        <div class="hero-inner">
          

            <h1 class="hero-title">
                Wujudkan Tubuh<br>
                Impianmu di <span class="line-accent">Gintung Master Fitness</span>
            </h1>

            <p class="hero-sub">
                Gym terjangkau dengan fasilitas lengkap, trainer berpengalaman, dan program latihan
                Muaythai, Boxing, serta Personal Training. <strong style="color:#e2e8f0">Mulai transformasimu hari ini!</strong>
            </p>

            <div class="hero-btns">
                <a href="#harga" class="btn-hero-primary">
                    <i class="feather-zap"></i> Daftar Sekarang
                </a>
                <a href="#kelas" class="btn-hero-secondary">
                    Lihat Program ↓
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══ WHY US ══ --}}
<section id="tentang" class="why-section">
    <div class="container-max">
        <div class="text-center">
            <div class="section-label" style="justify-content:center">Kenapa Pilih Kami?</div>
            <h2 class="section-title">Bukan Sekadar Gym Biasa</h2>
            <p class="section-sub" style="margin:0 auto">
                Kami hadir untuk membantu siapa saja — dari pemula hingga atlet — mencapai target kebugaran dengan cara yang menyenangkan dan terstruktur.
            </p>
        </div>

        <div class="features-grid">
            <div class="feat-card reveal">
                <div class="feat-icon"><i class="feather-trending-up"></i></div>
                <div class="feat-title">Hasil Nyata & Terukur</div>
                <p class="feat-desc">
                    Program latihan terstruktur yang dirancang untuk memberikan perubahan tubuh yang nyata.
                    Ratusan member kami telah membuktikannya.
                </p>
                <span class="feat-tag">Transformasi · Progress · Konsisten</span>
            </div>

            <div class="feat-card reveal">
                <div class="feat-icon"><i class="feather-shield"></i></div>
                <div class="feat-title">Fasilitas Modern & Bersih</div>
                <p class="feat-desc">
                    Peralatan gym lengkap dan terawat, ruangan yang luas, nyaman, serta area khusus untuk
                    kelas bela diri dan cardio.
                </p>
                <span class="feat-tag">Peralatan · Nyaman · Lengkap</span>
            </div>

            <div class="feat-card reveal">
                <div class="feat-icon"><i class="feather-dollar-sign"></i></div>
                <div class="feat-title">Harga Terjangkau</div>
                <p class="feat-desc">
                    Paket membership yang fleksibel dan ramah di kantong. Tidak perlu mahal untuk
                    tampil sehat dan bugar setiap hari.
                </p>
                <span class="feat-tag">Murah · Fleksibel · Hemat</span>
            </div>
        </div>
    </div>
</section>

{{-- ══ KELAS / PROGRAM ══ --}}
<section id="kelas" class="classes-section">
    <div class="container-max">
        <div class="text-center">
            <div class="section-label" style="justify-content:center">Program Unggulan</div>
            <h2 class="section-title">Pilih Kelas yang Tepat Untukmu</h2>
            <p class="section-sub" style="margin:0 auto">
                Dari latihan beban hingga bela diri, semua tersedia dengan jadwal yang fleksibel dan trainer yang siap membimbing.
            </p>
        </div>

        <div class="classes-grid">
            <div class="class-card reveal">
                <div class="class-img-wrap">
                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&q=80" alt="Gym Regular">
                    <span class="class-badge">Paling Populer</span>
                </div>
                <div class="class-body">
                    <div class="class-title">Gym Regular & Personal Training</div>
                    <p class="class-desc">
                        Latihan beban, cardio, dan program personal bersama trainer berpengalaman yang siap memandu setiap sesi latihanmu dari awal hingga target tercapai.
                    </p>
                    <div class="class-meta">
                        <div class="class-meta-item"><i class="feather-clock"></i> Setiap Hari</div>
                        <div class="class-meta-item"><i class="feather-users"></i> Semua Level</div>
                    </div>
                </div>
            </div>

            <div class="class-card reveal">
                <div class="class-img-wrap">
                    <img src="https://images.unsplash.com/photo-1555597673-b21d5c935865?w=600&q=80" alt="Muaythai">
                    <span class="class-badge">Seni Bela Diri</span>
                </div>
                <div class="class-body">
                    <div class="class-title">Kelas Muaythai</div>
                    <p class="class-desc">
                        Pelajari teknik dasar hingga mahir seni bela diri Muaythai. Efektif untuk self-defense, membakar kalori, dan membangun mental yang kuat.
                    </p>
                    <div class="class-meta">
                        <div class="class-meta-item"><i class="feather-clock"></i> 3x Seminggu</div>
                        <div class="class-meta-item"><i class="feather-users"></i> Semua Usia</div>
                    </div>
                </div>
            </div>

            <div class="class-card reveal">
                <div class="class-img-wrap">
                    <img src="https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=600&q=80" alt="Boxing">
                    <span class="class-badge">Cardio Intense</span>
                </div>
                <div class="class-body">
                    <div class="class-title">Kelas Boxing</div>
                    <p class="class-desc">
                        Latihan tinju yang menggabungkan teknik bela diri dengan cardio intensitas tinggi. Ideal untuk pembentukan tubuh, stamina, dan kepercayaan diri.
                    </p>
                    <div class="class-meta">
                        <div class="class-meta-item"><i class="feather-clock"></i> 3x Seminggu</div>
                        <div class="class-meta-item"><i class="feather-users"></i> Semua Level</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ TRAINER ══ --}}
<section class="trainer-section">
    <div class="container-max">
        <div class="trainer-strip reveal">
            <div class="trainer-icon-wrap">
                <i class="feather-award"></i>
            </div>
            <div class="trainer-text">
                <h3>Trainer Bersertifikat & Berpengalaman</h3>
                <p>
                    Semua trainer kami memiliki sertifikasi resmi dan pengalaman bertahun-tahun dalam mendampingi member mencapai target kebugaran. Mulai dari pemula yang baru pertama kali masuk gym hingga atlet kompetitif — kami siap membantu!
                </p>
                <div class="trainer-badges">
                    <span class="t-badge">Certified Trainer</span>
                    <span class="t-badge">Muaythai Coach</span>
                    <span class="t-badge">Boxing Coach</span>
                    <span class="t-badge">Nutrition Guide</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ HARGA ══ --}}
<section id="harga" class="pricing-section">
    <div class="container-max">
        <div class="text-center">
            <div class="section-label" style="justify-content:center">Paket Membership</div>
            <h2 class="section-title">Harga Transparan, Tanpa Biaya Tersembunyi</h2>
            <p class="section-sub" style="margin:0 auto">
                Pilih paket yang sesuai dengan kebutuhanmu. Semua paket sudah termasuk akses penuh ke fasilitas gym.
            </p>
        </div>

        <div class="pricing-grid">
            {{-- Paket Bulanan --}}
            <div class="price-card reveal">
                <div class="price-plan">Paket Bulanan</div>
                <div class="price-amount"><span class="currency">Rp</span>150K</div>
                <div class="price-period">per bulan · akses penuh</div>
                <div class="price-divider"></div>
                <ul class="price-features">
                    <li>Akses gym setiap hari</li>
                    <li>Semua peralatan bebas dipakai</li>
                    <li>Loker & ruang ganti</li>
                    <li>Konsultasi program gratis</li>
                    <li class="muted">Kelas Muaythai / Boxing</li>
                    <li class="muted">Personal Training session</li>
                </ul>
                <a href="#kontak" class="btn-price btn-price-outline">Daftar Sekarang</a>
            </div>

            {{-- Paket 3 Bulan (Popular) --}}
            <div class="price-card popular reveal">
                <div class="popular-badge">⭐ Paling Hemat</div>
                <div class="price-plan">Paket 3 Bulan</div>
                <div class="price-amount"><span class="currency">Rp</span>400K</div>
                <div class="price-period">per 3 bulan · hemat Rp50K</div>
                <div class="price-divider"></div>
                <ul class="price-features">
                    <li>Akses gym setiap hari</li>
                    <li>Semua peralatan bebas dipakai</li>
                    <li>Loker & ruang ganti</li>
                    <li>Konsultasi program gratis</li>
                    <li>1x sesi Personal Training</li>
                    <li class="muted">Kelas Muaythai / Boxing</li>
                </ul>
                <a href="#kontak" class="btn-price btn-price-fill">Daftar Sekarang</a>
            </div>

            {{-- Paket Kelas --}}
            <div class="price-card reveal">
                <div class="price-plan">Paket Kelas Bela Diri</div>
                <div class="price-amount"><span class="currency">Rp</span>200K</div>
                <div class="price-period">per bulan · Muaythai atau Boxing</div>
                <div class="price-divider"></div>
                <ul class="price-features">
                    <li>Kelas Muaythai atau Boxing</li>
                    <li>Latihan 3x seminggu</li>
                    <li>Coach bersertifikat</li>
                    <li>Akses gym di hari kelas</li>
                    <li>Konsultasi program gratis</li>
                    <li class="muted">Personal Training session</li>
                </ul>
                <a href="#kontak" class="btn-price btn-price-outline">Daftar Sekarang</a>
            </div>
        </div>

        <p style="text-align:center; margin-top:1.75rem; font-size:0.82rem; color:var(--text-muted);">
            * Harga dapat berubah sewaktu-waktu. Hubungi kami untuk info promo dan paket custom.
        </p>
    </div>
</section>

{{-- ══ KONTAK & LOKASI ══ --}}
<section id="kontak" class="contact-section">
    <div class="container-max">
        <div class="text-center">
            <div class="section-label" style="justify-content:center">Lokasi & Kontak</div>
            <h2 class="section-title">Kunjungi Kami atau Hubungi Langsung</h2>
            <p class="section-sub" style="margin:0 auto">
                Kami siap menjawab pertanyaan tentang program, harga, dan jadwal. Jangan ragu untuk menghubungi kami!
            </p>
        </div>

        <div class="contact-grid">
            <div class="contact-card reveal">
                <div class="contact-card-icon"><i class="feather-map-pin"></i></div>
                <h4>Lokasi Gym</h4>
                <p>
                    Jl. Tarumanegara No.xx, Ciputat,<br>
                    Tangerang Selatan, Banten 15411<br><br>
                    <em style="font-size:0.82rem; color:var(--text-muted);">Dekat perempatan Gintung, parkir luas tersedia.</em>
                </p>
            </div>

            <div class="contact-card reveal">
                <div class="contact-card-icon"><i class="feather-message-circle"></i></div>
                <h4>Hubungi via WhatsApp</h4>
                <p>
                    Punya pertanyaan soal program atau harga?<br>
                    Chat langsung dengan admin kami — <strong style="color:#e2e8f0">respon cepat!</strong>
                </p>
                <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20info%20membership%20Gintung%20Master%20Fitness" class="btn-wa" target="_blank"  style="color:#e2e8f0">
                    <i class="feather-phone"></i> Chat WhatsApp
                </a>
            </div>

            <div class="contact-card reveal">
                <div class="contact-card-icon"><i class="feather-clock"></i></div>
                <h4>Jam Operasional</h4>
                <p>
                    Senin – Jumat &nbsp;&nbsp; 06.00 – 22.00 WIB<br>
                    Sabtu – Minggu &nbsp; 07.00 – 21.00 WIB<br><br>
                    <em style="font-size:0.82rem; color:var(--text-muted);">Buka setiap hari termasuk hari libur.</em>
                </p>
            </div>

            <div class="contact-card reveal">
                <div class="contact-card-icon"><i class="feather-instagram"></i></div>
                <h4>Ikuti Kami di Sosmed</h4>
                <p>
                    Update jadwal kelas, promo membership, dan tips kebugaran setiap hari.
                    Follow Instagram kami:
                </p>
                <a href="#" style="display:inline-flex; align-items:center; gap:6px; margin-top:10px; color:var(--accent); font-weight:600; text-decoration:none;">
                    <i class="feather-instagram"></i> @gintungmasterfitness
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══ CTA ══ --}}
<section class="cta-section">
    <div class="container-max">
        <div class="cta-box reveal">
            <div class="hero-eyebrow" style="justify-content:center">
                <span class="eyebrow-dot"></span>
                Jangan Tunda Lagi!
            </div>
            <h2 class="cta-title">Mulai Perjalanan<br>Fitness-mu Sekarang</h2>
            <p class="cta-sub">
                Bergabunglah bersama ratusan member yang sudah merasakan perubahan nyata.
                Daftar hari ini dan dapatkan konsultasi program <strong style="color:#e2e8f0">GRATIS!</strong>
            </p>
            
            {{-- Bagian pembungkus tombol yang diubah --}}
            <div style="display:flex; flex-direction:column; gap:12px; align-items:center; justify-content:center;">
                <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20mau%20daftar%20member%20Gintung%20Master%20Fitness" class="btn-wa" target="_blank" style="font-size:0.95rem; padding:13px 28px;">
                    <i class="feather-phone"></i> Daftar via WhatsApp
                </a>
                
                @if(Route::has('login'))
                    @guest
                        <a href="{{ route('login') }}" class="btn-hero-secondary" style="padding:13px 28px;">
                            <i class="feather-log-in"></i> Login Member
                        </a>
                    @endguest
                @endif
            </div>

        </div>
    </div>
</section>

{{-- ══ FOOTER ══ --}}
<footer>
    <div class="footer-inner">
        <div class="footer-logo"><img src="{{ asset('template/assets/images/logo-abbr.png') }}" style="height:36px; margin-right:8px;" alt="GMF"> Gintung Master Fitness</div>
        <div class="footer-copy">
            &copy; {{ date('Y') }} Sufyan Dzaki · Skripsi UIN Jakarta
        </div>
    </div>
</footer>

<script src="{{ asset('template/assets/js/bootstrap.min.js') }}"></script>
<script>
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 30);
    });

    // Mobile menu toggle
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileMenu   = document.getElementById('mobileMenu');

    mobileToggle.addEventListener('click', () => {
        const isOpen = mobileMenu.classList.contains('open');
        if (isOpen) {
            closeMobileMenu();
        } else {
            mobileMenu.classList.add('open');
            mobileToggle.classList.add('active');
        }
    });

    function closeMobileMenu() {
        mobileMenu.classList.remove('open');
        mobileToggle.classList.remove('active');
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!navbar.contains(e.target) && !mobileMenu.contains(e.target)) {
            closeMobileMenu();
        }
    });

    // Close mobile menu on scroll
    window.addEventListener('scroll', () => {
        closeMobileMenu();
    }, { passive: true });

    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));
</script>

</body>
</html>