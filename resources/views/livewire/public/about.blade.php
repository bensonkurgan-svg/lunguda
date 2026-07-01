<div class="mx-auto max-w-4xl px-4 py-12 md:py-16">
    <header class="max-w-2xl">
        <p class="eyebrow">About</p>
        <h1 class="mt-2 font-display text-4xl font-semibold">Who we are, and why this archive exists</h1>
    </header>

    <div class="prose prose-basalt mt-8 max-w-none">
        <p class="lead text-lg text-basalt/80">
            The Lunguda — who call themselves <strong>Nʋngʋra</strong> — are a people of Jessu, in Balanga Local
            Government Area of Gombe State, Nigeria. This archive is a community-owned record of our language,
            lineage and living culture: built by the people who hold it, for the generations who will inherit it.
        </p>

        <h2 class="font-display">A matrilineal people of the plateau</h2>
        <p class="text-basalt/75">
            Lunguda society is matrilineal and matriarchal — descent, belonging and inheritance pass through the
            mother's line. We are farmers of sorghum and guinea-corn on the volcanic soils of the Lunguda Plateau,
            and our social life is organised around clans, each with its own history and totem. This archive is
            built to reflect that reality: our family trees are traced mother-to-child, not father-to-child.
        </p>

        <h2 class="font-display">One language, five dialects</h2>
        <p class="text-basalt/75">
            Lunguda belongs to the Niger-Congo family. It is spoken across five dialects —
            <span class="font-mono">Cerin, Deele, Guyuk, Gwaanda and Kɔla</span> — and every entry in this archive is
            tagged with the dialect it comes from, so differences are preserved rather than flattened. Lunguda is a
            minority language under pressure as younger generations shift toward dominant languages. We are not
            waiting for it to become endangered: this is preventive documentation, done while the language is still
            strong.
        </p>

        <h2 class="font-display">Built to outlast the website</h2>
        <p class="text-basalt/75">
            Every word, recording, story and meaning here is structured so it can be exported and deposited into
            open language archives. The website is how the community learns and contributes day to day — but the
            underlying record is designed to survive independently of any one platform, organisation or grant.
        </p>

        <h2 class="font-display">How to contribute</h2>
        <p class="text-basalt/75">
            Speakers, elders and families can add words, names, recordings and stories. Community contributions are
            reviewed by administrators before they are published, so the archive stays accurate and respectful.
            If you would like an account, sign up and ask an administrator to grant you contributor access.
        </p>
    </div>

    <div class="mt-10 card p-7 reveal">
        <p class="eyebrow">The five domains we document</p>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            @foreach ([
                ['Oral traditions & language','Words, names, proverbs, folktales and the spoken voice.'],
                ['Performing arts','Songs, music and the instruments that carry them.'],
                ['Social practices & festivals','Rites, ceremonies and the calendar of community life.'],
                ['Knowledge of nature','Farming, plants, healing and the land of the plateau.'],
                ['Traditional craftsmanship','Cloth, regalia, tools and the makers who keep the skills.'],
            ] as [$t,$d])
                <div class="rounded-xl bg-millet-200/50 p-4">
                    <p class="font-display text-lg font-semibold">{{ $t }}</p>
                    <p class="mt-1 text-sm text-basalt/65">{{ $d }}</p>
                </div>
            @endforeach
        </div>
        <p class="mt-4 text-xs text-basalt/45">Structured around UNESCO's five domains of intangible cultural heritage (2003 Convention).</p>
    </div>
</div>
