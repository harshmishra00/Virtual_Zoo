<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Immersive Tour — Zootopia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900|plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #000;
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ── Reel Container ── */
        .reels-container {
            height: 100vh;
            height: 100dvh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .reels-container::-webkit-scrollbar { display: none; }

        /* ── Individual Slide ── */
        .reel-slide {
            position: relative;
            height: 100vh;
            height: 100dvh;
            scroll-snap-align: start;
            scroll-snap-stop: always;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
        }

        /* Background image with parallax-like zoom on active */
        .reel-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.08);
            transition: transform 8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: 1;
        }
        .reel-slide.is-active .reel-bg {
            transform: scale(1);
        }

        /* Gradient: on mobile = bottom-heavy; on desktop = left+bottom */
        .reel-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
            /* Mobile default — strong bottom gradient only */
            background:
                linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 35%, rgba(0,0,0,0.0) 70%);
        }
        @media (min-width: 768px) {
            .reel-overlay {
                background:
                    linear-gradient(to right,  rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.1) 55%, rgba(0,0,0,0.0) 100%),
                    linear-gradient(to top,    rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.3) 40%, rgba(0,0,0,0.0) 100%),
                    linear-gradient(to bottom, rgba(0,0,0,0.4)  0%, transparent      30%);
            }
        }

        /* ════ MOBILE FIRST layout ════ */
        /* On phones: content sits at the bottom, only name shown */
        .reel-content {
            position: absolute;
            inset: 0;
            z-index: 5;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem 1.25rem;
            /* No gap on mobile — right panel is hidden */
            gap: 0;
        }

        /* LEFT column (name + CTA) — full width on mobile */
        .reel-left {
            width: 100%;
            min-width: 0;
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.55s cubic-bezier(0.16,1,0.3,1) 0.1s,
                        opacity  0.55s cubic-bezier(0.16,1,0.3,1) 0.1s;
        }
        .reel-slide.is-active .reel-left {
            transform: translateY(0);
            opacity: 1;
        }

        /* RIGHT column — HIDDEN on mobile, visible on desktop */
        .reel-right {
            display: none;
        }

        /* ════ DESKTOP overrides (≥768px) ════ */
        @media (min-width: 768px) {
            .reel-content {
                padding: 2.5rem 3rem;
                gap: 2rem;
            }
            .reel-left {
                flex: 1 1 0;
                width: auto;
                transform: translateX(-24px);
                transition: transform 0.6s cubic-bezier(0.16,1,0.3,1) 0.1s,
                            opacity  0.6s cubic-bezier(0.16,1,0.3,1) 0.1s;
            }
            .reel-slide.is-active .reel-left {
                transform: translateX(0);
                opacity: 1;
            }
            /* Show right panel on desktop */
            .reel-right {
                display: block;
                width: 340px;
                flex-shrink: 0;
                max-height: 80vh;
                overflow-y: auto;
                scrollbar-width: thin;
                scrollbar-color: rgba(255,255,255,0.2) transparent;
                transform: translateX(24px);
                opacity: 0;
                transition: transform 0.65s cubic-bezier(0.16,1,0.3,1) 0.2s,
                            opacity  0.65s cubic-bezier(0.16,1,0.3,1) 0.2s;
            }
            .reel-right::-webkit-scrollbar { width: 4px; }
            .reel-right::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
            .reel-slide.is-active .reel-right {
                transform: translateX(0);
                opacity: 1;
            }
        }


        .glass-card {
            background: rgba(15,15,25,0.55);
            backdrop-filter: blur(24px) saturate(1.6);
            -webkit-backdrop-filter: blur(24px) saturate(1.6);
            border: 1px solid rgba(255,255,255,0.1);
            border-top: 1px solid rgba(255,255,255,0.18);
            border-left: 1px solid rgba(255,255,255,0.18);
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow:
                0 2px 0 rgba(255,255,255,0.04) inset,
                0 30px 80px rgba(0,0,0,0.6);
        }

        /* Tag pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .pill.is-danger { background: rgba(239,68,68,0.7); border-color: rgba(239,68,68,0.5); }
        .pill.is-flower { background: rgba(168,85,247,0.7); border-color: rgba(168,85,247,0.5); }
        .pill.is-wild   { background: rgba(16,185,129,0.7); border-color: rgba(16,185,129,0.5); }

        .reel-title {
            font-family: 'Outfit', sans-serif;
            /* Larger on mobile for impact, smaller on desktop (desktop has the right panel) */
            font-size: clamp(2.2rem, 10vw, 3.5rem);
            font-weight: 900;
            line-height: 1.05;
            color: #fff;
            letter-spacing: -0.02em;
            margin: 0.75rem 0 0.3rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.6);
        }
        .reel-sci {
            font-style: italic;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.55);
            margin-bottom: 0.9rem;
        }
        .reel-desc {
            font-size: 0.9rem;
            line-height: 1.65;
            color: rgba(255,255,255,0.82);
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1.25rem;
        }

        /* Stats row */
        .stats-row {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }
        .stat-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
        }
        .stat-chip svg { opacity: 0.7; flex-shrink: 0; }

        /* CTA button */
        .cta-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: #fff;
            color: #0f172a;
            border-radius: 16px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
        }
        .cta-btn:hover { background: #f1f5f9; transform: scale(1.01); }

        /* ── Right Action Rail ── */
        .action-rail {
            position: absolute;
            right: 1.25rem;
            bottom: 5rem;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }
        .action-btn {
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.18);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            gap: 2px;
        }
        .action-btn:hover { background: rgba(255,255,255,0.2); transform: scale(1.08); }
        .action-btn span { font-size: 0.6rem; font-weight: 600; color: rgba(255,255,255,0.7); }

        /* ── Progress Dots ── */
        .progress-dots {
            position: fixed;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 50;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }
        .dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transition: all 0.3s;
        }
        .dot.is-active {
            height: 20px;
            border-radius: 4px;
            background: #fff;
        }

        /* ── Fixed UI Elements ── */
        .back-btn {
            position: fixed;
            top: 1.5rem;
            left: 1.25rem;
            z-index: 50;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.625rem 1rem;
            background: rgba(0,0,0,0.35);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 99px;
            border: 1px solid rgba(255,255,255,0.12);
            transition: all 0.2s;
        }
        .back-btn:hover { background: rgba(0,0,0,0.55); transform: translateX(-3px); }

        .logo-badge {
            position: fixed;
            top: 1.5rem;
            right: 1.25rem;
            z-index: 50;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            color: #fff;
            padding: 0.5rem 1rem;
            background: rgba(0,0,0,0.35);
            backdrop-filter: blur(12px);
            border-radius: 99px;
            border: 1px solid rgba(255,255,255,0.12);
        }

        .swipe-hint {
            position: fixed;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 50;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: rgba(255,255,255,0.6);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            pointer-events: none;
            transition: opacity 0.5s;
        }
        .swipe-hint svg { animation: swipeBounce 1.5s ease-in-out infinite; }
        @keyframes swipeBounce {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(6px); }
        }

        /* ── Visibility utilities ── */
        .desktop-only { display: none !important; }
        .mobile-only  { display: block; }

        @media (min-width: 768px) {
            .desktop-only { display: inline-flex !important; }
            .mobile-only  { display: none !important; }
            /* CTA is a block button on desktop */
            a.desktop-only.cta-btn { display: inline-flex !important; }
            div.desktop-only       { display: flex !important; }
        }

        /* Mobile: make entire slide tappable */
        .reel-slide-link {
            position: absolute;
            inset: 0;
            z-index: 4; /* below content (z-5), above overlay (z-2) */
        }
        @media (min-width: 768px) {
            .reel-slide-link { display: none; }
        }


        /* Particle shimmer on active slide */
        @keyframes shimmer {
            0%   { background-position: -400px 0; }
            100% { background-position: 400px 0; }
        }
    </style>
</head>
<body>

    {{-- Fixed navigation --}}
    <a href="{{ route('home') }}" class="back-btn">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Exit Tour
    </a>
    <div class="logo-badge">🦁 Zootopia</div>

    {{-- Progress indicator dots --}}
    <div class="progress-dots" id="progress-dots">
        @foreach($tourItems as $i => $_)
            <div class="dot {{ $i === 0 ? 'is-active' : '' }}" data-dot="{{ $i }}"></div>
        @endforeach
    </div>

    {{-- Swipe hint --}}
    <div class="swipe-hint" id="swipe-hint">
        Scroll to explore
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </div>

    {{-- Reels scroll container --}}
    <div class="reels-container" id="reels-container">
        @foreach($tourItems as $index => $item)
            @php
                // Use the explicit _type tag set by the controller — 100% reliable
                $isFlower    = ($item['_type'] ?? 'animal') === 'flower';
                $detailRoute = $isFlower
                    ? route('flowers.show', $item['slug'])
                    : route('animals.show', $item['slug']);
                $scientificName = $item['scientific_name'] ?? ($item['species']['name'] ?? '');

                // Build stat chips
                $stats = [];
                if (!empty($item['animal_facts']['weight_kg']) && $item['animal_facts']['weight_kg'] > 0)
                    $stats[] = ['icon' => '⚖️', 'label' => $item['animal_facts']['weight_kg'] . ' kg'];
                if (!empty($item['animal_facts']['lifespan_years']))
                    $stats[] = ['icon' => '⏳', 'label' => $item['animal_facts']['lifespan_years'] . ' yrs'];
                if (!empty($item['continent']))
                    $stats[] = ['icon' => '🌍', 'label' => $item['continent']];
                if (!empty($item['bloom_season']))
                    $stats[] = ['icon' => '🌸', 'label' => $item['bloom_season']];
                if (!empty($item['native_to']))
                    $stats[] = ['icon' => '📍', 'label' => $item['native_to']];

                $typeBg    = $isFlower ? 'linear-gradient(135deg,#7e22ce,#a855f7)' : 'linear-gradient(135deg,#064e3b,#10b981)';
                $typeEmoji = $isFlower ? '🌺' : '🦁';
                $typeLabel = $isFlower ? 'Flower' : 'Animal';
            @endphp

            <div class="reel-slide {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}">
                {{-- Background image --}}
                <img
                    class="reel-bg"
                    src="{{ $item['pexels_image'] }}"
                    alt="{{ $item['name'] }}"
                    loading="{{ $index < 2 ? 'eager' : 'lazy' }}"
                >
                <div class="reel-overlay"></div>

                {{-- Mobile: invisible full-slide tap target --}}
                <a href="{{ $detailRoute }}" class="reel-slide-link" aria-label="View {{ $item['name'] }}"></a>

                {{-- ══ Floating TYPE badge (top-left of slide, clickable) ══ --}}
                <a href="{{ $detailRoute }}"
                   style="position:absolute;top:5.5rem;left:1.25rem;z-index:20;
                          display:inline-flex;align-items:center;gap:8px;
                          padding:8px 16px;border-radius:99px;
                          background:{{ $typeBg }};
                          border:1px solid rgba(255,255,255,0.25);
                          backdrop-filter:blur(8px);
                          font-family:'Outfit',sans-serif;font-weight:800;
                          font-size:0.85rem;color:#fff;text-decoration:none;
                          box-shadow:0 4px 20px rgba(0,0,0,0.4);
                          transition:transform .2s,box-shadow .2s;"
                   onmouseover="this.style.transform='scale(1.05)'"
                   onmouseout="this.style.transform='scale(1)'">
                    {{ $typeEmoji }} {{ $typeLabel }}
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         style="opacity:.8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                </a>

                {{-- ══ SPLIT LAYOUT CONTENT ══ --}}
                <div class="reel-content">

                    {{-- LEFT: big name + type + CTA --}}
                    <div class="reel-left">
                        {{-- Type badge --}}
                        <a href="{{ $detailRoute }}"
                           style="display:inline-flex;align-items:center;gap:8px;
                                  padding:6px 14px;border-radius:99px;
                                  background:{{ $typeBg }};
                                  border:1px solid rgba(255,255,255,0.25);
                                  font-family:'Outfit',sans-serif;font-weight:800;
                                  font-size:0.8rem;color:#fff;text-decoration:none;
                                  margin-bottom:0.75rem;">
                            {{ $typeEmoji }} {{ $typeLabel }}
                        </a>

                        <h2 class="reel-title">{{ $item['name'] }}</h2>
                        @if($scientificName)
                            <p class="reel-sci">{{ $scientificName }}</p>
                        @endif

                        {{-- Stats chips — desktop only --}}
                        @if(count($stats))
                        <div class="stats-row desktop-only" style="margin-top:0.75rem;">
                            @foreach($stats as $stat)
                            <div class="stat-chip">{{ $stat['icon'] }} {{ $stat['label'] }}</div>
                            @endforeach
                        </div>
                        @endif

                        {{-- CTA button — desktop only --}}
                        <a href="{{ $detailRoute }}" class="cta-btn desktop-only" style="margin-top:1.25rem;width:auto;padding:0.8rem 1.5rem;">
                            View Full Profile
                            <svg style="margin-left:8px;width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        {{-- Mobile-only tap hint --}}
                        <p class="mobile-only" style="margin-top:0.6rem;font-size:0.75rem;
                                   color:rgba(255,255,255,0.5);font-weight:600;letter-spacing:0.05em;">
                            Tap to explore →
                        </p>
                    </div>

                    {{-- RIGHT: glass details card --}}
                    <div class="reel-right">
                        <div class="glass-card">
                            {{-- Conservation / category pills --}}
                            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:1rem;">
                                @if($isFlower)
                                    <span class="pill is-flower">🌺 Botanical</span>
                                @else
                                    <span class="pill is-wild">🦁 Wildlife</span>
                                @endif
                                @if(!empty($item['conservation_status']))
                                    @php
                                        $status   = $item['conservation_status'];
                                        $isDanger = in_array($status, ['Critically Endangered','Endangered']);
                                    @endphp
                                    <span class="pill {{ $isDanger ? 'is-danger' : '' }}">
                                        {{ $isDanger ? '🔴' : '🟡' }} {{ $status }}
                                    </span>
                                @endif
                            </div>

                            {{-- Description --}}
                            <p class="reel-desc" style="-webkit-line-clamp:5;">{{ $item['description'] }}</p>

                            {{-- ── Wikipedia Enrichment ── --}}
                            @if(!empty($item['wiki']['extract']))
                            <div style="padding:1rem;
                                        background:rgba(255,255,255,0.04);
                                        border:1px solid rgba(255,255,255,0.09);
                                        border-radius:16px;margin-bottom:1rem;">

                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:0.75rem;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="color:rgba(255,255,255,0.5);flex-shrink:0;">
                                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                    </svg>
                                    <span style="font-size:0.65rem;font-weight:700;text-transform:uppercase;
                                                 letter-spacing:0.12em;color:rgba(255,255,255,0.45);">
                                        From Wikipedia
                                    </span>
                                    @if(!empty($item['wiki']['url']))
                                    <a href="{{ $item['wiki']['url'] }}" target="_blank"
                                       style="margin-left:auto;font-size:0.65rem;font-weight:600;
                                              color:rgba(255,255,255,0.45);text-decoration:none;
                                              border:1px solid rgba(255,255,255,0.15);
                                              padding:2px 8px;border-radius:99px;">
                                        Full article ↗
                                    </a>
                                    @endif
                                </div>

                                {{-- Thumbnail + extract --}}
                                <div style="display:flex;gap:10px;align-items:flex-start;">
                                    @if(!empty($item['wiki']['thumbnail']))
                                    <img src="{{ $item['wiki']['thumbnail'] }}"
                                         alt="{{ $item['wiki']['title'] }}"
                                         style="width:60px;height:60px;object-fit:cover;
                                                border-radius:10px;flex-shrink:0;
                                                border:1px solid rgba(255,255,255,0.1);">
                                    @endif
                                    <p style="font-size:0.78rem;line-height:1.65;
                                              color:rgba(255,255,255,0.72);margin:0;">
                                        {{ $item['wiki']['extract'] }}
                                    </p>
                                </div>
                            </div>
                            @endif

                            {{-- Like + Share actions inside card on mobile --}}
                            <div style="display:flex;gap:0.75rem;">
                                <button onclick="toggleHeart(this)"
                                        style="flex:1;display:flex;align-items:center;justify-content:center;
                                               gap:6px;padding:0.65rem;border-radius:12px;
                                               background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.1);
                                               color:#fff;cursor:pointer;font-size:0.78rem;font-weight:600;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    <span class="like-count">{{ rand(100, 9999) }}</span>
                                </button>
                                <button onclick="doShare('{{ addslashes($item['name']) }}')"
                                        style="flex:1;display:flex;align-items:center;justify-content:center;
                                               gap:6px;padding:0.65rem;border-radius:12px;
                                               background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.1);
                                               color:#fff;cursor:pointer;font-size:0.78rem;font-weight:600;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                    Share
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <script>
        const container = document.getElementById('reels-container');
        const swipeHint = document.getElementById('swipe-hint');

        // Track all seen slugs to avoid immediate repeats
        const seenSlugs = new Set(
            [...document.querySelectorAll('.reel-slide')].map(s => s.dataset.slug)
        );

        let totalIndex   = document.querySelectorAll('.reel-slide').length;
        let isFetching   = false;
        let hintHidden   = false;

        // ── Intersection Observer ──────────────────────────────────
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-active');

                    const idx = Number(entry.target.dataset.index);

                    // Update progress dots
                    document.querySelectorAll('.dot').forEach((d, i) => {
                        d.classList.toggle('is-active', i === idx);
                    });

                    // Hide swipe hint after first scroll
                    if (idx > 0 && !hintHidden) {
                        hintHidden = true;
                        swipeHint.style.opacity = '0';
                    }

                    // Fetch more when 3 slides remain
                    const allSlides = document.querySelectorAll('.reel-slide');
                    if (idx >= allSlides.length - 3 && !isFetching) {
                        fetchMoreSlides();
                    }
                } else {
                    entry.target.classList.remove('is-active');
                }
            });
        }, { root: container, threshold: 0.55 });

        document.querySelectorAll('.reel-slide').forEach(s => observer.observe(s));

        // ── Fetch & append new slides ──────────────────────────────
        async function fetchMoreSlides() {
            isFetching = true;
            try {
                const excludeParam = [...seenSlugs].join(',');
                const res   = await fetch(`/tour/more?count=8&exclude=${encodeURIComponent(excludeParam)}`);
                const items = await res.json();

                items.forEach(item => {
                    if (seenSlugs.has(item.slug)) return; // safety: skip dupes
                    seenSlugs.add(item.slug);

                    const slide = buildSlide(item, totalIndex);
                    container.appendChild(slide);
                    observer.observe(slide);

                    // Add progress dot
                    const dot = document.createElement('div');
                    dot.className = 'dot';
                    dot.dataset.dot = totalIndex;
                    document.getElementById('progress-dots').appendChild(dot);

                    totalIndex++;
                });
            } catch (e) {
                console.warn('Tour fetch failed:', e);
            } finally {
                isFetching = false;
            }
        }

        // ── Build a slide DOM element from JSON data ───────────────
        function buildSlide(item, index) {
            const isFlower  = item._type === 'flower';
            const typeBg    = isFlower
                ? 'linear-gradient(135deg,#7e22ce,#a855f7)'
                : 'linear-gradient(135deg,#064e3b,#10b981)';
            const typeEmoji = isFlower ? '🌺' : '🦁';
            const typeLabel = isFlower ? 'Flower' : 'Animal';
            const detailUrl = isFlower
                ? `/flowers/${item.slug}`
                : `/animals/${item.slug}`;

            const status     = item.conservation_status ?? '';
            const isDanger   = ['Critically Endangered','Endangered'].includes(status);
            const statusHtml = status
                ? `<span class="pill ${isDanger ? 'is-danger' : ''}">${isDanger ? '🔴' : '🟡'} ${status}</span>`
                : '';

            // Stat chips
            const stats = [];
            if (item.weight_kg && item.weight_kg > 0) stats.push(`⚖️ ${item.weight_kg} kg`);
            if (item.lifespan_years)  stats.push(`⏳ ${item.lifespan_years} yrs`);
            if (item.continent)       stats.push(`🌍 ${item.continent}`);
            if (item.bloom_season)    stats.push(`🌸 ${item.bloom_season}`);
            if (item.native_to)       stats.push(`📍 ${item.native_to}`);
            const statsHtml = stats.length
                ? `<div class="stats-row desktop-only" style="margin-top:.75rem">${stats.map(s => `<div class="stat-chip">${s}</div>`).join('')}</div>`
                : '';

            // Wikipedia section (desktop right panel)
            const wikiThumb = item.wiki?.thumbnail
                ? `<img src="${item.wiki.thumbnail}" style="width:60px;height:60px;object-fit:cover;border-radius:10px;flex-shrink:0;border:1px solid rgba(255,255,255,.1);" alt="">`
                : '';
            const wikiArticle = item.wiki?.url
                ? `<a href="${item.wiki.url}" target="_blank" style="margin-left:auto;font-size:.65rem;font-weight:600;color:rgba(255,255,255,.45);text-decoration:none;border:1px solid rgba(255,255,255,.15);padding:2px 8px;border-radius:99px;">Full article ↗</a>`
                : '';
            const wikiSection = item.wiki?.extract ? `
                <div style="padding:1rem;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.09);border-radius:16px;margin-bottom:1rem;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:.75rem;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="color:rgba(255,255,255,.5);flex-shrink:0;"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        <span style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:rgba(255,255,255,.45);">From Wikipedia</span>
                        ${wikiArticle}
                    </div>
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        ${wikiThumb}
                        <p style="font-size:.78rem;line-height:1.65;color:rgba(255,255,255,.72);margin:0;">${item.wiki.extract}</p>
                    </div>
                </div>` : '';

            const likeCount = Math.floor(Math.random() * 9900) + 100;

            const div = document.createElement('div');
            div.className = 'reel-slide';
            div.dataset.index = index;
            div.dataset.slug  = item.slug;
            div.innerHTML = `
                <img class="reel-bg" src="${item.pexels_image}" alt="${item.name}" loading="lazy">
                <div class="reel-overlay"></div>
                <a href="${detailUrl}" class="reel-slide-link" aria-label="View ${item.name}"></a>

                <a href="${detailUrl}" style="position:absolute;top:5.5rem;left:1.25rem;z-index:20;
                    display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:99px;
                    background:${typeBg};border:1px solid rgba(255,255,255,.25);backdrop-filter:blur(8px);
                    font-family:'Outfit',sans-serif;font-weight:800;font-size:.85rem;color:#fff;text-decoration:none;
                    box-shadow:0 4px 20px rgba(0,0,0,.4);">
                    ${typeEmoji} ${typeLabel}
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:.8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                </a>

                <div class="reel-content">
                    <div class="reel-left">
                        <a href="${detailUrl}" style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:99px;background:${typeBg};border:1px solid rgba(255,255,255,.25);font-family:'Outfit',sans-serif;font-weight:800;font-size:.8rem;color:#fff;text-decoration:none;margin-bottom:.75rem;">
                            ${typeEmoji} ${typeLabel}
                        </a>
                        <h2 class="reel-title">${item.name}</h2>
                        ${item.scientific_name ? `<p class="reel-sci">${item.scientific_name}</p>` : ''}
                        ${statsHtml}
                        <a href="${detailUrl}" class="cta-btn desktop-only" style="margin-top:1.25rem;width:auto;padding:.8rem 1.5rem;">
                            View Full Profile
                            <svg style="margin-left:8px;width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <p class="mobile-only" style="margin-top:.6rem;font-size:.75rem;color:rgba(255,255,255,.5);font-weight:600;letter-spacing:.05em;">Tap to explore →</p>
                    </div>

                    <div class="reel-right">
                        <div class="glass-card">
                            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:1rem;">
                                <span class="pill ${isFlower ? 'is-flower' : 'is-wild'}">${typeEmoji} ${isFlower ? 'Botanical' : 'Wildlife'}</span>
                                ${statusHtml}
                            </div>
                            <p class="reel-desc" style="-webkit-line-clamp:5;">${item.description}</p>
                            ${wikiSection}
                            <div style="display:flex;gap:.75rem;">
                                <button onclick="toggleHeart(this)" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:.65rem;border-radius:12px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);color:#fff;cursor:pointer;font-size:.78rem;font-weight:600;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    <span class="like-count">${likeCount}</span>
                                </button>
                                <button onclick="doShare('${item.name.replace(/'/g,"\\'")}') " style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:.65rem;border-radius:12px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);color:#fff;cursor:pointer;font-size:.78rem;font-weight:600;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                    Share
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
            return div;
        }

        // ── Like button ────────────────────────────────────────────
        function toggleHeart(btn) {
            const svg   = btn.querySelector('svg');
            const count = btn.querySelector('.like-count');
            const liked = svg.getAttribute('fill') !== 'none';
            if (liked) {
                svg.setAttribute('fill', 'none');
                svg.setAttribute('stroke', 'currentColor');
                count.textContent = Number(count.textContent) - 1;
            } else {
                svg.setAttribute('fill', '#fb7185');
                svg.setAttribute('stroke', '#fb7185');
                count.textContent = Number(count.textContent) + 1;
                btn.animate([{transform:'scale(1)'},{transform:'scale(1.35)'},{transform:'scale(0.9)'},{transform:'scale(1.1)'},{transform:'scale(1)'}], {duration:400,easing:'ease'});
            }
        }

        // ── Share ──────────────────────────────────────────────────
        function doShare(name) {
            if (navigator.share) {
                navigator.share({ title:`${name} — Zootopia`, text:`Exploring ${name} on Zootopia! 🦁`, url:window.location.href });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => alert('Link copied!'));
            }
        }

        // ── Keyboard navigation ────────────────────────────────────
        document.addEventListener('keydown', e => {
            const all     = [...document.querySelectorAll('.reel-slide')];
            const current = all.findIndex(s => s.classList.contains('is-active'));
            if ((e.key === 'ArrowDown' || e.key === 'j') && current < all.length - 1) {
                all[current + 1].scrollIntoView({ behavior: 'smooth' });
            }
            if ((e.key === 'ArrowUp' || e.key === 'k') && current > 0) {
                all[current - 1].scrollIntoView({ behavior: 'smooth' });
            }
        });
    </script>
</body>
</html>
