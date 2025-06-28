// Scripts para el menú móvil
const mobileMenu = document.getElementById('mobile-menu');
const navLinks = document.getElementById('nav-links');

mobileMenu.addEventListener('click', () => {
    const isExpanded = mobileMenu.getAttribute('aria-expanded') === 'true';
    mobileMenu.setAttribute('aria-expanded', !isExpanded);
    navLinks.classList.toggle('active'); // Cambia la clase para mostrar/ocultar el menú
});

// Permite abrir el menú con la tecla "Enter" o "Space"
mobileMenu.addEventListener('keydown', function(event) {
    if (event.key === 'Enter' || event.key === ' ') {
        this.click();
    }
});


// Configuración de partículas
particlesJS("particles-js", {
    "particles": {
        "number": {
            "value": 80,
            "density": {
                "enable": true,
                "value_area": 800
            }
        },
        "color": {
            "value": "#ffffff"
        },
        "shape": {
            "type": "circle",
            "stroke": {
                "width": 0,
                "color": "#000000"
            },
            "polygon": {
                "nb_sides": 5
            }
        },
        "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.1,
                "sync": false
            }
        },
        "size": {
            "value": 3,
            "random": true,
            "anim": {
                "enable": false,
                "speed": 40,
                "size_min": 0.1,
                "sync": false
            }
        },
        "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": true,
                "mode": "repulse"
            },
            "onclick": {
                "enable": true,
                "mode": "push"
            },
            "resize": true
        },
        "modes": {
            "grab": {
                "distance": 400,
                "line_linked": {
                    "opacity": 1
                }
            },
            "bubble": {
                "distance": 400,
                "size": 40,
                "duration": 2,
                "opacity": 8,
                "speed": 3
            },
            "repulse": {
                "distance": 200
            },
            "push": {
                "particles_nb": 4
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": true,
});



// Función para cambiar el idioma
function changeLanguage(lang) {
    const elements = document.querySelectorAll('[data-es], [data-en]');
     elements.forEach(el => {
        // Cambiar texto del placeholder si es input o textarea
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
            el.placeholder = el.getAttribute(`data-${lang}`);
        } 
        // Cambiar texto de los <option> y otros elementos
        else {
            el.textContent = el.getAttribute(`data-${lang}`);
        }
    });
    cargarServicios(lang); // Cargar servicios en el nuevo idioma
    cargarCasosEstudio(lang); // Cargar casos de estudio en el nuevo idioma
}

// Función para cargar servicios desde la base de datos
function cargarServicios(lang) {
    fetch(`db.php?tipo=servicios&lang=${lang}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta de la red');
            }
            return response.json();
        })
        .then(data => {
            const serviciosContainer = document.getElementById('servicios');
            serviciosContainer.innerHTML = ''; // Limpiar contenido anterior
            
            data.forEach(servicio => {
                const servicioDiv = document.createElement('div');
                servicioDiv.classList.add('service-card');
                
                servicioDiv.innerHTML = `
                    <img src="${servicio.imagen_url}" 
                         alt="${servicio.nombre}" 
                         class="service-icon" />
                    <h3>${servicio.nombre}</h3>
                    <div class="detalles">
                        <p>${servicio.descripcion}</p>
                    </div>
                `;
                
                // Mostrar/ocultar detalles al click
                servicioDiv.addEventListener('click', () => {
                    const detalles = servicioDiv.querySelector('.detalles');
                    detalles.classList.toggle('show');
                });

                serviciosContainer.appendChild(servicioDiv);
            });
        })
        .catch(error => console.error('Error al cargar los servicios:', error));
}

// Función para cargar casos de estudio desde la base de datos
function cargarCasosEstudio(lang) {
    fetch(`db.php?tipo=casos_estudio&lang=${lang}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta de la red');
            }
            return response.json();
        })
        .then(data => {
            const casosEstudioContainer = document.getElementById('casos_estudio');
            casosEstudioContainer.innerHTML = ''; // Limpiar contenido anterior

            data.casos_estudio.forEach(caso => {
                const casoDiv = document.createElement('div');
                casoDiv.classList.add('caso-estudio');
				// Estructura de cada tarjeta con imagen/ícono dinámico
                casoDiv.innerHTML = `
                    <img src="${caso.imagen_url}" alt="${caso.titulo}" />
                    <h3 >${caso.titulo}</h3>
                    <div class="detalles">
                        <p>${caso.descripcion}</p>
						<p><a href ="${caso.web}" target="_blank">${caso.web}</a></p>
                        <p><strong>${caso.ubicacion}</strong></p>
                    </div>
                `;
                // Mostrar/ocultar detalles con animación
                casoDiv.onclick = () => {
                    const detalles = casoDiv.querySelector('.detalles');
                    detalles.classList.toggle('show');
                };
                casosEstudioContainer.appendChild(casoDiv);
            });
        })
        .catch(error => console.error('Error al cargar los casos de estudio:', error));
}

// Cargar los servicios y casos de estudio al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    cargarServicios('es'); // Cargar servicios en español por defecto
    cargarCasosEstudio('es'); // Cargar casos de estudio en español por defecto
});




// Mostrar/Ocultar el botón de subir
window.addEventListener('scroll', () => {
    const btnSubir = document.getElementById('btn-subir');
    if (window.scrollY > 300) { // Muestra el botón después de 300px de desplazamiento
        btnSubir.style.display = 'block';
    } else {
        btnSubir.style.display = 'none';
    }
});


// Suavizar el scroll al hacer clic en el botón
document.getElementById('btn-subir').addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Desplazamiento suave
    });
});



	

