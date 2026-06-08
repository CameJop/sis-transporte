<template>
    <Head title="Trans. Copacabana S.A. — Conectando Bolivia desde 1959" />

    <div class="root">

        <!-- ══ NAVBAR ══ -->
        <nav class="navbar">
            <div class="navbar-inner">
                <div class="navbar-left">
                    <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="navbar-logo" />
                    <div class="nav-links">
                        <a href="#destinos"   class="nav-link">Destinos</a>
                        <a href="#horarios"   class="nav-link">Horarios</a>
                        <a href="#servicios"  class="nav-link">Servicios</a>
                        <a href="#flota"      class="nav-link">Nuestra Flota</a>
                        <a href="#nosotros"   class="nav-link">Nosotros</a>
                        <a href="#sucursales" class="nav-link">Sucursales</a>
                        <a href="#contacto"   class="nav-link">Contacto</a>
                    </div>
                </div>
                <div class="navbar-right">
                    <a href="/login" class="btn-cuenta">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Mi Cuenta
                    </a>
                </div>
            </div>
        </nav>

        <!-- ══ HERO ══ -->
        <section class="hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <p class="hero-eyebrow">Empresa boliviana de transporte terrestre</p>
                <h1 class="hero-title">Conectando Bolivia<br /><span class="hero-accent">desde 1959</span></h1>
                <p class="hero-sub">Más de 65 años siendo la empresa pionera en transporte de pasajeros,<br class="br-hide"/>carga y encomiendas en todo el territorio nacional.</p>

                <!-- Buscador rápido -->
                <div class="search-box">
                    <div class="search-field">
                        <label class="search-label">Origen</label>
                        <select class="search-select">
                            <option>Cochabamba</option>
                            <option>La Paz</option>
                            <option>Santa Cruz</option>
                            <option>Oruro</option>
                            <option>Sucre</option>
                            <option>Potosí</option>
                            <option>Tarija</option>
                        </select>
                    </div>
                    <div class="search-divider">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                    <div class="search-field">
                        <label class="search-label">Destino</label>
                        <select class="search-select">
                            <option>La Paz</option>
                            <option>Cochabamba</option>
                            <option>Santa Cruz</option>
                            <option>Oruro</option>
                            <option>Sucre</option>
                            <option>Tarija</option>
                            <option>Trinidad</option>
                            <option>Yacuiba</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label class="search-label">Fecha</label>
                        <input type="date" class="search-select" />
                    </div>
                    <button class="search-btn">Buscar Pasaje</button>
                </div>
            </div>

            <!-- Stats bar -->
            <div class="stats-bar">
                <div class="stat-item">
                    <span class="stat-num">65+</span>
                    <span class="stat-lbl">Años de experiencia</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">1M+</span>
                    <span class="stat-lbl">Pasajeros al año</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">11M km</span>
                    <span class="stat-lbl">Recorridos anuales</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">30+</span>
                    <span class="stat-lbl">Sucursales en Bolivia</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">9</span>
                    <span class="stat-lbl">Departamentos</span>
                </div>
            </div>
        </section>

        <!-- ══ DESTINOS ══ -->
        <section id="destinos" class="section section-dark">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-tag">Nuestros Destinos</span>
                    <h2 class="section-title">Viaja a cualquier rincón de Bolivia</h2>
                    <div class="section-rule"></div>
                    <p class="section-desc">Cubrimos las rutas más importantes del país, conectando norte a sur y de oriente a occidente.</p>
                </div>

                <div class="destinos-grid">
                    <div class="destino-card destino-featured">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80" alt="Cochabamba" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">Cochabamba</span>
                            <span class="destino-tag">Ciudad Jardín</span>
                        </div>
                    </div>
                    <div class="destino-card">
                        <img src="https://images.unsplash.com/photo-1591608971362-f08b2a75731a?w=400&q=80" alt="La Paz" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">La Paz</span>
                            <span class="destino-tag">Sede de Gobierno</span>
                        </div>
                    </div>
                    <div class="destino-card">
                        <img src="https://images.unsplash.com/photo-1512438248247-f0f2a5a8b7f0?w=400&q=80" alt="Santa Cruz" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">Santa Cruz</span>
                            <span class="destino-tag">Capital económica</span>
                        </div>
                    </div>
                    <div class="destino-card">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&q=80" alt="Oruro" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">Oruro</span>
                            <span class="destino-tag">Folklore y cultura</span>
                        </div>
                    </div>
                    <div class="destino-card">
                        <img src="https://images.unsplash.com/photo-1533050487297-09b450131914?w=400&q=80" alt="Sucre" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">Sucre</span>
                            <span class="destino-tag">Capital constitucional</span>
                        </div>
                    </div>
                    <div class="destino-card">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&q=80" alt="Potosí" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">Potosí</span>
                            <span class="destino-tag">Patrimonio mundial</span>
                        </div>
                    </div>
                    <div class="destino-card">
                        <img src="https://images.unsplash.com/photo-1519922639192-e73293ca430e?w=400&q=80" alt="Tarija" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">Tarija</span>
                            <span class="destino-tag">La tierra del vino</span>
                        </div>
                    </div>
                    <div class="destino-card">
                        <img src="https://images.unsplash.com/photo-1504893524553-b855bce32c67?w=400&q=80" alt="Trinidad" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">Trinidad</span>
                            <span class="destino-tag">Corazón del Beni</span>
                        </div>
                    </div>
                    <div class="destino-card">
                        <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?w=400&q=80" alt="Yacuiba" class="destino-img" />
                        <div class="destino-overlay">
                            <span class="destino-name">Yacuiba</span>
                            <span class="destino-tag">Puerta del sur</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ SERVICIOS ══ -->
        <section id="servicios" class="section section-darker">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-tag">Lo que ofrecemos</span>
                    <h2 class="section-title">Nuestros Servicios</h2>
                    <div class="section-rule"></div>
                </div>

                <div class="servicios-grid">
                    <div class="servicio-card servicio-pasajeros">
                        <div class="servicio-icon-wrap">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        </div>
                        <h3 class="servicio-title">Transporte de Pasajeros</h3>
                        <p class="servicio-desc">Viaja con comodidad y seguridad en nuestra flota moderna. Buses cama, semicama y normal con salidas diarias a todos los destinos del país.</p>
                        <ul class="servicio-features">
                            <li>Asientos cama totalmente reclinables</li>
                            <li>Televisión individual a bordo</li>
                            <li>Aire acondicionado y calefacción</li>
                            <li>Baño en buses de largo recorrido</li>
                            <li>Mantenimiento constante de la flota</li>
                        </ul>
                        <a href="/login" class="servicio-btn">Comprar pasaje</a>
                    </div>

                    <div class="servicio-card servicio-carga">
                        <div class="servicio-icon-wrap">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                        </div>
                        <h3 class="servicio-title">Carga y Encomiendas</h3>
                        <p class="servicio-desc">Servicio confiable y seguro para transportar tus materiales. Desde sobres hasta traslados completos, a cualquier destino nacional.</p>
                        <ul class="servicio-features">
                            <li>Recepción y entrega en sucursales</li>
                            <li>Servicio puerta a puerta</li>
                            <li>Camiones especializados de carga</li>
                            <li>Rastreo en tiempo real</li>
                            <li>Soluciones logísticas a medida</li>
                        </ul>
                        <a href="#contacto" class="servicio-btn servicio-btn-outline">Cotizar envío</a>
                    </div>

                    <div class="servicio-card servicio-corp">
                        <div class="servicio-icon-wrap">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <h3 class="servicio-title">Servicio Corporativo</h3>
                        <p class="servicio-desc">Diseñamos soluciones de logística adaptadas a las necesidades de tu empresa. Traslados puerta a puerta en el eje troncal del país.</p>
                        <ul class="servicio-features">
                            <li>Contratos personalizados</li>
                            <li>Transporte de personal</li>
                            <li>Flota dedicada</li>
                            <li>Facturación corporativa</li>
                            <li>Atención ejecutiva dedicada</li>
                        </ul>
                        <a href="#contacto" class="servicio-btn servicio-btn-outline">Consultar</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ FLOTA ══ -->
        <section id="flota" class="section section-dark">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-tag">Comodidad garantizada</span>
                    <h2 class="section-title">Nuestra Flota</h2>
                    <div class="section-rule"></div>
                    <p class="section-desc">La flota más moderna y segura de Bolivia, con mantenimiento constante en nuestros propios talleres.</p>
                </div>

                <div class="flota-grid">
                    <div class="flota-card">
                        <div class="flota-badge">Económico</div>
                        <div class="flota-icon">🚌</div>
                        <h3 class="flota-title">Bus Normal</h3>
                        <p class="flota-sub">Ideal para trayectos cortos e intermedios</p>
                        <ul class="flota-list">
                            <li><span class="check">✓</span> Asientos cómodos reclinables</li>
                            <li><span class="check">✓</span> Sistema de audio a bordo</li>
                            <li><span class="check">✓</span> Televisión central</li>
                            <li><span class="check">✓</span> Bodega para equipaje</li>
                            <li><span class="cross">✗</span> Baño a bordo</li>
                            <li><span class="cross">✗</span> Aire acondicionado</li>
                        </ul>
                    </div>

                    <div class="flota-card flota-featured">
                        <div class="flota-badge flota-badge-pop">Más popular</div>
                        <div class="flota-icon">🚌</div>
                        <h3 class="flota-title">Semi Cama</h3>
                        <p class="flota-sub">El balance perfecto entre precio y confort</p>
                        <ul class="flota-list">
                            <li><span class="check">✓</span> Asientos semi-reclinables 160°</li>
                            <li><span class="check">✓</span> TV individual por asiento</li>
                            <li><span class="check">✓</span> Calefacción a bordo</li>
                            <li><span class="check">✓</span> Bodega amplia para equipaje</li>
                            <li><span class="check">✓</span> Servicio de refrigerio</li>
                            <li><span class="cross">✗</span> Aire acondicionado</li>
                        </ul>
                    </div>

                    <div class="flota-card">
                        <div class="flota-badge flota-badge-premium">Premium</div>
                        <div class="flota-icon">✨</div>
                        <h3 class="flota-title">Bus Cama</h3>
                        <p class="flota-sub">La experiencia definitiva en viaje terrestre</p>
                        <ul class="flota-list">
                            <li><span class="check">✓</span> Asiento-cama 180° totalmente plano</li>
                            <li><span class="check">✓</span> TV individual por asiento</li>
                            <li><span class="check">✓</span> Aire acondicionado / calefacción</li>
                            <li><span class="check">✓</span> Baño privado a bordo</li>
                            <li><span class="check">✓</span> Servicio de cena a bordo</li>
                            <li><span class="check">✓</span> Manta y almohada incluidas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ HORARIOS ══ -->
        <section id="horarios" class="section section-darker">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-tag">Salidas diarias</span>
                    <h2 class="section-title">Horarios de Salida</h2>
                    <div class="section-rule"></div>
                </div>

                <div class="horarios-tabs">
                    <button class="htab htab-active">Cochabamba</button>
                    <button class="htab">La Paz</button>
                    <button class="htab">Santa Cruz</button>
                    <button class="htab">Oruro</button>
                    <button class="htab">Potosí</button>
                    <button class="htab">Tarija</button>
                    <button class="htab">Sucre</button>
                </div>

                <div class="horarios-grid">
                    <div class="horario-row">
                        <div class="horario-destino">
                            <span class="horario-icon">📍</span>
                            <span class="horario-ciudad">La Paz</span>
                        </div>
                        <div class="horario-horas">
                            <span class="hora-pill">07:30</span>
                            <span class="hora-pill">10:00</span>
                            <span class="hora-pill">11:30</span>
                            <span class="hora-pill">16:00</span>
                            <span class="hora-pill">21:00</span>
                            <span class="hora-pill">21:30</span>
                            <span class="hora-pill">22:00</span>
                            <span class="hora-pill">22:30</span>
                        </div>
                    </div>
                    <div class="horario-row">
                        <div class="horario-destino">
                            <span class="horario-icon">📍</span>
                            <span class="horario-ciudad">Santa Cruz</span>
                        </div>
                        <div class="horario-horas">
                            <span class="hora-pill">08:00</span>
                            <span class="hora-pill">19:00</span>
                            <span class="hora-pill">20:00</span>
                            <span class="hora-pill">21:00</span>
                            <span class="hora-pill">21:30</span>
                        </div>
                    </div>
                    <div class="horario-row">
                        <div class="horario-destino">
                            <span class="horario-icon">📍</span>
                            <span class="horario-ciudad">Oruro</span>
                        </div>
                        <div class="horario-horas">
                            <span class="hora-pill">07:00</span>
                            <span class="hora-pill">10:30</span>
                            <span class="hora-pill">13:30</span>
                            <span class="hora-pill">15:30</span>
                            <span class="hora-pill">17:30</span>
                        </div>
                    </div>
                    <div class="horario-row">
                        <div class="horario-destino">
                            <span class="horario-icon">📍</span>
                            <span class="horario-ciudad">Sucre</span>
                        </div>
                        <div class="horario-horas">
                            <span class="hora-pill">21:30</span>
                        </div>
                    </div>
                    <div class="horario-row">
                        <div class="horario-destino">
                            <span class="horario-icon">📍</span>
                            <span class="horario-ciudad">Potosí</span>
                        </div>
                        <div class="horario-horas">
                            <span class="hora-pill">21:00</span>
                        </div>
                    </div>
                    <div class="horario-row">
                        <div class="horario-destino">
                            <span class="horario-icon">📍</span>
                            <span class="horario-ciudad">Tarija</span>
                        </div>
                        <div class="horario-horas">
                            <span class="hora-pill">17:00</span>
                        </div>
                    </div>
                </div>

                <p class="horarios-note">* Horarios sujetos a disponibilidad. Salidas todos los días desde la Terminal de Buses de Cochabamba.</p>
                <div style="text-align:center;margin-top:28px">
                    <a href="/login" class="btn-primary-lg">Ver todos los horarios y comprar</a>
                </div>
            </div>
        </section>

        <!-- ══ NOSOTROS ══ -->
        <section id="nosotros" class="section section-dark">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-tag">Nuestra Empresa</span>
                    <h2 class="section-title">Quiénes Somos</h2>
                    <div class="section-rule"></div>
                </div>

                <div class="nosotros-layout">
                    <div class="nosotros-text">
                        <div class="historia-block">
                            <h3 class="historia-title">Nuestra Historia</h3>
                            <p class="historia-p">Somos una empresa boliviana de transporte terrestre, fundada el <strong>5 de agosto de 1959</strong> en la ciudad de La Paz, recibiendo nuestro nombre en honor a la patrona de la empresa, la <strong>Virgen de Copacabana</strong>.</p>
                            <p class="historia-p">Inauguramos el servicio interdepartamental de pasajeros entre La Paz y Oruro, siendo <strong>pioneros en la introducción de omnibuses</strong> en el territorio boliviano. Desde entonces hemos extendido nuestros destinos a Cochabamba, Santa Cruz, Sucre, Potosí, Trinidad, Tarija, Villamontes, Camargo, El Alto y Yacuiba.</p>
                            <p class="historia-p">Hoy contamos con más de <strong>30 sucursales en toda Bolivia</strong>, viajamos 11 millones de kilómetros al año y transportamos aproximadamente un millón de pasajeros anualmente.</p>
                        </div>

                        <div class="mv-tabs-wrap">
                            <div class="mv-block">
                                <h4 class="mv-label">🎯 Misión</h4>
                                <p class="mv-p">Brindar un servicio eficiente y de valor añadido en el transporte de pasajeros, carga y encomiendas, ofreciendo calidad en el servicio, garantizando la satisfacción y bienestar del cliente, uniendo a Bolivia a través de sus rutas de todo el territorio nacional.</p>
                            </div>
                            <div class="mv-block">
                                <h4 class="mv-label">🌐 Visión</h4>
                                <p class="mv-p">Consolidarnos como pioneros del transporte terrestre en Bolivia, continuamente expandiendo nuestras rutas, implementando nuevas tecnologías y mejorando nuestros servicios para seguir integrando el país.</p>
                            </div>
                        </div>
                    </div>

                    <div class="valores-wrap">
                        <h3 class="valores-heading">Nuestros Valores</h3>
                        <div class="valor-item">
                            <span class="valor-icon">🛡️</span>
                            <div>
                                <h4 class="valor-title">Seguridad</h4>
                                <p class="valor-desc">La seguridad y bienestar de nuestros clientes es nuestra prioridad absoluta.</p>
                            </div>
                        </div>
                        <div class="valor-item">
                            <span class="valor-icon">⚡</span>
                            <div>
                                <h4 class="valor-title">Eficiencia</h4>
                                <p class="valor-desc">Maximizamos nuestros recursos para brindar el mejor servicio a nivel nacional.</p>
                            </div>
                        </div>
                        <div class="valor-item">
                            <span class="valor-icon">🤝</span>
                            <div>
                                <h4 class="valor-title">Respeto</h4>
                                <p class="valor-desc">Entre todos los que conformamos la familia Trans. Copacabana S.A.</p>
                            </div>
                        </div>
                        <div class="valor-item">
                            <span class="valor-icon">❤️</span>
                            <div>
                                <h4 class="valor-title">Solidaridad</h4>
                                <p class="valor-desc">Comprometidos al servicio social y apoyo a las causas necesitadas.</p>
                            </div>
                        </div>
                        <div class="valor-item">
                            <span class="valor-icon">✨</span>
                            <div>
                                <h4 class="valor-title">Honestidad</h4>
                                <p class="valor-desc">Un valor fundamental transmitido a clientes, proveedores y la comunidad.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ SUCURSALES ══ -->
        <section id="sucursales" class="section section-darker">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-tag">Estamos cerca de ti</span>
                    <h2 class="section-title">Nuestras Sucursales</h2>
                    <div class="section-rule"></div>
                    <p class="section-desc">Más de 30 agencias en todo el país para que puedas realizar tus compras, envíos y consultas de forma personal.</p>
                </div>

                <div class="sucursales-grid">
                    <div class="sucursal-card">
                        <div class="sucursal-city">Cochabamba</div>
                        <div class="sucursal-detail">
                            <p>🏢 Calle Luis Uriona Nro. 1936</p>
                            <p>📞 4252004 – 4235927</p>
                            <p>⏰ 05:30 – 23:00 hrs</p>
                        </div>
                        <span class="sucursal-badge">Oficina Central</span>
                    </div>
                    <div class="sucursal-card">
                        <div class="sucursal-city">La Paz</div>
                        <div class="sucursal-detail">
                            <p>🏢 Terminal Bimodal La Paz</p>
                            <p>📞 +591 2 228 5478</p>
                            <p>⏰ 06:00 – 22:00 hrs</p>
                        </div>
                    </div>
                    <div class="sucursal-card">
                        <div class="sucursal-city">Santa Cruz</div>
                        <div class="sucursal-detail">
                            <p>🏢 Terminal Bimodal Santa Cruz</p>
                            <p>📞 +591 3 348 7890</p>
                            <p>⏰ 06:00 – 23:00 hrs</p>
                        </div>
                    </div>
                    <div class="sucursal-card">
                        <div class="sucursal-city">Oruro</div>
                        <div class="sucursal-detail">
                            <p>🏢 Terminal de Buses de Oruro</p>
                            <p>📞 +591 2 525 6789</p>
                            <p>⏰ 05:30 – 22:00 hrs</p>
                        </div>
                    </div>
                    <div class="sucursal-card">
                        <div class="sucursal-city">Sucre</div>
                        <div class="sucursal-detail">
                            <p>🏢 Terminal de Buses de Sucre</p>
                            <p>📞 +591 4 644 3210</p>
                            <p>⏰ 06:00 – 22:00 hrs</p>
                        </div>
                    </div>
                    <div class="sucursal-card sucursal-more">
                        <div class="sucursal-more-text">+25 sucursales más en todo Bolivia</div>
                        <a href="#contacto" class="sucursal-more-btn">Ver todas</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ CONTACTO ══ -->
        <section id="contacto" class="section section-dark">
            <div class="section-inner">
                <div class="section-header">
                    <span class="section-tag">Estamos para ayudarte</span>
                    <h2 class="section-title">Contáctenos</h2>
                    <div class="section-rule"></div>
                </div>

                <div class="contacto-layout">
                    <div class="contacto-info">
                        <div class="contacto-item">
                            <div class="contacto-icon-wrap">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.62 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.12 6.12l.87-.87a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <div>
                                <p class="contacto-label">Atención al cliente</p>
                                <p class="contacto-value">+591 72 233 555</p>
                                <p class="contacto-sub">WhatsApp disponible</p>
                            </div>
                        </div>
                        <div class="contacto-item">
                            <div class="contacto-icon-wrap">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                            <div>
                                <p class="contacto-label">Correo electrónico</p>
                                <p class="contacto-value">info@transcopacabanasa.com</p>
                                <p class="contacto-sub">Respondemos en 24 hrs</p>
                            </div>
                        </div>
                        <div class="contacto-item">
                            <div class="contacto-icon-wrap">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div>
                                <p class="contacto-label">Oficina Central</p>
                                <p class="contacto-value">Calle Luis Uriona Nro. 1936</p>
                                <p class="contacto-sub">Cochabamba, Bolivia</p>
                            </div>
                        </div>
                        <div class="contacto-item">
                            <div class="contacto-icon-wrap">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <div>
                                <p class="contacto-label">Carga y Encomiendas</p>
                                <p class="contacto-value">4250428 – 4235928</p>
                                <p class="contacto-sub">Lunes a domingo</p>
                            </div>
                        </div>

                        <div class="redes-wrap">
                            <p class="redes-label">Síguenos en redes sociales</p>
                            <div class="redes-links">
                                <a href="https://www.facebook.com/Transcopacabanasabolivia" target="_blank" class="red-btn">Facebook</a>
                                <a href="https://www.instagram.com/transcopacabanasa/" target="_blank" class="red-btn">Instagram</a>
                                <a href="https://twitter.com/transcopasa" target="_blank" class="red-btn">Twitter</a>
                                <a href="https://www.linkedin.com/company/trans-copacabana-sa/" target="_blank" class="red-btn">LinkedIn</a>
                            </div>
                        </div>
                    </div>

                    <div class="contacto-form-wrap">
                        <h3 class="form-title">Envíanos un mensaje</h3>
                        <div class="form-field">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-input" placeholder="Juan Pérez" disabled />
                        </div>
                        <div class="form-field">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-input" placeholder="correo@ejemplo.com" disabled />
                        </div>
                        <div class="form-field">
                            <label class="form-label">Asunto</label>
                            <select class="form-input" disabled>
                                <option>Consulta sobre pasajes</option>
                                <option>Carga y encomiendas</option>
                                <option>Servicio corporativo</option>
                                <option>Reclamo o sugerencia</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label class="form-label">Mensaje</label>
                            <textarea class="form-input form-textarea" placeholder="Escribe tu mensaje aquí..." disabled></textarea>
                        </div>
                        <button class="btn-primary-lg" disabled style="opacity:0.5;cursor:not-allowed">Enviar mensaje</button>
                        <p style="font-size:0.72rem;color:rgba(255,255,255,0.3);margin-top:8px;text-align:center">Vista previa — formulario no funcional</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ FOOTER ══ -->
        <footer class="footer">
            <div class="footer-inner">
                <div class="footer-brand">
                    <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="footer-logo" />
                    <p class="footer-tagline">Empresa 100% boliviana con más de 65 años conectando el país.</p>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Navegación</h4>
                    <a href="#destinos"   class="footer-link">Destinos</a>
                    <a href="#horarios"   class="footer-link">Horarios</a>
                    <a href="#servicios"  class="footer-link">Servicios</a>
                    <a href="#flota"      class="footer-link">Nuestra Flota</a>
                    <a href="#nosotros"   class="footer-link">Nosotros</a>
                    <a href="#sucursales" class="footer-link">Sucursales</a>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Servicios</h4>
                    <a href="/login"  class="footer-link">Comprar pasaje</a>
                    <a href="/login"  class="footer-link">Rastrear envío</a>
                    <a href="#contacto" class="footer-link">Carga y encomiendas</a>
                    <a href="#contacto" class="footer-link">Servicio corporativo</a>
                    <a href="/login"  class="footer-link">Mi cuenta</a>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Contacto</h4>
                    <p class="footer-link">+591 72 233 555</p>
                    <p class="footer-link">info@transcopacabanasa.com</p>
                    <p class="footer-link">Calle Luis Uriona Nro. 1936</p>
                    <p class="footer-link">Cochabamba, Bolivia</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ new Date().getFullYear() }} Trans. Copacabana S.A. — Todos los derechos reservados.</p>
                <p>Empresa 100% boliviana · Fundada el 5 de agosto de 1959</p>
            </div>
        </footer>

    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.root {
    min-height: 100vh;
    background: #0d1117;
    font-family: 'Nunito', sans-serif;
    color: #e2e8f0;
    overflow-x: hidden;
}

/* ══ NAVBAR ══ */
.navbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 200;
    background: rgba(9, 11, 20, 0.88);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid rgba(255,255,255,0.07);
}
.navbar-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 10px 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.navbar-left { display: flex; align-items: center; gap: 28px; }
.navbar-logo  { height: 42px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); }
.nav-links    { display: flex; align-items: center; gap: 2px; }
.nav-link {
    padding: 7px 13px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    color: rgba(255,255,255,0.55);
    text-decoration: none;
    transition: color 0.2s, background 0.2s;
    white-space: nowrap;
}
.nav-link:hover { color: #fff; background: rgba(255,255,255,0.07); }
.btn-cuenta {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 20px;
    border-radius: 50px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff;
    font-weight: 700; font-size: 0.84rem;
    text-decoration: none;
    transition: filter 0.2s, transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 14px rgba(192,57,43,0.35);
}
.btn-cuenta:hover { filter: brightness(1.1); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(192,57,43,0.5); }

/* ══ HERO ══ */
.hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-image: url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=1920&q=85');
    background-size: cover;
    background-position: center;
    padding-top: 68px;
}
.hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(160deg, rgba(6,9,22,0.93) 0%, rgba(12,20,48,0.82) 45%, rgba(60,20,8,0.65) 100%);
}
.hero-content {
    position: relative; z-index: 2;
    text-align: center; padding: 0 24px;
    max-width: 860px;
}
.hero-eyebrow {
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase;
    color: rgba(192,57,43,0.85); margin-bottom: 16px;
}
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.8rem, 6vw, 5rem);
    font-weight: 900; color: #fff; line-height: 1.08;
    text-shadow: 0 4px 24px rgba(0,0,0,0.7);
    margin-bottom: 20px;
}
.hero-accent { color: #e05c4b; }
.hero-sub {
    font-size: 1rem; color: rgba(255,255,255,0.6);
    line-height: 1.7; margin-bottom: 44px; max-width: 600px; margin-inline: auto;
}
.br-hide { display: none; }

/* Search box */
.search-box {
    display: flex; align-items: flex-end;
    gap: 0;
    background: rgba(255,255,255,0.07);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 16px;
    padding: 20px 24px;
    flex-wrap: wrap;
    gap: 16px;
}
.search-field { display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 140px; }
.search-label { font-size: 0.68rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.45); }
.search-select {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 10px; color: #fff;
    font-family: 'Nunito', sans-serif; font-size: 0.9rem; font-weight: 600;
    padding: 10px 14px; outline: none;
    transition: border-color 0.2s, background 0.2s;
    cursor: pointer;
}
.search-select:focus { background: rgba(255,255,255,0.12); border-color: rgba(192,57,43,0.6); }
.search-select option { background: #1a1f2e; color: #fff; }
.search-divider {
    display: flex; align-items: flex-end; padding-bottom: 10px;
    color: rgba(255,255,255,0.3); flex-shrink: 0;
}
.search-btn {
    padding: 11px 28px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff; border: none; border-radius: 10px;
    font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 0.9rem;
    cursor: pointer; transition: filter 0.2s, transform 0.2s;
    white-space: nowrap; align-self: flex-end;
    box-shadow: 0 4px 16px rgba(192,57,43,0.4);
}
.search-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }

/* Stats bar */
.stats-bar {
    position: relative; z-index: 2;
    width: 100%; display: flex; justify-content: center; flex-wrap: wrap;
    background: rgba(5,8,18,0.8);
    backdrop-filter: blur(12px);
    border-top: 1px solid rgba(255,255,255,0.07);
    margin-top: 60px;
}
.stat-item {
    flex: 1; min-width: 150px; max-width: 220px;
    display: flex; flex-direction: column; align-items: center;
    padding: 20px 12px;
    border-right: 1px solid rgba(255,255,255,0.06);
}
.stat-item:last-child { border-right: none; }
.stat-num { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #e05c4b; line-height: 1; }
.stat-lbl { font-size: 0.68rem; color: rgba(255,255,255,0.4); font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 5px; }

/* ══ SECTIONS ══ */
.section { padding: 96px 24px; }
.section-dark    { background: #0d1117; }
.section-darker  { background: #090c14; }
.section-inner   { max-width: 1200px; margin: 0 auto; }
.section-header  { text-align: center; margin-bottom: 56px; }
.section-tag {
    display: inline-block; font-size: 0.68rem; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase;
    color: #c0392b; margin-bottom: 12px;
}
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    font-weight: 700; color: #fff; margin-bottom: 16px;
}
.section-rule {
    width: 52px; height: 3px;
    background: linear-gradient(90deg, #c0392b, transparent);
    margin: 0 auto 20px; border-radius: 2px;
}
.section-desc { font-size: 0.95rem; color: rgba(255,255,255,0.5); max-width: 580px; margin: 0 auto; line-height: 1.7; }

/* ══ DESTINOS ══ */
.destinos-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: 260px 220px;
    gap: 12px;
}
.destino-card { position: relative; border-radius: 14px; overflow: hidden; cursor: pointer; }
.destino-featured { grid-column: span 2; grid-row: span 2; }
.destino-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.destino-card:hover .destino-img { transform: scale(1.06); }
.destino-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 55%);
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 20px;
}
.destino-name { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: #fff; }
.destino-featured .destino-name { font-size: 2rem; }
.destino-tag { font-size: 0.7rem; font-weight: 700; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px; margin-top: 3px; }

/* ══ SERVICIOS ══ */
.servicios-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.servicio-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px; padding: 40px 32px;
    display: flex; flex-direction: column; gap: 16px;
    transition: border-color 0.3s, background 0.3s, transform 0.3s;
}
.servicio-card:hover { border-color: rgba(192,57,43,0.4); background: rgba(255,255,255,0.06); transform: translateY(-4px); }
.servicio-pasajeros:hover { border-color: rgba(192,57,43,0.5); }
.servicio-icon-wrap {
    width: 60px; height: 60px; border-radius: 14px;
    background: rgba(192,57,43,0.12); border: 1px solid rgba(192,57,43,0.25);
    display: flex; align-items: center; justify-content: center;
    color: #e05c4b;
}
.servicio-title { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: #fff; }
.servicio-desc  { font-size: 0.88rem; color: rgba(255,255,255,0.55); line-height: 1.7; }
.servicio-features { list-style: none; display: flex; flex-direction: column; gap: 8px; flex: 1; }
.servicio-features li { font-size: 0.82rem; color: rgba(255,255,255,0.6); display: flex; align-items: center; gap: 8px; }
.servicio-features li::before { content: '✓'; color: #c0392b; font-weight: 700; flex-shrink: 0; }
.servicio-btn {
    display: block; text-align: center;
    padding: 11px 24px; border-radius: 50px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff; font-weight: 700; font-size: 0.87rem;
    text-decoration: none; transition: filter 0.2s, transform 0.2s;
    box-shadow: 0 4px 14px rgba(192,57,43,0.35); margin-top: auto;
}
.servicio-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }
.servicio-btn-outline {
    background: transparent;
    border: 1px solid rgba(192,57,43,0.5); color: rgba(255,255,255,0.8);
    box-shadow: none;
}
.servicio-btn-outline:hover { background: rgba(192,57,43,0.1); border-color: rgba(192,57,43,0.8); }

/* ══ FLOTA ══ */
.flota-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.flota-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px; padding: 36px 28px;
    position: relative; text-align: center;
    transition: border-color 0.3s, transform 0.3s;
}
.flota-card:hover { border-color: rgba(255,255,255,0.2); transform: translateY(-4px); }
.flota-featured {
    border-color: rgba(192,57,43,0.4);
    background: rgba(192,57,43,0.06);
}
.flota-featured:hover { border-color: rgba(192,57,43,0.7); }
.flota-badge {
    display: inline-block; font-size: 0.65rem; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    padding: 4px 12px; border-radius: 50px;
    background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.45);
    margin-bottom: 20px;
}
.flota-badge-pop { background: rgba(192,57,43,0.2); color: #e05c4b; }
.flota-badge-premium { background: rgba(255,200,80,0.15); color: rgba(255,200,80,0.9); }
.flota-icon { font-size: 2.8rem; margin-bottom: 16px; display: block; }
.flota-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 8px; }
.flota-sub   { font-size: 0.8rem; color: rgba(255,255,255,0.4); margin-bottom: 24px; line-height: 1.5; }
.flota-list  { list-style: none; text-align: left; display: flex; flex-direction: column; gap: 10px; }
.flota-list li { font-size: 0.83rem; color: rgba(255,255,255,0.6); display: flex; align-items: center; gap: 10px; }
.check { color: #4ade80; font-weight: 700; }
.cross { color: rgba(255,255,255,0.2); }

/* ══ HORARIOS ══ */
.horarios-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 36px; justify-content: center; }
.htab {
    padding: 8px 22px; border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.12);
    background: transparent; color: rgba(255,255,255,0.45);
    font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 0.82rem;
    cursor: pointer; transition: all 0.2s;
}
.htab:hover { border-color: rgba(192,57,43,0.4); color: rgba(255,255,255,0.8); }
.htab-active { background: linear-gradient(135deg, #c0392b, #96281b); border-color: transparent; color: #fff; }
.horarios-grid { display: flex; flex-direction: column; gap: 2px; }
.horario-row {
    display: flex; align-items: center; gap: 24px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 12px; padding: 16px 24px;
    transition: background 0.2s;
}
.horario-row:hover { background: rgba(255,255,255,0.055); }
.horario-destino { display: flex; align-items: center; gap: 10px; min-width: 130px; }
.horario-icon { font-size: 1rem; }
.horario-ciudad { font-weight: 700; font-size: 0.9rem; color: #fff; }
.horario-horas  { display: flex; flex-wrap: wrap; gap: 8px; }
.hora-pill {
    padding: 4px 12px; border-radius: 50px;
    background: rgba(192,57,43,0.12); border: 1px solid rgba(192,57,43,0.25);
    font-size: 0.8rem; font-weight: 700; color: rgba(224,92,75,0.9);
    letter-spacing: 0.5px;
}
.horarios-note { font-size: 0.75rem; color: rgba(255,255,255,0.25); text-align: center; margin-top: 20px; line-height: 1.6; }
.btn-primary-lg {
    display: inline-block;
    padding: 14px 40px; border-radius: 50px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff; font-weight: 700; font-size: 1rem;
    text-decoration: none; border: none; cursor: pointer;
    transition: filter 0.2s, transform 0.2s;
    box-shadow: 0 6px 24px rgba(192,57,43,0.4);
}
.btn-primary-lg:hover { filter: brightness(1.1); transform: translateY(-2px); }

/* ══ NOSOTROS ══ */
.nosotros-layout { display: grid; grid-template-columns: 1fr 420px; gap: 56px; align-items: start; }
.historia-block { margin-bottom: 40px; }
.historia-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 18px; }
.historia-p { font-size: 0.92rem; color: rgba(255,255,255,0.65); line-height: 1.8; margin-bottom: 14px; }
.historia-p strong { color: rgba(255,255,255,0.9); }
.mv-tabs-wrap { display: flex; flex-direction: column; gap: 16px; }
.mv-block {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-left: 3px solid #c0392b; border-radius: 0 12px 12px 0;
    padding: 20px 24px;
}
.mv-label { font-weight: 700; font-size: 0.9rem; color: #fff; margin-bottom: 8px; }
.mv-p { font-size: 0.85rem; color: rgba(255,255,255,0.6); line-height: 1.7; }
.valores-wrap {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px; padding: 32px 28px;
}
.valores-heading { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 24px; }
.valor-item {
    display: flex; align-items: flex-start; gap: 16px;
    padding: 16px 0; border-bottom: 1px solid rgba(255,255,255,0.06);
}
.valor-item:last-child { border-bottom: none; padding-bottom: 0; }
.valor-icon { font-size: 1.5rem; flex-shrink: 0; margin-top: 2px; }
.valor-title { font-weight: 700; font-size: 0.9rem; color: #fff; margin-bottom: 4px; }
.valor-desc  { font-size: 0.8rem; color: rgba(255,255,255,0.45); line-height: 1.6; }

/* ══ SUCURSALES ══ */
.sucursales-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.sucursal-card {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px; padding: 28px 24px; position: relative;
    transition: border-color 0.3s, transform 0.3s;
}
.sucursal-card:hover { border-color: rgba(192,57,43,0.35); transform: translateY(-3px); }
.sucursal-city { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 14px; }
.sucursal-detail { display: flex; flex-direction: column; gap: 6px; }
.sucursal-detail p { font-size: 0.82rem; color: rgba(255,255,255,0.5); line-height: 1.5; }
.sucursal-badge {
    position: absolute; top: 16px; right: 16px;
    font-size: 0.62rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    background: rgba(192,57,43,0.2); color: #e05c4b;
    padding: 3px 10px; border-radius: 50px;
    border: 1px solid rgba(192,57,43,0.3);
}
.sucursal-more {
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px;
    background: rgba(192,57,43,0.05); border-color: rgba(192,57,43,0.2);
    text-align: center;
}
.sucursal-more-text { font-size: 0.9rem; color: rgba(255,255,255,0.5); font-weight: 600; }
.sucursal-more-btn {
    padding: 9px 24px; border-radius: 50px;
    border: 1px solid rgba(192,57,43,0.5); color: rgba(224,92,75,0.9);
    font-weight: 700; font-size: 0.85rem; text-decoration: none;
    transition: background 0.2s;
}
.sucursal-more-btn:hover { background: rgba(192,57,43,0.1); }

/* ══ CONTACTO ══ */
.contacto-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: start; }
.contacto-item { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 28px; }
.contacto-icon-wrap {
    width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
    background: rgba(192,57,43,0.1); border: 1px solid rgba(192,57,43,0.2);
    display: flex; align-items: center; justify-content: center; color: #e05c4b;
}
.contacto-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,0.35); margin-bottom: 4px; }
.contacto-value { font-weight: 700; font-size: 0.95rem; color: #fff; }
.contacto-sub   { font-size: 0.75rem; color: rgba(255,255,255,0.35); margin-top: 2px; }
.redes-wrap { margin-top: 8px; }
.redes-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,0.35); margin-bottom: 12px; }
.redes-links { display: flex; gap: 10px; flex-wrap: wrap; }
.red-btn {
    padding: 7px 16px; border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.12); color: rgba(255,255,255,0.55);
    font-size: 0.78rem; font-weight: 700; text-decoration: none;
    transition: border-color 0.2s, color 0.2s;
}
.red-btn:hover { border-color: rgba(255,255,255,0.3); color: #fff; }
.contacto-form-wrap {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px; padding: 36px 32px;
    display: flex; flex-direction: column; gap: 16px;
}
.form-title { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
.form-field { display: flex; flex-direction: column; gap: 6px; }
.form-label { font-size: 0.75rem; font-weight: 700; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1px; }
.form-input {
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
    border-radius: 10px; color: #fff;
    font-family: 'Nunito', sans-serif; font-size: 0.9rem;
    padding: 11px 14px; outline: none;
    transition: border-color 0.2s;
}
.form-input::placeholder { color: rgba(255,255,255,0.25); }
.form-input:focus { border-color: rgba(192,57,43,0.5); }
.form-textarea { resize: vertical; min-height: 110px; }

/* ══ FOOTER ══ */
.footer { background: #060810; border-top: 1px solid rgba(255,255,255,0.06); }
.footer-inner {
    max-width: 1200px; margin: 0 auto;
    padding: 60px 36px 40px;
    display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 40px;
}
.footer-logo    { height: 50px; width: auto; margin-bottom: 14px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); }
.footer-tagline { font-size: 0.82rem; color: rgba(255,255,255,0.35); line-height: 1.7; }
.footer-col     { display: flex; flex-direction: column; gap: 10px; }
.footer-col-title { font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.45); margin-bottom: 6px; }
.footer-link { font-size: 0.82rem; color: rgba(255,255,255,0.35); text-decoration: none; transition: color 0.2s; }
a.footer-link:hover { color: rgba(255,255,255,0.8); }
.footer-bottom {
    max-width: 1200px; margin: 0 auto;
    padding: 20px 36px; border-top: 1px solid rgba(255,255,255,0.05);
    display: flex; flex-direction: column; gap: 4px;
    font-size: 0.75rem; color: rgba(255,255,255,0.18); line-height: 1.7;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 1024px) {
    .destinos-grid { grid-template-columns: repeat(3, 1fr); grid-template-rows: auto; }
    .destino-featured { grid-column: span 3; height: 280px; }
    .servicios-grid { grid-template-columns: 1fr 1fr; }
    .nosotros-layout { grid-template-columns: 1fr; }
    .footer-inner { grid-template-columns: 1fr 1fr; gap: 32px; }
}
@media (max-width: 768px) {
    .nav-links { display: none; }
    .hero-title { font-size: 2.4rem; }
    .search-box { flex-direction: column; }
    .destinos-grid { grid-template-columns: 1fr 1fr; }
    .destino-featured { grid-column: span 2; height: 220px; }
    .servicios-grid  { grid-template-columns: 1fr; }
    .flota-grid      { grid-template-columns: 1fr; }
    .sucursales-grid { grid-template-columns: 1fr 1fr; }
    .contacto-layout { grid-template-columns: 1fr; }
    .nosotros-layout { gap: 32px; }
    .section { padding: 64px 20px; }
}
@media (max-width: 500px) {
    .destinos-grid { grid-template-columns: 1fr; }
    .destino-featured { grid-column: span 1; }
    .sucursales-grid { grid-template-columns: 1fr; }
    .footer-inner { grid-template-columns: 1fr; }
    .stat-item { min-width: 50%; }
}
</style>