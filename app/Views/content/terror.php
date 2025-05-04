<!-- titulo de la categoria -->
<div class="top-container2">
    <div class="cat-title">
        <p>Horror</p>
        <img src="https://i.ibb.co/SXdfGP6k/terror.png" alt="Terror" class="cat-image">
    </div>
</div>

<!-- boton para filtrar los juegos -->
<div class="filter-container">
    <button id="filterButton" class="filter-button">
        <div class="filter-label">
            <svg class="filter-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z" />
            </svg>
            Filtrar
            <span id="selectedFilterText" class="selected-filter">Alfabético</span>
        </div>
        <svg class="arrow-icon" id="arrowIcon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 10l5 5 5-5z" />
        </svg>
    </button>
    <div class="dropdown-content" id="filterDropdown">
        <div class="dropdown-item" data-filter="alphabetic" data-direction="asc">
            <div class="label">
                <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm3.5 9.5H9.7l2.1-2.1-1.4-1.4-4.1 4.1 4.1 4.1 1.4-1.4-2.1-2.1h5.8v-2z" />
                </svg>
                <span>Alfabéticamente</span>
            </div>
            <div class="direction">
                <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                </svg>
                <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                </svg>
            </div>
        </div>
        <div class="divider"></div>
        <div class="dropdown-item" data-filter="release" data-direction="asc">
            <div class="label">
                <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                </svg>
                <span>Fecha de salida</span>
            </div>
            <div class="direction">
                <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                </svg>
                <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                </svg>
            </div>
        </div>
        <div class="divider"></div>
        <div class="dropdown-item" data-filter="popularity" data-direction="asc">
            <div class="label">
                <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z" />
                </svg>
                <span>Popularidad</span>
            </div>
            <div class="direction">
                <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                </svg>
                <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                </svg>
            </div>
        </div>
        <div class="divider"></div>
        <div class="dropdown-item" data-filter="rating" data-direction="asc">
            <div class="label">
                <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                <span>Calificación</span>
            </div>
            <div class="direction">
                <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                </svg>
                <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                </svg>
            </div>
        </div>
        <div class="divider"></div>
        <div class="dropdown-item" data-filter="price" data-direction="asc">
            <div class="label">
                <svg class="sort-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                </svg>
                <span>Precio</span>
            </div>
            <div class="direction">
                <svg class="asc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z" />
                </svg>
                <svg class="desc-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- contenedor de los videojuegos -->
<div class="games-container2">
    <div class="game-card">
        <div class="media-container">
            <img src="https://i.ibb.co/vNNPnMD/sh2.jpg" alt="Monster Hunter: Wilds" class="game-image">
            <div class="game-trailer">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/2HOClc6Svg4?si=iVN60aCs1A9I_tQc&amp;start=10&amp;controls=0&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

        </div>
        <div class="game-info">
            <div class="game-title">Silent Hill 2 Remake</div>
            <div class="game-price">$59.99</div>
        </div>
    </div>
    <div class="game-card">
        <div class="media-container">
            <img src="https://i.ibb.co/TMM0v6C6/re3.jpg" alt="Kingdom Come: Deliverance II" class="game-image">
            <div class="game-trailer">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/Ym3W7_-7-rU?si=eNrF-6mGpSl7NazW&amp;start=10&amp;controls=0&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        <div class="game-info">
            <div class="game-title">Resident Evil 3 Remake</div>
            <div class="game-price">$13.03</div>
        </div>
    </div>
    <div class="game-card">
        <div class="media-container">
            <img src="https://i.ibb.co/Nn9dXSyZ/outlast2.jpg" alt="Assassin's Creed Shadows" class="game-image">
            <div class="game-trailer">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/5SNo8h-KfAU?si=5MP8FqHCWwFUEvp6&amp;start=10&amp;controls=0&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        <div class="game-info">
            <div class="game-title">Outlast II</div>
            <div class="game-price">$54.65</div>
        </div>
    </div>
    <div class="game-card">
        <div class="media-container">
            <img src="https://i.ibb.co/cKpk4TgN/sonof.jpg" alt="Terraria" class="game-image">
            <div class="game-trailer">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/ktw2k3m7Qko?si=OwP-tPpkfcBfuiJF&amp;start=10&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        <div class="game-info">
            <div class="game-title">Sons of the Forest</div>
            <div class="game-price">$5.99</div>
        </div>
    </div>
    <div class="game-card">
        <div class="media-container">
            <img src="https://i.ibb.co/G4vV9sD7/prey.jpg" alt="REPO" class="game-image">
            <div class="game-trailer">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/ngZoq1RApqk?si=0x5BQ9ARSbLHW_lm&amp;start=10&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        <div class="game-info">
            <div class="game-title">Prey</div>
            <div class="game-price">$11.99</div>
        </div>
    </div>
    <div class="game-card">
        <div class="media-container">
            <img src="https://i.ibb.co/kgLbJncx/zomboid.jpg" alt="Schedule I" class="game-image">
            <div class="game-trailer">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/w6bE11FrSFM?si=nAQdVe-7BVMbSZwa&amp;start=10&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        <div class="game-info">
            <div class="game-title">Proyect Zomboid</div>
            <div class="game-price">$15.99</div>
        </div>
    </div>
    <div class="game-card">
        <div class="media-container">
            <div class="discount-badge">-23%</div>
            <img src="https://i.ibb.co/qYj6J2W0/hunt.jpg" alt="Path of Exile II" class="game-image">
            <div class="game-trailer">
                <iframe src="https://www.youtube.com/embed/8X2kIfS6fb8?si=vSIwS4U0fAF2dHqq&amp;start=10&amp;controls=0&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope;" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </div>
        <div class="game-info">
            <div class="game-title">Hunt Showdown 1896</div>
            <div class="game-price">$45.99</div>
        </div>
    </div>
    <div class="game-card">
        <div class="media-container">
            <img src="https://i.ibb.co/QvCGr8wm/soma.jpg" alt="Stardew Valley" class="game-image">
            <div class="game-trailer">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/WYRePGtK074?si=hT1LC6wRToLqTZme&amp;start=10&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        <div class="game-info">
            <div class="game-title">SOMA</div>
            <div class="game-price">$14.99</div>
        </div>
    </div>
    <div class="game-card">
        <div class="media-container">
            <img src="https://i.ibb.co/gbq2Jddt/amnesia.jpg" alt="EA FC 25" class="game-image">
            <div class="game-trailer">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/YKRhE5hcG_E?si=BWqqm8NXEstUvzPq&amp;start=10&amp;controls=0&amp;autoplay=0&amp;mute=1&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        <div class="game-info">
            <div class="game-title">Amnesia: The Dark Descent</div>
            <div class="game-price">$34.99</div>
        </div>
    </div>
</div>

<!-- botones de paginacion -->
<div class="pagination">
    <button class="pagination-button active">1</button>
    <button class="pagination-button">2</button>
    <span class="pagination-ellipsis">...</span>
    <button class="pagination-button">13</button>
    <button class="pagination-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </button>
</div>